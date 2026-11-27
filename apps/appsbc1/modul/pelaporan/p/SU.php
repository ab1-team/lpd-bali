<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";

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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
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
			Kd.Doc. SU  Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN SIMPANAN UMUM<BR> <?php echo strtoupper("$jenis ".tgl_indo($tgl));?><BR><BR></td>

    </tr>
	<tr>
	    <th width="3%" height="30" class="style9 all">NO</th>
	    <th width="7" class="style9 top bottom">NOMOR REKENING</th>
	    <th width="10%" class="style9 all">TANGGAL BUKA</th>
	    <th width="3%" class="style9 top bottom">CIF</th>
	    <th width="35%" class="style9 all">KREDITUR</th>
	    <th width="10%" class="style9 top bottom">DEBIT</th>
	    <th width="10%" class="style9 left top bottom">KREDIT</th>
	    <th width="10%" class="style9 all">SALDO</th>
	    <th width="2%" class="style9 top bottom right">STATUS</th>
    </tr>
	  <?php
		$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.jenis_simpanan='1' order by si.nomor_rekening asc");
								$no=0;
								while($r=mysql_fetch_array($view)){
		$no=$no+1;
								$idsimp			=$r['id'];
								$tgl_now		=date('Y-m-d');
								$sumnabung		=sumnabung("$tgl_kondisi-$idsimp");
								$sumambil		=sumambil("$tgl_kondisi-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_kondisi-$idsimp");
								$sts			=$r['status'];
		?>
	<tr>
	    <td height="21" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $r['nomor_rekening'];?></td>
	    <td class="style9 left right bottom align-center"><?php echo tgl_ind($r['tgl_buka']);?></td>
	    <td class="style9 bottom align-center"><?php echo $r['id'];?></td>
	    <td class="style9 left bottom right"><?php echo "$r[nik] $r[namadepan]";?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($sumambil);?></td>
	    <td class="style9 bottom left align-right"><?php echo number_format($sumnabung);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($saldosimpanan);?></td>
	    <td class="style9 bottom right align-center"><?php echo $r['nama_status'];?></td>
	</tr>
  <?php 
  $totambil+=$sumambil;
  $totnabung+=$sumnabung;
  $totsaldo=$totnabung-$totambil;
  
  } ?>
  
	<tr>
	    <th height="30" class="style9 left right bottom top" colspan="5"><div align="center">TOTAL</div></th>
	    <th class="style9 bottom top align-right"><?php echo number_format($totambil);?></th>
	    <th class="style9 bottom top left align-right"><?php echo number_format($totnabung);?></th>
	    <th class="style9 left bottom top right align-right"><?php echo number_format($totsaldo);?></th>
	    <th class="style9 bottom top right align-center">&nbsp;</th>
	</tr>
</table>
	<?php include "tanda_tangan.php"; ?>          
</body>
<title>SU <?php echo tgl_indo($tgl);?></title>