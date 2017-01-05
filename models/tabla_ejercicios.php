<?php
class TablaEjercicios {
  public $id, $nombre, $tipo, $dificultadGlobal, $actividadId;

  function __construct($id, $nombre, $tipo, $dificultadGlobal, $actividadId) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->tipo = $tipo;
    $this->dificultadGlobal = $dificultadGlobal;
    $this->actividadId = $actividadId;
  }

  function insert() {
    return mysql_query("insert into tablaEjercicios values " .
		       "($this->id, '$this->nombre', $this->tipo, " .
		       "$this->dificultadGlobal, $this->actividadId)")
      or mysql_error();
  }

  function update() {
    return mysql_query("update tablaEjercicios set nombre = '$this->nombre', " .
		       "tipo = $this->tipo, dificultadGlobal = $this->dificultadGlobal, " .
		       "actividadId = $this->actividadId " .
		       "where (id = $this->id)")
      or mysql_error();
  }

  function delete() {
    return mysql_query("delete from tablaEjercicios where (id = $this->id)")
      or mysql_error();
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from tablaEjercicios where (id = $id)");
    if(mysql_error()) return mysql_error();
    $result = mysql_fetch_row($resultQuery);
    return new TablaEjercicios($result[0], // id
			       $result[1], // nombre
			       $result[2], // tipo
			       $result[3], // dificultadGlobal
			       $result[4]); // actividadId
  }

  public function asignar($deportistaId) {
    return mysql_query("insert into usuario_esAsignado_tablaEjercicios values " .
		"( $deportistaId, $this->id )");
  }
}
?>
