<aside class="control-sidebar control-sidebar-dark">

</aside>
<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 1.0.0.3
  </div>
  <strong>Copyright © 2014 <a href="#">AHS</a>.</strong>
</footer>
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
<script src="<?php //assets("js/loadGrade.js")
              ?>"></script>
<script src="<?php assets("js/loadStudent.js") ?>"></script>
<script src="<?php assets("js/Loadstudentsprofile.js") ?>"></script>
<script src="<?php assets("js/loadTeacher.js") ?>"></script>
<script src="<?php assets("js/loadSearch.js") ?>"></script>
<script src="<?php assets("js/DeleteScore.js") ?>"></script>
<script src="<?php assets("js/DeleteStudent.js") ?>"></script>
<script src="<?php assets("js/DeleteTeacher.js") ?>"></script>
<script src="<?php assets("js/flashMessage.js") ?>"></script>
<script src="<?php assets("js/RefreshPage.js") ?>"></script>

<script src="<?php assets("js/custom.js") ?>"></script>
<script src="<?php assets("js/CloseFlashMessage.js") ?>"></script>


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

</body>

</html>
