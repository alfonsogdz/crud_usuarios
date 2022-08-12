<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function getUsers()
  {
    $this->db->select("*");
    $this->db->from("usuarios");
    $query = $this->db->get();

    return $query->result_array();
  }

  public function insertUser($data, $comite)
  {
    $query = "insert into usuarios (nombre, apellido, procedencia, contrasenia, usuario, estatus) values ('" . $data['nameUser'] . "','" . $data['lastName'] . "','"  . $data['txtProcedencia']  . "', '" . md5($data['password']) . "','" . $data['txtUser'] . "', '" . $data['selStatus'] . "')";

    $result = $this->db->query($query);

    if ($result == 1) {
      $new_id = $this->db->insert_id();
      for ($i = 0; $i < count($comite); $i++) {
        $query = "insert into usuario_por_comite(usuario_id, comite_id)
        values(" . $new_id . ", " . $comite[$i] .  ")";
        $result = $this->db->query($query);
      }
      if ($result == 1) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

  public function getUserById($id)
  {
    $response = $this->emptyResponse();
    $this->db->select("*");
    $this->db->from("usuarios");
    $this->db->where("idUsuario", $id);
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

  public function updateUser($data, $comites)
  {
    $query = "select contrasenia from usuarios where idUsuario=" . $data['user_id'];
    $pwd = $this->db->query($query);
    $pwd = $pwd->result_array();
    $pwd = $pwd[0]['contrasenia'];



    $query = "update
                        usuarios
                    set
                        usuario = '" . $data['txtUser'] . "',
                        nombre = '" . $data['nameUser'] . "',
                        apellido = '" . $data['lastName'] . "',";

    if ($pwd != $data['password']) {
      $query .= "contrasenia = '" . md5($data['password']) . "', ";
    }

    $query .= "estatus = '" . $data['selStatus'] . "',
                        procedencia = '" . $data['txtProcedencia'] . "'
                    where idUsuario = " . $data['user_id'] . ";";

    $result = $this->db->query($query);

    if ($result == 1) {
      $query = "delete from usuario_por_comite
              where usuario_id = " . $data['user_id'] . ";";
      $result = $this->db->query($query);

      for ($i = 0; $i < count($comites); $i++) {
        $query = "insert into usuario_por_comite(usuario_id, comite_id)
              values(" . $data['user_id'] . ", " . $comites[$i] . ")";
        $result = $this->db->query($query);
      }

      if ($result == 1) {
        return 1;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
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

  function getusersActivos(){
    $query = "SELECT COUNT(*) as total from usuarios where estatus = 'A'";

    $result = $this->db->query($query);

    return $result->result_array();

  }
  function getusersInactivos(){
    $query = "SELECT COUNT(*) as total from usuarios where estatus = 'I'";

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
