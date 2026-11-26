<?php session_start();
$sT=$_GET['sT'];
$vL=$_GET['vL_i'];

if($sT=="P"){
	$sebutan="PROPOSAL";
	$status="MENUNGGU REKOMENDASI ANALIS";
	$nama="proposal";
	$kolom="<th class='hidden-xs'>Proposal</th>";
	$jumlahdok	=$jum_prop_i;
}elseif($sT=="V1"){
	$sebutan="PROPOSAL";
	$status="VERIFIED ANALIS";
	$nama="Verified";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Rekomendasi</th>";
	$jumlahdok	=$jum_ver1_i;
}elseif($sT=="V2"){
	$sebutan="PROPOSAL";
	$status="APROVED KEPALA";
	$nama="APROVED";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Aproved</th>";
	$jumlahdok	=$jum_ver2_i;
}elseif($sT=="V3"){
	$sebutan="PROPOSAL";
	$status="APROVED BAWAS";
	$nama="APROVED";
	$kolom="<th class='hidden-xs'>Pengajuan</th><th class='hidden-xs'>Aproved</th>";
	$jumlahdok	=$jum_ver3_i;
}elseif($sT=="W"){
	$sebutan="PROPOSAL";
	$status="WAITING LIST";
	$nama="tunggu";
	$kolom="<th class='hidden-xs'>Pengajuan</th><th class='hidden-xs'>Alokasi</th>";
	$jumlahdok	=$jum_wait_i;
}elseif($sT=="A"){
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="Cair";
	$kolom="<th class='hidden-xs'>Alokasi</th><th class='hidden-xs'>Saldo</th>";
	$jumlahdok	=$jum_akt_i;
}
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
		<h3><i class="glyphicon glyphicon-user"></i> <?php echo "<span class='fw-normal'>$jumlahdok $sebutan $status</span>";?> 
			<span class="pull-right">
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			</span>
		</h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk Detail Pinjaman </span>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<?php
			$sts=$_GET['s'];
			if($sts=="ok"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Verifikasi Berhasil, </strong>dan siap diproses lebih lanjut.
			</div>
			<?php } elseif($sts=="suksesWL"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Proposal Berhasil masuk ke Waiting List, </strong>anda dapat mencetak Dokumen Pencairan melalui menu Waiting List
			</div>
			<?php } elseif($sts=="suksesVU"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Proposal Berhasil diubah menjadi P, </strong>dan telah dikirim kembali ke Tim Verifikasi untuk di Verifikasi Ulang
			</div>
			<?php } elseif($sts=="suksesC"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Pinjaman berhasil dicairkan, </strong>dan jurnal transaksi pencairan telah dibuat otomatis
			</div>
			<?php } elseif($sts=="suksesRC"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Rescedulling Pinjaman berhasil !</strong>dan SPK baru telah kami buat.
			</div>
			<?php } ?>
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>LOAN ID</th>
                            <th>TGL <?php echo $nama; ?></th>
                            <th class="hidden-xs">NIK</th>
                            <th class="hidden-xs">Nama Debitur</th>
                            <th class="hidden-xs">Alamat</th>
							<?php echo $kolom;?>
                            <th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						include "inc/inc.koneksi.php";
						include "inc/fungsi_pinjaman_individu.php";
						$view=mysql_query("SELECT * FROM
																desa d, anggota_$_SESSION[kd_kab] a, status_pinjaman st, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																d.id=a.desa AND a.id=pi.nia AND st.kd_status=pi.status AND a.desa='$_SESSION[lokasi]' AND pi.status='$sT' order by pi.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$sts			=$row['status'];
								
								$dpr 		= explode("#", $row['data_proposal']);
								$v1 		= explode("#", $row['data_verifikasi_analis']);
								$v2 		= explode("#", $row['data_verifikasi_kepala']);
								$v3 		= explode("#", $row['data_verifikasi_bawas']);
								$dt 		= explode("#", $row['data_waiting']);

									if($sts=="P"){
										$tgl=$dpr[0];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($dpr[1])."</td>";
									}elseif($sts=="V1"){
										$tgl=$v1[0];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($dpr[1])."</td>
													  <td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($v1[1])."</td>";
									}elseif($sts=="V2"){
										$tgl=$v2[0];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($dpr[1])."</td>
													  <td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($v2[1])."</td>";
									}elseif($sts=="V3"){
										$tgl=$v3[0];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($dpr[1])."</td>
													  <td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($v3[1])."</td>";
									}elseif($sts=="W"){
										$tgl=$dt[0];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($dpr[1])."</td>
													  <td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="A"){
										$tgl=$row['tgl_cair'];
										$isi_kolom	="<td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($row['alokasi'])."</td>
													  <td class='subject fw-normal hidden-xs text-align-right' width='15%'>".number_format($saldopinjaman)."</td>";
									}
									
									?>
						
						<?php echo "<tr style='cursor: pointer;' href='#' data-toggle='modal' data-target='#myModalDetailProposalIndividu' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' >"; ?>
							<td><span class="toggle badge bg-default"><?php echo $no;?></span></td>
							<td class="subject fw-normal hidden-xs" width="10%"><?php echo $row['id'];?></td>
							<td class="subject fw-normal hidden-xs" width="14%"><?php echo $tgl;?></td>
							<td class="subject fw-normal hidden-xs" width="14%"><?php echo $row['nik'];?></td>
							<td class="name fw-normal hidden-xs" width="30%"><?php echo strtoupper($row['namadepan']);?></td>
							<td class="subject fw-normal hidden-xs" width="14%"><?php echo $row['alamat'];?></td>
							<?php echo $isi_kolom;?>
							<td class="subject hidden-xs" width="10%"><span class="label label-<?php echo $row['warna_status'];?> pull-right"><?php echo $row['nama_status'];?></span></td>
                        </tr>
						 
						 
						 
						
								<?php } ?>
						
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
