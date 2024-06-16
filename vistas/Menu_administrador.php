<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <h3 class="my-3" id="titulo">Usuarios</h3>
            <a href="../html/agregar_usuario.html" class="btn btn-success">Agregar usuarios</a>
            <a href="../vistas/login.php" class="btn btn-danger ms-2">Cerrar sesión</a>
            <table class="table table-hover table-bordered my-3" aria-describedby="titulo">
                <thead class="table-dark">
                    <tr>
                        <th>Rut</th>
                        <th>Correo</th>
                        <th>Contraseña</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir la conexión a la base de datos
                    include_once '../bd/conexion.php';

                    // Query para seleccionar todos los empleados
                    $sql = "SELECT Rut, Correo, Contraseña, Tipo FROM usuarios";
                    $result = $conn->query($sql);

                    // Mostrar los empleados en la tabla
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['Rut'] . "</td>";
                            echo "<td>" . $row['Correo'] . "</td>";
                            echo "<td>" . $row['Contraseña'] . "</td>";
                            echo "<td>" . $row['Tipo'] . "</td>";
                            echo '<td>
                                    <a href="../html/editar_usuario.html?rut=' . $row['Rut'] . '" class="btn btn-warning btn-sm me-2">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#eliminaModal" data-bs-id="' . $row['Rut'] . '">Eliminar</button>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No hay empleados registrados</td></tr>";
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container">
            <span class="text-body-secondary"> 2024 | Códigos de Programación</span>
        </div>
    </footer>
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Aviso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro?</p>
                </div>
                <div class="modal-footer">
                    <form id="form-elimina" action="../src/eliminar_usuario.php" method="post">
                        <input type="hidden" name="rut" id="rut-eliminar">
                        <input type="hidden" name="_method" value="delete">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        const eliminaModal = document.getElementById('eliminaModal');
        if (eliminaModal) {
            eliminaModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-bs-id');
                const form = eliminaModal.querySelector('#form-elimina');
                const rutEliminar = eliminaModal.querySelector('#rut-eliminar');
                rutEliminar.value = id;
            });
        }
    </script>
</body>
</html>
