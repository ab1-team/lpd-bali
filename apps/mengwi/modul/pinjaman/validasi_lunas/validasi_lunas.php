<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	function DetailProposal(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/pinjaman/proposal/detail_proposal.php",
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
		<h3><i class="fa fa-users"></i> <?php echo "$jum_lns PINJAMAN DENGAN SALDO NOL (0)";?> </h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk Validasi Lunas |&nbsp;
			<?php
			$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
				while($pp=mysql_fetch_array($dpp)){
				echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
				}
			?>
			</span>
			<?php
			if($_GET['s']=="suksesVL"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Validasi Lunas Berhasil, </strong>status kelompok tersebut menjadi L dan dapat dicairkan kembali.
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
                            <th class="hidden-xs">KELOMPOK</th>
                            <th class="hidden-xs">Alokasi</th>
                            <th class="hidden-xs">PENGEMBALIAN</th>
                            <th class="hidden-xs">saldo</th>
                            <th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						include "inc/inc.koneksi.php";
						include "inc/fungsi_pinjaman.php";
						$views=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
								WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' order by tgl_cair asc");
								$no=0;
								while($rows=mysql_fetch_array($views)){
								$idpinj			=$rows['id'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_now-$idpinj");
						
					if ($saldopinjaman<=0) {
							$kel=mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
								WHERE d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp and pk.id=$idpinj ");
									while($row=mysql_fetch_array($kel)){
									$no=$no+1;
									$id_pinj	=$row['id'];
									$sumpok		=sumpokok("$tgl_now-$id_pinj");
								
						echo "
						<tr>
							<td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>$row[id]</td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>$row[tgl_cair]</td>
							<td class='name hidden-xs' width='50%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>$row[kd_kelompok] - ".strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa'])."</td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>".number_format($row['alokasi'])."</td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>".number_format($sumpok)."</td>
							<td class='subject hidden-xs' width='10%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'>".number_format($saldopinjaman)."</td>
							<td class='subject hidden-xs' width='5%' href='#tabp2' onclick='javascript:DetailProposal(\"{$row[id]}\")' data-toggle='tab'><span class='label label-$row[warna_jpp] pull-right'>LUNAS</span></td>
                        </tr> ";
						 } } }?>
                        </tbody>
                    </table>
            </div>
			
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposal"></div>
        </div>
    </div>
	</div>
</section>