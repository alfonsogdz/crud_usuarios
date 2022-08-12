<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function ingresar($user, $pass)
    {
        $query = $this->db->query("SELECT * FROM usuarios where estatus = 'A' 
        and usuario = '".$user."' and contrasenia = '".md5($pass)."'");

        $arrData['userData'] = $query->row_array();
        $userCount = $query->num_rows();
        $response = array(
            'ok' => $userCount > 0 ? true : false,
            'message' => $userCount > 0 ? 'success' : 'Credenciales incorrectas',
            'data' => $arrData
        );

        return $response;
    }
}
