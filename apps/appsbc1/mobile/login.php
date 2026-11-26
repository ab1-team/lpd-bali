<?php
include "../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$uname		= anti_injection($_POST['email']);
$pass		= anti_injection($_POST['password']);
$ip     	= null;//$_SERVER['REMOTE_ADDR']; 



//login User Biasa
$login_users=mysql_query("SELECT u.id,c.id as id_kecamatan,c.kd_kab,c.kd_kec FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.hp='".$uname."' AND u.pass='".$pass."'");
$ketemu_users=mysql_num_rows($login_users);

//$login_desa	=mysql_query("SELECT * FROM desa WHERE uname='$uname' AND pass='$pass'");
/*
$login_desa	=mysql_query("SELECT * FROM kecamatan c join desa d ON (c.kd_kec=d.kd_kec) WHERE u.uname='".$uname."' AND u.pass='".$pass."'");
$ketemu_desa =mysql_num_rows($login_desa);
*/
//$login_camat	=mysql_query("SELECT * FROM kecamatan WHERE uname='$uname' AND pass='$pass'");
$login_camat	=mysql_query("SELECT * FROM kecamatan WHERE uname='".$uname."' AND pass='".$pass."'");
$ketemu_camat	=mysql_num_rows($login_camat);

/*
$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE web_kec='$url' OR web_alternatif='$url' "));
$id_kec	=$kec['id'];
$kd_kab	=$kec['kd_kab'];
$login_kelompok	=mysql_query("SELECT * FROM kelompok_$kd_kab WHERE lokasi='$id_kec' AND uname='$uname' AND pass='$pass'");

$ketemu_kelompok =mysql_num_rows($login_kelompok);
	*/
if ($ketemu_users > 0) 
{
  	$r = mysql_fetch_array($login_users);
	
	/*
	$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id=".$r['id']));
	$data = array(
		'uname' => $r['uname'],
		'namadepan' => $r['namadepan'],
		'namabelakang' => $r['namabelakang'],
		'hp' => $r['hp'],
		'lokasi' => $kec['id'],
		'level' => $r['level'],
		'jabatan' => $r['jabatan'],
		'leveluser' => "admin",
		'nama_lembaga_sort' => $kec['nama_lembaga_sort'],
		'unit' => $kec['nama_kec'],
		'alamat' => $kec['alamat_kec']
	);

	$kunj   = $r['kunjungan'];
	$kunjung=$kunj+1;
	$tanggal = date("Y-m-d H:i:s");
	mysql_query("UPDATE users SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = ".$r['id']);

	die(json_encode($data));
	*/
	echo $r['id'];
	
} else if ($ketemu_camat > 0){
	session_start();
  	$r = mysql_fetch_array($login_camat);
	$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id='$r[id]' "));
	
	$_SESSION['nama_lembaga_sort']=$kec['nama_lembaga_sort'];
	$_SESSION['unit']=$kec['nama_kec'];
	$_SESSION['alamat_kec']=$kec['alamat_kec'];
	$_SESSION['id']=$r['id']; 
	$_SESSION['uname']=$r['uname'];
	$_SESSION['pass']   	= $r['pass'];
	$_SESSION['lokasi']  		= $r['id'];
	$_SESSION['namadepan']   = "Camat";
	$_SESSION['namabelakang']   = $r['nama_kec'];
	$_SESSION['level']	="camat";
	
		header('location:../../2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=1'); //Home
	
} else if ($ketemu_desa > 0){
	session_start();
  	$r = mysql_fetch_array($login_desa);
	$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE kd_kec='$r[kd_kec]' "));
	$_SESSION['kd_kab']=$kec['kd_kab'];
	$_SESSION['lokasi'] = $kec['id'];
	$_SESSION['id']		=$r['id'];
	$_SESSION['level']	="desa";
	$_SESSION['nama_desa']	=$r['nama_desa'];
	$_SESSION['kd_desa']	=$r['kd_desa'];
	$kunj   			= $r['kunjungan'];
	$kunjung			=$kunj+1;
	$tanggal 			= date("Y-m-d H:i:s");
	mysql_query("UPDATE desa SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
	header('location:../../d.php?p=1'); //Home
} else if ($ketemu_kelompok > 0){
	session_start();
  	$r = mysql_fetch_array($login_kelompok);
	$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id='$r[lokasi]' "));
	$_SESSION['kd_kab']	=$kec['kd_kab'];
	$_SESSION['lokasi'] = $kec['id'];
	$_SESSION['id']		=$r['id'];
	$_SESSION['level']	="group";
	$_SESSION['nama_kelompok']	=$r['nama_kelompok'];
	$_SESSION['alamat_kelompok']	=$r['alamat_kelompok'];
	$kunj   			= $r['kunjungan'];
	$kunjung			=$kunj+1;
	$tanggal 			= date("Y-m-d H:i:s");
	mysql_query("UPDATE kelompok_$kec[kd_kab] SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
	header('location:../../G.php?p=1'); //Home
} else {
	echo "failure";
}
?>
