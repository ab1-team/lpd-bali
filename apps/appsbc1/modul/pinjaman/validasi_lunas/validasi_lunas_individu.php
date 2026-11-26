<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
function DetailProposalIndividu(ID){
		var idp = ID;
		$.ajax({
			type	: "POST",
			url	:"modul/pinjaman/proposal/detail_proposal_individu.php",
			data	: "idp="+idp,
			success: function(data) {
				$("#TampilDetailProposalIndividu").html(data);
			}
		});
		
	}
	
</script>
<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="glyphicon glyphicon-user"></i> <?php echo "PINJAMAN ANGGOTA DENGAN SALDO NOL (0)";?> </h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk Validasi Lunas</span>
			<?php
			if($_GET['s']=="suksesVL"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Validasi Lunas Berhasil, </strong>status Anggota tersebut menjadi L dan dapat mencairkan pinjaman kembali.
			</div>
			<?php } ?>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>LOAN ID</th>
                            <th>TGL CAIR</th>
                            <th class="hidden-xs">Debitur</th>
                            <th class="hidden-xs">Alokasi</th>
                            <th class="hidden-xs">PENGEMBALIAN</th>
                            <th class="hidden-xs">saldo</th>
                            <th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						include "inc/inc.koneksi.php";
						include "inc/fungsi_pinjaman_individu.php";
						$views=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
								WHERE a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' AND pi.status='A' order by tgl_cair asc");
								$no=0;
								while($rows=mysql_fetch_array($views)){
								$idpinj			=$rows['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
						
					if ($saldopinjaman<=0) {
							$kel=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
								WHERE d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp and pi.id=$idpinj ");
									while($row=mysql_fetch_array($kel)){
									$no=$no+1;
									$id_pinj	=$row['id'];
									$sumpok		=sumpokok("$tgl_now-$id_pinj");
								
						echo "
						<tr style='cursor: pointer;' href='#' data-toggle='modal' data-target='#myModalDetailProposalIndividu' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' >
							<td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='10%'>$row[id]</td>
							<td class='subject hidden-xs' width='10%'>$row[tgl_cair]</td>
							<td class='name hidden-xs' width='50%'>$row[nik] - ".strtoupper($row['namadepan'])." ".strtoupper($row['nama_desa'])."</td>
							<td class='subject hidden-xs' width='10%'>".number_format($row['alokasi'])."</td>
							<td class='subject hidden-xs' width='10%'>".number_format($sumpok)."</td>
							<td class='subject hidden-xs' width='10%'>".number_format($saldopinjaman)."</td>
							<td class='subject hidden-xs' width='5%'><span class='label label-$row[warna_jpp] pull-right'>LUNAS</span></td>
                        </tr> ";
						 } } }?>
                        </tbody>
                    </table>
            </div>
			
        </div>
    </div>
	</div>
</section>

<div class="modal fade" id="myModalDetailProposalIndividu" tabindex="" role="dialog" aria-labelledby="LabelDetailProposalIndividu" aria-hidden="true">
	<div class="modal-content">
		<div id="TampilDetailProposalIndividu"></div>
	</div>
</div>