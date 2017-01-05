<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<div>
<?php
require "controllers/notificacion.php";

if(isset($_SESSION["userId"])) {
    mostrar_notificaciones();
}
?>
</div>
</body>
</html>

