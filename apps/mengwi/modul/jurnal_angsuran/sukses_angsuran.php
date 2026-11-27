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
	<i class="fa fa-check-circle"></i> <strong>Notifikasi ! </strong> 
<hr>
<div class="text-align-center">
	Angsuran berhasil diposting, silahkan cetak struk angsuran dan notifikasi kartu angsuran dengan klik tombol dibawah ini.<br>
	
	<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak Struk<br>Printer InkJet/Laser</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str2.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak Struk<br>Tanpa Penyetor</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_ka.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak pada <br>Kartu Angsuran</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str_dot_1.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak Struk <br>Dot Matrik 1</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str_dot_2.php?&idtp=<?php echo $idtp;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak Struk <br>Dot Matrik 2</a>
	
<hr>
<?php

if($_SESSION['notif'] == "ya"){
	if($_SESSION['whatsapp']=="terkirim"){
		echo "<i class='fa fa-envelope-o'></i><br>Notifikasi pembayaran angsuran ini telah terkirim via SmS ke nomor <b>$_SESSION[telpon]</b>";
		// echo $cek;
	}else{
		echo "<div class='text-danger'><i class='fa fa-whatsapp'></i><br>Namun mohon maaf, notifikasi pembayaran angsuran ini tidak dapat kami kirim via SmS, dikarenakan nomor HP penerima tidak validd.</div>". $cek;
		// echo ;
	}
}


// if($_SESSION['sms']=="terkirim"){
// 	echo "<i class='fa fa-envelope-o'></i><br>Notifikasi pembayaran angsuran ini telah terkirim via SMS ke nomor <b>$_SESSION[telpon]</b>";
// }else{
// 	echo "<div class='text-danger'><i class='fa fa-envelope-o'></i><br>Namun mohon maaf, notifikasi pembayaran angsuran ini tidak dapat kami kirim via SMS, dikarenakan nomor HP penerima tidak valid.</div>";
// }
?>
</div>
</div>