<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_laporan = $_POST['cari'];

if($jenis_laporan==3) {

$view=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
		echo "<option value=''>-- Pilih Sub Laporan SAK--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='BB-$row[kd_jb]'>$row[nama_jb]</option>";
					}

}else if($jenis_laporan==4) {
	
	$view=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
			echo "<option value=''>-- Pilih Sub Laporan PTO--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='BS-$row[kd_jb]'>$row[nama_jb]</option>";
					}
	
}else if($jenis_laporan==5) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0'  ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman SPP--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-1'>$row[nama_laporan] (SPP)</option>";
					}
	
}else if($jenis_laporan==6) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0'  ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman UEP--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-2'>$row[nama_laporan] (UEP)</option>";
					}
	
}else if($jenis_laporan==7) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0'  ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman Lainnya--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-3'>$row[nama_laporan] (PL)</option>";
					}
					
}else if($jenis_laporan==9) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0'  ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman DKU--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-4'>$row[nama_laporan] (DKU)</option>";
					}
	
}else if($jenis_laporan==10) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0'  ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman DSPP--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-5'>$row[nama_laporan] (DSPP)</option>";
					}
	
}else if($jenis_laporan==8) {
	
	$view=mysql_query("select * from jenis_buku WHERE id='10' or id='11' or id='12' ");
			echo "<option value=''>-- Pilih Sub Laporan Inventory--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='IN-$row[id]'>$row[nama_jb]</option>";
					}
	
} else {
	
	echo "<option value=''>-- Silahkan klik Tombol Format Pelaporan --</option>";
}

?>
