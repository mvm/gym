<?php
class Actividad {
  public $id, $nombre, $numPlazasMax;

  function __construct($id, $nombre, $numPlazasMax) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->numPlazasMax = $numPlazasMax;
  }

  function insert() {
    return mysql_query("insert into actividad values ($this->id, " .
		       "'$this->nombre', $this->numPlazasMax)")
      or mysql_query();
  }

  function update() {
    return mysql_query("update actividad set nombre = '$this->nombre', " .
		       "numPlazasMax = $this->numPlazasMax " .
		       "where (id = $this->id)")
      or mysql_error();
  }

  function delete() {
      return mysql_query("delete from actividad where (id = $this->id)");
  }

  public static function seek($id) {
    $resultQuery = mysql_query("select * from actividad where (id = $id)");
    if(mysql_error()) return mysql_error();
    $result = mysql_fetch_row($resultQuery);
    return new Actividad($result[0], $result[1], $result[2]);
  }

  public static function get() {
      $result = array();
      $q = mysql_query("select id from actividad");
      if(mysql_error()) {
          print "<p>Mysql error: " . mysql_error() . "</p>\n";
          return null;
      }
      while($qr = mysql_fetch_row($q)) {
          array_push($result, Actividad::seek($qr[0]));
      }
      return $result;
  }
}
?>
