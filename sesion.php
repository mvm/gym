<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p>Sesiones :: </p>
<div>
<?php
require "controllers/sesion.php";
?>
</div>
</body>
</html>

