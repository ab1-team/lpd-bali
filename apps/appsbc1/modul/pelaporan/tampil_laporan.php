<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

$y	=$_POST['y'];
$m	=$_POST['m'];
$d	=$_POST['d'];

$tgl	="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y"; }
else{$laporan="Global";}
?>



<div class="col-sm-4">

<ol>
<?php

$view=mysql_query("select * from jenis_laporan ORDER BY urut"); //Jenis Laporan
	while($row=mysql_fetch_array($view)){
		
		$file	=$row['file'];
		
		if($file==2 OR $file==3 OR $file==4 OR $file==5 OR $file==6 OR $file==7) {
?>

<script type="text/javascript">	
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
	window.open(theURL,winName,features);
}
				
$(document).ready(function(){
  
  $("#SubLaporan<?php echo $file;?>").click(function() {
					var y		= $("#y").val();
					var m 		= $("#m").val();
					var d 		= $("#d").val();
					var file 	= $("#file<?php echo $file;?>").val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/pelaporan/ambil_sub_laporan.php",
                        data: 	"y="+y+
								"&m="+m+
								"&d="+d+
								"&file="+file,
								
						success: function(data) {
							$("#TampilSubLaporan").html(data);
                        }
                    });

                });
  
  });
				
</script>
	
	<input type="hidden" id="y"  name="y" value="<?php echo $y?>" />
	<input type="hidden" id="m"  name="m" value="<?php echo $m?>" />
	<input type="hidden" id="d"  name="d" value="<?php echo $d?>" />

	<input type="hidden" id="file<?php echo $file;?>"  name="file<?php echo $file;?>" value="<?php echo $file?>" />

	<li><button id="SubLaporan<?php echo $file;?>" class="btn btn-inverse btn-xs mb-xs"><?php echo $row['nama_laporan'];?></button></li>
	
<?php
}else{
?>
<form method="POST" target='_blank' action='modul/pelaporan/pdf/report_view.php'>
	<input type="hidden" id="y"  name="y" value="<?php echo $y?>" />
	<input type="hidden" id="m"  name="m" value="<?php echo $m?>" />
	<input type="hidden" id="d"  name="d" value="<?php echo $d?>" />
	<input type="hidden" id="report"  name="report" value="<?php echo $file?>" />
	<li><button type="submit" class="btn btn-inverse btn-xs mb-xs"><?php echo $row['nama_laporan'];?></button></li>
</form>
<?php
}

}
?>

</ol>
</div>
<div class="col-sm-8">
<div class='alert alert-info animated fadeInDown' style="background-color:white;">
<?php echo "<b>Generate Laporan $jenis ".tgl_indo($tgl_kondisi)." Berhasil,</b>";?>
			<div id="TampilSubLaporan"></div>
</div>
</div>
	