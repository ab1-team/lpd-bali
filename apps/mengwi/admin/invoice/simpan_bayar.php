<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_admin.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_rekening="admin_rekening";
$table_transaksi="admin_transaksi";
		
$tgl_transaksi			=$_POST['tgl_transaksi'];

$rekening_debit			=$_POST['jenis_pembayaran'];

$idv					=$_POST['idv'];
$keterangan_transaksi	=$_POST['keterangan_transaksi'];
$jumlah					=$_POST['jumlah'];
$id_user				=$_SESSION['id'];

$r=mysql_fetch_array(mysql_query("select * FROM $table_rekening WHERE kd_rekening='$rekening_debit' ")); //Deklarasi Pasangan Rekening
$rekening_kredit=$r['pasangan'];


$tagihan	=sumTagihan($idv);
$sumjum		=sumBayar($idv);

$sumjumlah	=$sumjum+$jumlah;

$persen =floor($jumlah/$tagihan*100);

if($sumjumlah >= $tagihan) {
	
	$update	= "UPDATE admin_invoice SET tgl_lunas	='$tgl_transaksi', status='PAID'
									WHERE idv='$idv' AND status='UNPAID' ";
	mysql_query($update);
}


	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idv,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','$idv','$keterangan_transaksi ($persen%)','$jumlah','0','$id_user')";
	mysql_query($input);
	

?>