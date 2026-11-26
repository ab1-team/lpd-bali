<?php session_start();
$sT="A";
$vL=$_GET['vL'];
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="pencairan";
	$kolom="";
	$jumlahdok	=$jum_akt;
	$wR="pk.status='A'";
	$js="2";
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
	
	function DetailProposal(ID){
		var ids = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/simpanan_deposito/detail_simpanan_deposito.php",
			data	: "ids="+ids,			  
			success	: function(data){
				$('#tabp2').html(data);
				
			}
		});
		
	}
	
</script>
<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="fa fa-users"></i> <?php echo "SIMPANAN DEPOSITO";?> 
			<span class="pull-right">
			
						<a href="2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=HBd" target="_blank" id="TampilHitungBunga" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Perhitungan Bulanan</a>
		                <a href="javascript:;" onclick="MM_openBrWindow('/modul/simpanan/cs/s_CetakDeposito.php?&js=<?php echo $js;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success "><i class="glyphicon glyphicon-print"></i> Cetak</a>
			</span>
               <!-- <span class="fs-mini"><br><b>Keterangan :</b> Klik untuk melihat detail simpanan | &nbsp;
				</span>-->
				<span class="sub_title" style="color:red"><br><b>Peringatan :</b> Mohon menunggu untuk Menu Simpanan Deposito masih dalam proses perbaikan ...  &nbsp;
				</span></h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>Tgl Buka</th>
                            <th>NOREK</th>
                            <th class="hidden-xs">Nama Kreditur</th>
                            <th class="hidden-xs">Saldo</th>
                            <th class="hidden-xs">Tempo</th>
                            <th class="hidden-xs">Bunga</th>
                            <th class="hidden-xs">target</th>
                            <th class="hidden-xs">Paid</th>
                            <th class="hidden-xs">UNPaid</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						include "inc/inc.koneksi.php";
						include "inc/fungsi_simpanan_individu.php";
						$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, jenis_simpanan js, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND si.jenis_simpanan=js.id AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.jenis_simpanan='2' order by si.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idsimp			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$tempo          =$row['jangka'];
								$bunga          =$row['pros_jasa'];
								$sumambil		=sumambil("$tgl_now-$idsimp");
								$sumnabung		=sumnabung("$tgl_now-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_now-$idsimp");
								$bulanke		=bulankeSD("$tgl_now-$idsimp");
								$targetbungaSD	=targetbungaSD("$tgl_now-$idsimp");
								$bungapaidSD	=bungapaidSD("$tgl_now-$idsimp");
								$bungaunpaidSD	=$targetbungaSD-$bungapaidSD;
								$sts			=$row['status'];
								if($row['lembaga']==NULL or $row['lembaga']==''){
								$nama			=$row['namadepan'];
								}else{
								$nama			= "$row[namadepan] QQ $row[lembaga]" ;	
								}
						echo "
						<tr>
                            <td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$row[id]</td>
							<td class='subject hidden-xs' width='14%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$row[tgl_buka]</td>
							<td class='subject hidden-xs' width='14%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$row[nomor_rekening]</td>
							<td class='name hidden-xs' width='30%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$nama</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>".number_format($saldosimpanan)."</td>
							<td class='subject hidden-xs text-align-center' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$tempo bln</td>
							<td class='subject hidden-xs text-align-center' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>$bunga %</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>".number_format($targetbungaSD)."</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>".number_format($bungapaidSD)."</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'>".number_format($bungaunpaidSD)."</td>
							<td class='subject hidden-xs' width='15%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row['id']}\")' data-toggle='tab'><span class='label label-warning pull-right'>$status</span></td>
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
			<?php } elseif($sts=="suksesRS"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Rescedulling Pinjaman berhasil !</strong>dan SPK baru telah kami buat.
			</div>
			<?php } elseif($sts=="suksesPH"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-times"></i><strong> Penghapusan Pinjaman berhasil !</strong>pinjaman berubah menjadi H dan Transaksi Penghapusan telah dibuat.
			</div>
			<?php } ?>
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposal"></div>
        </div>
    </div>
	</div>
</section>