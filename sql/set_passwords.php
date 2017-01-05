<?php
include "controllers/cli.php";
include "models/usuario.php";
include "controllers/db.php";

if(!isset($_REQUEST["id"]) or !isset($_REQUEST["password"])) {
    print "Especificar id= password=\n";
    die;
}

$user = Usuario::seek($_REQUEST["id"]);
if($user == null) {
    print "Usuario $_REQUEST[id] no encontrado.\n";
    die;
}
print "Usuario $user->correo \n";
$user->password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
print "Password hash: '$user->password'\n";
$user->update();

?>