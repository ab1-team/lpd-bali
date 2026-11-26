<?php session_start(); 
$lokasi				=$_SESSION['lokasi'];
?>
	
	<div class="alert alert-info animated fadeInDown">
			<header>
				<legend><i class="fa fa-book"></i> Jurnal Awal</legend>
					<div class="widget-controls">
						<a href="#" id="print"><i class="glyphicon glyphicon-print hidden-print"></i></a>
					</div>
			</header>
                        <div class="table-responsive">
							<table width="100%" class="table table-hover">
								<thead class="bg-info text-white">
								<tr>
								  <th width="2%" rowspan="2">No</th>
								  <th width="2%" rowspan="2">Ins</th>
								  <th width="5%" rowspan="2">Kode Rekening</th>
								  <th width="40%" rowspan="2">Nama Rekening</th>
								  <th width="5%" rowspan="2">Kode Jurnal</th>
								  <th colspan="2">Data Awal </th>
								  <th colspan="2">Keterangan </th>
								  </tr>
								<tr>
									<th width="10%">Th.Lalu</th>
									<th width="10%">Bulan Lalu</th>
									<th width="5%">Pos</th>
									<th width="5%">Mut</th>
								</tr>
								</thead>
								<tbody>
								<?php
								include "../../inc/inc.koneksi.php";
								$table_rekening		="rekening_".$lokasi;
								$view=mysql_query("select * from jenis_buku jb, $table_rekening r WHERE jb.kd_jb=r.kd_jb ORDER by kd_rekening ASC ");
									$no=0;
									while($row=mysql_fetch_array($view)){
									$no=$no+1;
									$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan where id='$lokasi' "));
									$tgl_pakai=$kec['tgl_pakai'];
									$thn_pakai=substr($tgl_pakai,0,4);
									$thn_lalu=$thn_pakai-1;
									$kolom="tb".$thn_lalu;

									if($row['posisi']=='1') { $posisi="Nrc"; }else{$posisi="RL";}
								echo "
								<tr>
									<td>$no</td>
									<td><strong>$row[ins]</strong></td>
									<td>$row[kd_rekening]</td>
									<td>$row[nama_rekening]</td>
									<td>$row[pasangan]</td>
									<td class='text-align-right'>".number_format($row[$kolom])."</td>
									<td class='text-align-right'>".number_format($row['awal'])."</td>
									<td>$posisi</td>
									<td>$row[jenis_mutasi]</td>
								</tr> "; ?>
								
								
								<?php
								  }
								  ?>
								</tbody>
							</table>
						</div>
			</div>
