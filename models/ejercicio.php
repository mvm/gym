<?php
class Ejercicio {
  private $id, $nombre, $descripcion, $imagen, $video, $dificultad;

  function __construct($id, $nombre, $descripcion, $imagen, $video, $dificultad) {
    $this->$id = $id;
    $this->$nombre = $nombre;
    $this->$descripcion = $descripcion;
    $this->$imagen = $imagen;
    $this->$video = $video;
    $this->$dificultad = $dificultad;
  }

  function insert() {
    return mysql_query("insert into ejercicio values ($this->$id, " .
		       "'$this->$nombre', '$this->$descripcion', " .
		       "x'$this->$imagen', x'$this->$video', $this->$dificultad)")
      or mysql_error();
  }

  function update() {
    return mysql_query("update ejercicio set nombre = '$this->$nombre', " .
		       "descripcion = '$this->$descripcion', " .
		       "imagen = x'$this->$imagen', " .
		       "video = x'$this->$video', " .
		       "dificultad = $this->$dificultad " .
		       "where (id = $this->$id)");
  }

  function delete() {
    return mysql_query("delete from ejercicio where (id = $this->$id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from ejercicio where (id = $id)");
    $result = mysql_fetch_row($resultQuery);
    return new Ejercicio($result[0], // id
			 $result[1], // nombre
			 $result[2], // descripcion
			 $result[3], // imagen
			 $result[4], // video
			 $result[5]); // dificultad
  }
}
?>