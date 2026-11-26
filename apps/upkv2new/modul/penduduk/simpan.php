<?php session_start();
include "../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";

$nik			=$_POST['nik'] ?: '0';
$namadepan		=addslashes($_POST['namadepan']) ?: '0'; //addslashes berfungsi menginput karakter petik
$jk				=$_POST['jk'] ?: '0';
$tempat_lahir	=$_POST['tempat_lahir'] ?: '0';
$tgl_lahir		=$_POST['tgl_lahir'] ?: '0';
$alamat			=$_POST['alamat'] ?: '0';
$desa			=$_POST['desaa'] ?: '0';
$hp				=$_POST['hp'] ?: '0';
$kk				=$_POST['kk'] ?: '0';
$nik_penjamin	=$_POST['nik_penjamin'] ?: '0';
$penjamin		=addslashes($_POST['penjamin']) ?: '0';
$hubungan		=$_POST['hubungan'] ?: '0';
$usaha			=$_POST['usaha'] ?: '0';
$jenis_jaminan	=$_POST['jenis_jaminan'] ?: '0';
$nomor_milik	=$_POST['nomor_milik'] ?: '0';
$merk			=$_POST['merk'] ?: '0';
$alamat_jaminan	=$_POST['alamat_jaminan'] ?: '0';
$nilai_jaminan	=$_POST['nilai_jaminan'] ?: '0';
$jaminan		="$jenis_jaminan,$nomor_milik,$merk,$alamat_jaminan,$nilai_jaminan";
$foto			=addslashes($_POST['foto']) ?: '0';
$terdaftar		=date('Y-m-d') ?: '0';
$status			="1" ?: '0';
$petugas		=$_SESSION['id'] ?: '0';
$online			="T" ?: '0';
$lo				=date('Y-m-d H:i:s') ?: '0';
$uname			=$_POST['uname'] ?: '0';
$pass			=$_POST['pass'] ?: '0';


$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nik='$nik' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET 	nik			='$nik',
									namadepan	='$namadepan',
									jk			='$jk',
									tempat_lahir='$tempat_lahir',
									tgl_lahir	='$tgl_lahir',
									alamat		='$alamat',
									desa		='$desa',
									lokasi		='$_SESSION[lokasi]',
									hp			='$hp',
									kk			='$kk',
									nik_penjamin='$nik_penjamin',
									penjamin	='$penjamin',
									hubungan	='$hubungan',
									usaha		='$usaha',
									jaminan		='$jaminan',
									foto		='$foto',
									terdaftar	='$terdaftar',
									status		='$status',
									petugas		='$petugas',
									online		='$online',
									lo			='$lo',
									uname		='$uname',
									pass		='$pass'
					WHERE nik='$nik'";
	mysql_query($input);								
}else{
	$input = "INSERT INTO $table (nik,namadepan,jk,tempat_lahir,tgl_lahir,alamat,desa,lokasi,hp,kk,nik_penjamin,penjamin,hubungan,usaha,jaminan,foto,terdaftar,status,petugas,online,nilai,kunjungan,lo,uname,pass)
				VALUES('$nik', '$namadepan', '$jk', '$tempat_lahir', '$tgl_lahir', '$alamat', '$desa', '$_SESSION[lokasi]', '$hp', '$kk', '$nik_penjamin', '$penjamin', '$hubungan', '$usaha','$jaminan','$foto', '$terdaftar', '$status', '$petugas', '$online','0', '0','$lo', '$uname', '$pass')";
	mysql_query($input);
}	

?>