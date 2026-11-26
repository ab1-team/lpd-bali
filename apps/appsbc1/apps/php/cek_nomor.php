<?php
include "../../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$NomorHPTujuan	= anti_injection($_POST['nomor_hp']);

	
	$user	=mysql_query("SELECT * FROM users WHERE nomor_hp='$NomorHPTujuan' ");
	$ketemu	=mysql_num_rows($user);
	
	if ($ketemu > 0){
		
	echo "<p class='color-red1-dark'>NOMOR TELAH TERDAFTAR SEBELUMNYA, SILAHKAN GUNAKAN NOMOR LAIN ATAU HUBUNGI CS</p>";

}
?>