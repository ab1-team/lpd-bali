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

$bunga=$kec['def_bunga'];
$pajak=$kec['def_pajak'];
$admin=$kec['def_admin'];
$openrek=$kec['def_openrek'];

$simp=mysql_fetch_array(mysql_query("select MAX(id) AS idsmax from simpanan_anggota_$_SESSION[kd_kab]"));

$lokasi0 = sprintf("%04d", $_SESSION['lokasi']);
$jps = '221'; //kedepannya, buat supaya menggunakan javascript
$idnkred = $simp['idsmax']+1;
$ids0 = sprintf("%06d", ($idnkred));
$norek= "$lokasi0.$jps.$ids0";

if ($row>0){
	$r=mysql_fetch_array($sql); 
	
	?>
	
	
<script type="text/javascript"> 
            $('#input_jabatan').hide()
            $('#input_lembaga').hide()

			function tandaPemisahTitik(b) {
                var _minus = false;
                if (b < 0) _minus = true;
                b = b.toString();
                b = b.replace(".", "");

                c = "";
                panjang = b.length;
                j = 0;
                for (i = panjang; i > 0; i--) {
                    j = j + 1;
                    if (((j % 3) == 1) && (j != 1)) {
                        c = b.substr(i - 1, 1) + "." + c;
                    } else {
                        c = b.substr(i - 1, 1) + c;
                    }
                }
                if (_minus) c = "-" + c;
                return c;
            }

            function numbersonly(ini, e) {
                if (e.keyCode >= 49) {
                    if (e.keyCode <= 57) {
                        a = ini.value.toString().replace(".", "");
                        b = a.replace(/[^\d]/g, "");
                        b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else if (e.keyCode <= 105) {
                        if (e.keyCode >= 96) {
                            //e.keycode = e.keycode - 47;
                            a = ini.value.toString().replace(".", "");
                            b = a.replace(/[^\d]/g, "");
                            b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode -
                                48);
                            ini.value = tandaPemisahTitik(b);
                            //alert(e.keycode);
                            return false;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 48) {
                    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
                    b = a.replace(/[^\d]/g, "");
                    if (parseFloat(b) != 0) {
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 95) {
                    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
                    b = a.replace(/[^\d]/g, "");
                    if (parseFloat(b) != 0) {
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 8 || e.keycode == 46) {
                    a = ini.value.replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = b.substr(0, b.length - 1);
                    if (tandaPemisahTitik(b) != "") {
                        ini.value = tandaPemisahTitik(b);
                    } else {
                        ini.value = "";
                    }

                    return false;
                } else if (e.keyCode == 9) {
                    return true;
                } else if (e.keyCode == 17) {
                    return true;
                } else {
                    //alert (e.keyCode);
                    return false;
                }
            }
            
            $('#sp').change(function() {
                if (this.value == 1) {
                    $('#input_jabatan').show()
                    $('#input_lembaga').show()
                } else {
                    $('#input_jabatan').hide()
                    $('#input_lembaga').hide()
                }
            })
			
function myFunction() {
    var x = document.getElementById("SimpanSimpananIndividu");
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


				$("#SimpanSimpananIndividu").click(function() {
				    
                    var norek			= $('#norek').val();
                    var nia				= $('#nia').val();
                    var nkred			= $('#nkred').val();
                    var js				= $('#js').val();
                    var jumlah			= $('#jumlah').val();
                    var tgl_buka    	= $('#tgl_buka').val();
                    var tgl_tutup    	= $('#tgl_tutup').val();
                    var pros_jasa		= $('#pros_jasa').val();
                    var jangka			= $('#jangka').val();
                    var openrek       	= $('#openrek').val();
                    var bunga       	= $('#bunga').val();
                    var pajak       	= $('#pajak').val();
                    var admin       	= $('#admin').val();
                    var sp          	= $('#sp').val();
                    var lembaga     	= $('#lembaga').val();
                    var jabatan     	= $('#jabatan').val();
                    var pengampu    	= $('#pengampu').val();
                    var hubungan    	= $('#hubungan').val();
					
					if(jumlah.length==0){ alert('Setoran Awal tidak boleh kosong!');
						$("#jumlah").focus();
						return false;
					}
					
					var i = 0
					while(i <= jumlah.length) {
					    jumlah = jumlah.toString().replace('.','')
					    i++
					}
					
					i = 0
					while(i <= openrek.length) {
					    openrek = openrek.toString().replace('.','')
					    i++
					}
						
                    $.ajax({
                        type: "POST",
                        url: "modul/simpanan/simpan_simpanan_individu.php",
                        data: 	"nia="+nia+
								"&norek="+norek+
								"&nkred="+nkred+
								"&js="+js+
								"&jumlah="+jumlah+
								"&tgl_buka="+tgl_buka+
								"&tgl_tutup="+tgl_tutup+
								"&pros_jasa="+pros_jasa+
								"&jangka="+jangka+
								"&openrek="+openrek+
								"&bunga="+bunga+
								"&pajak="+pajak+
								"&admin="+admin+
								"&sp="+sp+
								"&lembaga="+lembaga+
								"&jabatan="+jabatan+
								"&pengampu="+pengampu+
								"&hubungan="+hubungan,
								
						success: function(data) {
                          $("#SuksesS").load('modul/simpanan/sukses_data.php');
						   $("#TampilSimpanan").load('modul/simpanan/tampil_simpanan.php');

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
                            <span class='h5 fw-bold'><i class='glyphicon glyphicon-user'></i> Input Data Form Pembukaan Simpanan Umum<span class='pull-right'><a class='text-white' data-toggle='collapse' data-parent='#accordionIndividu' href='#collapseIndividu'><i class='glyphicon glyphicon-remove'></i></a></span></span>
                        </div>
						
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<div class='form-group mt'>
                                        <label class='control-label col-sm-5'>Nomor Rekening</label>
                                        <div class='col-sm-7'><input type='text' value='$norek' name='norek' class='form-control' id='norek' 
										required='required' autocomplete='off' placeholder='Norek' disabled > </div>
                                    </div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Tanggal Buka</label>
                                        <div class='col-sm-7'><input type='text' value='$tgl' name='tgl_buka' class='form-control' id='tgl_buka' 
										required='required' autocomplete='off' placeholder='Tanggal Buka'> </div>
                                    </div>
                                    
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Jumlah Setoran Awal Rp.</label>
                                        <div class='col-sm-7'><input type='text' name='jumlah' class='form-control' id='jumlah' 
										required='required' autocomplete='off' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' placeholder='Setoran Awal $r[namadepan]' > </div>
                                    </div>
                                    
                                    
                                    <input type='hidden' name='js' id='js' value='1' >
                                    <input type='hidden' name='tgl_tutup' id='tgl_tutup' value='$tgl' >
                                    <input type='hidden' name='Jangka' id='Jangka' value='$Jangka' >
                                    
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Biaya Pembukaan Rekening</label>
                                        <div class='col-sm-4'><input type='text' name='openrek' class='form-control' id='openrek' value='$openrek'
										required='required' autocomplete='off' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' placeholder='Biaya Pembukaan Rekening'> </div>
										<label class='control-label col-sm-3'>Rupiah (Rp.)</label>
									</div>
									
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Bunga</label>
                                        <div class='col-sm-4'><input type='text' name='bunga' class='form-control' id='bunga' value='$bunga'
										required='required' autocomplete='off' placeholder='Bunga (%)'> </div>
										<label class='control-label col-sm-3'>persen (%)</label>
									</div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Pajak</label>
                                        <div class='col-sm-4'><input type='text' name='pajak' class='form-control' id='pajak' value='$pajak'
										required='required' autocomplete='off' placeholder='pajak (%)'> </div>
										<label class='control-label col-sm-3'>persen (%)</label>
									</div>
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Admin</label>
                                        <div class='col-sm-4'><input type='text' name='admin' class='form-control' id='admin' value='$admin'
										required='required' autocomplete='off' placeholder='Biaya admin Per bulan'> </div>
										<label class='control-label col-sm-3'>Rupiah (Rp.)</label>
									</div>
									<div class='form-group'>
										<label class='control-label col-sm-5'>Kuasa</label>
										<div class='col-sm-7'>
											<select id='sp'  name='sp'
												class='select form-control'
												tabindex='-1'> 
												    <option value='0'>Pribadi</option>
												    <option value='1'>Mewakili Lembaga</option>
											</select>
										</div>
                                    </div>
									
									<div class='form-group' id='input_lembaga' style='background-color:#DDFFDD'>
                                        <label class='control-label col-sm-5'>Nama Lembaga</label>
                                        <div class='col-sm-7'><input type='text' name='lembaga' class='form-control' id='lembaga' 
										required='required' autocomplete='off' placeholder='Nama Lembaga yang diwakilkan' > </div>
                                    </div>
									<!-----------
									<div class='form-group' style='background-color:#DDFFDD'>
                                        <label class='control-label col-sm-5'>NPWP</label>
                                        <div class='col-sm-7'><input type='text' name='proposali' class='form-control' id='proposali' 
										required='required' autocomplete='off' placeholder='NPWP Lembaga yang diwakilkan' > </div>
                                    </div> ---------->
									<div class='form-group' id='input_jabatan' style='background-color:#DDFFDD'>
                                        <label class='control-label col-sm-5'>Jabatan</label>
                                        <div class='col-sm-7'><input type='text' name='jabatan' class='form-control' id='jabatan' 
										required='required' autocomplete='off' placeholder='Jabatan yang mewakili' > </div>
                                    </div>
                                    
									<div class='form-group'>
                                        <label class='control-label col-sm-5'>Ahli Waris / Pengampu</label>
                                        <div class='col-sm-7'><input type='text' name='pengampu' class='form-control' id='pengampu' 
										required='required' autocomplete='off' placeholder='Ahli Waris / Pengampu $r[namadepan]' > </div>
                                    </div>
                                    
                                    <div class='form-group'>
										<label class='control-label col-sm-5'>Hubungan</label>
										<div class='col-sm-7'>
											<select id='hubungan'  name='hubungan'
												class='select form-control'
												tabindex='-1'> ";
														$data=mysql_query('select * from keluarga'); 
															while($rowk=mysql_fetch_array($data)){
															echo "<option value=$rowk[id]>$rowk[kekeluargaan]</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
								
									
									<div class='form-group' id='form_barang'></div>
                                    
									<input type='hidden' name='nia' id='nia' value='$r[id]' >
									<input type='hidden' name='pros_jasa' id='pros_jasa' value='0' >
									<input type='hidden' name='nkred' id='nkred' value='$idnkred' >
									
									<div id='SuksesS'></div>
									
									<button class='btn btn-primary btn-rounded pull-right width-200' id='SimpanSimpananIndividu'>Simpan Simpanan <i class='fa fa-caret-right'></i></button>
             
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