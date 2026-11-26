<?php session_start(); ?>
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});

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
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						include "../../inc/fungsi_indotgl.php";
						
						$kd_kab	=$_SESSION['kd_kab'];
						$id_receiver	=$_SESSION['ida'];

						$view=mysql_query("select * from level l, users u, bimbingan b WHERE l.id=u.level AND u.id=b.id_sender AND b.kd_kab='$kd_kab' AND b.id_receiver='$id_receiver' order by b.id desc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>".tgl_indo($row['tanggal'])."</td>
							<td class='hidden-xs'>$row[isi]</td>
							<td class='hidden-xs'>$row[namadepan] $row[namabelakang] ($row[nama_level])</td>
						</tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>