<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";

if(!empty($_POST['nik'])) {
	$nik	= $_POST['nik'];
}else{
	$nik	= $_SESSION['nika'];
}

$action	=$_POST['action'];

if(!empty($_POST['id'])) {
	$id	= $_POST['id'];
}else{
	$id	=$_SESSION['id_pinj_i'];
}

$text	= "SELECT * FROM $table WHERE nik= '$nik' ";

$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
$des=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));

if ($row>0){
	$r=mysql_fetch_array($sql); 
	
	?>

<?php if($action=="tambah") { ?>
<div class="modal-header bg-primary">
	<h4 class="modal-title fw-normal" id="LabelProposal">
		<i class='glyphicon glyphicon-user'></i> Formulir Permohonan Pinjaman Baru | a.n. <?php echo $r['namadepan'];?> 
		<ul class="tags pull-right">
			<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i></span></a></li>
		</ul>
	</h4>
</div>
<?php } ?>

<div class="modal-body" <?php if($action=="tambah") { echo 'style="overflow: scroll; height: 450px;"'; } ?> >

<?php
$sqlmut=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$r[id]' AND `status`='P' OR nia='$r[id]' AND `status`='V1' OR nia='$r[id]' AND `status`='V2' OR nia='$r[id]' AND `status`='V3' OR nia='$r[id]' AND `status`='W' OR nia='$r[id]' AND `status`='M' ");
$lacakmut	= mysql_num_rows($sqlmut);
if ($lacakmut>0 AND $action=="tambah"){
		$pa=mysql_fetch_array($sqlmut);
		echo "
			<div class='alert alert-danger'>
				<i class='fa fa-warning'></i> <strong>Perhatian</strong> 
				<br>Anda tidak dapat menambahkan Pinjaman Baru, YBS terdeteksi telah memiliki proposal pinjaman ($pa[jenis_pinjaman]) Dalam Proses sebesar ".number_format($pa['alokasi'])." dengan status $pa[status]
			</div>
		";
}else{

$dat=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id='$id' ");
$jump	= mysql_num_rows($dat);
if($jump>0 AND $action!="tambah") {
	
	$pe=mysql_fetch_array($dat);

	if($pe['status']!="P") {
		
		$disabled ="disabled";
		
	}
	
	$id_pinj_i		=$pe['id'];
	$no_rekening	=$pe['no_rekening'];
	$dpr 			= explode("#", $pe['data_proposal']);
	$tgl_proposal	=$dpr[0];
	$proposali		=$dpr[1];
	$jangka			=$dpr[2];
	$pros_jasa		=$dpr[3];
	$jenis_jasa		=$dpr[4];
	$sistem			=$dpr[5];
	$sa_jasa		=$dpr[6];
	$tujuan_permohonan	=$dpr[7];
	$biaya_admin	=$dpr[8];
	$mtr	= explode("#", $pe['materai']);
	$materai = $mtr[0];
	$jum_materai = $mtr[1];
	
	$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$jenis_jasa'"));			
	$sap=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sistem'"));			
	$saj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sa_jasa'"));	
	$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$tujuan_permohonan'"));	
	
	

	$pend 		= explode("#", $pe['pendapatan']);
	$biaya 		= explode("#", $pe['biaya']);
	$aktiva 	= explode("#", $pe['aktiva']);
	$pasiva 	= explode("#", $pe['pasiva']);
	
}else {
	
		$des=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));
	
	$lok	=$_SESSION['lokasi'];
 
	$nkred	=$des['last_debitur']+1;

	
		 if($lok<10) {$lokasi="000$lok";}
	else if($lok>=10 AND $lok<100) {$lokasi="00$lok";}
	else if($lok>=100 AND $lok<1000) {$lokasi="0$lok";}
	else if($lok>=1000 AND $lok<10000) {$lokasi="$lok";}
	
		 if($nkred<10) {$nkred="000$nkred";}
	else if($nkred>=10 AND $nkred<100) {$lkred="00$nkred";}
	else if($nkred>=100 AND $nkred<1000) {$lkred="0$nkred";}
	else if($nkred>=1000 ) {$lkred="$nkred";}
	
	$no_rekening	="$lokasi.1.12.$lkred";
	
	
	$tgl_proposal=date('Y-m-d');
	$jangka			=$des['def_jangka'];
	$pros_jasa		=$des['def_jasa'];
	$biaya_admin	="3";
	$proposali		="";
	$dpr			="";
	$materai        ="10000";
	$jum_materai    ="2";
	$jaminan		=explode("#","0#");
	$pend			=explode("#","0#0#0");
	$biaya			=explode("#","0#0#0#0#0#0#0#0");
	$aktiva			=explode("#","0#0#0#0#0#0");
	$pasiva			=explode("#","0#0#0");
}



