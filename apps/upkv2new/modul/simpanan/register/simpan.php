<?php session_start();
include "../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";

$nik			=$_POST['nik'] ?: null;
$namadepan		=addslashes($_POST['namadepan']) ?: null; //addslashes berfungsi menginput karakter petik
$jk				=$_POST['jk'] ?: null;
$tempat_lahir	=$_POST['tempat_lahir'] ?: null;
$tgl_lahir		=$_POST['tgl_lahir'] ?: null;
$alamat			=$_POST['alamat'] ?: null;
$desa			=$_POST['desaa'] ?: null;
$hp				=$_POST['hp'] ?: null;
$kk				=$_POST['kk'] ?: null;
$nik_penjamin	=$_POST['nik_penjamin'] ?: null;
$penjamin		=addslashes($_POST['penjamin']) ?: null;
$hubungan		=$_POST['hubungan'] ?: null;
$usaha			=$_POST['usaha'] ?: null;
$jenis_jaminan	=$_POST['jenis_jaminan'] ?: null;
$nomor_milik	=$_POST['nomor_milik'] ?: null;
$merk			=$_POST['merk'] ?: null;
$alamat_jaminan	=$_POST['alamat_jaminan'] ?: null;
$nilai_jaminan	=$_POST['nilai_jaminan'] ?: null;
$jaminan		="$jenis_jaminan,$nomor_milik,$merk,$alamat_jaminan,$nilai_jaminan";
$foto			=addslashes($_POST['foto']) ?: null;
$terdaftar		=date('Y-m-d') ?: null;
$status			="1" ?: null;
$petugas		=$_SESSION['id'] ?: null;
$online			="T" ?: null;
$lo				=date('Y-m-d H:i:s') ?: null;
$uname			=$_POST['uname'] ?: null;
$pass			=$_POST['pass'] ?: null;

$nick			=$_POST['nick'] ?: null;
$agama			=$_POST['agama'] ?: null;
$pernikahan			=$_POST['pernikahan'] ?: null;
$pendidikan			=$_POST['pendidikan'] ?: null;
$npwp			=$_POST['npwp'] ?: null;
$penghasilan			=$_POST['penghasilan'] ?: null;
$sumber			=$_POST['sumber'] ?: null;
$pengampu			=$_POST['pengampu'] ?: null;
$hubungan			=$_POST['hubungan'] ?: null;
$ibu			=$_POST['ibu'] ?: null;

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

$sql2 = mysql_query("SELECT *
				   FROM anggota_s_$_SESSION[kd_kab] 
				   WHERE nik='$nik'");
$row2	= mysql_num_rows($sql2);
if ($row2>0){ 
	$input2	= "UPDATE anggota_s_$_SESSION[kd_kab] SET 
	                    nick			= '$nick',
                        agama			= '$agama',
                        pernikahan		= '$pernikahan',
                        pendidikan		= '$pendidikan',
                        npwp			= '$npwp',
                        penghasilan		= '$penghasilan',
                        sumber			= '$sumber',
                        ibu				= '$ibu'
					WHERE nik=$nik";
	mysql_query($input2);								
}else{
	$input2 = "INSERT INTO `anggota_s_$_SESSION[kd_kab]`(`nik`, `nick`, `agama`, `pernikahan`, `pendidikan`, `npwp`, `penghasilan`, `sumber`, `ibu`) VALUES 
	 ('$nik', '$nick', '$agama', '$pernikahan', '$pendidikan', '$npwp', '$penghasilan', '$sumber', '$ibu')
	";
	mysql_query($input2);
}
?>