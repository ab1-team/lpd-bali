<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$lokasi				=$_SESSION['lokasi'];
$table_transaksi	="transaksi_$lokasi";
$table_rekening		="rekening_$lokasi";
$idf				=$_POST['rekening_1'];
$kd_rekening			=$_POST['rekening_1'];
$d					=$_POST['hari'];
$m					=$_POST['bulan'];
$y					=$_POST['tahun'];

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi="$y-$m-01"; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi between '$y-$m-01' AND '$y-$m-31' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa where id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$totsaldoawaltahun	=saldoATR("$tgl_kondisi-$idf");

$saldoDR		=saldoDR("$tgl_lalu-$idf"); //Awal Bulan
$saldoKR		=saldoKR("$tgl_lalu-$idf");

$totsaldoawalbulan	=$totsaldoawaltahun+$saldoDR-$saldoKR;


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
	

	function deleteRow(ID) {
		var idt	= ID;
	   var pilih = confirm('Dengan menghapus jurnal '+idt+ ' secara otomatis jurnal yang berkaitan juga akan terhapus?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/jurnal/hapus.php",
				data	: "idt="+idt,
				success	: function(data){
					$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
					$("#TampilBuku").load('modul/jurnal/tampil_buku.php');
					alert('Berhasil!');
					$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				}
			});
		}
	}
</script>

<div class="modal-header bg-primary">
	<h5 class="modal-title fw-bold" id="LabelDetailTransaksiUmum">
	<i class="fa fa-book"></i> [<?php echo $kd_rekening;?>] <?php echo strtoupper(namarek($kd_rekening));?> <?php echo strtoupper($jenis);?> <?php echo strtoupper(tgl_indo($tgl));?>
		<ul class="tags pull-right">
			<li><a href="modul/pelaporan/pdf/BB.php?idf=<?php echo $kd_rekening;?>&y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>" target="_blank" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Generate ke PDF</span></a></li>
			<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
		</ul>
	</h5>
</div>

