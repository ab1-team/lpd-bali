<?php
    session_start();
    include '../../../inc/inc.koneksi.php';
    
    $kec            = mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
	$kd_kab         = $kec['kd_kab'];
	$nama_kec       = $kec['nama_kec'];
	
    $table_kelompok = "kelompok_$kd_kab";
    $table_pk="pinjaman_kelompok_$kd_kab";
    
    $tgl=date('d');
    $data=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
    				WHERE 
    				d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' AND (d.jadwal_angsuran_desa='0' OR d.jadwal_angsuran_desa='') OR
    				d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND d.jadwal_angsuran_desa='$tgl'
    				ORDER BY pk.tgl_cair ASC ");
    $hitung= mysql_num_rows($data);
    
    $tgl_i=date('d');
    $data_i=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE d.id=a.desa AND a.id=pa.nia AND pa.status='A' AND pa.jenis_pinjaman='I' AND  a.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl_i' ORDER BY pa.tgl_cair 	 ASC ");
    $hitung_i= mysql_num_rows($data_i);
?>

<div class="modal-sm">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 class="modal-title text-align-center fw-bold text-white" id="LabelProposal">TAGIHAN</h5>
        </div>
        <div class="modal-body">
			<div id="validation-form" class="form-horizontal form-label-left" method="post"
				  data-parsley-priority-enabled="false"
				  novalidate="novalidate">
				<fieldset>
					<div class="col-md-6 text-align-center">
						<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTA.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">
							<h1><?php echo $hitung;?></h1>
							<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>
						</button>
					</div>
					<div class="col-md-6 text-align-center">
						<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTA.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">
							<h1><?php echo $hitung_i;?></h1>
							<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
						</button>
					</div>
				</fieldset>
			</div>
		</div>
	
    </div>
</div>