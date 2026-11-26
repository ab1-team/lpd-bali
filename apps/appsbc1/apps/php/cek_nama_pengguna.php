<?php session_start();
include "../../inc/inc.koneksi.php";

	$nama	=mysql_fetch_array(mysql_query("SELECT * FROM jabatan j, users u WHERE j.id=u.jabatan AND u.id='$_SESSION[id]' "));
		
	echo '<b>'.$nama['namadepan'].' '.$nama['namabelakang'].'</b> <span class="badge bg-red2-dark font-11"> '.$nama['nama_jabatan'].'</span>';

?>