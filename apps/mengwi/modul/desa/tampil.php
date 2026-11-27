<?php session_start(); ?>
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	function editRow(ID){
		var id_desa = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/desa/cari.php",
			data	: "id_desa="+id_desa,
			dataType : "json",				  
			success	: function(data){
				$('#id_desa').val(ID);
				$('#kd_desa').val(data.kd_desa);
				$('#nama_desa').val(data.nama_desa);
				$('#kades').val(data.kades);
				$('#nip').val(data.nip);
				$('#pangkat').val(data.pangkat);
				$('#no_kades').val(data.no_kades);
				$('#sekdes').val(data.sekdes);
				$('#no_sekdes').val(data.no_sekdes);
				$('#ked').val(data.ked);
				$('#no_ked').val(data.no_ked);
				$('#deskripsi_desa').val(data.deskripsi_desa);
				$('#jadwal_angsuran_desa').val(data.jadwal_angsuran_desa);
				$('#uname').val(data.uname);
				$('#pass').val(data.pass);
			}
		});
		
	}
</script>

 <div class="widget-body">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode Desa</th>
                            <th class="hidden-xs">Nama Desa</th>
                            <th class="hidden-xs">Nama Kades</th>
                            <th class="hidden-xs">tgl</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						if($_SESSION['level']=="desa") {
							$view=mysql_query("select * from desa where id='$_SESSION[id]' ");	
								} else {
							$view=mysql_query("select * from kecamatan c, desa d where c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' order by d.id asc");
								}
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no=$no+1;
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>$row[kd_desa]</td>
							<td class='hidden-xs'>$row[nama_desa]</td>
							<td class='hidden-xs'>$row[kades]</td>
							<td class='hidden-xs'>$row[jadwal_angsuran_desa]</td>
                            <td><a href='javascript:editRow($row[id])' data-toggle='tooltip' data-placement='left' title='Edit & Detail $row[nama_desa]'><i class='glyphicon glyphicon-arrow-right'></i></a></td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>