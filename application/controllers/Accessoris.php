<?php



defined('BASEPATH') or exit('No direct script access allowed');

class accessoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->model('m_accessoris');
        $this->load->model('m_settings');
        
    }

    // List all your items
    public function index()
    {
        $data = array(
            'title' => 'Accessories',
            'accessoris' => $this->m_accessoris->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/v_accessoris'
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    // Add a new item
    public function add()
    {
        $data = array(
            'accessoris' => $this->input->post('accessoris'),
        );
        if ($this->m_brands->is_category_exist($data['accessoris'])) {
            $this->session->set_flashdata('error', 'Data accessoris Sudah Ada !');
            redirect('accessoris');
        } else {
            $this->m_accessoris->add($data);
            $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan !');
            redirect('accessoris');
        }
    }

    //Update one item
    public function update($id = NULL)
    {
        $data = array(
            'id' => $id,
            'accessoris' => $this->input->post('accessoris'),
        );

        $this->m_accessoris->update($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Update !');
        redirect('accessoris');
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $data = array(
            'id' => $id
        );
        $this->m_accessoris->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Hapus !');
        redirect('acessm_accessoris');
    }
}

/* End of file Category.php */
