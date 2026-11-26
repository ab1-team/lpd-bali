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
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
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
				
				
			
			?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
        <td height="20" colspan="2" class="bottom">
        <?php
        $logo=$row['logo'];
          if (empty($logo)) {
            echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
            }else{
            echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
            }
                      
      $nomor_bh =$row ['nomor_bh'];
      if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
    
      echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
      ?>      </td>
			<td width="38%" height="20" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo $rcp;?>
    Lamp-6, Lembar-<?php echo $no++;?> </div></td>
  </tr> 	  
      <tr>
        <td height="50" colspan="3" class="bottom"><p align="center" class="style6">SURAT  PERNYATAAN PEMINJAM INDIVIDU
        </p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9">Yang  bertanda tangan di bawah ini,</td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama Lengkap </td>
        <td class="style27">: <?php echo strtoupper($r['namadepan']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Jenis Kelamin </td>
        <td class="style27">: <?php echo $r['jk'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	   <tr>
        <td height="25" class="style9">NIK</td>
        <td class="style27">: <?php echo $r['nik'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Tempat, Tanggal Lahir </td>
        <td class="style27">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="25" class="style9">Alamat</td>
        <td width="42%" class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Jenis Usaha</td>
        <td class="style27">: <?php echo $r['nama_usaha'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9 align-justify"><p>Dengan  ini menyatakan dengan sebenarnya dan pernyataan ini tidak dapat  ditarik kembali, bahwa:</p>
          <ol class="style9 align-justify">
              
			   <?php if($_SESSION['lokasi']=='80') { //Khusus Wringinanom Gresik ?>
			   
			   <li>Saya selaku Anggota binaan <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span> melalui Desa/Kelurahan <span class="style9"><?php echo $nama_desa;?></span>, Kecamatan <span class="style9"><?php echo $nama_kec;?></span> Kabupaten <span class="style9"><?php echo $nama_kab;?></span>, benar-benar telah meminjam uang sebesar <span class="style27"> Rp. <?php echo number_format($r['alokasi']);?> (<?php echo ucwords(toTerbilang($r['alokasi']));?> Rupiah)</span>, dengan jaminan berupa tabungan tanggung renteng yang dikumpulkan di rekening kelompok.<br><br></li>
				<li>Apabila terjadi kemacetan atas kredit saya tersebut, saya bersedia menyerahkan seluruh tabungan saya dikelompok kepada pihak yang berwenang, guna menyelesaikan kredit/pinjaman saya kepada <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span></li><br>
              
			  <?php } else { ?>
			  
			  <li>Saya selaku Pemanfaat pinjaman individu pada <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span> melalui Desa/Kelurahan <span class="style9"><?php echo $nama_desa;?></span>, Kecamatan <span class="style9"><?php echo $nama_kec;?></span> Kabupaten <span class="style9"><?php echo $nama_kab;?></span>, benar-benar telah meminjam uang sebesar <span class="style27"> Rp. <?php echo number_format($r['alokasi']);?> (<?php echo ucwords(toTerbilang($r['alokasi']));?> Rupiah)</span>, dengan jaminan berupa barang sebagai berikut :<br><br>
                <ul>
                  <li>Nama Barang : _____________________________________, Nilai Jual Rp. : _______________</li><br>
                  <li>Nama Barang : _____________________________________, Nilai Jual Rp. : _______________</li><br>
                  <li>Nama Barang : _____________________________________, Nilai Jual Rp. : _______________</li><br>
                </ul>
              </li>
              <li>Barang yang saya jaminkan tersebut adalah benar-benar milik saya sendiri,</li><br>
              <li>Saya berkewajiban merawat dan melindungi barang jaminan tersebut dan tidak akan menjual, menggadaikan, dan/atau memindahtangankan kepada pihak lain sebelum kredit/pinjaman saya tersebut lunas,</li><br>
			  <li>Apabila terjadi kemacetan atas kredit saya tersebut, saya bersedia menyerahkan barang jaminan tersebut kepada pihak yang berwenang, guna menyelesaikan kredit/pinjaman saya kepada <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span>,</li><br>
              
			  <?php } ?>
			  
			  <li>Saya berjanji akan mengembalikan       pinjaman saya tersebut sesuai dengan peraturan yang ada di <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span>,</li><br>
              <li>Apabila di kemudian hari saya melanggar isi dari surat pernyataan ini, maka saya bersedia dilaporkan kepada pihak yang berwajib dan/atau diproses secara hukum.</li><br>
			
			<?php if($_SESSION['lokasi']=='72') {
				
				echo "
				<li>Apabila terjadi tunggakan atas pinjaman tersebut kami berikan kuasa penuh kepada pengurus BPP untuk menyita, melelang/menjual sebagian ataupun seluruhnya atas jaminan /anggunan dari pihak Kedua dan pemberi kuasa.</li>
				";
				
			}else{
				
			echo "	
			  <li>Jika dikemudian hari terjadi <i>force majeure</i> seperti banjir, gempa bumi, tanah longsor, petir, angin topan, kebakaran, huru-hara, kerusuhan, pemberontakan, dan perang 
			  atau saya berhalangan tetap seperti sakit atau meninggal dunia yang mengakibatkan tidak dapat terpenuhinya kewajiban saya sesuai poin 5 (lima) diatas,
			  maka sisa angsuran akan ditanggung oleh ahli waris.</li> ";
			}
			  ?>
			  
		  </ol>
		<p>Demikian  surat  pernyataan ini saya buat dengan sebenarnya dan dengan penuh kesadaran serta  rasa tanggung jawab.</p>
		<p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="style9">&nbsp;</td>
        <td height="25" class="style9"><div align="right"><span class="style9"><?php echo $nama_desa;?>, ____________________________</span></div></td>
      </tr>
</table>
	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td width="32%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Mengetahui,<br><?php echo $r['kekeluargaan']; ?>  </p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
          <p>Yang Menyatakan </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$r[penjamin]<br>NIK/KK. $r[kk]"); ?></p></th>
        <th width="32%" class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$r[namadepan]<br>NIK. $r[nik]"); ?></p></th>
  </tr>
</table>
<div style="height:250px;">
</div>

<?php 

}
?>        
</body>
<title>Surat Pernyataan Anggota  <?php echo $nik;?>-<?php echo $rcp;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>