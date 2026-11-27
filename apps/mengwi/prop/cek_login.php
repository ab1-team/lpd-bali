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
	
	// $login_prop	=mysql_query("SELECT * FROM propinsi WHERE uname='$uname' AND pass='$pass'");
	$login_prop	=mysql_query("SELECT * FROM propinsi WHERE web_prop='$url' AND uname='$uname' AND pass='$pass' OR 
																web_prop_alternatif='$url' AND uname='$uname' AND pass='$pass'  ");
	$ketemu_prop	=mysql_num_rows($login_prop);
	
	
	if ($ketemu_prop > 0){
		session_start();
	  	$r = mysql_fetch_array($login_prop);
		$_SESSION['kd_prop']=$r['id'];
		$_SESSION['nama_prop']=$r['nama_prop'];
		$_SESSION['nama_lembaga']=$r['nama_lembaga'];
		$_SESSION['alamat_prop']=$r['alamat_prop'];
		$_SESSION['id']=$r['id']; 
		$_SESSION['uname']=$r['uname'];
		$_SESSION['pass']   	= $r['pass'];
		$_SESSION['level']   = "prop";
		$kunj   = $r['kunjungan'];
		$kunjung=$kunj+1;
		$tanggal = date("Y-m-d H:i:s");
		mysql_query("UPDATE propinsi SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
		//header('location:m.php?p=1'); //Home
	}else{
	?>
    <script>
		window.location.href='prop/index.php?st=3';
	</script>
    <?php
	}
}
?>
