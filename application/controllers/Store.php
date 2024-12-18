<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends Sekai_Controller
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
            'product' => $this->m_store->get_all_data(), // Data produk
            'settings' => $this->m_settings->get_data(), // Pengaturan toko
            'category' => $this->m_store->get_all_data_category(), // Data kategori beserta ikon
            'brand' => $this->m_store->get_all_data_brands(),
            'slider' => $this->m_sliders->get_all_data_bystatus(), // Slider
            'content' => 'customer/v_index'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }

    public function all_product()
    {
        
    }
    public function promo() {
        $data['title'] = 'Produk Promo';
        $data['settings'] = $this->m_settings->get_data();
        $data['product'] = $this->m_store->get_all_promo_products();
        $data['content'] = 'customer/v_promo';
        $data['category'] = $this->m_store->get_all_data_category(); // Data kategori beserta ikon
        $data['brand'] = $this->m_store->get_all_data_brands();


        $this->load->view('customer/layout/wrapper', $data, false); // Load template utama
    }

    public function brands($id)
    {
        $category = $this->m_store->brands($id);
        $data = array(
            'title' => 'kategori ' . $category->brands,
            'settings' => $this->m_settings->get_data(),
            'product' => $this->m_store->get_all_product_baseonbrand($id),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'content' => 'customer/v_brand',
        );
        $this->load->view('customer/layout/wrapper', $data, false);
    }
    // Melihat produk berdasarkan kategori
    public function kategori($id)
    {
        $category = $this->m_store->category($id);
        $data = array(
            'title' => 'kategori ' . $category->kategori, // Menambahkan title
            'settings' => $this->m_settings->get_data(),
            'product' => $this->m_store->get_all_product_baseoncategory($id),
           'category' => $this->m_store->get_all_data_category(), // Menambahkan product
           'brand' => $this->m_store->get_all_data_brands(),
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
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
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
        $data['brand'] =$this->m_store->get_all_data_brands();
        $data['category'] = $this->m_store->get_all_data_category();

        // Load view dengan hasil pencarian
        $this->load->view('customer/layout/wrapper', $data);
    }
}

/* End of file Store.php */
