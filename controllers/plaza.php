<?php
require "controllers/db.php";
require "models/usuario.php";

function mostrar_solicitar_form() {
?>
        <div class="solicitarPlazaForm">
        <form action="?a=solicitada" method="post">
        <label for="actividad">Actividad:</label> <select name="actividad" required>
<?php
        $actividades = Actividad::get();

        foreach($actividades as $a) {
            print "<option value=\"$a->id\">$a->nombre</option>\n";
        }
?>
        </select>
        <label for="fecha">Fecha:</label> <input type="date" name="fecha"/>
        <input type="submit" value="Solicitar"/>
        </form>
        </div>
<?php
}

if(isset($_SESSION["userId"])) {
    $user = Usuario::seek($_SESSION["userId"]);

    if(!isset($_REQUEST["a"])) { // mostrar plazas del usuario o del sistema
        if($_SESSION["userTipo"] == 2) { // deportista
            $plazas = $user->consultarPlazas();
            
            foreach($plazas as $p) {
                $actividad = $p->getActividad();
                
                print '<div class="plaza">';
                print "<span class='plazaActividad'>$actividad->nombre</span>\n";
                print "<span class='plazaFecha'>$p->fecha</span>\n";
                print "</div>\n";
            }
        }
    } else if($_REQUEST["a"] == "solicitar") {
        mostrar_solicitar_form();
    } else if($_REQUEST["a"] == "solicitada") {
        if(!isset($_REQUEST["actividad"]) or !isset($_REQUEST["fecha"])) {
            print "<p>Actividad o fecha no especificadas.</p>\n";
            mostrar_solicitar_form();
        } else {
            $plaza = new Plaza(0, $_REQUEST["fecha"], $_REQUEST["actividad"],
            $_SESSION["userId"]);
            $plaza->insert();

            print "<p>Plaza solicitada con éxito.</p>\n";
        }
    }
} else {
    print "<p>No conectado. <a href='index.php'>Login</a>.</p>\n";
}

?>