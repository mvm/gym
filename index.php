<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}

if(isset($_REQUEST["a"]) and $_REQUEST["a"] == "logout") {
    session_destroy();
    unset($_SESSION);
}

?>
<html>
<head>
<title>GYM</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<h1><a href="?">GYM</a></h1>
<div>
<?php
require "controllers/login.php";
?>
</div>
</body>
</html>

