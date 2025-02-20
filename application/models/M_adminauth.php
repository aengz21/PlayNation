<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_adminauth extends CI_Model 
{
    public function admin_login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin');
        $this->db->where(array(
            'username' => $username, 
            'password' => md5($password)
        ));
        return $this->db->get()->row();
        
    }

    public function get_admin_by_username($username)
    {
        return $this->db->get_where('tbl_admin', ['username' => $username])->row();
    }

    public function set_reset_token($username, $token)
    {
        $this->db->where('username', $username);
        $this->db->update('tbl_admin', ['reset_token' => $token]);
    }

    public function get_admin_by_token($token)
    {
        return $this->db->get_where('tbl_admin', ['reset_token' => $token])->row();
    }

    public function update_password($username, $new_password)
    {
        $this->db->where('username', $username);
        $this->db->update('tbl_admin', [
            'password' => md5($new_password),
            'reset_token' => NULL
        ]);
    }
}

/* End of file M_auth.php */