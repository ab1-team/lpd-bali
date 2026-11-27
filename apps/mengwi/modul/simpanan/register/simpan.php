<?php session_start();
include "../../../inc/inc.koneksi.php";
$table	= "anggota_$_SESSION[kd_kab]";

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
$jenis_jaminan	=$_POST['jenis_jaminan'];
$nomor_milik	=$_POST['nomor_milik'];
$merk			=$_POST['merk'];
$alamat_jaminan	=$_POST['alamat_jaminan'];
$nilai_jaminan	=$_POST['nilai_jaminan'];
$jaminan		="$jenis_jaminan,$nomor_milik,$merk,$alamat_jaminan,$nilai_jaminan";
$foto			=addslashes($_POST['foto']);
$terdaftar		=date('Y-m-d');
$status			="1";
$petugas		=$_SESSION['id'];
$online			="T";
$lo				=date('Y-m-d H:i:s');
$uname			=$_POST['uname'];
$pass			=$_POST['pass'];

$nick			=$_POST['nick'];
$agama			=$_POST['agama'];
$pernikahan			=$_POST['pernikahan'];
$pendidikan			=$_POST['pendidikan'];
$npwp			=$_POST['npwp'];
$penghasilan			=$_POST['penghasilan'];
$sumber			=$_POST['sumber'];
$pengampu			=$_POST['pengampu'];
$hubungan			=$_POST['hubungan'];
$ibu			=$_POST['ibu'];

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