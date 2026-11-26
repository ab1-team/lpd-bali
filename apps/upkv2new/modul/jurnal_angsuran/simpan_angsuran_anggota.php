<?php session_start();
include "../../inc/inc.koneksi.php";

$idp		=$_POST['idp'];
$pokoka		=$_POST['pokoka'];
$jasaa		=$_POST['jasaa'];
$lu			=date('Y-m-d H:i:s');

$r=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$idp' "));

$kom_pokok	=$r['kom_pokok']+$pokoka;
$kom_jasa	=$r['kom_jasa']+$jasaa;

$input	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET kom_pokok	='$kom_pokok',
														 kom_jasa	='$kom_jasa',
														 lu			='$lu'
					WHERE id= '$idp'";
	mysql_query($input);

?>