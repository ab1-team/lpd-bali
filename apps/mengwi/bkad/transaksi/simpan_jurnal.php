<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_rekening="bkad_rekening";
$table_transaksi="bkad_transaksi";
		
$tgl_transaksi			=$_POST['tgl_transaksi'];
$rekening_debit			=$_POST['rekening_debit'];
$rekening_kredit		=$_POST['rekening_kredit'];
$keterangan_transaksi	=$_POST['keterangan_transaksi'];
$jumlah					=$_POST['nominal'];
$id_user				=$_SESSION['id'];

$sql = mysql_query("SELECT *
				   FROM $table_transaksi 
				   WHERE idt= '$idt'");
$row	= mysql_num_rows($sql);


if ($row>0){
	$update	= "UPDATE $table_transaksi SET jumlah	='$jumlah'
									WHERE idt= '$idt'";
	mysql_query($update);

}else{

	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idv,keterangan_transaksi,jumlah,urutan,lokasi,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','0','$keterangan_transaksi','$jumlah','0','$_SESSION[lokasi]','$id_user')";
	mysql_query($input);
	
}	
?>