<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
$tp=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten WHERE id='$_GET[idb]' "));
$_SESSION['lokasi']="0"; //untuk membuat bahwa ini bukan level kecamatan
$_SESSION['idb']=$_GET['idb']; 
$_SESSION['kd_kab']=$_GET['idb']; 
?> 
		
<div class="animated fadeInDown" style="min-height:500px;">
	<div class="col-sm-3">
		<span class="ml-lg"><img src="images/<?php echo "$tp[id]"; ?>.jpg" class="mt-lg" width="187"></span>
			<div class="alert alert-danger animated fadeInDown fs-mini">
			<legend class="mb-0 text-danger"><i class="glyphicon glyphicon-print"></i> Cetak !</legend>
			<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/BAMigrasi_Kab.php?idk=<?php echo $_GET['idb'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" >
				Cetak Berita Acara Migrasi Kabupaten
			</a>
			
			</div>
	</div>
	<div class="col-sm-9">
		<h3 class="mb-lg">
			<i class="fa fa-bar-chart-o"></i> Halaman Sistem Pelaporan<br>
			Rekapitulasi Kabupaten <?php echo "$tp[nama_kab]"; ?><br>
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
						if(cari==3 || cari==4 || cari==5 || cari==6 || cari==7 || cari==8 || cari==9 || cari==10){
						
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/ambil_sub_laporan_kab.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#sub_laporan").html(data);
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
						
						$.ajax({
							type	: "POST",
							url		: "modul/pelaporan/ambil_sub_laporan_kab.php",
							data	: "cari="+cari+
									  "&tanggal="+tanggal+
									  "&bulan="+bulan+
									  "&tahun="+tahun,
							success	: function(data){
								$("#sub_laporan").html(data);
							}
						});
							}
					
					}
					
					
					
					$("#sub_laporan").click(function(){
						var cari = $("#sub_laporan").val();
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
							data-placeholder="-- Pilih Jenis Laporan --"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
							<option value=""></option>
							<?php 
							$view=mysql_query("select * from jenis_laporan where file_kab!='0' ORDER BY urut"); //Jenis Laporan
							while($row=mysql_fetch_array($view)){
							echo "<option value='$row[file_kab]'>$row[nama_laporan]</option>";
							} ?>
							</select>
						</div>
						
						<label class="fs-sm">Nama Sub Laporan</label>
						<div class="form-group">
							<select  id="sub_laporan" name="sub_laporan" data-placeholder="-- Pilh Sub Laporan --"
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