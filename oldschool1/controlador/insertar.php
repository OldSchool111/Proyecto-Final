<?php
session_start(); 
include_once '../modelo/conexion.php'; 
$conexion = new Conexion();
$db = $conexion->conectar();
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
   
        $_SESSION['usuarios'][] = [
            'nombre' => '',
            'ciudad' => '',
            'direccion' => '',
            'telefono' => '',
            'email' => ''
        ];
    } else {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        if ($id && $nombre && $ciudad && $direccion && $telefono && $email) {
  
            $sql = "UPDATE usuarios SET nombre = :nombre, ciudad = :ciudad, direccion = :direccion, telefono = :telefono, email = :email WHERE id = :id";
            $stmt = $db->prepare($sql);


            try {
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':ciudad' => $ciudad,
                    ':direccion' => $direccion,
                    ':telefono' => $telefono,
                    ':email' => $email,
                    ':id' => $id
                ]);
                echo "Usuario actualizado correctamente.";
            } catch (PDOException $e) {
                echo "Error al actualizar el usuario: " . $e->getMessage();
            }
        } else {
            echo "Por favor, complete todos los campos.";
        }
    }
}
$usuarios = $_SESSION['usuarios'];
?>


