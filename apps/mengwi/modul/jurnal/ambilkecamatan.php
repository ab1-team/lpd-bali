<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_buku = $_GET['jenis_buku'];
$_SESSION['jenis_buku']	= $jenis_buku; //Dikirim ke Tombol Cetak Buku SAK dan PTO

$row=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$jenis_buku' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR  kd_jb='$jenis_buku' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
echo "<option>-- Mutasi $row[nama_jb] --</option>
		<option value='$jenis_buku-debit'>Debit</option>
      <option value='$jenis_buku-kredit'>Kredit</option>";

?>
