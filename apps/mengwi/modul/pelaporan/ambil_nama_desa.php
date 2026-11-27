<?php session_start();
include "../../inc/inc.koneksi.php";

$sub_laporan = $_GET['sub_report'];
$lokasi		 = $_SESSION['lokasi'];
if(substr($sub_laporan,0,2)=='DS') {	
echo "<label class='fs-sm'>Nama Desa</label>
<select  id='pilih_desa' name='pilih_desa' data-placeholder='-- Pilh Sub Laporan --'
							data-width='auto'
							data-minimum-results-for-search='10'
							tabindex='-1'
							class='select2 form-control'>";
	$view=mysql_query("select * from desa d, kecamatan k WHERE d.kd_kec=k.kd_kec AND k.id='$lokasi'");
			echo "<option value=''>--- Pilih desa ---</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[kd_desa]'>$row[nama_desa]</option>";
					}
	
}

?>