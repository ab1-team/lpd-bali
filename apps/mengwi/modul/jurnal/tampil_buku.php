<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$lokasi				=$_SESSION['lokasi'];
$table_transaksi	="transaksi_$lokasi";
$table_rekening		="rekening_$lokasi";
$idf				=$_POST['jenis_buku'];
$jenis_buku			=$_POST['jenis_buku'];
$d					=$_POST['hari'];
$m					=$_POST['bulan'];
$y					=$_POST['tahun'];

$tgl				="$y-$m-$d";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-$tgl_close"; $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-$tgl_close' ";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR  kd_jb='$idf' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
$posisi	=$jb['posisi'];

if($posisi=="1") {
$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
}else{
$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
}
$totsaldoawalbulan	=$totsaldoawaltahun+$saldoawalbulan;


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
	<i class="fa fa-book"></i> DETAIL TRANSAKSI <?php echo strtoupper($jb['nama_jb']);?> [<?php echo "$jb[ins]-$jb[kd_jb]";?>] <?php echo strtoupper($jenis);?> <?php echo strtoupper(tgl_indo($tgl));?>
		<ul class="tags pull-right">
			<li><a href="modul/pelaporan/p/BB.php?idf=<?php echo $jenis_buku;?>&y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>" target="_blank" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Cetak Standar Akt</span></a></li>
			<!--<li><a href="modul/pelaporan/p/BS.php?idf=<?php echo $jenis_buku;?>&y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>" target="_blank" > <span class="hidden fs-mini"><i class="hidden glyphicon glyphicon-print"></i> Cetak Standar PTO</span></a></li>-->
			<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
		</ul>
	</h5>
</div>

<?php
if (!empty($jenis_buku)) {
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
								<td class="text-align-right"><?php echo number_format(saldoATD("$tgl_kondisi-$idf"));?></td>
								<td class="text-align-right"><?php echo number_format(saldoATK("$tgl_kondisi-$idf"));?></td>
								<td class="text-align-right"><?php echo number_format($totsaldoawaltahun);?></td>
								<td class="hidden-print" colspan="2">&nbsp;</td>
							</tr>
							<tr class="bg-primary-light">
								<td>&nbsp;</td>
								<td><?php echo $tgl_awal;?></td>
								<td><?php echo $jb['kd_jb'];?></td>
								<td>Saldo Awal <?php echo $jenis." Per ".tgl_indo($tgl_kondisi);?></td>
								<td>SAB</td>
								<td class="text-align-right"><?php echo number_format(saldoABKD("$tgl_kondisi-$idf"));?></td>
								<td class="text-align-right"><?php echo number_format(saldoABKK("$tgl_kondisi-$idf"));?></td>
								<td class="text-align-right"><?php echo number_format($totsaldoawalbulan);?></td>
								<td class="hidden-print" colspan="2">&nbsp;</td>
							</tr>
							<?php
								$view=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_kredit AND $kondisi  order by tgl_transaksi, urutan, idt asc");
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
			//Untuk memunculkan keterangan TRX yg berbeda pada TRX BANK
			if ($rekening_debit=='122.01' OR $rekening_kredit=='121.04' OR $rekening_debit=='121.07' OR $rekening_debit=='121.08'
			OR $rekening_debit=='111.03' OR $rekening_debit=='111.04' OR $rekening_debit=='111.05'
			OR $rekening_debit=='122.01' OR $rekening_kredit=='122.04'  OR $rekening_debit=='123.01' OR $rekening_kredit=='123.04') 
			{ $keterangantransaksi=$nama_rekening; }else{$keterangantransaksi=$row['keterangan_transaksi'];}
			//
									$ds=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k, desa d WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$row[id_pinj]'"));
									if($row['id_pinj'] >0) { $keterangan_transaksi="$keterangantransaksi $ds[nama_desa]"; }else{ $keterangan_transaksi="$keterangantransaksi"; }
			
							echo "
							<tr>
								<td>$no</td>
								<td>$row[tgl_transaksi]</td>
								<td><a href='#' data-toggle='tooltip' data-placement='left' title='$row[nama_rekening]'>$row[kd_rekening]</a></td>
								<td>$keterangan_transaksi</td>
								<td class='text-align-center'>$row[idt]</td>
								<td class='text-align-right'>".number_format($debit)."</td>
								<td class='text-align-right'>".number_format($kredit)."</td>
								<td class='text-align-right'>"; $prasaldo=$debit-$kredit; if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; } echo "".number_format($saldosamping)." </td>
								<td>$r[ins]</td>
								<td class='hidden-print'>";
								?>
									<a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Dot Matrik 1' onclick="MM_openBrWindow('modul/jurnal/c_kw_dot_1.php?idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a> -
									<a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Dot Matrik 2' onclick="MM_openBrWindow('modul/jurnal/c_kw_dot_2.php?idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a> -
									<a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Kwitansi Printer Biasa' onclick="MM_openBrWindow('modul/jurnal/c_kw.php?idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
								<?php echo "
									| <a href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'>
								 	<i class='hidden fa fa-eraser'></i></a>
								</td>
							</tr> ";					
							$sumdebit=$sumdebit+$debit;
							$sumkredit=$sumkredit+$kredit;
							 }
							 
							 $saldo=saldo("$tgl_kondisisaldo-$jenis_buku");
									if($saldo>0) {
									$saldo=$saldo;
									$ketsaldo="Saldo Debet";
									}elseif($saldo<0){
									$saldo=$saldo*-1;
									$ketsaldo="Saldo Kredit";
									}
							 ?>
							</tbody>
							<tfoot class="bg-primary-light">
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format($sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format($sumkredit);?></th>
								<th class="text-align-center" colspan="3" rowspan="3"><h3><span class="fs-mini"><?php echo $ketsaldo;?></span><br><?php echo number_format($saldo);?></h3></th>
							</tr>
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Tahun <?php echo date('Y');?> s.d. Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format(saldoABKD("$tgl_kondisi-$idf")+$sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format(saldoABKK("$tgl_kondisi-$idf")+$sumkredit);?></th>
							</tr>
							<tr>
								<th class="text-align-right" colspan="5">Transaksi Komulatif s.d. Bulan <?php echo date('M Y');?></th>
								<th class="text-align-right"><?php echo number_format(saldoATD("$tgl_kondisi-$idf")+saldoABKD("$tgl_kondisi-$idf")+$sumdebit);?></th>
								<th class="text-align-right"><?php echo number_format(saldoATK("$tgl_kondisi-$idf")+saldoABKK("$tgl_kondisi-$idf")+$sumkredit);?>s</th>
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
		<br><br>Silahkan pilih Jenis Buku dan Sub Buku Terlebih Dahulu<br><br>
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
		<li><a href="modul/pelaporan/p/BB.php?idf=<?php echo $jenis_buku;?>&y=<?php echo $y;?>&m=<?php echo $m;?>&d=<?php echo $d;?>" target="_blank" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Cetak</span></a></li>
		<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
	</ul>
</div>