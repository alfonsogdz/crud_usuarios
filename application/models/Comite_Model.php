<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comite_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getComites()
    {
        $this->db->select("*");
        $this->db->from("comite");
        $query = $this->db->get();

        $data = $query->result_array();

        $icons = array(
            "fa fa-check",
            "fa fa-warning",
            "fa fa-x"
        );

        for ($i = 0; $i < count($data); $i++) {
            $id = $data[$i]['comites_id'];
            $estatus = $data[$i]['estatus_id'];
            $data[$i]['estatus_id'] = '<i class="' . $icons[$estatus - 1] . '" style="font-size:36px;"></i>';
            //$data['data'][$i]['actions'] = '<button type="button" class="btn btn-outline-primary edit-address" data-toggle="modal" onclick="initializeUpdateModal(' . $id . ');"><i class="fa fa-pencil fa-lg"></i></button>';
        }
        return $data;
    }

    public function insertComite($data)
    {
        $this->db->insert('comite', $data);
        $inserted_id = $this->db->insert_id();
        if ($inserted_id != 0) {
            $response = array(
                'ok' => true,
                'total' => 1,
                'data' => array(
                    'inserted_id' => $inserted_id
                )
            );
        }
        return $response;
    }

    public function getComitesById($id)
    {
        $response = $this->emptyResponse();
        $this->db->select("*");
        $this->db->from("comite");
        $this->db->where("comites_id", $id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();

        if ($num_rows > 0) {
            $response =  array(
                "ok" => true,
                'total' => $num_rows,
                'data' => $query->result_array()
            );
        }
        return $response;
    }

    public function updateComite($data, $id)
    {
        $response = $this->emptyResponse();
        $this->db->where('comites_id', $id);
        $this->db->update('comite', $data);
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows > 0) {
            $response = array(
                'ok' => true,
                'total' => $affected_rows,
                'data' => array(
                    'affected_rows' => $affected_rows
                )
            );
        }
        return $response;
    }

    public function deleteUser($id)
    {
        $response = $this->emptyResponse();
        $query = "UPDATE usuarios set estatus = 'I' where idUsuario = " . $id . "";
        $this->db->query($query);
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows > 0) {
            $response = array(
                'ok' => true,
                'total' => $affected_rows,
                'data' => array(
                    'affected_rows' => $affected_rows
                )
            );
        }
        return $response;
    }

    function getCommiteessById($user_id)
    {
        $query = "select comite_id from usuario_por_comite where usuario_id = " . $user_id . ";";

        $result = $this->db->query($query);

        return $result->result_array();
    }


    protected function emptyResponse()
    {
        return array(
            'ok' => false,
            'total' => 0,
            'data' => array()
        );
    }
    /*
    public function setAlumno(string $nocontrol, string $nombre ){
     

     return  $this->db->query("INSERT into alumno (nocontrol, nombre) values ({$nocontrol}, {$nombre})");
    }

    public function getAlumno(int $id){
      return $this->db->query("SELECT * from alumno where nocontrol = {$id}")->row();

    }

    public function updateAlumno(int $id, string $nombre){
      return $this->db->query("UPDATE alumno set nombre = {$nombre} where nocontrol = {$id}");

    }
    public function deleteAlumno(int $id){
      return $this->db->query("DELETE FROM alumno where nocontrol = {$id}");
    }
    */
}
