<?php
require_once("../../../includes/header.php");
require_once("../../../includes/sidebar.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibiendo los datos del formulario
    $nombre_equipo = $_POST['nombre'];
    $escudo_equipo = $_FILES['escudo'];
    $division_equipo = $_POST['division'];

    // Validar que los campos no estén vacíos
    if (empty($nombre_equipo) || empty($division_equipo)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos.'
                });
                </script>";
        exit();
    }

    // Validar que el archivo se suba correctamente
    if ($escudo_equipo['error'] != 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema con el archivo del escudo.'
                });
                </script>";
        exit();
    }

    // Obtener el nombre de la división
    $stmt = $conexion->prepare("SELECT division FROM divisiones WHERE id = :division_id");
    $stmt->bindParam(":division_id", $division_equipo);
    $stmt->execute();
    $division = $stmt->fetch(PDO::FETCH_ASSOC)['division'];

    // Crear la carpeta de la división si no existe
    $rutaCarpeta = "../../img/escudos/" . $division;
    if (!is_dir($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);  // Crear la carpeta con permisos adecuados
    }

    // Generar un nombre único para el archivo de imagen
    $fecha = new DateTime();
    $nombreArchivoEscudo = $fecha->getTimestamp() . "_" . $escudo_equipo['name'];
    $tmpEscudo = $escudo_equipo['tmp_name'];

    // Subir el archivo de imagen a la carpeta correspondiente
    if ($tmpEscudo != "") {
        $rutaDestino = $rutaCarpeta . "/" . $nombreArchivoEscudo;
        if (!move_uploaded_file($tmpEscudo, $rutaDestino)) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo subir el archivo.'
                });
                </script>";
            exit();
        }
    }

    try {
        // Insertar los datos en la base de datos
        $stmt = $conexion->prepare("INSERT INTO equipos (nombre, escudo, division_id) VALUES (:nombre, :escudo, :division)");
        $stmt->bindParam(":nombre", $nombre_equipo);
        $stmt->bindParam(":escudo", $nombreArchivoEscudo);
        $stmt->bindParam(":division", $division_equipo);
        $stmt->execute();

        // Mostrar mensaje de éxito
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Equipo creado correctamente.'
            }).then(function() {
                window.location = '../../index.php';
            });
            </script>";
    } catch (PDOException $e) {
        // Mostrar mensaje de error si algo sale mal
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo crear el equipo. Error: " . $e->getMessage() . "' 
            });
            </script>";
    }
}
?>

<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Crear Equipo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="listado_equipos.php">Equipos</a></li>
                        <li class="breadcrumb-item active">Crear Equipo</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <!-- Formulario para crear un equipo -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre del equipo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del equipo" required>
                        </div>

                        <div class="form-group">
                            <label for="escudo">Escudo del equipo</label>
                            <input type="file" class="form-control-file" id="escudo" name="escudo" accept="image/*" required>
                        </div>

                        <div class="form-group">
                            <label for="division">División</label>
                            <select class="form-control" id="division" name="division" required>
                                <option value="">Seleccione una división</option>
                                <?php
                                // Obtener las divisiones desde la base de datos
                                $stmt = $conexion->prepare("SELECT * FROM divisiones");
                                $stmt->execute();
                                $divisiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Mostrar las opciones de divisiones
                                foreach ($divisiones as $division) {
                                    echo "<option value='" . $division['id'] . "'>" . $division['division'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar equipo</button>
                        <a href="../../index.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                Footer
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<?php require_once("../../../includes/footer.php"); ?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>
</html>