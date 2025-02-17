<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_wishlist extends CI_Model
{
    public function get_wishlist($id_customer)
    {
        $this->db->select('tbl_wishlist.*, tbl_products.title, tbl_products.price, tbl_products.img');
        $this->db->from('tbl_wishlist');
        $this->db->join('tbl_products', 'tbl_wishlist.id_product = tbl_products.id_product');
        $this->db->where('tbl_wishlist.id_customer', $id_customer);
        return $this->db->get()->result();
    }

    public function add_to_wishlist($data)
    {
        return $this->db->insert('tbl_wishlist', $data);
    }

    public function remove_from_wishlist($id_customer, $id_product)
    {
        $this->db->where('id_customer', $id_customer);
        $this->db->where('id_product', $id_product);
        return $this->db->delete('tbl_wishlist');
    }

    public function check_wishlist($id_customer, $id_product)
    {
        $this->db->where('id_customer', $id_customer);
        $this->db->where('id_product', $id_product);
        return $this->db->get('tbl_wishlist')->row();
    }
}
