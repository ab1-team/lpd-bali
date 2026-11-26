<?php session_start(); ?>
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	function deleteRow(ID) {
		var id	= ID;
		var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/kelompok/hapus_catatan.php",
				data	: "id="+id,
				success	: function(data){
					location.reload();
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
                            <th>Tanggal</th>
                            <th class="hidden-xs">Isi Bimbingan/Hasil Kunjungan</th>
                            <th class="hidden-xs">Visitors</th>
                            <th class="hidden-xs">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						include "../../inc/fungsi_indotgl.php";
						
						$kd_kab	=$_SESSION['kd_kab'];
						$id_receiver	=$_SESSION['ida'];

						$view=mysql_query("select * from level l, users u, bimbingan b WHERE l.id=u.level AND u.id=b.id_sender AND b.kd_kab='$kd_kab' AND b.id_receiver='$id_receiver'  AND b.kd_kab='$_SESSION[kd_kab]' order by b.id desc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>".tgl_indo($row['tanggal'])."</td>
							<td class='hidden-xs'>$row[isi]</td>
							<td class='hidden-xs'>$row[namadepan] $row[namabelakang] ($row[nama_level])</td>
							<td width='10%'>
								<a href='javascript:deleteRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='left' title='Hapus catatan no. $no'><span class='toggle label bg-primary'><i class='fa fa-times'></i></span></a>
							</td>
						</tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>