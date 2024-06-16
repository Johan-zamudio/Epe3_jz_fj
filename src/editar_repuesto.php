<?php
// Incluir la conexión a la base de datos
require_once '../bd/conexion.php'; // Asegúrate de que la conexión esté correctamente configurada

// Verificar si se ha enviado el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $repuestoID = $_POST['repuestoID'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $proveedor = $_POST['proveedor'];

    // Preparar la declaración SQL para actualizar el repuesto
    $sql = "UPDATE repuestos SET NombreRepuesto = ?, CantidadStock = ?, PrecioUnitario = ?, Proveedor = ? WHERE RepuestoID = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;
    } else {
        // Vincular parámetros
        $stmt->bind_param("sdisi", $nombre, $cantidad, $precio, $proveedor, $repuestoID);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Redireccionar después de la actualización exitosa (o mostrar un mensaje)
            header('Location: ../vistas/Menu_vendedor.php'); // Redirigir al listado de repuestos u otra página de confirmación
            exit();
        } else {
            echo "Error al actualizar el repuesto: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}
?>
