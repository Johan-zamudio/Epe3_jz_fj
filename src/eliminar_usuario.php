<?php
// Incluir la conexión a la base de datos
include_once '../bd/conexion.php';

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el Rut del usuario a eliminar
    $rut = $_POST['rut']; // Asumiendo que el campo de formulario se llama 'rut'

    // Preparar la declaración SQL para eliminar el registro
    $sql = "DELETE FROM usuarios WHERE Rut = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("s", $rut);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        // Redireccionar después de la eliminación exitosa (o mostrar un mensaje)
        header('Location: ../vistas/Menu_administrador.php');
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
