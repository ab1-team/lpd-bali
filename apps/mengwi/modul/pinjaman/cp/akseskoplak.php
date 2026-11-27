<?php

$dashboard=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE hak_akses LIKE '%1%' "));
$pengaturanSop=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE hak_akses LIKE '%2%' "));
$pengaturanAwalLaporan=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE hak_akses LIKE '%3%' "));
$pengaturanEB=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE hak_akses LIKE '%3%' "));

	
	if ($!empty($dashboard)) {
		echo "dashboard";
	}else if ($!empty($pengaturan)) {
		echo "pengaturan";
	}else{
		
		echo "dashboard,pengaturan";
	}

?>