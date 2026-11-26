<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";
$nik	= $_POST['nik'];

$text	= "SELECT * FROM $table WHERE nik= '$nik' ";

$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
$kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));

if ($row>0){
	$r=mysql_fetch_array($sql); 
	
	?>
	
	
<script type="text/javascript"> 
			
function myFunction() {
    var x = document.getElementById("SimpanProposalTernak");
    x.disabled = true;
}

			$(document).ready(function() {
				
					//apabila terjadi event onchange terhadap object <select id=jenis_kegiatan>
				  $("#jenis_kegiatan").change(function(){
					var jenis_kegiatan = $("#jenis_kegiatan").val();
					$.ajax({
						url: "modul/penduduk/ambil_nama_usaha.php",
						data: "jenis_kegiatan="+jenis_kegiatan,
						cache: false,
						success: function(msg){
							//jika data sukses diambil dari server kita tampilkan
							//di <select id=jenis_buku>
							$("#usaha").html(msg);
						}
					});
				  });
				  
				  
				$("#proposali").focus();
				$("#proposali").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#jangka").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});



				$("#SimpanProposalTernak").click(function() {
                    var nia				= $('#nia').val();
                    var tgl_proposal	= $('#tgl_proposal').val();
                    var usaha			= $('#usaha').val();
                    var proposali		= $('#proposali').val();
                    var pros_jasa		= $('#pros_jasa').val();
                    var jangka			= $('#jangka').val();
					
					if(proposali.length==0){ alert('Alokasi Pengajuan tidak boleh kosong!');
						$("#proposali").focus();
						return false;
							}
						
						if(pros_jasa.length==0){ alert('Prosentase Jasa tidak boleh kosong!');
						$("#pros_jasa").focus();
						return false;
							}
						
						if(jangka.length==0){ alert('Jangka waktu tidak boleh kosong!');
						$("#jangka").focus();
						return false;
							}
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/register/simpan_proposal_ternak.php",
                        data: 	"nia="+nia+
								"&tgl_proposal="+tgl_proposal+
								"&usaha="+usaha+
								"&proposali="+proposali+
								"&pros_jasa="+pros_jasa+
								"&jangka="+jangka,
								
						success: function(data) {
                           $("#Sukses").load('modul/pinjaman/register/sukses.php');

                        }

                    });

                });
					
			});
			
</script>	
	
<?php
$pek=mysql_fetch_array(mysql_query("select * from jenis_kegiatan k, usaha u WHERE k.id=u.jenis_kegiatan AND u.id='$r[usaha]' order by u.nama_usaha "));
		
$tgl=date('Y-m-d');
	echo"
	
	<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div class='widget-top-overflow windget-padding-md clearfix bg-primary'>
                            <span class='h5 fw-bold'><i class='glyphicon glyphicon-user'></i> Input Proposal Kegiatan Usaha P4 <span class='pull-right'><a class='text-white' data-toggle='collapse' data-parent='#accordionPeternakan' href='#collapsePeternakan'><i class='glyphicon glyphicon-remove'></i></a></span></span>
                        </div>
						
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<div class='form-group mt'>
                                        <label class='control-label col-sm-5'>Tanggal Proposal</label>
                                        <div class='col-sm-7'><input type='text' value='$tgl' name='tgl_proposal' class='form-control' id='tgl_proposal' 
										required='required' autocomplete='off' placeholder='Tanggal Proposal'> </div>
                                    </div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Jenis Kegiatan Usaha</label>
                                        <div class='col-sm-3'>
											<select id='jenis_kegiatan'  name='jenis_kegiatan'
												data-placeholder='-- Pilih Jenis Kegiatan --'
												data-width='auto'
												data-minimum-results-for-search='10'
												tabindex='-1'
												class='select2 form-control'>
													<option value='$pek[jenis_kegiatan]'>$pek[deskripsi_jk]</option>";
												$view=mysql_query("select * from jenis_kegiatan ORDER BY id"); //jenis kegiatan
												while($row=mysql_fetch_array($view)){
												echo "<option value='$row[id]'>$row[deskripsi_jk]</option>";
												}
											echo "
											</select>
										</div>
										<div class='col-sm-4'>
											<select id='usaha' name='usaha' class='form-control' data-placeholder='-- Pilh Nama Usaha --' data-width='auto'>
                                                <option value='$pek[id]'>$pek[nama_usaha]</option>
											</select>
										</div>
									</div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Pengajuan Modal Awal Rp.</label>
                                        <div class='col-sm-7'><input type='text' name='proposali' class='form-control' id='proposali' 
										required='required' autocomplete='off' placeholder='Alokasi Pengajuan Modal Awal $r[namadepan]' > </div>
                                    </div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Prosentase Bagi Hasil</label>
                                        <div class='col-sm-4'><input type='text' name='pros_jasa' class='form-control' id='pros_jasa' value='50'
										required='required' autocomplete='off' placeholder='Prosentase Bagi Hasil (%)'> </div>
										<label class='control-label col-sm-3'>persen</label>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Jangka Waktu Penjualan/Panen</label>
										<div class='col-sm-4'><input type='text' name='jangka' class='form-control' id='jangka' value='4'
											required='required' autocomplete='off' placeholder='Jangka Waktu Penjualan/Panen'> </div>
										<label class='control-label col-sm-3'>bulan</label>
                                    </div>
                                    
									<input type='hidden' name='nia' id='nia' value='$r[id]' >
									
									<div id='Sukses'></div>
									
									<button class='btn btn-primary btn-rounded pull-right width-200' id='SimpanProposalTernak'>Simpan Proposal <i class='fa fa-caret-right'></i></button>
             
								</fieldset>
							</div> 
							<legend class='text-white'>&nbsp;</legend>
						
                        </div>
                        </section>
						
							
							";	
}else{
echo"
<div class='widget'>
	<div class='alert alert-danger alert-sm'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
                    Penduduk belum tersedia/NIK tidak dikenal!
                </div>
</div> ";
}
?>