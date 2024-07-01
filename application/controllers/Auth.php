<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{   
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
		$this->load->library('form_validation');
    }
    
	public function index()
	{
		show_404();
	}

	public function login()
	{
	     
		$rules = $this->auth_model->rules();
		// $this->form_validation->set_rules($rules);

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE){
			return $this->load->view('login_form');
		}
		else {
	    //    var_dump($this->input->post());die();
	    	$username = $this->input->post('username');
			$password = $this->input->post('password');
	
			if($this->auth_model->login($username, $password)){
				redirect('admin/dashboard');
			} else {
				$this->session->set_flashdata('message', 'Login Gagal, pastikan username dan passwrod benar!');
			}
			$this->load->view('login_form');
		}
	}

	public function logout()
	{
		$this->load->model('auth_model');
		$this->auth_model->logout();
		redirect(site_url('auth/login'));
	}
}