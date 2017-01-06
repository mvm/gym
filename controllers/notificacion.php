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
        print "<p>Lista de notificaciones ($numNot):</p>\n";
        foreach($notifs as $n) {
            print '<div class="notificacion">';
            $emisor = Usuario::seek($n->emisorId);
            print "<span class='emisorNotif'>De: $emisor->correo</span></br>\n";
            print "<span class='contenidoNotif'>$n->nombre : $n->texto</span>\n";
            print '</div>';
        }
    }
}

function mostrar_formulario_envio() {
?>
    <div class="envioNotificacionForm">
    <p>Enviar notificacion:</p>
    <form action="?a=enviado" method="post">
  A: <input type="text" name="destino"/></br>
  Asunto: <input type="text" name="asunto"/></br>
  Texto:</br><textarea name="texto">...</textarea></br>
    <input type="submit" value="Enviar"/>
    </form>
    </div>
<?php
}

if(isset($_SESSION["userId"])) {
    if(!isset($_REQUEST["a"])) {
        mostrar_notificaciones();
    } else if($_REQUEST["a"] == "enviar") {
        mostrar_formulario_envio();
    } else if($_REQUEST["a"] == "enviado") {
        $notif = new Notificacion(0, $_REQUEST["asunto"], $_REQUEST["texto"], 0, $_SESSION["userId"]);
        $destino = Usuario::getByEmail($_REQUEST["destino"]);

        if(!$destino) {
            print "<p>Usuario $_REQUEST[destino] no encontrado.</p>\n";
            goto envio_error;
        }

        $notif->receptorId = $destino->id;
        $notif->insert();

        print "<p>Mensaje enviado a $destino->correo con éxito.</p>\n";

        if(false) {
          envio_error:
            mostrar_formulario_envio();
        }
    }
} else {
    echo '<p>No estas conectado al sistema. <a href="/index.php">Volver</a></p>';
}
?>