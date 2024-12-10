<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];


    include_once '../modelo/conexion.php'; 
    $conexion = new Conexion();
    $db = $conexion->conectar();


    $query = $db->prepare("DELETE FROM usuarios WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    if ($query->execute()) {

        header("Location: ../vista/formulario_registro.php");
        exit();
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}
?>
