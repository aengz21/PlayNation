<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kelas Keranjang Belanja
 *
 * Kelas ini mengelola semua fungsi terkait keranjang belanja, termasuk menambah, mengupdate,
 * dan menghapus item dari keranjang, serta menyimpan data keranjang ke sesi.
 */
class CI_Cart {

	/**
	 * Aturan validasi untuk ID produk
	 *
	 * @var string
	 */
	public $product_id_rules = '\.a-z0-9-';

	/**
	 * Aturan validasi untuk nama produk
	 *
	 * @var string
	 */
	public $product_name_rules = '\w \-\.\:';

	/**
	 * Menentukan apakah hanya nama produk yang aman yang diizinkan
	 *
	 * @var bool
	 */
	public $product_name_safe = TRUE;

	// --------------------------------------------------------------------------

	/**
	 * Referensi ke instance CodeIgniter
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Konten keranjang belanja
	 *
	 * @var array
	 */
	protected $_cart_contents = array();

	/**
	 * Konstruktor Kelas Belanja
	 *
	 * Memuat kelas Sesi untuk menyimpan konten keranjang belanja.
	 *
	 * @param	array $params Parameter konfigurasi opsional
	 * @return	void
	 */
	public function __construct($params = array())
	{
		// Mengambil instance CodeIgniter untuk digunakan di kelas ini
		$this->CI =& get_instance();

		// Memuat kelas Sesi
		$this->CI->load->driver('session', $params);

		// Mengambil konten keranjang dari sesi
		$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		if ($this->_cart_contents === NULL)
		{
			// Jika tidak ada keranjang, set nilai awal
			$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0);
		}

