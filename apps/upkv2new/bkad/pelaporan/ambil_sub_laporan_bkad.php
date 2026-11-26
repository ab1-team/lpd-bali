<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_laporan = $_POST['cari'];

if($jenis_laporan==3) {

$view=mysql_query("select * from bkad_buku WHERE 
kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'  AND lokasi='0' or 
lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'  ORDER by jb_bkad ASC ");
		echo "<option value=''>-- Pilih Sub Laporan SAK--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='BA-$row[jb_bkad]'>$row[nama_jb]</option>";
					}
	
} else {
	
	echo "<option value=''>-- Silahkan klik Tombol Format Pelaporan --</option>";
}

?>
