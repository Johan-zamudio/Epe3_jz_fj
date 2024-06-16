<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Repuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <h3 class="my-3" id="titulo">Lista de Repuestos</h3>
            <a href="../html/agregar_repuesto.html" class="btn btn-success">Agregar repuesto</a>
            <a href="../vistas/cerrar_sesion.php" class="btn btn-danger ms-2">Cerrar sesión</a>
            <table class="table table-hover table-bordered my-3" aria-describedby="titulo">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir la conexión a la base de datos
                    include_once '../bd/conexion.php';

                    // Query para seleccionar todos los repuestos
                    $sql = "SELECT RepuestoID, NombreRepuesto, CantidadStock, PrecioUnitario, Proveedor FROM repuestos";
                    $result = $conn->query($sql);

                    // Mostrar los repuestos en la tabla
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['RepuestoID'] . "</td>";
                            echo "<td>" . $row['NombreRepuesto'] . "</td>";
                            echo "<td>" . $row['CantidadStock'] . "</td>";
                            echo "<td>$" . number_format($row['PrecioUnitario'], 2) . "</td>";
                            echo "<td>" . $row['Proveedor'] . "</td>";
                            echo '<td>
                                    <a href="../html/editar_repuesto.html?id=' . $row['RepuestoID'] . '" class="btn btn-warning btn-sm me-2">Editar</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#eliminaModal" data-bs-id="' . $row['RepuestoID'] . '">Eliminar</button>
                                  </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay repuestos registrados</td></tr>";
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
                    <p>¿Desea eliminar este repuesto?</p>
                </div>
                <div class="modal-footer">
                    <form id="form-elimina" action="../src/eliminar_repuesto.php" method="post">
                        <input type="hidden" name="id" id="id-eliminar">
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
                const idEliminar = eliminaModal.querySelector('#id-eliminar');
                idEliminar.value = id;
            });
        }
    </script>
</body>
</html>
