<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con php vanilla</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <h1 class="text-center p-3">CRUD con php vanilla</h1>

    <!-- F -->
    <div class="container-fluid row">
        <form class="col-4 mx-1 p-3 border shadow" action="process.php" method="POST">

            <h3 class="text-center">Registro de personas</h3>
            <div class="mb-4">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-4">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>

            <div class="mb-4">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>

            <div class="mb-4">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>

            <div class="mb-4">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <!-- tabla -->
        <div class="col-7 p-4 border shadow mx-1">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        include "model/conexion.php";
                        // Se utiliza un bloque try-catch para manejar posibles excepciones al interactuar con la base de datos
                        try {
                            // Se instancia la conexión a la base de datos
                            $db = new Conexion();
                            $conexion = $db->getConexion();

                            // Se ejecuta la consulta para obtener los datos de la tabla "persona"
                            $sql = $conexion->query("SELECT * FROM persona");

                            // Se itera sobre los resultados obtenidos
                            while ($datos = $sql->fetch_object()) {
                                ?>
                                <tr>
                                    <!-- Se utiliza htmlspecialchars para evitar inyección de código en los datos mostrados -->
                                    <th scope="row"><?php echo htmlspecialchars($datos->id); ?></th>
                                    <td><?php echo htmlspecialchars($datos->nombre); ?></td>
                                    <td><?php echo htmlspecialchars($datos->apellido); ?></td>
                                    <td><?php echo htmlspecialchars($datos->dni); ?></td>
                                    <td><?php echo htmlspecialchars($datos->fecha_nacimiento); ?></td>
                                    <td><?php echo htmlspecialchars($datos->correo); ?></td>
                                    <td>
                                        <!-- Botones de acción con íconos -->
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } catch (Exception $e) {
                            // Se muestra un mensaje de error en caso de que ocurra una excepción
                            echo "<tr><td colspan='7' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        } finally {
                            // Se asegura de cerrar la conexión a la base de datos en el bloque finally
                            if (isset($conexion)) {
                                $conexion->close();
                            }
                        }
                        ?>

                </tbody>
            </table>
        </div>

    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>