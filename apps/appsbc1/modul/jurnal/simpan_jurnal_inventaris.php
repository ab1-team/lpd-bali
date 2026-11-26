<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$tgl_transaksi			=$_POST['tgl_transaksi'];
$urutan					=$_POST['urutan'];
$rekening_debit			=$_POST['rekening_debit'];
$rekening_kredit		=$_POST['rekening_kredit'];
$keterangan_transaksi	=$_POST['keterangan_transaksi'];
$unit					=$_POST['unit'];
$harsat					=$_POST['harsat'];
$jumlah					=$unit*$harsat;
$umur_ekonomis			=$_POST['umur_ekonomis'];
$lokasi					=$_SESSION['lokasi'];
$id_user				=$_SESSION['id'];

if($rekening_kredit=="111.21") {$jenis="1";} else if($rekening_kredit=="111.20") {$jenis="2";} else if($rekening_kredit=="111.22") {$jenis="3";}

	$input_transaksi = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','0','0','$keterangan_transaksi','$jumlah','$urutan','$id_user')";
	mysql_query($input_transaksi);
	
	$input_inventaris = "INSERT INTO inventaris_$_SESSION[kd_kab] (id,lokasi,nama_barang,tgl_beli,unit,harsat,umur_ekonomis,jenis)
				VALUES('','$lokasi','$keterangan_transaksi','$tgl_transaksi','$unit','$harsat','$umur_ekonomis','$jenis')";
	mysql_query($input_inventaris);
		
?>