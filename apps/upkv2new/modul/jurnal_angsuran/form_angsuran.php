<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id		= $_POST['cari'];
$idk	= $_POST['id_kelompok'];
if($id>0) {
$text	= "SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' AND k.id= '$id'";
}else{
$text	= "SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' AND k.kd_kelompok='$idk'";
}
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
	$r=mysql_fetch_array($sql);
	$jpp=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman WHERE id='$r[jenis_pp]' "));
						
						$_SESSION['id_pinj']	=$r['id'];
						
						$tgl_cair	=$r['tgl_cair'];
						$alokasi	=$r['alokasi'];
						$jangka		=$r['jangka'];
						$sistem		=$r['sistem'];
						$pros_jasa	=$r['pros_jasa'];
						$jenis_pp	=$r['jenis_pp'];
						$tgl_now	=date('Y-m-d');
						
						if($jenis_pp==1) { $jenis_buku='112'; } else if($jenis_pp==2) { $jenis_buku='113'; }
						
						$_SESSION['jenis_buku']=$jenis_buku;
						
						$tempo=$jangka/$sistem;
						$tgl_kondisi=date('Y-m-t');
					
						$nunggakpokok=nunggakpokok("$tgl_kondisi-$r[id]"); //tunggakan menjadi tagihan pada form angsuran
						$nunggakjasa=nunggakjasa("$tgl_kondisi-$r[id]");
						
						$smpokok=sumpokok("$tgl_now-$r[id]");
						if($smpokok=="") { $sumpokok="0"; }else{$sumpokok=$smpokok; }
						$proskembali=floor($sumpokok/$alokasi*100);
						
		$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];				
						?>
						
<script type="text/javascript">
function myFunction() {
    var x = document.getElementById("SimpanAngsuran");
    x.disabled = true;
}

	$(document).ready(function() {
	//$("#Progres").load('modul/jurnal_angsuran/tampil_progres.php');
			//simpan angsuran		
			$("#SimpanAngsuran").click(function() {
                    var id_pinj			= $('#id_pinj').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var datetimepicker1	= $('#datetimepicker1').val();
                    var tgl_pakai		= $('#tgl_pakai').val();
                    var pokok			= $('#pokok').val();
                    var jasa			= $('#jasa').val();
                    var denda			= $('#denda').val();
                    var alokasi			= $('#alokasi').val();
                    var jumpokok		= $('#jumpokok').val();
                    var tgl_cair		= $('#tgl_cair').val();
					var zumpokok		= parseInt(jumpokok)+parseInt(pokok);
					
					if(datetimepicker1 < tgl_pakai){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#datetimepicker1").focus();
						return false;
							}
							
					if(datetimepicker1 < tgl_cair){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_tanggal.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#datetimepicker1").focus();
						return false;
							}
					
					if(zumpokok > alokasi){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_pokok.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#pokok").focus();
						return false;
							}
							
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/simpan_angsuran.php",
                        data: 	"id_pinj="+id_pinj+
								"&jenis_pp="+jenis_pp+
								"&datetimepicker1="+datetimepicker1+
								"&pokok="+pokok+
								"&jasa="+jasa+
								"&denda="+denda,
								
						success: function(data) {
							$("#SuksesAngsur").load('modul/jurnal_angsuran/sukses_angsuran.php');
							$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran.php');
							$("#TampilKelompok").load('modul/jurnal_angsuran/tampil_kelompok.php');
							$("#Progres").load('modul/jurnal_angsuran/tampil_progres.php');
							document.getElementById("SimpanAngsuran").disabled = false;
							
                        }
                    });

                });
				
				
				
	
	});		
