<?php
// Incluir la conexión a la base de datos
require_once '../bd/conexion.php'; // Asegúrate de que la conexión esté correctamente configurada

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del repuesto a eliminar
    $repuestoID = $_POST['repuestoID']; // Asumiendo que el campo de formulario se llama 'repuestoID'

    // Preparar la declaración SQL para eliminar el registro
    $sql = "DELETE FROM repuestos WHERE RepuestoID = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;
    } else {
        // Vincular parámetros
        $stmt->bind_param("i", $repuestoID);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Redireccionar después de la eliminación exitosa (o mostrar un mensaje)
            header('Location: ../vistas/Menu_vendedor'); // Por ejemplo, regresar al inicio
            exit();
        } else {
            echo "Error al eliminar el repuesto: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>
