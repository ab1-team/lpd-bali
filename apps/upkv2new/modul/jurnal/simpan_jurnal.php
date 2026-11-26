<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', '1'); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idt					=$_POST['idt'] ?: 0;
$tgl_transaksi			=$_POST['tgl_transaksi'] ?: 0;
$urutan					=$_POST['urutan'] ?: 0;
$rekening_debit			=$_POST['rekening_debit'] ?: 0;
$rekening_kredit		=$_POST['rekening_kredit'] ?: 0;
$keterangantransaksi	=$_POST['keterangan_transaksi'] ?: 0;
$keterangan_transaksi	=htmlentities($keterangantransaksi,ENT_QUOTES);
$nominal				=$_POST['nominal'] ?: 0;
$rupiah				=$_POST['rupiah'] ?: 0;
$id_user				=$_SESSION['id'] ?: 0;

$jumlah = str_replace(".", "", $nominal);

if (!$rupiah || $rupiah == null || $rupiah == 00 || $rupiah == 'undefined') {
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
	$query = mysql_query($update);

}else{

	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES(null,'$tgl_transaksi','$rekening_debit','$rekening_kredit','0','0','$keterangan_transaksi','$jumlah','$urutan','$id_user')";
	$query = mysql_query($input);
	
}
?>