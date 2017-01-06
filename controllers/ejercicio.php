<?php
require "controllers/db.php";
require "models/ejercicio.php";
require "models/usuario.php";

function mostrar_ejercicio($ejercicio) {
?>
    <div class="ejercicio">
    <span class="ejercicioNombre"><?= $ejercicio->nombre ?></span> <br/>
    <span class="ejercicioDescripcion"><?= $ejercicio->descripcion ?></span></br>
    <span class="ejercicioDificultad">Dificultad: <?= $ejercicio->dificultad ?></span>
    </div>
<?php
}

function formulario_ejercicio() {
?>
    <div class="ejercicioForm">
    <form action="?a=creado" method="post">
    <label for="nombre">Nombre: </label> <input type="text" name="nombre"/> </br>
    <label for="descripcion">Descripcion: </label> <br/>
    <textarea name="descripcion"> </textarea><br/>
    <label for="dificultad">Dificultad: </label> <input type="text" name="dificultad"/></br>
    <input type="submit" value="Crear"/>
    </form>
    </div>
<?php
}

if(isset($_SESSION["userId"])) {
    if($_SESSION["userTipo"] == 1) {
        if(!isset($_REQUEST["a"])) {
            $ejercicios = Ejercicio::get();

            foreach($ejercicios as $ej) {
                mostrar_ejercicio($ej);
            }
        } else if($_REQUEST["a"] == "crear") {
            formulario_ejercicio();
        } else if($_REQUEST["a"] == "creado") {
            $ej = new Ejercicio(0, $_REQUEST["nombre"], $_REQUEST["descripcion"],
            '', '', $_REQUEST["dificultad"]);
            $ej->insert();

            echo "<p>Ejercicio creado con éxito.</p>";
        }
    }
} else {
    echo "<p>No estás <a href='index.php'>conectado</a>.</p>";
}

?>