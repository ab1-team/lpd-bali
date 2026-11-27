<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	function editRow(ID){
		var kd_kas = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/jeniskas/cari.php",
			data	: "kd_kas="+kd_kas,
			dataType : "json",				  
			success	: function(data){
				$('#kd_kas').val(ID);
				$('#nama_kas').val(data.nama_kas);
				$('#deskripsi').val(data.deskripsi);
			}
		});
		
	}
	function deleteRow(ID) {
		var kd_kas	= ID;
	   var pilih = confirm('Anda akan hapus data '+kd_kas+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/jeniskas/hapus.php",
				data	: "kd_kas="+kd_kas,
				success	: function(data){
					$("#TampilData").load('modul/jeniskas/tampil.php');
					alert('Berhasil!');
				}
			});
		}
	}
</script>

 <div class="widget-body">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th class="hidden-xs">Nama Kas</th>
                            <th class="hidden-xs">Deskripsi</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from jenis_kas order by kd_kas asc");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no=$no+1;
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>$row[kd_kas]</td>
							<td class='hidden-xs'>$row[nama_kas]</td>
							<td class='hidden-xs'>$row[deskripsi]</td>
                            <td><a href='javascript:editRow(\"{$row[kd_kas]}\")' data-toggle='tooltip' data-placement='left' title='Edit $row[nama_kas]'><i class='fa fa-edit'></i></a> | 
								<a href='javascript:deleteRow(\"{$row[kd_kas]}\")' data-toggle='tooltip' data-placement='right' title='Hapus $row[nama_kas]'><i class='fa fa-times'></i></a></td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>