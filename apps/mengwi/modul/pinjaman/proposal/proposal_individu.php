<?php session_start();
$sT=$_GET['sT'];
$vL=$_GET['vL_i'];


if($sT=="P"){
	$sebutan="PROPOSAL";
	$status="MENUNGGU VERIFIKASI";
	$nama="proposal";
	$kolom="<th class='hidden-xs'>Proposal</th>";
	$jumlahdok	=$jum_prop_i;
	$wR="pi.status='P'";
}elseif($sT=="V"){
	$sebutan="PROPOSAL";
	$nama="verifikasi";
	$status="VERIFIED";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Verifikasi</th>";
	$jumlahdok	=$jum_ver_i;
	$wR="pi.status='V'";
}elseif($sT=="W"){
	$sebutan="PROPOSAL";
	$status="WAITING LIST";
	$nama="tunggu";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Hasil<br>Verifikasi</th><th class='hidden-xs'>Alokasi</th>";
	$jumlahdok	=$jum_wait_i;
	$wR="pi.status='W' OR d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp AND a.lokasi='$_SESSION[lokasi]' AND pi.jenis_pinjaman='I' AND pi.status='D'";
}elseif($sT=="A"){
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="cair";
	$kolom="<th class='hidden-xs'>Alokasi</th><th class='hidden-xs'>Saldo</th>";
	$jumlahdok	=$jum_akt_i;
	$wR="pi.status='A'";
}
?>
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
		var id = ID;
		$.ajax({
			type	: "POST",
			<?php if ($_SESSION['level']=='1'){ //UPK ?>
			url		: "modul/pinjaman/proposal/detail_proposal_individu.php",
			<?php }elseif ($_SESSION['level']=='4'){ //TV ?>
			url		: "modul/pinjaman/verifikasi/detail_verifikasi_individu.php",
			<?php }elseif ($_SESSION['level']=='5'){ //dana ?>
			url		: "modul/pinjaman/pendanaan/detail_pendanaan_individu.php",
			<?php } ?>
			data	: "id="+id,			  
			success	: function(data){
				$('#tabp2').html(data);
				
			}
		});
		
	}
	
</script>
<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="glyphicon glyphicon-user"></i> <?php echo "$jumlahdok $sebutan $status";?> 
			<span class="pull-right">
			<?php if ($_SESSION['level']=='1' and $sT=="P"){	//UPK ?>
				<!--<a href="?p=p1" class="btn btn-success width-200"><i class="fa fa-plus-circle"></i> Tambah Proposal</a>-->
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php }else{ ?>
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php } ?>
			</span>
		</h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk CRED Proposal dan Anggota |&nbsp;
			<?php
			$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
				while($pp=mysql_fetch_array($dpp)){
				    if ($pp['nama_jpp'] != 'PU') continue;
				echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
				}
			?>
			</span>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-success text-white">
                        <tr>
                            <th>#</th>
                            <th>LOAN ID</th>
                            <th>TGL <?php echo $nama; ?></th>
                            <th class="hidden-xs">NIK</th>
                            <th class="hidden-xs">Nama Debitur</th>
                            <th class="hidden-xs">Desa</th>
							<?php echo $kolom;?>
                            <th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						include "inc/inc.koneksi.php";
						include "inc/fungsi_pinjaman_individu.php";
						$view=mysql_query("SELECT * FROM
																 users u, desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp AND u.lokasi=$_SESSION[lokasi] AND u.id=pi.user_id AND pi.jenis_pinjaman='I' AND $wR  order by tgl_proposal asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
								$sts			=$row['status'];

									if($sts=="P"){
										$tgl=$row['tgl_proposal'];
										$isi_kolom	="<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($row['proposal'])."</td>";
									}elseif($sts=="V"){
										$tgl=$row['tgl_verifikasi'];
										$isi_kolom	="<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($row['proposal'])."</td>
													  <td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($row['alokasi'])."</td>";
									}elseif($sts=="W" OR $sts=="D"){
										if($sts=="D"){$status="FUNDED";}else{$status="WAITING LIST";}
										$tgl=$row['tgl_tunggu'];
										$isi_kolom	="<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($row['proposal'])."</td>
													  <td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".@(number_format($row['verifikasi']))."</td>
													  <td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".@(number_format($row['alokasi']))."</td>";
									}elseif($sts=="A"){
										$tgl=$row['tgl_cair'];
										$isi_kolom	="<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($row['alokasi'])."</td>
													  <td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".number_format($saldopinjaman)."</td>";
									}
						echo "
						<tr>
                            <td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>$row[id]</td>
							<td class='subject hidden-xs' width='14%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>$tgl</td>
							<td class='subject hidden-xs' width='14%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>$row[nik]</td>
							<td class='name hidden-xs' width='30%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>".strtoupper($row['namadepan'])."</td>
							<td class='subject hidden-xs' width='14%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'>$row[nama_desa]</td>
							$isi_kolom
							<td class='subject hidden-xs' width='15%' href='#tabp2' onclick='javascript:DetailProposalIndividu(\"{$row['id']}\")' data-toggle='tab'><span class='label label-$row[warna_jpp] pull-right'>$status</span></td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
            </div>
			<?php
			$sts=$_GET['s'];
			if($sts=="ok"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Verifikasi Berhasil, </strong>dan telah dikirim kembali ke UPK untuk diproses lebih lanjut.
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
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposalIndividu"></div>
        </div>
    </div>
	</div>
</section>
