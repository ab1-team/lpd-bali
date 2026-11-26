<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi				=$_SESSION['lokasi'];
$table_transaksi	="transaksi_".$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				= "$y-$m-$d";
	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date("Y-m-t", strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }
if($tgl_close>28){$tgl_akhir= date('Y-m-t', strtotime("$y-$m-01"));}else{ $tgl_akhir="$y-$m-$tgl_close"; }

if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $kondisi="tgl_transaksi='$tgl'";}
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="4" class="bottom">
			<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>

			
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. JU02 Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="8" class="style6 bottom"><br>JURNAL TRANSAKSI PERIODE <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="8%" class="style9 top bottom">TANGGAL</th>
	    <th width="6%" class="style9 all">ID.TRX</th>
	    <th width="40%" class="style9 top bottom">KETERANGAN</th>
	    <th width="10%" class="style9 all">KD.DEBIT</th>
	    <th width="10%" class="style9 top bottom">KD.KREDIT</th>
	    <th width="15%" class="style9 all">JUMLAH</th>
	    <th width="2%" class="style9 top bottom right">P</th>
    </tr>
	  <?php
		$data=mysql_query("SELECT * FROM $table_transaksi WHERE $kondisi ORDER BY tgl_transaksi ASC");
		while($ju=mysql_fetch_array($data)){
		$no=$no+1;
		$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$ju[id_user]' "));
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $ju['tgl_transaksi'];?></td>
	    <td class="style9 left right bottom align-center"><?php echo $ju['idt'];?></td>
	    <td class="style9 bottom"><?php echo $ju['keterangan_transaksi'];?></td>
	    <td class="style9 left bottom right align-center"><?php echo $ju['rekening_debit'];?></td>
	    <td class="style9 bottom align-center"><?php echo $ju['rekening_kredit'];?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format_koma($ju['jumlah']);?></td>
	    <td class="style9 bottom right align-center"><?php echo $r['ins'];?></td>
	</tr>
  <?php } ?>
</table>

<?php include "tanda_tangan.php"; ?>
	          
</body>
<title>JU02. Jurnal Transaksi <?php echo "$jenis ".tgl_indo($tgl);?></title>