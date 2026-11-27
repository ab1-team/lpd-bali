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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="5" class="bottom">
			<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. AA-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="7" class="style6 bottom"><br>DAFTAR ANGGOTA AKTIF S.D. <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
        <td colspan="2" class="style6 bottom align-right"><br><?php echo $jpp;?></td>
    </tr>
	<tr>
	    <th rowspan="2" width="4%" height="30" class="style9 all">NO</th>
	    <th rowspan="2" width="15" class="style9 top bottom">KELOMPOK</th>
	    <th rowspan="2" width="12%" class="style9 all">ID ANGGOTA</th>
	    <th rowspan="2" width="20%" class="style9 top bottom">NAMA ANGGOTA</th>
	    <th colspan="2" width="20%" class="style9 all">ALAMAT</th>
	    <th rowspan="2" width="10%" class="style9 top bottom">TGL CAIR</th>
	    <th rowspan="2" width="5%" class="style9 left top bottom">T/S</th>
	    <th rowspan="2" width="10%" class="style9 all">ALOKASI</th>
	    <th rowspan="2" width="2%" class="style9 top bottom right">P</th>
    </tr>
    <tr align="center"  height="30px" class="style9">
		<th width="12%" class="left bottom">Alamat</th>
		<th width="8%" class="left bottom right">Desa</th>
	</tr>
	  <?php
		$data=mysql_query("SELECT * FROM  kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pa, anggota_$_SESSION[kd_kab] a, desa d WHERE  a.id=pa.nia AND sa.id=pa.sistem_angsuran AND k.id=pa.id_kel AND pa.jenis_pp='$idf' AND pa.status='A' AND pa.tgl_lunas between '0000-00-00' AND '$tgl_kondisi' AND a.desa=d.id AND k.lokasi='$lokasi'   ORDER BY id_pinkel ASC");
		while($r=mysql_fetch_array($data)){
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $r['nama_kelompok'];?></td>
	    <td class="style9 left right bottom"><?php echo $r['nik'];?></td>
	    <td class="style9 bottom"><?php echo $r['namadepan'];?></td>
	    <td class="style9 left bottom "><?php echo $r['alamat'];?></td>
	    <td class="style9 left bottom right"><?php echo $r['nama_desa'];?></td>
	    <td class="style9 bottom align-center"><?php echo $r['tgl_cair'];?></td>
	    <td class="style9 bottom left align-center"><?php echo "$r[jangka]/$r[sistem]";?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($r['alokasi']);?></td>
	    <td class="style9 bottom right align-center"><?php echo $row['ins'];?></td>
	</tr>
  <?php } ?>
</table>
<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>
     
</body>
<title>AA<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>