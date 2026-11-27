
application/x-httpd-php ambil_sub_laporan.php ( PHP script, ASCII text )
<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_laporan = $_GET['report'];


if($jenis_laporan==20) {

$view=mysql_query("select * from sub_laporan WHERE 1 ORDER by urut ASC, id ASC ");
		echo "<option value=''>-- Pilih Sub Laporan OJK --</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]'>$row[nama_laporan]</option>";
					}
}
else if($jenis_laporan==3) {

$view=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
		echo "<option value=''>-- Pilih Sub Laporan Form Standart Akuntansi --</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='BB-$row[kd_jb]'>$row[nama_jb]</option>";
					}

}else if($jenis_laporan==4) {
	
	$view=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Format PTO--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='BS-$row[kd_jb]'>$row[nama_jb]</option>";
					}
	
}else if($jenis_laporan==5) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman Umum--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-1'>$row[nama_laporan] (PU)</option>";
					}
}else if($jenis_laporan==11) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman P2B--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-6'>$row[nama_laporan] (P2B)</option>";
					}
}else if($jenis_laporan==12) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman PKKPM--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-7'>$row[nama_laporan] (PKKPM)</option>";
					}
}else if($jenis_laporan==14) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Individu Umum--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-9'>$row[nama_laporan] (IU)</option>";
					}
}else if($jenis_laporan==15) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Cash Tempo--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-10'>$row[nama_laporan] (CT)</option>";
					}
}else if($jenis_laporan==16) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Manunggal Motor--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-11'>$row[nama_laporan] (MM)</option>";
					}
}else if($jenis_laporan==17) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Manunggal Karya--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-12'>$row[nama_laporan] (MK)</option>";
					}	
}else if($jenis_laporan==18) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Kredit Barang--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-13'>$row[nama_laporan] (KB)</option>";
					}	
}else if($jenis_laporan==6) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman UEP--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-2'>$row[nama_laporan] (UEP)</option>";
					}
	
}else if($jenis_laporan==7) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman Lainnya--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-3'>$row[nama_laporan] (PL)</option>";
					}
					
}else if($jenis_laporan==9) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman DKU--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-4'>$row[nama_laporan] (DKU)</option>";
					}
	
}else if($jenis_laporan==10) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman DSPP--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-5'>$row[nama_laporan] (DSPP)</option>";
					}
	
}else if($jenis_laporan==8) {
	
	$view=mysql_query("select * from jenis_buku WHERE id='10' or id='11' or id='12' ");
			echo "<option value=''>-- Pilih Sub Laporan Inventory--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='IN-$row[id]'>$row[nama_jb]</option>";
					}
}else if(($jenis_laporan==13)) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman SPPro--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-8'>$row[nama_laporan] (SPPro)</option>";
					}	
} else {
	
	echo "<option value=''>-- Silahkan klik Tombol Format Pelaporan --</option>";
}

?>