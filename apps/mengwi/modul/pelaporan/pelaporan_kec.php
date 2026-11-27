<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
$tp=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c WHERE b.id=c.kd_kab AND c.id='$_GET[idc]' "));
$_SESSION['lokasi']=$_GET['idc'];
$_SESSION['kd_kab']=$tp['kd_kab'];
?> 
		
<div class="alert alert-info animated fadeInDown" style="min-height:500px;">
	<div class="col-sm-3">
		<span class="ml-lg"><img src="images/upe.png" class="mt-lg" width="187"></span>
			<div class="alert alert-success animated fadeInDown fs-mini">
			<legend class="mb-0 text-danger"><i class="fa fa-info"></i> Informasi !</legend>
			Halaman ini merupakan embed dari halaman resmi SIM Koperasi <?php echo "$tp[nama_kec]"; ?>
			<a href="https://<?php echo "$tp[web_alternatif]"; ?>" target="_blank"><?php echo "$tp[web_alternatif]"; ?></a> sehingga data yang disajikan merupakan data realtime.
			<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/BAMigrasi.php?idk=<?php echo $_GET['idc'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" >
				Cetak Berita Acara Migrasi
			</a>
			</div>
	</div>
	<div class="col-sm-9">
		<h3 class="mb-lg">
			<i class="fa fa-bar-chart-o"></i> <br>Halaman Sistem Pelaporan<br>
			<?php echo "$tp[nama_lembaga_long] $tp[nama_kec]"; ?><br>
			<span class="h5 mb-0">Silahkan pilih jenis Laporan yang Anda Butuhkan !</span>
		</h3>
				
<script type="text/javascript">

	<![CDATA[
var htmlobjek;

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}


$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=report>
  $("#report").change(function(){
    var report = $("#report").val();
    $.ajax({
        url: "modul/pelaporan/ambil_sub_laporan.php",
        data: "report="+report,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=jenis_buku>
            $("#sub_report").html(msg);
        }
    });
  });
  
  });




 ]]>
 </script>
		
		<form method="POST" target='_blank' action='modul/pelaporan/p/report_view.php'>
				<div class="form-group">
					<div class="col-sm-2">
						<span><i class="glyphicon glyphicon-calendar"></i></span>
						<label class="fs-sm">Tahunan</label>
						<select id="y"  name="y"
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
						<select id="m"  name="m"
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
						<select id="d"  name="d"
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
							<select id="report"  name="report"
							data-placeholder="-- Pilih Jenis Laporan --"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
							<option value=""></option>
							<?php 
							$kecuali = $_SESSION['kd_kab'] . '-' . $_SESSION['lokasi'];
							$view=mysql_query("select * from jenis_laporan WHERE kecuali NOT LIKE '%$kecuali%' AND lokasi='0' OR lokasi LIKE '%$kecuali%' ORDER BY urut"); //Jenis Laporan
							while($row=mysql_fetch_array($view)){
							    if ($row['id'] == 36) continue;
    							echo "<option value='$row[file]'>$row[nama_laporan]</option>";
    						} ?>
							</select>
						</div>
						
						<label class="fs-sm">Nama Sub Laporan</label>
						<div class="form-group">
							<select  id="sub_report" name="sub_report" data-placeholder="-- Pilh Sub Laporan --"
							data-width="auto"
							data-minimum-results-for-search="10"
							tabindex="-1"
							class="select2 form-control">
								<option value=""></option>
							</select>
						</div>

						
				</div>
				<div class="col-sm-3">
					<table>
					<tr>
						<td colspan="5" height="25" class="fs-sm text-align-center">-- Pilih Format Laporan --</td>
					</tr>
					<tr>
					<td>
						<button type="submit" name="format" value="p" class="btn btn-default width-100 mb-xs text-primary" role="button">
							<h1>
								<i class="glyphicon glyphicon-globe"></i>
								
							</h1>
							<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> PREVIEW</span>
						</button>
					</td>
					<td>&nbsp;</td>
					<td>
						<button type="submit" name="format" value="pdf"  class="btn btn-default width-100 mb-xs text-danger" role="button">
							<h1>
								<i class="fa fa-file-pdf-o text-danger"></i>
							</h1>
							<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> P D F</span>
						</button>
					</td>
					<td>&nbsp;</td>
					<td>
						<button type="submit" name="format" value="excel"  class="btn btn-default width-100 mb-xs text-success" role="button">
							<h1>
								<i class="fa fa-file-excel-o"></i>
							</h1>
							<span class="fs-sm"><i class="glyphicon glyphicon-download-alt"></i> E X C E L</span>
						</button>
					</td>
					</tr>
					</table>
				</div>
	</form>
	
	</div>
</div>