?>
<div class="clearfix mt-n-sm">
                    <ul id="tabs1" class="nav nav-tabs pull-left"> <!-- remove pull-left to get a cool effect too -->
                        <li class="active"><a href="#tab1" data-toggle="tab">Data Pengajuan Pinjaman</a></li>
                        <li class=""><a href="#tab2" data-toggle="tab">Pendapatan dan Pengeluaran</a></li>
                        <li class=""><a href="#tab3" data-toggle="tab">Neraca Keuangan</a></li>
                        <li class=""><a href="#tab4" data-toggle="tab">Aspek Jaminan</a></li>
                    </ul>
                </div>
                <div id="tabs1c" class="tab-content">
                    <div class="tab-pane active clearfix" id="tab1">
                        
                   
				
	<div class='row'>
		<div class='col-sm-6'>
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
								
									<input type="hidden" name="nia" id="nia" value="<?php echo $r['id']?>" >
									<input type="hidden" name="id_pinj_i" id="id_pinj_i" value="<?php echo $id_pinj_i;?>" >
                                        
										<label class='fs-sm'>Nomor Rekening</label>
                                        <input type='text' value="<?php echo $no_rekening ?>" name='no_rekening' class='form-control' id='no_rekening' disabled="disabled"
										required='required' autocomplete='off' placeholder='Nomor Rekening'>
                                    <br>
									<label class='fs-sm'>Tanggal Proposal</label>
                                        <input type='text' value="<?php echo $tgl_proposal ?>" name='tgl_proposal' class='form-control' id='tgl_proposal' <?php echo $disabled ?>
										required='required' autocomplete='off' placeholder='Tanggal Proposal'>
                                    <br>
                                        <label class="fs-sm">Pengajuan Rp.</label>
                                        <input type="text" value="<?php echo number_format($proposali,0,",",".") ?>" name="proposali" class="form-control" id="proposali"  <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" 
										required="required" autocomplete="off" placeholder="Alokasi Pengajuan" >
                                    <br>
									
									<div class="col-sm-4">
										<label class='fs-sm'>Jangka (Bulan)</label>
										<input type='text' name="jangka" class="form-control" id="jangka" value="<?php echo $jangka ?>"  <?php echo $disabled ?>
											required='required' autocomplete='off' placeholder='Jangka Waktu (Bulan)'>
											<br>
									</div>    
									<div class="col-sm-4">    
										<label class="fs-sm">Jasa (%)</label>
                                        <input type="text" name="pros_jasa" class="form-control" id="pros_jasa" value="<?php echo $pros_jasa ?>"  <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Prosentase Jasa (%)">
										<br>
									</div>
									<div class="col-sm-4">    
										<label class="fs-sm">By.Admin (%)</label>
                                        <input type="text" name="biaya_admin" class="form-control" id="biaya_admin" value="<?php echo $biaya_admin ?>"  <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Biaya Administrasi (%)">
										<br>
									</div>
									<div class="col-sm-4">    
										<label class="fs-sm">Jenis Materai </label>
                                        <input type="text" name="materai" class="form-control" id="materai" value="<?php echo $materai ?>"  <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Jenis Materai ">
										<br>
									</div>
									<div class="col-sm-4">    
										<label class="fs-sm">Jumlah Materai </label>
                                        <input type="text" name="jum_materai" class="form-control" id="jum_materai" value="<?php echo $jum_materai ?>"  <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Jumlah Materai ">
										<br>
									</div>
								</fieldset>
						</div>
					</div>
			</section>
		</div>
		<div class="col-sm-6">
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
                                    
										<label class="fs-sm">Metode Perhitungan Jasa</label>
											<select id='jenis_jasa'  name='jenis_jasa' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$jenis_jasa'>$jj[nama_jj]</option>";
												}
														$data=mysql_query('select * from jenis_jasa ORDER BY warna_jj DESC'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jj] ($row[deskripsi_jj])</option>";
															}
															?>
											</select>
                                    <br>
										<label class='fs-sm'>Sistem Angsuran Pokok</label>
											<select id='sistem'  name='sistem' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$sistem'>$sap[nama_sistem]</option>";
												}
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
															?>
											</select>
                                    <br>
										<label class='fs-sm'>Sistem Angsuran Jasa</label>
											<select id='sa_jasa'  name='sa_jasa' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$sa_jasa'>$saj[nama_sistem]</option>";
												}
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
															?>
											</select>
                                    <br>    
										<label class="fs-sm">Tujuan Permohonan</label>
										<select id='tujuan_permohonan'  name='tujuan_permohonan' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$tujuan_permohonan'>$tp[nama_tujuan]</option>";
												}
														$data=mysql_query('select * from tujuan_pinjaman'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_tujuan]</option>";
															}
															?>
											</select>
									<br>
										
								</fieldset>
						</div>
					</div>
			</section>
		</div>
			
			
	</div>
	
