<?php
include_once '../modelo/conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();

$formVisible = true; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
    $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : null;
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : null;
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $contrasena = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : null; 

    if ($nombre && $ciudad && $direccion && $telefono && $email && $contrasena) {
        $sql = "INSERT INTO usuarios (nombre, ciudad, direccion, telefono, email, contrasena) VALUES (:nombre, :ciudad, :direccion, :telefono, :email, :contrasena)";
        $stmt = $db->prepare($sql);

        // Ejecutar la consulta con los datos proporcionados
        try {
            $stmt->execute([
                ':nombre' => $nombre,
                ':ciudad' => $ciudad,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':email' => $email,
                ':contrasena' => password_hash($contrasena, PASSWORD_DEFAULT) // Se asegura de que la contraseña esté encriptada
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Usuario registrado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al registrar el usuario: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, complete todos los campos.']);
    }
    exit();
}

$query = $db->query("SELECT * FROM usuarios");

if ($query) {
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $usuarios = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style 1/estilos.css">
    <title>Usuarios</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: black;
            color: white;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
        }
        .navbar a:hover {
            background-color: #444; 
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
            margin-right: 20px;
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <span class="logo">Old School S&J</span>
    <a href="inicio.php">Inicio</a>
    <a href="cerrar_sesion.php" onclick="return confirm('¿Estás seguro que deseas cerrar sesión?');">Cerrar Sesión</a>
</div>
<div class="container-lg">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8">
                    <h2>Datos de los usuarios</h2>
                </div>
                <div class="col-sm-4 text-end">
                    <form action="" method="POST">
                        <input type="hidden" name="accion" value="agregar">
                    </form>
                </div>
            </div>
        </div>

        <?php if ($formVisible): ?>
            <form id="registroForm" class="mb-3">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="contrasena" required>
                </div>
                
                <button type="button" id="registrarUsuarioBtn" class="btn btn-primary">Registrar Usuario</button>
            </form>
        <?php endif; ?>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('registrarUsuarioBtn').addEventListener('click', function () {
    var form = document.getElementById('registroForm');

    if (!form.checkValidity()) {
        Swal.fire({
            icon: 'warning',
            title: 'Por favor, complete todos los campos.',
            showConfirmButton: true
        });
        return; 
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: "El registro será añadido al sistema.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrarlo!'
    }).then((result) => {
        if (result.isConfirmed) {
            var formData = new FormData(form);

            formData.append('ajax', 'true');

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); 
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        Swal.fire({
                            position: "top",
                            icon: "success",
                            title: "El registro ha sido exitosamente registrado",
                            showConfirmButton: false,
                            timer: 3000
                        });
                        // Limpiar el formulario después del registro exitoso
                        form.reset();
                    } else {
                        Swal.fire({
                            position: "top",
                            icon: "error",
                            title: response.message,
                            showConfirmButton: true
                        });
                    }
                }
            };
            xhr.send(formData); // Enviar los datos del formulario
        }
    });
});
</script>

</body>
</html>


