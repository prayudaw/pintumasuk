<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('anggota_model');
    }

    public function index()
    {   
        
        $data['data_pengunjung_harian'] = (int) $this->transaksi_model->getDataPengunjungHarian()->jumlah;
        $data['data_pengunjung_bulanan'] = (int) $this->transaksi_model->getDataPengunjungBulanan()->jumlah;
        $this->load->view('home', $data);
    }

    public function getAnggota()
    {
        $nim = $this->input->post('nim');

        //check anggota
        $get_data_anggota = $this->anggota_model->getAnggotaById($nim);


       
        $message_blokir= '';
        

        $status = 2;
        $message = '';
        $foto = '';
        $image = '';
        $data_anggota = '';
        
        if (empty($get_data_anggota)) {
            $message = 'Gagal Data Tidak Ditemukan Silakan Menghubungi Petugas';
        } else if (count($get_data_anggota) > 0) {
            if ($get_data_anggota['status'] == 'P') {
                $message = 'Keanggotaan Tidak Aktif';
            } elseif ($get_data_anggota['status'] == 'BP') {
                $message = 'Sudah Bebas Pustaka';
            } 
            elseif ($get_data_anggota['status'] == 'DO') {
                $message = 'Keanggotaan Sudah Drop Out';
            }
            else {
                $check_blokir=$this->anggota_model->getAnggotaBlokir($nim);

                if ($check_blokir !==NULL) { 
                    $message_blokir=$check_blokir['keterangan'];
                }
                $this->checkout($get_data_anggota);
                $data_anggota = $get_data_anggota;
                $image = $this->getImage($nim);
                $status = 1;
                $message = 'Berhasil';
            }

        }
        echo json_encode(array('status' => $status, 'foto' => $image, 'data' => $data_anggota, 'message' => $message,'message_blokir' =>$message_blokir));
    }

    private function checkout($data)
    {

        $dataInsert = array(
            'no_mhs' => $data['no_mhs'],
            'nama' => $data['nama'],
            'fakultas' => $data['fakultas'],
            'jurusan' => $data['jurusan'],
        );

        $this->transaksi_model->insertPengunjung($dataInsert);
    }

    private function getImage($nim)
    {
        //get image mahasiswa from api
        $url = 'https://siprus.uin-suka.ac.id/realtime/b/a.php?nim=' . $nim . '';
        $html = file_get_contents($url);
        $doc = new DOMDocument();
        $img = '';
        @$doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('img');
        foreach ($tags as $tag) {
            $img = $tag->getAttribute('src');
        }
        // $img='';
        return $img;
    }

    public function getStatistik()
    {
        $getDataFakultas = $this->transaksi_model->dataFakultas();
        $tes = array();
        $i = 0;
        foreach ($getDataFakultas as $key => $value) {
            $jum = $this->transaksi_model->getDataPengunjungHariIni($value['fakultas']);
            $totData = (int) $jum->jumlah;
            if ($totData !== 0) {
                $tes[$i]['fakultas'] = $value['fakultas'];
                $tes[$i]['jumlah'] = (int) $jum->jumlah;

                if ($value['fakultas'] == 'Adab dan Ilmu Budaya') {
                    $tes[$i]['color'] = '#FEF552'; //fakultas Adab dan Ilmu Budaya
                }
                if ($value['fakultas'] == 'Dakwah dan Komunikasi') { //Dakwah dan Komunikasi
                    $tes[$i]['color'] = '#D29E6F';
                }
                if ($value['fakultas'] == 'Dosen') { // Dosen
                    $tes[$i]['color'] = 'purple';
                }
                if ($value['fakultas'] == 'Ekonomi dan Bisnis Islam') { //fakultas Ekonomi dan Bisnis Islam
                    $tes[$i]['color'] = '#FF5E10';
                }
                if ($value['fakultas'] == 'Ilmu Sosial dan Humaniora') { //fakultas Ilmu Sosial dan Humaniora
                    $tes[$i]['color'] = '#CE85CE';
                }
                if ($value['fakultas'] == 'Ilmu Tarbiyah dan Keguruan') { //fakultas Ilmu Tarbiyah dan Keguruan
                    $tes[$i]['color'] = '#4bf707';
                }
                if ($value['fakultas'] == 'Pascasarjana') { //fakultas Pascasarjana
                    $tes[$i]['color'] = 'red';
                }
                if ($value['fakultas'] == 'SAINS DAN TEKNOLOGI') { //fakultas SAINS DAN TEKNOLOGI
                    $tes[$i]['color'] = '#295ED2';
                }
                if ($value['fakultas'] == "Syari'ah dan Hukum") {
                    $tes[$i]['color'] = '#2A292F'; //fakultas Syari'ah dan Hukum
                }
                if ($value['fakultas'] == 'Ushuluddin dan Pemikiran Islam') { //fakultas Ushuluddin dan Pemikiran Islam
                    $tes[$i]['color'] = '#26dbef';
                }
                $i++;
            }
        }

        $data_pengunjung = array();
        $data_pengunjung['harian'] = (int) $this->transaksi_model->getDataPengunjungHarian()->jumlah;
        $data_pengunjung['bulanan'] = (int) $this->transaksi_model->getDataPengunjungBulanan()->jumlah;
        $data = array(
            'status' => true,
            'data' => $tes,
            'data_pengunjung' => $data_pengunjung
        );
        echo json_encode($data);
    }

}