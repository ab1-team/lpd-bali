<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]'"));

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
}elseif($sT=="D"){
	$sebutan="PROPOSAL";
	$status="PENDANAAN";
	$nama="RENCANA CAIR";
	$kolom="<th class='style9 left bottom top'>PROPOSAL</th><th class='style9 left bottom top'>ALOKASI</th>";
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
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom" width=7%">
				<div class="style9 text-align-left"><?php
                    $logo=$kec['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                 echo"</td>
                 	  <td class='bottom'>
                 ";
                                  
                  $nomor_bh =$kec ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>$kec[sebutan_kec] $kec[nama_kec] KABUPATEN $kec[nama_kab]</b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
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
																d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp AND k.lokasi='$_SESSION[lokasi]' AND pk.status='$sT' order by tgl_cair asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$sts			=$row['status'];
								$lokasi				=$row['lokasi'];

									if($sts=="P"){
										$tgl=$row['tgl_proposal'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['proposal'])."</td>";
									}elseif($sts=="V"){
										$tgl=$row['tgl_verifikasi'];
										$isi_kolom	="<td class='style9 left top text-right'>".number_format($row['proposal'])."</td>
													  <td class='style9 left top text-right'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="D"){
										$tgl=$row['tgl_dana'];
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
																$ketua = strtolower($row['ketua']);
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $row['id'];?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $tgl; ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['kd_kelompok']." - ".strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa'])." (".ucfirst($ketua).")";?></span></td>
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
</table> <br>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

    <tr>
      <td width="45%" class="style10 align-justify"><p><span class="style27"> Verified Sign:</span><br>
        Tim Verifikasi Unit Pengelola Kegiatan <?php echo "$sebutan_kec $nama_kec";?> menyatakan dengan sebenar-benarnya sesuai dengan hasil survey lapangan bahwa kelompok dengan identitas tersebut diatas <span class="style27">ADA/TIDAK ADA</span>*)  keberadaannya dan dapat dipertanggungjawabkan sesuai dengan peraturan yang berlaku. Serta <span class="style27">LAYAK/TIDAK LAYAK</span>*) untuk diberikan pinjaman sesuai dengan hasil rekomendari Verifikasi diatas.<br>
		Form ini digunakan sebagai dasar Verified pada SI UPK Online. </p>
        <p>*) coret yang tidak perlu. </p></td>
	    <td width="5%" height="20" colspan="-1" class="style9 align-justify"><p>&nbsp;</p>      </td>
        <td width="50%" colspan="2" class="style9"><p>Diverifikasi Oleh,<br>Tim Verifikasi <?php echo $row['sebutan_kec']; ?> <?php echo $nama_kec; ?><br>
        </p>
		<?php
		$dtv=mysql_query("SELECT * FROM jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi=$_SESSION[lokasi] AND u.level='4' AND u.hingga<=0 AND u.status='1' ");
		while($tv=mysql_fetch_array($dtv)){
		echo "
			<table width='100%'>
				<tr>
				<td width='60%' class='style27'>".strtoupper($tv['namadepan'])." ".strtoupper($tv['namabelakang'])."<br>
				<span class='style9'>(".$tv['nama_jabatan'].")</span></td>
				<td width='30%' class='bottom'></td>
				</tr>
				<tr><td height='10'>$nbsp</td></tr>
			</table>";
		}
		?>      </td>
  </tr>
</table>
<title>12. DAFTAR <?php echo "$sebutan $status";?></title>
       
</body>
