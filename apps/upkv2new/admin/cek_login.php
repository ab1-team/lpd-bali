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
	
	$login_pus	=mysql_query("SELECT * FROM pusat WHERE uname='$uname' AND pass='$pass'");

	$ketemu_pus	=mysql_num_rows($login_pus);
	
	
	if ($ketemu_pus > 0){
		session_start();
	  	$r = mysql_fetch_array($login_pus);
		$_SESSION['id']=$r['id'];
		$_SESSION['namadepan']=$r['namadepan'];
		$_SESSION['namabelakang']=$r['namabelakang'];
		$_SESSION['telpon']=$r['telpon'];
		$_SESSION['email']=$r['email']; 
		$_SESSION['uname']=$r['uname'];
		$_SESSION['pass']   	= $r['pass'];
		$_SESSION['level']   = "pusat";
		$kunj   = $r['kunjungan'];
		$kunjung=$kunj+1;
		$tanggal = date("Y-m-d H:i:s");
		mysql_query("UPDATE pusat SET online='Y',lo='$tanggal',ip='$ip',kunjungan='$kunjung' WHERE id = '$_SESSION[id]'");
		//header('location:m.php?p=1'); //Home
	}else{
	?>
    <script>
		window.location.href='admin/index.php?st=3';
	</script>
    <?php
	}
}
?>
