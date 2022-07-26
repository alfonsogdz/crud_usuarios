<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
				'User_Model' => 'user_model',
				'Comite_Model' => 'comite_model',
			)
		);
	}
	public function index()
	{
		$name = $_SESSION['nombre'];
		$data = array(
			'nombre' => $name,
			'usersActivos' => $this->user_model->getUsersActivos(),
			'comitesActivos' => $this->comite_model->getComitesActivos(),
			'usersInactivos' => $this->user_model->getUsersInactivos(),
			'comitesInactivos' => $this->comite_model->getComitesInactivos(),

		);
        $this->load->view('dashboard', $data);
	}
}
