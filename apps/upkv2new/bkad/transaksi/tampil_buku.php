<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_bkad.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table_transaksi="bkad_transaksi";
$jenis_buku	= $_SESSION['jenis_buku'];
$table_rekening="bkad_rekening";

$buku=mysql_fetch_array(mysql_query("SELECT * FROM bkad_buku WHERE jb_bkad='$jenis_buku'  "));


$tgl_open		="01";
$tgl_close		="31";
$bln_lalu		=mktime(0, 0, 0, date("m")-1, $tgl_open, date("Y"));
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal=date('Y-m')."-$tgl_open"; }

$tgl_kondisi	=date('Y-m')."-$tgl_close";
$kondisi		="tgl_transaksi between '$tgl_awal' AND '$tgl_kondisi' ";

$saldoABdebit	=saldoABKD("$tgl_awal-".$buku['jb_bkad']);
$saldoABkredit	=saldoABKK("$tgl_awal-".$buku['jb_bkad']);
$saldoATdebit	=saldoATDR("$tgl_kondisi-".$buku['jb_bkad']);
$saldoATkredit	=saldoATKR("$tgl_kondisi-".$buku['jb_bkad']);

$saldoawalbulan		=$saldoABdebit-$saldoABkredit;
$totsaldoawaltahun	=$saldoATdebit-$saldoATkredit;

$totsaldoawalbulan	=$saldoawalbulan;

$view=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_debit AND t.lokasi='$_SESSION[lokasi]' AND $kondisi OR  r.kd_jb='$jenis_buku' AND r.kd_rekening=t.rekening_kredit AND t.lokasi='$_SESSION[lokasi]' AND $kondisi order by tgl_transaksi, urutan, idt asc");

$pelogin			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id=$_SESSION[id]"));
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
				url		: "bkad/transaksi/hapus.php",
				data	: "idt="+idt,
				success	: function(data){
					$("#TampilJurnal").load('bkad/transaksi/tampil_jurnal.php');
					$("#TampilBuku").load('bkad/transaksi/tampil_buku.php');
					alert('Berhasil!');
					$("#TampilSaldo").load('bkad/transaksi/tampil_saldo.php');
				}
			});
		}
	}
</script>

<section class="alert alert-info">
	<header>
        <legend><i class="fa fa-book"></i> Buku <?php echo $buku['nama_jb'];?> - Bulan <?php echo tgl_indo(date("Y-m"));?></legend>
            <div class="widget-controls">
                Nomor Rekening : <?php echo $buku['jb_bkad'];?>
                <a href="javascript:;" data-toggle='tooltip' data-placement='left' title='Standart Akuntansi' onclick="MM_openBrWindow('bkad/pelaporan/p/BB.php?idf=<?php echo $jenis_buku;?>&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
                <a href="javascript:;" data-toggle='tooltip' data-placement='left' title='Standart PTO' onclick="MM_openBrWindow('bkad/pelaporan/p/BS.php?idf=<?php echo $jenis_buku;?>&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
            </div>
    </header>
			<div class="widget-body">
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
							<td><?php echo date('Y');?>-01-01</td>
							<td><?php echo $buku['jb_bkad'];?></td>
							<td>Saldo Awal <?php echo date('Y');?></td>
							<td>SAT</td>
                            <td class="text-align-right"><?php echo number_format($saldoATdebit);?></td>
                            <td class="text-align-right"><?php echo number_format($saldoATkredit);?></td>
                            <td class="text-align-right"><?php echo number_format($totsaldoawaltahun);?></td>
							<td class="hidden-print" colspan="2">&nbsp;</td>
                        </tr>
						<tr class="bg-primary-light">
                            <td>&nbsp;</td>
							<td><?php echo $tgl_awal;?></td>
							<td><?php echo $buku['jb_bkad'];?></td>
							<td>Saldo Awal Periode <?php echo date('M Y');?></td>
							<td>SAB</td>
                            <td class="text-align-right"><?php echo number_format($saldoABdebit);?></td>
                            <td class="text-align-right"><?php echo number_format($saldoABkredit);?></td>
                            <td class="text-align-right"><?php echo number_format($totsaldoawalbulan);?></td>
							<td class="hidden-print" colspan="2">&nbsp;</td>
                        </tr>
                        <?php
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
											
								
								if($pelogin['jabatan']==1) {$tombol="javascript:deleteRow(\"{$row[idt]}\")"; $title="Dengan menghapus $row[nama_rekening] transaksi yang berkaitan akan otomatis terhapus";
								$tampil="<td class='hidden-print'><a href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'><i class='fa fa-eraser'></i></a></td>";
								}
								
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
							<td></td>
                            <td class='hidden-print'>
								$tampil
							</td>
                        </tr> ";					
						$sumdebit=$sumdebit+$debit;
						$sumkredit=$sumkredit+$kredit;
		
							$saldo=saldo("$tgl_kondisi-".$buku['jb_bkad']);
								if($saldo>0) {
								$saldo=$saldo;
								$ketsaldo="Saldo Debet";
								}elseif($saldo<0){
								$saldo=$saldo*-1;
								$ketsaldo="Saldo Kredit";
								}							
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
</section>