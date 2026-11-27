<?php
include "../../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$uname		= anti_injection($_POST['uname']);
$pass		= anti_injection($_POST['pass']);
$ip     	= $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
$url		= $_SERVER['HTTP_HOST'];
if (!ctype_alnum($uname) OR !ctype_alnum($pass)){
?>
<script>
	alert('Cek Uname dan Passwornya!');
	window.location.href = '/'
</script>
<?php
}else{
	$login_kab	=mysql_query("SELECT * FROM kabupaten WHERE uname='$uname' AND pass='$pass'");
	//$login_users	=mysql_query("SELECT * FROM kabupaten WHERE web_kab='$url' AND uname='$uname' AND pass='$pass' OR 
	//															web_kab_alternatif='$url' AND uname='$uname' AND pass='$pass'  ");
	$ketemu_kab	=mysql_num_rows($login_kab);
	
	//$login_users	=mysql_query("SELECT * FROM users WHERE uname='$uname' AND pass='$pass'");
	$login_users	=mysql_query("SELECT * FROM kecamatan c, users u WHERE c.id=u.lokasi AND c.web_kec='$url' AND u.uname='$uname' AND u.pass='$pass' OR 
																			c.id=u.lokasi AND c.web_alternatif='$url' AND u.uname='$uname' AND u.pass='$pass'  ");
	$ketemu_users	=mysql_num_rows($login_users);
	
	//$login_desa	=mysql_query("SELECT * FROM desa WHERE uname='$uname' AND pass='$pass'");
	$login_desa	=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.web_kec='$url' AND d.uname='$uname' AND d.pass='$pass' OR 
																	  c.kd_kec=d.kd_kec AND c.web_alternatif='$url' AND d.uname='$uname' AND d.pass='$pass'  ");
	$ketemu_desa	=mysql_num_rows($login_desa);
	
	//$login_camat	=mysql_query("SELECT * FROM kecamatan WHERE uname='$uname' AND pass='$pass'");
	$login_camat	=mysql_query("SELECT * FROM kecamatan WHERE web_kec='$url' AND uname='$uname' AND pass='$pass' OR 
																web_alternatif='$url' AND uname='$uname' AND pass='$pass'  ");
	$ketemu_camat	=mysql_num_rows($login_camat);
	
	$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE web_kec='$url' OR web_alternatif='$url' "));
	$id_kec	=$kec['id'];
	$kd_kab	=$kec['kd_kab'];
	$login_kelompok	=mysql_query("SELECT * FROM kelompok_$kd_kab WHERE lokasi='$id_kec' AND uname='$uname' AND pass='$pass'");

	$ketemu_kelompok =mysql_num_rows($login_kelompok);
	
	
	if ($ketemu_users > 0){
		session_start();
	  	$r = mysql_fetch_array($login_users);
		$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id='$r[lokasi]' "));
		$_SESSION['kd_kab']=$kec['kd_kab'];
		$_SESSION['nama_lembaga_sort']=$kec['nama_lembaga_sort'];
		$_SESSION['unit']=$kec['nama_kec'];
		$_SESSION['unt']=$r['unit'];
		$_SESSION['hak_akses']=$r['hak_akses'];
		$_SESSION['alamat_kec']=$kec['alamat_kec'];
		$_SESSION['id']=$r['id']; 
		$_SESSION['uname']=$r['uname'];
		$_SESSION['pass']   	= $r['pass'];
		$_SESSION['lokasi']  		= $r['lokasi'];
		$_SESSION['namadepan']   = $r['namadepan'];
		$_SESSION['namabelakang']   = $r['namabelakang'];
		$_SESSION['jk']   = $r['jk'];
		$_SESSION['hp']   = $r['hp'];
		$_SESSION['foto']   = $r['foto'];
		$_SESSION['level']   = $r['level'];
		$_SESSION['jabatan']   = $r['jabatan'];
		$_SESSION['leveluser']="admin";
		$kunj   = $r['kunjungan'];
		$kunjung=$kunj+1;
		$tanggal = date("Y-m-d H:i:s");
		mysql_query("UPDATE users SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
			if($r['level']==1){
				header('location:../../main.php'); //Home 
			}else{
				header('location:../../2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=1'); //Home ?p=1
			}
			
	}else if ($ketemu_kab > 0){
		session_start();
	  	$r = mysql_fetch_array($login_kab);
		$_SESSION['kd_kab']=$r['id'];
		$_SESSION['nama_kab']=$r['nama_kab'];
		$_SESSION['nama_lembaga']=$r['nama_lembaga'];
		$_SESSION['alamat_kab']=$r['alamat_kab'];
		$_SESSION['id']=$r['id']; 
		$_SESSION['uname']=$r['uname'];
		$_SESSION['pass']   	= $r['pass'];
		$_SESSION['level']   = "kab";
		$kunj   = $r['kunjungan'];
		$kunjung=$kunj+1;
		$tanggal = date("Y-m-d H:i:s");
		mysql_query("UPDATE kabupaten SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
		header('location:../../k.php?p=1'); //Home
	
	    
	}else if ($ketemu_camat > 0){
		session_start();
	  	$r = mysql_fetch_array($login_camat);
		$kec=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id='$r[id]' "));
		$_SESSION['kd_kab']=$kec['kd_kab'];
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
		
	}else if ($ketemu_desa > 0){
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
	}else if ($ketemu_kelompok > 0){
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
	}else{
	?>
    <script>
		alert('Username dan Password tidak dikenal!');
		window.location.href='../../index.php';
	</script>
    <?php
	}
}
?>
