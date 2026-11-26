<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
include "../../../inc/fungsi_pinjaman_individu.php";
$id		= $_POST['idp'];

$_SESSION['idprop']	= $id;
$_SESSION['id_pinkel']	= $id;
$_SESSION['id_pinj']	= $id;
$row=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
		WHERE a.id=pi.nia AND pi.id='$id'"));

$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$row[jenis_jasa]'"));			
$sap=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$row[sistem_angsuran]'"));			
$saj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$row[sa_jasa]'"));			
$stt=mysql_fetch_array(mysql_query("select * FROM status_pinjaman WHERE kd_status='$row[status]'"));			

$_SESSION['ida']		=$row['nia']; //Dikirim ke penduduk/detail/tampil_data.php
$_SESSION['proposal']	=$row['proposal'];		
$_SESSION['id_pinj_i']	=$row['id'];	//Dikirim ke modul/pinjaman/register/input_pinjaman_individu.php	
$_SESSION['nika']		=$row['nik'];	//Dikirim ke modul/pinjaman/register/input_pinjaman_individu.php		
$sts					=$row['status'];
$spk_no					=$row['spk_no'];
$_SESSION['sts']		=$sts;	
$nia					=$row['nia'];
$idpinj					=$row['id'];
$jenis_pp				=$row['jenis_pp'];
$tgl_now				=date('Y-m-d');
$saldopinjaman			=saldopinjaman("$tgl_now-$idpinj");

$level		=$_SESSION['level'];
$jabatan	=$_SESSION['jabatan'];
$levjab		="$level.$jabatan";
?>

<head>
	<script>
		$(document).ready(function(){
		  $(".preloader").fadeOut("slow");
		})
	</script>
</head>
<div class="preloader">
	<div class="loading">
		<img src="images/animation.gif" width="280">
	</div>
</div>
  
<div class="modal-content">
	<div class="modal-header bg-primary">
		<h5 class="modal-title fw-normal" id="LabelDetailProposalIndividu">
			<i class="fa fa-book"></i> DETAIL PINJAMAN <?php echo $row['nik'];?> - <span class="fw-semi-bold"> <?php echo strtoupper($row['namadepan']);?></span> Loan ID. <?php echo "$row[id]";?> <span class='badge bg-danger'><?php echo strtoupper($stt['nama_status']);?></span>
			<ul class="tags pull-right">
				<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
			</ul>
		</h5>
	</div>

<div class="modal-body" style="overflow: scroll; height: 600px;">


