<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$tgl_transaksi			=$_POST['tgl_transaksi'];
$id_barang				=$_POST['id_barang'];
$rekening_debit			=$_POST['rekening_debit'];
$rekening_kredit		=$_POST['rekening_kredit'];
$status					=$_POST['status'];
$unit					=$_POST['unit'];
$unitm					=$_POST['unitm']; //Total Unit
$nominalm				=str_replace(".", "", $_POST['nominalm']); //Total Nilai Buku
$nominal_jual			=str_replace(".", "", $_POST['nominaljual']); //Total Penjualan

$row=mysql_fetch_array(mysql_query("select * from inventaris_$_SESSION[kd_kab] WHERE id='$id_barang' "));

$nama_barang			=$row['nama_barang'];
$tgl_beli				=$row['tgl_beli'];
$harsat					=$row['harsat'];
$umur_ekonomis			=$row['umur_ekonomis'];
$jenis					=$row['jenis'];

$keterangan_transaksi	="Penghapusan $unit unit $nama_barang karena $status ";

$nominal				=$_POST['nominal'];
$lokasi					=$_SESSION['lokasi'];
$id_user				=$_SESSION['id'];

$jumlah = str_replace(".", "", $nominal);

$sisa_unit				=$unitm-$unit;



	//Input Transaksi sejumlah nominal penghapusan
	$input_transaksi_hapus = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','0','0','$keterangan_transaksi','$jumlah','0','$id_user')";
	
	
	//Merubah Unit Inventaris 
	$update_unit_inventaris	= "UPDATE inventaris_$_SESSION[kd_kab] SET unit	='$sisa_unit', tgl_validasi='$tgl_transaksi'
									WHERE id= '$id_barang'";
	
	//Re-Input Inventaris yang dihapus dengan ganti status
	$reinput_inventaris = "INSERT INTO inventaris_$_SESSION[kd_kab] (id,lokasi,nama_barang,tgl_beli,unit,harsat,umur_ekonomis,jenis,status,tgl_validasi)
				VALUES('','$lokasi','$nama_barang','$tgl_beli','$unit','$harsat','$umur_ekonomis','$jenis','$status','$tgl_transaksi')";
	
	
	//Merubah Status Inventaris 
	$update_status_inventaris	= "UPDATE inventaris_$_SESSION[kd_kab] SET status	='$status', tgl_validasi='$tgl_transaksi'
									WHERE id= '$id_barang'";
	
	
	//Input Transaksi Penjualan sebagai Pendapatan
	$input_transaksi_jual = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','111.06','411.05','0','0','Penjualan $unit unit $nama_barang','$nominal_jual','0','$id_user')";
	
	
	//Jika Jumlah unit yang dihapus kurang dari unit yang ada (hapus beberapa/sebagian) (re-skedul)
	if($unit<$unitm) {
		mysql_query($input_transaksi_hapus);
		mysql_query($update_unit_inventaris);
		mysql_query($reinput_inventaris);
		
	}else if($unit==$unitm) {
		mysql_query($input_transaksi_hapus);
		mysql_query($update_status_inventaris);
	}
	
	if($status=="Dijual") {
		mysql_query($input_transaksi_jual);
	}
		
?>