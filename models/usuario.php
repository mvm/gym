<?php
include "models/notificacion.php";
include_once "models/sesion_entrenamiento.php";
include_once "models/tabla_ejercicios.php";
include_once "models/plaza.php";

class Usuario {
  public $id, $nombre, $apellidos, $dni, $correo, $tipo, $password;

  function __construct($id, $nombre, $apellidos, $dni, $correo, $tipo, $password) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->apellidos = $apellidos;
    $this->dni = $dni;
    $this->correo = $correo;
    $this->tipo = $tipo;
    $this->password = $password;
  }

  function insert() {
    return mysql_query("insert into usuario values ($this->id," .
		       "'$this->nombre', '$this->apellidos'," .
		       "'$this->dni', '$this->correo', $this->tipo, " .
		       "'$this->password')")
      or mysql_error();
  }

  function update() {
    return mysql_query("update usuario set nombre = '$this->nombre'," .
		       "apellidos = '$this->apellidos'," .
		       "dni = '$this->dni', correo = '$this->correo'," .
		       "tipo = '$this->tipo', password = '$this->password' " .
    "where (id = $this->id)");
  }

  function delete() {
    return mysql_query("delete from usuario where (id = $this->id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from usuario where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    if(!$result) {
        return null;
    }
    return new Usuario($id, $result[1], $result[2], $result[3], $result[4],
		       $result[5], $result[6]);
  }

  function consultarNotificacionesRecibidas() {
    $resultArray = array();
    $resultQuery = mysql_query("select notificacion.id from usuario, notificacion " .
			       "where (usuario.id = notificacion.receptorId " .
			       "and usuario.id = $this->id)");
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
			       "and usuario.id = $this->id");
    if(mysql_error()) {
      echo "<p>" . mysql_error() . "</p>";
      return null;
    }
    while(($result = mysql_fetch_row($resultQuery)) != false) {
      array_push($resultArray, Notificacion::seek($result[0]));
    }
    return $resultArray;
  }

  public function consultarEntrenamientos($entrena = false) {
      $result = array();
      if($entrena) {
          $q = mysql_query("select id from sesionEntrenamiento where (entrenadorId = $this->id)");
      } else {
          $q = mysql_query("select sesionEntrenamientoId from usuario, usuario_asiste_entrenamiento where (usuario.id = usuario_asiste_entrenamiento.usuarioId and usuario.id = $this->id)");
      }
      while($qr = mysql_fetch_row($q)) {
          array_push($result, SesionEntrenamiento::seek($qr[0]));
      }
      return $result;
  }

  public function consultarTablas() {
      $result = array();
      if($this->tipo == 2) {
          $q = mysql_query("select tablaEjerciciosId from usuario, usuario_esAsignado_tablaEjercicios where (usuario.id = usuario_esAsignado_tablaEjercicios.usuarioId and usuario.id = $this->id)");
      } else if($this->tipo == 1) {
          $q = mysql_query("select id from tablaEjercicios");
      } else {
          return null;
      }
      while($qr = mysql_fetch_row($q)) {
          array_push($result, TablaEjercicios::seek($qr[0]));
      }
      return $result;
  }

  public function consultarPlazas() {
      $result = array();
      $q = mysql_query("select plaza.id from plaza, usuario where " .
      "(plaza.usuarioId = usuario.id and usuario.id = $this->id)");
      while($qr = mysql_fetch_row($q)) {
          array_push($result, Plaza::seek($qr[0]));
      }
      return $result;
  }
  
  // Tomar todos los usuarios.
  public static function get($tipo = -1) { 
    $resultArray = array();
    if($tipo > -1) { // si tipo especificado
        $q = mysql_query("select id from usuario where (tipo = $tipo) order by id");
    } else {
        $q = mysql_query("select id from usuario order by id");
    }
    while(($result = mysql_fetch_row($q)) != false) {
      array_push($resultArray, Usuario::seek($result[0]));
    }
    return $resultArray;
  }

  public static function getByEmail($email) {
    $q = mysql_query("select id from usuario where (correo = '$email')");
    if($q == false) {
      echo mysql_error();
      return null;
    }
    if(($u = mysql_fetch_row($q)) == false) {
      return null;
    }
    return Usuario::seek($u[0]);
  }
}
?>
