<?php
include "models/usuario.php";
include "db.php";
include "cli.php";

function login_form() {
  ?>
  <form action="?a=login" method="post">
    E-mail: <input type="text" name="email" class="input"/> <br/>
    Password: <input type="password" name="password"/> <br/>
    <input type="submit" value="Log in"/>
    </form>
    <p><a href="?a=register">Registrar nuevo usuario</a></p>
<?php
}

function register_form() {
?>
  <form action="?a=new_user" method="post">
    Nombre: <input type="text" name="nombre"/></br>
    Apellidos: <input type="text" name="apellidos"/></br>
    DNI: <input type="text" name="dni"/></br>
    E-mail: <input type="text" name="correo"/></br>
    Password: <input type="password" name="password"/></br>
    Password (repetir): <input type="password" name="password2"/></br>
    <input type="submit" value="Registrar"/>
    </form>
<?php
}

function mostrar_principal() {
    $user = Usuario::seek($_SESSION["userId"]);

    print "<p>$user->correo ($user->id) : ";
    print '<a href="?a=logout">Desconectar</a>';
    print "</p>\n";
    
    $notifs = $user->consultarNotificacionesRecibidas();

    print "<div class='panelNotificaciones'>\n";
    if(!$notifs) {
        print "<span>No hay notificaciones recibidas.</span>\n";
    } else {
        $numNot = count($notifs);
        print "<span><a href=\"notificacion.php\">" .
            "$numNot notificacion(es)</a></span>\n";
    }
    print "</div>";

    if($_SESSION["userTipo"] == 2)  { // deportista
        $user = Usuario::seek($_SESSION["userId"]);
        $sesiones = $user->consultarEntrenamientos();
        $numSesiones = count($sesiones);
?>
        <div class="panelSesiones">
        <a href="sesion.php">Hay <?= $numSesiones ?> sesion(es) pendientes.</a>
        </div>
<?php
        
    }

}

if(isset($_SESSION["userId"])) {
    mostrar_principal();
} else if(!isset($_REQUEST["a"]) or !isset($_SESSION)) {
  // formulario login
  login_form();
} else if($_REQUEST["a"] == "login") {
  // hacer login
  $usuario = Usuario::getByEmail($_REQUEST["email"]);
  
  if($usuario == null) {
    print "<p>Error: usuario $_REQUEST[email] no encontrado.</p>";
    goto login_error;
  }

  if(password_verify($_REQUEST["password"], $usuario->password)) {
    $_SESSION["userId"] = $usuario->id;
    $_SESSION["userTipo"] = $usuario->tipo;
    mostrar_principal();
  } else {
    print "<p>Error: password incorrecta.</p>";
    goto login_error;
  }

  if(false) {
login_error:
  login_form();
  }
} else if($_REQUEST["a"] == "register") {
  // formulario de registro
  register_form();
} else if($_REQUEST["a"] == "new_user") {
    // despues del registro
    
    if(!isset($_REQUEST["nombre"]) or !isset($_REQUEST["apellidos"]) or !isset($_REQUEST["dni"]) or !isset($_REQUEST["correo"]) or !isset($_REQUEST["password"])
    or !isset($_REQUEST["password2"]))
    {
        print "<p>Campos no especificados.</p>\n";
        goto register_error;
    }
    
    if($_REQUEST["password"] != $_REQUEST["password2"]) {
        print "<p>Error: passwords no coinciden.</p>";
        goto register_error;
    }
    
    $usuario = new Usuario(0, $_REQUEST["nombre"],
			 $_REQUEST["apellidos"],
			 $_REQUEST["dni"],
			 $_REQUEST["correo"],
			 2, // por defecto tipo deportista
			 password_hash($_REQUEST["password"], PASSWORD_DEFAULT));
  $usuario->insert();

  if(false) {
register_error:
  register_form();
  }
}

?>