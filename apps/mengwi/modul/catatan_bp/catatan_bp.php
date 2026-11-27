<?php include "inc/fungsi_indotgl.php"; ?>
 <script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {

				$("#tahun").keyup(function(e){
						var isi = $(e.target).val();
						$(e.target).val(isi.toUpperCase());
					});
	
                $("#FormSubmit").click(function() {
                    var tahun = $('#tahun').val();
                    var bulan = $('#bulan').val();
                    var isi = $('#isi').val();
						if(tahun.length==0){
						alert('Tahun tidak boleh kosong!');
						$("#tahun").focus();
						return false;
							}
						if(bulan.length==0){
						alert('Bulan tidak boleh kosong!');
						$("#bulan").focus();
						return false;
							}
						if(isi.length==0){
						alert('Catatan tidak boleh kosong!');
						$("#isi").focus();
						return false;
							}

							
                    $.ajax({
                        type: "POST",
                        url: "modul/catatan_bp/simpan.php",
                        data: "tahun="+tahun+
								"&bulan="+bulan+
								"&isi="+isi,
                        success: function(data) {
                            location.reload();
							alert('Berhasil !');

                        }
                    });

                });
				
            });
        </script>       
		
		<div class="row" id="TampilData">
            <div class="col-md-5 col-md-offset">
                <section class="widget">
                    <header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <legend><i class="fa fa-cog"></i> Form Catatan Hasil Pemeriksaan Badan Pengawas</legend>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Tahun Laporan</label>
                                        <div class="col-sm-8"><input type="text" name="tahun" id="tahun" class="form-control" 
										required="required" autocomplete="off" placeholder="Tahun Laporan" value="<?php echo date('Y');?>"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Bulan Laporan</label>
											<div class="col-sm-8">
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
                                    </div>
									<div class="form-group">
   
										<label>Catatan Hasil Pemeriksaan</label>
											<textarea rows="4" class="form-control" name="isi" id="isi"
											autocomplete="off" placeholder="Tuliskan Catatan Hasil Pemeriksaan"></textarea>
			
                                    </div>
                            </fieldset>
                           
                            <div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="FormSubmit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                <button type="button" class="btn btn-default btn-rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
			
	<div class="col-md-7">
		<section class="widget">
					<header>
                        <legend><i class="fa fa-th-list"></i> Daftar Jenis Kas</legend>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                        </div>
                    </header>
            <script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	

		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
	function deleteRow(ID) {
		var id	= ID;
	   var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/catatan_bp/hapus.php",
				data	: "id="+id,
				success	: function(data){
					location.reload();
					alert('Berhasil!');
				}
			});
		}
	}
</script>

 <div class="widget-body">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Kode Catatan</th>
                            <th width="10%" class="hidden-xs">Bulan Laporan</th>
                            <th width="60%" class="hidden-xs">Deskripsi</th>
							<th width="10%" class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						include "../../inc/fungsi_indotgl.php";
						$lokasi		= $_SESSION['lokasi'];
						$view=mysql_query("SELECT * FROM catatan_bp WHERE lokasi='$lokasi' order by bulan_laporan DESC");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no				= $no+1;
								$bulan_laporan	= $row['bulan_laporan'];
								$bulan 			= getBulan(substr($bulan_laporan,5,2));
								$tahun			= substr($bulan_laporan,0,4);
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>$row[id]</td>
							<td class='hidden-xs'>$bulan $tahun</td>
							<td class='hidden-xs'>";
							if(substr($row['isi'],51,1)==""){echo $row['isi'];}else{echo substr($row['isi'],0,50).".............";}
							echo "</td>
                            <td><!---------------<a href='javascript:editRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='left' title='Edit Kode $row[id]'><i class='fa fa-edit'></i></a> | 
								---><a href='javascript:deleteRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='right' title='Hapus Kode $row[id]'><i class='fa fa-times'></i></a> | "; ?>
								
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/BP.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"> <i class='fa fa-print'></i> </a></td> <?php echo "
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
	</div>
</div>