</div>
<div class="tab-pane" id="tab2">
	<div class='row'>
		<div class='col-sm-6'>
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<legend class="fw-semi-bold">
										Pendapatan
									</legend>
                                        <label class='fs-sm'>Penghasilan Pemohon</label>
                                        <input type="text" value="<?php echo $pend[0]; ?>" name="penghasilan_pemohon" id="penghasilan_pemohon"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Penghasilan Pemohon">
                                    <br>
                                        <label class='fs-sm'>Penghasilan Suami/Istri</label>
                                        <input type="text" value="<?php echo $pend[1]; ?>" name="penghasilan_sutri" id="penghasilan_sutri"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Penghasilan Suami/Istri">
                                    <br>
                                        <label class='fs-sm'>Penghasilan Lainnya</label>
                                        <input type="text" value="<?php echo $pend[2]; ?>" name="penghasilan_lain" id="penghasilan_lain"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Penghasilan Lainnya">
                                    <br>
								</fieldset>
						</div>
					</div>
			</section>
		</div>
		<div class="col-sm-6">
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<legend class="fw-semi-bold">
										Biaya
									</legend>
                                        <label class='fs-sm'>Pangan</label>
                                        <input type="text" value="<?php echo $biaya[0]; ?>" name="biaya_pangan" id="biaya_pangan"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Biaya Pangan">
                                    <br>
									    <label class='fs-sm'>Listrik dan Air</label>
                                        <input type="text" value="<?php echo $biaya[1]; ?>" name="listrik_air" id="listrik_air"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Listrik dan Air">
                                    <br>
									    <label class='fs-sm'>Telpon dan Internet</label>
                                        <input type="text" value="<?php echo $biaya[2]; ?>" name="telpon_internet" id="telpon_internet"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Telpon dan Internet">
                                    <br>
									    <label class='fs-sm'>Biaya Pendidikan</label>
                                        <input type="text" value="<?php echo $biaya[3]; ?>" name="biaya_pendidikan" id="biaya_pendidikan"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Biaya Pendidikan">
                                    <br>
									    <label class='fs-sm'>Biaya Sandang</label>
                                        <input type="text" value="<?php echo $biaya[4]; ?>" name="biaya_sandang" id="biaya_sandang"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Biaya Sandang">
                                    <br>
									    <label class='fs-sm'>Upacara Adat</label>
                                        <input type="text" value="<?php echo $biaya[5]; ?>" name="upacara_adat" id="upacara_adat"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Upacara Adat">
                                    <br>
									    <label class='fs-sm'>Angsuran Pinjaman Bank Lain</label>
                                        <input type="text" value="<?php echo $biaya[6]; ?>" name="angsuran_bank_lain" id="angsuran_bank_lain"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Angsuran Pinjaman Bank Lain">
                                    <br>
									    <label class='fs-sm'>Biaya Lainnya</label>
                                        <input type="text" value="<?php echo $biaya[7]; ?>" name="biaya_lain" id="biaya_lain"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Biaya Lainnya">
                                    <br>
										
								</fieldset>
						</div>
					</div>
			</section>
		</div>
	</div>
