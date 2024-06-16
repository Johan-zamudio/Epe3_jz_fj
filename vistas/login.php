<?php
// Iniciar sesión
session_start();

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo']) && isset($_POST['contrasena'])) {
    // Conexión a la base de datos
    require_once '../bd/conexion.php'; // Asegúrate de que la conexión esté correctamente configurada

    // Obtener datos del formulario y escapar para prevenir SQL injection
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

    // Consulta SQL para obtener información del usuario
    $query = "SELECT * FROM usuarios WHERE Correo = '$correo' AND Contraseña = '$contrasena'";
    $resultado = mysqli_query($conn, $query);

    // Verificar si se encontró un usuario
    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Almacenar datos del usuario en sesión
        $_SESSION['usuario_rut'] = $usuario['Rut'];
        $_SESSION['usuario_tipo'] = $usuario['Tipo'];

        // Redireccionar según el tipo de usuario
        if ($usuario['Tipo'] == 'Administrador') {
            header('Location: ../vistas/Menu_administrador.php');
            exit(); // Terminar el script después de redireccionar
        } elseif ($usuario['Tipo'] == 'Vendedor') {
            header('Location: ../vistas/Menu_vendedor.php');
            exit(); // Terminar el script después de redireccionar
        } else {
            // Si el tipo de usuario no es reconocido, redirigir a página de error o inicio de sesión
            $_SESSION['login_error'] = "Tipo de usuario no válido.";
            header('Location: ../index.php');
            exit(); // Terminar el script después de redireccionar
        }
    } else {
        // Si no se encuentra el usuario, redireccionar de nuevo al inicio de sesión con mensaje de error
        $_SESSION['login_error'] = "Correo o contraseña incorrectos.";
        header('Location: ../index.php');
        exit(); // Terminar el script después de redireccionar
    }
} else {
    // Si no se enviaron datos por POST, redireccionar de nuevo al inicio de sesión
    header('Location: ../index.php');
    exit(); // Terminar el script después de redireccionar
}
?>
