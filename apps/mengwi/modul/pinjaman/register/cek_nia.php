<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$nia		= $_POST['nia'];
$id_pinkel	= $_POST['cek_kel'];

$pa=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.nia='$nia' AND pa.id_pinkel='$id_pinkel' "));
$kel=mysql_fetch_array(mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
 WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$id_pinkel' "));
 
 $jenis_pinjaman=$pa['jenis_pinjaman'];
 
 if($jenis_pinjaman=='K') {
?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
<legend>Early Warning System (EWS)</legend>
	<div class="row">
		
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $pa['namadepan'];?></strong> tidak dapat ditambahkan
			<p class="fs-mini text-muted mt-sm">Alasan penolakan:</p>
		Telah terdaftar pada proposal Pinjaman Kelompok <br> <strong><?php echo "$kel[nama_kelompok] Desa $kel[nama_desa]";?></strong><br>
		sebesar Rp. <strong><?php echo number_format($pa['proposal']);?></strong>
		Loan ID: <strong><?php echo $id_pinkel; ?></strong>, Status : <strong><?php echo $pa['status']?></strong>
	</div>
	</div>
</div>

<?php
 }else if($jenis_pinjaman=='I') {
?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
<legend>Early Warning System (EWS)</legend>
	<div class="row">
		
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $pa['namadepan'];?></strong> tidak dapat ditambahkan
			<p class="fs-mini text-muted mt-sm">Alasan penolakan:</p>
		Telah terdaftar pada proposal Pinjaman Individu <br> sebesar Rp. <strong><?php echo number_format($pa['proposal']);?></strong><br>
		Dengan Loan ID: <strong><?php echo $pa['id'];; ?></strong>, Status : <strong><?php echo $pa['status'];?></strong>
	</div>
	</div>
</div>

<?php
 }
?>