<?php
require "controllers/db.php";
require "models/tabla_ejercicios.php";
require "models/usuario.php";
require "models/actividad.php";

if(isset($_SESSION["userId"])) {

    if($_SESSION["userTipo"] == 2) { // deportista
        $user = Usuario::seek($_SESSION["userId"]);
        $tablas = $user->consultarTablas();

        if(count($tablas) == 0) {
            print "<p>No hay tablas asignadas a tí.</p>\n";
        } else {
            foreach($tablas as $tabla) {
                print "<div class='tablaEjercicio'>\n";
                print "<span class='tablaNombre'>$tabla->nombre</span>\n";
                print "<span class='tablaDificultad'>(Dif. $tabla->dificultadGlobal)</span>\n";
                $actividad = Actividad::seek($tabla->actividadId);
                print "<span class='tablaActividad'>$actividad->nombre</span>\n";

                print "<br/>";

                $ejercicios = $tabla->consultarEjercicios();

                foreach($ejercicios as $e) {
                    print "<div class='ejerciciosTabla'>\n";

                    print "<span class='ejercicioNombre'>$e->nombre</span><br/>\n";
                    print "<span class='ejercicioDescripcion'>$e->descripcion</span>\n";
                    
                    print "</div>";
                }
                
                print "</div>";
            }
        }
    }
    
} else {
    print "<p>No conectado. <a href='index.php'>Login</a>.</p>\n";
}
?>