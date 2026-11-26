<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan_admin.php";

$table_transaksi	="admin_transaksi";
$jenis_buku			=$_GET['idf'];
$table_rekening		="admin_rekening";

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


$tgl_open		="01";
$tgl_close		="31";
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }
if($tgl_close>28){$tgl_akhir= date('Y-m-t', strtotime("$y-$m-01"));}else{ $tgl_akhir="$y-$m-$tgl_close"; }

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$u=mysql_fetch_array(mysql_query("SELECT * FROM pusat where id='$_SESSION[id]' "));
$jb=mysql_fetch_array(mysql_query("SELECT * FROM admin_buku where id='$idf' "));

if(saldoATD("$tgl_kondisi-$idf")>=saldoATK("$tgl_kondisi-$idf") ) {
$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
}else{
$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
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
			<div class="style9">PT. ASTA BRATA TEKNOLOGI<br>
			JALAN RAYA KOPENG KM 1.5 BANYUURIP II, TEGALREJO MAGELANG
			</div>
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. AB-<?php echo $idf;?></div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>BUKU  <?php echo strtoupper("$jb[nama_jb] <br>$jenis ".tgl_indo($tgl));?><br><br></td>
    </tr>
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="8%" class="style9 top bottom">TANGGAL</th>
	    <th width="6%" class="style9 all">ID.TRX</th>
	    <th width="8%" class="style9 top bottom">KD.REK</th>
	    <th width="35%" class="style9 all">KETERANGAN</th>
	    <th width="12%" class="style9 top bottom">DEBIT</th>
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
		$data=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_kredit AND $kondisi order by tgl_transaksi, urutan, idt asc");
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
		$r=mysql_fetch_array(mysql_query("SELECT * FROM pusat where id='$bb[id_user]' "));
		
		$rekening_debit			=$bb['rekening_debit'];
		$rekening_kredit		=$bb['rekening_kredit'];
		$nama_rekening			=$bb['nama_rekening'];
		$keterangan_transaksi	=$bb['keterangan_transaksi'];
		//

		
		?>
	
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $bb['tgl_transaksi'];?></td>
	    <td class="style9 left right bottom align-center"><?php echo $bb['idt'];?></td>
	    <td class="style9 bottom  align-center"><?php echo $kdrek;?></td>
	    <td class="style9 left bottom right"><?php echo "$keterangan_transaksi";?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($debit);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($kredit);?></td>
	    <td class="style9 bottom right align-right"><?php $prasaldo=$debit-$kredit; if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; } echo number_format($saldosamping);?></td>
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
	     
<?php include "tanda_tangan.php"; ?> 
		 
</body>
<title>BB. Buku Besar <?php echo "$jenis ".tgl_indo($tgl);?></title>