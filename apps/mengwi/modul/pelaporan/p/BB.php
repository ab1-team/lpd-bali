<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

$lokasi				=$_SESSION['lokasi'];
$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$jenis_buku				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$jenis_buku				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-$tgl_close"; $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-$tgl_close' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR  kd_jb='$idf' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
$posisi	=$jb['posisi'];

if($posisi=="1") {
$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
}else if ($posisi=="2" or $posisi=="3" or$posisi=="4" ) {
$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
}else {
$totsaldoawaltahun	=(saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf"))*-1;
$saldoawalbulan		=(saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf"))*-1;
}
$totsaldoawalbulan	=$totsaldoawaltahun+$saldoawalbulan;
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
.pagebreak  { display:block; page-break-before:always; }
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
			Kd.Doc. BB-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="9" class="style6 bottom"><br>BUKU  <?php echo strtoupper("$jb[nama_jb] $jenis ".tgl_indo($tgl));?></td>
    </tr>
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="8%" class="style9 top bottom">TANGGAL</th>
	    <th width="6%" class="style9 all">ID.TRX</th>
	    <th width="8%" class="style9 top bottom">KD.REK</th>
	    <th width="35%" class="style9 all">KETERANGAN</th>
	    <th width="12%" class="style9 top bottom">DEBET</th>
	    <th width="12%" class="style9 all">KREDIT</th>
	    <th width="12%" class="style9 top bottom right">SALDO</th>
	    <th width="3%" class="style9 top bottom right">P</th>
    </tr>
	<tr>
                            <td class="style9 all align-center">&nbsp;</td>
							<td class="style9 top bottom align-center"><?php echo $y;?>-01-01</td>
							<td class="style9 all align-center">SAT</td>
							<td class="style9 top bottom align-center"><?php echo $idf;?></td>
							<td class="style9 all">Saldo Awal <?php echo $y;?> (TB. <?php echo $y-1;?>)</td>
                            <td class="style9 top bottom align-right"><?php echo number_format(saldoATD("$tgl_kondisi-$idf"));?></td>
                            <td class="style9 all align-right"><?php echo number_format(saldoATK("$tgl_kondisi-$idf"));?></td>
                            <td class="style9 top bottom right align-right"><?php echo number_format($totsaldoawaltahun);?></td>
							<td class="style9 top bottom right">&nbsp;</td>
	</tr>
	<tr>
                            <td class="style9 left bottom right align-center">&nbsp;</td>
							<td class="style9 bottom align-center"><?php echo $tgl_kondisi;?></td>
							<td class="style9 left bottom right align-center">SAB</td>
							<td class="style9 bottom align-center"><?php echo $idf;?></td>
							<td class="style9 left bottom right">Saldo Awal <?php echo $jenis." Per ".tgl_indo($tgl_kondisi);?></td>
                            <td class="style9 bottom align-right"><?php echo number_format(saldoABKD("$tgl_kondisi-$idf"));?></td>
                            <td class="style9 left bottom right align-right"><?php echo number_format(saldoABKK("$tgl_kondisi-$idf"));?></td>
                            <td class="style9 bottom right align-right"><?php echo number_format($totsaldoawalbulan);?></td>
							<td class="style9 bottom right">&nbsp;</td>
	</tr>
	  <?php
		//$kondisi_lokasi	= "r.kd_jb=0";
		$data=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_kredit AND $kondisi  order by tgl_transaksi, urutan, idt asc");
		while($bb=mysql_fetch_array($data)){
		$no=$no+1;
		
		if($bb['rekening_debit']==$bb['kd_rekening']) {
										$debit	=$bb['jumlah'];
										$kredit	="0";
										$kdrek	=$bb['rekening_debit'];
										}elseif($bb['rekening_kredit']==$bb['kd_rekening']) {
										$debit	="0";
										$kredit	=$bb['jumlah'];
										$kdrek	=$bb['rekening_kredit'];
										}
		$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$bb[id_user]' "));
		
		$rekening_debit			=$bb['rekening_debit'];
		$rekening_kredit		=$bb['rekening_kredit'];
		$nama_rekening			=$bb['nama_rekening'];
		//Untuk memunculkan keterangan TRX yg berbeda pada TRX BANK
		if ($rekening_debit=='122.01' OR $rekening_kredit=='121.04' OR $rekening_debit=='121.07' OR $rekening_debit=='121.08'
		OR $rekening_debit=='111.03' OR $rekening_debit=='111.04' OR $rekening_debit=='111.05'
		OR $rekening_debit=='122.01' OR $rekening_kredit=='122.04'  OR $rekening_debit=='123.01' OR $rekening_kredit=='123.04') 
		{ $keterangantransaksi=$nama_rekening; }else{$keterangantransaksi=$bb['keterangan_transaksi'];}
		//
		$ds=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k, desa d WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$bb[id_pinj]'"));
		if($bb['id_pinj'] >0) { $keterangan_transaksi="$keterangantransaksi $ds[nama_desa]"; }else{ $keterangan_transaksi="$keterangantransaksi"; }
		
		?>
	
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $bb['tgl_transaksi'];?></td>
	    <td class="style9 left right bottom align-center"><?php echo $bb['idt'];?></td>
	    <td class="style9 bottom  align-center"><?php echo $kdrek;?></td>
	    <td class="style9 left bottom right"><?php echo "$keterangan_transaksi";?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($debit);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($kredit);?></td>
	    <td class="style9 bottom right align-right"><?php if($posisi=="1" OR $posisi=="5") { $prasaldo=$debit-$kredit; } else if($posisi=="2" OR $posisi=="3" OR $posisi=="4") { $prasaldo=$kredit-$debit; }
			if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; } echo number_format($saldosamping);?></td>
	    <td class="style9 bottom right align-center"><?php echo $r['ins'];?></td>
	</tr>
	
  <?php 
  $sumdebit=$sumdebit+$debit;
  $sumkredit=$sumkredit+$kredit;
  } 
  $saldo=saldo("$tgl_kondisisaldo-$idf");
								if($saldo>0) {
								$saldo=$saldo;
								$ketsaldo="Saldo Debit";
								}elseif($saldo<0){
								$saldo=$saldo*-1;
								$ketsaldo="Saldo Kredit";
								}
  ?>
	<tr>
	    <td height="25" class="style27 left right bottom" colspan="5">Total Transaksi <?php echo $jenis." ".tgl_indo("$y-$m-$d");?></td>
	    <td class="style27 bottom align-right"><?php echo number_format($sumdebit);?></td>
	    <td class="style27 left bottom right align-right"><?php echo number_format($sumkredit);?></td>
	    <td class="style9 bottom right align-center" colspan="2" rowspan="3"><?php echo $ketsaldo;?><br><span class="style6"><?php echo number_format($saldo);?></span></td>
	</tr>
	<tr>
	    <td height="25" class="style27 left right bottom" colspan="5">Total Transaksi sampai dengan <?php echo $jenis." ".tgl_indo("$y-$m-$d");?></td>
	    <td class="style27 bottom align-right"><?php echo number_format(saldoABKD("$tgl_kondisi-$idf")+$sumdebit);?></td>
	    <td class="style27 left bottom right align-right"><?php echo number_format(saldoABKK("$tgl_kondisi-$idf")+$sumkredit);?></td>
	</tr>
	<tr>
	    <td height="25" class="style27 left right bottom" colspan="5">Total Transaksi Komulatif sampai dengan Tahun <?php echo $y;?></td>
	    <td class="style27 bottom align-right"><?php echo number_format(saldoATD("$tgl_kondisi-$idf")+saldoABKD("$tgl_kondisi-$idf")+$sumdebit);?></td>
	    <td class="style27 left bottom right align-right"><?php echo number_format(saldoATK("$tgl_kondisi-$idf")+saldoABKK("$tgl_kondisi-$idf")+$sumkredit);?></td>
	</tr>
</table>
	     
<?php if ($_SESSION['lokasi']=='209') {?>
<table  width="96%" border="0" align="center" cellpadding="3" cellspacing="0">

	<tr>
		<td class="style27 align-center" colspan="3" valign="top" width="31%">Dilaporkan Oleh <?php echo $row['nama_lembaga_sort']; ?> </td>
	</tr>
	<tr>
		<td class="style10 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Ahmad Susyanto
			</u><br>
			Manajer
		</p>
		</td>
		<td class="style10 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Hartono L
			</u><br>
			Ka Div Operasional
		</p>
		</td>
		<td class="style10 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Aprilia Eka K
			</u><br>
			Teller
		</p>
		</td>
	</tr>
</table>

<?php }else{ ?>

<?php if($_SESSION['lokasi']==351) {?>
		    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
		    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
		    <?php include "tanda_tangan.php"; }?> 
<?php }  ?>
		 
</body>
<title>BB. Buku Besar <?php echo "$jenis ".tgl_indo($tgl);?></title>