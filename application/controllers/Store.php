<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_store');
        $this->load->model('m_sliders');
        $this->load->model('m_search');
        $this->load->model('m_settings');
    }

    // Halaman utama (dashboard pelanggan)
    public function index()
    {
        $data = array(
            'title' => 'Dashboard Customers',
            'product' => $this->m_store->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'category' => $this->m_store->get_all_data_category_with_icons(), // Mengambil kategori dengan icon
            'slider' => $this->m_sliders->get_all_data_bystatus(),
            'promo_products' => $this->m_store->get_promo_products(), // Produk promo
            'best_seller_products' => $this->m_store->get_best_seller_products(), // Produk paling laris
            'content' => 'customer/v_index'
        );
        $this->load->view('customer/layout/wrapper', $data, false);
    }

    // Melihat produk berdasarkan kategori
    public function kategori($id)
    {
        $category = $this->m_store->category($id);
        $data = array(
            'title' => 'Gadget ' . $category->kategori,
            'settings' => $this->m_settings->get_data(),
            'product' => $this->m_store->get_all_product_baseonbrand($id),
            'content' => 'customer/v_kategori'
        );
        $this->load->view('customer/layout/wrapper', $data, false);
    }

    // Melihat detail produk
    public function detail_product($id_product)
    {
        $data = array(
            'title' => 'Detail Product',
            'settings' => $this->m_settings->get_data(),
            'product' => $this->m_store->detail_product($id_product),
            'content' => 'customer/v_detail'
        );
        $this->load->view('customer/layout/wrapper', $data, false);
    }

    // Fungsi pencarian produk
    public function search()
    {
        $search_title = $this->input->post('search_title');
        
        // Panggil model untuk mendapatkan hasil pencarian
        $data['products'] = $this->m_search->searchProducts($search_title);
        $data['title'] = $search_title;
        $data['content'] = 'customer/v_res';
        $data['settings'] = $this->m_settings->get_data();

        // Load view dengan hasil pencarian
        $this->load->view('customer/layout/wrapper', $data);
    }
}

/* End of file Store.php */
