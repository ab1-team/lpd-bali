<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="bkad_transaksi";

$idt		= $_POST['idt'];
$sql 	= mysql_query("SELECT * FROM $table_transaksi WHERE idt= '$idt'");
$row	= mysql_num_rows($sql);
$rows	= mysql_fetch_array($sql);


if ($row>0){
	$input = "DELETE FROM $table_transaksi WHERE idt= '$idt'";
	mysql_query($input);
}

?>