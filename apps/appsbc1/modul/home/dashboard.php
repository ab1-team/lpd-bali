<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
include "inc/fungsi_pinjaman_individu.php";

$now	=date('Y-m')."-31";
$akt	=aktiva("$now");
$surplus=surplus("$now");

$ma=modalawal("$now");
$ap=asetproduktif("$now");
$pd=$ap-$ma;
$pr=@(floor($pd/$ma*100));

$tgl=date('d');
$data=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[lokasi] a, pinjaman_anggota_$_SESSION[lokasi] pa WHERE d.id=a.desa AND a.id=pa.nia AND pa.status='A' AND a.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pa.tgl_cair ASC ");

$u=mysql_fetch_array(mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.id='$_SESSION[id]' "));
?>

<script type="text/javascript">	
		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}

$(document).ready(function() {	

$("#TampilPinjaman").load('modul/pinjaman/register/tampil_tugas.php');

});	
</script>
	
<div class="row">
			<div class="col-md-12 col-lg-12">
				<section class="widget no-padding mt-n-md mb">
					<div class="row no-margin">
                        <div class="col-md-2 col-lg-2 bg-danger btlr bblr text-align-center">
                            <h5 class="text-white display-inline-block fw-normal"><i class="glyphicon glyphicon-envelope fa-lg"></i>&nbsp; SMS GATEWAY: <?php echo strtoupper(date('D'));?></h5>
                        </div>
						<div class="col-md-10 col-lg-10 opacity-60">
							<div class="live-tile" data-mode="carousel" data-speed="750" data-delay="5000" data-height="30">
								<?php 
								$dt=mysql_query("select * from sms_backup WHERE CreatorID='$_SESSION[lokasi]' order by id desc LIMIT 10");
									$sms=mysql_num_rows($dt);
									if($sms<=0) {
										echo '<h5 class="display-inline-block fw-normal"><span><img src="images/sms.gif" height="22px" width="40px"/></span> SMS Gateway is running...</h5>';
									}else{
									while($rows=mysql_fetch_array($dt)){
										
									 echo '
									<div>
										<h5 class="display-inline-block fw-normal"><strong>'.$rows['DestinationNumber'].'</strong> <i class="fa fa-play"></i> '.substr($rows['TextDecoded'],0,130).'</h5>
									</div>
									'; 
									}
									}
									?>
								
							</div>
						</div>
					</div>
                </section>
            </div>
</div>
<div class="row">
			<div class="col-md-3 col-lg-3">
				<section class="widget mb-sm">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> Customers</h5>
                    </header>
                    <div class="widget-body no-padding">
                        <div id="events-calendar" class="bg-primary-light"></div>
                        <div class="list-group fs-mini">
							<table width="100%">
							<tr>
							<td width="30%" class="text-align-center h1">
								<i class="glyphicon glyphicon-user"></i>
							</td>
							<td width="70%">
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Debitur <span class="label label-warning pull-right"><?php echo number_format($jum_debitur,0,",",".");?></span>
								</a>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/SU.php?&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=<?php echo date('d');?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Kreditur <span class="label label-success pull-right"><?php echo number_format($jum_kreditur,0,",",".");?></span>
								</a>
							</td>
							</tr>
							</table>
                        </div>
                    </div>
                </section>
				<section class="widget mb-sm">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> Proposal Dalam Proses</h5>
                    </header>
                    <div class="widget-body no-padding">
                        <div id="events-calendar" class="bg-primary-light"></div>
                        <div class="list-group fs-mini">
							<table width="100%">
							<tr>
							<td width="30%" class="text-align-left">
								<img src="images/gears.gif" width="110px" class="mr-n-lg"/>
							</td>
							<td width="70%">
								<a href="modul/pinjaman/cp/i_LP.php?&sT=P" target="_blank" class="list-group-item text-ellipsis">
									Pengajuan Pemohon <span class="label label-warning pull-right"><?php echo $jum_prop_i;?></span>
								</a>
								<a href="modul/pinjaman/cp/i_LP.php?&sT=V1" target="_blank" class="list-group-item text-ellipsis">
									Rekomendasi Analis <span class="label label-info pull-right"><?php echo $jum_ver1_i;?></span>
								</a>
								<a href="modul/pinjaman/cp/i_LP.php?&sT=V2" target="_blank" class="list-group-item text-ellipsis">
									Approved Kepala <?php echo LEMBAGA_SORT; ?> <span class="label label-primary pull-right"><?php echo $jum_ver2_i;?></span>
								</a>
								<a href="modul/pinjaman/cp/i_LP.php?&sT=V3" target="_blank" class="list-group-item text-ellipsis">
									Approved Bawas <span class="label label-success pull-right"><?php echo $jum_ver3_i;?></span>
								</a>
								<a href="modul/pinjaman/cp/i_LP.php?&sT=W" target="_blank" class="list-group-item text-ellipsis">
									Waiting List <span class="label label-danger pull-right"><?php echo $jum_wait_i;?></span>
								</a>
							</td>
							</tr>
							</table>
                        </div>
                    </div>
                </section>
                <section class="widget">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> Jatuh Tempo</h5>
                    </header>
                    <div class="widget-body no-padding">
                        <div id="events-calendar" class="bg-primary-light"></div>
                        <div class="list-group fs-mini">
							<table width="100%">
							<tr>
							<td width="30%" class="text-align-center h1">
								<i class="fa fa-warning"></i>
							</td>
							<td width="70%">
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTA.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Tagihan <span class="label label-warning pull-right"><?php echo mysql_num_rows($data);?></span>
								</a>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTU.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Menunggak
								</a>
								<a href="modul/pinjaman/cp/i_RPY.php" target="_blank" class="list-group-item text-ellipsis">
									Reminder
								</a>
							</td>
							</tr>
							</table>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-9 col-lg-9">
