<?php
include_once '../modelo/modelo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena']; 

    $modelo = new Modelo();
    if ($modelo->agregarUsuario($nombre, $ciudad, $direccion, $telefono, $email, $contrasena)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al agregar usuario.']);
    }
}
?>
