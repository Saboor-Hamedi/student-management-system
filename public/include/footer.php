<script src="<?php assets("plugins/jquery/jquery.min.js") ?>"></script>
<script src="<?php assets("plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php assets("dist/js/adminlte.js") ?>"></script>
<!-- ajax -->
<script src="<?php assets("js/ajax-jquery.min.js") ?>"></script>
<!-- datetimepicker -->
<script src="<?php assets("datetimepicker/jquery.datetimepicker.full.js") ?>"></script>
<script src="<?php assets("datetimepicker/jquery.datetimepicker.full.min.js") ?>"></script>
<script src="<?php assets("datetimepicker/jquery.datetimepicker.min.js") ?>"></script>
<script src="<?php assets("js/Loadgrades.js") ?>"></script>
<script src="<?php assets("js/Loadstudents.js") ?>"></script>
<script src="<?php assets("js/Loadstudentsprofile.js") ?>"></script>
<script src="<?php assets("js/Loadteachers.js") ?>"></script>

<script src="<?php assets("js/custom.js") ?>"></script>


<!-- datetimepicker -->
<script>
  $(document).ready(function() {
    $("#start_subject_time").datetimepicker({
      format: 'Y-m-d H:i',
      formatTime: 'H:i:s',
      minDate: true,
      minDate: '2010-01-01 00:00',
      hours12: true,
    });
  });
  // subject end time
  $(document).ready(function() {
    $("#end_subject_time").datetimepicker({
      format: 'Y-m-d H:i',
      formatTime: 'H:i:s',
      minDate: true,
      minDate: '2010-01-01 00:00',
      hours12: true,
    });
  });
</script>
<script>
  window.addEventListener('load', function() {
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  });
</script>
</body>

</html>