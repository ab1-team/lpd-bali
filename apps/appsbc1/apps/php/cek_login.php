<?php
include "../../inc/inc.koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
$nomorhp	= anti_injection($_POST['nomorhp']);
$pin		= anti_injection($_POST['pin']);
$ip     	= $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
$url		= $_SERVER['HTTP_HOST'];

	
	$login	=mysql_query("SELECT * FROM users WHERE hp='$nomorhp' AND pass='$pin'");
	$ketemu	=mysql_num_rows($login);
	
	if ($ketemu > 0){
		session_start();
	  	$r = mysql_fetch_array($login);
		$_SESSION['id']	=$r['id'];
		$_SESSION['lokasi']	=$r['lokasi'];
		$_SESSION['level']	=$r['level'];
		$_SESSION['jabatan']	=$r['jabatan'];
		$_SESSION['kd_kab']	="1";
		$tanggal = date("Y-m-d H:i:s");
		mysql_query("UPDATE users SET online='Y',lo='$tanggal',ip='$ip' WHERE id = '$_SESSION[id]'");
	echo '
	<h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle color-green1-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700"> Berhasil</div></h1>
        <p class="boxed-text-l">
             Silahkan klik tombol dibawah ini untuk melanjutkan
        </p>
        <a href="index_home.php" class="btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green1-light">Lanjut</a>
	';

}else{
	echo '
	<h1 class="text-center mt-4"><i class="fa fa-3x fa-fa-times color-red2-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700"> Gagal</div></h1>
        <p class="boxed-text-l">
             Silahkan periksa kembali Nomor HP dan PIN anda
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-red1-light">Ok</a>
	';
	
}
?>