</div>
                    <div class="tab-pane" id="tab3">
                        <div class='row'>
		<div class='col-sm-6'>
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<legend class="fw-semi-bold">
										Aktiva
									</legend>
                                        <label class='fs-sm'>Uang Tunai</label>
                                        <input type="text" value="<?php echo $aktiva[0]; ?>" name="aktiva_uang_tunai" id="aktiva_uang_tunai"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Uang Tunai">
                                    <br>
                                        <label class='fs-sm'>Simpanan</label>
                                        <input type="text" value="<?php echo $aktiva[1]; ?>" name="simpanan" id="simpanan"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Simpanan">
                                    <br>
                                        <label class='fs-sm'>Kendaraan</label>
                                        <input type="text" name="kendaraan" id="kendaraan"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" value="<?php echo $aktiva[2]; ?>" autocomplete="off" placeholder="Kendaraan">
                                    <br>
                                        <label class='fs-sm'>Tanah</label>
                                        <input type="text" name="tanah" id="tanah"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" value="<?php echo $aktiva[3]; ?>" autocomplete="off" placeholder="Tanah">
                                    <br>
                                        <label class='fs-sm'>Bangunan</label>
                                        <input type="text" value="<?php echo $aktiva[4]; ?>" name="bangunan" id="bangunan"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Bangunan">
                                    <br>
                                        <label class='fs-sm'>Aktiva Lain-lain</label>
                                        <input type="text" value="<?php echo $aktiva[5]; ?>" name="aktiva_lain" id="aktiva_lain"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Aktiva Lain-lain">
                                    <br>
								</fieldset>
						</div>
					</div>
			</section>
		</div>
		<div class="col-sm-6">
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
									<legend class="fw-semi-bold">
										Passiva
									</legend>
                                        <label class='fs-sm'>Pinjaman Pribadi</label>
                                        <input type="text" value="<?php echo $pasiva[0]; ?>" name="pinjaman_pribadi" id="pinjaman_pribadi"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Pinjaman Pribadi">
                                    <br>
									    <label class='fs-sm'>Pinjaman <?php echo $_SESSION['lembaga'];?></label>
                                        <input type="text" value="<?php echo $pasiva[1]; ?>" name="pinjaman_lpd" id="pinjaman_lpd"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Pinjaman LPD">
                                    <br>
									    <label class='fs-sm'>Pinjaman Bank</label>
                                        <input type="text" value="<?php echo $pasiva[2]; ?>" name="pinjaman_bank" id="pinjaman_bank"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Pinjaman Bank">
                                    <br>
										
								</fieldset>
						</div>
					</div>
			</section>
		</div>
	</div>
					</div>
                    <div class="tab-pane" id="tab4">
					
										<blockquote class="blockquote-sm mb-xs fw-normal">
											Dari Permohonan Pinjaman ini, Dijaminkan Harta/Benda Berupa :
										</blockquote>
										<?php
										    if($jaminan[1]==""){
						            $rj         = mysql_fetch_array(mysql_query("select jaminan FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$r[id]' ORDER BY id DESC"));
                                    $jmnn    = explode('#',$rj['jaminan']);
										       $jaminan[1]= $jmnn[1];
										       $jaminan[0]= $jmnn[0];
										    }
										?>
										<textarea type="text" name="deskripsi_jaminan" id="deskripsi_jaminan"  class="form-control" rows="5" <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Tuliskan Deskripsi Jaminan, seperti Merk, Type, Nomor Bukti Kepemilikan, nomor rangka, nomor mesin, dll"><?php echo $jaminan[1]; ?></textarea>
									<br>
										<blockquote class="blockquote-sm mb-xs fw-normal">
											Estimasi Nilai Jual Rp. :
										</blockquote>
                                        <input type="text" value="<?php echo number_format($jaminan[0],0,",","."); ?>" name="nilai_jual" id="nilai_jual"  class="form-control" <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
										required="required" autocomplete="off" placeholder="Estimasi Nilai Jual">
                                    
                    </div>
                </div>
				
</div>

<div class="modal-footer bg-primary">
	<div id="Sukses"></div>
	<button class="btn btn-primary btn-block btn-lg fw-normal" id="SimpanProposalIndividu" <?php echo $disabled ?>>SIMPAN PROPOSAL <i class="fa fa-caret-right"></i></button>
</div>
					
							
<?php	

} ?>

<script type="text/javascript"> 

