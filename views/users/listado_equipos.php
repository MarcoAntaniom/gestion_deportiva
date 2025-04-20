<?php
require_once("../../includes/header.php");
require_once("../../includes/sidebar.php");
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
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Escudo</th>
              <th>División</th>
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
              <td><?= $equipo['nombre']; ?></td>
              <td><img src="../img/escudos/<?= $equipo['escudo'] ?>" alt="Escudo de <?= $equipo['nombre']; ?>" width="50px"></td>
              <td><?= $equipo['nombre_division']; ?></td>
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
<?php require_once("../../includes/footer.php"); ?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</body>
</html>