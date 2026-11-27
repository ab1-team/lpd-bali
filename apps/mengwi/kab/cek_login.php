<?php
include "../inc/inc.koneksi.php";
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
</script>
<?php
}else{
	
	$login_kab	=mysql_query("SELECT * FROM kabupaten WHERE uname='$uname' AND pass='$pass'");
	//$login_users	=mysql_query("SELECT * FROM kabupaten WHERE web_kab='$url' AND uname='$uname' AND pass='$pass' OR 
	//															web_kab_alternatif='$url' AND uname='$uname' AND pass='$pass'  ");
	$ketemu_kab	=mysql_num_rows($login_kab);
	
	
	if ($ketemu_kab > 0){
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
		//header('location:m.php?p=1'); //Home
	}else{
	?>
    <script>
		window.location.href='kab/index.php?st=3';
	</script>
    <?php
	}
}
?>
