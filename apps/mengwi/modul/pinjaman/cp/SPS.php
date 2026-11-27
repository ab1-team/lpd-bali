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
			$r	=mysql_fetch_array(mysql_query("SELECT * FROM
              kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk, jenis_produk_pinjaman jpp, sistem_angsuran sa, anggota_$_SESSION[kd_kab] a, jenis_jasa jj, pinjaman_anggota_$_SESSION[kd_kab] pa, usaha us, keluarga kelu
              WHERE b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND k.id=pk.id_kel AND jj.id=pk.jenis_jasa AND pk.jenis_pp=jpp.id AND a.id=pa.nia AND sa.id=pa.sistem_angsuran AND pk.id=pa.id_pinkel 
               AND pa.id='$rcp' AND us.id=a.usaha AND kelu.id=a.hubungan"));
			
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
      $alokasi = $r['alokasi'];
      $nama_kelompok =$r['nama_kelompok'];
      $nama_jpp     =$r['nama_jpp'];
      $usaha    =$r['nama_usaha'];
			
      $user =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1'"));

      $tempat = $user['tempat_lahir'];

			
			?>



<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>			</td>
			<td width="38%" height="20" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo $id_pinj;?>
    Lamp-6, Lembar-<?php echo $no++;?> </div></td>
  </tr> 	  
      <tr>
        <td height="50" colspan="3" class="bottom"><p align="center" class="style6">SURAT PERNYATAAN <?php echo strtoupper($r['kekeluargaan']);?>
        </p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9">Yang  bertanda tangan di bawah ini,</td>
      </tr>
      <tr>
        <td height="25" class="style9" width="25%"><span style="margin-left:15px; padding: 0px;">Nama </span></td>
        <td class="style9">: <?php echo $r['penjamin'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"><span style="margin-left:15px; padding: 0px;">Alamat </span></td>
        <td class="style9">:</td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"><span style="margin-left:15px; padding: 0px;">NO.KTP</span></td>
        <td class="style9">: <?php echo $r['nik_penjamin'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>

      <tr>
        <td height="25" colspan="3" class="style9">Adalah <?php echo $r['kekeluargaan'];?> dari :</td>
      </tr>

      <tr>
        <td height="25" class="style9" width="25%"><span style="margin-left:15px; padding: 0px;">Nama </span></td>
        <td class="style9">: <?php echo $r['namadepan'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"><span style="margin-left:15px; padding: 0px;">Alamat</span> </td>
        <td class="style9">: <?php echo $r['alamat'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"><span style="margin-left:15px; padding: 0px;">Pekerjaan</span></td>
        <td class="style9">: <?php echo $r['nama_usaha'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"> <span style="margin-left:15px; padding: 0px;">NO.KTP</span></td>
        <td class="style9">: <?php echo $r['nik'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9"><span style="margin-left:15px; padding: 0px;">Kedudukan di kelompok</span></td>
        <td class="style9">: Sebagai Anggota</td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" co class="style9" colspan="3"><div align="justify">
        
        <ul style="list-style:none; margin-left:15px; padding:0px;">Menerangkan dengan sebenarnya, bahwa saya mengetahui dan menyetujui pinjaman sebesar Rp.<?php echo number_format($r['alokasi']);?> ,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) pada Kelompok <?php echo "$nama_jpp $nama_kelompok";?> yang akan di ajukan ke <?php echo $row['nama_lembaga_sort']; ?> Kecamatan <?php echo $row['nama_kec']; ?> Sebagai salah satu syarat pengajuan pinjaman. Apabila pinjaman tersebut bisa dicairkan maka dana itu akan kami pergunakan untuk ............................................
    <br>................................................................................................................................
    <br>Sebagai bentuk tanggung jawab saya sebagai <?php echo $row['kekeluargaan'] ?>, maka saya akan turut bertanggung jawab dalam melaksanakan kewajiban pengembalian dana tersebut.
    <br><br>Demikan surat penytaan ini saya buat dengan sebenarnya tanpa ada unsur paksaan dari siapapun.
  </ul>
        </div></td>
       
      </tr>
      

     
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
   
   <tr>
        <td width="28%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p></p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_proposal);?>
            <p>Yang membuat pernyataan</p>
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
        <?php echo strtoupper($r['penjamin']); ?> <br>
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
       
</body>
<title>Surat Pernyataan Anggota  <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>