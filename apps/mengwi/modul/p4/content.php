<?php
include "inc/inc.koneksi.php";
$mod = $_GET['p'];


//p4
if ($mod=='p4_home'){
    include "p4/home.php";
}


elseif ($mod=='register_penduduk'){
			include "modul/penduduk/register_penduduk.php";
			}
			
elseif ($mod=='proposal'){
			include "modul/p4/proposal_p4.php";
			}


elseif ($mod=='x'){
    echo"
		<div class='alert alert-danger mt animated fadeInDown h4'>
			Maaf, masih dalam pengembangan!
		</div>
		";
}

else{
echo "<h2>Maaf, halaman belum tersedia! </h2>";
}
?>