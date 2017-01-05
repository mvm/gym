<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1>GYM</h1>
<p><a href="index.php">Página principal</a></p>
<p>Notificaciones :: <a href="?">Inbox</a> : <a href="?a=enviar">Enviar</a></p><br/>
<div>
<?php
require "controllers/notificacion.php";
?>
</div>
</body>
</html>

