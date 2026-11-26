<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

$y	= $_POST['y'];
$m	= $_POST['m'];
$d	= $_POST['d'];

$tgl	= "$y-$m-$d";

if ($d = $d) {
	$laporan = "Harian";
	$jenis = "Tanggal";
	$tgl_kondisi = "$y-$m-$d";
} else if ($m = $m) {
	$laporan = "Bulanan";
	$jenis = "Bulan";
	$tgl_kondisi = "$y-$m";
} else if ($y = $y) {
	$laporan = "Tahunan";
	$jenis = "Tahun";
	$tgl_kondisi = "$y";
} else {
	$laporan = "Global";
}
?>


<div class="row">
	<div class="col-md-4 p-0">

	<ol>
		<?php

		$view = mysqli_query($koneksi, "select * from jenis_laporan WHERE file != '0' ORDER BY urut"); //Jenis Laporan
		while ($row = mysqli_fetch_array($view)) {
            // if ($row['id'] == '30' && $_SESSION['lokasi'] != '1') continue;
			$file	= $row['file'];

			if ($file == 2 or $file == 3 or $file == 4 or $file == 5 or $file == 6 or $file == 7 or $file == 20 or $file == 9 or $file == 11 or $file == 12 or $file == 13  or $file == 14) {
		?>

				<script type="text/javascript">
					function MM_openBrWindow(theURL, winName, features) { //membuka window untuk print
						window.open(theURL, winName, features);
					}

					$(document).ready(function() {

						$("#SubLaporan<?php echo $file; ?>").click(function() {
							var y = $("#y").val();
							var m = $("#m").val();
							var d = $("#d").val();
							var file = $("#file<?php echo $file; ?>").val();

							$.ajax({
								type: "POST",
								url: "modul/pelaporan/ambil_sub_laporan.php",
								data: "y=" + y +
									"&m=" + m +
									"&d=" + d +
									"&file=" + file,

								success: function(data) {
									$("#TampilSubLaporan").html(data);
								}
							});

						});

					});
				</script>

				<input type="hidden" id="y" name="y" value="<?php echo $y ?>" />
				<input type="hidden" id="m" name="m" value="<?php echo $m ?>" />
				<input type="hidden" id="d" name="d" value="<?php echo $d ?>" />

				<input type="hidden" id="file<?php echo $file; ?>" name="file<?php echo $file; ?>" value="<?php echo $file ?>" />

				<li><button id="SubLaporan<?php echo $file; ?>" class="btn btn-outline-primary m-b-5"><?php echo $row['nama_laporan']; ?></button></li>

			<?php
			} else {
			 //   if ($_SESSION['lokasi'] != '1') {
			 //       if ($row['urut'] == 12) continue;
			 //   }
			?>
				<form method="POST" target='_blank' action='modul/pelaporan/p/report_view.php'>
					<input type="hidden" id="y" name="y" value="<?php echo $y ?>" />
					<input type="hidden" id="m" name="m" value="<?php echo $m ?>" />
					<input type="hidden" id="d" name="d" value="<?php echo $d ?>" />
					<input type="hidden" id="report" name="report" value="<?php echo $file ?>" />
					<li><button type="submit" class="btn btn-outline-primary m-b-5"><?php echo $row['nama_laporan']; ?></button></li>
				</form>
		<?php
			}
		}
		?>

	</ol>
	</div>
	<div class="col-md-8 p-0">
		<div class="alert alert-light inverse alert-success shake show" role="alert"><i class="icon-check txt-success"></i>
			<?php echo "<b>Generate Laporan $jenis " . tgl_indo($tgl_kondisi) . " Berhasil,</b>"; ?>
			<div id="TampilSubLaporan"></div>
		</div>
	</div>
</div>