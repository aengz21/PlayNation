<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Adminauth extends CI_Controller
{ 
    public function __construct()
    {
        parent ::__construct();
        $this->load->model('M_adminauth');
    }
    public function admin_login()
    {
        $this->load->library('form_validation');
        $this->load->model('m_adminauth');

        $this->set_validation_rules();

        if ($this->form_validation->run()) {
            $this->process_login();
        }

        $data = array(
            'title' => 'Login Admin',
        );

        $this->load->view('admin/v_admin_login', $data, false);
    }

    public function admin_logout()
    {
        $this->load->model('m_adminauth');
        $this->admin_login->logout();
    }

    private function set_validation_rules()
    {
        $validation_rules = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s Harus Di isi !'
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => array(
                    'required' => '%s Harus Di isi !'
                )
            )
        );
        $this->form_validation->set_rules($validation_rules);
    }

    private function process_login()
    {
        $username = $this->input->post('username');
        $password = ($this->input->post('password'));
        $this->admin_login->login($username, $password);
    }

      public function forgot_password()
    {
        $this->form_validation->set_rules('username', 'Username', 'required', [
            'required' => 'Username harus diisi!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/v_forgot_password');
        } else {
            $username = $this->input->post('username');
            $admin = $this->M_adminauth->get_admin_by_username($username);

            if ($admin) {
                $token = md5(uniqid());
                $this->M_adminauth->set_reset_token($username, $token);

                // Kirim Email
                $reset_link = base_url("adminauth/reset_password/$token");
                $message = "Klik link berikut untuk mereset password Anda: <a href='$reset_link'>$reset_link</a>";
                $this->send_email($admin->email, 'Reset Password', $message);

                $this->session->set_flashdata('success', 'Silakan cek email Anda untuk reset password!');
                redirect('adminauth/forgot_password');
            } else {
                $this->session->set_flashdata('error', 'Username tidak ditemukan!');
                redirect('adminauth/forgot_password');
            }
        }
    }

    public function reset_password($token)
    {
        $admin = $this->M_adminauth->get_admin_by_token($token);
        if (!$admin) {
            $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa!');
            redirect('adminauth/forgot_password');
        }

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'required' => 'Password harus diisi!',
            'min_length' => 'Password minimal 6 karakter!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $data['token'] = $token;
            $this->load->view('admin/v_reset_password', $data);
        } else {
            $new_password = $this->input->post('password');
            $this->M_adminauth->update_password($admin->username, $new_password);

            $this->session->set_flashdata('success', 'Password berhasil direset, silakan login!');
            redirect('adminauth/admin_login');
        }
    }

    private function send_email($to, $subject, $message)
    {
        $this->load->library('email');
        $this->email->from('noreply@yourwebsite.com', 'Admin');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }
}

/* End of file adminauth.php */