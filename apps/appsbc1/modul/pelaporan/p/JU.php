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

$tgl				="$y-$m-$d";

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi="$y-$m-01"; $kondisi="tgl_transaksi between '$y-$m-01' AND '$y-$m-31' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR  kd_jb='$idf' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
$posisi	=$jb['posisi'];
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
			<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_lpd.gif' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="SK Gubernur Bali No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>LEMBAGA PERKREDITAN DESA (LPD) <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>

			
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
	    <td class="style9 bottom align-center"><?php echo tgl_ind($ju['tgl_transaksi']);?></td>
	    <td class="style9 left right bottom align-center"><?php echo $ju['idt'];?></td>
	    <td class="style9 bottom"><?php echo $ju['keterangan_transaksi'];?></td>
	    <td class="style9 left bottom right align-center"><?php echo $ju['rekening_debit'];?></td>
	    <td class="style9 bottom align-center"><?php echo $ju['rekening_kredit'];?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($ju['jumlah']);?></td>
	    <td class="style9 bottom right align-center"><?php echo $r['ins'];?></td>
	</tr>
  <?php } ?>
</table>

<?php include "tanda_tangan.php"; ?>
	          
</body>
<title>JU02. Jurnal Transaksi <?php echo "$jenis ".tgl_indo($tgl);?></title>