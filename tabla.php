<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<h1><a href="index.php">GYM</a></h1>
<p>Tablas :: </p>
<div>
<?php
require "controllers/tabla.php";
?>
</div>
</body>
</html>

