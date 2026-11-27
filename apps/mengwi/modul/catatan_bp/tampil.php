<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	

		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
	function deleteRow(ID) {
		var id	= ID;
	   var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/catatan_bp/hapus.php",
				data	: "id="+id,
				success	: function(data){
					$("#TampilData").load('modul/catatan_bp/tampil.php');
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
                            <th width="5%">No</th>
                            <th width="10%">Kode Catatan</th>
                            <th width="10%" class="hidden-xs">Bulan Laporan</th>
                            <th width="60%" class="hidden-xs">Deskripsi</th>
							<th width="10%" class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						include "../../inc/fungsi_indotgl.php";
						$view=mysql_query("SELECT * FROM catatan_bp WHERE lokasi='$_SESSION[lokasi]' order by bulan_laporan DESC");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no				= $no+1;
								$bulan_laporan	= $row['bulan_laporan'];
								$bulan 			= getBulan(substr($bulan_laporan,5,2));
								$tahun			= substr($bulan_laporan,0,4);
						echo "
						<tr>
                            <td>$no</td>
							<td class='hidden-xs'>$row[id]</td>
							<td class='hidden-xs'>$bulan $tahun</td>
							<td class='hidden-xs'>".if(substr($row['isi'],51,0)==""){echo $row['isi'];}else{echo substr($row['isi'],0,50) ..............;}"</td>
                            <td><!---------------<a href='javascript:editRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='left' title='Edit Kode $row[id]'><i class='fa fa-edit'></i></a> | 
								---><a href='javascript:deleteRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='right' title='Hapus Kode $row[id]'><i class='fa fa-times'></i></a> | "; ?>
								
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/BP.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"> <i class='fa fa-print'></i> </a></td> <?php echo "
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
                </div>
            </div>