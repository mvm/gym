<?php
class Notificacion {
  public $id, $nombre, $texto, $receptorId, $emisorId;

  function __construct($id, $nombre, $texto, $receptorId, $emisorId) {
    $this->$id = $id;
    $this->$nombre = $nombre;
    $this->$texto = $texto;
    $this->$receptorId = $receptorId;
    $this->$emisorId = $emisorId;
  }

  function insert() {
    return mysql_query("insert into notificacion values ($this->$id, " .
		       "'$this->$nombre', '$this->$texto', " .
		       "$this->$receptorId, $this->$emisorId)")
      or mysql_error();
  }

  function update() {
    return mysql_query("update notificacion set nombre = '$this->$nombre', " .
		       "texto = '$this->$texto', " .
		       "receptorId = $this->$receptorId, " .
		       "emisorId = $this->$emisorId " .
		       "where (id = $this->$id)")
      or mysql_error();
  }
  
  function delete() {
    return mysql_query("delete from notificacion where (id = $this->$id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from notificacion where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    return new Notificacion($id, $result[1], /* nombre */
			    $result[2], /* texto */
			    $result[3], /* receptorId */
			    $result[4]); // emisorId
			    
  }
}
?>