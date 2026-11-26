<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.all  {border: 1px solid #000000; }
.top  {border-top: 1px solid #000000; }
.bottom {border-bottom: 1px solid #000000; }
.left {border-left: 1px solid #000000; }
.right  {border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
-->
</style>
<body onLoad="window.print()">

          <?php
      
      $row  =mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
      $nama_kec=$row['nama_kec'];
      
      $rcp=$_GET['rcp'];


      $data=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us,
                          keluarga k, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
                                WHERE
                                b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
                                k.id=a.hubungan AND sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
                                a.id=pi.nia AND pi.id='$rcp'");
      $no=1;
      while($r=mysql_fetch_array($data)){
        
        
        $nama_desa=$r['nama_desa'];
      $nama_kab=$r['nama_kab'];
      $nik=$r['nik'];
      $tgl_cair = $r['tgl_cair'];
      $tgl_now =date('Y-m-d');
      $ketuaupk     =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='1' AND jabatan='1' AND sejak<='$tgl_proposal' "));
        
        
      
      ?>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo "$rcp";?></div></td>
	  </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="50" colspan="3" class="bottom"><p align="center" class="style6">TANDA TERIMA JAMINAN
        </p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style10">Tanggal Cair </td>
        <td class="style27">: <?php echo tgl_indo($tgl_cair);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
           <tr>
        <td height="25" class="style10">NIK</td>
        <td class="style27">: <?php echo $r['nik'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style10">Diterima dari </td>
        <td class="style27">: <?php echo strtoupper($r['namadepan']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style10">Diserahkan Kepada </td>
        <td class="style27">: <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>

      <tr>
        <td height="30" colspan="3" ><p align="center" class="style10">

      </tr>

      <tr>
        <td height="30" colspan="3" class="bottom top"><p align="center" class="style10"><b>JENIS JAMINAN</b>

      </tr>

      <tr>
        </p></td>
        <td height="30" class="bottom top" colspan="3"><p align="center" class="style10">
        <b  class="style11">Jenis jaminan, Nomor, Type/Merek, Alamat</b><br><br>

        <?php if(substr($r['jaminan'],0,1)=='1') { echo "Tanah"; echo substr($r['jaminan'],1);?> 

        <?php } else if(substr($r['jaminan'],0,1)=='2') { echo "Tanah dan Bangunan"; echo substr($r['jaminan'],1);?> 

        <?php } else if(substr($r['jaminan'],0,1)=='3') { echo "Sepeda Motor"; echo substr($r['jaminan'],1);?>

        <?php } else if(substr($r['jaminan'],0,1)=='4') { echo "Mobil"; echo substr($r['jaminan'],1);?>

        <?php } else if(substr($r['jaminan'],0,1)=='5') { echo "SKP Pegawai"; echo substr($r['jaminan'],1);?>   





          <?php } ?>
        
      </tr>
      
      
      
</table>
    
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td width="32%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Yang menyerahkan,<br></p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
          <p>Yang Menerima,</p>
        </div></td>
      </tr> 
  <tr>
      <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$r[namadepan]<br>NIK. $r[nik]"); ?></p></th>
        <th width="32%" class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$_SESSION[namadepan] $_SESSION[namabelakang]"); ?> <br> <?php echo $r['sebutan_level_1']; ?> <?php echo "$row[nama_lembaga_sort]";?>  </p></th>
  </tr>
</table>
<div style="height:250px;">
</div>

<?php 

}
?>        
</body>
<title>Surat Pernyataan Anggota  <?php echo $nik;?>-<?php echo $rcp;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>