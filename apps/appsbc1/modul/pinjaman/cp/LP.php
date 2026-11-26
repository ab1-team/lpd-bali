<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));

$sT=$_GET['sT'];

$data=mysql_fetch_array(mysql_query("SELECT sum(proposal) as sum_proposal FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' and pk.status='$sT' "));
$data1=mysql_fetch_array(mysql_query("SELECT sum(alokasi) as sum_alokasi FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' and pk.status='$sT' "));

if($sT=="P"){
	$sebutan="PROPOSAL";
	$status="MENUNGGU VERIFIKASI";
	$nama="PROPOSAL";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>";
}elseif($sT=="V"){
	$sebutan="PROPOSAL";
	$status="VERIFIED";
	$nama="VERIFIKASI";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>VERIFIKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="W"){
	$sebutan="PROPOSAL";
	$status="WAITING LIST (DAFTAR TUNGGU PENCAIRAN)";
	$nama="RENCANA CAIR";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>ALOKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>
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
			<td height="20" colspan="8" class="bottom">
				<div class="style9 text-align-left"><?php echo "$kec[nama_lembaga_sort] Kecamatan $kec[nama_kec]";?><br>
				<?php echo $kec['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_kec'];?>
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
              <th width="40%" class="style9 left bottom top">NAMA KELOMPOK</th>
              <th width="2%" class="style9 left bottom top">JENIS</th>
			  <?php echo $kolom;?>
              <th width="4%" class="style9 left bottom top">A</th>
              <th width="15%" class="style9 left bottom top right">KETERANGAN</th>
        </tr>      
		
<?php 	
		$sT=$_GET['sT'];
		$view=mysql_query("SELECT * FROM
																desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp AND k.lokasi='$_SESSION[lokasi]' AND pk.status='$sT' order by tgl_proposal asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$sts			=$row['status'];

									if($sts=="P"){
										$tgl=$row['tgl_proposal'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['proposal'])."</td>";
									}elseif($sts=="V"){
										$tgl=$row['tgl_verifikasi'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['proposal'])."</td>
													  <td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="W"){
										$tgl=$row['tgl_cair'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['proposal'])."</td>
													  <td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="A"){
										$tgl=$row['tgl_cair'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>
													  <td class='style9 left top text-right'>".number_format($saldopinjaman)."</td>";
									}
								
						$jum_pem=mysql_num_rows(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab]
																WHERE
																id_pinkel='$row[id]'"));
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $row['id'];?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $tgl; ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['kd_kelompok']." - ".strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']);?></span></td>
              <td class="style9 left top"><div align="center"><?php echo $row['nama_jpp'];?></div></td>
			  <?php echo $isi_kolom;?>
			  <td class="style9 left top"><div align="center"><?php echo $jum_pem;?></div></td>
              <td class="style9 left top right"><?php echo $row['catatan_verifikasi'];?></td>
            </tr>
  <?php 
$tot_pem	=$tot_pem+$jum_pem;
$sum_saldopinjaman	=$sum_saldopinjaman+$saldopinjaman;
  } ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="5"><div align="center" >JUMLAH</div></th>
              <?php echo $kolom_footer;
			  if ($sT=='A') { 
			  echo "<th class='style9 left bottom top text-right'>".number_format($sum_saldopinjaman)."</th>";
			  }
			  ?>
			  
              <th class="style9 left bottom top"><div align="center"><?php echo number_format($tot_pem);?></div></th>
              <th class="style9 left bottom top right"></th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>12. DAFTAR <?php echo "$sebutan $status";?></title>
       
</body>
