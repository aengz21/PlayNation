<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_categories extends CI_Model {

    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_categories');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result();
    }

    public function is_category_exist($nama_brand)
    {
        $this->db->where('kategori', $nama_brand);
        $query = $this->db->get('tbl_categories');
        return $query->num_rows() > 0;
    }

    public function add($data){
        $this->db->insert('tbl_categories', $data);
        
    }

    public function update($data){
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_categories', $data);
    }

    public function delete($data){
        $this->db->where('id', $data['id']);
        $this->db->delete('tbl_categories', $data);
    }
}