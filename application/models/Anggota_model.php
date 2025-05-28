<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{

    public $table = 'anggota';
    public $column_order = array('no_mhs', 'nama', 'angkatan', 'status');
    public $column_search = array('no_mhs', 'nama', 'angkatan'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public $order = array('no_mhs' => 'desc'); // default order

    public $db_siprus;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_siprus = $this->load->database('siprus', true);
    }

    private function _get_datatables_query()
    {

        $this->db_siprus->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db_siprus->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db_siprus->like($item, $_POST['search']['value']);
                } else {
                    $this->db_siprus->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db_siprus->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db_siprus->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db_siprus->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db_siprus->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db_siprus->get();
        return $query->result();
    }

    public function getAnggotaById($no_mhs)
    {
        $this->db_siprus->from($this->table);
        $this->db_siprus->where('no_mhs', $no_mhs);
        $this->db_siprus->join('fakultas', 'fakultas.kd_fakultas = anggota.kd_fakultas', 'left');
        $query = $this->db_siprus->get();

        return $query->row_array();
    }

    public function getAnggotaBlokir($no_mhs)
    {   
        $this->db_siprus->from('anggota_blokir');
        $this->db_siprus->where('no_mhs', $no_mhs);
        $this->db_siprus->where('aktif_blokir', 1);
        $this->db_siprus->order_by('tgl_blokir', 'desc');
        $this->db_siprus->limit(1);
        $query = $this->db_siprus->get();
        return $query->row_array();
    

    }

}

/* End of file ModelName.php */