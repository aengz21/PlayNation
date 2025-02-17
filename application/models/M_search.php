<?php


defined('BASEPATH') or exit('No direct script access allowed');
class M_search extends CI_Model
{
    public function searchProducts($title, $min_price = null, $max_price = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_products');
        if ($title) {
            $this->db->like('title', $title);
        }
        if ($min_price) {
            $this->db->where('price >=', $min_price);
        }
        if ($max_price) {
            $this->db->where('price <=', $max_price);
        }
        return $this->db->get()->result();
    }
}


/* End of file search.php */
