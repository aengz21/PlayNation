<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekai_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('m_store');
        $this->load->model('m_sliders');
        $this->load->model('m_search');
        $this->load->model('m_settings');
        $this->setting = $this->m_settings->get_data();
        $this->toko = $this->m_store->get_all_data_category();
        $this->slider = $this->m_sliders->get_all_data_bystatus();
    }

    // Shortcut to load header and footer templates with the main content
    public function C_template($view, $data = array()) {
        $data = array(
        'settings' => $this->setting, // Pengaturan toko
        'category' => $this->toko,
        'slider' => $this->slider,
        );
        $this->load->view('customer/layout/header', $data); // Load header
        $this->load->view('customer/layout/head', $data); // Load head
        $this->load->view($view, $data);                    // Load the main view
        $this->load->view('customer/layout/footer', $data); // Load footer
    }

    // Function to load multiple models easily
    public function load_models($models = array()) {
        foreach ($models as $model) {
            $this->load->model($model);
        }
    }

    // Redirect with a flash notification
    public function redirect_with_flash($url, $message, $type = 'success') {
        // Set flash data using CodeIgniter session
        $this->session->set_flashdata('message', "<div class='alert alert-$type'>$message</div>");
        redirect($url);
    }
}
