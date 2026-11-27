<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idt					=$_POST['idt'];
$tgl_transaksi			=$_POST['tgl_transaksi'];
$urutan					=$_POST['urutan'];
$rekening_debit			=$_POST['rekening_debit'];
$rekening_kredit		=$_POST['rekening_kredit'];
$keterangan_transaksi	=$_POST['keterangan_transaksi'];
$nominal				=$_POST['nominal'];
$rupiah				    =$_POST['rupiah'];
$id_user				=$_SESSION['id'];

$jumlah = str_replace(".", "", $nominal);

if (!$rupiah || $rupiah == null || $rupiah == 00) {
    $rupiah = '00';
}
$jumlah = $jumlah . '.' . $rupiah;
$sql = mysql_query("SELECT *
				   FROM $table_transaksi 
				   WHERE idt= '$idt'");
$row	= mysql_num_rows($sql);


if ($row>0){
	$update	= "UPDATE $table_transaksi SET tgl_transaksi	='$tgl_transaksi',
											keterangan_transaksi	='$keterangan_transaksi', 
											urutan	='$urutan',
											jumlah	='$jumlah',
											id_user	='$id_user'
									WHERE idt= '$idt'";
	mysql_query($update);

}else{

	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','0','0','$keterangan_transaksi','$jumlah','$urutan','$id_user')";
	mysql_query($input);
	
}	
?>