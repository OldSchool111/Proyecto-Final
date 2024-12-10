<?php
class Modelo {
    private $conexion;

    public function __construct() {
        include_once 'conexion.php';
        $this->conexion = new Conexion();
        $this->db = $this->conexion->conectar();
    }

    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $query = $this->db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarUsuario($nombre, $ciudad, $direccion, $telefono, $email, $contrasena) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, ciudad, direccion, telefono, email, contrasena) VALUES (:nombre, :ciudad, :direccion, :telefono, :email, :contrasena)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':ciudad' => $ciudad,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email,
            ':contrasena' => $contrasenaHash
        ]);
    }

    public function actualizarUsuario($id, $nombre, $ciudad, $direccion, $telefono, $email, $contrasena = null) {
        if ($contrasena) {
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET nombre = :nombre, ciudad = :ciudad, direccion = :direccion, telefono = :telefono, email = :email, contrasena = :contrasena WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':ciudad' => $ciudad,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':email' => $email,
                ':contrasena' => $contrasenaHash,
                ':id' => $id
            ]);
        } else {
            $sql = "UPDATE usuarios SET nombre = :nombre, ciudad = :ciudad, direccion = :direccion, telefono = :telefono, email = :email WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':ciudad' => $ciudad,
                ':direccion' => $direccion,
                ':telefono' => $telefono,
                ':email' => $email,
                ':id' => $id
            ]);
        }
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Datos de los usuarios</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Agregar Usuario</button>

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="agregarUsuarioForm">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" name="ciudad" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" name="contrasena" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table mt-4 text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaUsuarios">
                <?php
                include_once '../modelo/modelo.php';
                $modelo = new Modelo();
                $usuarios = $modelo->obtenerUsuarios();

                foreach ($usuarios as $usuario) {
                ?>
                    <tr id="usuario_<?php echo $usuario['id']; ?>">
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['ciudad']; ?></td>
                        <td><?php echo $usuario['direccion']; ?></td>
                        <td><?php echo $usuario['telefono']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['contrasena']; ?></td>
                        <td>
                        <div class="d-flex justify-content-between mt-2">
                        <button type="button" class="btn btn-warning me-3" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $usuario['id']; ?>">Editar</button>
                      <button class="btn btn-danger" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">Eliminar</button>
                     </div>
                     </td>
                    </tr>
                    <div class="modal fade" id="editModal_<?php echo $usuario['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editarUsuarioForm_<?php echo $usuario['id']; ?>" onsubmit="editarUsuario(<?php echo $usuario['id']; ?>); return false;">
                                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ciudad" class="form-label">Ciudad</label>
                                            <input type="text" name="ciudad" class="form-control" value="<?php echo $usuario['ciudad']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" name="direccion" class="form-control" value="<?php echo $usuario['direccion']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" name="telefono" class="form-control" value="<?php echo $usuario['telefono']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $usuario['email']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contrasena" class="form-label">Contraseña</label>
                                            <input type="password" name="contrasena" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-warning">actualizar datos</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById("agregarUsuarioForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../controlador/agregar.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "El Usuario Fue Registrado Correctamente",
                    showConfirmButton: false,
                    timer: 3000
                });
                document.getElementById("agregarUsuarioForm").reset();
                var modal = new bootstrap.Modal(document.getElementById('addUserModal'));
                modal.hide();
                location.reload();
            }
        };
        xhr.send(formData);
    });

    function editarUsuario(id) {
        Swal.fire({
            title: '¿Estás seguro de que quieres actualizar los datos?',
            text: "Los cambios se aplicarán al usuario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, actualizar!'
        }).then((result) => {
            if (result.isConfirmed) {
                var form = document.getElementById("editarUsuarioForm_" + id);
                var formData = new FormData(form);
                var params = new URLSearchParams(formData).toString();

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../controlador/editar.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        Swal.fire({
                            position: "top",
                            icon: "success",
                            title: "El Registro fue actualizado correctamente!",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            location.reload();
                        });
                    }
                };
                xhr.send(params);
            }
        });
    }

    function eliminarUsuario(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../controlador/eliminar.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        Swal.fire({
                            position: "top",
                            icon: "success",
                            title: "El Registro Fue Eliminado del Sistema",
                            showConfirmButton: false,
                            timer: 3000
                        });
                        document.getElementById("usuario_" + id).remove();
                    }
                };
                xhr.send("id=" + id);
            }
        });
    }
    </script>
</body>
</html>
