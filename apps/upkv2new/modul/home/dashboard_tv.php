<?php
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_pinjaman.php";

$_SESSION['jum_prop']=$jum_prop;
$_SESSION['jum_prop_i']=$jum_prop_i;

if($jum_prop<=0 ) {
	$ket="BELUM ADA";
}else{
	$ket=$jum_prop;
}

if($jum_prop_i<=0 ) {
	$ket_i="BELUM ADA";
}else{
	$ket_i=$jum_prop_i;
}
?>		
									
<script type="text/javascript">	


		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
</script>
			<?php
			$tgl=date('d');
			$data=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE 
			d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND  k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' OR
			d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND  k.lokasi='$_SESSION[lokasi]' AND d.jadwal_angsuran_desa='$tgl'
			ORDER BY pk.tgl_cair ASC ");
			$hitung= mysql_num_rows($data);
			?>

			<?php
			$tgl_i=date('d');
			$data_i=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE d.id=a.desa AND a.id=pa.nia AND pa.status='A' AND pa.jenis_pinjaman='I' AND  a.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl_i' ORDER BY pa.tgl_cair 	 ASC ");
			$hitung_i= mysql_num_rows($data_i);
			?>
    <div class="row hidden-print">
		<div class="row justify-content-md-center">
			<div class="col col-lg-5">
                </section>
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg" style="background-color:DarkCyan;">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-tags"></i> &nbsp;JATUH TEMPO INDIVIDU
								<ul class="tags text-white pull-right">
								</ul>
							</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified" style="background-color:#D0FBFB; border: 1px solid DarkCyan;">
                                 <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTA.php')" target="_blank"> <div class="h1 no-margin fw-normal text-align-center" style="color: DarkCyan;"><?php echo $hitung_i;?></div> <span class="badge" style="background-color:DarkCyan;">TAGIHAN</span></a></li>
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTU.php')" target="_blank"> <div class="h1 no-margin fw-thin text-align-center"><i class="fa fa-warning" style="color: DarkCyan;"></i> </div> <span class="badge" style="background-color:DarkCyan;">MENUNGGAK</span></a></li>
								<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_RPY.php')" target="_blank"> <div class="h1 no-margin fw-thin text-align-center" style="color:DarkCyan"><i class="fa fa-bell-o"></i></div> <span class="badge" style="background-color:DarkCyan;">REMINDER</span></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
			<div class="col col-lg-5">
                </section>
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg" style="background-color:ForestGreen;">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-tags"></i> &nbsp;JATUH TEMPO KELOMPOK
								<ul class="tags text-white pull-right">
								</ul>
							</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified" style="background-color:#D2FBD2; border: 1px solid ForestGreen;">
                                 <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTA.php')" target="_blank"> <div class="h1 no-margin fw-normal text-align-center" style="color: ForestGreen;"><?php echo $hitung;?></div> <span class="badge" style="background-color:ForestGreen;">TAGIHAN</span></a></li>
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTU.php')" target="_blank"> <div class="h1 no-margin fw-thin text-align-center"><i class="fa fa-warning" style="color:ForestGreen"></i> </div> <span class="badge" style="background-color:ForestGreen;">MENUNGGAK</span></a></li>
								<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/RPY.php')" target="_blank"> <div class="h1 no-margin fw-thin text-align-center"><i class="fa fa-bell-o" style="color:ForestGreen"></i></div> <span class="badge" style="background-color:ForestGreen;">REMINDER</span></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
		</div>			
        <div class="col-md-12">
				
				<div class="text-align-center mt-xlg">
									<h3>Silahkan Pilih Pinjaman yang akan Anda Verifikasi</h3>
									<a href="?p=pJ_i&sT=P" class="btn btn-primary width-200 height-150 mr-lg mt-lg">
										<h1 class="mt-lg">
											<i class="glyphicon glyphicon-user"></i>
										</h1>
										<span class="fs-md"><?php echo $ket_i; ?> PROPOSAL<BR>PINJAMAN INDIVIDU</span>
									</a>
									
									<a href="?p=pJ&sT=P" class="btn btn-success width-200 height-150 ml-lg mt-lg">
										<h1 class="mt-lg">
											<i class="fa fa-group"></i>
										</h1>
										<span class="fs-md"><?php echo $ket; ?> PROPOSAL<BR>PINJAMAN KELOMPOK</span>
									</a> <br><br>
			
								</div>	

        </div>
    </div>