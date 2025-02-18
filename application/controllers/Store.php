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
            'product' => $this->m_store->get_all_data(), // Data produk
            'settings' => $this->m_settings->get_data(), // Pengaturan toko
            'category' => $this->m_store->get_all_data_category(), // Data kategori beserta ikon
            'brand' => $this->m_store->get_all_data_brands(),
            'slider' => $this->m_sliders->get_all_data_bystatus(), // Slider
            'content' => 'customer/v_index'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }

    public function all_products()
    {
        $this->load->library('pagination');

        $config['base_url'] = base_url('store/all_product');
        $config['total_rows'] = $this->m_store->count_all_products();
        $config['per_page'] = 18; // Menampilkan 20 produk per halaman
        $config['uri_segment'] = 3;

        // Konfigurasi tampilan pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data = array(
            'title' => 'Semua Produk',
            'product' => $this->m_store->get_all_products($config['per_page'], $page),
            'pagination' => $this->pagination->create_links(),
            'settings' => $this->m_settings->get_data(),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'content' => 'customer/v_all_product'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
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
            'comments' => $this->m_store->get_comments_by_product($id_product),
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

    public function add_comment()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('customer/login');
        }

        $data = array(
            'id_product' => $this->input->post('id_product'),
            'user_name' => $this->session->userdata('customer_name'), // Menggunakan nama customer
            'comment' => $this->input->post('comment'),
            'rating' => $this->input->post('rating'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->m_store->add_comment($data);
        $this->session->set_flashdata('pesan', 'Komentar berhasil ditambahkan!');
        redirect('store/detail_product/' . $data['id_product']);
    }
}


/* End of file Store.php */
