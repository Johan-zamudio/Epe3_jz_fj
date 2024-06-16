<?php
// Incluir la conexión a la base de datos (asegúrate de tener este archivo)
include_once '../bd/conexion.php';

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    // Obtener el Rut del usuario a editar
    $rut = $_POST['rut']; // Asumiendo que el campo de formulario se llama 'rut'

    // Obtener los nuevos datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];

    // Preparar la declaración SQL para actualizar el registro
    $sql = "UPDATE usuarios SET Correo = ?, Contraseña = ?, Tipo = ? WHERE Rut = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssss", $correo, $contrasena, $tipo, $rut);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        // Redireccionar después de la actualización exitosa (o mostrar un mensaje)
        header('Location: ../vistas/Menu_administrador.php');
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();
    $conn->close();
}
?>