		log_message('info', 'Cart Class Initialized'); // Log inisialisasi kelas keranjang
	}

	// --------------------------------------------------------------------

	/**
	 * Menyisipkan item ke dalam keranjang dan menyimpannya ke tabel sesi
	 *
	 * @param	array $items Item yang akan ditambahkan
	 * @return	bool TRUE jika berhasil, FALSE jika gagal
	 */
	public function insert($items = array())
	{
		// Memeriksa apakah data keranjang yang valid telah diberikan
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.'); // Log kesalahan
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Menyimpan status penyimpanan keranjang
		$save_cart = FALSE;
		if (isset($items['id']))
		{
			// Menyisipkan item tunggal
			if (($rowid = $this->_insert($items)))
			{
				$this->_decrease_stock($items['id'], $items['qty']); // Mengurangi stok
				$save_cart = TRUE; // Menandai bahwa penyimpanan berhasil
			}
		}
		else
		{
			// Menyisipkan beberapa item
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['id']))
				{
					if ($this->_insert($val))
					{
						$this->_decrease_stock($val['id'], $val['qty']); // Mengurangi stok
						$save_cart = TRUE; // Menandai bahwa penyimpanan berhasil
					}
				}
			}
		}

		// Menyimpan data keranjang jika penyisipan berhasil
		if ($save_cart === TRUE)
		{
			$this->_save_cart(); // Menyimpan keranjang ke sesi
			return isset($rowid) ? $rowid : TRUE; // Mengembalikan ID baris atau TRUE
		}

		return FALSE; // Mengembalikan FALSE jika gagal
	}

	// --------------------------------------------------------------------

	/**
	 * Menyisipkan item ke dalam keranjang
	 *
	 * @param	array $items Item yang akan disisipkan
	 * @return	bool TRUE jika berhasil, FALSE jika gagal
	 */
	protected function _insert($items = array())
	{
		// Memeriksa apakah data keranjang yang valid telah diberikan
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.'); // Log kesalahan
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Memeriksa apakah item memiliki ID, kuantitas, harga, dan nama
		if ( ! isset($items['id'], $items['qty'], $items['price'], $items['name']))
		{
			log_message('error', 'The cart array must contain a product ID, quantity, price, and name.'); // Log kesalahan
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Menyiapkan kuantitas
		$items['qty'] = (float) $items['qty'];

		// Mengembalikan FALSE jika kuantitas nol
		if ($items['qty'] == 0)
		{
			return FALSE;
		}

		// Memvalidasi ID produk
		if ( ! preg_match('/^['.$this->product_id_rules.']+$/i', $items['id']))
		{
			log_message('error', 'Invalid product ID.'); // Log kesalahan
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Memvalidasi nama produk
		if ($this->product_name_safe && ! preg_match('/^['.$this->product_name_rules.']+$/i'.(UTF8_ENABLED ? 'u' : ''), $items['name']))
		{
			log_message('error', 'An invalid name was submitted as the product name.'); // Log kesalahan
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Menyiapkan harga
		$items['price'] = (float) $items['price'];

		// Membuat ID baris unik untuk item
		if (isset($items['options']) && count($items['options']) > 0)
		{
			$rowid = md5($items['id'].serialize($items['options'])); // Menggunakan opsi untuk ID unik
		}
		else
		{
			$rowid = md5($items['id']); // Menggunakan ID produk untuk ID unik
		}

		// Mengambil kuantitas lama jika item sudah ada
		$old_quantity = isset($this->_cart_contents[$rowid]['qty']) ? (int) $this->_cart_contents[$rowid]['qty'] : 0;

		// Menambahkan item ke keranjang
		$items['rowid'] = $rowid; // Menyimpan ID baris
		$items['qty'] += $old_quantity; // Menambahkan kuantitas lama
		$this->_cart_contents[$rowid] = $items; // Menyimpan item ke keranjang

		return $rowid; // Mengembalikan ID baris
	}

	// --------------------------------------------------------------------

	/**
	 * Memperbarui keranjang
	 *
	 * Memungkinkan perubahan jumlah item yang ada di keranjang.
	 *
	 * @param	array $items Item yang akan diperbarui
	 * @return	bool TRUE jika berhasil, FALSE jika gagal
	 */
	public function update($items = array())
	{
		// Memeriksa apakah data keranjang yang valid telah diberikan
		if ( ! is_array($items) OR count($items) === 0)
		{
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Menyimpan status penyimpanan keranjang
		$save_cart = FALSE;
		if (isset($items['rowid']))
		{
			if ($this->_update($items) === TRUE)
			{
				$save_cart = TRUE; // Menandai bahwa penyimpanan berhasil
			}
		}
		else
		{
			// Memperbarui beberapa item
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['rowid']))
				{
					if ($this->_update($val) === TRUE)
					{
						$save_cart = TRUE; // Menandai bahwa penyimpanan berhasil
					}
				}
			}
		}

		// Menyimpan data keranjang jika pembaruan berhasil
		if ($save_cart === TRUE)
		{
			$this->_save_cart(); // Menyimpan keranjang ke sesi
			return TRUE; // Mengembalikan TRUE
		}

		return FALSE; // Mengembalikan FALSE jika gagal
	}

	// --------------------------------------------------------------------

	/**
	 * Memperbarui item dalam keranjang
	 *
	 * @param	array $items Item yang akan diperbarui
	 * @return	bool TRUE jika berhasil, FALSE jika gagal
	 */
	protected function _update($items = array())
	{
		// Memeriksa apakah ID baris valid
		if ( ! isset($items['rowid'], $this->_cart_contents[$items['rowid']]))
		{
			return FALSE; // Mengembalikan FALSE jika gagal
		}

		// Menyiapkan kuantitas
		if (isset($items['qty']))
		{
			$items['qty'] = (float) $items['qty'];
			// Menghapus item jika kuantitas nol
			if ($items['qty'] == 0)
			{
				unset($this->_cart_contents[$items['rowid']]); // Menghapus item dari keranjang
				return TRUE; // Mengembalikan TRUE
			}
		}

		// Mencari kunci yang dapat diperbarui
		$keys = array_intersect(array_keys($this->_cart_contents[$items['rowid']]), array_keys($items));
		// Memastikan harga valid
		if (isset($items['price']))
		{
			$items['price'] = (float) $items['price'];
		}

		// Mengupdate kunci yang tidak boleh diubah
		foreach (array_diff($keys, array('id', 'name')) as $key)
		{
			$this->_cart_contents[$items['rowid']][$key] = $items[$key]; // Memperbarui item
		}

		return TRUE; // Mengembalikan TRUE
	}

	// --------------------------------------------------------------------

	/**
	 * Menyimpan keranjang ke sesi
	 *
	 * @return	bool TRUE jika berhasil
	 */
	protected function _save_cart()
	{
		// Menghitung total harga dan jumlah item
		$this->_cart_contents['total_items'] = $this->_cart_contents['cart_total'] = 0;
		foreach ($this->_cart_contents as $key => $val)
		{
			// Memastikan array memiliki indeks yang benar
			if ( ! is_array($val) OR ! isset($val['price'], $val['qty']))
			{
				continue; // Lewati jika tidak valid
			}

			// Menghitung total harga dan jumlah item
			$this->_cart_contents['cart_total'] += ($val['price'] * $val['qty']);
			$this->_cart_contents['total_items'] += $val['qty'];
			$this->_cart_contents[$key]['subtotal'] = ($this->_cart_contents[$key]['price'] * $this->_cart_contents[$key]['qty']);
		}

		// Menghapus keranjang jika kosong
		if (count($this->_cart_contents) <= 2)
		{
			$this->CI->session->unset_userdata('cart_contents'); // Menghapus data sesi
			return FALSE; // Mengembalikan FALSE
		}

		// Menyimpan keranjang ke sesi
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));
		return TRUE; // Mengembalikan TRUE
	}

	// --------------------------------------------------------------------

	/**
	 * Menghitung total harga keranjang
	 *
	 * @return	int Total harga
	 */
	public function total()
	{
		return $this->_cart_contents['cart_total']; // Mengembalikan total harga
	}

	// --------------------------------------------------------------------

	/**
	 * Menghapus item dari keranjang
	 *
	 * @param	string $rowid ID baris item yang akan dihapus
	 * @return	bool TRUE jika berhasil
	 */
	public function remove($rowid)
	{
		$item = $this->_cart_contents[$rowid]; // Ambil item sebelum dihapus
		unset($this->_cart_contents[$rowid]); // Menghapus item dari keranjang
		$this->_increase_stock($item['id'], $item['qty']); // Mengembalikan stok
		$this->_save_cart(); // Menyimpan perubahan ke sesi
		return TRUE; // Mengembalikan TRUE
	}

	// --------------------------------------------------------------------

	/**
	 * Menghitung total item dalam keranjang
	 *
	 * @return	int Jumlah total item
	 */
	public function total_items()
	{
		return $this->_cart_contents['total_items']; // Mengembalikan jumlah total item
	}

	// --------------------------------------------------------------------

	/**
	 * Mengembalikan semua konten keranjang
	 *
	 * @param	bool $newest_first Apakah ingin menampilkan yang terbaru terlebih dahulu
	 * @return	array Konten keranjang
	 */
	public function contents($newest_first = FALSE)
	{
		// Mengatur urutan konten keranjang
		$cart = ($newest_first) ? array_reverse($this->_cart_contents) : $this->_cart_contents;

		// Menghapus total item dan total harga dari tampilan
		unset($cart['total_items']);
		unset($cart['cart_total']);

		return $cart; // Mengembalikan konten keranjang
	}

	// --------------------------------------------------------------------

	/**
	 * Mengambil item dari keranjang
	 *
	 * @param	string $row_id ID baris item
	 * @return	array Detail item
	 */
	public function get_item($row_id)
	{
		return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->_cart_contents[$row_id]))
			? FALSE // Mengembalikan FALSE jika tidak valid
			: $this->_cart_contents[$row_id]; // Mengembalikan detail item
	}

	// --------------------------------------------------------------------

	/**
	 * Memeriksa apakah item memiliki opsi
	 *
	 * @param	string $row_id ID baris item
	 * @return	bool TRUE jika ada opsi
	 */
	public function has_options($row_id = '')
	{
		return (isset($this->_cart_contents[$row_id]['options']) && count($this->_cart_contents[$row_id]['options']) !== 0); // Mengembalikan TRUE jika ada opsi
	}

	// --------------------------------------------------------------------

	/**
	 * Mengambil opsi produk
	 *
	 * @param	string $row_id ID baris item
	 * @return	array Opsi produk
	 */
	public function product_options($row_id = '')
	{
		return isset($this->_cart_contents[$row_id]['options']) ? $this->_cart_contents[$row_id]['options'] : array(); // Mengembalikan opsi produk
	}

	// --------------------------------------------------------------------

	/**
	 * Memformat angka
	 *
	 * @param	float $n Angka yang akan diformat
	 * @return	string Angka yang diformat
	 */
	public function format_number($n = '')
	{
		return ($n === '') ? '' : number_format((float) $n, 2, '.', ','); // Mengembalikan angka yang diformat
	}

	// --------------------------------------------------------------------

	/**
	 * Menghancurkan keranjang
	 *
	 * Mengosongkan keranjang dan menghapus sesi
	 *
	 * @return	void
	 */
	public function destroy()
	{
		$this->_cart_contents = array('cart_total' => 0, 'total_items' => 0); // Mengosongkan keranjang
		$this->CI->session->unset_userdata('cart_contents'); // Menghapus data sesi
	}

	/**
	 * Mengurangi stok barang
	 *
	 * @param string $product_id ID produk
	 * @param int $quantity Jumlah yang akan dikurangi
	 * @return void
	 */
	protected function _decrease_stock($product_id, $quantity)
	{
		// Logika untuk mengurangi stok barang
		// Misalnya, panggil model untuk mengupdate stok di database
		// $this->product_model->decrease_stock($product_id, $quantity);
	}

	/**
	 * Mengembalikan stok barang
	 *
	 * @param string $product_id ID produk
	 * @param int $quantity Jumlah yang akan dikembalikan
	 * @return void
	 */
	protected function _increase_stock($product_id, $quantity)
	{
		// Logika untuk mengembalikan stok barang
		// Misalnya, panggil model untuk mengupdate stok di database
		// $this->product_model->increase_stock($product_id, $quantity);
	}

}
