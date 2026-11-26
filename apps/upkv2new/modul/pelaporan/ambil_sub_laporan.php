<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

$jenis_laporan = $_POST['file'];
$y = $_POST['y'];
$m = $_POST['m'];
$d = $_POST['d'];
?>

<form method="POST" target='_blank' action='modul/pelaporan/p/report_view.php'>
	<input type="hidden" id="y" name="y" value="<?php echo $y ?>" />
	<input type="hidden" id="m" name="m" value="<?php echo $m ?>" />
	<input type="hidden" id="d" name="d" value="<?php echo $d ?>" />
	<input type="hidden" id="report" name="report" value="<?php echo $jenis_laporan ?>" />

	<?php

	if ($jenis_laporan == 2) {

		$view = mysqli_query($koneksi, "select * from jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' ORDER by u.level, u.jabatan ASC ");
		echo "Silahkan Pilih Nama Penanggung Jawab Transaksi<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='TU-$row[id]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['namadepan'] . ". " . $row['namabelakang'] . " (" . $row['nama_jabatan'] . ")</button></li>";
		}
		echo "</ol>";
	} else if ($jenis_laporan == 3) {

		$view = mysqli_query($koneksi, "select * from rekening_$_SESSION[lokasi] ORDER by kode_akun ASC ");
		echo "Silahkan Pilih Buku Besar yang akan anda cetak<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='BB-$row[kode_akun]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['kode_akun'] . ". " . $row['nama_akun'] . "</button></li>";
		}
		echo "</ol>";
	} else if ($jenis_laporan == 4) {

	
		$view = mysqli_query($koneksi, "select * from rekening_$_SESSION[lokasi] WHERE lev1=1 OR lev1=2 OR lev1=3 OR (lev1=4 AND lev2<2) ORDER by kode_akun ASC ");
		if (mysqli_num_rows(mysqli_query($koneksi, "select * from rekening_$_SESSION[lokasi] WHERE kode_akun LIKE '%.%'")) > 0) {
			$view2 = mysqli_query($koneksi, "select * from akn_level_3 WHERE lev1=5 OR (lev1=4 AND lev2>=2) ORDER by kode_akun ASC ");
		} else {
			$view2 = mysqli_query($koneksi, "select * from akun_level_3 WHERE lev1=4 OR lev1=5 ORDER by kode_akun ASC ");
		}
		echo "Silahkan Pilih Buku Kas, Bank, dll yang akan anda cetak<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='BS-$row[kode_akun]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['kode_akun'] . ". " . $row['nama_akun'] . "</button></li>";
		}
		while ($row = mysqli_fetch_array($view2)) {
			echo "<li><button type='submit' name='sub_report' value='BS-$row[kode_akun]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['kode_akun'] . ". " . $row['nama_akun'] . "</button></li>";
		}
		echo "</ol>";
	} else if ($jenis_laporan == 5) {

		$view = mysqli_query($koneksi, "select * from jenis_laporan_pinjaman WHERE file!='0'");
		echo "Silahkan Pilih Laporan Pinjaman yang akan anda cetak<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='$row[file]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['nama_laporan'] . "</button></li>";
		}
		echo "</ol>";
	} else if ($jenis_laporan == 6) {

		$view = mysqli_query($koneksi, "select * from rekening_$_SESSION[lokasi] WHERE jenis_akun='inventory' ");
		echo "Silahkan Pilih Laporan Inventory yang akan anda cetak<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='IN-$row[id]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['nama_akun'] . "</button></li>";
		}
		echo "</ol>";
	} else if ($jenis_laporan == 20) {

		$view = mysqli_query($koneksi, "select * from sub_laporan WHERE 1 ORDER by urut ASC, id ASC");
		echo "Silahkan Pilih Laporan Inventory yang akan anda cetak<br><br>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='$row[file]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['nama_laporan'] . "</button></li>";
		}
		echo "</ol>";
	}   else if($jenis_laporan== 8 ) {
	
	$view=mysql_query("select * from jenis_buku WHERE id='10' or id='11' or id='12' ");
			echo "<option value=''>-- Pilih Sub Laporan Inventory--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='IN-$row[id]'>$row[nama_jb]</option>";
					}
}else if ($jenis_laporan == 9) {

		$view=mysql_query($koneksi, "select * from jenis_laporan_pinjaman WHERE 1 ORDER by urut ASC, id ASC");
        echo "<option value=''>-- Pilih Sub Laporan Pinjaman DKU--</option>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='IN-$row[id]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['nama_laporan'] . "</button></li>";
		}
		echo "</ol>";
		
	 }else if($jenis_laporan==11) {
	
	$view=mysql_query($koneksi, "select * from jenis_laporan_pinjaman WHERE 1 ORDER by urut ASC, id ASC");
        echo "<option value=''>-- Pilih Sub Laporan Pinjaman DKU--</option>";
		echo "<ol>";
		while ($row = mysqli_fetch_array($view)) {
			echo "<li><button type='submit' name='sub_report' value='IN-$row[id]' class='btn btn-outline-danger m-b-5 btn-sm'>" . $row['nama_laporan'] . "</button></li>";
		}
		echo "</ol>";
		
}
else if($jenis_laporan==12) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Pilih Sub Laporan Pinjaman PKKPM--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-7'>$row[nama_laporan] (PKKPM)</option>";
					}
}else if($jenis_laporan==13) {
	
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman Kredit Barang--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-13'>$row[nama_laporan] (KB)</option>";
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
}else if($jenis_laporan==19) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER BY urut ASC ");
			echo "<option value=''>-- Perkembangan Pinjaman SPP Mikro--</option>";
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file]-14'>$row[nama_laporan] (SPP Mikro)</option>";
					}
}else {

		echo "-- Silahkan Pilih Pelaporan --";
	}

	?>

</form>