<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	
	function editanggota(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/penduduk/cari.php",
			data	: "id="+id,
			dataType : "json",				  
			success	: function(data){
				$('#id').val(ID);
				$('#nik').val(data.nik);
				$('#namadepan').val(data.namadepan);
				$('#jk').val(data.jk);
				$('#tempat_lahir').val(data.tempat_lahir);
				$('#tgl_lahir').val(data.tgl_lahir);
				$('#alamat').val(data.alamat);
				$('#desa').val(data.desa);
				$('#lokasi').val(data.lokasi);
				$('#hp').val(data.hp);
				$('#kk').val(data.kk);
				$('#penjamin').val(data.penjamin);
				$('#hubungan').val(data.hubungan);
				$('#usaha').val(data.usaha);
				//$('#foto').val(data.foto);
				$('#terdaftar').val(data.terdaftar);
				$('#status').val(data.status);
				$('#petugas').val(data.petugas);
				$('#online').val(data.online);
				$('#lo').val(data.lo);
				$('#uname').val(data.nik);
				$('#pass').val(data.pass);
				
			}
		});
		
	}

	
	function DetailAnggota(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/penduduk/detail/account.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tab2').html(data);
				
			}
		});
		
	}
</script>
<section class="widget">
 <div class="widget-body">
 <legend>
		<h3><i class="fa fa-user"></i> Data Base Anggota UPK</h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tab1">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th><i class="fa fa-user"></i></th>
                            <th>N i k</th>
                            <th class="hidden-xs">Nama Lengkap</th>
                            <th class="hidden-xs">Alamat Domisili</th>
                            <th class="hidden-xs"><i class="fa fa-phone"></i> Telpon</th>
                            <th class="hidden-xs"><i class="fa fa-group"></i> Group</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from desa d, pinjaman_anggota_$_SESSION[kd_kab] pa, anggota_$_SESSION[kd_kab] a WHERE d.id=a.desa AND a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' order by a.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no=$no+1;
								
								$kel=mysql_fetch_array(mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] WHERE id='$row[id_kel]' "));
								
								if($row['jenis_pinjaman']=='K') {
													$jenis_pinjaman=$kel['nama_kelompok'];
												} else {
													$jenis_pinjaman="Individu";
												}
								
								$dpa=mysql_query("select * from status_pinjaman s, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE s.kd_status=pa.status AND pa.nia='$row[id]'");
									$pa	=mysql_num_rows($dpa);
									if ($pa > 0){
										$r = mysql_fetch_array($dpa);
										$status =$r['kd_status']; $bg=$r['warna_status'];
										}else{ $status ="N"; $bg="default"; }
								
								$jk=$row['jk']; if ($jk=="L") { $gb="male";}else{ $gb="female";}
						echo "
						<tr>
                            <td><span class='toggle badge bg-default'>$no</span></td>
							<td class='subject hidden-xs' width='14%' href='#tab2' onclick='javascript:DetailAnggota(\"{$row[id]}\")' data-toggle='tab'>$row[nik]</td>
							<td class='subject hidden-xs' width='26%' href='#tab2' onclick='javascript:DetailAnggota(\"{$row[id]}\")' data-toggle='tab'>$row[namadepan]<span class='pull-right'><i class='fa fa-$gb fa-lg'></i> </span></td>
							<td class='subject hidden-xs' width='25%' href='#tab2' onclick='javascript:DetailAnggota(\"{$row[id]}\")' data-toggle='tab'> $row[alamat] $row[nama_desa]</td>
							<td class='subject hidden-xs' width='15%' href='#tab2' onclick='javascript:DetailAnggota(\"{$row[id]}\")' data-toggle='tab'>$row[hp]</td>
							<td class='subject hidden-xs' width='20%' href='#tab2' onclick='javascript:DetailAnggota(\"{$row[id]}\")' data-toggle='tab'>$jenis_pinjaman</td>
                            <td><span class='toggle badge bg-$bg pull-right'>$status</span></td>
                        </tr> ";
						 } 
						 //<a href='#tab2' onclick='javascript:editanggota(\"{$row[id]}\")' data-toggle='tab' title='Edit $row[namadepan]'><span class='toggle label bg-primary'><i class='fa fa-edit'></i></span></a>
						 ?>
                        </tbody>
                    </table>
                </div>
			</div>
		<div class="tab-pane" id="tab2">
			<div id="DetailDataAnggota"></div>
        </div>
    </div>
</div>
</section>