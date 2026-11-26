<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";
	
	$tgl =date('d');
	$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.lokasi='$_SESSION[lokasi]' AND substring(pa.tgl_cair,9,2)='$tgl' order by pa.id desc");
	

	$ketemu	=mysql_num_rows($data);
	
if ($ketemu > 0){
	  	while($tr=mysql_fetch_array($data)){
			
			$tgl_kondisi	=date('Y-m')."-31";
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$tr[id]"); //tunggakan menjadi tagihan
			$nunggakjasa	=nunggakjasa("$tgl_kondisi-$tr[id]");
			
			$file="../../foto_anggota/$tr[nia].png";
				if(file_exists($file)){
					$foto="../foto_anggota/$tr[nia].png";
				}else{
					$foto="../img/avatar.png";
				}
		
	echo '
					
		<div class="card card-style">
            <div class="content">
                <div class="d-flex">
                    <div>
                        <img src="'.$foto.'" width="50" class="mr-3 bg-highlight rounded-xl">
                    </div>
                    <div>
                        <p class="color-highlight mb-0 font-11">'.$tr['no_rekening'].'
							<span class="badge bg-green2-dark font-11 mt-1">P: '.number_format($nunggakpokok,0,',','.').'</span>
							<span class="badge bg-blue2-dark font-11">J: '.number_format($nunggakjasa,0,',','.').'</span>
						</p>
                        <p class="font-13 font-500 mt-n2 mb-0">'.$tr['namadepan'].'</p>
						<p class="mt-n2 mb-0 font-11">'.$tr['alamat'].' '.$tr['hp'].'</p>
                    </div>
                </div>
            </div>
        </div>
		
		 
	';
		}

}else{
	echo "<p class='text-center color-gray-dark'>TIDAK ADA DATA</p>";
	
}
?>


	 