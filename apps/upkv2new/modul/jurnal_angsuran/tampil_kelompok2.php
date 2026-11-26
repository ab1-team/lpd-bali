<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";

$idk		= $_POST['kelompok'];
if(!empty($idk)) {$idpinj=$idk;}else{$idpinj=$_SESSION['id_pinj'];}
$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
 WHERE sd.id=d.sebutan AND d.id=k.desa AND jpp.id=pk.jenis_pp AND sa.id=pk.sistem_angsuran AND k.id=pk.id_kel AND pk.id='$idpinj' "));
	
$jum_angsuran	=@($row['jangka']/$row['sistem']);
$id_pinj		=$row['id'];
$_SESSION['id_pinj']	=$row['id'];
$sistem			=$row['sistem'];
$alokasi			=$row['alokasi'];
$tgl_cair			=$row['tgl_cair'];
$pros_jasa			=$row['pros_jasa'];
$jenis_jasa			=$row['jenis_jasa'];
$nama_jj			=$row['nama_jj'];
$jangka				=$row['jangka'];
$sistem				=$row['sistem'];
$tempo				=@($jangka/$sistem);
$datenow		=date('Y-m-d');
$tottargetpokok	=targetpokok("$datenow-$id_pinj");
$tottargetjasa		=targetjasa("$datenow-$id_pinj");
$sumpokok		=sumpokok("$datenow-$id_pinj");
$sumjasa		=sumjasa("$datenow-$id_pinj");
$totsaldopinjaman	=saldopinjaman("$datenow-$id_pinj");
$totsaldojasa	=saldo_jasa("$datenow-$id_pinj");
$totnunggakpokok	=nunggakpokok("$datenow-$id_pinj");
$totnunggakjasa	=nunggakjasa("$datenow-$id_pinj");

$proskembali=floor(@($sumpokok/$alokasi*100));


											
?>

<div class='alert alert-info'>
	<i class='fa fa-info-circle'></i> <strong>Data Kelompok :</strong>
	<span class="tags pull-right">
		<a class="btn btn-sm btn-primary" href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KA.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini fw-semi-bold">Kartu Angsuran [B5]</span></a>
		<a class="btn btn-sm btn-success" href="" data-toggle="modal" data-target="#myModalDetailAngsuranKelompok" id="DetailAngsuranKelompok"> <span class="fs-mini fw-semi-bold">Detail Angsuran</span></a>
		<a class="btn btn-sm btn-danger" href="modul/pinjaman/cp/LPP.php?&idp=<?php echo $row['id'];?>" target="_blank"> <span class="fs-mini fw-semi-bold">LPP</span></a>
	</span>
	<br>
		<span class="fs-xsm"><?php echo "Progres Pengembalian: <b>$proskembali</b>%"?></span>
		<div class='progress progress-sm progress-striped active'>
			<div class='progress-bar progress-bar-primary' style='width: <?php echo "$proskembali%"?>;'>
			</div>
		</div>
			
			
						
<?php
echo "				
    <table width='100%' class='fs-mini'>
		<tr><td width='19%'>ID Kelompok</td><td>:</td width='1%'><td width='30%'><strong>$row[kd_kelompok]</strong></td>	<td width='19%'>Loan ID</td><td width='1%'>:</td><td width='30%'><strong>$row[nama_jpp]-$row[id]</strong></td></tr>
		<tr><td>Nama Kelompok</td><td>:</td><td><strong>$row[nama_kelompok]</strong></td>									<td>SPK Nomor</td><td>:</td><td><strong>$row[spk_no]</strong></td></tr>
		<tr><td>Alamat</td><td>:</td><td><strong>$row[alamat_kelompok]</strong></td>									<td>Tanggal Cair</td><td>:</td><td><strong>$row[tgl_cair]</strong></td></tr>
		<tr><td>$row[sebutan_desa]</td><td>:</td><td><strong>$row[nama_desa]</strong></td>										<td>Alokasi</td><td>:</td><td><strong>".number_format($row['alokasi'])."</strong></td></tr>
		<tr><td>Telpon</td><td>:</td><td><strong>$row[telpon]</strong></td>									<td>Jasa</td><td>:</td><td><strong>$pros_jasa</strong>% <strong>$nama_jj</strong></td></tr>
		<tr><td>Nama Ketua</td><td>:</td><td><strong>$row[ketua]</strong></td>													<td>Sistem Angsuran</td><td>:</td><td><strong>$row[jangka]</strong> bulan @<strong>$row[nama_sistem]</strong></td></tr>
		<tr><td>Nama Sekretrais</td><td>:</td><td><strong>$row[sekretaris]</strong></td>												<td>Angsuran</td><td>:</td><td><strong>".number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj)*$sistem))."</strong> x <strong>$jum_angsuran</strong></td></tr>
		<tr><td>Nama Bendahara</td><td>:</td><td><strong>$row[bendahara]</strong></td>												<td>Angsuran</td><td>:</td><td><strong>".number_format(wajibjasaaja($id_pinj)+(wajibpokokaja($id_pinj)*$sistem))."</strong> x <strong>$jum_angsuran</strong></td></tr>
    </table>
	<hr>
	<table width='100%' class='fs-mini'>
		<tr>
		<td width='50%'>Saldo Pokok:<br><span class='h3 fw-normal'>".number_format($totsaldopinjaman)."</span></td>
		<td width='50%' class='text-align-right'>Saldo Jasa:1<br><span class='h3 fw-normal'>".number_format($totsaldojasa)."</span></td>
		</tr>											
	</table>