<?php
if (!empty($kd_rekening)) {
?>

<div class="modal-body" style="overflow: scroll; height: 550px;">

					<div class="table-responsive">
						<table id="datatable-table" class="table table-hover">
							<thead class="bg-primary text-white">
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>No. Rek</th>
								<th>Keterangan</th>
								<th>Kd.Trx</th>
								<th class="text-align-right">Debit</th>
								<th class="text-align-right">Kredit</th>
								<th class="text-align-right">Saldo</th>
								<th>P</th>
								<th class="hidden-print">&nbsp;</th>
							</tr>
							</thead>
							<tbody>
							<tr class="bg-primary-light">
								<td>&nbsp;</td>
								<td><?php echo $y;?>-01-01</td>
								<td><?php echo $jb['kd_jb'];?></td>
								<td>Saldo Awal <?php echo $y;?></td>
								<td>SAT</td>
								<td class="text-align-right"></td>
								<td class="text-align-right"></td>
								<td class="text-align-right"><?php echo number_format($totsaldoawaltahun);?></td>
								<td class="hidden-print" colspan="2">&nbsp;</td>
							</tr>
							<tr class="bg-primary-light">
								<td>&nbsp;</td>
								<td><?php echo $tgl_kondisi;?></td>
								<td><?php echo $jb['kd_jb'];?></td>
								<td>Saldo Awal <?php echo $jenis." Per ".tgl_indo($tgl_kondisi);?></td>
								<td>SAB</td>
								<td class="text-align-right"><?php echo number_format($saldoDR);?></td>
								<td class="text-align-right"><?php echo number_format($saldoKR);?></td>
								<td class="text-align-right"><?php echo number_format($totsaldoawalbulan);?></td>
								<td class="hidden-print" colspan="2">&nbsp;</td>
							</tr>
							<?php
								$view=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_rekening='$kd_rekening'  AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_rekening='$kd_rekening'  AND r.kd_rekening=t.rekening_kredit AND $kondisi  order by tgl_transaksi, urutan, idt asc");
								$no=0;
									while($row=mysql_fetch_array($view)){
									$no=$no+1;
										if($row['rekening_debit']==$row['kd_rekening']) {
											$debit	=$row['jumlah'];
											$kredit	="0";
											}elseif($row['rekening_kredit']==$row['kd_rekening']) {
											$debit	="0";
											$kredit	=$row['jumlah'];
											}
											
									$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));		
									
									
									if($_SESSION['level']==1 AND $_SESSION['jabatan']==1) {$tombol="javascript:deleteRow(\"{$row[idt]}\")"; $title="Dengan menghapus $row[nama_rekening] transaksi yang berkaitan akan otomatis terhapus";}
									else{$tombol="#"; $title="Hapus transaksi hanya dapat dilakukan oleh Ketua UPK/Manajer";}
									
									$rekening_debit			=$row['rekening_debit'];
									$rekening_kredit		=$row['rekening_kredit'];
									$nama_rekening			=$row['nama_rekening'];
									$keterangan_transaksi	=$row['keterangan_transaksi'];
									
									$ja=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND r.kd_rekening='$idf' "));
									$posisi	=$ja['posisi'];
									
									if($posisi=="1" OR $posisi=="5") { $prasaldo=$debit-$kredit; } else if($posisi=="2" OR $posisi=="3" OR $posisi=="4") { $prasaldo=$kredit-$debit; }
		
									if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; }
		
									
							echo "
							<tr>
								<td>$no</td>
								<td>$row[tgl_transaksi]</td>
								<td><a href='#' data-toggle='tooltip' data-placement='left' title='$row[nama_rekening]'>$row[kd_rekening]</a></td>
								<td>$keterangan_transaksi</td>
								<td class='text-align-center'>$row[idt]</td>
								<td class='text-align-right'>".number_format($debit)."</td>
								<td class='text-align-right'>".number_format($kredit)."</td>
								<td class='text-align-right'>".number_format($saldosamping)." </td>
								<td>$r[ins]</td>
								<td class='hidden-print'>";
								
								if($row['rekening_debit']=="1-10001") {$file="c_bkm";} else if($row['rekening_kredit']=="1-10001") {$file="c_bkk";} else {$file="c_bpa";}
								?>
								<ul class="tags mb-0">
									<li class="text-primary"><a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Printer Inkjet/Laser' onclick="MM_openBrWindow('modul/pelaporan/pdf/<?php echo "$file.php?idt=$row[idt]";?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a></li>
									
								<?php echo "
									<li class='text-danger'><a href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'><i class='glyphicon glyphicon-remove'></i></a></li>
								</ul>
								</td>
							</tr> ";					
							$sumdebit=$sumdebit+$debit;
							$sumkredit=$sumkredit+$kredit;
							 }
							 
							 $saldo=saldoR("$tgl_kondisisaldo-$kd_rekening");
									if($saldo>0) {
									$saldoo=$saldo;
									$ketsaldo="Saldo Debet";
									}elseif($saldo<0){
									$saldoo=$saldo*-1;
									$ketsaldo="Saldo Kredit";
									}
							 ?>
							</tbody>
							<tfoot class="bg-primary-light">
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format($sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format($sumkredit);?></th>
								<th class="text-align-center" colspan="3" rowspan="3"><h3><span class="fs-mini"><?php echo $ketsaldo;?></span><br><?php echo number_format($saldoo);?></h3></th>
							</tr>
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Tahun <?php echo date('Y');?> s.d. Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format($saldoABdebit+$sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format($saldoABkredit+$sumkredit);?></th>
							</tr>
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Komulatif s.d. Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format($saldoATdebit+$saldoABdebit+$sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format($saldoATkredit+$saldoABkredit+$sumkredit);?></th>
							</tr>
							</tfoot>
						</table>
					</div>
</div>

<?php
}else{
	echo '
	<div class="modal-body" style="overflow: scroll; height: 550px;">
	<h3 class="text-align-center">
		<br><br>Silahkan pilih Jenis Transaksi dan Sumber Dana Terlebih Dahulu<br><br>
		<button type="button" data-dismiss="modal" aria-hidden="true" class="btn width-100">OK</button>
	</h3>
	
	</div>
	';
}
?>

<div class="modal-footer bg-primary">
	<ul class="tags pull-right">
		<li><span class="h4 mr"><?php echo $ketsaldo;?></li>
		<li><span class="h4 mr-lg fw-semi-bold"><?php echo number_format($saldo);?></li>
		<li><a href="modul/pelaporan/pdf/BB.php?idf=<?php echo $kd_rekening;?>&y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>" target="_blank" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Generate ke PDF</span></a></li>
		<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
	</ul>
</div>