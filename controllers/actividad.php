<?php
require "controllers/db.php";
require "models/actividad.php";
require "models/usuario.php";

function listar_actividades() {
?>
    <div>
<?php
    $actividades = Actividad::get();

    foreach($actividades as $a) {
?>
        <div class="actividad">
        <span class="actividadNombre"><?=$a->nombre?></span>
        <span class="actividadPlazasMax">Plazas: <?=$a->numPlazasMax?></span>
<?php
        if($_SESSION["userTipo"] == 1) {
?>
<form action="?a=eliminar_actividad" method="post">
<input type="hidden" name="actividad" value=<?='"'.$a->id.'"'?>>
<input type="submit" value="Eliminar" class="smallButton">
</form>
<?php
        }
?>
        </div>
<?php
    }
?>
    
    </div>
<?php
}

function mostrar_formulario_crear() {
?>
    <div class="crearActividadForm">
    <form action="?a=creada" method="post">
    <label for="nombre">Nombre: </label> <input type="text" name="nombre"/></br>
    <label for="plazasMax">Num. plazas: </label> <input type="text" name="plazasMax"/></br>
    <input type="submit" value="Crear"/>
    </form>
    </div>
<?php
}

if(isset($_SESSION["userId"])) {
    if($_SESSION["userTipo"] == 1) { // entrenador
        if(!isset($_REQUEST["a"])) {
            listar_actividades();
        } else if($_REQUEST["a"] == "crear") {
            mostrar_formulario_crear();
        } else if($_REQUEST["a"] == "creada") {
            $actividad = new Actividad(0, $_REQUEST["nombre"], $_REQUEST["plazasMax"]);
            $actividad->insert();
            print "<p>Actividad creada con éxito.</p>\n";
        } else if($_REQUEST["a"] == "eliminar_actividad") {
            $actividad = Actividad::seek($_REQUEST["actividad"]);
            if($actividad->delete()) {
                print "<p>Actividad eliminada con éxito.</p>";
            } else {
                print "<p>Error: " . mysql_error() . "</p>";
            }
        }
    }
} else {
    print "<p>No estás <a href='index.php'>conectado</a>.</p>\n";
}

?>