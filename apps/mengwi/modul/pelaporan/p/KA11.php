<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$lokasi				=$_SESSION['lokasi'];

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
$thn_kondisi		=$y;

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

if($_SESSION['level']=='kab' and $lokasi<=0 OR $_SESSION['level']=='pusat' and $lokasi<=0){ 
	$levelc="WHERE kd_kab='$_SESSION[kd_kab]'";
}else if ($lokasi>0){
	$levelc="WHERE id='$lokasi' ";
}
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
		<td height="20" colspan="9" class="bottom">
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
		<td height="20" colspan="3" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. KA-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="12" class="style6 bottom"><br>PELAPORAN KHUSUS PENCAIRAN DAN ANGSURAN KELOMPOK <?php echo $jpp;?> AKTIF <i>(Loan Active Only)</i><BR>
		PADA <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
	<tr>
	    <th width='40%' rowspan='2' class='style9 left top bottom' colspan="6" height="30">NAMA KELOMPOK</th>
		
	    <th width='10%' rowspan='2' class='style9 left top bottom'>KETUA KELOMPOK</th>
	    <th width='5%' rowspan='2' class='style9 all'>&sum;A</th>
	    <th width='10%' rowspan='2' class='style9 top bottom'>TGL CAIR</th>
	    <th width='5%' rowspan='2' class='style9 left top bottom'>T/S</th>
	    <th colspan='2' class='style9 ALL'>ALOKASI</th>
    </tr>
	<tr>
		<TH width='10%'class='style9 left bottom'>Pengajuan</th>
		<TH width='10%'class='style9 left bottom RIGHT'>Pencairan</th>
	</tr>
<?php
	$kab=mysql_query("SELECT * FROM kabupaten WHERE id='$_SESSION[kd_kab]' "); //KAB
	$nob=0;
	while($rb=mysql_fetch_array($kab)){
	$nob=$nob+1;
	echo"
	<tr>
		<td height='25' colspan='12' class='style27 all'>$nob. KABUPATEN ".strtoupper($rb['nama_kab'])."</td>
	</tr>
	";
	
	$kec=mysql_query("SELECT * FROM kecamatan $levelc "); // KEC
	$noc=0;
	while($rc=mysql_fetch_array($kec)){
	$noc=$noc+1;
	$_SESSION['lokasi']=$rc['id'];
	echo"
	<tr>
		<td class='left'></td>
		<td height='25' colspan='9' class='style27 left bottom'>$noc. KECAMATAN ".strtoupper($rc['nama_kec'])."</td>
		<td class='style27 bottom align-right'></td>
		<td class='style27 bottom right align-right'><!-------".number_format(alokasiD("$tgl_kondisi-$idf-$rd[id]"))."---------></td>
	</tr>
	";
	
	$des=mysql_query("SELECT * FROM desa WHERE kd_kec='$rc[kd_kec]' "); //START DESA
	$nod=0;
	while($rd=mysql_fetch_array($des)){
	$nod=$nod+1;
	echo"
	<tr>
		<td class='left'></td>
		<td height='25' colspan='2' class='style27 left right'></td>
		<td height='25' colspan='6' class='style27 bottom'>$nod. DESA ".strtoupper($rd['nama_desa'])."</td>
		<td class='style27 bottom align-right'></td>
		<td class='style27 bottom align-right'></td>
		<td class='style27 bottom right align-right'><!---------".number_format(alokasiDA("$tgl_kondisi-$idf-$rd[id]"))."----------></td>
	</tr>
	";
		
		
		
		
	 if($d=$d){
		 $data=mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 

		d.id=k.desa AND k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$rd[id]' AND jenis_pp='$idf'  AND day(pk.tgl_cair) = '$d' AND  pk.`status`='A'
		ORDER BY tgl_cair DESC");
	 }
else if($m=$m){$data=mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		d.id=k.desa AND k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$rd[id]' AND jenis_pp='$idf'  AND month(pk.tgl_cair) = '$m' AND pk.`status`='A'
		ORDER BY tgl_cair DESC");}
		
else if($y=$y){$data=mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 

		d.id=k.desa AND k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$rd[id]' AND jenis_pp='$idf'  AND year(pk.tgl_cair) = '$y' AND pk.`status`='A'
		ORDER BY tgl_cair DESC");}
else{$data=mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 

		d.id=k.desa AND k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$rd[id]' AND jenis_pp='$idf' AND pk.`status`='A'
		ORDER BY tgl_cair DESC");}


		$noc=0;
		while($r=mysql_fetch_array($data)){
		$noc=$noc+1;
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
	<tr>
		<td class='left'></td>
	    <td height="25" class="style9 left right" colspan="2"></td>
	    <td class="style9 right"></td>
	    <td class="style9 bottom"><div align="center"><?php echo $noc;?>. </div></td>
	    <td class="style9 right bottom"><?php echo "$r[kd_kelompok] $r[nama_kelompok]";?></td>
	    <td class="style9 bottom right align-right"><?php echo "$r[ketua]";?></td>
	    <td class="style9 bottom right align-center"><?php echo $ja;?></td>
	    <td class="style9 bottom align-center"><?php echo $r['tgl_cair'];?></td>
	    <td class="style9 bottom left align-center"><?php echo "$r[jangka]/$r[sistem]";?></td>
	    <td class="style9 left bottom align-right"><?php echo number_format($r['proposal']);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($r['alokasi']);?></td>
	</tr>
  <?php } } } } ?>

</table>

<?php include "tanda_tangan.php"; ?> 
        
</body>
<title>KA<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>