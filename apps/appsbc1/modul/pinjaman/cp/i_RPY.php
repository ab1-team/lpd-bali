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
.red {color:red; }
-->
</style>
<body onLoad="window.print()">


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom" width="5%">
				<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
			</td>
	  </tr> 
</table>
<p align="center" class="style6">DAFTAR NAMA PEMINJAM LUNAS 3 BULAN KEDEPAN<br>Tanggal : <?php echo tgl_indo(date('Y-m-d'));?> </p>
<p align="center" class="style9 red">NAMA DIBAWAH INI MERUPAKAN NAMA YANG MEMILIKI JANGKA WAKTU PELUNASAN KURANG DARI 3 BULAN.</p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" rowspan="2" height="34" class="style9 bottom top left">No</th>
			<th width="5%" rowspan="2" class="style9 left bottom top" >LOAN ID</th>
              <th width="25%" rowspan="2" class="style9 left bottom top">NAMA </th>
              <th width="15%" rowspan="2" class="style9 left bottom top">ALAMAT</th>
              <th width="5%" rowspan="2" class="style9 left bottom top">TELPON</th>
              <th width="5%" rowspan="2" class="style9 left bottom top">TGL CAIR</th>
              <th width="5%" rowspan="2" class="style9 left bottom top">JANGKA WAKTU</th>
              <th width="5%" rowspan="2" class="style9 left bottom top">TGL JATUH TEMPO</th>
              <th width="5%" rowspan="2" class="style9 left bottom top">SISA WAKTU</th>
              <th width="25%" colspan="3" class="style9 left bottom top right">SISA ANGSURAN</th>
        </tr>      
        <tr>
              <th width="8%" class="style9 left bottom">POKOK</th>
              <th width="7%" class="style9 left bottom">JASA</th>
              <th width="10%" class="style9 left bottom right">JUMLAH</th>
        </tr>      
		
<?php 	

		$table_anggota	="anggota_$_SESSION[kd_kab]";
		$table_pa		="pinjaman_anggota_$_SESSION[kd_kab]";
	
	$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		 ?>
		
		 <tr>
              <td height="33" colspan="12" class="style27 top left right">DESA <?php echo strtoupper($r['nama_desa']);?></td>
		</tr>
		
		<?php
		
		$view=mysql_query("SELECT * FROM $table_anggota a, $table_pa pa WHERE 
							a.desa='$idd' AND a.id=pa.nia AND pa.status='A' AND a.lokasi='$_SESSION[lokasi]' ORDER BY pa.tgl_cair ASC ");
								$no=0;
								while($row=mysql_fetch_array($view)){
								
								$idpinj			=$row['id'];
								$tgl_cair		=$row['tgl_cair'];
								$tgl_kondisi	=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_kondisi-$idpinj");
								$nunggakpokok		=nunggakpokok("$tgl_kondisi-$idpinj");
								$nunggakjasa		=nunggakjasa("$tgl_kondisi-$idpinj");
								
								$saldopinjaman		=saldopinjaman("$tgl_kondisi-$idpinj");
								$saldo_jasa			=saldo_jasa("$tgl_kondisi-$idpinj");
								
								$jangka				=$row['jangka'];
								$tgl_jatuh 	= date('Y-m-d', strtotime("+$jangka month", strtotime($tgl_cair))); //Cari Tanggal Jatuh Temponya
								
								$bulan1   	= substr($tgl_kondisi,5,2);
								$bulan2   	= substr($tgl_jatuh,5,2);
								$tahun1   	= substr($tgl_kondisi,0,4);
								$tahun2   	= substr($tgl_jatuh,0,4);
								
								$sisa_waktu	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi

				if ($sisa_waktu <= 3) {
					$no=$no+1;
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $idpinj;?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['nik']." - ".strtoupper($row['namadepan']);?></span></td>
              <td class="style9 left top"><span class="style9"><?php echo "$row[alamat] $row[nama_desa]";?></span></td>
              <td class="style9 left top"><span class="style9"><?php echo "$row[hp]";?></span></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_cair); ?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $jangka; ?></div></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_jatuh); ?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $sisa_waktu; ?></div></td>
			  <td class="style9 left top text-right"><?php echo number_format($saldopinjaman); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($saldo_jasa); ?></td>
			  <td class="style9 left top right text-right"><?php echo number_format($saldopinjaman+$saldo_jasa); ?></td>
            </tr>
				
<?php }
$tot_pokok	=$tot_pokok+$nunggakpokok;
$tot_jasa	=$tot_jasa+$nunggakjasa;
$tot_jumlah	=$tot_pokok+$tot_jasa;
  }
		}  ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="9"><div align="center" >JUMLAH</div></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_pokok);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jasa);?></th>
              <th class="style9 left bottom top right text-right"><?php echo number_format($tot_jumlah);?></th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>DAFTAR NAMA HAMPIR LUNAS</title>
       
</body>
