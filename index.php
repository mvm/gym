<?php
if(!isset($_SESSION["userId"])) {
    session_start();
}
?>
<html>
<body>
<div>
<?php
require "controllers/login.php";
?>
</div>
</body>
</html>

