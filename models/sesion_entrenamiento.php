<?php
class SesionEntrenamiento {
  public $id, $inicio, $fin, $nombre, $actividadId, $entrenadorId;

  function __construct($id, $inicio, $fin, $nombre, $actividadId, $entrenadorId) {
    $this->id = $id;
    $this->inicio = $inicio;
    $this->fin = $fin;
    $this->nombre = $nombre;
    $this->actividadId = $actividadId;
    $this->entrenadorId = $entrenadorId;
  }

  function asignar($deportistaId) {
      return mysql_query("insert into usuario_asiste_entrenamiento values " .
      "($deportistaId, $this->id)");
  }
  
  function insert() {
    return mysql_query("insert into sesionEntrenamiento values " .
		       "( $this->id, '$this->inicio', '$this->fin', " .
		       "'$this->nombre', $this->actividadId, " .
		       "$this->entrenadorId)")
      or mysql_error();
  }

  function update() {
    return mysql_query("update sesionEntrenamiento set " .
		       "inicio = '$this->inicio', " .
		       "fin = '$this->fin', " .
		       "nombre = '$this->nombre', " .
		       "actividadId = $this->actividadId, " .
		       "entrenadorId = $this->entrenadorId " .
		       "where (id = $this->id)")
      or mysql_query();
  }

  function delete() {
    return mysql_query("delete from sesionEntrenamiento where (id = $this->id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from sesionEntrenamiento where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    return new SesionEntrenamiento($id, $result[1], // inicio
				   $result[2], // fin
				   $result[3], // nombre
				   $result[4], // actividadId
				   $result[5]); // entrenadorId
  }
}
?>
