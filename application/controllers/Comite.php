<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comite extends CI_Controller
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
				'Comite_Model' => 'comite_model',
			)
		);
	}
	public function index()
	{
		$name = $_SESSION['nombre'];
		$data = array(
			'view' => 'comite/comite_table',
			'nombre' => $name
		);
		$this->load->view('dashboard', $data);
	}

	public function getComites()
	{
		//$data = $this->input->post();
		$response = $this->comite_model->getComites();
		echo json_encode($response);
	}

	public function insertComite()
	{
		

		$data = $this->input->post('data');
		$response = $this->comite_model->insertComite($data);
		echo json_encode($response);
	}

	public function getComiteById()
	{
		$comites_id = $this->input->post('comites_id');

		$response = $this->comite_model->getComitesById($comites_id);
		echo json_encode($response);
	}

	public function updateComite()
	{
		$data = $this->input->post('data');
        $id = $this->input->post('id');

        $response = $this->comite_model->updateComite($data, $id);

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
