<?php session_start();
include "../../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$nama			=anti_injection(addslashes($_POST['nama']));
$nomor_hp		=anti_injection($_POST['nomor_hp']);
$alamat			=anti_injection($_POST['alamat']);
$pin			=anti_injection($_POST['pin']);
$tgl_register	=date('Y-m-d H:i:s');

$user	=mysql_query("SELECT * FROM users WHERE nomor_hp='$nomor_hp' ");
	$ketemu	=mysql_num_rows($user);
	
	if ($ketemu > 0){
		
		echo "<p class='color-red1-dark'>NOMOR TELAH TERDAFTAR SEBELUMNYA, SILAHKAN GUNAKAN NOMOR LAIN ATAU HUBUNGI CS</p>";
		
	}else{

	$input = "INSERT INTO users (id,nama,nomor_hp,alamat,pin,tgl_register,status)
				VALUES('', '$nama','$nomor_hp','$alamat','$pin','$tgl_register','1')";
	mysql_query($input);
	
	echo "<p class='color-green1-dark'>PENDAFTARAN BERHASIL, SILAHKAN <a href='login.php'>MASUK</a> MENGGUNAKAN NOMOR HP DAN PIN ANDA</p>";
	
	}
	
?>