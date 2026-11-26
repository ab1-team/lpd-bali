<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id		= $_POST['cari'];
$idk	= $_POST['nik'];
if($id>0) {
$text	= "SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND a.desa=d.id and a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' AND pi.status='A' AND pi.jenis_pinjaman='I' AND a.id= '$id'";
}else{
$text	= "SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND a.desa=d.id and a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' AND pi.status='A' AND pi.jenis_pinjaman='I' AND a.nik='$idk'";
}
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
	$r=mysql_fetch_array($sql);
	$jpp=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman WHERE id='$r[jenis_pp]' "));
						
						$_SESSION['id_pinj']	=$r['id'];
						
						$alokasi	=$r['alokasi'];
						$jangka		=$r['jangka'];
						$sistem		=$r['sistem'];
						$pros_jasa	=$r['pros_jasa'];
						$jenis_pp	=$r['jenis_pp'];
						
						if($jenis_pp==1) { $jenis_buku='112'; } else if($jenis_pp==2) { $jenis_buku='113'; }
						
						$_SESSION['jenis_buku']=$jenis_buku;
						
						$tempo=$jangka/$sistem;
						$tgl_kondisi=date('Y-m-t');
					
						$nunggakpokok=nunggakpokok("$tgl_kondisi-$r[id]"); //tunggakan menjadi tagihan pada form angsuran
						$nunggakjasa=nunggakjasa("$tgl_kondisi-$r[id]");
						
						$sumpokok=sumpokok(date('Y-m-d')."-$r[id]");
						$proskembali=$sumpokok/$alokasi*100;
						
		$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];				
						?>
						
<script type="text/javascript">

	$(document).ready(function() {
	//$("#SuksesAngsur").load('modul/jurnal_angsuran/sukses_angsuran_individu.php');
			//simpan angsuran		
			$("#SimpanAngsuranIndividu").click(function() {
                    var id_pinj			= $('#id_pinj').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var tgl_transaksi	= $('#tgl_transaksi').val();
                    var tgl_pakai		= $('#tgl_pakai').val();
                    var pokok			= $('#pokok').val();
                    var jasa			= $('#jasa').val();
                    var denda			= $('#denda').val();
					
					if(tgl_transaksi < tgl_pakai){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						return false;
							}
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/simpan_angsuran_individu.php",
                        data: 	"id_pinj="+id_pinj+
								"&jenis_pp="+jenis_pp+
								"&tgl_transaksi="+tgl_transaksi+
								"&pokok="+pokok+
								"&jasa="+jasa+
								"&denda="+denda,
								
						success: function(data) {
							$("#SuksesAngsur").load('modul/jurnal_angsuran/sukses_angsuran_individu.php');
							$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran_individu.php');
							$("#TampilKelompok").load('modul/jurnal_angsuran/tampil_individu.php');

                        }
                    });

                });
				
				
				
	
	});		
</script>
		
		<?php
		echo "
		<br>
			<small>Progres pengembalian $proskembali%</small>
			<div class='progress progress-xs'>
                            <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$proskembali'
                                 aria-valuemin='0' aria-valuemax='100' style='width: $proskembali%;'>
                            </div>
            </div>
			
			";
		?>
			
								<div class="form-group">
									<label class="control-label col-sm-4">Tanggal</label>
									<div class="col-sm-8"><input type="text" name="tgl_transaksi" id="tgl_transaksi" class="form-control" 
										value="<?php echo date('Y-m-d');?>" required="required" autocomplete="off" placeholder="-- Tanggal Transaksi --"> </div>
								</div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Pokok</label>
                                    <div class="col-sm-8">
										<input value="<?php echo $nunggakpokok;?>" onkeyup="kalkulatorTambah(this.value,getElementById('jasa').value);" type="text" name="pokok" id="pokok" class="form-control text-align-right" 
									required="required" autocomplete="off" placeholder="Pokok">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jasa</label>
                                    <div class="col-sm-8">
										<input value="<?php echo $nunggakjasa;?>" onkeyup="kalkulatorTambah(this.value,getElementById('pokok').value);" type="text" name="jasa" id="jasa" class="form-control text-align-right" 
									required="required" autocomplete="off" placeholder="Jasa">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Denda</label>
                                    <div class="col-sm-8">
										<input value="0" type="text" name="denda" id="denda" class="form-control text-align-right" 
									required="required" autocomplete="off" placeholder="Denda">
                                    </div>
                                </div>
								<div class="text-align-right"><span id="result"></span></div>
								<input value="<?php echo $r['id'];?>" type="hidden" name="id_pinj" id="id_pinj"/>
								<input value="<?php echo $r['jenis_pp'];?>" type="hidden" name="jenis_pp" id="jenis_pp"/>
								<input type="hidden" name="tgl_pakai" id="tgl_pakai" value="<?php echo $tgl_pakai;?>"/>
								<div id="SuksesAngsur"></div>
								<button class="btn btn-inverse btn-rounded width-200 mt-sm pull-right" id="SimpanAngsuranIndividu"><i class="fa fa-paper-plane"></i> POSTING ANGSURAN</button>
							
									<script>
									function kalkulatorTambah(pokok,jasa){
									var hasil = eval(pokok) + eval(jasa);
									document.getElementById("result").innerHTML = hasil;
									}
									</script>

				
<?php				
}else{
echo"
<div class='widget'>
	<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
                    Silahkan scan barcode NIK atau pilih Pemanfaat!
                </div>
</div> ";
}
?>