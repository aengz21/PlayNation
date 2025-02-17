<?php
class About extends CI_Controller
{
    public function __construct()
    {
        parent ::__construct();
        $this->load->model('m_settings');
        $this->load->model('m_store');
    }
    public function Faq ()
    {
        $data = array(
            'title' => 'Faq',
           'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_faq'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }

    public function how_to_buy()
    {
        $data = array(
            'title' => 'How to But',
           'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_how_to_buy'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }
    }
?>