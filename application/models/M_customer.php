<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model 
{
    public function register($data)
    {
        $this->db->insert('tbl_customers', $data);
    }

    public function update_password($data){
        $this->db->where('id_customer', $data['id_customer']);
        $this->db->update('tbl_customers', $data);
    }

    public function get_customer_by_id($customer_id)
    {
        $this->db->where('id_customer', $customer_id);
        return $this->db->get('tbl_customers')->row();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('tbl_customers', ['email' => $email])->row();
    }

    public function set_password_reset_token($id_customer, $token)
    {
        $this->db->where('id_customer', $id_customer);
        $this->db->update('tbl_customers', ['reset_token' => $token, 'token_expiry' => date('Y-m-d H:i:s', strtotime('+1 hour'))]);
    }

    public function get_by_reset_token($token)
    {
        return $this->db->get_where('tbl_customers', ['reset_token' => $token, 'token_expiry >' => date('Y-m-d H:i:s')])->row();
    }

    public function clear_password_reset_token($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->update('tbl_customers', ['reset_token' => null, 'token_expiry' => null]);
    }

    public function forgot_password($email)
    {
        $customer = $this->get_by_email($email);
        if ($customer) {
            $otp = rand(100000, 999999); // Generate a random OTP
            $this->set_password_reset_token($customer->id_customer, $otp); // Simpan OTP di database
            $this->send_reset_email($email, $otp); // Panggil fungsi untuk mengirim email
            return true; // Berhasil
        }
        return false; // Email tidak ditemukan
    }

    private function send_reset_email($email, $otp)
    {
        $this->load->library('email'); // Pastikan library email telah di-load
        $this->email->from('satrioangga350@gmail.com', 'Playnation'); // Ganti dengan alamat Gmail Anda
        $this->email->to($email);
        $this->email->subject('Kode OTP untuk Reset Password Anda');
        $this->email->message("
        <center>
            <p>Hai,</p>
            <p>Untuk atur ulang password, mohon gunakan kode OTP berikut:</p>
            <h2 style='font-size: 24px; font-weight: bold;'>$otp</h2>
            <p>Hanya berlaku selama 15 menit, JANGAN BERIKAN kode ini ke siapa pun.</p>
            <p>Jika Anda tidak mengajukan permintaan ini, mohon segera hubungi Customer Service kami.</p>
            <p>Terima kasih,<br>Playnation</p>
            </center>
        ");

        if ($this->email->send()) {
            return true; // Email berhasil dikirim
        } else {
            log_message('error', $this->email->print_debugger()); // Log error jika pengiriman gagal
            return false;
        }
    }


    public function reset_password($id_customer, $new_password)
    {
        $this->db->where('id_customer', $id_customer);
        $this->db->update('tbl_customers', ['password' => password_hash($new_password, PASSWORD_BCRYPT)]);
    }

    public function get_by_activation_token($token)
    {
        return $this->db->get_where('tbl_customers', ['activation_token' => $token])->row();
    }

    public function activate_account($id_customer)
    {
        $this->db->where('id_customer', $id_customer);
        return $this->db->update('tbl_customers', ['is_active' => 1, 'activation_token' => null]); // Set is_active to 1 and clear the token
    }

    public function add_review($data)
    {
        $this->db->insert('tbl_comments', $data); // Pastikan tabel 'tbl_reviews' ada di database
    }

}

/* End of file M_customer.php */
