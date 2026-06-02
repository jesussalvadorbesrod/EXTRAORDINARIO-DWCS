<?php
session_start();

// Importa el módulo JQuery4PHP
require_once '../vendor/autoload.php';
YsJQueryAutoloader::register();

require_once 'conexion.php';
function error($mensaje)
{
    $_SESSION['error'] = $mensaje;
    header('Location:login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body style="background:silver;">
<?php
if (isset($_POST['login'])) {
    $nombre = trim($_POST['usuario']);
    $pass = trim($_POST['pass']);
    if (strlen($nombre) == 0 || strlen($pass) == 0) {
        error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
    }

    //creamos el sha256 de la contraseña que es como se almacena en mysql

    $pass1 = hash('sha256', $pass);
    $consulta = "select * from clientes where usuario=:u AND pass=:p";
    $stmt = $conProyecto->prepare($consulta);
    try {
        $stmt->execute([
            ':u' => $nombre,
            ':p' => $pass1
        ]);
    } catch (PDOException $ex) {
        cerrarTodo($conProyecto, $stmt);
        error("Error en la consulta a la base de datos.");
    }
    if ($stmt->rowCount()==0) {
        unset($_POST['login']);
        cerrarTodo($conProyecto, $stmt);
        error("Error, Nombre de usuario o password incorrecto");
        
    }
    cerrarTodo($conProyecto, $stmt);

    //Nos hemos validado correctamente creamos la sesion de usuario con el nombre de usuario

    $_SESSION['nombre'] = $nombre;
    header('Location:listado.php');
} else {
    ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <!-- Agregado el identificador form necesario para confirmar después de que se produzca el efecto -->
                    <form id="form" name='login' method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="usuario" name='usuario' required>

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" placeholder="contraseña" name='pass' required>
                        </div>
                        <div class="form-group">
                            <!-- Agregado el identificador login necesario para el efecto de la caja de login -->
                            <input type="submit" value="Login" class="btn float-right btn-success" name='login' id="login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='mt-3 text-danger font-weight-bold text-lg'>";
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                echo "</div>";
            }
        ?>
    </div>
<?php } ?>
    <?php
        // Crea un efecto al pulsar el botón Login. Luego confirma el formulario
        echo YsJQuery::newInstance()
            ->onClick()
            ->in('#login')
            ->execute(
                '$(".card").animate({right: "100px"}, "fast").animate({left: "100px"}, "fast").animate({right: "100px"}, "fast").animate({left: "100px"}, "fast");
                $(".card").promise().done(function() {
                    $("#form").trigger("submit");   
                });'
            );
    ?>
</body>

</html>