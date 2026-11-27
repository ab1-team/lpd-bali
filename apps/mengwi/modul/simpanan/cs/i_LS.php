<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]'"));

$sT=$_GET['sT'];

$data=mysql_fetch_array(mysql_query("SELECT sum(proposal) as sum_proposal FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' and pi.status='$sT'  AND pi.jenis_pinjaman='I' "));
$data1=mysql_fetch_array(mysql_query("SELECT sum(alokasi) as sum_alokasi FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' and pi.status='$sT'  AND pi.jenis_pinjaman='I' "));

if($sT=="P"){
	$sebutan="PROPOSAL INDIVIDU";
	$status="MENUNGGU VERIFIKASI";
	$nama="PROPOSAL";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>";
}elseif($sT=="V"){
	$sebutan="PROPOSAL INDIVIDU";
	$status="VERIFIED";
	$nama="VERIFIKASI";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>VERIFIKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="W"){
	$sebutan="PROPOSAL INDIVIDU";
	$status="WAITING LIST (DAFTAR TUNGGU PENCAIRAN)";
	$nama="RENCANA CAIR";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>ALOKASI</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data['sum_proposal'])."</th>
					<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>";
}elseif($sT=="A"){
	$sebutan="LAPORAN SIMPANAN";
	$status="AKTIF";
	$nama="";
	$kolom="<th class='style9 left bottom top'>DEBIT</th><th class='style9 left bottom top'>KREDIT</th>";
	$kolom_footer="<th class='style9 left bottom top text-right'>".number_format($data1['sum_alokasi'])."</th>
					";
}
if($_SESSION['lokasi']=="68" or $_SESSION['lokasi']=="2" or $_SESSION['lokasi']=="128"){
    
	if($row['nama_jpp']=="KB"){$isi=$row['nama_barang'];}else{$isi="-";}
$jbarang = "<th class='style9 left bottom top'>BARANG</th>";
    $jubarang="<th class='style9 left bottom top'></th>";
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
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
           <tr>
    			<td height="20" colspan="2" class="bottom" width='7%'>
    				<div class="style9 text-align-left"><?php
                        $logo=$kec['logo'];
                          if (empty($logo)) {
                            echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                            }else{
                            echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                            }
                            echo "</td>";
                            echo"<td class='bottom'>";
                                      
                      $nomor_bh =$kec ['nomor_bh'];
                      if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                    
                      echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>KECAMATAN $kec[nama_kec] KABUPATEN $kec[nama_kab] </b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
                      ?>      
    				</div>
    			</td>
    			<td height="20" colspan="2" class="bottom"><div align="right" class="style9"></div></td>
    	  </tr> 
    </table>
<p align="center" class="style6"><?php echo "$sebutan $status";?><br>Tanggal <?php echo tgl_indo(date('Y-m-d'));?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			  <th width="14%" class="style9 left bottom top" >NO REK</th>
			  <th width="5%" class="style9 left bottom top" >CIF</th>
			  <th width="15%" class="style9 left bottom top">TGL BUKA <?php echo $nama; ?></th>
              <th width="40%" class="style9 left bottom top">NAMA KREDITUR</th>
              <th width="2%" class="style9 left bottom top">JENIS</th>
			  <?php echo $kolom;?> 
			  <?php echo $jbarang;?>
              <th width="9%" class="style9 left bottom top ">SALDO</th>
              <th width="15%" class="style9 left bottom top right">KET</th>
        </tr>      
		
<?php 	
		$sT=$_GET['sT'];
		$view=mysql_query("SELECT * FROM
																desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp AND a.lokasi='$_SESSION[lokasi]' AND pi.status='$sT' AND pi.jenis_pinjaman='I' order by tgl_proposal asc");
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
									if($_SESSION['lokasi']=="189" or $_SESSION['lokasi']=="1"){
    
                                    	if($row['nama_jpp']=="KB"){$isi=$row['nama_barang'];}else{$isi="<center>-</center>";}
                                    	$ibarang="<td class='style9 left top'>".$isi."</td>";
                                    }
								
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $row['id'];?></div></td>
              <td class="style9 left top"><div align="center"></div></td>
              <td class="style9 left top"><div align="center"></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['nik']." - ".strtoupper($row['namadepan'])." ".strtoupper($row['nama_desa']);?></span></td>
              <td class="style9 left top"><div align="center"><?php echo $row['nama_jpp'];?></div></td>
			  <?php echo $isi_kolom;?><?php echo $ibarang;?>
              <td class="style9 left top right"><?php echo $row['catatan_verifikasi'];?></td>
              
            </tr>
  <?php 
$sum_saldopinjaman	=$sum_saldopinjaman+$saldopinjaman;
  } ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="7"><div align="center" >JUMLAH</div></th>
              <?php echo $kolom_footer;
			  if ($sT=='A') { 
			  echo "<th class='style9 left bottom top text-right'>".number_format($sum_saldopinjaman)."</th>";
			  }
			  ?>
 <?php echo $jubarang;?>
              <th class="style9 left bottom top right"></th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>12. DAFTAR <?php echo "$sebutan $status";?></title>
       
</body>
