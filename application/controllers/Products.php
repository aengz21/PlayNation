<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_products');
        $this->load->model('m_categories');
        $this->load->model('m_settings');
        $this->load->model('m_brands');
    }

    public function index()
    {
        $data = array(
            'title' => 'Produk',
            'products' => $this->m_products->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/products/v_products',
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    public function add()
    {
        $this->form_validation->set_rules(
            'title',
            'Nama Produk',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        $this->form_validation->set_rules(
            'kategori',
            'Nama Kategori',
            'required',
            array('required' => '%s Harus Di Isi')
        );

        $this->form_validation->set_rules(
            'price',
            'Harga Produk',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        $this->form_validation->set_rules(
            'weight',
            'Berat',
            'required',
            array('required' => '%s Harus Di Isi !')
        );
        $this->form_validation->set_rules(
            'stock',
            'Stok',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        $this->form_validation->set_rules(
            'discount',
            'Diskon Produk',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        $this->form_validation->set_rules(
            'description',
            'Deskripsi Produk',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        if ($this->form_validation->run() == True) {
            $config['upload_path'] = './assets/products_img/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']     = '2000';
            $this->upload->initialize($config);
            $field_name = "img";
            if (!$this->upload->do_upload($field_name)) {
                $data = array(
                    'title' => 'Add Product',
                    'category' => $this->m_categories->get_all_data(),
                    'brand' => $this->m_brands->get_all_data(),
                    'settings' => $this->m_settings->get_data(),
                    'error_upload' => $this->upload->display_errors(),
                    'content' => 'admin/products/v_add',
                );
                $this->load->view('admin/layout/wrapper', $data, false);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/products_img/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);

                $data = array(
                    'title' => $this->input->post('title'),
                    'id_category' => $this->input->post('kategori'),
                    'id_brand' => $this->input->post('brand'),
                    'price' => $this->input->post('price'),
                    'weight' => $this->input->post('weight'),
                    'discount' => $this->input->post('discount'),
                    'description' => $this->input->post('description'),
                    'stock' => $this->input->post('stock'),
                    'img' => $upload_data['uploads']['file_name'],
                );
                $this->m_products->add($data);
                $this->session->set_flashdata('pesan', 'Data Berhasil DI tambahkan !');
                redirect('products');
            }
        }
        $data = array(
            'title' => 'Add Product',
            'category' => $this->m_categories->get_all_data(),
            'brand' => $this->m_brands->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/products/v_add',
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

   public function update($id_product = NULL)
{
    $this->form_validation->set_rules(
        'title',
        'Nama Produk',
        'required',
        array('required' => '%s Harus Di Isi !')
    );

    // Validasi lainnya seperti yang ada di kode sebelumnya

    if ($this->form_validation->run() == True) {
        $config['upload_path'] = './assets/products_img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']     = '2000';
        $this->upload->initialize($config);
        $field_name = "img";

        // Ambil data lama dari database
        $product = $this->m_products->get_data($id_product);

        // Jika upload gambar baru dilakukan
        if ($this->upload->do_upload($field_name)) {
            // Jika ada gambar lama, hapus
            if ($product->img != "") {
                unlink('./assets/products_img/' . $product->img);
            }
            $upload_data = array('uploads' => $this->upload->data());
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/products_img/' . $upload_data['uploads']['file_name'];
            $this->load->library('image_lib', $config);
            $img = $upload_data['uploads']['file_name'];
        } else {
            // Jika gambar tidak diupload, tetap gunakan gambar yang lama
            $img = $product->img;
        }

        // Periksa apakah input kosong, jika ya gunakan data lama
        $data = array(
            'id_product' => $id_product,
            'title' => $this->input->post('title') ? $this->input->post('title') : $product->title,
            'id_category' => $this->input->post('kategori') ? $this->input->post('kategori') : $product->id_category,
            'id_brand' => $this->input->post('brand') ? $this->input->post('brand') : $product->id_brand,
            'price' => $this->input->post('price') ? $this->input->post('price') : $product->price,
            'weight' => $this->input->post('weight') ? $this->input->post('weight') : $product->weight,
            'discount' => $this->input->post('discount') ? $this->input->post('discount') : $product->discount,
            'stock' => $this->input->post('stok') ? $this->input->post('stok') : $product->stock,
            'description' => $this->input->post('description') ? $this->input->post('description') : $product->description,
            'img' => $img,
        );

        $this->m_products->update($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Update !');
        redirect('products');
    }

    $data = array(
        'title' => 'Update Product',
        'category' => $this->m_categories->get_all_data(),
        'brands' => $this->m_brands->get_all_data(),
        'settings' => $this->m_settings->get_data(),
        'product' => $this->m_products->get_data($id_product),
        'content' => 'admin/products/v_update',
    );

    $this->load->view('admin/layout/wrapper', $data, false);
}


    //Delete one item
    public function delete($id_product = NULL)
    {
        // Hapus gambar
        $product = $this->m_products->get_data($id_product);
        if ($product->img != "") {
            unlink('./assets/products_img/' . $product->img);
        }
        //end
        $data = array('id_product' => $id_product);
        $this->m_products->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Di Hapus !');
        redirect('products');
    }
}


/* End of file Products.php */
