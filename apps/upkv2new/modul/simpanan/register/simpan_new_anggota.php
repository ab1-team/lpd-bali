<?php session_start();
include "../../../inc/inc.koneksi.php";
$table	= "anggota";

$nik		=$_POST['nik'] ?: null;
$rek_anggota=$_POST['rek_anggota'] ?: null;
$tanggal	=$_POST['tgl_transaksi'] ?: null;
$lokasi		=$_SESSION['lokasi'] ?: null;
$user_id	=$_SESSION['id'] ?: null;

$simpok		=$_POST['simpok'] ?: null;
$simjib		=$_POST['simjib'] ?: null;
$simsuka	=$_POST['simsuka'] ?: null;


$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nik='$nik' AND lokasi='$lokasi' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET 	nik			='$nik',
									rek_anggota	='$rek_anggota',
									tanggal		='$tanggal',
									lokasi		='$lokasi',
									user_id		='$user_id'
					WHERE nik='$nik'";
	mysql_query($input);								
}else{
	$input = "INSERT INTO $table (nik,rek_anggota,tanggal,lokasi,user_id)
				VALUES('$nik','$rek_anggota', '$tanggal', '$lokasi','$user_id')";
	mysql_query($input);
}

$input_simpok = "INSERT INTO transaksi_$lokasi (tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,rek_anggota,keterangan_transaksi,jumlah,id_user)
				VALUES('$tanggal', '0', '0','0','0','$rek_anggota','Simpanan Pokok','$simpok','$user_id')";

$input_simjib = "INSERT INTO transaksi_$lokasi (tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,rek_anggota,keterangan_transaksi,jumlah,id_user)
				VALUES('$tanggal', '0', '0','0','0','$rek_anggota','Simpanan Wajib','$simjib','$user_id')";

$input_simsuka = "INSERT INTO transaksi_$lokasi (tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,rek_anggota,keterangan_transaksi,jumlah,id_user)
				VALUES('$tanggal', '0', '0','0','0','$rek_anggota','Simpanan Sukarela','$simsuka','$user_id')";
			
if ($simsuka<=0){
	mysql_query($input_simpok);
	mysql_query($input_simjib);
	
}else if ($simsuka>0){
	mysql_query($input_simpok);
	mysql_query($input_simjib);
	mysql_query($input_simsuka);
}
?>