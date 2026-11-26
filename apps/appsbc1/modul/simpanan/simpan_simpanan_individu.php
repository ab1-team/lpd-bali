<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";


$nia			= $_POST['nia'];
$jenis_simpanan	= $_POST['jenis_simpanan'];
$nomor_rekening	= $_POST['nomor_rekening'];
$tgl_buka		= $_POST['tgl_buka'];
$jumlah			= str_replace(".", "", $_POST['jumlah']);
$jangka			= $_POST['jangka'];
$pros_jasa		= $_POST['pros_jasa'];
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "A";
$tgl_tutup		= date('Y-m-d', strtotime('+'.$jangka. 'month', strtotime( $tgl_buka )));

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] where id='$nia' "));

$datadesa=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));
$datadesa=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));



$sql="INSERT INTO $table (lokasi,nomor_rekening,jenis_simpanan,nia,jumlah,jangka,pros_jasa,tgl_buka,tgl_tutup,tgl_st,status,lu,user_id)
				VALUES('$_SESSION[lokasi]','$nomor_rekening','$jenis_simpanan', '$nia', '$jumlah','$jangka','$pros_jasa','$tgl_buka','$tgl_tutup','','$status','$lu','$user_id')";


if (mysql_query($sql)) {  
  //mendapatkan id terakhir dengan fungsi mysql_insert_id  
  $last_id = mysql_insert_id($konek); 
  
$su=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));
$sd=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_deposito' "));

if($jenis_simpanan==1) {		//Tabungan Umum
$rekening_debit		="1-10001";	
$rekening_kredit	="$su[kd_rekening]_$last_id";
$last_norek			=$datadesa['last_kreditur']+1;
$field				="last_kreditur";
$keterangan_transaksi="Setoran Awal SU $nomor_rekening $nm[namadepan]";	
}else if($jenis_simpanan==2) {		//Tabungan Deposito
$rekening_debit		="1-10001";	
$rekening_kredit	="$sd[kd_rekening]_$last_id";
$last_norek			=$datadesa['last_deposito']+1;
$field				="last_deposito";
$keterangan_transaksi="Setor SD $nomor_rekening $nm[namadepan]";
}
  
  mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('$tgl_buka','$rekening_debit', '$rekening_kredit', '0','$keterangan_transaksi','$jumlah','','$user_id')");

$update	= "UPDATE desa SET $field='$last_norek' WHERE id= '$_SESSION[lokasi]'";
	mysql_query($update);
 
 }

 //menutup koneksi mysql   
 mysql_close($konek); 

				
	

?>