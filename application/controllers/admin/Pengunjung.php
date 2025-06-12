<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . '/core/BaseController.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengunjung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');
        $this->load->model('auth_model');
        $this->load->model('fakultas_model');
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

    public function getFakultasListApi()
    {
        if ($this->input->get('searchTerm', TRUE)) {
            $data = $this->fakultas_model->get_daftar_fakultas_like($this->input->get('searchTerm', TRUE));
        } else {
            $data = $this->fakultas_model->get_daftar_fakultas();
        }

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
    }


    public function getJurusanListApi()
    {
        if ($this->input->get('searchTerm', TRUE)) {
            $data = $this->fakultas_model->get_daftar_jurusan_like($this->input->get('searchTerm', TRUE));
        } else {
            $data = $this->fakultas_model->get_daftar_jurusan();
        }

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
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

    public function export_excel()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator('pw10')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Pengunjung Perpustakaan")
            ->setSubject("Data Pengunjung")
            ->setDescription("Data Pengunjung Perpustakaan")
            ->setKeywords("Data Pengunjung Perpustakaan");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA TRANSAKSI PEMINJAMAN BUKU TANDON"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIM"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "WAKTU KUNJUNG"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "FAKULTAS"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        $post = $this->input->post();
        $getDataTransaksi = $this->transaksi_model->getDataExcel($post);

        // var_dump(count($getDataTransaksi));
        // die();

        if (count($getDataTransaksi) > 0) {

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4

            foreach ($getDataTransaksi as $data) { // Lakukan looping pada variabel siswa
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->no_mhs);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->waktu_kunjung);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->fakultas);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }

            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E


            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul file excel nya
            $excel->getActiveSheet(0)->setTitle("Laporan Data Pengunjung");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="laporan_data_pengunjung.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
            # code...
        } else {
        }
    }
}
