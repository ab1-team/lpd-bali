<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

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
			<td height="20" colspan="2" class="bottom" width="5%">
				<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_lpd.gif' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="SK Gubernur Bali No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>LEMBAGA PERKREDITAN DESA (LPD) <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
			</td>
	  </tr> 
</table>
<p align="center" class="style6">LAPORAN TAGIHAN HARI INI<br>Jatuh Tempo Tanggal : <?php echo tgl_indo(date('Y-m-d'));?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="5%" class="style9 left bottom top" >LOAN ID</th>
              <th width="7%" class="style9 left bottom top">TGL CAIR</th>
              <th width="35%" class="style9 left bottom top">NAMA</th>
              <th width="10%" class="style9 left bottom top">POKOK</th>
              <th width="10%" class="style9 left bottom top">JASA</th>
              <th width="10%" class="style9 left bottom top">JUMLAH</th>
              <th width="15%" class="style9 left bottom top right">KETERANGAN</th>
        </tr>      
		
<?php 	
		$tgl=date('d');
		$tgl_kondisi=date('Y-m-d');
		$table_anggota	="anggota_$_SESSION[kd_kab]";
		$table_a		="pinjaman_anggota_$_SESSION[kd_kab]";
		$view=mysql_query("SELECT * FROM desa d, $table_anggota a, $table_a pa 
							WHERE d.id=a.desa AND a.id=pa.nia AND pa.status='A' AND a.lokasi='$_SESSION[lokasi]' AND 
							substring(tgl_cair,9,2)='$tgl' ORDER BY pa.tgl_cair ASC ");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_cair		=$row['tgl_cair'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
								$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");

				
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $idpinj;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_cair); ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['nik']." - ".strtoupper($row['namadepan'])." ".strtoupper($row['nama_desa']);?></span></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakjasa); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok+$nunggakjasa); ?></td>
              <td class="style9 left top right">&nbsp;</td>
            </tr>
  <?php 
$tot_pokok	=$tot_pokok+$nunggakpokok;
$tot_jasa	=$tot_jasa+$nunggakjasa;
$tot_jumlah	=$tot_pokok+$tot_jasa;
  } ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="4"><div align="center" >JUMLAH</div></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_pokok);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jasa);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jumlah);?></th>
              <th class="style9 left bottom top right">&nbsp;</th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>LAPORAN TAGIHAN HARI INI</title>
       
</body>
