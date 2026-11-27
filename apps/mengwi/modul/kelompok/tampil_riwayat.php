<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman.php";
$id_pinj=$_SESSION['id_pinj'];
$tgl_now			=date('Y-m-d');	
echo "					<hr>
											
										<div class='col-md-12'>
											<span class='fw-semi-bold'>RIWAYAT TRANSAKSI DAN ANGSURAN</span>
											<table width='100%' class='table'>
												<tr class='bg-body'>
												  <th width='5%'>No </th>
											      <th width='10%'>Tanggal</th>
											      <th width='5%'>KD.TRX</th>
											      <th width='5%'>KD.Rek</th>
											      <th width='30%'>Keterangan Transaksi</th>
										          <th width='10%'>Pencairan</th>
										          <th width='10%'>Pokok</th>
									              <th width='10%'>Jasa</th>
									              <th width='10%'>Denda</th>
									              <th width='5%'>&nbsp;</th>
												</tr> ";
							$dra=mysql_query("SELECT * FROM transaksi_$_SESSION[lokasi] WHERE id_pinj='$id_pinj' ORDER BY tgl_transaksi ");
								$no=0;
								while($ra=mysql_fetch_array($dra)){	
								$no=$no+1;
								$alokasi=alokasi($id_pinj);
								if($ra['rekening_debit']=='112.07' OR $ra['rekening_debit']=='113.07' OR $ra['rekening_debit']=='122.07' OR $ra['rekening_debit']=='123.07' ) {$cair=$ra['jumlah']; $pokok=0; $jasa=0; $denda=0;
								}else if($ra['rekening_debit']=='112.01' OR $ra['rekening_debit']=='113.01' ) {$cair=0; $pokok=$ra['jumlah']; $jasa=0; $denda=0;
								}else if($ra['rekening_debit']=='112.02' OR $ra['rekening_debit']=='113.02' ){$cair=0; $pokok=0; $jasa=$ra['jumlah']; $denda=0;
								}else if($ra['rekening_debit']=='112.03' OR $ra['rekening_debit']=='113.03' ){$cair=0; $pokok=0; $jasa=0; $denda=$ra['jumlah'];}
												
						echo "					<tr>
												  <th>$no</th>
												  <td>$ra[tgl_transaksi]</td>
												  <td>$ra[idt]-$ra[idtp]</td>
												  <td>$ra[rekening_debit]</td>
												  <td>$ra[keterangan_transaksi]</td>
												  <td class='text-align-right'>".number_format($cair)."</td>
												  <td class='text-align-right'>".number_format($pokok)."</td>
												  <td class='text-align-right'>".number_format($jasa)."</td>
												  <td class='text-align-right'>".number_format($denda)."</td>
												  <td class='hidden-print'>"; ?>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str.php?&idtp=<?php echo $ra['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak Struk"><i class="glyphicon glyphicon-print"></i></a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_str2.php?&idtp=<?php echo $ra['idtp'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Cetak Struk"><i class="glyphicon glyphicon-print"></i></a>
												</td>
												</tr>
						<?php					
												}
												$totcair=alokasi($id_pinj);
												$totpokok=sumpokok("$tgl_now-$id_pinj");
												$totjasa=sumjasa("$tgl_now-$id_pinj");
												$totdenda=sumdenda("$tgl_now-$id_pinj");
						echo "					<tr>
												  <th colspan='5'>Jumlah</td>
												  <th class='text-align-right'>".number_format($totcair)."</th>
												  <th class='text-align-right'>".number_format($totpokok)."</th>
												  <th class='text-align-right'>".number_format($totjasa)."</th>
												  <th class='text-align-right'>".number_format($totdenda)."</th>
												  <th></th>
												</tr>
												<tr>
												  <th colspan='5'>Saldo</th>
												  <th colspan='5' class='text-align-right'>".number_format($totcair-$totpokok)."</th>
												</tr>";
												
						echo "				</table>
										</div>
											";
											
											 ?>