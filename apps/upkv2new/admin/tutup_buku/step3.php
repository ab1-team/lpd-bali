<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_admin.php";

$tgl_kondisi		="$_SESSION[tahunbuku]-12-31";
$surplus_bersih		=surplus($tgl_kondisi);
	
$_SESSION['surplus_bersih']=$surplus_bersih;

$tbtahunlalu		=$_SESSION['tahunbuku']-1;
$tgl_kondisialu		="$tbtahunlalu-12-31";

$sditlalu			=saldoR("$tgl_kondisialu-321");

$all_surplus		=$sditlalu+$surplus_bersih;
$_SESSION['all_surplus']=$all_surplus;

$maarif				=floor($surplus_bersih*50/100);
$santoso			=floor($surplus_bersih*50/100);

$surdit				=$all_surplus-$maarif-$santoso; //surdit belum termasuk penambahan modal
$_SESSION['surdit']	=$surdit;
?>

        <script type="text/javascript">
			$(document).ready(function() {
			
				
				$("#SimpanSurplus").click(function() {
                    var maarif = $('#maarif').val();
                    var santoso = $('#santoso').val();
                    $.ajax({
                        type: "POST",
                        url: "admin/tutup_buku/update_surplus.php",
                        data:"maarif="+maarif+
								"&santoso="+santoso,
                        
						success: function(data) {
                            $("#SuksesUPS").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				$("#maarif").keyup(function() {
					var maarif 		= $('#maarif').val();
                    var santoso		= $('#santoso').val();
                    var shu_ditahan 	= $('#shu_ditahan').val();
					
						$.ajax({
						type	: "POST",
						url		: "admin/tutup_buku/update_surplus.php",
						data:"maarif="+maarif+
								"&santoso="+santoso,
						success: function(data) {
							$("#SuksesEdit1").load('admin/tutup_buku/sukses_edit.php');

							}
						});
					});
					
					$("#santoso").keyup(function() {
					var maarif = $('#maarif').val();
                    var santoso		 = $('#santoso').val();
                    var shu_ditahan 	= $('#shu_ditahan').val();
					
						$.ajax({
						type	: "POST",
						url		: "admin/tutup_buku/update_surplus.php",
						data:"maarif="+maarif+
								"&santoso="+santoso,
						success: function(data) {
							$("#SuksesEdit2").load('admin/tutup_buku/sukses_edit.php');

							}
						});
					});
					

				
            });
			

        </script>
		
<legend class="h4"><strong> Step 3 :</strong>  Sharing Profit <?php echo $_SESSION['tahunbuku'];?></legend>
<div class="row">
	<div class="col-sm-8">
		

		<div class="form-group">
			<label class="col-sm-4 control-label">Bapak Ma'arif</label>
			<label class="col-sm-4 control-label"><?php echo number_format($all_surplus). " x 50 %";?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="maarif" name="maarif" value="<?php echo $maarif;?>" 
					required="required" autocomplete="off" placeholder="Sharing Profit Bapak Ma'arif">
				
            </div>
            <div class="col-sm-1">
				<div id="SuksesEdit1"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label">Bapak Santoso</label>
			<label class="col-sm-4 control-label"><?php echo number_format($all_surplus). " x 50 %";?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="santoso" name="santoso" value="<?php echo $santoso;?>" 
					required="required" autocomplete="off" placeholder="Sharing Profit Bapak Santoso">
            </div>
			<div class="col-sm-1">
				<div id="SuksesEdit2"></div>
			</div>
		</div>
		
		<div id="SuksesUPS"></div>


	</div>
	
	<div class="col-md-4">
		<div class="alert alert-info animated fadeInDown">
			<legend><strong>Perhatian</strong></legend>
			<ol>
				<li>Isikan pembagian surplus sesuai dengan Alokasinya</li>
				<li>Angka tersebut disamping hanyalah angka rekomendasi, anda dapat merubahnya</li>
				<li>Klik tombol simpan jika Anda telah yakin dengan Sharing Profit</li>
				<li>Angka-angka tersebut akan automatis masuk ke Neraca bagian Passiva</li>
				<li>Anda dapat merubah dilain waktu jika ada kekeliruan, dengan mengulangi mulai step 1</li>
			</ol>
				<button type="button" class="btn btn-info input-lg" id="SimpanSurplus"><i class="glyphicon glyphicon-book text-white"></i> Simpan Sharing Profit</button>

		</div>
		
		
	</div>
</div>