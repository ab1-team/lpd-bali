<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$jenis_laporan	= $_POST['cari'];

if($jenis_laporan=="5") {
	$idf="1";
	$jpp="SPP";
}else{
	$idf="2";
	$jpp="UEP";
}

$_SESSION['lokasi']="0"; //untuk membuat bahwa ini bukan level kecamatan
?>
<script type="text/javascript">
				
			$(document).ready(function() {
			
			//$("#JenisPembukuan").load('modul/pelaporan/double_entry.php');
				
				$("#jenis_laporan_pinjaman").click(function(){
						var cari = $("#jenis_laporan_pinjaman").val();
						var tanggal = $("#tanggal").val();
						var bulan = $("#bulan").val();
						var tahun = $("#tahun").val();
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/tombol_kab.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#Tombol").html(data);
							}
						});

					})
							
            });
</script>

<div class="form-group animated fadeInDown">
	<select  id="jenis_laporan_pinjaman" name="jenis_laporan_pinjaman" data-placeholder="jenis_laporan_pinjaman"
	data-width="auto"
	data-minimum-results-for-search="10"
	tabindex="-1"
	class="select2 form-control">
		<option value="">--Pilih Jenis Laporan--</option>
			<?php
			$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file_kab!='0' ");
					while($row=mysql_fetch_array($view)){
						echo "<option value='$row[file_kab]-$idf'>$row[nama_laporan] ($jpp)</option>";
					}
			?>
	</select>
</div>

<?php

?>