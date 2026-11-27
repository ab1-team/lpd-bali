<?php session_start();
include "../../inc/inc.koneksi.php";

if (isset($_GET['jenis_kegiatan'])) {
		echo "<option value=''>-- Pilih Nama Usaha --</option>";
			
	$data=mysql_query("select * from usaha WHERE jenis_kegiatan='$_GET[jenis_kegiatan]' order by nama_usaha asc"); //USAHA
		while($rows=mysql_fetch_array($data)){
			echo "<option value='$rows[id]'>$rows[nama_usaha]</option>";
		}
} else {
    $data = mysql_query("select * from usaha WHERE id=$_GET[id_usaha]");
    $row = mysql_fetch_array($data);
    
    $jk = mysql_query("SELECT * FROm jenis_kegiatan WHERE id=$row[jenis_kegiatan]");
    $return = mysql_fetch_array($jk);
    echo $return['id'];
}
?>
