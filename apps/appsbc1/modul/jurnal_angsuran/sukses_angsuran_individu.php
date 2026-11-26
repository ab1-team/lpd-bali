<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi WHERE id_user='$_SESSION[id]' ORDER BY idtp DESC"));
$idtp			=$idt[0];
?>

<script type="text/javascript">
	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}	
</script>

<div class="alert alert-success mt animated fadeInDown">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<i class="fa fa-check-circle"></i> <strong>Notifikasi Transaksi Angsuran ! </strong> <hr>
<div class="text-align-center">
	Angsuran berhasil diposting, silahkan cetak struk angsuran dan notifikasi kartu angsuran dengan klik tombol dibawah ini.<br>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_struk.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mt-sm ml-md"><span class="h1"><i class="glyphicon glyphicon-print"></i></span> <br>Cetak Bukti Pembayaran<br>dengan Printer Inkjet/Laser</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_notif_ka.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mt-sm ml-md"><span class="h1"><i class="glyphicon glyphicon-print"></i></span> <br>Cetak Notifikasi<br>pada Kartu Angsuran</a>
	<img src="images/ok.gif" width="145px"/>
<hr>
<?php
if($_SESSION['sms']=="terkirim"){
	echo "<i class='fa fa-envelope-o'></i><br>Notifikasi pembayaran angsuran ini telah terkirim via SMS ke nomor <b>$_SESSION[telpon]</b>";
}else{
	echo "<div class='text-danger'><i class='fa fa-envelope-o'></i><br>Namun mohon maaf, notifikasi pembayaran angsuran ini tidak dapat kami kirim via SMS, dikarenakan nomor HP penerima tidak valid.</div>";
}
?>
</div>
</div>