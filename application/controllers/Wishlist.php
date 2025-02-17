<?php
defined('BASEPATH') or exit('No direct script access allowed');

class wishlist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_wishlist');
        $this->load->model('M_products');
        $this->load->model('m_store');

        // Pastikan pelanggan sudah login
        if (!$this->session->userdata('id_customer')) {
            redirect('customer/login');
        }
    }

    public function wishlist()
    {
        $id_customer = $this->session->userdata('id_customer');
        $data = array(
            'title' => 'Wishlist Saya',
            'wishlist' => $this->M_wishlist->get_wishlist($id_customer),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'settings' => $this->m_store->get_all_settings(),
            'content' => 'customer/wishlist'
        );

        $this->load->view('customer/layout/wrapper', $data);
    }

    public function add()
    {
        $id_customer = $this->session->userdata('id_customer');
        $id_product = $this->input->post('id_product');

        // Cek apakah produk sudah ada di wishlist
        if (!$this->M_wishlist->check_wishlist($id_customer, $id_product)) {
            $data = [
                'id_customer' => $id_customer,
                'id_product' => $id_product
            ];
            $this->M_wishlist->add_to_wishlist($data);
            $this->session->set_flashdata('success', 'Produk ditambahkan ke wishlist.');
        } else {
            $this->session->set_flashdata('error', 'Produk sudah ada di wishlist Anda.');
        }

        redirect('wishlist');
    }

    public function remove($id_wishlist)
    {
        $this->M_wishlist->remove_from_wishlist($id_wishlist);
        $this->session->set_flashdata('success', 'Produk dihapus dari wishlist.');
        redirect('wishlist');
    }
}
