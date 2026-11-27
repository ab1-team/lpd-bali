<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
-->
</style>
<body onLoad="window.print()">

     	    <?php
			$rcp=$_GET['rcp'];
			$id_pinkel=$_GET['id_pinkel'];
			$r	=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k, anggota_$_SESSION[kd_kab] a, keluarga kelu, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE 
			b.id=c.kd_kab AND c.kd_kec=d.kd_kec AND d.id=k.desa AND k.id=pa.id_kel AND a.id=pa.nia AND kelu.id=a.hubungan AND a.id='$rcp' AND pa.id_pinkel='$id_pinkel' "));
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c WHERE b.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
      $nama_kec=$row['nama_kec'];
			$nama_desa=$r['nama_desa'];
			$nama_kab=$r['nama_kab'];
      $tgl_now =date('Y-m-d');
      $kades = $r['kades'];
      $tgl_proposal = $r['tgl_proposal'];
      $kk = $r['kk'];
      $Hubungan = $r['kekeluargaan'];
      $alamat = $r['alamat'];
      $nik_penjamin =$r['nik_penjamin'];
			
      $user =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1'"));

      $tempat = $user['tempat_lahir'];
                if($r['status']=='P' OR $r['status']=='V'){
                    $alokasi    = $r['proposal'];
                    $zz         = " rencana ";
                }else{
                    $alokasi    = $r['alokasi'];
                    $zz         = "";
                }
			
			?>


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo "$rcp";?></div></td>
	  </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td colspan="3" class="bottom"><p align="center" class="style6">SURAT  PERNYATAAN  AHLI WARIS
        </p></td>
      </tr>
      
      <tr>
        <td height="25" colspan="3" class="style9">Yang  bertanda tangan di bawah ini,</td>
      </tr>
      <tr>
        <td height="25" class="style9" width="25%">Nama Penjamin </td>
        <td class="style9">: <?php echo $r['penjamin'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">NIK/NO.KK</td>
        <td class="style9">: <?php echo $r['nik_penjamin'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Alamat </td>
        <td class="style9">: <?php echo $r['alamat'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Hubungan dengan Peminjam </td>
        <td class="style9">: <?php echo $Hubungan ?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="25" colspan="3" class="style9 align-justify">Adalah benar-benar ahli waris dari <b><?php echo ucwords($r['namadepan']); ?></b><br/><br/>
          
                    Dengan ini menyatakan menyetujui <?php echo $zz;?> pinjaman orang tersebut di atas dengan rincian pinjaman sebagai berikut : 
                    <table border='0' class="style9">
                        <tr><td>Jumlah Pinjaman</td><td> : <?php echo number_format($alokasi)." (".ucwords(toTerbilang($alokasi)).")";?></td></tr>
                        <tr><td>Jangka Waktu</td>   <td> : <?php echo "$r[jangka] Bulan";?></td></tr>
                        <tr><td>Jaminan</td>        <td> : __________________________________</td></tr>
                    </table>
                    melalui kelompok <?php echo "$r[nama_kelompok] Desa $r[nama_desa]";?> kepada <?php echo "$row[nama_lembaga_long] ($row[nama_lembaga_sort]) $sebutan_kec $row[nama_kec] Kabupaten $row[nama_kab]" ;?>.   	
            Dan sekaligus menyatakan bersedia menanggung beban Pinjaman tersebut di atas sampai lunas, apabila terjadi hal-hal yang tidak diinginkan. <br>
            Yang dimaksud sebagai hal-hal yang tidak diinginkan adalah hal-hal yang menyebabkan peminjam tidak bisa melunasi kewajibannya seperti :
            Meninggal Dunia, Melarikan diri, Berpindah domisili di luar desa, gangguan kejiwaan, sakit parah, dll.<br/>
            Demikian Surat Pernyataan Ahli Waris ini saya buat tanpa ada paksaan dari pihak manapun.
         
        </td>

		<p>&nbsp;</p></td>
      </tr>
      <?php
 $tgl=date('Y-m-d');

 ?>
      <tr>
        <td height="25" colspan="3" class="style9"><div align="right"><span class="style9"><?php echo $nama_desa;?>,<?php echo tgl_indo($tgl_proposal);?> </span></div></td>
      </tr>
</table>
	  
  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td width="32%" height="36" colspan="1" class="style26"><div align="center" class="style9">
            <p><br>Ketua Kelompok </p>
          </div></td>
          <td class="style26"><div align="center" class="style9">
         
          </div></td>
          <td class="style26"><div align="center" class="style9">
            <p> Nama Penjamin </p>
          </div></td>
        </tr>	
        <tr>
          <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
          <p><?php echo strtoupper($r['ketua']); ?></p></th>
          <td class="style26"><div align="center" class="style9">
              <?php if($_SESSION['lokasi']==301){echo "<br><br>";}else{ ?>
            <p>Mengetahui,<br>
              Kepala Desa
              </p>
              <?php } ?>
          </div></td>
          <th width="32%" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><?php echo strtoupper($r['penjamin']); ?></p></th>
        </tr>
  	<tr>
  	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
          <p></p></th>
          <th width="36%" class="style9"><p>&nbsp;</p>
            <p>&nbsp;</p>
          <?php if($_SESSION['lokasi']!=301){echo strtoupper($kades);} ?></th>
          <th width="32%" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p></p></th>
    </tr>
  </table>
<div style="height:250px;">
</div>

       
</body>
<title>Surat Pernyataan Ahli Waris</title>