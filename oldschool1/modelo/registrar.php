<?php
include_once 'conexion.php'; // Asegúrate de que la ruta sea correcta
$conexion = new Conexion();
$db = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;

    // Validar que los datos requeridos están presentes
    if ($nombre && $ciudad && $direccion && $telefono && $email) {
        // Preparar la consulta SQL para insertar el usuario
        $sql = "INSERT INTO usuarios (nombre, ciudad, direccion, telefono, email) VALUES (:nombre, :ciudad, :direccion, :telefono, :email)";
        $stmt = $db->prepare($sql);

        // Ejecutar la consulta con los datos proporcionados
        try {
            $stmt->execute([
                ':nombre' => $nombre,
                ':ciudad' => $ciudad,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':email' => $email
            ]);
            // Redirigir a la interfaz de éxito
            header("Location: ../vista/success.php?message=El usuario ha sido registrado exitosamente");
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
