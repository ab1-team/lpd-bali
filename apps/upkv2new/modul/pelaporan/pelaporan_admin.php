<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";

?> 
		
<div class="alert alert-primary animated fadeInDown" style="min-height:500px;">
<legend class="text-align-center h2 mb-lg">
			PT. Asta Brata Teknologi<br>
			Sistem Pelaporan Manajemen Perusahaan<br>
		</legend>
	<div class="col-sm-3">
		<span class="ml-lg mt-lg"><img src="images/abt.png" class="mt-lg" width="187"></span>
	</div>
	<div class="col-sm-9">
		
				
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
						if(cari==3 || cari==4 || cari==5 || cari==6 || cari==7){
						
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/ambil_sub_laporan_admin.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#sub_laporan_admin").html(data);
							}
						});
							}else{ 
						
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/tombol.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#Tombol").html(data);
							}
						});
						
						
							}
					
					}
					
					
					
					$("#sub_laporan_admin").click(function(){
						var cari = $("#sub_laporan_admin").val();
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
								$("#Tombol").html(data);
							}
						});

					})
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
							
							$th=date('Y');
							for($t=2014;$t<=$th;$t++) 
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
							data-placeholder="-- Pilih Jenis Laporan --"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
							<option value=""></option>
							<?php 
							$view=mysql_query("select * from jenis_laporan WHERE file_admin!='0' "); //Jenis Laporan
							while($row=mysql_fetch_array($view)){
							echo "<option value='$row[file_admin]'>$row[nama_laporan]</option>";
							} ?>
							</select>
						</div>
						
						<label class="fs-sm">Nama Sub Laporan</label>
						<div class="form-group">
							<select  id="sub_laporan_admin" name="sub_laporan_admin" data-placeholder="-- Pilh Sub Laporan --"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
								<option value=""></option>
							</select>
						</div>

						
				</div>
				<div class="col-sm-3">
					<div id="Tombol"></div>
				</div>
	</div>
</div>