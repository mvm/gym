<?php
class Plaza {
  private $fecha, $actividadId, $usuarioId;

  function __construct($fecha, $actividadId, $usuarioId) {
    $this->$fecha = $fecha;
    $this->$actividadId = $actividadId;
    $this->$usuarioId = $usuarioId;
  }

  function insert() {
    return mysql_query("insert into plaza values ('$this->$fecha', " .
		       "$this->$actividadId, $this->$usuarioId)")
      or mysql_error();
  }
}
?>