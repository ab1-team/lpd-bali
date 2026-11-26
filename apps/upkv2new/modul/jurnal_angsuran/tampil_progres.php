<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";


$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE jpp.id=pk.jenis_pp AND sd.id=d.sebutan AND jj.id=pk.jenis_jasa AND sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' AND pk.id= '$_SESSION[id_pinj]' "));
	
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
 
 