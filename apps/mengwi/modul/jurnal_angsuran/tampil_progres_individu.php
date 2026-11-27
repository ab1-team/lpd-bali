<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";


$row=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.id= '$_SESSION[id_pinj]' "));
	
$alokasi		=$row['alokasi'];
$sumpokok=sumpokok(date('Y-m-d')."-$row[id]");
$proskembali=floor(@($sumpokok/$alokasi*100));
											
		echo "
		<br>
			<small>Progres pengembalian:</small>		
			<div class='progress progress-striped active'>
                                    <div class='progress-bar progress-bar-success fw-semi-bold' style='width: $proskembali%;'>
                                        $proskembali %
                                    </div>
                                </div>
			
			";
		

 ?>
 
 