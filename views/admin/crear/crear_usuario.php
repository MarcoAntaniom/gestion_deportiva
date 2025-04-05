<?php
require_once("../../../includes/header.php");
require_once("../../../includes/sidebar.php");

//Obtiene los tipos de usuarios de la base de datos
try {
    $stmt = "SELECT id, nombre FROM tipo_usuario";
    $stmt = $conexion->prepare($stmt);
    $stmt->execute();
    $tipo_usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Verifica si se obtuvieron resultados
    if (empty($tipo_usuario)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontraron tipos de usuario en la base de datos.'
                });
              </script>";
    }
} catch (PDOException $e) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al obtener los tipos de usuario: " . $e->getMessage() . "'
            });
          </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recibe los datos del formulario
    $nombre_usuario = $_POST['nombre'];
    $apellido_usuario = $_POST['apellido'];
    $correo_usuario = $_POST['correo'];
    $clave_usuario = $_POST['clave'];
    $tipo_usuario_id = $_POST['tipo_usuario'];

    try {
        $query = "INSERT INTO usuarios (nombre, apellido, correo, clave, tipo_usuario) VALUES (:nombre, :apellido, :correo, :clave, :tipo_usuario)";
        $stmt = $conexion->prepare($query);

        $stmt->bindParam(':nombre', $nombre_usuario);
        $stmt->bindParam(':apellido', $apellido_usuario);
        $stmt->bindParam(':correo', $correo_usuario);
        $stmt->bindParam(':clave', $clave_usuario);
        $stmt->bindParam(':tipo_usuario', $tipo_usuario_id);
        $stmt->execute();
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Usuario creado exitosamente.'
                }).then(function() {
                    window.location.href = 'listado_usuarios.php';
                });
              </script>";
    } catch (PDOException $e) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al crear el usuario: " . $e->getMessage() . "'
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
          <h1>Crear Usuario</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="listado_usuarios.php">Usuario</a></li>
            <li class="breadcrumb-item active">Crear Usuario</li>
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
        <!-- Aquí iría el contenido que deseas mostrar sin el formulario -->
        <form action="crear_usuario.php" method="POST">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre">Nombre del Usuario</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del usuario" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido del Usuario</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese el apellido del usuario" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo electrónico" required>
                </div>

                <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingrese la contraseña" required>
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario</label>
                    <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                        <option value="">Seleccione un tipo</option>
                        <?php foreach ($tipo_usuario as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Crear Usuario</button>
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