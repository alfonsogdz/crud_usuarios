<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
				'User_Model' => 'user_model',
				'Comite_Model' => 'comite_model'
			)
		);
	}
	public function index()
	{
		$this->load->view('shared/navbar');
		$comites = $this->comite_model->getComites();
		$data = array(
			'comites' => $comites,
		);
		$this->load->view('user_table', $data);
	}

	public function getUsers()
	{
		//$data = $this->input->post();
		$response = $this->user_model->getUsers();
		echo json_encode($response);
	}

	public function insertUser()
	{
		// $data = $this->input->post();
		// $response = $this->user_model->insertUser($data);
		// echo json_encode($response);

		$data = $this->input->get();
		$commites = explode('-', $data['commite']);
		$response = $this->user_model->insertUser($data, $commites);
		echo json_encode($response);
	}

	public function getUserById()
	{
		$idUsuario = $this->input->post('idUsuario');

		$response = $this->user_model->getUserById($idUsuario);
		echo json_encode($response);
	}

	public function updateUser()
	{
		$data = $this->input->get();

        $commites = explode('-', $data['commite']);

        $response = $this->user_model->updateUser($data, $commites);

        echo json_encode($response);
	}

	public function deleteUser()
	{
		$idUsuario = $this->input->post('idUsuario');

		$response = $this->user_model->deleteUser($idUsuario);
		echo json_encode($response);
	}
	public function getCommitesByUser(){
		$idUsuario = $this->input->post('id');

		$response = $this->user_model->getCommiteessById($idUsuario);
		echo json_encode($response);

	}
}
