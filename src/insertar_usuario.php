<?php
// Incluir la conexión a la base de datos (asegúrate de tener este archivo)
include_once '../bd/conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $rut = $_POST['rut']; // Asumiendo que el campo de formulario se llama 'rut'
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];

    // Preparar la declaración SQL
    $sql = "INSERT INTO usuarios (Rut, Correo, Contraseña, Tipo) VALUES (?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssss", $rut, $correo, $contrasena, $tipo);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        // Redireccionar después de la inserción exitosa (o mostrar un mensaje)
        header('Location: ../vistas/Menu_administrador.php');
        exit();
    } else {
        echo "Error al insertar el usuario: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
