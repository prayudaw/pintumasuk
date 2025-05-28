<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{
    var $table = 'pengunjung';
    var $column_order = array('no_mhs', 'nama', 'fakultas', 'waktu_kunjung', 'Jurusan');
    var $column_search = array('no_mhs', 'nama', 'fakultas', 'waktu_kunjung', 'Jurusan');
    // default order 
    var $order = array('waktu_kunjung' => 'desc');


    public $db_siprus;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_siprus = $this->load->database('siprus', true);
        //Do your magic here
    }

    public function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {
            if ($this->input->post('search')['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }

        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $this->db->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($now = false)
    {
        $this->_get_datatables_query();

        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("waktu_kunjung LIKE '%" . $date . "%'");
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($now = false)
    {
        $this->_get_datatables_query();
        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("waktu_kunjung LIKE '%" . $date . "%'");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($now = false)
    {
        $this->db->from($this->table);
        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("waktu_kunjung LIKE '%" . $date . "%'");
        }
        return $this->db->count_all_results();
    }

    public function insertPengunjung($data)
    {
        $this->db->insert('pengunjung', $data);
        return $this->db->insert_id();
    }

    public function dataFakultas()
    {
        $this->db_siprus->from('fakultas');
        $this->db_siprus->where('fakultas != "Pegawai" ');
        $this->db_siprus->group_by('fakultas');
        $query = $this->db_siprus->get();
        return $query->result_array();
    }


    public function getDataPengunjungHarian()
    {
        $dateNow = date('y-m-d');
        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('waktu_kunjung  BETWEEN "' . $dateNow . ' 00:00:00" AND "' . $dateNow . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }


    public function getDataPengunjungBulanan()
    {
        $bulan = date('m');
        $tahun = date('y');
        $awal = $tahun . '-' . $bulan . '-01';
        $akhir = $tahun . '-' . $bulan . '-31';
        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('waktu_kunjung  BETWEEN "' . $awal . ' 00:00:00" AND "' . $akhir . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }


    public function getDataPengunjungHariIni($where)
    {
        $dateNow = date('y-m-d');
        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('fakultas = "' . $where . '"');
        $this->db->where('waktu_kunjung  BETWEEN "' . $dateNow . ' 00:00:00" AND "' . $dateNow . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }

    public function getDataPengunjungExcelHarian($where)
    {
        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('fakultas = "' . $where['fakultas'] . '"');
        $this->db->where('waktu_kunjung  BETWEEN "' . $where['tanggal'] . ' 00:00:00" AND "' . $where['tanggal'] . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }

    public function getDataPengunjungExcelBulan($where)
    {
        $awal = $where['tahun'] . '-' . $where['bulan'] . '-01';
        $akhir = $where['tahun'] . '-' . $where['bulan'] . '-31';

        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('fakultas = "' . $where['fakultas'] . '"');
        $this->db->where('waktu_kunjung  BETWEEN "' . $awal . ' 00:00:00" AND "' . $akhir . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }

    public function getDataPengunjungExcelTahun($where)
    {
        $awal = $where['tahun'] . '-01-01';
        $akhir = $where['tahun'] . '-12-31';

        $this->db->select('COUNT(*) AS jumlah');
        $this->db->from('pengunjung');
        $this->db->where('fakultas = "' . $where['fakultas'] . '"');
        $this->db->where('waktu_kunjung  BETWEEN "' . $awal . ' 00:00:00" AND "' . $akhir . ' 23:00:00"');
        $query = $this->db->get();
        return $query->row();
    }

    public function getDataPengunjungMingguan()
    {

        $query = $this->db->query('SELECT DATE(waktu_kunjung) AS kunjung,COUNT(waktu_kunjung) AS jumlah FROM `pengunjung` WHERE DATE(waktu_kunjung) > (NOW() - INTERVAL 8 DAY) GROUP BY kunjung');

        return $query->result_array();
    }
}
