<?php session_start();
	ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
	include "../../inc/inc.koneksi.php";
	include "../../inc/fungsi_indotgl.php";
	include "../../inc/fungsi_pinjaman.php";
	
	if ($_SESSION['jum_pinj']<=0) {
	echo "
	<div class='alert alert-danger animated fadeInDown'>
		<h3 class='text-align-center'>
			<i class='fa fa-warning'></i> Belum ada data pinjaman pada kelompok ini !
			<span class='ml-xlg'><img src='images/user.png'></span>
		</h3>
	</div>";
	}else{
			
?>			
		
                        <?php
						$view=mysql_query("SELECT * FROM		kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
																fungsi_kelompok fgs, users u, sistem_angsuran sa, status_pinjaman sp, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
																jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
																sa.id=pk.sistem_angsuran AND sp.kd_status=pk.status AND k.lokasi='$_SESSION[lokasi]' AND k.id=$_SESSION[ida] order by d.id asc");

								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$tgl_tunggu			=$row['tgl_tunggu'];
											$tgl_cair			=$row['tgl_cair'];
											$catatan_verifikasi	=$row['catatan_verifikasi'];
											$alokasi			=$row['alokasi'];
											$pros_jasa			=$row['pros_jasa'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$nama_status	=$row['nama_status'];
											$warna_status	=$row['warna_status'];
											$lu					=$row['lu'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											$nama_desa			=$row['nama_desa'];
											$kd_kelompok		=$row['kd_kelompok'];
											$nama_kelompok		=$row['nama_kelompok'];
											$alamat_kelompok	=$row['alamat_kelompok'];
											$telpon				=$row['telpon'];
											$tgl_now			=date('Y-m-d');	

											$_SESSION['id_pinj']=$id_pinj;

										$saldopinjaman=saldopinjaman("$tgl_now-$id_pinj");


						  ?>
						 <div class="panel-group mb-xs  animated fadeInDown" id="accordion2" data-toggle="collapse">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h5 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $id_pinj;?>">
											<i class="fa fa-angle-down pull-left"></i> <span class="fw-semi-bold pull-left"><?php echo tgl_ind($tgl_cair);?>  Rp. <?php echo number_format($alokasi);?></span>
											<span class="fs-mini pull-left">&nbsp;| <?php echo "$pros_jasa % @$jangka x $sistem_angsuran";?></span>. 
											<span class='label label-<?php echo $warna_status;?> pull-right'><i class="fa fa-circle"></i> <?php echo $nama_status;?></span>
											<span class='pull-right mr'>Saldo : Rp. <?php echo number_format($saldopinjaman);?></span> 
										</a>
									</h5>
								</div>
								<div id="collapse<?php echo $id_pinj;?>" class="panel-collapse collapse">
									<div class="panel-body fs-mini">
										<?php
										if ($_SESSION['level']==1) {
											
											?>	
										<div class="alert alert-<?php echo $row['warna_jpp'];?> animated fadeInDown">
											<table width="100%">
												<tr><td width="70%">
													Arsip Dokumen Pencairan<br><br>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/RA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Rencana Angsuran</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Kuasa</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/BA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Berita Acara Pencairan</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/TT.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Tanda Terima Pinjaman</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KW1.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kwitansi 1</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KW2.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kwitansi 2</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/DH.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Daftar Hadir</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kartu Angsuran</a>
													<a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_RK.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Riwayat Angsuran</a>
												</td>
												<td width="30%" class="text-align-center">Tanggal Cair<br>
													<span class="label label-<?php echo $row['warna_jpp'];?>"><?php echo tgl_indo($tgl_cair);?></span><br><br>
													Action<br>
													<a disabled="disabled" href="" data-toggle="modal" data-target="#myModalCair<?php echo $id_pinj;?>" class="btn btn-<?php echo $row['warna_jpp'];?> btn-rounded width-200 mb-xs"><i class="fa fa-legal"></i> Validasi Lunas !</a>
													<!--File Modal ada di modul/pinjaman/pinjaman.php-->
												</td>
												</tr>
											</table>
										</div>
											<?php } ?>
										
											
											<?php
					echo "					<hr>
											
										<div class='col-md-8'>
											<span class='fw-semi-bold'>RIWAYAT PROSES</span>
											<table width='100%' class='table'>
												<tr class='bg-body'>
												  <th width='20%'>Reg. $id_pinj </th>
											      <th width='20%'>Tanggal</th>
											      <th width='20%'>Alokasi</th>
											      <th width='10%'>Jasa</th>
										          <th width='10%'>Jangka</th>
									              <th width='15%'>Sistem</th>
												</tr>
												<tr>
												  <th>Proposal</th>
												  <td>$tgl_proposal</td>
												  <td>".number_format($proposal)."</td>
												  <td>$pros_jasa %</td>
												  <td>$jangka kali</td>
												  <td>$sistem_angsuran</td>
												</tr>
												<tr>
												  <th>Verifikasi</th>
												  <td>".tgl_ind($tgl_verifikasi)."</td>
												  <td>".number_format($alokasi)."</td>
												  <td>$pros_jasa %</td>
												  <td>$jangka kali</td>
												  <td>$row[nama_sistem]</td>
												</tr>
												<tr>
												  <th>Daftar Tunggu</th>
												  <td>".tgl_ind($tgl_tunggu)."</td>
												  <td>".number_format($alokasi)."</td>
												  <td>-</td>
												  <td>-</td>
												  <td>-</td>
												</tr>
												<tr>
												  <th>Pencairan</th>
												  <td>".tgl_ind($tgl_cair)."</td>
												  <td>".number_format($alokasi)."</td>
												  <td>$pros_jasa %</td>
												  <td>$jangka kali</td>
												  <td>$row[nama_sistem]</td>
												</tr>
												<tr>
													<td colspan='6'>&nbsp</td>
												</tr>
											</table>
										</div>
										<div class='col-md-4'>
											<div class='form-group'>
												<div class='col-sm-12'>
													<i class='fa fa-pencil'></i> Catatan Verifikasi :
													<textarea rows='8' class='form-control' placeholder='$catatan_verifikasi' disabled></textarea>
												</div>
											</div>
										</div>
										";						
					echo "				<div class='col-md-12 mt-n-xlg'>		
											<span class='fw-semi-bold'>ANGGOTA PEMANFAAT</span>
											<table width='100%' class='table table-hover'>
												<tr class='bg-body'>
												  <th width='2%'>NO </th>
											      <th width='14%'>NIK</th>
											      <th width='14%'>Nama Lengkap</th>
											      <th width='14%'>Alamat</th>
										          <th width='10%'>Proposal</th>
									              <th width='10%'>Rekomendasi</th>
												  <th width='27%'>Catatan Verifikasi</th>
												<tr>";
	$dpa=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE d.id=a.desa AND a.id=pa.nia AND pa.id_pinkel='$id_pinj' AND pa.id_kel='$id_kel' ");
		while($pa=mysql_fetch_array($dpa)){
		$nom=$nom+1;	
		$idpa=$pa['id'];
		$proposala=$pa['proposal'];
		$alokasia=$pa['alokasi'];
		$catatan_anggota=$pa['catatan_anggota'];
					echo						"	<tr>
												  <td>$nom </td>
												  <td>$pa[nik] </td>
												  <td>"; ?>
												  <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/c_dra.php?&rcp=<?php echo $pa['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" data-toggle="tooltip" data-placement="left" title="Profil & Riwayat <?php echo $pa['namadepan'];?>"><i class="glyphicon glyphicon-user"></i></a>
				<?php echo "					  $pa[namadepan] </td>
												  <td>$pa[alamat] $pa[nama_desa] </td>
												  <td class='text-align-right'>".number_format($proposala)." </td>
												  <td class='text-align-right'>".number_format($alokasia)." </td>
												  <td>$catatan_anggota</td>
												</tr>";
												
											$sumproposal=$sumproposal+$proposala;	
											$sumalokasi=$sumalokasi+$alokasia;	
											}										
					echo					"
												<tr>
												  <th colspan='4'>&nbsp</th>
												  <th>".number_format($sumproposal)." </th>
												  <th class='text-align-right'>".number_format($sumalokasi)." </th>
												  <th >&nbsp </td>
												<tr>
											</table>
										</div>"; ?>
					
									<div id="TampilRiwayat"></div>
									
									</div>
									
								</div>
							</div>
						</div>
					
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
			
			
	$("#TampilRiwayat").load('modul/kelompok/tampil_riwayat.php');			
	
</script>

					
					
<?php 
}
}
 ?>					