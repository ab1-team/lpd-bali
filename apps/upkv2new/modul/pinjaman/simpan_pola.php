<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="pola_angsuran_$_SESSION[kd_kab]";

	$input = "INSERT INTO $table (id,id_pinj,a1,a2,a3,a4,a5,a6,a7,a8,a9,a10,a11,a12,a13,a14,a15,a16,a17,a18,a19,a20,a21,a22,a23,a24,user_id)
				VALUES('','','','','','','','','','','','','','','','','','','','','','','','','','','$_SESSION[id]')";
	mysql_query($input);

?>