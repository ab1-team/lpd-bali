<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_simpanan_individu.php";

$tahun	=$_POST['tahun'];
$bulan	=$_POST['bulan'];
$tglkondisi1	=date('Y-m-d');
$tglkondisi2	="$tahun-$bulan-31";


if(empty($bulan)){ $tgl_kondisi=$tglkondisi1; }else{ $tgl_kondisi=$tglkondisi2; }
?>
<head>
	<script>
		$(document).ready(function(){
		  $(".preloader").fadeOut("slow");
		})
	</script>
</head>
<div class="preloader">
	<div class="loading">
		<img src="images/animation.gif" width="280">
	</div>
</div>
<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
function DetailSimpananIndividu(ID){
		var ids = ID;
		$.ajax({
			type	: "POST",
			url	:"modul/simpanan/detail_simpanan_individu.php",
			data	: "ids="+ids,
			success: function(data) {
				$("#TampilDetailSimpananIndividu").html(data);
			}
		});
		
	}

	
</script>

			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>Tgl Buka</th>
                            <th>NOREK</th>
                            <th class="hidden-xs">Nama Kreditur</th>
                            <th class="hidden-xs">Debit</th>
                            <th class="hidden-xs">Kredit</th>
                            <th class="hidden-xs">Saldo</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.jenis_simpanan='1' AND si.tgl_buka<='$tgl_kondisi' order by si.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idsimp			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$sumnabung		=sumnabung("$tgl_now-$idsimp");
								$sumambil		=sumambil("$tgl_now-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_now-$idsimp");
								$sts			=$row['status'];
								
									?>
						
						<?php echo "<tr style='cursor: pointer;' href='#' data-toggle='modal' data-target='#myModalDetailSimpananIndividu' onclick='javascript:DetailSimpananIndividu(\"{$row['id']}\")' >"; ?>
							<td><span class="toggle badge bg-default"><?php echo $no;?></span></td>
							<td class="subject fw-normal hidden-xs"><?php echo $row['id'];?></td>
							<td class="subject fw-normal hidden-xs"><?php echo tgl_ind($row['tgl_buka']);?></td>
							<td class="subject fw-normal hidden-xs"><?php echo $row['nomor_rekening'];?></td>
							<td class="name fw-normal hidden-xs"><?php echo strtoupper($row['namadepan']);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($sumambil);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($sumnabung);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($saldosimpanan);?></td>
							<td class="text-align-center"><span class="label label-<?php echo $row['warna_status'];?>"><?php echo $row['nama_status'];?></span></td>
                        </tr>
						 
						 
						 
						
								<?php } ?>
                        </tbody>
                    </table>
					<center class="fs-mini text-muted">* Klik untuk Detail Simpanan </center>
            </div>


<div class="modal fade" id="myModalDetailSimpananIndividu" tabindex="" role="dialog" aria-labelledby="LabelDetailSimpananIndividu" aria-hidden="true">
	<div class="modal-content">
		<div id="TampilDetailSimpananIndividu"></div>
	</div>
</div>	
