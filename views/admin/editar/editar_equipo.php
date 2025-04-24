<?php
require_once("../../../includes/header.php");
require_once("../../../includes/sidebar.php");

// Verifica que venga el ID por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener el equipo por ID
    $stmt = $conexion->prepare("SELECT * FROM equipos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $equipo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipo) {
        // Si no encuentra el equipo, muestra el mensaje de error con SweetAlert
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Equipo no encontrado.',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'listado_equipos_admin.php';
                    }
                });
              </script>";
        exit;
    }

    // Consulta para obtener las divisiones disponibles
    $divisiones_stmt = $conexion->prepare("SELECT * FROM divisiones");
    $divisiones_stmt->execute();
    $divisiones = $divisiones_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no se pasa el ID, muestra el mensaje de error con SweetAlert
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID no especificado.',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'listado_equipos_admin.php';
                }
            });
          </script>";
    exit;
}

// Actualización del equipo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $division_id = $_POST['division_id'];
    $escudo_actual = $equipo['escudo'];

    // Si se ha subido una nueva imagen de escudo
    if (!empty($_FILES['escudo']['name'])) {
        $escudo = $_FILES['escudo']['name'];
        $tmp = $_FILES['escudo']['tmp_name'];
        // Aquí se usa la ruta dinámica basada en la división
        $rutaEscudo = "../../img/escudos/" . strtolower($divisiones[$division_id - 1]['division']) . "/" . $escudo;
        move_uploaded_file($tmp, $rutaEscudo); // Ruta de escudos
    } else {
        $escudo = $escudo_actual; // Mantiene el escudo actual si no se sube uno nuevo
    }

    // Consulta para actualizar los datos del equipo
    $update = $conexion->prepare("UPDATE equipos SET nombre = :nombre, escudo = :escudo, division_id = :division_id WHERE id = :id");
    $update->bindParam(':nombre', $nombre);
    $update->bindParam(':escudo', $escudo);
    $update->bindParam(':division_id', $division_id);
    $update->bindParam(':id', $id);
    $update->execute();

    // Muestra el mensaje de éxito con SweetAlert
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Actualización exitosa',
                text: 'El equipo se ha actualizado correctamente.',
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                }
            });
          </script>";
    exit;
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
          <h1>Modificar Equipo</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="listado_equipos_admin.php">Equipos</a></li>
            <li class="breadcrumb-item active">Modificar Equipo</li>
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
        <h3 class="card-title">Editar información del equipo</h3>

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
        <!-- Formulario para editar el equipo -->
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nombre">Nombre del Equipo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($equipo['nombre']) ?>" required>
          </div>

          <div class="form-group">
            <label for="escudo">Escudo (imagen actual debajo)</label><br>
            <img src="../../img/escudos/<?= strtolower($divisiones[$equipo['division_id'] - 1]['division']); ?>/<?= htmlspecialchars($equipo['escudo']) ?>" width="120" alt="Escudo actual"><br><br>
            <input type="file" class="form-control-file" id="escudo" name="escudo">
            <small class="form-text text-muted">Si no seleccionas una nueva imagen, se mantendrá la actual.</small>
          </div>

          <div class="form-group">
            <label for="division_id">Seleccionar División</label>
            <select class="form-control" id="division_id" name="division_id" required>
              <?php foreach ($divisiones as $division): ?>
                <option value="<?= $division['id'] ?>" <?= $division['id'] == $equipo['division_id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($division['division']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <a href="listadodeequipos.php" class="btn btn-secondary">Cancelar</a>
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

<!-- Main Footer -->
<?php require_once("../../../includes/footer.php"); ?>
</body>
</html>