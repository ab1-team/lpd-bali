<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_simpanan_individu.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$ids	=$_SESSION['ids']; //Diambil dari file modul/simpanan/detail_simpanan_individu.php

$table_transaksi	="transaksi_$_SESSION[lokasi]";
$table_rekening		="rekening_$_SESSION[lokasi]";

$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
                                $js     = $sa['jenis_simpanan'];
                        if($js==1){
                            $kd_jb  = 221;
                        }else if($js==3){
                            $kd_jb  = 223;
                        }else{
                            $kd_jb  = 222;
                        }
								$wrek1  = jenisrek("1-$js");
$text	= "SELECT * FROM $table_transaksi WHERE $wrek1 AND id_simp_i='$ids' ORDER BY tgl_transaksi ASC, idt ASC";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

	if ($rows>0){
		

?>					
	
                <div class="table-responsive">
						<table id="datatable-table" class="table table-hover fs-mini fw-normal">
							<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Keterangan</th>
								<th>Kd.Trx</th>
								<th class="text-align-right">Debit (Tarik)</th>
								<th class="text-align-right">Kredit (Setor)</th>
								<th class="text-align-right">Saldo</th>
								<th>P</th>
								<th class="hidden-print">&nbsp;</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$no=0;
									while($row=mysql_fetch_array($sql)){
									$no=$no+1;
									
									$rek=mysql_num_rows(mysql_query("select * from rekening_$_SESSION[lokasi] where kd_jb=$kd_jb AND kd_rekening=$row[rekening_kredit] "));
									
									if(jenisrek("2-$js")) {$file="c_bkm";} else {$file="c_bkk";}
									
										if($rek>0) {
											$debit	="0";
											$kredit	=$row['jumlah'];
										}else{
											$debit	=$row['jumlah'];
											$kredit	="0";
											}
											
									$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));		

							echo "
							<tr>
								<td>$no</td>
								<td>$row[tgl_transaksi]</td>
								<td>$row[keterangan_transaksi]</td>
								<td class='text-align-center'>$row[idt]</td>
								<td class='text-align-right'>".number_format($debit)."</td>
								<td class='text-align-right'>".number_format($kredit)."</td>
								<td class='text-align-right'>"; $prasaldo=$kredit-$debit; $saldosamping=$saldosamping+$prasaldo; echo "".number_format($saldosamping)." </td>
								<td>$r[ins]</td>
								<td class='hidden-print'>";
								?>
								<ul class="tags mb-0 text-primary">
									<li><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi' onclick="MM_openBrWindow('modul/simpanan/cs/kwitansi.php?&idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print"></i> 
									</a><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Buku Tabungan' onclick="MM_openBrWindow('modul/simpanan/cs/s_CetakPadaBuku.php?&idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-bookmark"></i></i> 
									</a></li>
								</ul>
								<?php echo "
								</td>
							</tr> ";
							 }
							 
							 ?>
							</tbody>
						</table>
					</div>
	
<?php
}else{
?>

<div class="alert alert-info animated fadeInDown">
    <h3 class="text-align-center">
		<i class="glyphicon glyphicon-comment"></i> Belum ada transaksi pada simpanan ini! <?php echo $id_simp_i;?>
	</h3>
</div>

<?php
}
?>