<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];

$tgl_kondisi		="$_SESSION[tahunbuku]-12-31";
?>

<script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
	$(document).ready(function() {

                $("#ImportRekening").click(function() {
                    var tahunbuku = $('#tahunbuku').val();
					
						if(tahunbuku.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); $("#tahunbuku").focus(); return false; }

                    $.ajax({
                        type: "POST",
                        url: "modul/tutup_buku/update_kolom.php",
                        data: "tahunbuku="+tahunbuku,
                        success: function(data) {
							$("#TampilStep").load('modul/tutup_buku/step3.php');
                        }
                    });

                });
				
            });
				
 </script> 
 
<legend class="h4"><strong> Step 2 :</strong>  Import saldo Akhir rekening-rekening Neraca <?php echo tgl_indo($tgl_kondisi);?> menjadi saldo Awal Tahun <?php echo $_SESSION['tahunbuku']+1;?></legend>
<div class="row">
	<div class="col-md-4">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th>Aktiva</th>
					</tr>
				</thead>
				<tbody>
																		
				<?php
				$view=mysql_query("select * from rekening_riil WHERE posisi='1' ORDER by id ASC ");
					while($row=mysql_fetch_array($view)){
				$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'  OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
					echo "
					<tr>
						<td><strong>$row[nama_rr]</strong><br> ";
							while($r=mysql_fetch_array($data)){

							$saldo_aktiva=saldo("$tgl_kondisi-".$r['kd_jb']);
																							
							echo	"$r[kd_jb]. $r[nama_jb] <span class='pull-right'>".number_format($saldo_aktiva)."</span><br> ";
																						
							$aktiva=$aktiva+$saldo_aktiva;
							}
																					
						echo "
						</td>
					</tr> 
				";					
				}
				?>
																		
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th class="text-align-center bg-primary-light">Total Aktiva<span class="pull-right"><?php echo number_format($aktiva);?></span></th>
					</tr>
				</tfoot>
			</table>
		</div>									
	</div>

	<div class="col-md-4">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th>Passiva</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$view=mysql_query("select * from rekening_riil WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
					$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
						echo "
						<tr height='30'>
							<td><strong>$row[nama_rr]</strong><br> ";
								while($r=mysql_fetch_array($data)){

									$saldo_passiva=saldo("$tgl_kondisi-".$r['kd_jb'])*-1;
																																														
									echo	"$r[kd_jb]. $r[nama_jb] <span class='pull-right'>".number_format($saldo_passiva)."</span><br> ";
																																													
									$passiva=$passiva+$saldo_passiva;
								}
									echo "
							</td>
						</tr> 
							";					
						}
				?>
						<tr><td><strong>Surplus/Devisit Berjalan</strong><span class="pull-right"><?php echo number_format(surplus($tgl_kondisi));?></span></td></tr>
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th class="text-align-center bg-primary-light">Total Passiva<span class="pull-right"><?php echo number_format(surplus($tgl_kondisi)+$passiva);?></span></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<a href="javascript:;" onclick="MM_openBrWindow('modul/tutup_buku/c_detail_rekening.php?y=<?php echo $_SESSION['tahunbuku'];?>&m=12&d=31','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" type="button" class="btn btn-primary" >
			<i class="glyphicon glyphicon-print text-white"></i> Detail per Rekening</a>
	</div>

	<div class="col-md-4">
		<div class="alert alert-info animated fadeInDown">
			<legend><strong>Perhatian</strong></legend>
			<ol>
				<li>Jika saldo disamping belum Anda anggap sesuai, silahkan sesuaikan terlebih dahulu sesuai dengan transaksi-transaksinya, baik melalui jurnal umum, jurnal khusus, maupun penyesuaian.</li>
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/tutup_buku/c_detail_rekening.php?y=<?php echo $_SESSION['tahunbuku'];?>&m=12&d=31','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > Klik disini</a> untuk melihat detail saldo per rekening</li>
				<li>Saldo-saldo tersebut akan menjadi saldo Awal Tahun <?php echo $_SESSION['tahunbuku']+1;?></li>
				<li>Jika telah sesuai, klik import dan lanjutkan</li>
			</ol>
				
				<input type="hidden" id="tahunbuku" name="tahunbuku" value="<?php echo $_SESSION['tahunbuku'];?>" >
				<button type="button" class="btn btn-info input-lg" id="ImportRekening"><i class="glyphicon glyphicon-book text-white"></i> Import dan Lanjutkan Tutup Buku</button>

		</div>
	</div>
	
</div>

