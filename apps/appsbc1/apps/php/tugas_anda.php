<?php session_start();
include "../../inc/inc.koneksi.php";

$level		=$_SESSION['level'];
$jabatan	=$_SESSION['jabatan'];
$levjab		="$level.$jabatan";

if($levjab=="1.4") {$statuse="P";}elseif($levjab=="1.1") {$statuse="V1";}elseif($level=="3") {$statuse="V2";}elseif($levjab=="1.2") {$statuse="V3";}elseif($levjab=="1.3") {$statuse="W";}

	
	$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.status='$statuse' AND pa.lokasi='$_SESSION[lokasi]' ");
	$desa=mysql_fetch_array(mysql_query("select * from desa WHERE id='$_SESSION[lokasi]' "));
	

echo '<div class="card-body double-slider text-center owl-carousel owl-no-dots">';
	
	$ketemu	=mysql_num_rows($data);
	
if ($ketemu > 0){
	  	while($tr=mysql_fetch_array($data)) {
		
	echo '
	
	
				<a href="#" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-mint-dark shadow-l bg-white col-12">
					<h5 class="font-16 font-500">Proposal 1</h5>
				</a>
			
	';
	
		}
	
	
echo '</div>';
	
}else{
	
	echo "<p class='text-center color-gray2-dark mt-3'>-- Anda tidak memiliki tugas --</p>";
	
}

?>