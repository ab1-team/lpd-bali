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
		<h3><i class="fa fa-users"></i> Data Base Kelompok 
		<span class="pull-right"><a href="modul/kelompok/rekap.php" target="_blank"  class="btn btn-success "><i class="glyphicon glyphicon-print"></i> Cetak </a> <button data-toggle="modal" data-target="#FormInputKelompok" class="btn btn-primary width-100"><i class="fa fa-plus-circle"></i> Tambah</button></span></h3>
		<!--MODAL REGISTRASI KELOMPOK ADA DI modul/kelompok/form_registrasi.php-->
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th><i class="fa fa-user"></i></th>
                            <th>ID</th>
                            <th>KD.KELOMPOK</th>
                            <th class="hidden-xs">Nama Kelompok</th>
                            <th class="hidden-xs">Alamat Domisili</th>
                            <th class="hidden-xs"><i class="fa fa-phone"></i> Telpon</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from desa d, kelompok_$_SESSION[kd_kab] k WHERE d.id=k.desa and k.lokasi='$_SESSION[lokasi]' order by k.id DESC");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no=$no+1;
								
								$dpa=mysql_query("select * from status_pinjaman s, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE s.kd_status=pk.status AND pk.id_kel='$row[id]'");
									$pa	=mysql_num_rows($dpa);
									if ($pa > 0){
										$r = mysql_fetch_array($dpa);
										$status =$r['kd_status']; $bg=$r['warna_status'];
										}else{ $status ="N"; $bg="default"; }
								
								$jpp=$row['jenis_produk_pinjaman']; if ($jpp=="1") { $gb="female";}else{ $gb="male";}
						echo "
						<tr>
                            <td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='5%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[id]</td>
							<td class='subject hidden-xs' width='14%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[kd_kelompok]</td>
							<td class='name hidden-xs' width='25%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[nama_kelompok]<span class='pull-right'><i class='fa fa-$gb fa-lg'></i> </span></td>
							<td class='subject hidden-xs' width='30%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[alamat_kelompok] $row[nama_desa]</td>
							<td class='subject hidden-xs' width='15%' href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[telpon]</td>
                            <td><span class='toggle badge bg-$bg pull-right'>$status</span></td>
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