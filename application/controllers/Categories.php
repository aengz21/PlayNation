<?php



defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->model('m_categories');
        $this->load->model('m_settings');
        
    }

    // List all your items
    public function index()
    {
        $data = array(
            'title' => 'Kategori',
            'categories' => $this->m_categories->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/v_categories'
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    // Add a new item
    public function add()
    {
        $data = array(
            'kategori' => $this->input->post('kategori')
        );
        if ($this->m_categories->is_category_exist($data['kategori'])) {
            $this->session->set_flashdata('error', 'Data Kategori Sudah Ada !');
            redirect('categories');
        } else {
            $this->m_categories->add($data);
            $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan !');
            redirect('categories');
        }
    }

    //Update one item
    public function update($id = NULL)
    {
        $data = array(
            'id' => $id,
            'kategori' => $this->input->post('kategori'),
            'icon' => $this->input->post('icon'),
        );

        $this->m_categories->update($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Update !');
        redirect('categories');
    }

    //Delete one item
    public function delete($id = NULL)
    {
        $data = array(
            'id' => $id
        );
        $this->m_categories->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Hapus !');
        redirect('categories');
    }
}

/* End of file Category.php */
