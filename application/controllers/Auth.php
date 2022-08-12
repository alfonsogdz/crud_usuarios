<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model(
			array(
				'Auth_Model' => 'auth_model',
			)
		);
	}
	public function index()
	{
		$this->load->view('shared/login');
	}

	public function ingresar()
	{
		$user = trim($this->input->post('inputUser'));
		$pass = trim($this->input->post('inputPassword'));

		$this->session->set_flashdata('txtUser', $user);
		if (!isset($user) || !strlen($user)) {
			$this->session->set_flashdata('errorMessage', 'Ingrese su nombre de usuario');
			redirect(site_url('auth'));
		}
		if (!isset($pass) || !strlen($pass)) {
			$this->session->set_flashdata('errorMessage', 'Ingrese su contraseña');
			redirect(site_url('auth'));
		}

		$response = $this->auth_model->ingresar($user, $pass);
		
		#echo json_encode($response);

		if ($response['ok']) {
			$this->session->set_userdata($response['data']['userData']);

			//redirect(site_url('dashboard'));
			redirect('dashboard', 'refresh');
		}else{
			$this->session->set_flashdata('errorMessage', $response['message']);
			redirect(site_url('auth'));
		}
		
	}

	public function salir()
	{
		$this->session->unset_userdata('userData');
		$this->session->sess_destroy();
		redirect('auth');
	}
}
