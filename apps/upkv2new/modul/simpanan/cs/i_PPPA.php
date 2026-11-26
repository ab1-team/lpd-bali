<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>
<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.align-justify {text-align:justify; }
.style28 {font-size: 10px}
-->
</style>
    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon">
    <link href="css/application.min.css" rel="stylesheet">
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
	
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
<body onLoad="window.print()">

     	    <?php
			$nia = $_GET['ida'];
			$r	=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, anggota_s_$_SESSION[kd_kab] sa,simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
												a.id=$nia AND a.nik=sa.nik 
															"));
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, kabupaten b WHERE b.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
			

			
			?>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" width="65%" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">CIF : </div><br><div align="right" class="style9">No Rekening : </div></td>
			<td height="20" colspan="2" class="bottom" width="15%"><div align="left" class="style9 bottom"><?php echo $r['id'];?></div><br><div align="left" class="style9 bottom"><?php echo $r['nomor_rekening'];?>
			</div></td>
	  </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
	  
      <tr>
        <td height="35" colspan="6" class="bottom"><p align="center" class="style6"><b>FORMULIR SIMPANAN NASABAH</b>
        </p>
        
	    </td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">1.</div></td>
        <td height="0" class="align-justify style9">N I K</td>
        <td height="0" colspan="4" class="style27 bottom">: <?php echo $r['nik'];?></td>
      </tr>
      <tr>
        <td width="4%" class="align-justify style9"><div align="right">2.</div></td>
        <td width="25%" class="align-justify style9">Nama Lengkap</td>
        <td colspan="4" class="style27 bottom">: <?php echo $r['namadepan'];?></td>
      </tr>
      <tr>
        <td width="4%" class="align-justify style9"><div align="right">3.</div></td>
        <td width="25%" class="align-justify style9">Nama Alias</td>
        <td colspan="3" width="40%" class="style27 bottom">: <?php echo $r['nick'];?> </td>
        <td class="style27">  &nbsp; &nbsp; [ ] Laki Laki <i class="fa fa-square"></i>   &nbsp; &nbsp; [ ] Perempuan</td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">4.</div></td>
        <td height="0" class="align-justify style9">Tempat, Tanggal Lahir </td>
        <td height="0" colspan="4" class="style27 bottom">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">5.</div></td>
        <td height="0" class="align-justify style9">Alamat</td>
        <td height="0" colspan="4" class="style27 bottom"><span class="style27">: <?php echo $r['alamat'];?> </span></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">6.</div></td>
        <td height="0" class="align-justify style9">No. Handphone</td>
        <td height="0" colspan="4" class="style27 bottom">: <?php echo $r['hp'];?>  </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">7.</div></td>
        <td class="align-justify style9">Agama</td>
        <td colspan="4" class="style27 bottom">: <?php echo $r['agama'];?>   </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">8.</div></td>
        <td class="align-justify style9">Status Pernikahan</td>
        <td  colspan="4" class="style27">:  &nbsp; &nbsp; [ ] Lajang   &nbsp; &nbsp; [ ] Menikah  &nbsp; &nbsp; [ ] Duda/Janda</td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">9.</div></td>
        <td class="align-justify style9">Pendidikan Terakhir</td>
        <td colspan="4" class="style27">:  &nbsp; &nbsp; [ ] Tidak ada  &nbsp; &nbsp; [ ] SD  &nbsp; &nbsp; [ ] SLTP  &nbsp; &nbsp; [ ] SLTA  &nbsp; &nbsp; [ ] D1  &nbsp; &nbsp; [ ] D2  &nbsp; &nbsp; [ ] D3  &nbsp; &nbsp; [ ] S1  &nbsp; &nbsp; [ ] S2  &nbsp; &nbsp; [ ] S3  &nbsp; &nbsp; [ ] Lainnya </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">10.</div></td>
        <td class="align-justify style9">Pekerjaan</td>
        <td colspan="4" class="style27 bottom">:  <?php echo $r['nama_usaha'];?>  </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">11.</div></td>
        <td class="align-justify style9">Alamat  Pekerjaan</td>
        <td colspan="4" class="style27 bottom">:  </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">12.</div></td>
        <td class="align-justify style9">NPWP</td>
        <td colspan="4" class="style27 bottom">: </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">13.</div></td>
        <td class="align-justify style9">Penghasilan per Bulan</td>
        <td colspan="4" class="style27">:  &nbsp; &nbsp; [ ] < 5 jt  &nbsp; &nbsp; [ ] 5 - 15 jt  &nbsp; &nbsp; [ ] 15 - 25 jt  &nbsp; &nbsp; [ ] > 25 jt </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">14.</div></td>
        <td class="align-justify style9">Sumber Dana</td>
        <td colspan="4" class="style27">:  &nbsp; &nbsp; [ ] Gaji/Upah  &nbsp; &nbsp; [ ] Usaha  &nbsp; &nbsp; [ ] Lainnya : ________________________________________ </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">15.</div></td>
        <td class="align-justify style9">Jenis Rekening</td>
        <td colspan="4" class="style27 bottom">:   &nbsp; &nbsp; [ ] Simantera <i class="fa fa-square"></i>   &nbsp; &nbsp; [ ] Simantera Qurban   &nbsp; &nbsp; [ ] Simantera Hari raya </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">16.</div></td>
        <td class="align-justify style9">Status Permohonan</td>
        <td colspan="4" class="style27 ">:  &nbsp; &nbsp; [ ] Pribadi  &nbsp; &nbsp; [ ] Kuasa</td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right"></div></td>
        <td colspan="4" class="style27 "><span class="style27 bottom">Isikan Jika Status Permohonan Kuasa</span>
                    
            <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
                     <tr>
                            <td width="4%" class="align-justify style9"><div align="right">1.</div></td>
                            <td width="25%" class="align-justify style9">Nama Lembaga</td>
                            <td colspan="4" class="style27 bottom">:  </td>
                     </tr>
                     <tr>
                            <td width="4%" class="align-justify style9"><div align="right">2.</div></td>
                            <td width="25%" class="align-justify style9">Jabatan</td>
                            <td colspan="4" class="style27 bottom">:  </td>
                     </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">17.</div></td>
        <td class="align-justify style9">Pengampu</td>
        <td colspan="4" class="style27 bottom">: <?php echo $r['nama_sistem'];?> </td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">18.</div></td>
        <td class="align-justify style9">Hubungan</td>
        <td colspan="4" class="style27 bottom">: <?php echo $r['jangka'];?></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">19.</div></td>
        <td class="align-justify style9">Nama Gadis Ibu Kandung</td>
        <td colspan="4" class="style27 bottom">: <?php echo $r['jangka'];?></td>
      </tr>
 </table>     
