<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-align:center; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];

											
											$tgl_cair			=$row['tgl_cair'];
											
										
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$alokasi			=$row['alokasi'];
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];

											$sistem				=$row['sistem'];
											$jangka				=$row['jangka'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
											$nama_lembaga_long	=$row ['nama_lembaga_long'];
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											
											
											$spk_no				=$row['spk_no'];
											$nik				=$row['nik'];
											$namadepan			=$row['namadepan'];
											$alamat				=$row['alamat'];
											$telpon				=$row['telpon'];
											$tempat_lahir		=$row['tempat_lahir'];
											$tgl_lahir			=$row['tgl_lahir'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_usaha'];
											$jenis_kelamin		=$row['jk'];
											$nomor_kk			=$row['kk'];
											$penjamin			=$row['penjamin'];
											$hubungan			=$row['hubungan'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$tgl_now			=date('Y-m-d');
											$nik_penjamin		=$row['nik_penjamin'];
											$wajibjasaaja		=wajibjasaaja_anggota($id_pinj);
											$wajibjasa			=($wajibjasaaja*$sistem);
				
				                            $row['nama_kec'] = $_SESSION['unit'];
			                                $nama_kec = $row['nama_kec'];
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
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$id_pinj";?></div></td>
	  </tr> 
</table>

<p class="style16">
	<br>SURAT PERNYATAAN<br>
	PENGIKAT DIRI SEBAGAI PENJAMIN*)<br>
	<br>
</p>

	  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-left:30px;">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		Yang bertanda tangan di bawah ini :</p>        </td>
      </tr>
      <tr>
        <td width="197" height="25" class="style9">
        <p>Nama <br>
           No. Identitas <br>
           Alamat <br>
           Hubungan dengan Debitur 
        <td height="25" colspan="23" class="style27">
          : <?php echo strtoupper($row['penjamin']); ?> <br>
          : <?php echo strtoupper($row['nik_penjamin']); ?> <br>
          : <?php echo $row['alamat']; ?><br>
          : <?php echo $row['kekeluargaan'];?></td>
      </tr>
      <tr>
      	<td colspan="24"></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Dengan ini menyatakan bahwa :</div></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		1. Saya <b> menyetujui dan menjamin</b>  sepenuhnya Debitur sebagai berikut :</div></td>
      </tr>
      <tr>
        <td height="25" class="style9" width="24%">
        <ul style="list-style:none; margin-left:15px; padding:0px;">
	        <li>Nama</li> 
			<li>Tempat dan tanggal lahir</li> 
			<li>No. Identitas </li> 
			<li>Alamat </li> 
			<li>Desa</li> 
			<li>No. Telp/HP </li> 
		</ul>
        <td height="25" colspan="23" class="style27">
        <ul style="list-style:none; margin-left:0px; padding:0px;">
        	<li>: <?php echo strtoupper($row['namadepan']); ?> </li> 
			<li>: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($row['tgl_lahir']);?></li> 
			<li>: <?php echo $row['nik'];?></li> 
			<li>: <?php echo $row['alamat'];?></li> 
			<li>: <?php echo $nama_desa;?></li> 
			<li>: <?php echo $row['hp'];?></li> 
		</ul>
			</td>
      </tr>

        <td height="37" colspan="24" class="style9"><div align="justify">
        <ul style="list-style:none; margin-left:15px; padding:0px;">
		<li><?php  echo $tgl_jt_tempo; ?>untuk melakukan pinjaman dana di <?php echo "$row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?> yang akan <b>dicairkan pada tanggal <?php echo tgl_indo($tgl_cair);?></b> dan dengan jangka waktu pengembalian maksimal <b><?php echo $jangka;?> Bulan</b>, sesuai kartu rencana angsuran terlampir sebagai bagian yang tidak terpisahkan dari Surat Perjanjian Kredit (SPK).</li>
		</ul>
        </div></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
        	<ol style="margin:0px; padding:0px; margin-left:15px;" start="2">
        		<li>Apabila orang tersebut di atas tidak memenuhi kewajibannya (membayar angsuran dan kewajiban lainnya) sesuai ketentuan dalam Surat Perjanjian Kredit (SPK) maka dengan ini saya mengikatkan diri dan mejamin untuk membayar seluruh tagihan yang menjadi kewajiban debitur tersebut di atas sesuai hasil perhitungan saldo pinjaman dan tagihan jasa serta kewajiban lainnya di <?php echo "$row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?>.</li>
        	</ol>
          	
          
          </ol>
        </div></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="24" class="style6" align="justify">
          <div align="justify" class="style9">
            Demikian pernyataan penjaminan ini saya buat dengan sebenar-benarnya dan merupakan bagian tidak terpisahkan dari Surat Perjanjian Kredit, dalam kondisi sehat lahir dan batin serta tanpa paksan dari pihak manapun serta bersedia dituntut dimuka hukum apabila dikemudian hari saya mengkingkari pernyataan ini.
		  </div>
		</td>
      </tr>
      
 
</table>
<br>
<br>
<br>


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
   
   <tr>
        <td width="28%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p></p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9"><?php echo $nama_desa;?>, <?php echo tgl_indo($tgl_cair);?>
            <p>Yang menyatakan dan menjamin,</p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p></p></th>
        <th width="15%" colspan="2" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo strtoupper($row['penjamin']); ?> <br>
        Penjamin </th>
  </tr>


      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
  
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      
</table>

<title>1. Surat pernyataan pengikat diri sebagai penjamin <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
