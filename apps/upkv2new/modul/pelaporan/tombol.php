<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$tanggal		= $_POST['tanggal'];
$bulan			= $_POST['bulan'];
$tahun			= $_POST['tahun'];
$cari			= $_POST['cari'];

$file	=substr($cari,0,2);
$idf	=substr($cari,3);

if(empty($cari)) { ?>
<script type="text/javascript">
	$("#Tombol").load('modul/pelaporan/tombol_disabled.php');
</script>
<div id="Tombol"></div>
<?php
}else{
?>

<tr>
	<td colspan="5" height="25" class="fs-sm text-align-center"><?php echo "$cari - $tanggal/$bulan/$tahun";?> is Ready!</td>
</tr>
<tr>
<td>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/<?php echo $file;?>.php?source=<?php echo $_GET['p'];?>&idf=<?php echo $idf;?>&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=<?php echo $tanggal;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="btn btn-default width-100 mb-xs text-primary" role="button">
		<h1>
			<i class="glyphicon glyphicon-globe"></i>
			
		</h1>
		<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> PREVIEW</span>
	</a>
</td>
<td>&nbsp;</td>
<td>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/<?php echo hash("sha512",'bismillahirohmanirrokhim'); ?>/<?php echo $file;?>.php?idf=<?php echo $idf;?>&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=<?php echo $tanggal;?>' )"  class="btn btn-default width-100 mb-xs text-danger" role="button">
		<h1>
			<i class="fa fa-file-pdf-o text-danger"></i>
		</h1>
		<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> P D F</span>
	</a>
</td>
<td>&nbsp;</td>
<td>
	<a href="modul/pelaporan/p/master_excel.php?file=<?php echo $file;?>&idf=<?php echo $idf;?>&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=<?php echo $tanggal;?>"  class="btn btn-default width-100 mb-xs text-success" role="button">
		<h1>
			<i class="fa fa-file-excel-o"></i>
		</h1>
		<span class="fs-sm"><i class="glyphicon glyphicon-download-alt"></i> E X C E L</span>
	</a>
</td>
</tr>

<?php } ?>