<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c where c.id='$_SESSION[lokasi]' "));

?>

<script type="text/javascript">

	<![CDATA[
var htmlobjek;
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
    $("#sub_report").change(function(){
	 var sub_report = $("#sub_report").val();
	 $.ajax({
		 url:"modul/pelaporan/ambil_nama_desa.php",
        data: "sub_report="+sub_report,
        cache: false,
        success: function(msg){
            $("#select_desa").html(msg);
        }
	 });
  });
  });



 ]]>
</script>
		
<div class="row">
	<div class="col-md-12 col-md-offset hidden-print">
        <section class="widget" style="border: 1px solid #5d8fc2;">
			<div class="widget-body">
				<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
					<div class="row">
						<div class="col-md-12">
							<span class="h4 fw-bold text-white pull-right mt">
							<span class="fw-normal">HALAMAN </span>  PELAPORAN <i class="glyphicon glyphicon-th-large"></i> </span>
						</div>
					</div>
				</div>

		<div class="row">
                <section class="widget" style="background-color:#f8f8f8;">
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<form method="POST" target='_blank' action='modul/pelaporan/p/report_view.php'>	
		<div class="form-group">
			<div class="col-md-3" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-primary custom-width" onclick="window.location.href='?p=l'">Pelaporan</button>
			</div>
			<div class="col-md-3" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-primary custom-width" onclick="window.location.href='?p=lb'">buku besar</button>
			</div>
			<div class="col-md-3" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-primary custom-width" onclick="window.location.href='?p=li'">inventaris</button>
			</div>
			<div class="col-md-3" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-primary custom-width" onclick="window.location.href='?p=lp'" disabled>Pinjaman</button>
			</div>
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
										<div class="col-sm-3">
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
									<legend></legend>
									<div class="col-sm-5">
										<label class="fs-sm">IDF</label>
											<div class="form-group">
												<select  id="idf" name="idf" data-placeholder="-- Pilh IDF --"
												data-width="auto"
												data-minimum-results-for-search="10"
												tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
												<?php 
												$view1=mysql_query("select * from jenis_produk_pinjaman WHERE 
												kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'  AND lokasi='0' or 
												lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'"); //Jenis Laporan
												while($row1=mysql_fetch_array($view1)){
												echo "<option value='$row1[id]'>$row1[nama_jpp]</option>";
												} 
												?>
												</select>
											</div>
											
										<label class="fs-sm">Laporan</label>
											<div class="form-group">
												<select id="report"  name="report"
												data-placeholder="-- Pilih Jenis Laporan --"
												data-width="auto"
												data-minimum-results-for-search="10"
												tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
												<?php 
												$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ORDER by urut ASC"); //Jenis Laporan
												while($row=mysql_fetch_array($view)){
												echo "<option value='$row[file]'>$row[nama_laporan]</option>";
												} 
												?>
												</select>
											</div>
										<label class="fs-sm">desa</label>
											<div class="form-group">
												<select id="pilih_desa"  name="pilih_desa"
												data-placeholder="-- Pilih Desa --"
												data-width="auto"
												data-minimum-results-for-search="10"
												tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
												<?php 
												$view=mysql_query("select * from desa WHERE `kd_kec` LIKE '$kec[kd_kec]'"); //Jenis Laporan
												while($row=mysql_fetch_array($view)){
												echo "<option value='$row[kd_desa]'>$row[nama_desa]</option>";
												} 
												?>
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
							</fieldset>
                        </div>
                    </div>
                </section>
		</div>
 
		

	
			</div>
		</section>
	</div>
</div>