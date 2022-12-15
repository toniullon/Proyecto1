<?php 

    $dir_ = '';
    if(file_exists("../plugins")){
        $dir_ = '../';
    }
    
?>

<script src="<?php echo $dir_; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo $dir_; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/sparklines/sparkline.js"></script>
<script src="<?php echo $dir_; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $dir_; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo $dir_; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo $dir_; ?>dist/js/adminlte.js"></script>
<script src="<?php echo $dir_; ?>dist/js/demo.js"></script>
<script src="<?php echo $dir_; ?>dist/js/pages/dashboard.js"></script>
</body>

</html>