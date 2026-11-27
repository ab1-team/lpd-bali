<?php session_start(); 
$table_transaksi="transaksi_".$_SESSION['lokasi'];
$table_rekening="rekening_".$_SESSION['lokasi'];

?>
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
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
					alert('Berhasil!');
				}
			});
		}
	}
</script>

<div class="alert alert-info mt animated fadeInDown">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<i class="fa fa-check-circle"></i> <strong>Notifikasi | Transaksi Berhasil ! </strong> 
	<hr>

                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$idt=mysql_fetch_array(mysql_query("SELECT max(idt) FROM $table_transaksi WHERE id_user='$_SESSION[id]' ORDER BY idt DESC"));
						$maxtrans=$idt[0];
			
						$kredit=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r, jenis_buku jb where jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND t.idt='$maxtrans' AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND t.idt='$maxtrans' AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
						$jumlah_kredit = explode('.',$kredit['jumlah']);
						$rupiah = ($jumlah_kredit[1]) ? $jumlah_kredit[1] : '00';
						$t_kredit = number_format($jumlah_kredit[0]) . '.' . $rupiah;
						
						echo "
						$kredit[tgl_transaksi]
						[<a href='' data-toggle='tooltip' data-placement='top' title='$kredit[jenis_mutasi] : $kredit[nama_rekening]'>$kredit[rekening_kredit]</a>]
						<strong>$kredit[nama_jb] ($kredit[ins])</strong> <i class='glyphicon glyphicon-arrow-right'></i> <br> $kredit[nama_rekening] | <i>$kredit[keterangan_transaksi]</i>
						<br><strong>$kredit[jenis_mutasi] :</strong> <span class='pull-right'>" .$t_kredit . "</span>
						<hr>
						";
						
						$debit=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r, jenis_buku jb where jb.kd_jb=r.kd_jb AND r.pasangan=t.rekening_kredit AND t.idt='$maxtrans' AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.pasangan=t.rekening_kredit AND t.idt='$maxtrans' AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
						$jumlah_debit = explode('.',$debit['jumlah']);
						$rupiah = ($jumlah_debit[1]) ? $jumlah_debit[1] : '00';
						$t_debit = number_format($jumlah_debit[0]) . '.' . $rupiah;
						
						echo "
						$debit[tgl_transaksi]
						[<a href='' data-toggle='tooltip' data-placement='top' title='$debit[jenis_mutasi] : $debit[nama_rekening]'>$debit[rekening_debit]</a>]
						<strong>$debit[nama_jb] ($debit[ins])</strong> <i class='glyphicon glyphicon-arrow-left'></i> <br> $debit[nama_rekening] | <i>$debit[keterangan_transaksi]</i>
						<br><strong>$debit[jenis_mutasi] :</strong> <span class='pull-right'>" . $t_debit . " </span>
						<hr>
						";
						  ?>
                        </tbody>

				<p class="fs-sm"><i class="glyphicon glyphicon-comment"></i> Posting Jurnal transaksi ini dilakukan otomatis oleh sistem!
				
				<a class="btn btn-default text-info" href="javascript:;" data-toggle='tooltip' data-placement='top' title='Printer Dot Matrik 1' onclick="MM_openBrWindow('modul/jurnal/c_kw_dot_1.php?idt=<?php echo $kredit['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i> Kwitansi 1</a> |
				<a class="btn btn-default text-info" href="javascript:;" data-toggle='tooltip' data-placement='top' title='Printer Dot Matrik 2' onclick="MM_openBrWindow('modul/jurnal/c_kw_dot_2.php?idt=<?php echo $kredit['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i> Kwitansi 2</a> |
				<a class="btn btn-default text-info" href="javascript:;" data-toggle='tooltip' data-placement='top' title='Printer Biasa' onclick="MM_openBrWindow('modul/jurnal/c_kw.php?idt=<?php echo $kredit['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i> Kwitansi 3</a>
							
				<?php
				if($_SESSION['level']==1 AND $_SESSION['jabatan']==1) {$tombol="javascript:deleteRow($kredit[idt])"; $title="Dengan menghapus $kredit[nama_rekening] transaksi yang berkaitan akan otomatis terhapus";}
								else{$tombol="#"; $title="Hapus jurnal transaksi hanya dapat dilakukan oleh Ketua UPK/Manajer";}
				echo "
				<a class='btn btn-default text-info' href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'><i class='hidden fa fa-eraser'></i></a> 
						";
				?>
				</p>
</div>