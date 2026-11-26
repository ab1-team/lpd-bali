<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

if($_SESSION['level']   == "pusat") {
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.center {text-align:center; }
-->
</style>
<body onLoad="window.print()">
<?php
		$idk=$_GET['idk'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan where id='$idk' "));
				$tgl_pakai=$row['tgl_pakai'];
				$tanggal			 = substr($tgl_pakai,8,2);
											$bulan  			 = getBulan(substr($tgl_pakai,5,2));
											$tahun  			 = substr($tgl_pakai,0,4);
			?>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left">PT. Asta Brata Teknologi<br>
				Jalan Raya K.H. Khudlori Km. 1.5 Magelang				</div>			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Berita Acara<br>
			Migrasi Data SI UPK Online</div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		BERITA ACARA MIGRASI DATA SI UPK ONLINE <br>
		<span class="fw-semi-bold"><?php echo strtoupper($row['nama_lembaga_sort']);?> KECAMATAN <?php echo strtoupper($row['nama_kec']);?><br>Nomor : <?php echo "$row[kd_kab].$row[id]/BA.UPK-Apps";?><?php echo tgl_rom($row['tgl_pakai']);?></p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="81" colspan="4" class="style9"><div align="justify">
          <p>
		  <?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_pakai', CURDATE()) as selisih";
				$hasil = mysql_query($query);
				$data  = mysql_fetch_array($hasil);

				$selisih = $data['selisih'];
				 
				$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
				$namahari = date("l", $x);
				 
				if ($namahari == "Sunday") $namahari = "Minggu";
				else if ($namahari == "Monday") $namahari = "Senin";
				else if ($namahari == "Tuesday") $namahari = "Selasa";
				else if ($namahari == "Wednesday") $namahari = "Rabu";
				else if ($namahari == "Thursday") $namahari = "Kamis";
				else if ($namahari == "Friday") $namahari = "Jumat";
				else if ($namahari == "Saturday") $namahari = "Sabtu";
				
				// dipilih tanggal 1 Maret 2010 sebagai acuan  
				// hari pasaran tanggal 1 Maret 2010 adalah 'Pon'  
				$tgl1 = "2010-03-01";    

				// array urutan nama hari pasaran dimulai dari 'Pon'  
				$pasaran = array('Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing');  
				  
				// proses mencari selisih hari antara kedua tanggal  
				$pecah1 = explode("-", $tgl1);  
				$date1 = $pecah1[2];  
				$month1 = $pecah1[1];  
				$year1 = $pecah1[0];  
				  
				$pecah2 = explode("-", $tgl_pakai);  
				$date2 = $pecah2[2];  
				$month2 = $pecah2[1];  
				$year2 =  $pecah2[0];  
				  
				$jd1 = GregorianToJD($month1, $date1, $year1);  
				$jd2 = GregorianToJD($month2, $date2, $year2);  
				  
				$selisih = $jd2 - $jd1;  
				  
				// hitung modulo 5 dari selisih harinya  
				$mod = $selisih % 5;  
				?>
		Pada hari ini <b> <?php echo "$namahari $pasaran[$mod]";?> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, telah selesai dilakukan migrasi data laporan
          UPK Kecamatan <?php echo $row['nama_kec'];?>  dari format Microsoft Excel (*.xls) ke Sistem Informasi UPK berbasis Online (SI UPK Online) dengan posisi Neraca dan Rugi Laba sebagaimana terlampir.</p>
          <p>Untuk selanjutnya pihak BKAD dan kelengkapannya dapat menggunakan SI UPK Online ini per tanggal sebagai mana tersebut diatas yang ditetapkan sebagai tanggal awal penggunaan aplikasi ini dengan cara mengakses alamat website <b><?php echo $row['web_kec'];?></b> dengan memasukkan username dan password dibawah ini sesuai dengan jabatan masing-masing. </p>
        </div></td>
      </tr>
	  </table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">ID</th>
			<th width="20%" class="style9 left bottom top" >NAMA DEPAN </th>
              <th width="20%" class="style9 left bottom top">NAMA BELAKANG</th>
              <th width="20%" class="style9 left bottom top">JABATAN/LEVEL</th>
              <th width="10%" class="style9 left bottom top">USERNAME</th>
              <th width="10%" class="style9 left bottom top">PASSWORD</th>
              <th width="15%" class="style9 left bottom top right">INISIAL</th>
        </tr>      
		
<?php 	

		
		$userss=mysql_query("select * FROM jabatan j, level l, users u WHERE u.jabatan=j.id AND u.level=l.id AND u.lokasi='$idk' order by u.id ASC");  /* untuk memunculkan ke tabel tampil */	
		
		while($rows=mysql_fetch_array($userss)){
						  
					
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="30" class="style9 top left"><?php echo $rows['id'];?></td>
              <td class="style9 left top"><?php echo $rows['namadepan'];?></td>
              <td class="style9 left top"><?php echo $rows['namabelakang']; ?></td>
              <td class="style9 left top"><?php echo $rows['nama_jabatan']; ?> <?php echo $rows['nama_level']; ?></td>
              <td class="style9 left top"><span class="style9"><div align="center"><?php echo $rows['uname'];?></div></span></td>
              <td class="style9 left top"><div align="center"><?php echo $rows['pass'];?></div></td>
              <td class="style9 left top right"><div align="center"><?php echo $rows['ins'];?></div></td>
            </tr>
  <?php 

  }?>
	
</table>
	  <tr>
        <td height="37" colspan="4" class="style9"><p align="justify" class="style9">Demikian, berita acara ini dibuat dan merupakan bagian tak terpisahkan dari Dokumen Nota Kesepahaman Bersama 
		(<i>Memorandum of Understanding - MoU</i>) antara PT. Asta Brata Teknologi dengan Badan Kerjasama Antar Desa (BKAD) Kecamatan <?php echo $row['nama_kec'];?>.</p>          </td>
  </tr>
      <tr>
        <td width="191" height="25" class="style9">&nbsp;</td>
        <td width="349" height="25" class="style27">&nbsp;</td>
        <td width="224" height="25" class="style9">&nbsp;</td>
        <td width="271" height="25" class="style27">&nbsp;</td>
      </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

      

      <tr>
        <td width="49%" height="36" colspan="1" class="style26">&nbsp;</td>
        <td width="51%" class="style26"><div align="center" class="style9">
          <p>Direktur,<br>PT. Asta Brata Teknologi<br>
          <i>Chief Technology Officer - CTO</i> SI UPK Online </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p>&nbsp;</p></th>
        <th class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p>MA'ARIF, S.Kom., CEH., CHFI., ECSS</p></th>
  </tr>
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      
      <?php if($ttd_mengetahui=="1") { ?>
<?php } else if($ttd_mengetahui=="2") { ?>
<?php } else if($ttd_mengetahui=="3") { ?>
<?php } else if($ttd_mengetahui=="4") { ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php } ?>
      
      <tr>
        <td height="19" colspan="2" class="style9">&nbsp;</td>
      </tr>
</table>
<title>Berita Acara Migrasi Data</title>
      
</body>

<?php } else {
	
	echo "<h1>Maaf, Anda tidak memiliki otoritas akses halaman ini!</h1>";
}?>