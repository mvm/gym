<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<head>
<title>GYM</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<h1><a href="index.php">GYM</a></h1>
<p>Notificaciones :: <a href="?">Inbox</a> : <a href="?a=enviar">Enviar</a></p><br/>
<?php
require "controllers/notificacion.php";
?>
</body>
</html>

