<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c WHERE b.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
			
			$nama_kec=$row['nama_kec'];
			
			$rcp=$_GET['rcp'];


			$data=mysql_query("SELECT * FROM kabupaten b, kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE 
			b.id=c.kd_kab AND c.kd_kec=d.kd_kec AND k.id=pa.id_kel AND d.id=a.desa AND a.id=pa.nia AND pa.id_pinkel='$rcp' ");
			
			$no=1;
			while($r=mysql_fetch_array($data)){
			    
				$pek	=mysql_fetch_array(mysql_query("SELECT * FROM usaha WHERE id='$r[usaha]' "));
			
				
				$nama_desa      =$r['nama_desa'];
			    $nama_kab       =$r['nama_kab'];
			    $nama_kelompok  =$r['nama_kelompok'];
			    $kd_kelompok    =$r['kd_kelompok'];
			    
				$jaminan 	= explode(",", $r['jaminan']);
						  $jj=mysql_fetch_array(mysql_query("select * from jenis_jaminan WHERE id='$jaminan[0]' ")); 
						  $jenis_jaminan	=$jj['nama_jaminan'];
							$nomor_milik	=(isset($jaminan[1])) ?$jaminan[1]:0;
							$merk			=(isset($jaminan[2])) ?$jaminan[2]:0;
							$alamat_jaminan	=(isset($jaminan[3])) ?$jaminan[3]:0;
						    $nilai_jaminan	=(isset($jaminan[4])) ?$jaminan[4]:0;	
				
			
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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]  </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>			</td>
			<td width="38%" height="20" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo $id_pinj=0;?>
    Lamp-6, Lembar-<?php echo $no++;?> </div></td>
  </tr> 	  
      <tr>
        <td height="50" colspan="3" class="bottom"><p align="center" class="style6">SURAT  PERNYATAAN PEMINJAM
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
        <td class="style27">: <?php echo $r['namadepan'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Jenis Kelamin </td>
        <td class="style27">: <?php echo $r['jk'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Tempat, Tanggal Lahir </td>
        <td class="style27">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">NIK</td>
        <td class="style27">: <?php echo $r['nik'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="25" class="style9">Alamat</td>
        <td width="42%" class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td width="20%" height="25" class="style9">Pekerjaan/Usaha</td>
        <td width="42%" class="style27">: <?php echo "$pek[nama_usaha]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9 align-justify"><p>Dengan  ini menyatakan dengan sebenarnya dan pernyataan ini tidak dapat  ditarik kembali, bahwa:</p>
          <ol class="style9 align-justify">
              
			   <?php if($_SESSION['lokasi']=='80') { //Khusus Wringinanom Gresik ?>
			   
			   <li>Saya selaku Anggota Kelompok <span class="style9"><?php echo $nama_kelompok;?></span> binaan <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span> melalui Desa/Kelurahan <span class="style9"><?php echo $nama_desa;?></span>, Kecamatan <span class="style9"><?php echo $nama_kec;?></span> Kabupaten <span class="style9"><?php echo $nama_kab;?></span>, benar-benar telah meminjam uang sebesar <span class="style27"> Rp. <?php echo number_format($r['alokasi']);?> (<?php echo ucwords(toTerbilang($r['alokasi']));?> Rupiah)</span>, dengan jaminan berupa tabungan tanggung renteng yang dikumpulkan di rekening kelompok.<br><br></li>
				<li>Apabila terjadi kemacetan atas kredit saya tersebut, saya bersedia menyerahkan seluruh tabungan saya dikelompok kepada pihak yang berwenang, guna menyelesaikan kredit/pinjaman saya kepada <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span></li><br>
              
			  <?php } else { ?>
			  
			  <li>Saya selaku Anggota Kelompok <span class="style9"><?php echo $r['nama_kelompok'];?></span> binaan <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span> melalui Desa/Kelurahan <span class="style9"><?php echo $nama_desa;?></span>, Kecamatan <span class="style9"><?php echo $nama_kec;?></span> Kabupaten <span class="style9"><?php echo $nama_kab;?></span>, benar-benar mengajukan pinjaman uang sebesar <span class="style27"> Rp. <?php echo number_format($r['alokasi']);?> (<?php echo ucwords(toTerbilang($r['alokasi']));?> Rupiah)</span>, dengan jaminan berupa barang kepada kelompok. Barang yang saya jaminkan sebagai berikut :<br><br>
                <ul>
                 <table border=0 class="style9">
				<?php if($jenis_jaminan=$jenis_jaminan){?>
				<tr>
                  <td><li>Nama Barang </li></td><td>:</td><td> <?php echo "$jenis_jaminan $merk $nomor_milik $alamat_jaminan"; ?>,</td>
				  </tr>
				<tr>
                  <td>Nilai Jual </td><td>:</td><td>  Rp <?php echo number_format($nilai_jaminan).".-"; ?></td>
				</tr><?php }else{?><tr>
                  <td><li>Nama Barang </td><td>:</td><td> _________________________________________________________________,</li></td>
				  </tr>
				<tr>
                  <td>Nilai Jual </td><td>:</td><td>  Rp_______________</td>
				  </tr><?php }?>
				<tr>
                  <td><li>Nama Barang </td><td>:</td><td> _________________________________________________________________,</li></td>
				  </tr>
				<tr>
                  <td>Nilai Jual </td><td>:</td><td>  Rp_______________</td>
				  </tr>
				<tr>
                  <td><li>Nama Barang </td><td>:</td><td> _________________________________________________________________,</li></td>
				  </tr>
				<tr>
                  <td>Nilai Jual </td><td>:</td><td> Rp _______________</td>
				  </tr>
				</table>
                </ul>
              </li>
              <li>Barang yang saya jaminkan kepada kelompok tersebut adalah benar-benar milik saya sendiri,</li><br>
              <li>Saya berkewajiban merawat dan melindungi barang jaminan tersebut dan tidak akan menjual, menggadaikan, dan/atau memindahtangankan kepada pihak lain sebelum kredit/pinjaman saya tersebut lunas,</li><br>
			  <li>Apabila terjadi kemacetan atas kredit saya tersebut, saya bersedia menyerahkan barang jaminan tersebut kepada pihak yang berwenang, guna menyelesaikan kredit/pinjaman saya kepada <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span>,</li><br>
              
			  <?php } ?>
			  
			  <li>Saya berjanji akan mengembalikan       pinjaman saya tersebut sesuai dengan peraturan yang ada di <?php echo $row['nama_lembaga_sort'];?> Kecamatan <span class="style9"><?php echo $nama_kec;?></span>,</li><br>
              <li>Apabila di kemudian hari saya melanggar isi dari surat pernyataan ini, maka saya bersedia dilaporkan kepada pihak yang berwajib dan/atau diproses secara&nbsp; hukum.</li><br>
			
			<?php if($_SESSION['lokasi']=='1' OR $_SESSION['lokasi']=='67') { ?>
			
			  <li>Jika dikemudian hari terjadi <i>force majeure</i> seperti banjir, gempa bumi, tanah longsor, petir, angin topan, kebakaran, huru-hara, kerusuhan, pemberontakan, dan perang 
			  atau saya berhalangan tetap seperti sakit atau meninggal dunia yang mengakibatkan tidak dapat terpenuhinya kewajiban saya sesuai poin 5 (lima) diatas,
			  maka sisa angsuran akan ditanggung oleh ahli waris.</li>
			  <?php } ?>
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
          <p>Saksi 2<br>Ketua Kelompok </p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
          <p>Saksi 1<br>
            <//?php echo $r['kekeluargaan']; ?> </p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
          <p>Yang Menyatakan </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($r['ketua']); ?></p></th>
        <th width="36%" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo strtoupper($r['penjamin']); ?></th>
        <th width="32%" class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper($r['namadepan']); ?></p></th>
  </tr>
</table>
<div style="page-break-after: always;">
</div>

<?php 

}
?>        
</body>
<title>Surat Pernyataan Anggota <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>