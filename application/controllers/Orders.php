<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_orders');
        $this->load->model('m_settings');
    }

    public function index()
    {
        $data = array(
            'title' => 'Data Orders',
            'orders' => $this->m_orders->get_all_data(),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/v_orders'
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    public function details($no_order)
    {
        $data = array(
            'title' => $no_order,
            'details' => $this->m_orders->get_details_order($no_order),
            'settings' => $this->m_settings->get_data(),
            'content' => 'admin/v_details_orders'
        );

        $this->load->view('admin/layout/wrapper', $data, false);
    }

    public function inputresi($no_order)
    {
        $data = array(
            'no_order' => $no_order,
            'no_resi' => $this->input->post('no_resi'),
        );

        $this->m_orders->updateresi($data);
        $this->session->set_flashdata('pesan', 'Resi Berhasil Di Update !');

        redirect('orders/details/' . $no_order);
    }

    public function gantistatus($no_order)
    {
        $status = $this->input->post('status');
        $data = array(
            'no_order' => $no_order,
            'status' => $status,
        );

        $this->m_orders->gantistatus($data);
        $this->session->set_flashdata('pesan', 'Status Berhasil Di Update !');

        // Mengambil detail order untuk mendapatkan email customer
        $order_details = $this->m_orders->get_details_order($no_order);
        if ($order_details) {
            $customer_email = $order_details[0]->email;
            $this->send_status_email($customer_email, $status);
        }

        redirect('orders/details/' . $no_order);
    }

    private function send_status_email($to_email, $status)
    {
        $this->load->library('email');

        $this->email->from('your_email@example.com', 'Your Name');
        $this->email->to($to_email);

        $this->email->subject('Perubahan Status Pesanan Anda');
        $this->email->message('Halo, kami ingin memberitahukan bahwa status pesanan Anda telah berubah menjadi: ' . $this->get_status_text($status) . '. Terima kasih atas kepercayaan Anda kepada kami.');

        if ($this->email->send()) {
            log_message('info', 'Email pemberitahuan status pesanan berhasil dikirim ke ' . $to_email);
        } else {
            log_message('error', 'Gagal mengirim email pemberitahuan status pesanan ke ' . $to_email);
        }
    }

    private function get_status_text($status)
    {
        switch ($status) {
            case 0:
                return 'Belum Di Bayar';
            case 1:
                return 'Sudah Di Bayar';
            case 2:
                return 'Sedang Di Kirim';
            case 3:
                return 'Diterima';
            case 4:
                return 'Dibatalkan';
            default:
                return 'Tidak Diketahui';
        }
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

        $this->load->view('invoice/invoice-pdf', $data);

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

/* End of file Orders.php */