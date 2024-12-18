<?php



defined('BASEPATH') or exit('No direct script access allowed');

class brands extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->model('m_brands');
        $this->load->model('m_settings');
        
    }

    // List all your items
    public function index()
    {
        $data = array(
            'title' => 'Brands',
            'categories' => $this->m_brands->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/v_brands'
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    // Add a new item
    public function add()
    {
        $data = array(
            'brands' => $this->input->post('brands'),
        );
        if ($this->m_brands->is_category_exist($data['brands'])) {
            $this->session->set_flashdata('error', 'Data brands Sudah Ada !');
            redirect('Brands');
        } else {
            $this->m_brands->add($data);
            $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan !');
            redirect('Brands');
        }
    }

    //Update one item
    public function update($id = NULL)
    {
        $data = array(
            'id' => $id,
            'brands' => $this->input->post('brands'),
        );

        $this->m_brands->update($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Update !');
        redirect('Brands');
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $data = array(
            'id' => $id
        );
        $this->m_brands->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Hapus !');
        redirect('Brands');
    }
}

/* End of file Category.php */
