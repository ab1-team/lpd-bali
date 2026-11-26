<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj	=$_POST['id_pinj'];
$text	= "SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t WHERE a.id=pi.nia AND pi.id=t.id_pinj_i AND pi.jenis_pinjaman='I'  AND t.id_pinj_i='$id_pinj' ORDER BY t.tgl_transaksi  ";
$sql 	= mysql_query($text);
$r		= mysql_num_rows($sql);

if ($r>0){
	
	$alokasi	=alokasi($id_pinj);
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

<section class="widget animated fadeInDown">
			<div class="widget-body">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
							<th>Tanggal</th>
							<th>No.Rek</th>
							<th>Keterangan</th>
							<th>Kd.Trx</th>
                            <th class="text-align-right">Pencairan</th>
                            <th class="text-align-right">Pokok</th>
                            <th class="text-align-right">Jasa</th>
                            <th class="text-align-right">Denda</th>
							<th class="hidden-print">Cetak</th>
                        </tr>
                        </thead>
                        <tbody>
						<tr>
                            <th  class="text-align-center" colspan="5">T A R G E T &nbsp; P E M B A Y A R A N</th>
                            <th class="text-align-right"><?php echo number_format($alokasi);?></th>
                            <th class="text-align-right"><?php echo number_format($alokasi);?></th>
                            <th class="text-align-right"><?php echo number_format($alokasi_jasa);?></th>
                            <th class="text-align-right">0</th>
							<th class="hidden-print">&nbsp;</th>
                        </tr>
                        <?php
								$no=0;
								while($row=mysql_fetch_array($sql)){
								$no=$no+1;	
									if($row['rekening_debit']=="112.01" OR $row['rekening_debit']=="113.01" OR $row['rekening_debit']=="114.01" OR $row['rekening_debit']=="115.01" OR $row['rekening_debit']=="116.01" OR $row['rekening_debit']=="117.01" OR $row['rekening_debit']=="118.01") { 
										$pokok	=pokok($row['idtp']);
										$jasa	="0";
										$denda	="0";
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_debit']=="112.02" OR $row['rekening_debit']=="113.02" OR $row['rekening_debit']=="114.02" OR $row['rekening_debit']=="115.02" OR $row['rekening_debit']=="116.02" OR $row['rekening_debit']=="117.02" OR $row['rekening_debit']=="118.02") {
										$pokok	="0";
										$jasa	=jasa($row['idtp']);
										$denda	="0";
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_debit']=="112.03" OR $row['rekening_debit']=="113.03" OR $row['rekening_debit']=="114.03" OR $row['rekening_debit']=="115.03" OR $row['rekening_debit']=="116.03" OR $row['rekening_debit']=="117.03" OR $row['rekening_debit']=="118.03" ) {
										$pokok	="0";
										$jasa	="0";
										$denda	=denda($row['idtp']);
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_kredit']=="112.07" OR $row['rekening_kredit']=="113.07" OR $row['rekening_debit']=="114.07" OR $row['rekening_kredit']=="122.07"  OR $row['rekening_kredit']=="123.07" OR $row['rekening_kredit']=="126.07" OR $row['rekening_kredit']=="115.07" OR $row['rekening_kredit']=="116.07" OR $row['rekening_kredit']=="117.07" OR $row['rekening_kredit']=="118.07") {
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$pencairan=$row['jumlah'];
										$rekening=$row['rekening_kredit'];
										}

						echo "
						<tr>
							<td>$no</td>
							<td>$row[tgl_transaksi]</td>
							<td>$rekening</td>
							<td>$row[keterangan_transaksi]</td>
							<td class='text-align-center'>$row[idt]/$row[idtp]</td>
							<td class='text-align-right'>".number_format($pencairan)."</td>
							<td class='text-align-right'>".number_format($pokok)."</td>
							<td class='text-align-right'>".number_format($jasa)."</td>
							<td class='text-align-right'>".number_format($denda)."</td> "; ?>
							
							<?php if ($row['idtp']==0) { ?>
                            <td class='hidden-print'>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_ka_i.php?&idtp=none&idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak pada Kartu Angsuran"><i class="glyphicon glyphicon-print"></i></a>
							</td>	
								<?php } else { ?>
							<td class='hidden-print' >	
								<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str_dot_i.php?&idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak Struk Dot Metrik"><i class="glyphicon glyphicon-print"></i></a> | 
								<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str_dot_i_2.php?&idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak Struk Dot Metrik 2"><i class="glyphicon glyphicon-print"></i></a> | 
								<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str_i.php?&idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak Struk "><i class="glyphicon glyphicon-print"></i></a> | 
								<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_ka_i.php?&idtp=<?php echo $row['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak pada Kartu Angsuran"><i class="glyphicon glyphicon-print"></i></a>
								
								<?php } ?>
								
							</td>
                        </tr> 					
	<?php				$sumcair=$sumcair+$pencairan;
						$sumpokok=$sumpokok+$pokok;
						$sumjasa=$sumjasa+$jasa;
						$sumdenda=$sumdenda+$denda;
						$saldo_pokok=$row['alokasi']-$sumpokok;
						$saldo_cair=$row['alokasi']-$sumcair;
						$saldo_jasa=$alokasi_jasa-$sumjasa;
						 } 
						 ?>
                        </tbody>
						<tfoot class="bg-info-light">
                        <tr>
							<th class="text-align-right" colspan="5">Total Transaksi</th>
                            <th class="text-align-right"><?php echo number_format($sumcair);?></th>
                            <th class="text-align-right"><?php echo number_format($sumpokok);?></th>
                            <th class="text-align-right"><?php echo number_format($sumjasa);?></th>
                            <th class="text-align-right"><?php echo number_format($sumdenda);?></th>
							<th class="hidden-print">&nbsp;</th>
                        </tr>
						<tr>
							<th class="text-align-right" colspan="5">S A L D O</th>
                            <th class="text-align-right"><?php echo number_format($saldo_cair);?></th>
                            <th class="text-align-right"><?php echo number_format($saldo_pokok);?></th>
                            <th class="text-align-right"><?php echo number_format($saldo_jasa);?></th>
                            <th class="text-align-right">0</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
</section>

<?php
}else{
?>

<div class="alert alert-info animated fadeInDown">
    <h3 class="text-align-center">
		<i class="glyphicon glyphicon-comment"></i> Belum ada transaksi pada pinjaman ini!
	</h3>
</div>

<?php
}
?>