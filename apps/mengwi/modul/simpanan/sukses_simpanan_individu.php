<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$row=mysql_fetch_array(mysql_query("SELECT max(idt) as maxidt FROM $table_transaksi WHERE id_user='$_SESSION[id]' ORDER BY idtp DESC"));
$idt			=$row['maxidt'];

$r=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idt='$idt' ORDER BY idt DESC"));

if($r['rekening_debit']=="1-10001") {$file="c_bkm";} else if($r['rekening_kredit']=="1-10001") {$file="c_bkk";}
?>


<div class="alert alert-success flash animated fadeInDown">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<i class="fa fa-check-circle"></i> <strong>Notifikasi ! </strong> <hr>
<div class="text-align-center">	
	Data simpanan berhasil disimpan, silahkan cetak struk dan notifikasi pada buku tabungan dengan klik tombol dibawah ini.<br>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/<?php echo "$file.php?idt=$idt";?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-150 mt-sm ml-md"><i class="glyphicon glyphicon-print"></i> <br>Cetak Struk<br>Printer Inkjet/Laser</a>
<hr>
<?php
if($_SESSION['sms']=="terkirim"){
	echo "<i class='fa fa-envelope-o'></i><br>Notifikasi pembayaran ini telah terkirim via SMS ke nomor <b>$_SESSION[telpon]</b>";
}else{
	echo "<div class='text-danger'><i class='fa fa-envelope-o'></i><br>Namun mohon maaf, notifikasi pembayaran ini tidak dapat kami kirim via SMS, dikarenakan nomor HP penerima tidak valid.</div>";
}
?>
</div>

</div>

<script> window.setTimeout(function() { $(".alert-success.flash").fadeTo(1000, 0).slideUp(1000, function(){ $(this).remove(); }); }, 9000); </script> 