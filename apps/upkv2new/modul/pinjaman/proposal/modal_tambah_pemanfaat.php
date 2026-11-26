<?php session_start();
include "../../../inc/inc.koneksi.php"; 
											
$view=mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE lokasi='$_SESSION[lokasi]' and desa='$_POST[cari]' order by namadepan ASC "); //ANGGOTA
	while($row=mysql_fetch_array($view)){
		echo "<option value='$row[id]'>$row[nik] - $row[namadepan] $row[alamat]</option>";
	}
?>