</script>
		
				
		
		
		<div>
			<a data-toggle="collapse" data-parent="#accordionCair" href="#collapseCair" ><i class="fa fa-user"></i> Tampilkan angsuran Anggota</a>
		</div>
		<div class="panel-group mb-lg" id="accordionCair" data-toggle="collapse">
			<div class="panel panel-default">
				<div id="collapseCair" class="panel-collapse collapse">
					<div class="panel-body">
						<table>
								<tr>
									<td class="col-sm-4"><i class="glyphicon glyphicon-user"></i></td>
									<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg">Pokok</h6></td>
									<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg">Jasa</h6></td>
									<td class="col-sm-2"><h6 class="ml-n-lg mr-n-lg">Jumlah</h6></td>
								</tr>
							<?php
							$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_pinkel='$r[id]'");
								while($pa=mysql_fetch_array($data)){
								$alokasia		=$pa['alokasi'];
								$jangkaa			=$pa['jangka'];
								$sistem_angsuran=$pa['sistem_angsuran'];
								$pros_jasaa		=$pa['pros_jasa'];
								
								$tempoa=$jangkaa/$sistem_angsuran;
								
								$angspokok=$alokasia/$tempoa;
								$angsjasa=($alokasia*$pros_jasaa)/100;
								$angsapokok=bulatkan($angspokok);
								
							?>
										<tr>
										<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg"><?php echo $pa['namadepan'];?></h6></td>
										<td><input value="<?php echo $angsapokok;?>" type="text" name="pokoka" id="pokoka" class="form-control input-sm  ml-n-lg text-align-right" required="required" autocomplete="off" placeholder="Pokok"></td>
										<td><input value="<?php echo $angsjasa;?>" onkeyup="kalkulatorTambah(getElementById('pokoka').value,this.value);" type="text" name="jasaa" id="jasaa" class="form-control input-sm ml-n-lg text-align-right" required="required" autocomplete="off" placeholder="Jasa"></td>
										<td><h6 class="text-align-right"><?php echo number_format($angsapokok+$angsjasa);?></h6></td>
										</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
							
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Pokok</label>
                                    <div class="col-sm-8">
										<input value="<?php echo $nunggakpokok;?>" onkeyup="calculate()" type="text" name="pokok" id="v0" class="form-control text-align-right" 
										required="required" placeholder="Pokok">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jasa</label>
                                    <div class="col-sm-8">
										<input value="<?php echo $nunggakjasa;?>" onkeyup="calculate()" type="text" name="jasa" id="v1" class="form-control text-align-right" 
									required="required" placeholder="Jasa">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Denda/Lainnya</label>
                                    <div class="col-sm-8">
										<input value="0" type="text" onkeyup="calculate()" name="denda" id="v2" class="form-control text-align-right" 
									required="required"  placeholder="Denda">
                                    </div>
                                </div>
                                
								<div class="text-align-right"><span id="result"></span></div>
								<input value="<?php echo $r['id'];?>" type="hidden" name="id_pinj" id="id_pinj"/>
								<input value="<?php echo $r['jenis_pp'];?>" type="hidden" name="jenis_pp" id="jenis_pp"/>
								<input type="hidden" name="tgl_pakai" id="tgl_pakai" value="<?php echo $tgl_pakai;?>"/>
								<input type="hidden" name="tgl_cair" id="tgl_cair" value="<?php echo $tgl_cair;?>"/>
								<input type="hidden" name="alokasi" id="alokasi" value="<?php echo $alokasi;?>"/>
								<input type="hidden" name="jumpokok" id="jumpokok" value="<?php echo $sumpokok;?>"/>
								<div id="SuksesAngsur"></div>
								<button class="btn btn-inverse btn-rounded width-200 mt-sm pull-right" id="SimpanAngsuran" onclick="myFunction()"><i class="fa fa-paper-plane"></i> POSTING ANGSURAN</button>
							
									<script type="text/javascript">

									function calculate(){
									var result = document.getElementById('result');
									var el, i = 0, total = 0;
									while(el = document.getElementById('v'+(i++)) ) {
									el.value = el.value.replace(/\\D/,"");
									total = total + Number(el.value);
									}
									result.value = total;
									if(document.getElementById('v0').value =="" && document.getElementById('v1').value =="" && document.getElementById('v2').value =="" ){
									 result.value ="";
									}
									}
									</script>

				
<?php				
}else{
echo"
<div class='widget'>
	<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
                    Silahkan scan barcode atau pilih kelompok!
                </div>
</div> ";
}
?>