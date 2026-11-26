<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";
	
	$tgl =date('d');
	$data=mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE lokasi='$_SESSION[lokasi]' order by namadepan asc");
	

	echo '<div class="search-results disabled-search-list bg-white">
			<div class="list-group list-custom-large">';
			
	  	while($tr=mysql_fetch_array($data)){
			
			$file="../../foto_anggota/$tr[id].png";
				if(file_exists($file)){
					$foto="../foto_anggota/$tr[id].png";
				}else{
					$foto="../img/avatar.png";
				}
		
	echo '
		<a href="anggota.php?nia='.$tr['id'].'" data-filter-item data-filter-name="'.$tr['nik'].' '.$tr['namadepan'].' '.$tr['hp'].'">
			<img src="'.$foto.'" width="50" class="ml-3 mr-2 bg-highlight rounded-xl">
			<span>'.$tr['namadepan'].'</span>
			<strong>'.$tr['alamat'].', '.$tr['hp'].'</strong>
			<i class="fa fa-angle-right mr-2"></i>
		</a>			
					
		
		
		 
	';
		}
		
	echo '</div>';
	echo '</div>';

?>


	 