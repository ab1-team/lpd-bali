<?php 
session_start();
include '../../../inc/inc.koneksi.php';
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
include "../../../inc/fungsi_pinjaman.php";

$now    = date('Y-m-t');
$akt    = aktiva("$now");
$ak1    = substr($akt, 0, -6);
$ak2    = substr($akt, -6);

$ma = modalawal("$now");
$ap = asetproduktif("$now");
$pd = $ap - $ma;
$pr = @(floor($pd / $ma * 100));

$kec      = mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
$kd_kab   = $kec['kd_kab'];
$nama_kec = $kec['nama_kec'];

$table_kelompok = "kelompok_$kd_kab";
$table_anggota  = "anggota_$kd_kab";
$table_pk       = "pinjaman_kelompok_$kd_kab";
$table_pa       = "pinjaman_anggota_$kd_kab";

$jum_kel  = mysql_num_rows(mysql_query("select * from $table_kelompok WHERE lokasi='$_SESSION[lokasi]' "));
$jum_prop = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='P' "));
$jum_ver  = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='V' "));
$jum_wait = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='W' "));
$jum_akt  = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' "));
$jum_aakt = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.status='A' "));
$jum_pinj = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' "));
	
$jum_prop_i = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='P' "));
$jum_ver_i  = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='V' "));
$jum_wait_i = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='W' "));
$jum_akt_i  = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='A' "));
$jum_pinj_i = mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' "));

?>

<div class="col-md-3 col-sm-6">
    <section class="widget">
        <div class="widget-body mb-lg">
            <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-success">
                <span class="h5 text-white"><i class="glyphicon glyphicon-user"></i> CUSTOMERS</span>
            </div>
            
            <div class="row mt">
                <ul class="map-controls nav nav-pills nav-justified bg-success-light" style="border: 1px solid #228B22;">
                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_akt;?></div> <span class="badge bg-success">G R O U P</span></a></li>
                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/AAA.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center"><?php echo number_format($jum_aakt);?></div> <span class="badge bg-success">M E M B E R</span></a></li>
                </ul>
            </div>
        </div>
    </section>
</div>

<div class="col-md-3 col-sm-6">
    <section class="widget">
        <div class="widget-body mb-lg">
            <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-primary">
                <span class="h5 text-white"><i class="glyphicon glyphicon-th-list"></i> PROPOSAL</span>
            </div>
            
            <div class="row mt">
                <ul class="map-controls nav nav-pills nav-justified bg-primary-light" style="border: 1px solid #5d8fc2;">
                    <li><a href="" data-toggle="modal" data-target="#myModalProposal" data-file="modal_proposal"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_prop+$jum_prop_i;?></div> <span class="badge bg-primary">P</span></a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModalVerified" data-file="modal_verified"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_ver+$jum_ver_i;?></div> <span class="badge bg-primary">V</span></a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModalWaiting" data-file="modal_waiting"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_wait+$jum_wait_i;?></div> <span class="badge bg-primary">W</span></a></li>
                </ul>
            </div>
        </div>
    </section>
</div>

<div class="col-md-3 col-sm-6">
    <section class="widget">
        <div class="widget-body mb-lg">
            <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-danger">
                <span class="h5 text-white"><i class="glyphicon glyphicon-tags"></i> &nbsp;JATUH TEMPO</span>
            </div>
            
            <div class="row mt">
                <ul class="map-controls nav nav-pills nav-justified bg-danger-light" style="border: 1px solid #dd5826;">
                     <li><a href="" data-toggle="modal" data-target="#myModalTagihan" data-file="modal_tagihan"> <div class="h1 no-margin fw-normal text-align-center text-danger"><i class="fa fa-money"></i></div> <span class="badge bg-danger">TAGIHAN</span></a></li>
                    <li><a href="" data-toggle="modal" data-target="#myModalMenunggak" data-file="modal_menunggak"> <div class="h1 no-margin fw-thin text-align-center text-danger"><i class="fa fa-warning"></i> </div> <span class="badge bg-danger">MENUNGGAK</span></a></li>
					<li><a href="" data-toggle="modal" data-target="#myModalReminder" data-file="modal_reminder"> <div class="h1 no-margin fw-thin text-align-center text-danger"><i class="fa fa-bell-o"></i></div> <span class="badge bg-danger">REMINDER</span></a></li>
                </ul>
            </div>
        </div>
    </section>
</div>

<div class="col-md-3 col-sm-6">
    <section class="widget">
        <div class="widget-body mb-lg">
            <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-info">
                <span class="h5 text-white"><i class="glyphicon glyphicon-bookmark"></i> TOTAL ASET
				<ul class="tags text-white pull-right">
						<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/PM.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini">Modal</span></a></li>
						<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/RL.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini">L - R</span></a></li>
					</ul>
				</span>
            </div>
            
            <div class="row mt">
                <ul class="map-controls nav nav-pills nav-justified bg-info-light" style="border: 1px solid #5dc4bf;">
                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center text-info">&nbsp;<span id="geo-locations-number"><?php echo $ak1;?></span> <span class="h4" id="geo-locations-number"><?php echo $ak2;?></span></div><span class="badge bg-info">DETAIL NERACA</span></a></li>
                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 ml-n-lg mr-n-lg mt-0 mb fw-normal text-align-center"><span class="h3 text-success"><i class="fa fa-sort-up"></i></span><?php echo $pr;?><span class="h4">%</span></div></a></li>
				</ul>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PROPOSAL  -->
<div class="modal fade" id="myModalProposal" tabindex="" role="dialog" aria-labelledby="LabelProposal" aria-hidden="true">

</div>

<!-- MODAL VERIFIED  -->
<div class="modal fade" id="myModalVerified" tabindex="" role="dialog" aria-labelledby="LabelVerified" aria-hidden="true">

</div>

<!-- MODAL MENUNGGAK  -->
<div class="modal fade" id="myModalMenunggak" tabindex="" role="dialog" aria-labelledby="LabelMenunggak" aria-hidden="true">

</div>

<!-- MODAL REMINDER  -->
<div class="modal fade" id="myModalReminder" tabindex="" role="dialog" aria-labelledby="LabelReminder" aria-hidden="true">

</div>

<!-- MODAL TAGIHAN  -->
<div class="modal fade" id="myModalTagihan" tabindex="" role="dialog" aria-labelledby="LabelTagihan" aria-hidden="true">

</div>

<!-- MODAL VERIFIED  -->
<div class="modal fade" id="myModalWaiting" tabindex="" role="dialog" aria-labelledby="LabelWaiting" aria-hidden=" true">

</div>

<script>
    $('[data-toggle=modal]').click(function() {
        var modal = $(this).attr('data-target')
        var link  = $(this).attr('data-file') + '.php'
        
        $(modal).load('modul/home/data/' + link)
        // $(modal).modal('show')
    })
</script>