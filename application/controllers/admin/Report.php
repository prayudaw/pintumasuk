<?php

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('auth_model');
        $this->load->library('Pdf');

        if (!$this->auth_model->current_user()) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['title'] = 'Report';
        $this->load->view('dashboard/report', $data);
    }

    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->transaksi_model->get_datatables();
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
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->transaksi_model->count_all(),
            "recordsFiltered" => $this->transaksi_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    public function export_excel_harian()
    {
        $tanggal = $this->input->get('tanggal');
        $dataFakultas = $this->getDataFakultas();
        $data = array();
        $i = 0;
        foreach ($dataFakultas as $key => $value) {

            $jum = $this->transaksi_model->getDataPengunjungExcelHarian(array('tanggal' => $tanggal, 'fakultas' => $value['fakultas']));
            $data[$i]['fakultas'] = $value['fakultas'];
            $data[$i]['jumlah'] = (int) $jum->jumlah;
            $i++;
        }

        $d['data'] = $data;
        $this->load->view('dashboard/report/v_laporan', $d);
    }

    function export_excel_bulan()
    {
        $bulan_name = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $dataFakultas = $this->getDataFakultas();
        $data = array();
        $i = 0;

        foreach ($dataFakultas as $key => $value) {
            $jum = $this->transaksi_model->getDataPengunjungExcelBulan(array('bulan' => $bulan, 'tahun' => $tahun, 'fakultas' => $value['fakultas']));
            $data[$i]['fakultas'] = $value['fakultas'];
            $data[$i]['jumlah'] = (int) $jum->jumlah;
            $i++;
        }
        $d['tittle'] = $bulan_name[$bulan] . ' ' . $tahun;
        $d['data'] = $data;

        $this->load->view('dashboard/report/v_laporan_bulan', $d);
    }

    function export_excel_tahun()
    {
        $tahun = $this->input->get('tahun');
        $dataFakultas = $this->getDataFakultas();
        $data = array();
        $i = 0;

        foreach ($dataFakultas as $key => $value) {
            $jum = $this->transaksi_model->getDataPengunjungExcelTahun(array('tahun' => $tahun, 'fakultas' => $value['fakultas']));
            $data[$i]['fakultas'] = $value['fakultas'];
            $data[$i]['jumlah'] = (int) $jum->jumlah;
            $i++;
        }
        $d['tittle'] = $tahun;
        $d['data'] = $data;
        $this->load->view('dashboard/report/v_laporan_tahun', $d);
    }

    // public function export_excel_bulan1()
    // {
    //     $bulan = $this->input->get('bulan');
    //     $tahun = $this->input->get('tahun');
    //     $dataFakultas = $this->getDataFakultas();
    //     $data = array();
    //     $i = 0;

    //     foreach ($dataFakultas as $key => $value) {
    //         $data[$i]['fakultas'] = $value['fakultas'];
    //         $b = 1;
    //         //loop for date
    //         for ($b = 1; $b <= 31; $b++) {
    //             $tanggal = $tahun . "-" . $bulan . "-" . $b;
    //             $jum = $this->transaksi_model->getDataPengunjungExcelHarian(array('tanggal' => $tanggal, 'fakultas' => $value['fakultas']));
    //             $data[$i]['tanggal'][$b] = (int) $jum->jumlah;
    //         }
    //         $b++;
    //         //end 
    //         $i++;
    //     }

    //     // //debug
    //     // echo "<pre>";
    //     // echo print_r($data);
    //     // die();
    //     //

    //     $d['data'] = $data;
    //     $this->load->view('dashboard/report/v_laporan_bulan', $d);
    // }

    private function getDataFakultas()
    {
        $getDataFakultas = $this->transaksi_model->dataFakultas();
        return $getDataFakultas;
    }

    //dummy export excel
    public function tes()
    {
        $this->load->view('dashboard/v_laporan');
    }
}
