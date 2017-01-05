<?php
require "controllers/db.php";
require "models/sesion_entrenamiento.php";
require "models/usuario.php";
require "models/actividad.php";

if(isset($_SESSION["userId"])) {
    if($_SESSION["userTipo"] == 2) {
        $user = Usuario::seek($_SESSION["userId"]);
        $sesiones = $user->consultarEntrenamientos();

        foreach($sesiones as $sesion) {
            print "<div class='sesionEntrenamiento'>\n";
            print "<span class='sesionNombre'>$sesion->nombre</span>";
            print "<span class='sesionInicio'>$sesion->inicio</span>";
            print "<span class='sesionFin'>$sesion->fin</span>";
            print "<br/>";

            $actividad = Actividad::seek($sesion->actividadId);
            $entrenador = Usuario::seek($sesion->entrenadorId);

            print "<span class='sesionEntrenador'>$entrenador->nombre ($entrenador->correo)</span>";
            print "<span class='sesionActividad'>$actividad->nombre</span>";
            
            print "</div>";
        }

    } else {
        print "<p>No eres un deportista. <a href='index.php?a=logout'>Desconectar</a>.</p>\n";
    }
} else {
    print "<p>No conectado. <a href='index.php'>Login</a>.</p>\n";
}

?>