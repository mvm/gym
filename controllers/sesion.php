<?php
require "controllers/db.php";
require "models/sesion_entrenamiento.php";
require "models/usuario.php";
//require "models/actividad.php";
//require "models/sesion_entrenamiento.php";

function mostrar_sesion($sesion, $entrena = false) {
    print "<div class='sesionEntrenamiento'>\n";
    print "<span class='sesionNombre'>$sesion->nombre</span>";
    print "<span class='sesionInicio'>$sesion->inicio</span>";
    print "<span class='sesionFin'>$sesion->fin</span>";
    print "<br/>";
    
    $actividad = Actividad::seek($sesion->actividadId);
    $entrenador = Usuario::seek($sesion->entrenadorId);

    if($entrena == false) {
        print "<span class='sesionEntrenador'>$entrenador->nombre ($entrenador->correo)</span>";
    }
    print "<span class='sesionActividad'>$actividad->nombre</span>";

    if($entrena) {
        print "<span class='sesionDeportista'><a href='?a=asignar&sesion=$sesion->id'>Asignar deportista</a></span>";
    }
    
    print "</div>";
}

function mostrar_formulario_sesion() {
?>
    <div class="crearSesionForm">
    <form action="?a=creada" method="post">
    <label for="nombre">Nombre: </label> <input type="text" name="nombre"/><br/>
    <label for="actividad">Actividad: </label> <select name="actividad" required>
<?php
    $actividades = Actividad::get();

    foreach($actividades as $a) {
        print "<option value=\"$a->id\">$a->nombre</option>\n";
    }
?>
    </select><br/>
    <label for="inicio">Inicio: </label> <input type="date" name="inicio"/><br/>
    <label for="fin">Fin: </label> <input type="date" name="fin"/></br>
    <input type="submit" value="Crear"/>
    </form>
    </div>
<?php
}

function mostrar_formulario_asignar() {
    $sesion = SesionEntrenamiento::seek($_REQUEST["sesion"]);
?>
    <div class="asignarSesionForm">
    <p>Asignar sesion <?= $sesion->id ?> a deportista:</p>
    <form action="?a=asignada&sesion=<?= $sesion->id?>" method="post">
    <label for="usuario">Deportista: </label> <select name="usuario" required>
<?php
    $deportistas = Usuario::get(2);

    foreach($deportistas as $d) {
        print "<option value=\"$d->id\">$d->apellidos, $d->nombre</option>\n";
    }
?>
    </select></br>
    <input type="submit" value="Asignar"/>
    </form>
    </div>
<?php
}

if(isset($_SESSION["userId"])) {
    $user = Usuario::seek($_SESSION["userId"]);
    
    if($_SESSION["userTipo"] == 2) {
        $sesiones = $user->consultarEntrenamientos();

        foreach($sesiones as $sesion) {
            mostrar_sesion($sesion);
        } 
    }else if($_SESSION["userTipo"] == 1) { // entrenador
        if(!isset($_REQUEST["a"])) { // listar sesiones
            $sesiones = $user->consultarEntrenamientos(true);
            
            foreach($sesiones as $sesion) {
                mostrar_sesion($sesion, true);
            }
        } else if($_REQUEST["a"] == "crear") {
            mostrar_formulario_sesion();
        } else if($_REQUEST["a"] == "creada") {
            $sesion = new SesionEntrenamiento(0, $_REQUEST["inicio"], $_REQUEST["fin"],
            $_REQUEST["nombre"], $_REQUEST["actividad"], $_SESSION["userId"]);
            $sesion->insert();
            print "<p>Sesion creada con éxito.</p>\n";
        } else if($_REQUEST["a"] == "asignar") {
            mostrar_formulario_asignar();
        } else if($_REQUEST["a"] == "asignada") {
            $sesion = SesionEntrenamiento::seek($_REQUEST["sesion"]);
            $sesion->asignar($_REQUEST["usuario"]);

            print "<p>Usuario asignado con éxito.</p>\n";
        }
    } else {
        print "<p>No eres un deportista. <a href='index.php?a=logout'>Desconectar</a>.</p>\n";
    }
} else {
    print "<p>No conectado. <a href='index.php'>Login</a>.</p>\n";
}

?>