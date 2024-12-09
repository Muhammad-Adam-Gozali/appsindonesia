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
                <section class="content">
                    <div class="row">
                      <div class="col-lg-12">
<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];

?>

<!-- SETTING STOP -->
<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
?>


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>

</ol>

<!-- BREADCRUMB -->

<!-- BOX HAPUS BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>

                           
       <!-- BOX INFORMASI -->
    <?php
if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {?>





<?php

        $sqla="SELECT no, COUNT( * ) AS totaldata FROM $forward";
        $hasila=mysqli_query($conn,$sqla);
        $rowa=mysqli_fetch_assoc($hasila);
        $totaldata=$rowa['totaldata'];

?>
                           <div class="box">
            <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> <?php echo $dataapa ?>  <span class="label label-default"><?php echo $totaldata; ?></span>
                    </h3> 

    </div>

<div class="box-body">
<p>
    <a href="add_barang" class="btn bg-blue btn-sm"><i class="fa fa-plus"></i> Tambah</a>
    <a href="barang?q=stokmin" class="btn bg-orange btn-sm"><i class="fa fa-check"></i> Stok Minimal</a>
    <a href="barang" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
</p>
<br>
                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED );

    if(isset($_GET['q'])){
    $sql    = "select * FROM barang WHERE sisa <= stokmin ORDER BY no";    
} else {
    $sql    = "select * FROM barang ORDER BY no";
}
    $result = mysqli_query($conn, $sql);
  
?>
                            <div class="table-responsive">
                                       <table class="table table-bordered table-hover" id="example2" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="width:10px">No</th>
                                                <th style="width:10%">SKU</th>
                                                <th>Nama</th>
                                                 <th>Harga Jual</th>
                                                   <th>Harga Beli</th>
                                                <th>Kategori</th>
                                                 <th>Merek</th>
                                              
                                               
                                                <th>Keterangan</th>
                                               
                                                <?php   if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                                <th>Opsi</th>
                                                <?php }?>
                                            </tr>
                                        </thead>
                                         
                      <tbody>

<?php 
$no_urut="0";
while($fill=mysqli_fetch_assoc($result)) {
?>

                        <tr>
                      <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['hargajual'], $decimal, $a_decimal, $thousand).',-'); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['hargabeli'], $decimal, $a_decimal, $thousand).',-'); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
            <td>
                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                    <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Edit</button>
                     <?php } ?>

                     <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
             <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
                     <?php } ?>
                     </td></tr>
           
   <?php     }       ?>
                  </tbody></table>
                 

                               </div>
                                <!-- /.box-body -->
                            </div>

                          
                        </div>

<?php } else {?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php } ?>
                 


                        <!-- ./col -->
      
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
           <?php footer();?>
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
  

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


 <script>
  $(function () {
    $("#DataTable").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>


    </body>
</html>
