<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";


$tgl_transaksi	= $_POST['tgl_transaksi'];
$nia			= $_POST['nia'];
$id_simp_i		= $_POST['id_simp_i'];
$jenis_mutasi	= $_POST['jenis_mutasi'];
$jumlah			= str_replace(".", "", $_POST['jumlah']);
$user_id		= $_SESSION['id'];

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where a.id=sa.nia AND sa.id='$id_simp_i' "));
$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));


if($jenis_mutasi=="setor") {	
$rekening_debit		="1-10001";	//Kas Umum
$rekening_kredit	="$rek[kd_rekening]_$id_simp_i"; //Rek Simpanan Umum
$keterangan_transaksi="Setor SU $nm[nomor_rekening] $nm[namadepan]";	
}else if($jenis_mutasi=="tarik") {
$rekening_debit		="$rek[kd_rekening]_$id_simp_i"; //Rek Simpanan Umum
$rekening_kredit	="1-10001"; //Kas Umum
$keterangan_transaksi="Tarik SU $nm[nomor_rekening] $nm[namadepan]";
}


mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('$tgl_transaksi','$rekening_debit', '$rekening_kredit', '0','$keterangan_transaksi','$jumlah','','$user_id')");
 

				
	

?>