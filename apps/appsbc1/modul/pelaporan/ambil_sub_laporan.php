<?php session_start();
include "../../inc/inc.koneksi.php";


$jenis_laporan = $_POST['file'];
$y = $_POST['y'];
$m = $_POST['m'];
$d = $_POST['d'];
?>

<span class="pull-right">
	<img src="images/buku.gif" width="185px" style="margin-top:-30px;"/>
</span>
<form method="POST" target='_blank' action='modul/pelaporan/p/report_view.php'>
	<input type="hidden" id="y"  name="y" value="<?php echo $y?>" />
	<input type="hidden" id="m"  name="m" value="<?php echo $m?>" />
	<input type="hidden" id="d"  name="d" value="<?php echo $d?>" />
	<input type="hidden" id="report"  name="report" value="<?php echo $jenis_laporan?>" />

<?php

if($jenis_laporan==2) {
	
$view=mysql_query("select * from jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' ORDER by u.level, u.jabatan ASC ");
		echo "Silahkan Pilih Nama Penanggung Jawab Transaksi<br><br>";
				echo "<ol>";
					while($row=mysql_fetch_array($view)){
						echo "<li><button type=submit name=sub_report value=TU-$row[id]>".$row['namadepan'].". ".$row['namabelakang']." (".$row['nama_jabatan'].")</button></li>";
					}
				echo "</ol>";
	
}else if($jenis_laporan==3) {
	
$view=mysql_query("select * from rekening_$_SESSION[lokasi] ORDER by kd_rekening ASC ");
		echo "Silahkan Pilih Buku Besar yang akan anda cetak<br><br>";
				echo "<ol>";
					while($row=mysql_fetch_array($view)){
						echo "<li><button type=submit name=sub_report value=BB-$row[kd_rekening]>".$row['kd_rekening'].". ".$row['nama_rekening']."</button></li>";
					}
				echo "</ol>";
	
}else if($jenis_laporan==4) {
	
	$view=mysql_query("select * from jenis_simpanan ");
			echo "Silahkan Pilih Laporan Simpanan yang akan anda cetak<br><br>";
				echo "<ol>";
					while($row=mysql_fetch_array($view)){
						echo "<li><button type=submit name=sub_report value=$row[file]>".$row['nama_js']."</button></li>";
					}
				echo "</ol>";
				
}else if($jenis_laporan==5) {
	
	$view=mysql_query("select * from jenis_laporan_pinjaman ");
			echo "Silahkan Pilih Laporan Pinjaman yang akan anda cetak<br><br>";
				echo "<ol>";
					while($row=mysql_fetch_array($view)){
						echo "<li><button type=submit name=sub_report value=$row[file]>".$row['nama_laporan']."</button></li>";
					}
				echo "</ol>";
	
}else if($jenis_laporan==6) {
	
	$view=mysql_query("select * from rekening_$_SESSION[lokasi] WHERE jenis_akun='inventory' ");
			echo "Silahkan Pilih Laporan Inventory yang akan anda cetak<br><br>";
				echo "<ol>";
					while($row=mysql_fetch_array($view)){
						echo "<li><button type=submit name=sub_report value=IN-$row[id]>".$row['nama_rekening']."</button></li>";
					}
				echo "</ol>";
	
}else {
	
	echo "-- Silahkan Pilih Pelaporan --";
}

?>

</form>