<br>
<table width="97%" border="0" class ="style9 top" align="center" cellpadding="3" cellspacing="0">
    <br>
   
    <tr>
      <td width="45%" class="style9 align-justify" colspan="2"><p><span class="style27"> PERNYATAAN</span> <br>Bersama ini saya menyatakan bahwa <br>
      1. Semua data isian diatas adalah benar. <br>
      2. Menyetujui serta tunduk pada ketentuan dan syarat umum yang berlaku pada pembukaan rekening di <?php echo strtoupper("KOPERASI LEMBAGA KEUANGAN MIKRO $row[nama_lembaga_sort] KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>"); 
                  ?>. <br>
      3. Dana yang saya setorkan dan pergunakan tidak berasal dari / untuk tujuan <i>money laundering</i> atau pencucian uang. 
      
           <br><br><br></p>
      </td>
  </tr>
  <!-- Menampilkan tanda tangan -->
      
       <?php 
       $u			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$_SESSION[id]'  "));
       ?>
       
	<tr>
        <td height="24" class="style9"><p align="center">Petugas Penerima</p>
        <p>&nbsp;</p>
	    <p>&nbsp;</p>
	   
       	<p align="center"><b><?php echo " $u[namadepan] $u[namabelakang] "?></b></p>
		</td>
	    
	    <td height="24" class="style9"><p align="center">Pemohon</p>
	    <p>&nbsp;</p>
	    <p>&nbsp;</p>
	    
       	<p align="center"><b><?php echo $r['namadepan'];?></b></p>
		</td>
		<tr><td colspan="3">&nbsp;
		<p>&nbsp;</p>
	    <p>&nbsp;</p></td></tr>
		
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>
</body>
<title>Form Buka Rekening</title>