function tandaPemisahTitik(b){
				var _minus = false;
				if (b<0) _minus = true;
				b = b.toString();
				b=b.replace(".","");
				
				c = "";
				panjang = b.length;
				j = 0;
				for (i = panjang; i > 0; i--){
					 j = j + 1;
					 if (((j % 3) == 1) && (j != 1)){
					   c = b.substr(i-1,1) + "." + c;
					 } else {
					   c = b.substr(i-1,1) + c;
					 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}

			function numbersonly(ini, e){
				if (e.keyCode>=48){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
				}else if (e.keyCode==48){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){
					return true;
				} else if (e.keyCode==17){
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}

			$(document).ready(function() {
			
				$("#proposali").focus();
				$("#proposali").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#jangka").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});



				$("#SimpanProposalIndividu").click(function() {
                    var nia				= $('#nia').val();
					//Data Pinjaman
					var id_pinj_i			= $('#id_pinj_i').val();
					var tgl_proposal		= $('#tgl_proposal').val();
					var proposali			= $('#proposali').val();
					var jangka				= $('#jangka').val();
					var pros_jasa			= $('#pros_jasa').val();
					var jenis_jasa			= $('#jenis_jasa').val();
					var sistem				= $('#sistem').val();
					var sa_jasa				= $('#sa_jasa').val();
					var tujuan_permohonan	= $('#tujuan_permohonan').val();
					var biaya_admin			= $('#biaya_admin').val();
					var materai     		= $('#materai').val();
					var jum_materai     	= $('#jum_materai').val();
					//Pendapatan
					var penghasilan_pemohon	= $('#penghasilan_pemohon').val();
					var penghasilan_sutri	= $('#penghasilan_sutri').val();
					var penghasilan_lain	= $('#penghasilan_lain').val();
					//Biaya
					var biaya_pangan		= $('#biaya_pangan').val();
					var listrik_air			= $('#listrik_air').val();
					var telpon_internet		= $('#telpon_internet').val();
					var biaya_pendidikan	= $('#biaya_pendidikan').val();
					var biaya_sandang		= $('#biaya_sandang').val();
					var upacara_adat		= $('#upacara_adat').val();
					var angsuran_bank_lain	= $('#angsuran_bank_lain').val();
					var biaya_lain			= $('#biaya_lain').val();
					//Aktiva
					var aktiva_uang_tunai	= $('#aktiva_uang_tunai').val();
					var simpanan			= $('#simpanan').val();
					var kendaraan			= $('#kendaraan').val();
					var tanah				= $('#tanah').val();
					var bangunan			= $('#bangunan').val();
					var aktiva_lain			= $('#aktiva_lain').val();
					//Passiva
					var pinjaman_pribadi	= $('#pinjaman_pribadi').val();
					var pinjaman_lpd		= $('#pinjaman_lpd').val();
					var pinjaman_bank		= $('#pinjaman_bank').val();
					//Jaminan
					var deskripsi_jaminan	= $('#deskripsi_jaminan').val();
					var nilai_jual			= $('#nilai_jual').val();
					
					if(proposali.length==0){ alert('Alokasi Pengajuan tidak boleh kosong!');
						$("#proposali").focus();
						return false;
							}
						
						if(pros_jasa.length==0){ alert('Prosentase Jasa tidak boleh kosong!');
						$("#pros_jasa").focus();
						return false;
							}
						
						if(jangka.length==0){ alert('Jangka waktu tidak boleh kosong!');
						$("#jangka").focus();
						return false;
							}
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/register/simpan_proposal_individu.php",
                        data: 	"id_pinj_i="+id_pinj_i+
								"&nia="+nia+
								"&nia="+nia+
								"&tgl_proposal="+tgl_proposal+
								"&proposali="+proposali+
								"&jangka="+jangka+
								"&pros_jasa="+pros_jasa+
								"&biaya_admin="+biaya_admin+
								"&materai="+materai+
								"&jum_materai="+jum_materai+
								"&jenis_jasa="+jenis_jasa+
								"&sistem="+sistem+
								"&sa_jasa="+sa_jasa+
								"&tujuan_permohonan="+tujuan_permohonan+
								"&penghasilan_pemohon="+penghasilan_pemohon+
								"&penghasilan_sutri="+penghasilan_sutri+
								"&penghasilan_lain="+penghasilan_lain+
								"&biaya_pangan="+biaya_pangan+
								"&listrik_air="+listrik_air+
								"&telpon_internet="+telpon_internet+
								"&biaya_pendidikan="+biaya_pendidikan+
								"&biaya_sandang="+biaya_sandang+
								"&upacara_adat="+upacara_adat+
								"&angsuran_bank_lain="+angsuran_bank_lain+
								"&biaya_lain="+biaya_lain+
								"&aktiva_uang_tunai="+aktiva_uang_tunai+
								"&simpanan="+simpanan+
								"&kendaraan="+kendaraan+
								"&tanah="+tanah+
								"&bangunan="+bangunan+
								"&aktiva_lain="+aktiva_lain+
								"&pinjaman_pribadi="+pinjaman_pribadi+
								"&pinjaman_lpd="+pinjaman_lpd+
								"&pinjaman_bank="+pinjaman_bank+
								"&deskripsi_jaminan="+deskripsi_jaminan+
								"&nilai_jual="+nilai_jual,
								
						success: function(data) {
                           $("#Sukses").load('modul/pinjaman/register/sukses.php');
						  <?php
							if($action=="tambah") {
						  ?> 
						   $("#TampilPinjaman").load('modul/pinjaman/register/tampil_pinjaman.php');
						   setTimeout(function(){ $('#myModalProposal').modal('hide'); }, 2000);
						   <?php
							}
						  ?>

                        }

                    });

                });
					
			});
			
</script>	

<?php
}else{
echo"
<div class='widget'>
	<div class='alert alert-danger alert-sm'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
                    Penduduk belum tersedia/NIK tidak dikenal!
                </div>
</div> ";
}
?>