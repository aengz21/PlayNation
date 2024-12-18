<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-oSm60e409Hpy2faZ-s1XPXtd', 'production' => false);
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: PUT, GET, POST");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('checkout_snap');
	}

	public function token()
	{
		// Hitung total harga dari semua item di keranjang
		$total_price = 0;
		$item_details = array();

		foreach ($this->cart->contents() as $items) {
			$item_details[] = array(
				'id' => $items['id'],
				'price' => $items['price'],
				'quantity' => $items['qty'],
				'name' => $items['name']
			);
			$total_price += $items['price'] * $items['qty'];
		}

		// Definisikan alamat penagihan dan pengiriman
		$billing_address = array(
			'first_name'    => "Andri",
			'address'       => "Jalan Mawar No. 123",
			'city'          => "Jakarta",
			'postal_code'   => "12345",
			'phone'         => "081122334455",
			'country_code'  => 'IDN'
		);

		$shipping_address = array(
			'first_name'    => "$_POST",
			'last_name'     => "Litani",
			'address'       => "Jalan Melati No. 456",
			'city'          => "Bandung",
			'postal_code'   => "67890",
			'phone'         => "081122334455",
			'country_code'  => 'IDN'
		);

		// Required
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => $total_price, // Total harga dari semua item
		);

		// Optional
		$customer_details = array(
			'first_name'    => "Andri",
			'last_name'     => "Litani",
			'email'         => "andri@litani.com",
			'phone'         => "081122334455",
			'billing_address'  => $billing_address,
			'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'minute',
			'duration'  => 2
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish()
	{
		$result_data = $this->input->post('result_data');
		
		if ($result_data) {
			$result = json_decode($result_data);
			
			if ($result) {
				echo 'RESULT <br><pre>';
				echo 'Order ID: ' . $result->order_id . '<br>';
				echo 'Nama Pembeli: ' . $result->customer_details->first_name . ' ' . $result->customer_details->last_name . '<br>';
				echo 'Items: <br>';
				foreach ($result->item_details as $item) {
					echo '- ' . $item->name . ' (Qty: ' . $item->quantity . ')<br>';
				}
				echo '</pre>';
			} else {
				echo 'Error: JSON decode failed.';
			}
		} else {
			echo 'Error: No result data received.';
		}
	}
}
