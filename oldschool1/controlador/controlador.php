<?php
// controlador.php

// Incluir el archivo de conexión
require_once '../modelo/conexion.php';


// Crear una instancia de la clase Conexion
$conexion = new Conexion();
$db = $conexion->conectar(); // Obtener la conexión

// Verificar si se recibió el ID y los datos actualizados
if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['ciudad']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email'])) {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Preparar la consulta para actualizar los datos
    $query = "UPDATE usuarios SET nombre = :nombre, ciudad = :ciudad, direccion = :direccion, telefono = :telefono, email = :email WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':email', $email);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente";
    } else {
        echo "Error al actualizar el usuario";
    }
} else {
    echo "Datos incompletos";
}
include_once '../modelo/modelo.php';

$modelo = new Modelo();

if (isset($_POST['elimina'])) {
    $id = $_POST['id'];
    $modelo->eliminarUsuario($id);
    
    // Redirigir después de eliminar (opcional, pero recomendable para evitar reenvíos del formulario)
    header("Location: ../vista/vista_usuarios.php");
    exit();
}