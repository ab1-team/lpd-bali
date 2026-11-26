<?php session_start(); 
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../../inc/inc.koneksi.php";
						
$table_transaksi="transaksi_".$_SESSION['lokasi'];
$table_rekening="rekening_".$_SESSION['lokasi'];


$row=mysql_fetch_array(mysql_query("SELECT max(idt) as maxidt FROM $table_transaksi WHERE id_user='$_SESSION[id]' ORDER BY idt DESC"));
$maxtrans=$row['maxidt'];
			
$kredit	=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r where r.kd_rekening=t.rekening_kredit AND t.idt='$maxtrans' "));
$debit	=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r where r.kd_rekening=t.rekening_debit AND t.idt='$maxtrans' "));

$r=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idt='$maxtrans' ORDER BY idt DESC"));
	
if($r['rekening_debit']=="1-10001") {$file="c_bkm";} else if($r['rekening_kredit']=="1-10001") {$file="c_bkk";}	else {$file="c_bpa";}
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

<script> window.setTimeout(function() { $(".alert-success").fadeTo(1000, 0).slideUp(1000, function(){ $(this).remove(); }); }, 9000); </script> 

<div class="alert alert-success mt animated fadeInDown">
    <button type="button" class="close ml" data-dismiss="alert" aria-hidden="true">×</button>
	<i class="fa fa-check-circle"></i> <strong>Notifikasi </strong> Transaksi Berhasil ! 
			<span class="pull-right">
				<?php
				if($_SESSION['level']==1 AND $_SESSION['jabatan']==1) {$tombol="javascript:deleteRow($kredit[idt])"; $title="Dengan menghapus $kredit[nama_rekening] transaksi yang berkaitan akan otomatis terhapus";}
								else{$tombol="#"; $title="Hapus jurnal transaksi hanya dapat dilakukan oleh Ketua/Manajer";}
				echo "
				<a class='btn btn-default text-success' href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'><i class='fa fa-eraser'></i></a> 
						";
						
			
				?>
				<a class="btn btn-default text-success" href="javascript:;" data-toggle='tooltip' data-placement='top' title='Printer Inkjet/Laser' onclick="MM_openBrWindow('modul/pelaporan/pdf/<?php echo "$file.php?idt=$maxtrans";?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i> Cetak Kwitansi</a>
			</span>				
	<hr>

                        <tbody>
                        <?php
						echo "
						$kredit[tgl_transaksi]
						[<a href='' data-toggle='tooltip' data-placement='top' title='$kredit[nama_rekening]'>$kredit[rekening_kredit]</a>] <strong>$kredit[nama_rekening]</strong> <i class='glyphicon glyphicon-arrow-right'></i> <br> <i>$kredit[keterangan_transaksi]</i>
						<span class='pull-right fw-semi-bold'>".number_format($kredit['jumlah'])."</span>
						<hr>
						";
						
						echo "
						$debit[tgl_transaksi]
						[<a href='' data-toggle='tooltip' data-placement='top' title='$debit[nama_rekening]'>$debit[rekening_debit]</a>] <strong>$debit[nama_rekening]</strong> <i class='glyphicon glyphicon-arrow-left'></i> <br> <i>$debit[keterangan_transaksi]</i>
						<span class='pull-right fw-semi-bold'>".number_format($debit['jumlah'])." </span>
						<hr>
						";
						  ?>
                        </tbody>
						<p class="fs-sm"><i class="glyphicon glyphicon-comment"></i> Notifikasi ini akan tertutup otomatis dalam 10 detik</p>

</div>