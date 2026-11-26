<?php
include "../../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$NomorHPTujuan	= anti_injection($_POST['NomorHPTujuan']);

	
	$user	=mysql_query("SELECT * FROM users WHERE hp='$NomorHPTujuan' ");
	$ketemu	=mysql_num_rows($user);
	
	if ($ketemu > 0){
	  	$r = mysql_fetch_array($user);
		
	echo "<p class='color-green2-dark'> PEMILIK : ".strtoupper($r['nama'])."";
	echo "<input type='hidden' class='mt-n5' id='IDTujuan' value='$r[id]' /></p>";

}else{
	echo "<p class='color-red1-dark'>NOMOR BELUM TERDAFTAR";
	echo "<input type='hidden' class='mt-n5' id='IDTujuan' value='' /></p>";
	
}
?>