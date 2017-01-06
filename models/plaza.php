<?php
include_once "models/actividad.php";

class Plaza {
  public $id, $fecha, $actividadId, $usuarioId;

  function __construct($id, $fecha, $actividadId, $usuarioId) {
    $this->id = $id;
    $this->fecha = $fecha;
    $this->actividadId = $actividadId;
    $this->usuarioId = $usuarioId;
  }

  function insert() {
    return mysql_query("insert into plaza values ($this->id, '$this->fecha', " .
		       "$this->actividadId, $this->usuarioId)")
      or mysql_error();
  }

  function delete() {
    return mysql_query("delete from plaza where (id = $this->id)");
  }

  public function getActividad() {
      $q = mysql_query("select actividad.id from plaza, actividad where " .
      "(plaza.actividadId = actividad.id and plaza.id = $this->id)");
      $qr = mysql_fetch_row($q);
      if(!$qr) {
          print "<p>Mysql error: " . mysql_error() . "</p>\n";
          return null;
      }
      return Actividad::seek($qr[0]);
  }
  
  public static function consultarPlazas($idActividad) {
    $resultArray = array();
    $actividadQuery = mysql_query("select plaza.id from plaza, " .
				  "actividad where (plaza.actividadId = actividad.id " .
				  "and actividad.id = $idActividad)");
    if(mysql_error()) {
      echo "<p>" . mysql_error() . "</p>";
      return null;
    }
    while(($row = mysql_fetch_row($actividadQuery)) != false) {
      array_push($resultArray, Plaza::seek($result[0]));
    }
    return $resultArray;
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from plaza where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    return new Plaza($result[0], // id
		     $result[1], // fecha
		     $result[2], // actividadId
		     $result[3]); // usuarioId
  }
}
?>
