<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "restore"; // halaman
$dataapa = "restore"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu


 
?>


<?php
ini_set('max_execution_time', '300');
if(isset($_POST['restore'])){

// Database connection settings
 $host = mysqli_real_escape_string($conn, $_POST["servername"]);
    $password = mysqli_real_escape_string($conn, $_POST["pass"]);
    $username = mysqli_real_escape_string($conn, $_POST["user"]);
    $database = mysqli_real_escape_string($conn, $_POST["db"]);
    

// Step 1: Uploading the SQL file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sqlFile']) && $_FILES['sqlFile']['error'] === UPLOAD_ERR_OK) {
    
      // Validate file extension
    $allowedExtensions = ['sql'];
    $fileExtension = pathinfo($_FILES['sqlFile']['name'], PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $allowedExtensions)) {
         echo "<script type='text/javascript'>  alert('GAGAL, file yang di upload bukan file sql');</script>";
        echo "<script type='text/javascript'>window.location = 'restore';</script>";
        exit;
    }
    
    $sqlFile = $_FILES['sqlFile']['tmp_name'];

    // Step 2: Restoring the database
    $mysqli = new mysqli($host, $username, $password);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
         echo "<script type='text/javascript'>  alert('GAGAL, Koneksi ke database tidak berhasil dilakukan');</script>";
                    echo "<script type='text/javascript'>window.location = 'backup';</script>";
    }

    // Drop and recreate the database
    $mysqli->query("DROP DATABASE IF EXISTS $database;");
    $mysqli->query("CREATE DATABASE $database;");
    $mysqli->select_db($database);

    // Execute the SQL queries from the uploaded file
    $sql = file_get_contents($sqlFile);
    
    
    if($mysqli->multi_query($sql)){
      echo "<script type='text/javascript'>  alert('BERHASIL, Database telah di restore! Silahkan logout dulu');</script>";
                    echo "<script type='text/javascript'>window.location = 'backup';</script>";
    } else {
           echo "<script type='text/javascript'>  alert('GAGAL restore dengan cara ini, anda bisa mencoba melakukan restore melalui PHPmyadmin!');</script>";
                    echo "<script type='text/javascript'>window.location = 'backup';</script>";
    }
    
} else {
     echo "<script type='text/javascript'>  alert('GAGAL, proses upload gagal, coba lagi!');</script>";
                     echo "<script type='text/javascript'>window.location = 'restore';</script>";
}



}
?> 


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="backup">Backup</a></li>

 <li class="active">Data <?php echo $dataapa ?></li>
  
</ol>

<!-- BREADCRUMB -->

<!-- BOX INSERT BERHASIL -->



       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Restore Database</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="col-lg-6">

Lakukan restore database apabila diperlukan. Silakan klik upload <strong>"file .sql yang telah dibackup sebelumnya"</strong> untuk memulai proses restore. Selama proses restore dilarang meninggalkan/menutup halaman ini.<span class="red-text"><strong>*</strong></span><br><br>

<p>isikan Password akun yang anda pakai saat login (Harus berjabatan admin)</p>
</div>

<div class="col-lg-6">

 <div class="box box-primary col-lg-6">
            <div class="box-header with-border">
              <h3 class="box-title">Upload Database</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="" enctype="multipart/form-data"
        id="frm-restore">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputFile">Pilih File database</label>
                  <input type="file" name="sqlFile" class="input-file"  required>

                  <p class="help-block">Hanya upload file dengan format .sql.</p>
                </div>

                 <div class="form-group">
                

                  <input type="hidden" name="servername" value="<?php echo $servername;?>" required>
                  <input type="hidden" name="user" value="<?php echo $username;?>" required>
                  <input type="hidden" name="pass" value="<?php echo $password;?>" >
                  <input type="hidden" name="db" value="<?php echo $dbname;?>" required>

                  
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="restore" value="Restore" class="btn btn-primary">Restore</button>
              </div>
            </form>
          </div>
<?php
if (! empty($response)) {
    ?>
<div class="response <?php echo $response["type"]; ?>">
<?php echo nl2br($response["message"]); ?>
</div>
<?php
}
?>
        </div>

                    </div>            <!-- /.box-body -->
                            </div>
                        </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>
                        <!-- ./col -->
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->


<!--AUTO Complete-->

</body>
</html>
