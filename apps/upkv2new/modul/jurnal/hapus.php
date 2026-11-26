<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];
$table1	= "pinjaman_kelompok_$_SESSION[kd_kab]";
$table2	= "pinjaman_anggota_$_SESSION[kd_kab]";

$idt		= $_POST['idt'];
$sql 	= mysql_query("SELECT * FROM $table_transaksi WHERE idt= '$idt'");
$row	= mysql_num_rows($sql);
$rows	= mysql_fetch_array($sql);

$rekening_debit	=$rows['rekening_debit'];
$id_pinj		=$rows['id_pinj'];
$id_pinj_i		=$rows['id_pinj_i'];

if ($row>0){
	$input = "DELETE FROM $table_transaksi WHERE idt= '$idt'";
	mysql_query($input);
}

if ($rekening_debit=="131.01" OR $rekening_debit=="131.03" OR $rekening_debit=="132.01" OR $rekening_debit=="133.01" OR $rekening_debit=="134.01" OR $rekening_debit=="135.01" or $rekening_debit=="136.01" or $rekening_debit=="137.01") {
	$input1	= "UPDATE $table1 SET status='W' WHERE id= '$id_pinj' ";
	mysql_query($input1);
	
	if($id_pinj==0) { //Pinjaman Individu
	$input2	= "UPDATE $table2 SET status='W' WHERE id= '$id_pinj_i' AND jenis_pinjaman='I' ";
	mysql_query($input2);
	}else if($id_pinj_i==0) { //Pinjaman Kelompok
	$input3	= "UPDATE $table2 SET status='W' WHERE id_pinkel= '$id_pinj' AND jenis_pinjaman='K' ";
	mysql_query($input3);
	}
}
?>