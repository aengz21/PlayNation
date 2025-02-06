<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_store extends CI_Model
{
    // Mendapatkan semua produk
    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.id_category', 'left');
        $this->db->order_by('id_product', 'desc');
        return $this->db->get()->result();
    }
    public function get_all_data_category()
    {
        $this->db->select('*');
        $this->db->from('tbl_categories');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_data_brands()
    {
        $this->db->select('*');
        $this->db->from('tbl_brands');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_all_promo_products() {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('discount >', 0); // Hanya produk dengan discount lebih dari 0
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan semua kategori dengan ikon
    public function get_all_data_category_with_icons()
    {
        $this->db->select('id, kategori, icon'); // Menambahkan field 'icon'
        $this->db->from('tbl_categories');
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result();
    }

    // Mendapatkan produk promo (yang memiliki diskon)
    public function get_promo_products()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('discount >', 0); // Filter produk dengan diskon
        $this->db->order_by('id_product', 'desc');
        return $this->db->get()->result();
    }

    // Mendapatkan produk best seller
    public function get_best_seller_products()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->order_by('sold', 'desc'); // Urutkan berdasarkan jumlah terjual (sold)
        $this->db->limit(5); // Batasi ke 5 produk paling laris
        return $this->db->get()->result();
    }

    // Mendapatkan detail kategori
    public function category($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_categories');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function brands($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_brands');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    // Mendapatkan produk berdasarkan kategori
    public function get_all_product_baseoncategory($id_category)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id_category', $id_category);
        return $this->db->get()->result();
    }
    public function get_all_product_baseonbrand($id_brand)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id_brand', $id_brand);
        return $this->db->get()->result();
    }

    // Mendapatkan detail produk
    public function detail_product($id_product)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id_product', $id_product);
        return $this->db->get()->row();
    }



    // Mengurangi stok produk
    public function kurangi_stok($id_product, $qty)
    {
        // Mengurangi stok produk berdasarkan qty yang diinginkan
        $this->db->set('stock', 'stock - ' . (int)$qty, FALSE);
        $this->db->where('id_product', $id_product);
        return $this->db->update('tbl_products');
    }

    public function add_comment($data)
    {
        $this->db->insert('tbl_comments', $data);
    }

    public function get_comments_by_product($id_product)
    {
        $this->db->select('*');
        $this->db->from('tbl_comments');
        $this->db->where('id_product', $id_product);
        $this->db->order_by('created_at', 'desc'); // Urutkan berdasarkan waktu pembuatan
        return $this->db->get()->result();
    }
}

/* End of file M_store.php */
    