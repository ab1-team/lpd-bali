<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
?>
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
</script>	
	<div class="alert alert-info animated fadeInDown">
			<header>
				<legend><i class="fa fa-exchange"></i> List Jurnal Transaksi</legend>
					<div class="widget-controls">
						<a href="#" id="print"><i class="glyphicon glyphicon-print hidden-print"></i></a>
					</div>
			</header>
                        <div class="table-responsive">
							<table width="100%" class="table table-hover">
								<thead class="bg-primary text-white">
								<tr>
								  <th width="2%">No</th>
								  <th width="5%">Tgl</th>
								  <th width="5%">Kd.Trx</th>
								  <th width="43%">Keterangan Transaksi</th>
								   <th width="12%">Kd Debit</th>
								  <th width="13%">Kd Kredit</th>
								  <th width="20%" class="text-align-right">Jumlah</th>
								  </tr>
								</thead>
								<tbody>
								<?php 
								
								$table_transaksi		="transaksi_".$_SESSION['lokasi'];
								$tgla	=date('Y-m-01');
								$tglb	=date('Y-m-t');
								$view=mysql_query("select * from $table_transaksi WHERE tgl_transaksi between '$tgla' AND '$tglb' ORDER by tgl_transaksi, idt ASC ");
									$no=0;
									while($row=mysql_fetch_array($view)){
									$no=$no+1;
								echo "
								<tr>
									<td>$no</td>
									<td>$row[tgl_transaksi]</td>
									<td>$row[idt]</td>
									<td>$row[keterangan_transaksi]</td>
									<td class='text-align-center'><a href='' data-toggle='tooltip' data-placement='top' title='".namarek($row['rekening_debit'])."'>$row[rekening_debit]</a></td>
									<td class='text-align-center'><a href='' data-toggle='tooltip' data-placement='top' title='".namarek($row['rekening_kredit'])."'>$row[rekening_kredit]</a></td>
									<td class='text-align-right'>".number_format($row['jumlah'])."</td>
								</tr> ";
								  }
								  ?>
								</tbody>
							</table>
						</div>
			</div>
