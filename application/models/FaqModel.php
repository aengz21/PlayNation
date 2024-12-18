<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FaqModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_faqs() {
        $query = $this->db->get('faqs');
        return $query->result();
    }
} 