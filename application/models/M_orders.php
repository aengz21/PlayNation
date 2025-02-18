<?php


defined('BASEPATH') or exit('No direct script access allowed');

class M_orders extends CI_Model
{
    public function simpan_transaksi($data)
    {
        $this->db->insert('tbl_orders', $data);
    }

    public function simpan_detail_transaksi($datadetails)
    {
        $this->db->insert('tbl_detail_orders', $datadetails);
    }

    public function get_data_by_logged_id()
    {
        $loggedID = $this->session->userdata('id_customer');
        $this->db->select('*');
        $this->db->from('tbl_orders');
        $this->db->where('id_customer', $loggedID);
        $this->db->order_by('id_order', 'desc');
        return $this->db->get()->result();
    }

    public function get_details_order($no_order)
    {
        $this->db->select('
        tbl_detail_orders.id_details,
        tbl_detail_orders.no_order,
        tbl_detail_orders.id_product,
        tbl_detail_orders.qty,
        tbl_orders.*,
        tbl_products.title AS product_name,
        tbl_products.price,
        tbl_products.weight,
        tbl_products.discount,
        tbl_products.img AS image
    ');
        $this->db->from('tbl_detail_orders');
        $this->db->join('tbl_orders', 'tbl_detail_orders.no_order = tbl_orders.no_order');
        $this->db->join('tbl_products', 'tbl_detail_orders.id_product = tbl_products.id_product');
        $this->db->where('tbl_detail_orders.no_order', $no_order);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function diterima($data)
    {
        $this->db->where('id_order', $data['id_order']);
        $this->db->update('tbl_orders', $data);
    }


    //admin
    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_orders');
        $this->db->order_by('id_order', 'desc');
        return $this->db->get()->result();
    }

    //Input Resi
    public function updateresi($data){
        $this->db->where('no_order', $data['no_order']);
        $this->db->update('tbl_orders', $data);
    }

    //Ganti Status

    public function get_filtered_orders($status = null, $search = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_orders');
        $this->db->where('id_customer', $this->session->userdata('id_customer'));

        if ($status && $status != 'all') {
            $this->db->where('status', $status);
        }

        if ($search) {
            $this->db->like('no_order', $search);
        }

        $query = $this->db->get();
        $result = $query->result();

        // Tambahkan log untuk debugging
        log_message('debug', 'Orders: ' . print_r($result, true));

        return $result;
    }
    public function gantistatus($data , $id_order, $status_baru) {
         // Ambil nomor HP dari order berdasarkan ID
         $order = $this->db->get_where('tb_order', ['id_order' => $id_order])->row();
         if (!$order) {
             return false;
         }
 
         $nomor_hp = $order->nomor_hp;
 
         // Update status di database
         $this->db->where('id_order', $id_order);
         $this->db->update('tb_order', ['status' => $status_baru]);
 
         // Kirim pesan WhatsApp atau SMS
         return $this->kirim_pesan($nomor_hp, $status_baru);
     }
 
     private function kirim_pesan($nomor_hp, $status)
     {
         $pesan = "Halo, pesanan Anda dengan ID #" . $nomor_hp . " telah berubah status menjadi: " . $status;
 
         // API WhatsApp / SMS
         $api_url = "https://api.whatsapp.com/send?phone=" . $nomor_hp . "&text=" . urlencode($pesan);
 
         // Kirim request
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $api_url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         $result = curl_exec($ch);
         curl_close($ch);
 
         return $result;
    }

    // Tambahkan method untuk mendapatkan history status
    public function get_status_history($no_order) {
        $this->db->select('status_history.*, admin.username as changed_by');
        $this->db->from('tbl_status_history as status_history');
        $this->db->join('tbl_admin as admin', 'status_history.admin_id = admin.id_admin', 'left');
        $this->db->where('no_order', $no_order);
        $this->db->order_by('created_at', 'desc');
        return $this->db->get()->result();
    }

    // Tambahkan method untuk menyimpan history status
    public function save_status_history($data) {
        return $this->db->insert('tbl_status_history', $data);
    }
}


/* End of file M_orders.php */