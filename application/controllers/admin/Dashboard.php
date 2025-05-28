<?php
// require APPPATH . '/core/BaseController.php';

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('transaksi_model');
        if (!$this->auth_model->current_user()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        // $data['transaksi'] = $this->transaksi_model->getTransaksiPerHariIni();
        // $data['page'] = 'Dashboard';

        $this->load->view('dashboard/index');
    }

    public function getPeminjam()
    {
        $getData = $this->transaksi_model->getDataPengunjungMingguan();
        $data = array(
            'status' => true,
            'data' => $getData,
        );

        echo json_encode($data);
    }
}
