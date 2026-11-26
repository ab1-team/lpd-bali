<?php session_start();
if (!$_SESSION['lokasi']) die;
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$tgl_transaksi			=$_POST['tgl_transaksi'] ?: 0;
$urutan					=$_POST['urutan'] ?: 0;
$rekening_debit			=$_POST['rekening_debit'] ?: 0;
$rekening_kredit		=$_POST['rekening_kredit'] ?: 0;
$keterangan_transaksi	=$_POST['keterangan_transaksi'] ?: 0;
$unit					=$_POST['unit'] ?: 0;
$harsat					=$_POST['harsat'] ?: 0;
$kategori				=$_POST['kategori'] ?: 0;
$jumlah					=$unit*$harsat;
$umur_ekonomis			=$_POST['umur_ekonomis'] ?: 0;
$lokasi					=$_SESSION['lokasi'] ?: 0;
$id_user				=$_SESSION['id'] ?: 0;

if($rekening_kredit=="111.21") {$jenis="1";} else if($rekening_kredit=="111.20") {$jenis="2";} else if($rekening_kredit=="111.22") {$jenis="3";}

	$input_transaksi = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES(null,'$tgl_transaksi','$rekening_debit','$rekening_kredit','0','0','$keterangan_transaksi','$jumlah','0','$id_user')";
	mysql_query($input_transaksi);
	
	$input_inventaris = "INSERT INTO inventaris_$_SESSION[kd_kab] (id,lokasi,nama_barang,tgl_beli,unit,harsat,kategori,umur_ekonomis,jenis,status)
				VALUES(null,'$lokasi','$keterangan_transaksi','$tgl_transaksi','$unit','$harsat','$kategori','$umur_ekonomis','$jenis','Baik')";
	mysql_query($input_inventaris);
		
?>