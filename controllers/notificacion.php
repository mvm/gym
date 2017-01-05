<?php
require "controllers/db.php";
require "models/usuario.php";

function mostrar_notificaciones() {
    $user = Usuario::seek($_SESSION["userId"]);
    $notifs = $user->consultarNotificacionesRecibidas();
    if(!$notifs) {
        print "<p>No se han recibido notificaciones.</p>\n";
    } else {
        $numNot = count($notifs);
        print "Lista de notificaciones ($numNot):<br/>\n";
        foreach($notifs as $n) {
            print '<div class="notificacion">\n';
            print "<p>$n->nombre : $n->texto</p>\n";
            print '</div>\n';
        }
    }
}
?>