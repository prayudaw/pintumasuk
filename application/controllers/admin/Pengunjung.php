<?php
// require APPPATH . '/core/BaseController.php';

class Pengunjung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('auth_model');
        // if (!$this->auth_model->current_user()) {
        //     redirect('auth/login');
        // }
    }

    public function index()
    {
        // $data['transaksi'] = $this->transaksi_model->getTransaksiPerHariIni();
        // $data['page'] = 'Dashboard';
        $data['title'] = 'Data Pengunjung';
        $this->load->view('dashboard/pengunjung', $data);
    }


    public function ajax_list($now = null)
    {
        header('Content-Type: application/json');
        $list = $this->transaksi_model->get_datatables($now);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $Data_pengunjung) {
            $no++;
            $row = array();
            //row pertama akan kita gunakan untuk btn edit dan delete
            $row[] = $Data_pengunjung->no_mhs;
            $row[] = $Data_pengunjung->nama;
            $row[] = $Data_pengunjung->fakultas;
            $row[] = $Data_pengunjung->Jurusan;
            $row[] = $Data_pengunjung->waktu_kunjung;
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->transaksi_model->count_all($now),
            "recordsFiltered" => $this->transaksi_model->count_filtered($now),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }
}
