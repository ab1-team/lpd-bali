<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id	= $_POST['nia'];
$id_pinkel	= $_POST['id_pinkel'];


$cek_nia=mysql_num_rows(mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE id='$id' "));

$r=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE id='$id' "));


$cek_id=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$id' AND `status`='P' OR nia='$id' AND `status`='V' OR nia='$id' AND `status`='W' OR nia='$id' AND `status`='M'  OR nia='$id'  AND `status`='B' ");
$row=mysql_fetch_array($cek_id);

$cek_a=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$id' AND `status`='A' ");
$a=mysql_fetch_array($cek_a);

$cek_b=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$id' AND `status`='B' ");
$b=mysql_fetch_array($cek_b);

$kel=mysql_fetch_array(mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
 WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$row[id_pinkel]' "));
 
 $kela=mysql_fetch_array(mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
 WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$a[id_pinkel]' "));

$jum_p=mysql_num_rows($cek_id);
$jum_a=mysql_num_rows($cek_a);
$jum_b=mysql_num_rows($cek_b);

if ($cek_nia>0 AND $jum_b>0 AND $b['jenis_pinjaman']=='I' ){
?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $r['namadepan'];?></strong> tidak dapat ditambahkan
			<p class="fs-mini text-muted mt-sm">Alasan penolakan:</p>
		YBS telah masuk ke daftar Black List sejak tanggal  <br> <strong><?php echo "$b[tgl_proposal]";?></strong><br>
		
	</div>
	</div>
</div>

<?php } else  
if ($cek_nia>0 AND $jum_p>0 AND $row['jenis_pinjaman']=='K' AND $row['id_pinkel']!=$id_pinkel ){
?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $r['namadepan'];?></strong> tidak dapat ditambahkan
			<p class="fs-mini text-muted mt-sm">Alasan penolakan:</p>
		Telah terdaftar pada proposal Kelompok <br> <strong><?php echo "$kel[nama_kelompok] Desa $kel[nama_desa]";?></strong><br>
		Dengan Loan ID: <strong><?php echo $row['id_pinkel']?></strong>, Status : <strong><?php echo $row['status']?></strong>
	</div>
	</div>
</div>

<?php } else if ($cek_nia>0 AND $jum_p>0 AND $row['jenis_pinjaman']=='I' ){ ?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $r['namadepan'];?></strong> tidak dapat ditambahkan
			<p class="fs-mini text-muted mt-sm">Alasan penolakan:</p>
		Telah terdaftar pada proposal Individu <br> sebesar Rp. <strong><?php echo number_format($row['alokasi']);?></strong><br>
		Dengan Loan ID: <strong><?php echo $row['id']?></strong>, Status : <strong><?php echo $row['status']?></strong>
	</div>
	</div>
</div>

<?php } else if ($cek_nia>0 AND $jum_a>0 AND $jum_p<=0 ){ ?>

<div class="alert alert-info">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-info"></i>
			</span>
		</div>
	<div class="col-xs-9">
		INFORMASI:<BR><strong><?php echo $r['namadepan'];?></strong> sedang memiliki pinjaman Aktif
		<?php $jenis_pinjaman=$a['jenis_pinjaman'];
		if($jenis_pinjaman=='K') {echo "<b>Kelompok $kela[nama_kelompok] Desa $kela[nama_desa]</b>";} elseif($jenis_pinjaman=='I') {echo"Individu";}
			?>
		sebesar Rp. <strong><?php echo number_format($a['alokasi']);?></strong>
		Dengan Loan ID: <strong><?php echo "$a[id_pinkel]/$a[id]"?></strong>, Status : <strong><?php echo $a['status']?></strong>
	</div>
	</div>
</div>

<?php } else if ($cek_nia<=0) { ?>

<div class="alert alert-danger">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-3">
			<span class="widget-icon" style="font-size:100px;">
				<i class="fa fa-warning"></i>
			</span>
		</div>
	<div class="col-xs-9">
		Maaf, <strong><?php echo $id;?></strong> tidak dikenal, silahkan pilih Nama Penduduk kembali, dan klik enter...
	</div>
	</div>
</div>

<?php } else { ?>

<div class="alert alert-success">
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<div class="row">
		<div class="col-xs-2">
			<span class="widget-icon" style="font-size:40px;">
				<i class="glyphicon glyphicon-user"></i>
			</span>
		</div>
	<div class="col-xs-10">
		Silahkan masukkan alokasi untuk, <strong><?php echo $r['namadepan'];?></strong>...
	</div>
	</div>
</div>

<?php } ?>