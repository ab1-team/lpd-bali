<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$kec=mysql_fetch_array(mysql_query("select * from desa d, sebutan_desa sd WHERE sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

$sT=$_GET['sT'];

$query=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.lokasi='$_SESSION[lokasi]' and pi.status='$sT' ");
while($r=mysql_fetch_array($query)){
	$dpr=explode("#",$r['data_proposal']);
	$proposal=$dpr[1];
	$sumproposal=$sumproposal+$proposal;
}
$data1=mysql_fetch_array(mysql_query("SELECT sum(alokasi) as sum_alokasi FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.lokasi='$_SESSION[lokasi]' and pi.status='$sT' "));



if($sT=="P"){
	$sebutan="PROPOSAL PINJAMAN";
	$status="MENUNGGU REKOMENDASI ANALIS";
	$nama="PROPOSAL";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($sumproposal)."</th>";
}elseif($sT=="V1"){
	$sebutan="REKOMENDASI ANALIS";
	$status="MENUNGGU APPROVE KEPALA";
	$nama="REKOMENDASI";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>VERIFIKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($sumproposal)."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="V2"){
	$sebutan="APPROVE KEPALA";
	$status="MENUNGGU APPROVE BAWAS";
	$nama="APPROVED";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>VERIFIKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($sumproposal)."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="V3"){
	$sebutan="APPROVE BADAN PENGAWAS";
	$status="VERIFIED";
	$nama="APPROVED";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>VERIFIKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($sumproposal)."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="W"){
	$sebutan="PROPOSAL PINJAMAN";
	$status="WAITING LIST (DAFTAR TUNGGU PENCAIRAN)";
	$nama="RENCANA CAIR";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>ALOKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($sumproposal)."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="A"){
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="PENCAIRAN";
	$kolom="<th class='style9 left bottom top'>ALOKASI</th><th class='style9 left bottom top'>SALDO</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>
					";
}
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="7" class="bottom">
				<div class="style9 text-align-left"><?php echo "LPD $kec[sebutan_desa] $kec[nama_desa]";?><br>
				<?php echo $kec['alamat_desa'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_desa'];?>
				</div>
			</td>
		  </tr> 	  
</table>
<p align="center" class="style6"><?php echo "$sebutan $status";?><br>Tanggal <?php echo tgl_indo(date('Y-m-d'));?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="5%" class="style9 left bottom top" >LOAN ID</th>
              <th width="7%" class="style9 left bottom top">TGL <?php echo $nama; ?></th>
              <th width="40%" class="style9 left bottom top">NAMA PEMANFAAT</th>
			  <?php echo $kolom;?>
              <th width="15%" class="style9 left bottom top right">KETERANGAN</th>
        </tr>      
		
<?php 	
		$sT=$_GET['sT'];
		$view=mysql_query("SELECT * FROM
																desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																d.id=a.desa AND a.id=pi.nia AND pi.lokasi='$_SESSION[lokasi]' AND pi.status='$sT' order by pi.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$sts			=$row['status'];
								
								$dpr 		= explode("#", $row['data_proposal']);
								$v1 		= explode("#", $row['data_verifikasi_analis']);
								$v2 		= explode("#", $row['data_verifikasi_kepala']);
								$v3 		= explode("#", $row['data_verifikasi_bawas']);
								$dt 		= explode("#", $row['data_waiting']);
									
									if($sts=="P"){
										$tgl=$dpr[0];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($dpr[1])."</td>";
									}elseif($sts=="V1"){
										$tgl=$v1[0];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($dpr[1])."</td>
													  <td class='style9 left top text-right'>".number_format($v1[1])."</td>";
									}elseif($sts=="V2"){
										$tgl=$v2[0];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($dpr[1])."</td>
													  <td class='style9 left top text-right'>".number_format($v2[1])."</td>";
									}elseif($sts=="V3"){
										$tgl=$v3[0];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($dpr[1])."</td>
													  <td class='style9 left top text-right'>".number_format($v3[1])."</td>";
									}elseif($sts=="W"){
										$tgl=$dt[0];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($dpr[1])."</td>
													  <td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="A"){
										$tgl=$row['tgl_cair'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>
													  <td class='style9 left top text-right'>".number_format($saldopinjaman)."</td>";
									}
								
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $row['id'];?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $tgl; ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['nik']." - ".strtoupper($row['namadepan'])." ".strtoupper($row['nama_desa']);?></span></td>
			  <?php echo $isi_kolom;?>
              <td class="style9 left top right"><?php echo $row['catatan_verifikasi'];?></td>
            </tr>
  <?php 
$sum_saldopinjaman	=$sum_saldopinjaman+$saldopinjaman;
  } ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="4"><div align="center" >JUMLAH</div></th>
              <?php echo $kolom_footer;
			  if ($sT=='A') { 
			  echo "<th class='style9 left bottom top text-right'>".number_format($sum_saldopinjaman)."</th>";
			  }
			  ?>

              <th class="style9 left bottom top right"></th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>12. DAFTAR <?php echo "$sebutan $status";?></title>
       
</body>
