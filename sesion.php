<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1>GYM</h1>
<p><a href="index.php">Página principal</a></p>
<p>Sesiones :: </p>
<div>
<?php
require "controllers/sesion.php";
?>
</div>
</body>
</html>

