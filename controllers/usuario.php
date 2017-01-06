<?php
require "controllers/db.php";
require "models/usuario.php";

function tipo_to_str($tipo) {
    $options = array("Admin", "Entrenador", "Deportista");
    return $options[$tipo];
}

function mostrar_usuario($usuario) {
?>
    <div class="panel">
    <span class="usuarioId"><?= $usuario->id ?></span>
    <span class="usuarioApellidos"><?= $usuario->apellidos ?></span>, 
    <span class="usuarioNombre"><?= $usuario->nombre ?></span>
    <span class="usuarioTipo"><?= tipo_to_str($usuario->tipo) ?></span>
    <form style="float:right;" class="eliminarUsuario" action="?a=eliminar" method="post">
    <input type="hidden" name="usuario" value=<?= $usuario->id ?>>
    <input type="submit" style="display:inline" value="X" class="smallButton">
    </form>
    </br>
    <span class="usuarioCorreo"><?= $usuario->correo ?></span>
    <span class="usuarioDni"><?= $usuario->dni ?></span>
    <form style="margin: 0; padding: 0;" class="editarUsuario" action="?a=editar" method="post">
    <input type="hidden" name="usuario" value=<?= $usuario->id ?>>
    <input type="submit" style="display:inline" value="Editar" class="smallButton">
    </form>
    </div>
<?php
}

function mostrar_confirmacion_eliminar($userId) {
    $user = Usuario::seek($userId);
?>
    <div class="formulario">
    <p>Eliminar usuario <?= $user->correo ?> ? </p>
    <form method="post" action="?a=eliminado">
    <input type="hidden" name="usuario" value=<?= $userId ?>>
    <input type="submit" value="Confirmar"/>
    </form>
    </div>
<?php
}

function mostrar_formulario_editar_usuario($userId) {
    $user = Usuario::seek($userId);
?>
    <div class="formulario">
  <form action="?a=editado" method="post">
    <input type="hidden" name="id" value=<?= '"' . $user->id . '"'?>>
    Nombre: <input type="text" name="nombre" value=<?= '"' . $user->nombre . '"' ?>/></br>
    Apellidos: <input type="text" name="apellidos" value=<?= '"' . $user->apellidos . '"'?>/></br>
  DNI: <input type="text" name="dni" value=<?= '"' . $user->dni . '"' ?>/></br>
    E-mail: <input type="text" name="correo" value=<?= '"'.$user->correo.'"'?>/></br>
    <label for="tipo">Tipo: </label> <input type="text" name="tipo" value=<?='"'.$user->tipo.'"'?>><br/>
    <input type="submit" value="Editar"/>
    </form>
    </div>
<?php
}

if(isset($_SESSION["userId"])) {
    if($_SESSION["userTipo"] == 0) { // administrador
        if(!isset($_REQUEST["a"])) {
            $usuarios = Usuario::get();
            foreach($usuarios as $usuario) {
                mostrar_usuario($usuario);
            }
        } else if($_REQUEST["a"] == "eliminar") {
            mostrar_confirmacion_eliminar($_REQUEST["usuario"]);
        } else if($_REQUEST["a"] == "eliminado") {
            $user = Usuario::seek($_REQUEST["usuario"]);
            if(!$user->delete()) {
                echo "<p>Problema al eliminar usuario: " . mysql_error() . "</p>";
            } else {
                echo "<p>Usuario $user->nombre $user->apellidos eliminado.</p>";
            }
        } else if($_REQUEST["a"] == "editar") {
            mostrar_formulario_editar_usuario($_REQUEST["usuario"]);
        } else if($_REQUEST["a"] == "editado") {
            $user = Usuario::seek($_REQUEST["id"]);
            $user->nombre = $_REQUEST["nombre"];
            $user->apellidos = $_REQUEST["apellidos"];
            $user->dni = $_REQUEST["dni"];
            $user->correo = $_REQUEST["correo"];
            $user->tipo = $_REQUEST["tipo"];
            if(!$user->update()) {
                echo "<p>Problema editando usuario: " . mysql_error() . "</p>";
            } else {
                echo "<p>Usuario $user->nombre $user->apellidos editado.</p>";
            }
        }
    }
}

?>