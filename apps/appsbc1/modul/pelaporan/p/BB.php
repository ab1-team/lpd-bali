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
	$jenis_buku			=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$jenis_buku			=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi="$y-$m-01"; $kondisi="tgl_transaksi between '$y-$m-01' AND '$y-$m-31' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR  kd_jb='$idf' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
$posisi	=$jb['posisi'];

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
			<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
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
		$keterangan_transaksi	=$bb['keterangan_transaksi'];
		
		?>
	
	<tr>
	    <td height="22" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
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
	     
<?php include "tanda_tangan.php"; ?> 
		 
</body>
<title>BB. Buku Besar <?php echo "$jenis ".tgl_indo($tgl);?></title>