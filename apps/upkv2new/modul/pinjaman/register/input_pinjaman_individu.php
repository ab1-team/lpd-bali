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
function tandaPemisahTitik(b){
				var _minus = false;
				if (b<0) _minus = true;
				b = b.toString();
				b=b.replace(".","");
				
				c = "";
				panjang = b.length;
				j = 0;
				for (i = panjang; i > 0; i--){
					 j = j + 1;
					 if (((j % 3) == 1) && (j != 1)){
					   c = b.substr(i-1,1) + "." + c;
					 } else {
					   c = b.substr(i-1,1) + c;
					 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}

			function numbersonly(ini, e){
				if (e.keyCode>=49){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
				}else if (e.keyCode==48){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){
					return true;
				} else if (e.keyCode==17){
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}
			
function myFunction() {
    var x = document.getElementById("SimpanProposalIndividu");
    x.disabled = true;
}

			$(document).ready(function() {
													$("#jenis_pp").change(function(){
													 var jenis_pp = $("#jenis_pp").val();
													 $.ajax({
														 url:"modul/pinjaman/ambil_nama_barang.php",
														data: "jenis_pp="+jenis_pp,
														cache: false,
														success: function(msg){
															$("#form_barang").html(msg);
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



				$("#SimpanProposalIndividu").click(function() {
                    var nia				= $('#nia').val();
                    var tgl_proposal	= $('#tgl_proposal').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var nama_barang		= $('#nama_barang').val();
                    var proposali		= $('#proposali').val();
                    var pros_jasa		= $('#pros_jasa').val();
                    var jenis_jasa		= $('#jenis_jasa').val();
                    var jangka			= $('#jangka').val();
                    var sistem			= $('#sistem').val();
                    var sa_jasa			= $('#sa_jasa').val();
                    
					
					if(proposali.length==0){ alert('Alokasi Pengajuan tidak boleh kosong!');
						$("#proposali").focus();
						return false;
							}
						
                    var i = 0
					while(i <= proposali.length) {
					    proposali = proposali.toString().replace('.','')
					    i++
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
                        url: "modul/pinjaman/register/simpan_proposal_individu.php",
                        data: 	"nia="+nia+
								"&tgl_proposal="+tgl_proposal+
								"&jenis_pp="+jenis_pp+
								"&nama_barang="+nama_barang+
								"&proposali="+proposali+
								"&pros_jasa="+pros_jasa+
								"&jenis_jasa="+jenis_jasa+
								"&jangka="+jangka+
								"&sistem="+sistem+
								"&sa_jasa="+sa_jasa,
								
						success: function(data) {
                           $("#Sukses").load('modul/pinjaman/register/sukses.php');

                        }

                    });

                });
					
			});
			
</script>	
<?php	
$tgl=date('Y-m-d');
	echo"
	
	<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div class='widget-top-overflow windget-padding-md clearfix bg-primary'>
                            <span class='h5 fw-bold'><i class='glyphicon glyphicon-user'></i> Input Proposal Pinjaman Individu (non-Kelompok) <span class='pull-right'><a class='text-white' data-toggle='collapse' data-parent='#accordionIndividu' href='#collapseIndividu'><i class='glyphicon glyphicon-remove'></i></a></span></span>
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
                                        <label class='control-label col-sm-5'>Pengajuan Rp.</label>
                                        <div class='col-sm-7'><input type='text' name='proposali' class='form-control' id='proposali' 
										required='required' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' autocomplete='off' placeholder='Alokasi Pengajuan $r[namadepan]' > </div>
                                    </div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Prosentase Jasa</label>
                                        <div class='col-sm-4'><input type='text' name='pros_jasa' class='form-control' id='pros_jasa' value='$kec[def_jasa]'
										required='required' autocomplete='off' placeholder='Prosentase Jasa (%)'> </div>
										<label class='control-label col-sm-3'>persen</label>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Jangka Waktu</label>
										<div class='col-sm-4'><input type='text' name='jangka' class='form-control' id='jangka' value='$kec[def_jangka]'
											required='required' autocomplete='off' placeholder='Jangka Waktu'> </div>
										<label class='control-label col-sm-3'>bulan</label>
                                    </div>

									<div class='form-group'>
										<label class='control-label col-sm-5'>Jenis Jasa</label>
										<div class='col-sm-7'>
											<select id='jenis_jasa'  name='jenis_jasa'
												class='select form-control'
												tabindex='-1'> ";
														$data=mysql_query('select * from jenis_jasa'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jj]</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Sis. Angsuran Pokok</label>
										<div class='col-sm-7'>
											<select id='sistem'  name='sistem'
												class='select form-control'
												tabindex='-1'> ";
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Sis. Angsuran Jasa</label>
										<div class='col-sm-7'>
											<select id='sa_jasa'  name='sa_jasa'
												class='select form-control'
												tabindex='-1'> ";
														$data2=mysql_query('select * from sistem_angsuran'); 
															while($row2=mysql_fetch_array($data2)){
															echo "<option value=$row2[id]>$row2[nama_sistem] ($row2[deskripsi_sistem])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Jenis Produk Pinj.</label>
										<div class='col-sm-7'>
											<select id='jenis_pp'  name='jenis_pp'
												class='select form-control'
												tabindex='-1'> ";
														$data=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'"); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jpp] ($row[deskripsi_jpp])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									<div class='form-group' id='form_barang'></div>
                                    
									<input type='hidden' name='nia' id='nia' value='$r[id]' >
									
									<div id='Sukses'></div>
									
									<button class='btn btn-primary btn-rounded pull-right width-200' id='SimpanProposalIndividu'>Simpan Proposal <i class='fa fa-caret-right'></i></button>
             
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