<?php session_start(); 
$table_transaksi="admin_transaksi";
$table_rekening="admin_rekening";

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
				url		: "admin/transaksi/hapus.php",
				data	: "idt="+idt,
				success	: function(data){
					$("#TampilJurnal").load('admin/transaksi/tampil_jurnal.php');
					alert('Berhasil!');
				}
			});
		}
	}
</script>

				<div class="alert alert-danger animated fadeInDown hidden-print">
					<legend><i class="fa fa-check"></i> Posting Jurnal Transaksi Terakhir!</legend>
					<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-danger text-white">
                        <tr>
                            <th>Tgl</th>
                            <th>NoRek</th>
							<th>Nama Rekening</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$idt=mysql_fetch_array(mysql_query("SELECT max(idt) FROM $table_transaksi ORDER BY idt DESC"));
						$maxtrans=$idt[0];
			
						$kredit=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r, admin_buku jb where jb.id=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND t.idt='$maxtrans' "));
						echo "
						<tr>
							<td>$kredit[tgl_transaksi]</td>
							<td><a href='' data-toggle='tooltip' data-placement='left' title='$kredit[nama_rekening]'>$kredit[rekening_kredit]</a></td>
							<td><strong>$kredit[nama_jb] ($kredit[ins])</strong> <i class='glyphicon glyphicon-arrow-right'></i> <br> $kredit[nama_rekening] <br> <i>$kredit[keterangan_transaksi]</i></td>
							<td>0</td>
							<td>".number_format($kredit['jumlah'])."</td>
                        </tr> ";
						
						$debit=mysql_fetch_array(mysql_query("select * from $table_transaksi t, $table_rekening r, admin_buku jb where jb.id=r.kd_jb AND r.pasangan=t.rekening_kredit AND t.idt='$maxtrans' "));
						echo "
						<tr>
							<td>$debit[tgl_transaksi]</td>
							<td><a href='' data-toggle='tooltip' data-placement='left' title='$debit[nama_rekening]'>$debit[rekening_debit]</a></td>
							<td><strong>$debit[nama_jb] ($debit[ins])</strong> <i class='glyphicon glyphicon-arrow-left'></i> <br> $debit[nama_rekening] <br> <i>$debit[keterangan_transaksi]</i></td>
							<td>".number_format($debit['jumlah'])."</td>
							<td>0</td>
                        </tr>";
						  ?>
                        </tbody>
                    </table>
                </div>
				<p class="fs-sm"><i class="glyphicon glyphicon-comment"></i> Posting Jurnal transaksi ini dilakukan otomatis oleh sistem!
				<?php
				if($_SESSION['level']=="pusat") {$tombol="javascript:deleteRow(\"{$kredit[idt]}\")"; $title="Dengan menghapus $kredit[nama_rekening] transaksi yang berkaitan akan otomatis terhapus";}
								else{$tombol="#"; $title="Hapus jurnal transaksi";}
				echo "
				<a class='pull-right fs-larger' href='$tombol' data-toggle='tooltip' data-placement='left' title='$title'><i class='fa fa-eraser'></i></a> 
						";
				?>
				</p>
				</div>