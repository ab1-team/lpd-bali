<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code
	
$table	= "anggota_$_SESSION[kd_kab]";

$nia			=$_POST['niaa'];
$nik			=$_POST['nik'];
$namadepan		=addslashes($_POST['namadepan']); //addslashes berfungsi menginput karakter petik
$jk				=$_POST['jk'];
$tempat_lahir	=$_POST['tempat_lahir'];
$tgl_lahir		=$_POST['tgl_lahir'];
$alamat			=$_POST['alamat'];
$desa			=$_POST['desaa'];
$hp				=$_POST['hp'];
$kk				=$_POST['kk'];
$nik_penjamin	=$_POST['nik_penjamin'];
$penjamin		=addslashes($_POST['penjamin']);
$hubungan		=$_POST['hubungan'];
$usaha			=$_POST['usaha'];
$terdaftar		=date('Y-m-d');
$status			="1";
$petugas		=$_SESSION['id'];
$online			="T";
$lo				=date('Y-m-d H:i:s');
$uname			=$_POST['uname'];
$pass			=$_POST['pass'];


		
		
		
$sql = mysql_query("SELECT * FROM $table WHERE id='$nia' ");
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
									terdaftar	='$terdaftar',
									status		='$status',
									petugas		='$petugas',
									online		='$online',
									lo			='$lo',
									uname		='$uname',
									pass		='$pass'
					WHERE id='$nia'";
	mysql_query($input);								
}else{
	$input = "INSERT INTO $table (nik,namadepan,jk,tempat_lahir,tgl_lahir,alamat,desa,lokasi,hp,kk,nik_penjamin,penjamin,hubungan,usaha,terdaftar,status,petugas,online,nilai,kunjungan,lo,uname,pass)
				VALUES('$nik', '$namadepan', '$jk', '$tempat_lahir', '$tgl_lahir', '$alamat', '$desa', '$_SESSION[lokasi]', '$hp', '$kk', '$nik_penjamin', '$penjamin', '$hubungan', '$usaha', '$terdaftar', '$status', '$petugas', '$online','0', '0','$lo', '$uname', '$pass')";
	mysql_query($input);
	
}
?>