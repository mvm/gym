<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p>Notificaciones :: <a href="?">Inbox</a> : <a href="?a=enviar">Enviar</a></p><br/>
<div>
<?php
require "controllers/notificacion.php";
?>
</div>
</body>
</html>
