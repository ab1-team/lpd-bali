<?php session_start();
include "../../inc/inc.koneksi.php";
$id_barang = $_GET['id_barang'];

$row=mysql_fetch_array(mysql_query("select * from inventaris_$_SESSION[kd_kab] WHERE id='$id_barang' "));

     echo "<option value=$row[unit]>$row[unit] unit</option>";

	 for($unit=1;$unit<=$row['unit'];$unit++) //POKOK
			  {
			echo "<option value=$unit>$unit unit</option>";
			  }

?>
