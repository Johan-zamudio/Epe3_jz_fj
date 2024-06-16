<?php
// Iniciar sesión (no es necesario para este formulario)
// session_start();

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['cantidad']) && isset($_POST['precio']) && isset($_POST['proveedor'])) {
    // Conexión a la base de datos
    require_once '../bd/conexion.php'; // Asegúrate de que la conexión esté correctamente configurada

    // Obtener datos del formulario y escapar para prevenir SQL injection
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $cantidad = (int)$_POST['cantidad'];
    $precio = (float)$_POST['precio'];
    $proveedor = mysqli_real_escape_string($conn, $_POST['proveedor']);

    // Consulta SQL para insertar el nuevo repuesto
    $query = "INSERT INTO repuestos (NombreRepuesto, CantidadStock, PrecioUnitario, Proveedor) VALUES ('$nombre', $cantidad, $precio, '$proveedor')";

    if (mysqli_query($conn, $query)) {
        // Redireccionar a la página de éxito o a donde sea necesario
        header('Location: Location: ../vistas/Menu_vendedor.php'); // Por ejemplo, regresar al inicio
        exit();
    } else {
        // Manejo de errores si la inserción falla
        echo "Error al insertar el repuesto: " . mysqli_error($conn);
    }
} else {
    // Si no se enviaron datos por POST, redireccionar o mostrar un mensaje de error
    echo "Error: Todos los campos son requeridos.";
}
?>
