<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$tanggal		= $_POST['tanggal'];
$bulan			= $_POST['bulan'];
$tahun			= $_POST['tahun'];
$cari			= $_POST['cari'];

$file	=substr($cari,0,2);
$idf	=substr($cari,3);
$_SESSION['lokasi']="0"; //untuk membuat bahwa ini bukan level kecamatan

if(empty($cari)) { ?>
<script type="text/javascript">
	$("#Tombol").load('modul/pelaporan/tombol_disabled.php');
</script>
<div id="Tombol"></div>
<?php
}else{
?>

<button href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/<?php echo $file;?>.php?idf=<?php echo $idf;?>&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=<?php echo $tanggal;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="btn btn-default width-100 mb-xs" role="button">
	<h1>
		<i class="glyphicon glyphicon-print text-gray-light"></i>
		
	</h1>
	<span class="fs-sm text-gray">Cetak</span>
</button>
<a href="modul/pelaporan/p/master_excel.php?file=<?php echo $file;?>&idf=<?php echo $idf;?>&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=<?php echo $tanggal;?>" class="btn btn-default width-100 mb-xs" role="button">
	<h1>
		<i class="glyphicon glyphicon-download-alt text-gray-light"></i>
	</h1>
	<span class="fs-sm text-gray">Download</span>
</a>

<?php } ?>