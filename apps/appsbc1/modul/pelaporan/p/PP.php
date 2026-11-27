<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$lokasi				=$_SESSION['lokasi'];

$d					=$_POST['d'];
$m					=$_POST['m'];
$y					=$_POST['y'];
$tgl				="$y-$m-$d";
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
$thn_kondisi		="$y-01-01";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

?>


<style type="text/css">
<!--
.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px;font-weight: bold;  }
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Arial, Helvetica, sans-serif}
.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="10" class="bottom">
			<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. Pi  Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN ANGGOTA <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Pemanfaat - Loan ID</a></th>
			  <th width="4%" rowspan="2" class="left bottom">Tgl Cair</a></th>
              <th width="3%" rowspan="2" class="left bottom">Tem<br>po</a></th>
              <th width="7%" rowspan="2" class="left bottom">Alokasi</a></th>
              <th colspan="2" class="left bottom">Target Pengembalian</a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulL;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi <?php echo $judulC;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulC;?> </a></th>
              <th width="8%" rowspan="2" class="left bottom">Saldo Pinjaman </th>
              <th width="2%" rowspan="2" class="left bottom">%</th>
              <th colspan="2" class="left bottom right">Tunggakan Pengembalian</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom right">Jasa</th>
            </tr>
		<?php
		$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.status='A' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R'
		ORDER BY pi.tgl_cair ASC"); 
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$tgl_lunas		=$row['tgl_lunas'];
		$status			=$row['status'];
		$targetpokok	=targetpokok($tgl_kondisi."-".$idp);
		$targetjasa		=targetjasa($tgl_kondisi."-".$idp);
		$reallalu		=sumpokok("$tgl_kondisilalu-$idp");
		$reallalujasa	=sumjasa("$tgl_kondisilalu-$idp");
		$realpokok		=realisasiinipokok("$tgl_kondisi-$kc-$idp");
		$realjasa		=realisasiinijasa("$tgl_kondisi-$kc-$idp");
		$sumpokok		=sumpokok("$tgl_kondisi-$idp");
		$sumjasa		=sumjasa($tgl_kondisi."-".$idp);
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		
		$angsuranke		=angsuranke($tgl_kondisi."-".$idp);
		
		?>
		<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[nik] $row[namadepan] - $idp"; ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($row['tgl_cair']); ?></td>
			  <td class="left top" align="center">	<?php echo "$row[jangka]/$row[sistem]*$angsuranke";?></td>
			  <td class="left top">					<?php echo number_format($alokasi);?></td>
              <td class="left top">					<?php echo number_format($targetpokok);?></td>
              <td class="left top">					<?php echo number_format($targetjasa);?></td>
			  <td class="left top">					<?php echo number_format($reallalu);?></td>              
              <td class="left top">					<?php echo number_format($reallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($realpokok);?></td>
              <td class="left top">					<?php echo number_format($realjasa);?></td>
              <td class="left top">					<?php echo number_format($sumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumjasa);?></td>
              <td class="left top">					<?php echo number_format($saldopinjaman);?></td>
              <td class="left top">					<?php $pros=@($sumpokok/$targetpokok*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			
	<?php if($tgl_lunas<=$tgl_kondisi and $status=="L") { ?>
			  <td class="left top right align-center" colspan="2">V-LUNAS <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="R") { ?>
			  <td class="left top right align-center" colspan="2">Rescedulling <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php }else{ ?>
			<td class="left top">					<?php echo number_format($nunggakpokok);?></td>
			<td class="left top right">				<?php echo number_format($nunggakjasa);?></td>
	<?php } ?>
		</tr>
		<?php 
		$sumalokasi			=$sumalokasi+$alokasi;
		$sumtargetpokok		=$sumtargetpokok+$targetpokok;
		$sumtargetjasa		=$sumtargetjasa+$targetjasa;
		$sumreallalu		=$sumreallalu+$reallalu;
		$sumreallalujasa	=$sumreallalujasa+$reallalujasa;
		$sumrealpokok		=$sumrealpokok+$realpokok;
		$sumrealjasa		=$sumrealjasa+$realjasa;
		$sumsumpokok		=$sumsumpokok+$sumpokok;
		$sumsumjasa			=$sumsumjasa+$sumjasa;
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumnunggakjasa		=$sumnunggakjasa+$nunggakjasa;
		
		} 
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Total</td>
			  <td class="left top">					<?php echo number_format($sumalokasi);?></td>
              <td class="left top">					<?php echo number_format($sumtargetpokok);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasa);?></td>
			  <td class="left top">					<?php echo number_format($sumreallalu);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumsumjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $pros=@($sumsumpokok/$sumtargetpokok*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			  <td class="left top">					<?php echo number_format($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format($sumnunggakjasa);?></td>	
		</tr>
		<td class="style10 top" colspan="17">&nbsp;</td>
</table>

<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>Perkembangan Pinjaman <?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>