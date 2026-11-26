<?php session_start();
error_reporting(0);
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
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }


$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
$jum_rekdeb=mysql_num_rows($rekdeb);
$jum_rekred=mysql_num_rows($rekred);


$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }
if($tgl_close>28){$tgl_akhir= date('Y-m-t', strtotime("$y-$m-01"));}else{ $tgl_akhir="$y-$m-$tgl_close"; }

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisilalu="$y-$m-$dl"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisi=$tgl_awal; $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $tgl_kondisilalu="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR  kd_jb='$idf' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
$posisi	=$jb['posisi'];

if($jum_rekdeb<1){
$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
}elseif($jum_rekred<1){
$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
}
else{
if($jb['posisi']=='1') {
$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
}else{
$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
}}
$totsaldoawalbulan	=$totsaldoawaltahun+$saldoawalbulan;
?>


<style type="text/css">
<!--
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px;  }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="<?php echo 4+$jum_rekdeb;?>" class="bottom">
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
		<td height="20" colspan="<?php echo 2+$jum_rekred;?>" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?> (Standar PTO)<br>
			Kd.Doc. BS-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="<?php echo 6+$jum_rekdeb+$jum_rekred;?>" class="style6 bottom"><br>BUKU  <?php echo strtoupper("$jb[nama_jb] $jenis ".tgl_indo($tgl));?> </td>
    </tr>
			<?php 
