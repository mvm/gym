<?php

include "notificacion.php";

class Usuario {
  private $id, $nombre, $apellidos, $dni, $correo, $tipo;

  function __construct($id, $nombre, $apellidos, $dni, $correo, $tipo) {
    $this->$id = $id;
    $this->$nombre = $nombre;
    $this->$apellidos = $apellidos;
    $this->$dni = $dni;
    $this->$correo = $correo;
    $this->$tipo = $tipo;
  }

  function insert() {
    return mysql_query("insert into usuario values ($this->$id," .
		       "'$this->$nombre', '$this->$apellidos'," .
		       "'$this->$dni', '$this->$correo', $this->$tipo)")
      or mysql_error();
  }

  function update() {
    return mysql_query("update usuario set nombre = '$this->$nombre'," .
		       "apellidos = '$this->$apellidos'," .
		       "dni = '$this->$dni', correo = '$this->$correo'," .
		       "tipo = '$this->$tipo' where (id = $this->$id)")
      or mysql_error();
  }

  function delete() {
    return mysql_query("delete from usuario where (id = $this->$id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from usuario where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    return new Usuario($id, $result[1], $result[2], $result[3], $result[4],
		       $result[5]);
  }

  function consultarNotificacionesRecibidas() {
    $resultArray = array();
    $resultQuery = mysql_query("select notificacion.id from usuario, notificacion " .
			       "where (usuario.id = notificacion.receptorId " .
			       "and usuario.id = $this->$id)");
    if(mysql_error()) {
      echo "<p>" . mysql_error() . "</p>";
      return null;
    }
    while(($result = mysql_fetch_row($resultQuery)) != false) {
      array_push($resultArray, Notificacion::seek($result[0]));
    }
    return $resultArray;
  }

  function consultarNotificacionesEnviadas() {
    $resultArray = array();
    $resultQuery = mysql_query("select notificacion.id from usuario, notificacion " .
			       "where (usuario.id = notificacion.emisorId " .
			       "and usuario.id = $this->$id");
    if(mysql_error()) {
      echo "<p>" . mysql_error() . "</p>";
      return null;
    }
    while(($result = mysql_fetch_row($resultQuery)) != false) {
      array_push($resultArray, Notificacion::seek($result[0]));
    }
    return $resultArray;
  }
}
?>