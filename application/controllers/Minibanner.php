<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Minibanner extends Sekai_Controller {

    public function index() {
        $data = array();
        $this->C_template('minibanner/v_index', $data);
    }
}
