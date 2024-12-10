<?php
include('../modelo/conexion.php');

session_start();

if (isset($_POST['Ingresar'])) {
    $nombreCliente = $_POST['nombreCliente'];
    $contrasenaCliente = $_POST['contrasenaCliente'];

    $c = new Conexion();
    $cone = $c->conectar(); 

    $stmt = $cone->prepare("SELECT * FROM usuarios WHERE nombre = :nombre");
    $stmt->bindParam(':nombre', $nombreCliente);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica la contraseña ingresada con la contraseña hash de la base de datos
        if (password_verify($contrasenaCliente, $usuario['contrasena'])) {
            $_SESSION['nombreCliente'] = $nombreCliente;
            header("location:formulario_registro.php");
            exit();
        } else {
            echo '<script type="text/javascript">
                alert("Usuario y clave no existen");
                window.location.href="formulario_registro.php";
            </script>';
        }
    } else {
        echo '<script type="text/javascript">
            alert("Usuario y clave no existen");
            window.location.href="formulario_registro.php";
        </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>iniciar sesion</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <body>
    <script>
        WebFont.load({
            google: {"families":["Open+Sans:300,400,600,700"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['assets/css/fonts.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/azzara.min.css">
    <style>
    
        body.login {
            background-image: url('https://i.pinimg.com/originals/2e/08/61/2e08617f3f0e57bc5b0343e37b56d7bc.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .wrapper-login {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 60px 40px;
            max-width: 400px;
            width: 100%;
            margin: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-floating-label .form-control {
            border-radius: 30px;
            padding: 15px 20px;
        }
        .form-action input[type="submit"] {
            background: #3498db;
            color: #fff;
            border-radius: 30px;
            padding: 12px 0;
            border: none;
            width: 100%;
            font-size: 16px;
            transition: 0.3s;
        }
        .form-action input[type="submit"]:hover {
            background: #2980b9;
        }
        .text-center {
            color: #333;
            margin-bottom: 30px;
        }
        .link {
            color: #3498db;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
        .olvido {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .olvido a {
            color: #3498db;
            font-size: 14px;
        }
    </style>
</head>
<body class="login">
<form action="" method="post" class="formulario">
    <div class="wrapper wrapper-login">
        <h3 class="text-center">Iniciar Sesión</h3>
        <div class="login-form">
            <div class="form-group form-floating-label position-relative">    
                <input id="nombreCliente" name="nombreCliente" type="text" class="form-control input-border-bottom" placeholder="Nombre" required>
            </div>
            <div class="form-group form-floating-label position-relative">    
                <input id="contrasenaCliente" name="contrasenaCliente" type="password" class="form-control input-border-bottom" placeholder="Contraseña" required>
            </div>    
            <div class="form-action mb-3">
                <input type="submit" name="Ingresar" value="Ingresar">
            </div>
            <div class="olvido"> 
                <a href="#" class="link">¿Olvidó su contraseña?</a> 
            </div>
        </div>
    </div>
</form>
</body>
</html>
