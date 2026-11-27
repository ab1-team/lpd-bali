<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";

?> 
		
<div class="alert alert-info animated fadeInDown" style="min-height:500px;">
	<div class="col-sm-3">
		<span class="ml-lg"><img src="images/upe.png" class="mt-lg" width="187"></span>
			<div class="alert alert-danger animated fadeInDown fs-mini">
			<legend class="mb-0 text-danger"><i class="fa fa-warning"></i> Perhatian !</legend>
			Sebelum mencetak, pastikan setting margin kiri, atas, kanan, bawah pada browser dan pilih kertas Lanscape or Portrait pada propertis printer.
			<a href="modul/user_guides/Modul 2 - Settup Margin pada Mozzilla.pdf" target="_blank">Selengkapnya...</a>
			</div>
	</div>
	<div class="col-sm-9">
		<h3 class="mb-lg">
			<i class="fa fa-bar-chart-o"></i> <br>Halaman Sistem Pelaporan<br>
			Desa <?php echo "$_SESSION[nama_desa]"; ?><br>
			<span class="h5 mb-0">Silahkan pilih jenis Laporan yang Anda Butuhkan !</span>
		</h3>
				
<script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
			$(document).ready(function() {
			
			$("#Tombol").load('modul/pelaporan/tombol.php');
				
				
				$("#jenis_laporan").click(function(){
						var cari = $("#jenis_laporan").val();
						carijenis_laporan(cari);
					})
					function carijenis_laporan(e){
						var cari = e;
						var tanggal = $("#tanggal").val();
						var bulan = $("#bulan").val();
						var tahun = $("#tahun").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/tombol.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#JenisBuku").load('modul/pelaporan/form_blank.php');
								$("#Tombol").html(data);
							}
						});
							
					}
            });
        </script>  
		
				<div class="form-group">
					<div class="col-sm-2">
						<span><i class="glyphicon glyphicon-calendar"></i></span>
						<label class="fs-sm">Tahunan</label>
						<select id="tahun"  name="tahun"
						data-width="auto"
                        data-minimum-results-for-search="10"
                        tabindex="-1"
                        class="select2 form-control">
						<option value="">-</option>
						<?php
							$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
								$tgl_pakai		=$tp['tgl_pakai'];
								$th_pakai   	= substr($tgl_pakai,0,4);
							$th=date('Y');
							for($t=$th_pakai;$t<=$th;$t++) 
							{
							echo "<option selected value=$t>$t</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<span><i class="glyphicon glyphicon-calendar"></i></span>
						<label class="fs-sm">Bulanan</label>
						<select id="bulan"  name="bulan"
						data-width="auto"
                        data-minimum-results-for-search="10"
                        tabindex="-1"
                        class="select2 form-control">
							<option value="<?php $bln=date('m'); echo $bln;?>"><?php echo strtoupper(bln_indo(date('Y-m')));?></option>
							<option value="">-</option>
							<option value="01">JANUARI</option>
							<option value="02">FEBRUARI</option>
							<option value="03">MARET</option>
							<option value="04">APRIL</option>
							<option value="05">MEI</option>
							<option value="06">JUNI</option>
							<option value="07">JULI</option>
							<option value="08">AGUSTUS</option>
							<option value="09">SEPTEMBER</option>
							<option value="10">OKTOBER</option>
							<option value="11">NOVEMBER</option>
							<option value="12">DESEMBER</option>
						</select>
					</div>
					<div class="col-sm-2">
						<span><i class="glyphicon glyphicon-calendar"></i></span>
						<label class="fs-sm">Harian</label>
						<select id="tanggal"  name="tanggal"
						data-width="auto"
                        data-minimum-results-for-search="10"
                        tabindex="-1"
                        class="select2 form-control">
							<option value="">-</option>
							<?php
							for($tg=1;$tg<=31;$tg++) 
							{
							if($tg<=9){$tg="0$tg";}else{$tg=$tg;}
							echo "<option value=$tg>$tg</option>";
							}
							?>
						</select>
					</div>
				</div>
				<br><br><br><br><legend></legend>
					<div class="col-sm-6">
						<label class="fs-sm">Nama Laporan</label>
						<div class="form-group">
							<select id="jenis_laporan"  name="jenis_laporan"
							data-placeholder="Pilih Jenis Laporan"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
							<option value="Pilih Jenis Laporan">Pilih Jenis Laporan</option>
							<?php 
							$view=mysql_query("select * from jenis_laporan WHERE 
							id='6' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='6' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='7' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='7' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='14' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='14' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='15' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='15' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='17' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='17' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='18' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='18' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='19' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='19' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='20' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='20' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='21' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='21' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
							id='23' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
							id='23' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'
							"); //Jenis Laporan
							
							
							
							while($row=mysql_fetch_array($view)){
							    if ($row['id'] == 36) continue;
							echo "<option value='$row[file]'>$row[nama_laporan]</option>";
							} ?>
							</select>
						</div>
						<div id="JenisBuku"></div>
						
				</div>
				<div class="col-sm-2">
					<div id="Tombol"></div>
				</div>
	</div>
</div>