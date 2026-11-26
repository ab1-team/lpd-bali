<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";


$tgl_transaksi	= $_POST['tgl_transaksi'] ?: '0';
$nia			= $_POST['nia'] ?: '0';
$id_simp_i		= $_POST['id_simp_i'] ?: '0';
$jenis_mutasi	= $_POST['jenis_mutasi'] ?: '0';
$jumlah			= str_replace(".", "", $_POST['jumlah']) ?: '0';
$lu				=date('Y-m-d H:i:s') ?: '0';
$user_id		= $_SESSION['id'] ?: '0';

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where 
a.id=sa.nia AND sa.id='$id_simp_i' "));
$perpanjang=$nm['jangka']+$jumlah;


if($jenis_mutasi=="setor") {	

	mysql_query("INSERT INTO $table2 (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
			VALUES(null,'$tgl_transaksi','119.02', '222.01', '0', '0', '0', '$id_simp_i' ,'Setor SD $nm[nomor_rekening] $nm[namadepan]','$jumlah','0','$user_id')");
	
}else if($jenis_mutasi=="tarik") {
	
	mysql_query("INSERT INTO $table2 (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
			VALUES(null,'$tgl_transaksi','222.04','119.04', '0', '0', '0', '$id_simp_i' , 'Tarik SD $nm[nomor_rekening] $nm[namadepan]','$jumlah','0','$user_id')");
	
}else if($jenis_mutasi=="perpanjangan") {	

	mysql_query("UPDATE $table SET jangka='$perpanjang', lu='$lu', user_id='$user_id' WHERE id= '$id_simp_i'");
	
}




				
	

?>