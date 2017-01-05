<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<p><a href="?">Inbox</a> : <a href="?a=enviar">Enviar</a></p><br/>
<div>
<?php
require "controllers/notificacion.php";
?>
</div>
</body>
</html>

