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
<body>
<h1>GYM</h1>
<div>
<?php
require "controllers/login.php";
?>
</div>
</body>
</html>

