<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";


$kd_rekening	= $_SESSION['rekening_1'];
$tgl=date('Y-m-d');
$saldo_rekening	=saldoR("$tgl-$kd_rekening");

$nama_rekening=namarek($kd_rekening);

if($saldo_rekening>0) {
$ketsaldo="Saldo Debet";
}elseif($saldo_rekening<0){
$ketsaldo="Saldo Kredit";
}else{
$ketsaldo="Tidak Ada Saldo";
}

?>
<section class="widget" style="border: 1px solid #5d8fc2;">
	<div class="widget-body">
		<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
			<div class="row">
				<div class="col-md-6">
					<span class="h2 text-white fw-semi-bold"><?php echo $nama_rekening;?></span>
				</div>
				<div class="col-md-6">
									<div class="form-group">
											<div class="input-group input-group-no-border mb-n-md">
											<span class="input-group-addon">
												<i class="fa fa-search"></i>
											</span>
												<input class="form-control" id="IdTransaksi" type="text" placeholder="Search ID Transaksi disini, lalu enter">
											</div>
										</div>
								</div>
			</div>
		</div>
		<div class="h1"><?php echo $ketsaldo;?><span class="pull-right fw-semi-bold"><?php echo number_format($saldo_rekening,0,',','.');?></span></div>
		<hr>
		<div class="row">
				<div id="CariTransaksi"></div>
		</div>
	</div>
</section>

<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
	
				document.querySelector('#IdTransaksi').addEventListener("keyup", function(event)
				{
					if (event.keyCode === 13) 
					{
						var id_trx		= $("#IdTransaksi").val();
								
						$.ajax({
							type: "POST",
							url: "modul/jurnal/cari_transaksi.php",
							data: 	"id_trx="+id_trx,
									
							success: function(data) {
								$("#CariTransaksi").html(data);
							}
						});
					}
				});

				
});

 ]]>

</script>
						