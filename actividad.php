<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p><a href="?">Actividad</a> :: <?php
    if(isset($_SESSION) and $_SESSION["userTipo"] == 1) { // si es entrenador
?>
        <a href="?a=crear">Crear</a>
<?php
    }
?></p>
<div>
<?php
require "controllers/actividad.php";
?>
</div>
</body>
</html>

