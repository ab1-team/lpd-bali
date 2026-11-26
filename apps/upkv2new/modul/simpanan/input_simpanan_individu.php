<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";
$ids	= $_POST['ids'];
$nik	= $_POST['nik'];

$text	= "SELECT * FROM $table WHERE nik= '$nik' ";

$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
$idss=mysql_fetch_array(mysql_query("select  MAX(id) as idsim from simpanan_anggota_$_SESSION[kd_kab]"));
$des=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));

if ($row>0){
	$r=mysql_fetch_array($sql); 
	
	$lok	=$_SESSION['lokasi'];
	
if($ids==1){ 
	$nkred	=$idss['idsim']+1;
	$idrek	="221";
}else if($ids==2){ 
	$nkred	=$idss['idsim']+1;
	$idrek	="222";
}else if($ids==3){ 
	$nkred	=$idss['idsim']+1;
	$idrek	="223";
}
	
		 if($lok<10) {$lokasi="000$lok";}
	else if($lok>=10 AND $lok<100) {$lokasi="00$lok";}
	else if($lok>=100 AND $lok<1000) {$lokasi="0$lok";}
	else if($lok>=1000 AND $lok<10000) {$lokasi="$lok";}
	
		 if($nkred<10) {$lkred="000$nkred";}
	else if($nkred>=10 AND $nkred<100) {$lkred="00$nkred";}
	else if($nkred>=100 AND $nkred<1000) {$lkred="0$nkred";}
	else if($nkred>=1000 ) {$lkred="$nkred";}
	
	
	$norek	="$lokasi.$idrek.$lkred";
	
	?>
		
	
<?php	
$tgl=date('Y-m-d');
	echo"
	
	<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
								<div class='col-sm-12'>
									<div class='form-group'>
                                        <label class='fs-sm'>Nomor Rekening</label>
                                        <input type='text' value='$norek' name='nomor_rekening' class='form-control' id='nomor_rekening' disabled
										required='required' autocomplete='off' placeholder='Nomor Rekening'>
                                    </div>
                                </div>
								<div class='col-sm-5'>
									<div class='form-group'>
                                        <label class='fs-sm'>Tanggal Pembukaan / Transaksi</label>
                                        <input type='text' value='$tgl' name='tgl_buka' class='form-control' id='tgl_buka' 
										required='required' autocomplete='off' placeholder='Tanggal Pembukaan'>
                                    </div>";
							
							if($ids==2) {
									
							echo "
									<div class='form-group'>
										<label class='fs-sm'>Jangka Waktu (Bulan)</label>
										<input type='text' name='jangka' class='form-control' id='jangka' value='$des[def_jangka]'
											required='required' autocomplete='off' placeholder='Jangka Waktu (Bulan)'>
                                    </div>";
							}else{
								echo "<input type='hidden' name='jangka' id='jangka' value='0' >";
							}
							
							echo "
                                 </div>
								 
								 <div class='col-sm-1'>
                                 </div>
								 
								 <div class='col-sm-6'>
									
									<div class='form-group'>
                                        <label class='fs-sm'>Jumlah ";if($ids==1) {echo "Setoran Awal "; } echo "Rp.</label>
                                        <input type='text' name='jumlah' class='form-control' id='jumlah'  onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'
										required='required' autocomplete='off' placeholder='Jumlah Setoran' >
                                    </div>";
							
							if($ids==2) {
									
							echo "
									<div class='form-group'>
                                        <label class='fs-sm'>Prosentase Jasa (Persen)</label>
                                        <input type='text' name='pros_jasa' class='form-control' id='pros_jasa' value='$des[def_jasa]'
										required='required' autocomplete='off' placeholder='Prosentase Jasa (%)'>
									</div>
                                 </div>";
							}else{
								echo "<input type='hidden' name='pros_jasa' id='pros_jasa' value='0' >";
							}
							
							echo "
								</fieldset>
							</div>
								<input type='hidden' name='jenis_simpanan' id='jenis_simpanan' value='$ids' >
								<input type='hidden' name='nia' id='nia' value='$r[id]' >
								<input type='hidden' name='nkred' id='nkred' value='$nkred' >
								<div id='Sukses'></div>
								<button class='btn btn-primary btn-block btn-lg' id='SimpanSimpanan'>S i m p a n</button>
						
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
    var x = document.getElementById("SimpanSimpanan");
    x.disabled = true;
}

$("#jumlah").focus();

			$(document).ready(function() {
				$("#jumlah").focus();
				$("#jumlah").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#jangka").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});



				$("#SimpanSimpanan").click(function() {
                    var nia				= $('#nia').val();
                    var nkred       	= $('#nkred').val();
                    var jenis_simpanan	= $('#jenis_simpanan').val();
                    var nomor_rekening	= $('#nomor_rekening').val();
                    var tgl_buka		= $('#tgl_buka').val();
                    var jumlah			= $('#jumlah').val();
                    var jangka			= $('#jangka').val();
                    var pros_jasa		= $('#pros_jasa').val();
					
					if(jumlah.length==0){ alert('Jumlah Setoran tidak boleh kosong!');
						$("#jumlah").focus();
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
                        url: "modul/simpanan/simpan_simpanan_individu.php",
                        data: 	"nia="+nia+
								"&nkred="+nkred+
								"&jenis_simpanan="+jenis_simpanan+
								"&nomor_rekening="+nomor_rekening+
								"&tgl_buka="+tgl_buka+
								"&jumlah="+jumlah+
								"&jangka="+jangka+
								"&pros_jasa="+pros_jasa,
								
						success: function(data) {
                           $("#Sukses").load('modul/simpanan/sukses_data.php');
						   $("#TampilSimpanan").load('modul/simpanan/tampil_simpanan.php');
						   document.getElementById("SimpanSimpanan").disabled = false;
						   setTimeout(function(){ $('#myModalSimpananUmum').modal('hide'); }, 1000); //Tutup Otomatis
						   setTimeout(function(){ $('#myModalSimpananDepo').modal('hide'); }, 1000); //Tutup Otomatis

                        }

                    });

                });
					
			});
			
</script>