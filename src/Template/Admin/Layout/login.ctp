<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?= $this->Html->css([
      'admin/bootstrap/css/bootstrap.min.css',
      'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
      'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
      'admin/dist/css/AdminLTE.min.css',
      'admin/dist/css/skins/_all-skins.min.css',
      'admin/plugins/iCheck/flat/blue.css',
      'admin/plugins/morris/morris.css',
      'admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
      'admin/plugins/datepicker/datepicker3.css',
      'admin/plugins/daterangepicker/daterangepicker.css',
      'admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
      'admin/plugins/datatables/dataTables.bootstrap.css'
  ]) ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">

<?= $this->fetch('content') ?>

<?= $this->Html->script([
  'admin/plugins/jQuery/jquery-2.2.3.min.js',
  'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
  'admin/bootstrap/js/bootstrap.min.js',
  'admin/plugins/datatables/jquery.dataTables.min.js',
  'admin/plugins/datatables/dataTables.bootstrap.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
  'admin/plugins/morris/morris.min.js',
  'admin/plugins/sparkline/jquery.sparkline.min.js',
  'admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
  'admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
  'admin/plugins/knob/jquery.knob.js',
  'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
  'admin/plugins/daterangepicker/daterangepicker.js',
  'admin/plugins/datepicker/bootstrap-datepicker.js',
  'admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
  'admin/plugins/slimScroll/jquery.slimscroll.min.js',
  'admin/plugins/fastclick/fastclick.js',
  'https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js'
]) ?>

<?= $this->Html->script([
  'admin/dist/js/app.min.js',
  'admin/dist/js/demo.js'
]) ?>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>