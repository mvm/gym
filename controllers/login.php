<?php
include "../models/usuario.php";
include "db.php";

// iniciar request parameters si se llama desde la CLI
if (php_sapi_name() === 'cli') {
    parse_str(implode('&', array_slice($argv, 1)), $_REQUEST);
}

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

if(!isset($_REQUEST["a"])) {
  // formulario login
  login_form();
} else if($_REQUEST["a"] == "login") {
  // hacer login
  $usuario = Usuario::getByEmail($_REQUEST["email"]);
  
  if($usuario == null) {
    print "<p>Error: usuario $_REQUEST[email] no encontrado.</p>";
    goto login_error;
  }

  if(password_verify($_REQUEST["password"], $usuario->$password)) {
    session_start();
    $_SESSION["userId"] = $usuario->$id;
  } else {
    print "<p>Error: password incorrecta.</p>";
    goto login_error;
  }

  return;
login_error:
  login_form();
} else if($_REQUEST["a"] == "register") {
  // formulario de registro
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
} else if($_REQUEST["a"] == "new_user") {
  // despues del registro

  if($_REQUEST["password"] != $_REQUEST["password2"]) {
    print "<p>Error: passwords no coinciden.</p>";
    break;
  }

  $usuario = new Usuario(0, $_REQUEST["nombre"],
			 $_REQUEST["apellidos"],
			 $_REQUEST["dni"],
			 $_REQUEST["correo"],
			 2, // por defecto tipo deportista
			 password_hash($_REQUEST["password"], PASSWORD_DEFAULT));
  $usuario->insert();
}
?>