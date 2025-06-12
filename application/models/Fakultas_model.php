<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fakultas_model extends CI_Model
{

    public $db_siprus;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_siprus = $this->load->database('siprus', true);
    }


    public function getFakultas()
    {
        $this->db_siprus->from('fakultas');
        // $this->db_siprus->where('no_mhs', $no_mhs);
        // $this->db_siprus->join('fakultas', 'fakultas.kd_fakultas = anggota.kd_fakultas', 'left');
        $this->db_siprus->order_by('fakultas', 'ASC');
        $query = $this->db_siprus->get();

        return $query->row_array();
    }

    public function get_daftar_fakultas()
    {
        $this->db->select('*');
        $this->db->from('fakultas');
        $this->db->group_by('fakultas');
        $this->db->order_by('fakultas', 'ASC');

        return $this->db->get()->result();
    }

    public function get_daftar_fakultas_like($searchTerm)
    {
        $this->db->select('*');
        $this->db->from('fakultas');
        $this->db->group_by('fakultas');
        $this->db->like('fakultas', $searchTerm);
        $this->db->order_by('fakultas', 'ASC');
        return $this->db->get()->result();
    }


    public function get_daftar_jurusan()
    {
        $this->db->select('jurusan');
        $this->db->from('fakultas');
        $this->db->order_by('jurusan', 'ASC');

        return $this->db->get()->result();
    }

    public function get_daftar_jurusan_like($searchTerm)
    {
        $this->db->select('*');
        $this->db->from('fakultas');
        $this->db->like('jurusan', $searchTerm);
        $this->db->order_by('jurusan', 'ASC');

        return $this->db->get()->result();
    }
}

/* End of file ModelName.php */