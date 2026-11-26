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

<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th><i class="fa fa-user"></i></th>
                            <th>ID</th>
                            <th>KODE KELOMPOK</th>
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
							<td class='hidden-xs' width='5%'>$row[id]</td>
							<td class='hidden-xs' width='14%'>$row[kd_kelompok]</td>
							<td class='hidden-xs' width='25%'>$row[nama_kelompok]<span class='pull-right'><i class='fa fa-$gb fa-lg'></i> </span></td>
							<td class='hidden-xs' width='25%'>$row[alamat_kelompok] $row[nama_desa]</td>
							<td class='hidden-xs' width='10%'>$row[telpon]</td>
                            <td>
								<a href='#tabk22' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab' title='Detail $row[namadepan]'><span class='toggle label bg-primary'><i class='glyphicon glyphicon-arrow-right'></i></span></a>
								<a href='javascript:deleteRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='left' title='Hapus $row[namadepan]'><span class='toggle label bg-primary'><i class='fa fa-times'></i></span></a>
								<span class='toggle badge bg-$bg pull-right'>$status</span>
							</td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
            </div>
        </div>
		<div class="tab-pane" id="tabk22">
			<div id="DetailKelompok"></div>
        </div>
    </div>