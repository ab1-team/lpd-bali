<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_buku = $_GET['jenis_buku'];
$_SESSION['jenis_buku']	= $jenis_buku;

$row=mysql_fetch_array(mysql_query("select * from bkad_buku WHERE id='$jenis_buku' "));

echo "<option>-- Mutasi $row[nama_jb] --</option>
		<option value='$jenis_buku-debit'>Debit</option>
      <option value='$jenis_buku-kredit'>Kredit</option>";

?>
