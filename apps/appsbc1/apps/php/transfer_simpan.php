<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id_user				=$_SESSION['id'];
$pin					=$_POST['pin'];
$user	=mysql_query("SELECT * FROM users WHERE id='$id_user' AND pin='$pin' ");
	$ketemu	=mysql_num_rows($user);
	
if ($ketemu > 0){
	  	$r = mysql_fetch_array($user);
	
$table_transaksi="transaksi_1";

$tgl_transaksi			=date('Y-m-d H:i:s');
$urutan					="0";
$produk					=$_POST['produk'];
$id_user				=$r['id'];
$IDTujuan				=$_POST['IDTujuan'];
$tujuan					=$_POST['tujuan'];
$rekening_debit			="2-40002_$IDTujuan";
$rekening_kredit		="2-40002_$id_user";
$nominal				=$_POST['nominal'];

$jumlah = str_replace(".", "", $nominal);

$keterangan_transaksi	="$produk $nominal to $tujuan";

if ($r['saldo'] >= $jumlah) {
	
	//Input Penjurnalan ke Transaksi
	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,produk,tujuan,keterangan_transaksi,jumlah,status,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','$produk','$tujuan','$keterangan_transaksi','$jumlah','0','$urutan','$id_user')";
	mysql_query($input);
	
	//Update Saldo Masuk User
	$userM	=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$IDTujuan' AND nomor_hp='$tujuan' "));
	$masukM	=$userM['masuk']+$jumlah;
	$saldoM	=$userM['saldo']+$jumlah;
	mysql_query("UPDATE users SET masuk='$masukM',saldo='$saldoM' WHERE id='$IDTujuan' AND nomor_hp='$tujuan' ");
	
	//Update Saldo Keluar User
	$userK	=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$id_user' "));
	$KeluarK	=$userK['keluar']+$jumlah;
	$saldoK		=$userK['saldo']-$jumlah;
	mysql_query("UPDATE users SET keluar='$KeluarK',saldo='$saldoK' WHERE id='$id_user' ");
	
	echo "<p class='color-green2-dark'>TRANSAKSI BERHASIL <a href='index_transaksi.php'>[LIHAT]</a></p>";
	
}else{
	
	echo "<p class='color-red1-dark'>SALDO TIDAK MENCUKUPI</p>";
	
}	

}else{
	
	echo "<p class='color-red1-dark'>PIN SALAH</p>";
	
}	
?>