if($jum_rekdeb<1){ ?>
<tr>
	    <th width="2%"  height="30" class="style10 all">NO</th>
	    <th width="4%"  class="style10 top bottom">TANGGAL</th>
	    <th width="4%"  class="style10 all">ID.TRX</th>
	    <th width="75%"  class="style10 top bottom">KETERANGAN</th>
		<?php while($rk=mysql_fetch_array($rekred)){		//KOLOM KREDIT
		echo "
	    <th width='4%' class='style10 top bottom left'>$rk[nama_rekening]</th>
		";
		}?>
	    <th width="8%" class="style10 all">SALDO</th>
	    <th width="2%" class="style10 top bottom right">P</th>
		</tr>
<?php }elseif($jum_rekred<1){ ?>
<tr>
	    <th width="2%" height="30" class="style10 all">NO</th>
	    <th width="4%" class="style10 top bottom">TANGGAL</th>
	    <th width="4%" class="style10 all">ID.TRX</th>
	    <th width="75%" class="style10 top bottom">KETERANGAN</th>
		<?php 
		while($rd=mysql_fetch_array($rekdeb)){		//KOLOM DEBIT
		echo "
	    <th width='4%' class='style10 top bottom left'>$rd[nama_rekening]</th>
		";
		}?>
	    <th width="8%" class="style10 all">SALDO</th>
	    <th width="2%" class="style10 top bottom right">P</th>
		</tr>
<?php }else{ ?>
	<tr>
	    <th width="2%" rowspan="2" height="30" class="style10 all">NO</th>
	    <th width="4%" rowspan="2" class="style10 top bottom">TANGGAL</th>
	    <th width="4%" rowspan="2" class="style10 all">ID.TRX</th>
	    <th width="75%" rowspan="2" class="style10 top bottom">KETERANGAN</th>
	    <th width="4%" class="style10 top left" colspan="<?php echo $jum_rekdeb;?>">DEBIT</th>
	    <th width="4%" class="style10 left top" colspan="<?php echo $jum_rekred;?>">KREDIT</th>
	    <th width="8%" rowspan="2" class="style10 all">SALDO</th>
	    <th width="2%" rowspan="2" class="style10 top bottom right">P</th>
    </tr>
	<tr>
		 <?php
		
		while($rd=mysql_fetch_array($rekdeb)){		//KOLOM DEBIT
		echo "
	    <th width='4%' class='style10 top bottom left'>$rd[nama_rekening]</th>
		";
		}
		
		while($rk=mysql_fetch_array($rekred)){		//KOLOM KREDIT
		echo "
	    <th width='4%' class='style10 top bottom left'>$rk[nama_rekening]</th>
		";
		}
		
		?>

    </tr>
		<?php }?>
	<tr>
                            <td class="style10 all align-center">&nbsp;</td>
							<td class="style10 top bottom align-center"><?php echo $y;?>-01-01</td>
							<td class="style10 all align-center">SAT</td>
							<td class="style10 top bottom">Saldo Awal <?php echo $y;?> (TB. <?php echo $y-1;?>)</td>
			<?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
							
							while($rd=mysql_fetch_array($rekdeb)){		//SALDO AWAL TAHUN DEBIT
							echo "
							<td width='4%' class='style10 top bottom left align-right'>".number_format_koma(SATDR("$tgl_kondisi-$rd[kd_rekening]"))."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//SALDO AWAL TAHUN KREDIT
							echo "
							<td width='4%' class='style10 top bottom left align-right'>".number_format_koma(SATKR("$tgl_kondisi-$rk[kd_rekening]"))."</td>
							";
							}
			?>
                            <td class="style10 all align-right"><?php echo number_format_koma($totsaldoawaltahun);?></td>
							<td class="style10 top bottom right">&nbsp;</td>
	</tr>
	<tr>
                            <td class="style10 left bottom right align-center">&nbsp;</td>
							<td class="style10 bottom align-center"><?php echo $tgl_kondisi;?></td>
							<td class="style10 left bottom right align-center">SAB</td>
							<td class="style10 bottom">Saldo Awal <?php echo $jenis." Per ".tgl_indo($tgl_kondisi);?></td>
			<?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
							
							while($rd=mysql_fetch_array($rekdeb)){		//SALDO AWAL BULAN DEBIT
							echo "
							<td width='4%' class='style10 bottom left align-right'>".number_format_koma(SABDR("$tgl_kondisilalu-$rd[kd_rekening]"))."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//SALDO AWAL BULAN KREDIT
							echo "
							<td width='4%' class='style10 bottom left align-right'>".number_format_koma(SABKR("$tgl_kondisilalu-$rk[kd_rekening]"))."</td>
							";
							}
			?>
                            <td class="style10 left bottom right align-right"><?php echo number_format_koma($totsaldoawalbulan);?></td>
							<td class="style10 bottom right">&nbsp;</td>
	</tr>
	  <?php
		$data=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_kredit AND $kondisi  order by tgl_transaksi, urutan, idt asc");
		$no=0;
		while($bb=mysql_fetch_array($data)){
		$no=$no+1;
		if($bb['rekening_debit']==$bb['kd_rekening']) {
										$sdebit	=$bb['jumlah'];
										$skredit	="0";
										}else if($bb['rekening_kredit']==$bb['kd_rekening']){
										$sdebit	="0";
										$skredit	=$bb['jumlah'];
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
		$ds=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k, desa d WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$bb[id_pinj]' "));
		if($bb['id_pinj'] >0) { $keterangan_transaksi="$keterangantransaksi $ds[nama_desa]"; }else{ $keterangan_transaksi="$keterangantransaksi $ds[nama_desa]"; }
		
		?>
	<tr>
	    <td height="25" class="style10 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style10 bottom align-center"><?php echo $bb['tgl_transaksi'];?></td>
	    <td class="style10 left right bottom align-center"><?php echo $bb['idt'];?></td>
	    <td class="style5 bottom"><?php echo $keterangan_transaksi;?></td>
		<?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
							
							while($rd=mysql_fetch_array($rekdeb)){		//TRANSAKSI DEBIT
							if($bb['rekening_debit']==$rd['kd_rekening']) {
										$debit	=$bb['jumlah'];
										$kredit	="0";
										}else{
										$debit	="0";
										$kredit	=$bb['jumlah'];
										}
							echo "
							<td width='4%' class='style10 bottom left align-right'>".number_format_koma($debit)."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//TRANSAKSI KREDIT
							if($bb['rekening_kredit']==$rk['kd_rekening']) {
										$kredit	=$bb['jumlah'];
										$debit	="0";
										}else{
										$kredit	="0";
										$debit	=$bb['jumlah'];
										}
							echo "
							<td width='4%' class='style10 bottom left align-right'>".number_format_koma($kredit)."</td>
							";
							}
			?>
	    <td class="style10 left bottom right align-right"><?php if($jum_rekdeb<1) {$prasaldo=$skredit-$sdebit;}elseif($jum_rekred<1){$prasaldo=$sdebit-$skredit;}else{ //khusus untuk pendapatan dan biaya operasional
		if($posisi=="1" OR $posisi=="5") { $prasaldo=$sdebit-$skredit; } else if($posisi=="2" OR $posisi=="3" OR $posisi=="4") { $prasaldo=$skredit-$sdebit; }} 
		if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; } echo number_format_koma($saldosamping);?></td>
	    <td class="style10 bottom right align-center"><?php echo $r['ins'];?></td>
	</tr>
  <?php 

  } 
  $saldo=saldo("$tgl_kondisisaldo-$idf");
								if($jb['posisi']=='1') {
								$saldo=$saldo;
								$ketsaldo="Saldo Debit";
								}elseif($saldo<0){
								$saldo=$saldo*-1;
								$ketsaldo="Saldo Kredit";
								}
  ?>
	<tr>
	    <td height="25" class="style27 left bottom" colspan="4">Total Transaksi <?php echo $jenis." ".tgl_indo("$y-$m-$d");?></td>
		<?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
			
							while($rd=mysql_fetch_array($rekdeb)){		//SALDO AWAL BULAN DEBIT
							$rekd=$rd['kd_rekening'];
							$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_debit='$rekd' AND $kondisi"));
							echo "
							<td width='4%'  class='style27 bottom left align-right'>".number_format_koma($sd['sumjumlah'])."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//SALDO AWAL BULAN KREDIT
							$rekk=$rk['kd_rekening'];
							$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_kredit='$rekk' AND $kondisi"));
							echo "
							<td width='4%'  class='style27 bottom left align-right'>".number_format_koma($sk['sumjumlah'])."</td>
							";
							}
			?>
	    <td class="style9 left bottom right align-center" colspan="2" rowspan="3"><br><span class="style6"><?php echo number_format_koma($saldo);?></span></td>
	</tr>
	<tr>
	    <td height="25" class="style27 left bottom" colspan="4">Total Transaksi sampai dengan <?php echo $jenis." ".tgl_indo("$y-$m-$d");?></td>
	    <?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
			
							while($rd=mysql_fetch_array($rekdeb)){		//SALDO AWAL BULAN DEBIT
							$rekd=$rd['kd_rekening'];
							$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_debit='$rekd' AND $kondisi"));
							echo "
							<td width='4%'  class='style27 bottom left align-right'>".number_format_koma(SABDR("$tgl_kondisilalu-$rekd")+$sd['sumjumlah'])."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//SALDO AWAL BULAN KREDIT
							$rekk=$rk['kd_rekening'];
							$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_kredit='$rekk' AND $kondisi"));
							echo "
							<td width='4%'  class='style27 bottom left align-right'>".number_format_koma(SABKR("$tgl_kondisilalu-$rekk")+$sk['sumjumlah'])."</td>
							";
							}
			?>
	</tr>
	<tr>
	    <td height="25" class="style27 left bottom" colspan="4">Total Transaksi Komulatif sampai dengan Tahun <?php echo $y;?></td>
	    <?php
			$rekdeb=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='debit' order by kd_rekening asc"); //Rekening Debit
			$rekred=mysql_query("select * from $table_rekening WHERE kd_jb='$idf' AND jenis_mutasi='kredit' order by kd_rekening asc"); //Rekening Debit
			
							while($rd=mysql_fetch_array($rekdeb)){		//SALDO AWAL BULAN DEBIT
							$rekd=$rd['kd_rekening'];
							$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_debit='$rekd' AND $kondisi"));
							echo "
							<td width='4%'  class='style27 bottom left align-right'>".number_format_koma(SATDR("$tgl_kondisi-$rekd")+SABDR("$tgl_kondisilalu-$rekd")+$sd['sumjumlah'])."</td>
							";
							}
							
							while($rk=mysql_fetch_array($rekred)){		//SALDO AWAL BULAN KREDIT
							$rekk=$rk['kd_rekening'];
							$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_kredit='$rekk' AND $kondisi"));
							echo "
							<td width='4%' class='style27 bottom left align-right'>".number_format_koma(SATKR("$tgl_kondisi-$rekk")+SABKR("$tgl_kondisilalu-$rekk")+$sk['sumjumlah'])."</td>
							";
							}
			?>
	</tr>
</table>
<br>
<?php  if ($_SESSION['lokasi']=='209') {?>
<table  width="96%" border="0" align="center" cellpadding="3" cellspacing="0">

	<tr>
		<td class="style27 align-center" colspan="3" valign="top" width="31%">Dilaporkan Oleh <?php echo $row['nama_lembaga_sort']; ?> </td>
	</tr>
	<tr>
		<td class="style5 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Ahmad Susyanto
			</u><br>
			Manajer
		</p>
		</td>
		<td class="style5 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Hartono L
			</u><br>
			Ka Div Operasional
		</p>
		</td>
		<td class="style5 align-center" valign="top" width="31%">
			<p></p>&nbsp;&nbsp;&nbsp;
			<p></p>&nbsp;&nbsp;&nbsp;
			<p align="center"><u>Aprilia Eka K
			</u><br>
			Kasir
		</p>
		</td>
	</tr>
</table>

<?php }else{ ?>

<?php include "tanda_tangan.php"; ?> 
<?php  } ?> 
         
</body>
<title>BS-<?php echo $idf;?>. <?php echo "$jb[nama_jb] $jenis ".tgl_indo($tgl);?></title>