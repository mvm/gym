<?php
require "controllers/db.php";
require "models/tabla_ejercicios.php";
require "models/usuario.php";
//require "models/actividad.php";

function mostrar_tabla($tabla) {
    print "<div class='tablaEjercicio'>\n";

    if($_SESSION["userTipo"] == 1) {
?>
    <form action="?a=eliminar_tabla" method="post">
    <input type="hidden" name="tabla" value=<?='"'.$tabla->id.'"'?>>
    <input type="submit" value="X" class="smallButton">
    </form>
<?php
    }
    
    print "<span class='tablaNombre'>$tabla->nombre</span>\n";
    $actividad = Actividad::seek($tabla->actividadId);
    print "<span class='tablaActividad'>$actividad->nombre</span>\n";
    print "<span class='tablaDificultad'>(Dif. $tabla->dificultadGlobal)</span>\n";
    
    print "<br/>";
    
    $ejercicios = $tabla->consultarEjercicios();
    
    foreach($ejercicios as $e) {
        print "<div class='ejerciciosTabla'>\n";
        
        print "<span class='ejercicioNombre'>$e->nombre</span><br/>\n";
        print "<span class='ejercicioDescripcion'>$e->descripcion</span>\n";
        
        print "</div>";
    }

    if($_SESSION["userTipo"] == 1) {
        echo "<span class='anadirEjercicio'><a href=\"?a=anadir_ejercicio&tabla=$tabla->id\">Añadir ej.</a></span>";
        echo "<span class='asignarDeportista'><a href=\"?a=asignar_deportista&tabla=$tabla->id\">Asignar dep.</a></span>";

        $deportistas = $tabla->consultarAsignados();
        foreach($deportistas as $de) {
?>
            <form action="?a=desasignar" method="post">
            <input type="hidden" name="usuario" value=<?='"'.$de->id.'"'?>>
            <input type="hidden" name="tabla" value=<?='"'.$tabla->id.'"'?>>
            <?= $de->nombre." ".$de->apellidos ?>
            <input type="submit" value="X" class="smallButton"/>
            </form>
<?php
        }
    }
    
    print "</div>";
}

function mostrar_formulario_tabla() {
?>
    <div class="tablaForm">
    <form action="?a=creada" method="post">
    <label for="nombre">Nombre:</label> <input type="text" name="nombre"/><br/>
    <label for="tipo">Tipo:</label> <input type="text" name="tipo"/></br>
    <label for="dificultad">Dificultad:</label> <input type="text" name="dificultad"/></br>
    <label for="actividad">Actividad: </label> <select name="actividad" required>
<?php
    $actividades = Actividad::get();
    foreach($actividades as $a) {
        echo "<option value=\"$a->id\">$a->nombre</option>";
    }
?>
    </select></br>
    <input type="submit" value="Crear"/>
    </form>
    </div>
<?php
}

function mostrar_formulario_ejercicio($tablaId) {
?>
    <div class="ejercicioForm">
    <form action="?a=anadido_ejercicio" method="post">
    <input type="hidden" name="tabla" value=<?='"'.$tablaId.'"'?>>
    <label for="ejercicio">Ejercicio: </label> <select name="ejercicio" required>
<?php
    $ejercicios = Ejercicio::get();
    foreach($ejercicios as $e) {
        echo "<option value=\"$e->id\">$e->nombre</option>";
    }
?>
    </select>
    <input type="submit" value="Añadir"/>
    </form>
    </div>
<?php
}

function mostrar_formulario_deportista() {
?>
    <div class="deportistaForm">
<?php
    echo "<form action=\"?a=asignado_deportista&tabla=$_REQUEST[tabla]\" method=\"post\">\n";
?>
    <label for="deportista">Deportista: </label> <select name="deportista" required>
<?php
    $deportistas = Usuario::get(2);
    foreach($deportistas as $de) {
        echo "<option value=\"$de->id\">$de->apellidos, $de->nombre</option>\n";
    }
?>
    </select>
    <input type="submit" value="Asignar"/>
    </form>
</div>
<?php
}

if(isset($_SESSION["userId"])) {
    $user = Usuario::seek($_SESSION["userId"]);
    if($_SESSION["userTipo"] == 2) { // deportista
        $tablas = $user->consultarTablas();

        if(count($tablas) == 0) {
            print "<p>No hay tablas asignadas a tí.</p>\n";
        } else {
            foreach($tablas as $tabla) {
                mostrar_tabla($tabla);
            }
        } 
        
    } else if($_SESSION["userTipo"] == 1) {
        if(!isset($_REQUEST["a"])) {
            $tablas = $user->consultarTablas();

            foreach($tablas as $tabla) {
                mostrar_tabla($tabla);
            }
        } else if($_REQUEST["a"] == "crear") {
            mostrar_formulario_tabla();
        } else if($_REQUEST["a"] == "creada") {
            $tabla = new TablaEjercicios(0, $_REQUEST["nombre"], $_REQUEST["tipo"],
            $_REQUEST["dificultad"], $_REQUEST["actividad"]);
            $tabla->insert();
            echo "<p>Tabla creada con éxito.</p>";
        } else if($_REQUEST["a"] == "anadir_ejercicio") {
            mostrar_formulario_ejercicio($_REQUEST["tabla"]);
        } else if($_REQUEST["a"] == "anadido_ejercicio") {
            $tabla = TablaEjercicios::seek($_REQUEST["tabla"]);
            $tabla->asignarEjercicio($_REQUEST["ejercicio"]);
            echo "<p>Ejercicio asignado con éxito.</p>\n";
        } else if($_REQUEST["a"] == "asignar_deportista") {
            mostrar_formulario_deportista();
        } else if($_REQUEST["a"] == "asignado_deportista") {
            $tabla = TablaEjercicios::seek($_REQUEST["tabla"]);
            $tabla->asignar($_REQUEST["deportista"]);
            echo "<p>Deportista asignado con éxito.</p>\n";
        } else if($_REQUEST["a"] == "desasignar") {
            $tabla = TablaEjercicios::seek($_REQUEST["tabla"]);
            if(!$tabla->desasignar($_REQUEST["usuario"])) {
                print "<p>Problema al desasignar usuario: " . mysql_error() . "</p>";
            } else {
                print "<p>Usuario desasignado con éxito.</p>";
            }
        } else if($_REQUEST["a"] == "eliminar_tabla") {
            $tabla = TablaEjercicios::seek($_REQUEST["tabla"]);
            if(!$tabla->delete()) {
                print "<p>Error eliminando tabla: ".mysql_error()."</p>";
            } else {
                print "<p>Tabla eliminada correctamente.</p>";
            }
        }
    }

} else {
    print "<p>No conectado. <a href='index.php'>Login</a>.</p>\n";
}
?>