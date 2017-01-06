<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p>Plazas :: <a href="?">Ver</a> : <a href="?a=solicitar">Solicitar</a></p>
<div>
<?php
require "controllers/plaza.php";
?>
</div>
</body>
</html>

