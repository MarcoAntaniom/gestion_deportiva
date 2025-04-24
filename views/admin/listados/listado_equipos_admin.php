<?php
require_once("../../../includes/header.php");
require_once("../../../includes/sidebar.php");
?>

<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Listado de Equipos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
            <li class="breadcrumb-item active">Listado de Equipos</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
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

        <?php
        // Obtener divisiones para el filtro
        $divisiones_stmt = $conexion->prepare("SELECT * FROM divisiones");
        $divisiones_stmt->execute();
        $divisiones = $divisiones_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="mb-3">
          <label for="filtroDivision">Filtrar por División:</label>
          <select id="filtroDivision" class="form-control" style="width: 250px;">
            <option value="">Todas las divisiones</option>
            <?php foreach ($divisiones as $division): ?>
              <option value="<?= $division['division']; ?>"><?= $division['division']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Escudo</th>
              <th>División</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT equipos.*, divisiones.division AS nombre_division 
                      FROM equipos 
                      INNER JOIN divisiones ON equipos.division_id = divisiones.id";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($equipos as $equipo): ?>
            <tr>
              <td><?= $equipo['id']; ?></td>
              <td><?= $equipo['nombre']; ?></td>
              <td><img src="../../img/escudos/<?= strtolower($equipo['nombre_division']); ?>/<?= $equipo['escudo'] ?>" alt="Escudo de <?= $equipo['nombre']; ?>" width="50px"></td>
              <td><?= $equipo['nombre_division']; ?></td>
              <td>
                <a href="../editar/editar_equipo.php?id=<?= $equipo['id'] ?>" class="btn btn-warning">Editar</a>
                <button class="btn btn-danger" onclick="confirmarEliminacion(<?= $equipo['id']; ?>)">Eliminar</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">Footer</div>
    </div>
  </section>
</div>

<aside class="control-sidebar control-sidebar-dark"></aside>
<?php require_once("../../../includes/footer.php"); ?>


<?php if (isset($_GET['success']) && $_GET['success'] == 'equipo_eliminado'): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'El equipo ha sido eliminado correctamente.',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'listado_equipos_admin.php';
            }
        });
    </script>
<?php elseif (isset($_GET['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema. Intente nuevamente.',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'listado_equipos_admin.php';
            }
        });
    </script>
<?php endif; ?>

<script>
  function confirmarEliminacion(id) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡Este cambio no se puede deshacer!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'No, cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '../../../src/deleteController.php?id=' + id;
      }
    });
  }
</script>

</body>
</html>