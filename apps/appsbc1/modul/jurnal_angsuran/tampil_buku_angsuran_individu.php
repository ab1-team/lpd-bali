<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";
include "../../inc/fungsi_indotgl.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj	=$_SESSION['id_pinj'];
$text	= "SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t WHERE 
a.id=pi.nia AND pi.id=substring(t.rekening_debit,9) AND rekening_debit='1-10005_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='1-10005_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60001_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60002_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60003_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60004_$id_pinj' 
ORDER BY t.tgl_transaksi  ";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

$r		=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia  AND pi.id='$id_pinj' "));

	
$alokasi		=alokasi($id_pinj);
$alokasi_jasa	=alokasi_jasa($id_pinj);

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
	
</script>

<?php
	if ($rows>0){
?>					
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
							<th>Tanggal</th>
							<th width="33%">Keterangan</th>
							<th>Kd.Trx</th>
                            <th class="text-align-right">Pencairan</th>
                            <th class="text-align-right">Pokok</th>
                            <th class="text-align-right">Jasa</th>
                            <th class="text-align-right">Denda</th>
                            <th class="text-align-right">Lainnya</th>
							<th class="hidden-print">Cetak</th>
                        </tr>
                        </thead>
                        <tbody>
						<tr>
                            <th  class="text-align-center" colspan="4">T A R G E T &nbsp; P E M B A Y A R A N</th>
                            <th class="text-align-right"><?php echo number_format($alokasi);?></th>
                            <th class="text-align-right"><?php echo number_format($alokasi);?></th>
                            <th class="text-align-right"><?php echo number_format($alokasi_jasa);?></th>
                            <th class="text-align-right">0</th>
                            <th class="text-align-right">0</th>
							<th class="hidden-print">&nbsp;</th>
                        </tr>
                        <?php
								$no=0;
								while($row=mysql_fetch_array($sql)){
								$no=$no+1;	
									if($row['rekening_kredit']=="1-10005_$id_pinj") { 
										$pokok	=pokok($row['idtp']);
										$jasa	="0";
										$denda	="0";
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_kredit']=="4-60001_$id_pinj") {
										$pokok	="0";
										$jasa	=jasa($row['idtp']);
										$denda	="0";
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_kredit']=="4-60002_$id_pinj") {
										$pokok	="0";
										$jasa	="0";
										$denda	=denda($row['idtp']);
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_debit']=="1-10005_$id_pinj") {
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$lainnya	="0";
										$pencairan=$row['jumlah'];
										}else{
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$pencairan	="0";
										$lainnya=$row['jumlah'];
										}

						echo "
						<tr class='fs-mini fw-normal'>
							<td>$no</td>
							<td>".tgl_ind($row['tgl_transaksi'])."</td>
							<td>$row[keterangan_transaksi]</td>
							<td class='text-align-center'>$row[idt]/$row[idtp]</td>
							<td class='text-align-right'>".number_format($pencairan)."</td>
							<td class='text-align-right'>".number_format($pokok)."</td>
							<td class='text-align-right'>".number_format($jasa)."</td>
							<td class='text-align-right'>".number_format($denda)."</td> 
							<td class='text-align-right'>".number_format($lainnya)."</td> 
						"; 						if($row['rekening_debit']=="1-10001") {$file="c_bkm";} else if($row['rekening_kredit']=="1-10001") {$file="c_bkk";} else {$file="c_bpa";}
								?>
									
							<?php if ($row['idtp']==0) { 
							?>
                            <td class='hidden-print'>
								<ul class="tags mb-0">
									<li class="text-danger"><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Bukti Pengeluaran Kredit' onclick="MM_openBrWindow('modul/pelaporan/pdf/p_BuktiPengeluaranKredit.php?idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a></li>
									<li class="text-primary"><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Printer Inkjet/Laser' onclick="MM_openBrWindow('modul/pelaporan/pdf/<?php echo "$file.php?idt=$row[idt]";?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a></li>
									
								</ul>
							</td>	
								<?php } else { ?>
							<td class='hidden-print' >
								<ul class="tags mb-0">
									<li class="text-success"><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Printer Inkjet/Laser' onclick="MM_openBrWindow('modul/pelaporan/pdf/c_struk.php?idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a></li>
									<li class="text-primary"><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Cetak Notifikasi pada Kartu Angsuran' onclick="MM_openBrWindow('modul/pelaporan/pdf/c_notif_ka.php?idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a></li>
								</ul>
								
								<?php } ?>
								
							</td>
                        </tr> 					
	<?php				$sumcair=$sumcair+$pencairan;
						$sumpokok=$sumpokok+$pokok;
						$sumjasa=$sumjasa+$jasa;
						$sumdenda=$sumdenda+$denda;
						$sumlainnya=$sumlainnya+$lainnya;
						$saldo_pokok=$row['alokasi']-$sumpokok;
						$saldo_cair=$row['alokasi']-$sumcair;
						$saldo_jasa=$alokasi_jasa-$sumjasa;
						 } 
						 ?>
                        </tbody>
						<tfoot class="bg-info-light">
                        <tr>
							<th class="text-align-right" colspan="4">Total Transaksi</th>
                            <th class="text-align-right"><?php echo number_format($sumcair);?></th>
                            <th class="text-align-right"><?php echo number_format($sumpokok);?></th>
                            <th class="text-align-right"><?php echo number_format($sumjasa);?></th>
                            <th class="text-align-right"><?php echo number_format($sumdenda);?></th>
                            <th class="text-align-right"><?php echo number_format($sumlainnya);?></th>
							<th class="hidden-print">&nbsp;</th>
                        </tr>
						<tr>
							<th class="text-align-right" colspan="4">S A L D O</th>
                            <th class="text-align-right"><?php echo number_format($saldo_cair);?></th>
                            <th class="text-align-right"><?php echo number_format($saldo_pokok);?></th>
                            <th class="text-align-right"><?php echo number_format($saldo_jasa);?></th>
                            <th class="text-align-right">0</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
	
<?php
}else{
?>

<div class="alert alert-info animated fadeInDown">
    <h3 class="text-align-center">
		<i class="glyphicon glyphicon-comment"></i> Belum ada transaksi pada pinjaman ini! <?php echo $id_pinj;?>
	</h3>
</div>

<?php
}
?>

