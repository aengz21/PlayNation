<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_store extends CI_Model
{
    // Mendapatkan semua produk
    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->join('tbl_categories', 'tbl_categories.id = tbl_products.id_category', 'left');
        $this->db->order_by('id_product', 'desc');
        return $this->db->get()->result();
    }

    // Mendapatkan semua kategori dengan ikon
    public function get_all_data_category_with_icons()
    {
        $this->db->select('id, kategori, icon'); // Menambahkan field 'icon'
        $this->db->from('tbl_categories');
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result();
    }

    // Mendapatkan produk promo (yang memiliki diskon)
    public function get_promo_products()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('discount >', 0); // Filter produk dengan diskon
        $this->db->order_by('id_product', 'desc');
        return $this->db->get()->result();
    }

    // Mendapatkan produk best seller
    public function get_best_seller_products()
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->order_by('sold', 'desc'); // Urutkan berdasarkan jumlah terjual (sold)
        $this->db->limit(5); // Batasi ke 5 produk paling laris
        return $this->db->get()->result();
    }

    // Mendapatkan detail kategori
    public function category($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_categories');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    // Mendapatkan produk berdasarkan kategori
    public function get_all_product_baseonbrand($id_category)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id_category', $id_category);
        return $this->db->get()->result();
    }

    // Mendapatkan detail produk
    public function detail_product($id_product)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id_product', $id_product);
        return $this->db->get()->row();
    }
}

/* End of file M_store.php */
    