</div>

";


 ?>

<body>

<div id="grafikkelompok" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">

Highcharts.chart('grafikkelompok', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Grafik Perkembangan Pinjaman'
    },
    subtitle: {
        text: 'Kelompok: <?php echo $row['nama_kelompok'];?>'
    },
    xAxis: [{
        categories: [
		<?php
		for($noo=1;$noo<=$tempo;$noo++) 
			  {
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
				
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			    $date	="$th-$bln";
				
				$bulan=tgl_indo($date);
			
			  echo "'$bulan',"; 

			  }
		?>
		],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            formatter:function(){
				return(this.value/1000000)+" Juta";
			},
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Rupiah',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Target Pokok',
        type: 'column',
        data: [
		<?php 
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			
			$targetpokok=targetpokok("$th-$bln-$tanggal-$id_pinj");	
			
			  echo "$targetpokok,"; 
			  }
			   ?>
		]

    }, {
        name: 'Realisasi Pokok',
        type: 'spline',
        data: [
		<?php 
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			
			$sumpokok=sumpokok("$th-$bln-$tanggal-$id_pinj");	
			if(empty($sumpokok)) {$sumpokok=0;}
			  echo "$sumpokok,"; 
			  }
			   ?>
		]
    }, {
        name: 'Target Jasa',
        type: 'column',
        data: [
		<?php 
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			
			$targetjasa=targetjasa("$th-$bln-$tanggal-$id_pinj");	
			if(empty($targetjasa)) {$targetjasa=0;}
			  echo "$targetjasa,"; 
			  }
			   ?>
		]
    }, {
        name: 'Realisasi Jasa',
        type: 'spline',
        data: [
		<?php 
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			
			$sumjasa=sumjasa("$th-$bln-$tanggal-$id_pinj");	
			if(empty($sumjasa)) {$sumjasa=0;}
			  echo "$sumjasa,"; 
			  }
			   ?>
		]
    }
	]
});

	$(document).ready(function() {
		
			$("#DetailAngsuranKelompok").click(function() {
					var id_pinj		= <?php echo $row['id'];?>
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/tampil_buku_angsuran.php",
                        data: 	"id_pinj="+id_pinj,
								
						success: function(data) {
							$("#TampilBuku").html(data);
                        }
                    });

                });					
	
	});
		</script>


<!-- MODAL DETAIL ANGSURAN -->
						<div class="modal fade" id="myModalDetailAngsuranKelompok" tabindex="" role="dialog" aria-labelledby="LabelDetailAngsuranKelompok" aria-hidden="true">
                            <div class="modal-backdrop">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title fw-bold" id="LabelDetailAngsuranKelompok">
											<i class="fa fa-book"></i> DETAIL ANGSURAN PINJAMAN KELOMPOK | <?php echo strtoupper($row['nama_kelompok']);?>
											<ul class="tags pull-right">
												<li><a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_RK.php?&idp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Cetak</span></a></li>
												<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
											</ul>
										</h5>
                                    </div>
                                    <div class="modal-body" style="overflow: scroll; height: 550px;">
											<div id="TampilBuku">
											</div>
									</div>
									<div class="modal-footer bg-primary">
										<ul class="tags pull-right">
												<li><a href="javascript:;" onclick="MM_openBrWindow('modul/jurnal_angsuran/c_RK.php?&idp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Cetak</span></a></li>
												<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
											</ul>
									</div>
                                </div>
                            </div>
                        </div>
		

	</body>