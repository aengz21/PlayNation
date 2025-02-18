<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Shopping extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_orders');
        $this->load->model('m_store');
        $this->load->model('m_settings');
    }


    
    
        public function index()
        {
            $this->customer_login->proteksi_halaman();
            $this->form_validation->set_rules(
                'courier',
                'Kurir Pengiriman',
                'required',
                array('required' => '%s Harus Di Isi !')
            );
            $this->form_validation->set_rules(
                'cost',
                'Layanan Expedisi',
                'required',
                array('required' => '%s Harus Di Isi !')
            );
            $this->form_validation->set_rules(
                'provinsi',
                'Provinsi',
                'required',
                array('required' => '%s Harus Di Isi !')
            );
            $this->form_validation->set_rules(
                'kota',
                'Kota',
                'required',
                array('required' => '%s Harus Di Isi !')
            );
    
            if ($this->form_validation->run() == false) {
                $data = array(
                    'title' => 'Keranjang',
                    'settings' => $this->m_settings->get_data(),
                    'content' => 'customer/v_shopping',
                    'category' => $this->m_store->get_all_data_category(),
                    'brand' => $this->m_store->get_all_data_brands(),
                    'customer_name' => $this->input->post('nama_lengkap'),
                    'customer_phone' => $this->input->post('phone'),
                    'customer_address' => $this->input->post('alamat'),
                    'cart_items' => $this->cart->contents(),
                );
    
                $this->load->view('customer/layout/wrapper', $data, false);
            } else {
                $data = array(
                    'id_customer' => $this->input->post('id_customer'),
                    'nama_penerima' => $this->input->post('nama_lengkap'),
                    'no_order' => $this->input->post('no_order'),
                    'no_telp' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'provinsi' => $this->input->post('provinsi'),
                    'kota' => $this->input->post('kota'),
                    'alamat' => $this->input->post('alamat'),
                    'courier' => $this->input->post('courier'),
                    'layanan_courier' => $this->input->post('cost'),
                    'weight' => $this->input->post('weight'),
                    'ongkir' => $this->input->post('ongkir'),
                    'total_bayar' => $this->input->post('total_bayar'),
                    'status' => 0,
                );
                
                $this->m_orders->simpan_transaksi($data);
    
                // Simpan ke details transaksi dan kurangi stok produk
                foreach ($this->cart->contents() as $items) {
                    $datadetails = array(
                        'no_order' => $this->input->post('no_order'),
                        'id_product' => $items['id'],
                        'qty' => $items['qty'],
                    );
    
                    $this->m_orders->simpan_detail_transaksi($datadetails);
    
                    // Kurangi stok produk sesuai qty
                    $stok_updated = $this->m_store->kurangi_stok($items['id'], $items['qty']);
                    if ($stok_updated <= 0) {
                        log_message('error', 'Stok gagal diperbarui untuk produk ID: ' . $items['id']);
                    }
                }
    
                $this->cart->destroy();
                $this->session->set_flashdata('pesan', 'Pesanan Berhasil Di Simpan !');
                redirect('customer/my_orders');
            }
        }
    
    

    public function add()
    {
        $this->customer_login->proteksi_halaman();
        $redirect_page = $this->input->post('redirect_page');
        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => $this->input->post('qty'),
            'name'    => $this->input->post('name'),
            'price'   => $this->input->post('price'),
            'discount' => $this->input->post('discount'),
            'weight' => $this->input->post('weight'),
            'img' => $this->input->post('img'),
        );

        $this->cart->insert($data);
        redirect($redirect_page, 'refresh');
    }

    public function delete($rowid)
    {
        $this->cart->remove($rowid);
        redirect('shopping');
    }
}
