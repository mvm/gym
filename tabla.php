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
    <p><a href="?">Tablas</a> :: <?php
    if(isset($_SESSION) and $_SESSION["userTipo"] == 1) {
?>
<a href="?a=crear">Crear</a>
<?php
    }
?>
    </p>
<div>
<?php
require "controllers/tabla.php";
?>
</div>
</body>
</html>

