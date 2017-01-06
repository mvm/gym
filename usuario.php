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
<p><a href="?">Usuarios</a></p>
<div>
<?php
require "controllers/usuario.php";
?>
</div>
</body>
</html>

