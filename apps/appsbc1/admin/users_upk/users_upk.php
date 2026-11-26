<?php session_start(); 
include "modul/kelompok/form_registrasi.php";
?>
<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	//$("#DetailKelompok").load('modul/kelompok/detail.php');
	
	function deleteRow(ID) {
		var id	= ID;
	   var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/kelompok/hapus.php",
				data	: "id="+id,
				success	: function(data){
					alert('Berhasil!');
				}
			});
		}
	}
	
	function DetailKelompok(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/kelompok/detail.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tabk22').html(data);
				
			}
		});
		
	}
	
</script>
<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="fa fa-users"></i> Daftar Users SI UPK Online
		<span class="pull-right"><button data-toggle="modal" data-target="#FormInputKelompok" class="btn btn-primary width-100"><i class="fa fa-plus-circle"></i> Tambah</button></span></h3>
		<!--MODAL REGISTRASI KELOMPOK ADA DI modul/kelompok/form_registrasi.php-->
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>ID.</th>
                            <th>Data User</th>
                            <th class="hidden-xs">Penggunaan Record</th>
                            <th class="hidden-xs">Register</th>
                            <th class="hidden-xs">Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("SELECT * FROM kabupaten b, kecamatan c WHERE b.id=c.kd_kab");
								$no=0;
								while($row=mysql_fetch_array($view)){
									$no=$no+1;
									$id_kec=$row['id'];
									$kd_kab=$row['kd_kab'];
									
									$tgl_register	=$row['tgl_register'];
									$tgl_aktif		=date('Y').substr($tgl_register,4,6);
									$tgl_sekarang	=date('Y-m-d');
									if ($tgl_sekarang>$tgl_aktif) { $status_aktif="Masa Tenggang"; $warna_status="danger"; } else { $status_aktif="Aktif"; $warna_status="info"; }
									
									$table_kelompok="kelompok_$kd_kab";
									$table_anggota="anggota_$kd_kab";
									$table_pk="pinjaman_kelompok_$kd_kab";
									$table_pa="pinjaman_anggota_$kd_kab";
										
									$jum_kel=mysql_num_rows(mysql_query("select * from $table_kelompok WHERE lokasi='$id_kec' "));
									$jum_angg=mysql_num_rows(mysql_query("select * from $table_anggota WHERE lokasi='$id_kec' "));
									$jum_pinj_kel=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$id_kec'"));
									$jum_pinj_angg=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$id_kec'"));
									$jum_trx=mysql_num_rows(mysql_query("select * from transaksi_$id_kec "));
									$max_trx=mysql_fetch_array(mysql_query("select max(tgl_transaksi) as maxtgl from transaksi_$id_kec "));
								
								
							
						echo "
						<tr>
							<td class='subject hidden-xs' width='5%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'><span class='toggle badge bg-default'>$row[id]</span></td>
							<td class='subject hidden-xs' width='20%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'><b>$row[nama_lembaga_sort] $row[nama_kec]</b> <br>$row[nama_kab] $row[nama_prov]<br>$row[telpon_kec]</td>
							<td class='subject hidden-xs' width='20%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>kelompok_$kd_kab : <b>$jum_kel</b><br>pinjaman_kelompok_$kd_kab : <b>$jum_pinj_kel</b><br> anggota_$kd_kab : <b>$jum_angg</b> <br> pinjaman_anggota_$kd_kab : <b>$jum_pinj_angg</b><br>transaksi_$id_kec : <b>$jum_trx</b></td>
							<td class='subject hidden-xs' width='20%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>Reg. Awal : $row[tgl_register]<br>Masa Aktif : $tgl_aktif<br>Status : <span class='label label-$warna_status'>$status_aktif</span></td>
							<td class='subject hidden-xs' width='20%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>Data Awal : $row[tgl_pakai]<br>Data Update : $max_trx[maxtgl]<br>Status : <span class='label label-danger'>Aktif</span></td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
					Keterangan:
					<table>
						<tr><th> Icon &nbsp; &nbsp;</th><th> &nbsp; &nbsp;  &nbsp; &nbsp;Nama </th><th>Keterangan</th></tr>
						<?php
						$view=mysql_query("select * from status_pinjaman");
								while($row=mysql_fetch_array($view)){
							echo "
							<tr>
								<td><span class='toggle badge bg-$row[warna_status] pull-right'>$row[kd_status]</span></td><td>  &nbsp; &nbsp; $row[nama_status]  &nbsp; &nbsp;</td><td> $row[deskripsi]</td>
							<tr>
							";
								}
						?>
						
					</table>
            </div>
        </div>
		<div class="tab-pane" id="tabk22">
			<div id="DetailKelompok"></div>
        </div>
    </div>
	</div>
</section>