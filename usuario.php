<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p><a href="?">Usuarios</a> :: <?php
    if(isset($_SESSION) and $_SESSION["userTipo"] == 0) { // si es administrador
?>
        <a href="?a=crear">Crear</a>
<?php
    }
?></p>
<div>
<?php
require "controllers/usuario.php";
?>
</div>
</body>
</html>

