<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_customer');
        $this->load->model('M_wishlist');
        $this->load->model('m_customerauth');
        $this->load->model('m_orders');
        $this->load->model('m_settings');
        $this->load->model('m_store');
        $params = array('server_key' => 'SB-Mid-server-oSm60e409Hpy2faZ-s1XPXtd', 'production' => false);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: PUT, GET, POST");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $this->load->library('midtrans');
        $this->midtrans->config($params);
        $this->load->helper('url');
    }

    public function register()
    {
        $this->form_validation->set_rules(
            'nama_customer',
            'Nama Lengkap',
            'required',
            array('required' => '%s Harus Di Isi !')
        );

        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'required|is_unique[tbl_customers.email]',
            array(
                'required' => '%s Harus Di Isi !',
                'is_unique' => '%s Ini Sudah Terdaftar !'
            )
        );

        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[8]',
            array(
                'required' => '%s Harus Di Isi !',
                'min_length' => '%s Minimal 8 Karakter'
            )
        );

        $this->form_validation->set_rules(
            'confirmpw',
            'Konfirmasi Password',
            'required|matches[password]',
            array(
                'required' => '%s Harus Di Isi !',
                'matches' => '%s Tidak Sama'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Register Pelanggan',
                'settings' => $this->m_settings->get_data(),
                'content' => 'customer/v_register'
            );

            $this->load->view('customer/layout/wrapper-daftar', $data, false);
        } else {
            $data = array(
                'nama_customer' => $this->input->post('nama_customer'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'activation_token' => bin2hex(random_bytes(16)),
                'is_active' => 0
            );

            $this->m_customer->register($data);
            $this->send_activation_email($data['email'], $data['activation_token']);
            $this->session->set_flashdata('berhasil', 'Registrasi Berhasil! Silahkan cek email Anda untuk mengaktifkan akun.');
            redirect('customer/register');
        }
    }
    public function login()
    {
        $this->set_validation_rules();
        $login_berhasil = $this->form_validation->run();
        if ($login_berhasil) {
            $this->process_login();
            $this->session->set_userdata('logged_in', true);
        }
        $data = array(
            'title' => 'Login Pelanggan',
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_login'
        );

        $this->load->view('customer/layout/wrapper-login', $data, false);
    }

    public function account()
    {
        $this->form_validation->set_rules(
            'currentPassword',
            'Password Saat Ini',
            'required|min_length[8]|callback_check_current_password',
            array(
                'required' => '%s Harus Di Isi !',
                'min_length' => '%s Minimal 8 Karakter',
                'callback_check_current_password' => '%s Salah'
            )
        );

        $this->form_validation->set_rules(
            'newPassword',
            'Password Baru',
            'required|min_length[8]',
            array(
                'required' => '%s Harus Di Isi !',
                'min_length' => '%s Minimal 8 Karakter'
            )
        );

        $this->form_validation->set_rules(
            'confirmPassword',
            'Konfirmasi Password',
            'required|matches[newPassword]',
            array(
                'required' => '%s Harus Di Isi !',
                'matches' => '%s Tidak Sama'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'title' => 'Dashboard Pelanggan',
                'settings' => $this->m_settings->get_data(),
                'content' => 'customer/v_dashboard',
                'category' => $this->m_store->get_all_data_category(), // Data kategori beserta ikon
                'brand' => $this->m_store->get_all_data_brands()
            );
    
            $this->load->view('customer/layout/wrapper', $data, false);
        } else {
            $data = array(
                'id_customer' => $this->session->userdata('id_customer'),
                'password' => md5($this->input->post('newPassword')),
            );

            $this->m_customer->update_password($data);
            $this->session->set_flashdata('pesan', 'Password Berhasil Di Update !');
            redirect('customer/account');
        }
    }

    public function check_current_password($currentPassword) {
        $user = $this->m_customer->get_customer_by_id($this->session->userdata('id_customer'));
    
        if (!$user || $user->password !== md5($currentPassword)) {
            $this->form_validation->set_message('check_current_password', 'Password saat ini salah');
            return FALSE;
        }
    
        return TRUE;
    }    

    private function set_validation_rules()
    {
        $validation_rules = array(
            array(
                'field' => 'email',
                'label' => 'E-mail',
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
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        
        $user = $this->m_customer->get_by_email($email);
        if ($user && $user->password === $password) {
            if (!$user->is_active) {
                $this->session->set_flashdata('error', 'Akun Anda belum diaktifkan! Silakan aktifasi akun Anda.');
                redirect('customer/login');
            } else {
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('id_customer', $user->id_customer);
                $this->session->set_userdata('email', $user->email);
                redirect('store');
            }
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah!');
            redirect('customer/login');
        }
    }

    public function logout()
    {
        $this->customer_login->logout();
    }

    public function my_orders()
    {
        $status = $this->input->get('status');
        $search = $this->input->get('search');

        $data = array(
            'title' => 'Pesanan Saya',
            'orders' => $this->m_orders->get_filtered_orders($status, $search),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_my_orders'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }

    public function details_order($no_order)
    {
        $data = array(
            'title' => 'Pesanan Saya',
            'details' => $this->m_orders->get_details_order($no_order),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_details_order'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    }

    // Midtrans
    public function token()
    {
        $no_order = $this->input->get('no_order');
        $grossamount = $this->input->get('grossamount');
        $nama = $this->input->get('nama');
        $alamat = $this->input->get('alamat');
        $no_hp = $this->input->get('no_hp');
        $kota = $this->input->get('kota');
        $provinsi = $this->input->get('provinsi');
        $datakeranjang = $this->m_orders->get_details_order($no_order);
        

        // Update status pesanan menjadi "belum dibayar"
        $this->db->update('tbl_orders', ['status' => 0], ['no_order' => $no_order]);

        // Required
        $transaction_details = array(
            'order_id' => $no_order,
            'gross_amount' => (int)$grossamount, // no decimal allowed for creditcard
        );

        $item_details = array();
        
        foreach ($datakeranjang as $keranjang) {
            $item_details[] = array(
                'id' => $keranjang->id_product,
                'price' => $keranjang->price - ($keranjang->price * $keranjang->discount / 100),
                'quantity' => $keranjang->qty,
                'name' => $keranjang->product_name
            );
        }

        // Include ongkir
        $item_details[0]['price'] += $keranjang->ongkir;

        // Optional
        $shipping_address = array(
            'first_name'    => $nama,
            'last_name'     => "",
            'address'       => $alamat,
            'city'          => $kota,
            'province'      => $provinsi,
            'postal_code'   => "",
            'phone'         => $no_hp,
            'country_code'  => 'IDN'
        );

        // Mengambil email dari sesi pengguna yang sudah login
        $email = $this->session->userdata('email'); // Pastikan email disimpan di sesi saat login

        // Optional
        $customer_details = array(
            'first_name'    => $nama,
            'last_name'     => "",
            'email'         => $email, // Menggunakan email pengguna yang sudah login
            'phone'         => $no_hp,
            'billing_address'  => $shipping_address,
            'shipping_address' => $shipping_address
        );

        // Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O", $time),
            'unit' => 'day',
            'duration'  => 1
        );

        $transaction_data = array(
            'transaction_details' => $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

        error_log(json_encode($transaction_data));
        $snapToken = $this->midtrans->getSnapToken($transaction_data);
        error_log($snapToken);
        echo $snapToken;
    }

    public function finish()
    {
        $result = json_decode($this->input->post('result_data'));
        $no_order = $result->order_id;
        $this->db->update('tbl_orders', ['status' => 1], ['no_order' => $no_order] );
        echo 'RESULT <br><pre>';
        var_dump($result);
        echo '</pre>';
        redirect('customer/details_order/'.$no_order);
    }

    //Terima Pesanan
    public function diterima($id_order)
    {
        $no_order = $this->input->post('no_order');
        $data = array(
            'id_order' => $id_order,
            'status' => 3,
        );

        $this->m_orders->diterima($data);
        redirect('customer/details_order/'.$no_order);
    }


public function forgot_password()
{
    $this->form_validation->set_rules(
        'email', 
        'E-mail', 
        'required|valid_email', 
        array(
            'required' => '%s Harus Di Isi !',
            'valid_email' => '%s Tidak Valid !'
        )
    );

    if ($this->form_validation->run() == FALSE) {
        $data = array(
            'title' => 'Lupa Password',
            'settings' => $this->m_settings->get_data(),
            'category' => $this->m_store->get_all_data_category(),
            'brand' => $this->m_store->get_all_data_brands(),
            'content' => 'customer/v_forgot_password'
        );

        $this->load->view('customer/layout/warpper-forgot', $data, false);
    } else {
        $email = $this->input->post('email');
        $user = $this->m_customer->get_by_email($email);

        if ($user) {
            $token = bin2hex(random_bytes(50)); // generate random token
            $this->m_customer->set_password_reset_token($user->id_customer, $token);

            // Kirim email dengan link reset password
            $reset_link = base_url('customer/reset_password?token=' . $token);
            $this->send_reset_email($email, $reset_link);

            $this->session->set_flashdata('pesan', 'Link reset password sudah dikirim ke email Anda!');
        } else {
            $this->session->set_flashdata('pesan', 'Email tidak ditemukan!');
        }
        redirect('customer/forgot_password');
    }
}

public function reset_password()
{
    $token = $this->input->get('token');
    $user = $this->m_customer->get_by_reset_token($token);

    if (!$user) {
        $this->session->set_flashdata('pesan', 'Token tidak valid atau sudah kadaluarsa!');
        redirect('customer/login');
    }

    $this->form_validation->set_rules(
        'new_password', 
        'Password Baru', 
        'required|min_length[8]',
        array(
            'required' => '%s Harus Di Isi !',
            'min_length' => '%s Minimal 8 Karakter'
        )
    );

    $this->form_validation->set_rules(
        'confirm_password', 
        'Konfirmasi Password', 
        'required|matches[new_password]',
        array(
            'required' => '%s Harus Di Isi !',
            'matches' => '%s Tidak Sama'
        )
    );

    if ($this->form_validation->run() == FALSE) {
        $data = array(
            'title' => 'Reset Password',
            'settings' => $this->m_settings->get_data(),
            'content' => 'customer/v_reset_password'
        );

        $this->load->view('customer/layout/wrapper', $data, false);
    } else {
        $new_password = md5($this->input->post('new_password'));
        $this->m_customer->update_password(array('id_customer' => $user->id_customer, 'password' => $new_password));
        $this->m_customer->clear_password_reset_token($user->id_customer);
        
        $this->session->set_flashdata('berhasil', 'Password berhasil direset! Silahkan login.');
        redirect('customer/login');
    }
}

private function send_reset_email($email, $reset_link)
{
    // Konfigurasi dan kirim email di sini
    $this->load->library('email');
    $this->email->from('satrioangga350@gmail.com', 'Playnation'); // Ganti dengan alamat Gmail Anda
    $this->email->to($email);
    $this->email->subject('Permintaan Reset Password Anda');
    $this->email->message("
    <center>
        <h2 style='font-size: 20px; font-weight: bold;'>Permintaan Reset Password</h2>
        <p style='font-size: 16px;'>Halo,</p>
        <p style='font-size: 16px;'>Kami menerima permintaan untuk mereset password akun Anda di Playnation. Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.</p>
        <p style='font-size: 16px;'>Untuk mereset password Anda, silakan klik tautan di bawah ini:</p>
        <p style='font-size: 16px;'><a href='$reset_link' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
        <p style='font-size: 16px;'>Terima kasih,<br>Tim Playnation</p>
    </center>
    ");
    if ($this->email->send()) {
        return true; // Email berhasil dikirim
    } else {
        log_message('error', $this->email->print_debugger()); // Log error jika pengiriman gagal
        return false;
    }
}

private function send_activation_email($email, $token)
{
    $activation_link = base_url('customer/activate?token=' . $token);
    $this->load->library('email');
    $this->email->from('satrioangga350@gmail.com', 'Playnation');
    $this->email->to($email);
    $this->email->subject('Aktivasi Akun Anda');
    $this->email->message("<center>
        <h2>Selamat Datang di Playnation!</h2>
        <p>Terima kasih telah mendaftar. Untuk mengaktifkan akun Anda, silakan klik tautan di bawah ini:</p>
        <p><a href='$activation_link' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Aktivasi Akun Anda</a></p>
        <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
        <p>Terima kasih,<br>Tim Playnation</p>
    </center>");
    $this->email->send();
}

public function activate()
{
    $token = $this->input->get('token');
    $user = $this->m_customer->get_by_activation_token($token);

    if ($user) {
        $this->m_customer->activate_account($user->id_customer);
        $this->session->set_flashdata('berhasil', 'Akun Anda berhasil diaktifkan! Silahkan login.');
        redirect('customer/login');
    } else {
        $this->session->set_flashdata('pesan', 'Token aktivasi tidak valid atau sudah kadaluarsa!');
        redirect('customer/login');
    }
}

public function pay_order($no_order)
{
    // Ambil data pesanan berdasarkan nomor pesanan
    $order = $this->m_orders->get_order_by_no($no_order);

    // Periksa apakah status pesanan adalah "belum dibayar"
    if ($order && $order->status == 0) {
        // Redirect ke metode token untuk memproses pembayaran
        redirect('customer/token?no_order=' . $no_order . '&grossamount=' . $order->gross_amount . '&nama=' . $order->nama . '&alamat=' . $order->alamat . '&no_hp=' . $order->no_hp);
    } else {
        // Jika status bukan "belum dibayar", tampilkan pesan kesalahan atau lakukan tindakan lain
        $this->session->set_flashdata('error', 'Pesanan tidak dapat diproses atau sudah dibayar.');
        redirect('customer/my_orders');
    }
}


public function wishlist()
{
    $id_customer = $this ->session->userdata('id_customer');
    $data = array(
        'title' => 'Wishlist Saya',
        'wishlist' => $this->M_wishlist->get_wishlist($id_customer),
        'category' => $this->m_store->get_all_data_category(),
        'brand' => $this->m_store->get_all_data_brands(),
        'settings' => $this->m_settings->get_data(),
        'content' => 'customer/v_wishlist'
    );

    $this->load->view('customer/layout/wrapper', $data);
}
public function add_wishlist()
{
    $id_customer = $this->session->userdata('id_customer');
    $id_product = $this->input->post('id_product');

    log_message('debug', "Add to wishlist: Customer ID = $id_customer, Product ID = $id_product");

    // Cek apakah produk sudah ada di wishlist
    if (!$this->M_wishlist->check_wishlist($id_customer, $id_product)) {
        $data = [
            'id_customer' => $id_customer,
            'id_product' => $id_product
        ];
        $this->M_wishlist->add_to_wishlist($data);
        $this->session->set_flashdata('success', 'Produk ditambahkan ke wishlist.');
    } else {
        $this->session->set_flashdata('error', 'Produk sudah ada di wishlist Anda.');
    }
}

public function remove_wishlist()
{
    $id_customer = $this->session->userdata('id_customer');
    $id_product = $this->input->post('id_product');

    log_message('debug', "Remove from wishlist: Customer ID = $id_customer, Product ID = $id_product");

    $wishlist_item = $this->M_wishlist->check_wishlist($id_customer, $id_product);
    if ($wishlist_item) {
        $this->M_wishlist->remove_from_wishlist($wishlist_item->id_wishlist);
        $this->session->set_flashdata('success', 'Produk dihapus dari wishlist.');
    }
}

public function check_wishlist_status()
{
    $id_customer = $this->session->userdata('id_customer');
    $id_product = $this->input->post('id_product');

    if ($id_customer) {
        $in_wishlist = $this->M_wishlist->check_wishlist($id_customer, $id_product);
        echo json_encode(['status' => $in_wishlist ? 'in_wishlist' : 'not_in_wishlist']);
    } else {
        echo json_encode(['status' => 'not_logged_in']);
    }
}

public function toggle_wishlist()
{
    $id_customer = $this->session->userdata('id_customer');
    $id_product = $this->input->post('id_product');

    if (!$id_customer) {
        echo json_encode(['status' => 'not_logged_in']);
        return;
    }

    if ($this->M_wishlist->check_wishlist($id_customer, $id_product)) {
        $this->M_wishlist->remove_from_wishlist($id_customer, $id_product);
        echo json_encode(['status' => 'removed']);
    } else {
        $this->M_wishlist->add_to_wishlist(['id_customer' => $id_customer, 'id_product' => $id_product]);
        echo json_encode(['status' => 'added']);
    }
}

public function submit_review()
{
    if (!$this->session->userdata('logged_in')) {
        redirect('customer/login');
    }

    $data = array(
        'id_product' => $this->input->post('id_product'),
        'user_name' => $this->session->userdata('email'), // Atau gunakan nama pengguna jika tersedia
        'comment' => $this->input->post('comment'),
        'rating' => $this->input->post('rating'),
        'created_at' => date('Y-m-d H:i:s') // Tambahkan timestamp jika diperlukan
    );

    $this->m_customer->add_review($data);
    $this->session->set_flashdata('pesan', 'Ulasan berhasil ditambahkan!');
    redirect('store/detail_product/' . $data['id_product']);
}
public function exportpdf($no_order)
    {
        $data = array(
            'title' => 'Pesanan Saya',
            'details' => $this->m_orders->get_details_order($no_order),
            'content' => 'customer/v_details_order'
        );  
        $sroot      = $_SERVER['DOCUMENT_ROOT'];
        include $sroot . "/playnation/application/third_party/dompdf/autoload.inc.php";
        $dompdf = new Dompdf\Dompdf();

        $this->load->view('invoice/invoice-receipt', $data);

        $paper_size  = 'A4'; // ukuran kertas 
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape 
        $html = $this->output->get_output();
        $dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF 
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("invoice-$no_order.pdf", array('Attachment' => 0));
    }

}

/* End of file Customer.php */
