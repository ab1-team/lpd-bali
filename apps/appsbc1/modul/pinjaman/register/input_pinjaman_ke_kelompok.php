<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";
$nik	= $_POST['nik'];

$text	= "SELECT * FROM $table WHERE nik= '$nik' ";

$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);

if ($row>0){
	$r=mysql_fetch_array($sql); 
	
	?>
	
	
<script type="text/javascript"> 
			
function myFunction() {
    var x = document.getElementById("SimpanProposalKeKelompok");
    x.disabled = true;
}

			$(document).ready(function() {
				$("#alokasi").focus();
				$("#alokasi").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});



				$("#SimpanProposalKeKelompok").click(function() {
                    var nia				= $('#nia').val();
                    var kelompoke	= $('#kelompoke').val();
                    var alokasi			= $('#alokasi').val();
					
					if(alokasi.length==0){ alert('Alokasi Pengajuan tidak boleh kosong!');
						$("#alokasi").focus();
						return false;
							}
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/register/simpan_proposal_ke_kelompok.php",
                        data: 	"nia="+nia+
								"&kelompoke="+kelompoke+
								"&alokasi="+alokasi,
								
						success: function(data) {
                           $("#Suksese").load('modul/pinjaman/register/sukses.php');

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
                            <span class='h5 fw-bold'><i class='fa fa-group'></i> Masukkan $r[namadepan] Ke Pinjaman Kelompok <span class='pull-right'><a class='text-white' data-toggle='collapse' data-parent='#accordionKelompok' href='#collapseKelompok'><i class='glyphicon glyphicon-remove'></i></a></span></span>
                        </div>
						
							<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset> ";
								
								$kel=mysql_query("select * from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
																			WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND k.desa='$r[desa]' AND pk.`status`='P' ORDER BY pk.id DESC "); 
																			$rows	= mysql_num_rows($kel);
																		if ($rows>0){
								
								echo "
									<div class='form-group mt'>
															<label class='col-sm-4 control-label'>Pilih Kelompok</label>
															<div class='col-sm-8'>
																<select name='kelompoke' id='kelompoke' class='select2 form-control'>";
																	
																			while($row=mysql_fetch_array($kel)){
																		echo "<option value='$row[id]'>$row[nama_kelompok] ($row[ketua]) | ".number_format($row['proposal'])."</option>";
																			}
						
																echo "	
																</select>
															</div>
									</div>
									
									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Alokasi Pengajuan</label>
                                        <div class='col-sm-8'><input type='text' name='alokasi' class='form-control' id='alokasi' 
										required='required' autocomplete='off' placeholder='Rp. (Alokasi Pengajuan $r[namadepan])'> </div>
                                    </div>
                                    
									<input type='hidden' name='nia' id='nia' value='$r[id]' >
									
									<div id='Suksese'></div>
									
									<button class='btn btn-primary btn-rounded pull-right width-200' id='SimpanProposalKeKelompok'>Masukkan ke Kelompok <i class='fa fa-caret-right'></i></button>
								";
								
								}else{
									echo "<h3 class='text-danger'>Proposal Kelompok belum Tersedia,<br>Silahkan <a href='#tab1' data-toggle='tab'>Klik Disni</a> untuk membuat proposal kelompok!</h3>";	
								}
								
								echo "
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