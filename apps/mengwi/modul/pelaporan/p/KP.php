<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi				=$_SESSION[lokasi];

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

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];
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
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom" width="5%">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
						echo "</td>";
						echo "<td class='bottom'>";
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
			KP-<?php echo $idf;?> Lembar-1</div></td>
	  </tr> 
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
     <tr>
        <td height="20" colspan="5" class="style6 bottom"><br>DAFTAR KELOMPOK NON-AKTIF S.D. <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
        <td colspan="2" class="style6 bottom align-right"><br><?php echo $jpp;?></td>
    </tr>
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="10" class="style9 top bottom">ID KELOMPOK</th>
	    <th width="25%" class="style9 all">NAMA KELOMPOK</th>
	    <th width="35%" class="style9 top bottom right">ALAMAT</th>
	    <th width="15%" class="style9 top bottom right">LAST CAIR</th>
	    <th width="2%" class="style9 top bottom right">P</th>
    </tr>
	  <?php
		$data=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND k.jenis_produk_pinjaman='$idf' AND pk.status!='A' AND  pk.tgl_lunas between '0000-00-00' AND '$tgl_kondisi' AND k.lokasi='$lokasi'  ORDER BY tgl_cair DESC");
		while($r=mysql_fetch_array($data)){
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $r['kd_kelompok'];?></td>
	    <td class="style9 left right bottom"><?php echo $r['nama_kelompok'];?></td>
	    <td class="style9 bottom right"><?php echo $r['alamat_kelompok'];?></td>
	    <td class="style9 bottom right align-center"><?php echo $r['tgl_cair'];?></td>
	    <td class="style9 bottom right align-center"><?php echo $row['ins'];?></td>
	</tr>
  <?php } ?>
</table>
	
<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>KP<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>