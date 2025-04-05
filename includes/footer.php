  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/gestion_deportiva/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/gestion_deportiva/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/gestion_deportiva/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/gestion_deportiva/assets/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="/gestion_deportiva/assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/gestion_deportiva/assets/plugins/raphael/raphael.min.js"></script>
<script src="/gestion_deportiva/assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/gestion_deportiva/assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="/gestion_deportiva/assets/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="/gestion_deportiva/assets/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/gestion_deportiva/assets/js/pages/dashboard2.js"></script>

<script>
  $(document).ready(function () {
    // Función para ajustar la posición del pie de página
    function adjustFooter() {
      var docHeight = $(window).height();
      var footerHeight = $('.main-footer').outerHeight();
      var footerTop = $('.main-footer').position().top + footerHeight;

      if (footerTop < docHeight) {
        $('.main-footer').css({
          position: 'absolute',
          bottom: 0,
          width: '100%',
        });
      } else {
        $('.main-footer').css({
          position: 'relative',
        });
      }
    }

    // Llamar a la función al cargar y redimensionar la ventana
    adjustFooter();
    $(window).resize(adjustFooter);
  });
</script>
</body>
</html>