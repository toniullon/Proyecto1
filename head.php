

<?php 

    $dir_ = '';
    if(file_exists("../plugins")){
        $dir_ = '../';
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo $dir_; ?>plugins/summernote/summernote-bs4.min.css">
</head>