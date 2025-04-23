<?php
require_once("../../../includes/header.php");
require_once("../../../includes/sidebar.php");

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Actualizar datos en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, tipo_usuario = :tipo_usuario WHERE id = :id");
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellido", $apellido);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":tipo_usuario", $tipo_usuario);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        echo "
        <script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Usuario actualizado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = 'listado_usuarios.php';
        });
        </script>";
    } else {
        echo "
        <script>
        Swal.fire({
            title: '¡Error!',
            text: 'Hubo un problema al actualizar el usuario.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    }
}

// Cargar usuario para mostrar en el formulario
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cargar roles desde la tabla tipo_usuario
$stmtRoles = $conexion->prepare("SELECT * FROM tipo_usuario");
$stmtRoles->execute();
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Usuario</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="listado_usuarios.php">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Usuario</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Formulario de edición</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php if ($usuario): ?>
        <form action="" method="POST">
          <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($usuario['nombre']) ?>">
          </div>

          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" class="form-control" required value="<?= htmlspecialchars($usuario['apellido']) ?>">
          </div>

          <div class="form-group">
            <label for="correo">Correo electrónico</label>
            <input type="email" name="correo" class="form-control" required value="<?= htmlspecialchars($usuario['correo']) ?>">
          </div>

          <div class="form-group">
            <label for="tipo_usuario">Rol</label>
            <select name="tipo_usuario" class="form-control" required>
              <option value="">Selecciona un rol</option>
              <?php foreach ($roles as $rol): ?>
                <option value="<?= $rol['id'] ?>" <?= $rol['id'] == $usuario['tipo_usuario'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($rol['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>
          <a href="listado_usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
        <?php else: ?>
        <div class="alert alert-danger">Usuario no encontrado.</div>
        <?php endif; ?>
      </div>
      <div class="card-footer">
        Footer
      </div>
    </div>
  </section>
</div>

<!-- Footer -->
<?php require_once("../../../includes/footer.php"); ?>