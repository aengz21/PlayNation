<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_accessoris extends CI_Model
{
    public function get_all_data_accessoris()
    {
        return $this->db->get('tbl_accessoris')->result_array();
    }

    public function add($data)
    {
        $this->db->insert('tbl_accessoris', $data);
    }

    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_accessoris', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_accessoris');
    }
} 