<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";


$tgl_transaksi	= $_POST['tgl_transaksi'];
$nia			= $_POST['nia'];
$id_simp_i		= $_POST['id_simp_i'];
$jenis_mutasi	= $_POST['jenis_mutasi'];
$jumlah			= str_replace(".", "", $_POST['jumlah']);
$lu				=date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where 
a.id=sa.nia AND sa.id='$id_simp_i' "));
$perpanjang=$nm['jangka']+$jumlah;


if($jenis_mutasi=="setor") {	

	mysql_query("INSERT INTO $table2 (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
			VALUES('','$tgl_transaksi','1-10001', '2-40003_$id_simp_i', '0','Setor SD $nm[nomor_rekening] $nm[namadepan]','$jumlah','0','$user_id')");
	
}else if($jenis_mutasi=="tarik") {
	
	mysql_query("INSERT INTO $table2 (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
			VALUES('','$tgl_transaksi','2-40003_$id_simp_i','1-10001','0','Tarik SD $nm[nomor_rekening] $nm[namadepan]','$jumlah','0','$user_id')");
	
}else if($jenis_mutasi=="perpanjangan") {	

	mysql_query("UPDATE $table SET jangka='$perpanjang', lu='$lu', user_id='$user_id' WHERE id= '$id_simp_i'");
	
}




				
	

?>