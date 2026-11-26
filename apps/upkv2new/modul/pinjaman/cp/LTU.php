<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]'"));

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
<p align="center" class="style6">LAPORAN TUNGGAKAN S.D. HARI INI<br>Tanggal : <?php echo tgl_indo(date('Y-m-d'));?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="5%" class="style9 left bottom top" >LOAN ID</th>
              <th width="7%" class="style9 left bottom top">TGL CAIR</th>
              <th width="20%" class="style9 left bottom top">NAMA KELOMPOK</th>
              <th width="15%" class="style9 left bottom top">ALAMAT</th>
              <th width="10%" class="style9 left bottom top">TELPON</th>
			  <th width="10%" class="style9 left bottom top">ALOKASI</th>
              <th width="10%" class="style9 left bottom top">POKOK</th>
              <th width="10%" class="style9 left bottom top">JASA</th>
              <th width="10%" class="style9 left bottom top">JUMLAH</th>
              <th width="10%" class="style9 left bottom top">SALDO PINJAMAN</th>
              <th width="10%" class="style9 left bottom top right">KETERANGAN</th>
        </tr>      
		
<?php 	

		$table_kelompok	="kelompok_$_SESSION[kd_kab]";
		$table_pk		="pinjaman_kelompok_$_SESSION[kd_kab]";
	
	$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		 ?>
		
		 <tr>
              <td height="33" colspan="12" class="style27 top left right">DESA <?php echo strtoupper($r['nama_desa']);?></td>
		</tr>
		
		<?php
		
		$view=mysql_query("SELECT * FROM $table_kelompok k , jenis_produk_pinjaman j, $table_pk pk WHERE 
							k.desa='$idd' AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND pk.jenis_pp=j.id ORDER BY pk.tgl_cair ASC ");
								$no=0;
								while($row=mysql_fetch_array($view)){
								
								$idpinj			=$row['id'];
								$jpp			=$row['nama_jpp'];
								$tgl_cair		=$row['tgl_cair'];
								$tgl_kondisi	=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_kondisi-$idpinj");
								$kolek1			=kolek1($tgl_kondisi."-".$idpinj);
								$kolek2			=kolek2($tgl_kondisi."-".$idpinj);
								$kolek3			=kolek3($tgl_kondisi."-".$idpinj);
								$kolek4			=kolek4($tgl_kondisi."-".$idpinj);
								$kolek5			=kolek5($tgl_kondisi."-".$idpinj);
								$nunggakpokok		=nunggakpokok("$tgl_kondisi-$idpinj");
								$nunggakjasa		=nunggakjasa("$tgl_kondisi-$idpinj");

				if ($nunggakpokok > 0 or $nunggakjasa > 0) {
					$no=$no+1;
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $jpp."-".$idpinj;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_cair); ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['kd_kelompok']." - ".strtoupper($row['nama_kelompok'])." - ".ucfirst($row['ketua']);?></span></td>
              <td class="style9 left top"><span class="style9"><?php echo "$row[alamat_kelompok] $row[nama_desa]";?></span></td>
              <td class="style9 left top"><span class="style9"><?php echo "$row[telpon]";?></span></td>
			  <td class="style9 left top text-right"><?php echo number_format($row['alokasi']); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakjasa); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok+$nunggakjasa); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($saldopinjaman); ?></td>
              <td class="style9 left top right">
			  <?php
				if($saldopinjaman==0){echo "Belum Di <br>Validasi Lunas";}
					elseif($kolek1!= 0){echo "Kolek 1";}
					elseif($kolek2!= 0){echo "Kolek 2";}
					elseif($kolek3!= 0){echo "Kolek 3";}
					elseif($kolek4!= 0){echo "Kolek 4";}
					elseif($kolek5!= 0){echo "Kolek 5";}
					else{echo "<i>error</i>";}
			  ?>
			  </td>
            </tr>
				
<?php }
$tot_pokok	=$tot_pokok+$nunggakpokok;
$tot_jasa	=$tot_jasa+$nunggakjasa;
$tot_jumlah	=$tot_pokok+$tot_jasa;
$tot_saldopinjaman	=$tot_saldopinjaman+$saldopinjaman;
  }
		}  ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="7"><div align="center" >JUMLAH</div></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_pokok);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jasa);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jumlah);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_saldopinjaman);?></th>
              <th class="style9 left bottom top right">&nbsp;</th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<title>LAPORAN TAGIHAN HARI INI</title>
       
</body>