<div class="row">
			<div class="col-md-8 col-lg-8">
				<section class="widget">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> Grafik Pendapatan dan Biaya
						<span class="pull-right">
						<ul class="tags mb-0">
							<li><a href="javascript:;" data-toggle='tooltip' data-placement='left' title='Rencana E-Budgeting TA <?php echo date('Y');?>' onclick="MM_openBrWindow('modul/pelaporan/pdf/EBR.php?y=<?php echo date('Y');?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )">E-BUD PLANT <?php echo date('Y');?></a></li>
							<li><a href="modul/pelaporan/pdf/EB.php?y=<?php echo date('Y');?>" target="_blank" data-toggle='tooltip' data-placement='left' title='Realisasi E-Budgeting TA <?php echo date('Y');?>' >E-BUD REAL <?php echo date('Y');?></a></li>
						</ul>
						</span>
						</h5>
                    </header>
                    <div class="widget-body no-padding">
					
<body>
<?php include "modul/home/charts.php"; //GRAFIK ?>

<div id="pendapatandanbiaya" style="min-width: 310px; height: 330px; margin: 0 auto"></div>

<script src="modul/home/highchats/code/highcharts.js"></script>
<script src="modul/home/highchats/code/modules/series-label.js"></script>
<script src="modul/home/highchats/code/modules/exporting.js"></script>

<script type="text/javascript">
Highcharts.chart('pendapatandanbiaya', {
	chart: {
      backgroundColor: '#ffffff'
	},

    title: {
        text: '<code><?php echo "Tahun $th";?></code>'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nop', 'Des']
    },
	yAxis:{
		labels:{
			formatter:function(){
				return(this.value/1000000)+" J";
			}
		}
	},
    series: [{
        type: 'column',
        name: 'Pendapatan',
        data: [<?php echo "$p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12"; ?>],
		color: Highcharts.getOptions().colors[7]
    }, {
        type: 'column',
        name: 'Biaya',
        data: [<?php echo "$b1, $b2, $b3, $b4, $b5, $b6, $b7, $b8, $b9, $b10, $b11, $b12"; ?>],
		color: Highcharts.getOptions().colors[8]
    },{
        type: 'spline',
        name: 'Surplus',
        data: [<?php echo "$s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10, $s11, $s12"; ?>],
		color: Highcharts.getOptions().colors[5],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[5],
            fillColor: 'white'
        }
    }]
});
</script>
</body>
					</div>
				</section>
				<section class="widget">
                    <div class="widget-body no-padding">
					
<body>

<div id="container" style="height: 200px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Sebaran Nasabah'
    },
	xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nop', 'Des']
    },
    yAxis: {
        title: {
            text: 'Orang'
        },
        labels: {
            formatter: function () {
                return this.value / 1000 + 'k';
            }
        }
    },
    tooltip: {
        pointFormat: '{series.name} sebanyak <b>{point.y:,.0f}</b> orang'
    },
    series: [{
        name: 'Debitur',
        data: [
            6, 11, 32, 110, 235,
            369, 640, 1005, 1436, 2063, 3057, 4618
        ]
    }, {
        name: 'Kreditur',
        data: [
            5, 25, 50, 120, 150, 200, 426, 660, 869, 1060,
            1605, 2471
        ]
    }]
});
		</script>
	</body>
					</div>
				</section>
			</div>
			<div class="col-md-4 col-lg-4">
				<section class="widget mb-sm">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> Keuangan <?php echo $ap;?></h5>
                    </header>
                    <div class="widget-body no-padding">
                        <div id="events-calendar" class="bg-primary-light"></div>
                        <div class="list-group fs-mini">
							<table width="100%">
							<tr>
							<td width="65%">
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Asset <span class="label label-danger pull-right"><?php echo number_format($akt,0,",",".");?></span>
								</a>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/RL.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="list-group-item text-ellipsis">
									Surplus <span class="label label-success pull-right"><?php echo number_format($surplus,0,",",".");?></span>
								</a>
							</td>
							<td width="35%" class="text-align-center h2">
								<a class="text-gray" href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/PM.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )">
									<span class="h3 text-success"><i class="fa fa-sort-up"></i></span><?php echo $pr;?><span class="h4">%</span>
								</a>
							</td>
							</tr>
							</table>
                        </div>
                    </div>
                </section>
				<section class="widget">
                    <header class="bg-primary">
                        <h5><i class="glyphicon glyphicon-th-large"></i> List Tugas Anda<span class="label label-danger pull-right"><?php echo $u['nama_jabatan'];?></span></h5>
                    </header>
                    <div class="widget-body no-padding">
                        <div class="list-group list-group-lg">
                            <div id="TampilPinjaman" style="min-height: 375px;"></div>	
                        </div>
                    </div>
                </section>
            </div>
</div>

                
		</div>
		
</div>				