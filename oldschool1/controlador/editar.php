<?php
include_once '../modelo/modelo.php';

$modelo = new Modelo();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$contrasena = isset($_POST['contrasena']) && !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_BCRYPT) : null;

$resultado = $modelo->actualizarUsuario($id, $nombre, $ciudad, $direccion, $telefono, $email, $contrasena);

if ($resultado) {
    echo "Usuario actualizado exitosamente";
} else {
    echo "Error al actualizar usuario";
}
?>