<div class="animated fadeInDown mt-n-sm">
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
						
						<li class=""><a href="#tab14" data-toggle="tab"><i class="fa fa-building"></i> Data Usulan Pinjaman</a></li>
						<li class=""><a href="#tab24" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Identitas Pemanfaat</a></li>
						<li class="<?php if ($sts=="P" OR $sts=="V1" OR $sts=="V2" OR $sts=="V3" OR $sts=="W" AND $levjab!="1.3") { echo "active"; }elseif ($sts=="W" AND $levjab=="1.3") { echo ""; } ?>"><a href="#tab35" data-toggle="tab"><i class="glyphicon glyphicon-cog"></i> Proses Rekomendasi Kredit</a></li>
						
						<?php if ($sts=="W") {?>
						<li class="<?php if ($levjab=="1.3") { echo "active"; } ?>"><a href="#tabCair" data-toggle="tab"><i class="glyphicon glyphicon-list"></i> Form Pencairan</a></li>
						<?php } elseif ($sts=="A" AND $saldopinjaman!=0) {?>
						<li class="active"><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a></li>
						<li class=""><a href="#tabR" data-toggle="tab"><i class="fa fa-history"></i> Resceduling</a></li>
						<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
						<li class=""><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a></li>
						<li class="active"><a href="#tab84" data-toggle="tab"><i class="fa fa-gavel"></i> Validasi Pelunasan</a></li>
						<?php } ?>
                    </ul>
                    <div id="tabs3c" class="tab-content">
					
						<div class="tab-pane" id="tab14">
							<legend>
								<i class="fa fa-building"></i> Data Pinjaman
								<?php if ($sts=="P") { ?>
								<span class="pull-right">
									<a href="#tabX"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-times"></i> Hapus Proposal</a>
								</span>
								<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
								<span class="pull-right">
									<a href="#tab84"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-gavel"></i> Validasi Pelunasan</a>
								</span>
								<?php } ?>
							</legend>
							<div id="DataProposal"></div>
							<div id="EditBerhasil"></div>	
                        </div>
						
						
						<div class="tab-pane" id="tab24">
							<header>
								<legend><i class="glyphicon glyphicon-user"></i> Identitas Pemanfaat</legend>
							</header>
								<div id="TampilDataPemanfaat"></div>
                        </div>
						
						<div id="tab35" class="tab-pane <?php if ($sts=="P" OR $sts=="V1" OR $sts=="V2" OR $sts=="V3" OR $sts=="W" AND $levjab!="1.3") { echo "active"; }elseif ($sts=="W" AND $levjab=="1.3") { echo ""; } ?>" >
								<div id="InputRekomendasiKredit"></div>
						</div>
						
						<div id="tabCair" class="tab-pane <?php if ($sts=="W" AND $levjab=="1.3") { echo "active"; } ?>" >
								<div id="FormPencairanIndividu"></div>
						</div>

						<div class="tab-pane <?php if ($sts=="A" AND $saldopinjaman!=0) { echo "active"; } ?>" id="tab74">
							<legend>
								<i class="fa fa-history"></i> Riwayat Transaksi

								<ul class="tags pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_KartuAngsuranLuar.php?&idp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini fw-semi-bold">Kartu Angsuran Luar</span></a></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_KartuAngsuranDalam.php?&idp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini fw-semi-bold">Kartu Angsuran Dalam</span></a></li>
									<li><a href="modul/pelaporan/pdf/RKP.php?&idp=<?php echo $idpinj;?>" target="_blank"><span class="fs-mini fw-semi-bold">Rekening Koran</span></a></li>
									<li><a href="modul/pinjaman/cp/i_LPP.php?&idp=<?php echo $row['id'];?>" target="_blank"> <span class="fs-mini fw-semi-bold">Perkembangan Pinjaman <i class="glyphicon glyphicon-print"></i></span></a></li>
								</ul>
							</legend>
							<div id="RiwayatTransaksiIndividu"></div>
						</div>
						
						<div class="tab-pane <?php if ($sts=="A" AND $saldopinjaman==0) { echo "active"; } ?>" id="tab84">
							<div id="ValidasiPelunasanIndividu"></div>
						</div>
						
						<div class="tab-pane" id="tabX">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Hapus Proposal
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menghapus data proposal Pinjaman Individu<br>
								Dengan klik tombol "YA" maka proposal akan hilang, namun data penduduk YBS masih ada.<br>
								Apakah anda akan menghapus proposal ini?
								</p>
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<?php echo "<a href='javascript:deleteProposal(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-times'></i>  Ya, Hapus Proposal</a>"; ?>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
						
						<div class="tab-pane" id="tabR">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Resceduling Pinjaman
							</legend>
							
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menjadwal ulang (Resceduling) Pinjaman, 
								Dengan klik tombol "YA" maka pinjaman ini akan berstatus R, dan akan membuat pinjaman baru dengan Alokasi sebesar saldo yang ada, yaitu
								Rp. <?php echo number_format($saldopinjaman);?><br>
								</p>
									<input type="hidden"  value="<?php echo $nia;?>" id="niares" />
									<input type="hidden"  value="<?php echo $idpinj;?>" id="idpinjres" />
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Tanggal</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" name="tglres" id="tglres" 
                                                autocomplete="off" placeholder="Tanggal">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Alokasi</label>
                                            <input type="text" class="form-control" value="<?php echo $saldopinjaman;?>" name="alokasires" id="alokasires" 
                                                autocomplete="off" placeholder="Alokasi">
											<input type="hidden" value="<?php echo $saldopinjaman;?>" name="saldopinjamanres" id="saldopinjamanres" >
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Jangka</label>
                                            <input type="text" class="form-control" value="<?php echo $row['jangka'];?>" name="jangkares" id="jangkares" 
                                                autocomplete="off" placeholder="Jangka">
                                    </div>
									
							</div>
							<div class="col-sm-6">
							<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Prosentase Jasa</label>
                                            <input type="text" class="form-control" value="<?php echo $row['pros_jasa'];?>" name="pros_jasares" id="pros_jasares" 
                                                autocomplete="off" placeholder="Jasa">
                                    </div>
								<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jenis Jasa</label>
														<select id="jenis_jasares"  name="jenis_jasares"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[jenis_jasa]'>$jj[nama_jj]</option>";
																$views=mysql_query("select * from jenis_jasa");
																	while($rowres=mysql_fetch_array($views)){
																	echo "<option value='$rowres[id]'>$rowres[nama_jj]</option>";
																	} ?>
														</select>
													</div>
									
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Pokok</label>
														<select id="sistemres"  name="sistemres"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$sap[nama_sistem]</option>";
																$views=mysql_query("select * from sistem_angsuran");
																	while($rowres=mysql_fetch_array($views)){
																	echo "<option value='$rowres[id]'>$rowres[nama_sistem]</option>";
																	} ?>
														</select>
													</div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Bunga</label>
														<select id="sa_jasares"  name="sa_jasares"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$saj[nama_sistem]</option>";
																$views=mysql_query("select * from sistem_angsuran");
																	while($rowres=mysql_fetch_array($views)){
																	echo "<option value='$rowres[id]'>$rowres[nama_sistem]</option>";
																	} ?>
														</select>
													</div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Action</label>
										<div id="RescedulingBerhasil"></div>	
										<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded">Kembali</a>
										<a href="" class='btn btn-inverse btn-rounded pull-right' id="SimpanRescedulingIndividu"><i class='fa fa-times'></i>  Ya, Resceduling pinjaman ini</a>
									</div>
							</div>
						</div>

                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>

      <script type="text/javascript">
			
			function deleteProposal(ID) {
				var id_a	= ID;
			   var pilih = confirm('Apakah anda yakin akan menghapus Loan ID '+id_a+ '?');
				if (pilih==true) {
					$.ajax({
						type	: "POST",
						url		: "modul/pinjaman/register/hapus_pemanfaat.php",
						data	: "id_a="+id_a,
						success	: function(data){
							window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=P';
						}
					});
				}
			}
			
			
			
	
	
	$(document).ready(function() {

			$("#proposali").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#DataProposal").load('modul/pinjaman/register/input_pinjaman_individu.php');
				$("#TampilDataPemanfaat").load('modul/penduduk/detail/tampil_data.php');
				$("#InputRekomendasiKredit").load('modul/pinjaman/proposal/input_rekomendasi_kredit.php');
				$("#FormPencairanIndividu").load('modul/pinjaman/waiting/form_cair_individu.php');
				$("#RiwayatTransaksiIndividu").load('modul/jurnal_angsuran/tampil_buku_angsuran_individu.php');
				$("#ValidasiPelunasanIndividu").load('modul/pinjaman/validasi_lunas/validasi_individu.php');
             
					
			$("#SimpanRescedulingIndividu").click(function() {
				var niares				= $('#niares').val();
				var idpinjres			= $('#idpinjres').val();
				var jenis_ppres			= $('#jenis_ppres').val();
				var jenis_ppasli		= $('#jenis_ppasli').val();
				var tglres				= $('#tglres').val();
				var alokasires			= $('#alokasires').val();
				var saldopinjamanres	= $('#saldopinjamanres').val();
				var pros_jasares		= $('#pros_jasares').val();
				var jenis_jasares		= $('#jenis_jasares').val();
				var jangkares			= $('#jangkares').val();
				var sistemres			= $('#sistemres').val();
				var sa_jasares			= $('#sa_jasares').val();
					var pilih = confirm('Apakah yakin akan rescedulling Pinjaman Individu ini?');
					if (pilih==true) {
						$.ajax({
						
						type: "POST",
						url: "modul/pinjaman/proposal/simpan_resceduling_individu.php",
						data: 	"niares="+niares+
						"&idpinjres="+idpinjres+
						"&jenis_ppres="+jenis_ppres+
						"&jenis_ppasli="+jenis_ppasli+
						"&tglres="+tglres+
						"&alokasires="+alokasires+
						"&saldopinjamanres="+saldopinjamanres+
						"&pros_jasares="+pros_jasares+
						"&jenis_jasares="+jenis_jasares+
						"&jangkares="+jangkares+
						"&sistemres="+sistemres+
						"&sa_jasares="+sa_jasares,
							success: function(data) {
									window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=A&s=suksesRC';
								}
						});
					}
			});
			
			
			});
			
		
        </script>
