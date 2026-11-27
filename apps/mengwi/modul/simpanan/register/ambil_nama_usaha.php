<?php session_start();
include "../../../inc/inc.koneksi.php";

		echo "<option value=''>-- Pilih Nama Usaha --</option>";
			
	$data=mysql_query("select * from usaha WHERE jenis_kegiatan='$_GET[jenis_kegiatan]' order by nama_usaha asc"); //USAHA
		while($rows=mysql_fetch_array($data)){
			echo "<option value='$rows[id]'>$rows[nama_usaha]</option>";
		}
?>
