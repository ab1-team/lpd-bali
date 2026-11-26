<?php session_start(); 
include "inc/inc.koneksi.php";
	
		
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="ilmu-detil.blogspot.com">


	<style>
	#container {
		height: 600px; 
		min-width: 700px; 
		max-width: 1366px; 
		margin: 0 auto; 
	}
	</style>
	<script>
	$(function() {    
    var data = [
        {
            "hc-key": "id-3700",
            "value": 0
        },
		
		<?php
		
		$data=mysql_query('select * from propinsi'); 
					while($row=mysql_fetch_array($data)){
	
	echo "
	
	{
			'hc-key': 'id-$row[hc_key]',
            'value': 0,
			color: Highcharts.getOptions().colors[$row[id]]
        },
		
	";
	
}
		?>
        
		
    ];
	

    // Initiate the chart
    $('#container').highcharts('Map', {
		legend: {
            enabled: false
          },


        title : {
            text : 'Peta Sebaran Pemanfaat Dana Bergulir'
        },

        subtitle : {
            text : 'Unit Pengelola Kegiatan (UPK) Eks PNPM Mandiri Perdesaan'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'top'
            }
        },
        series : [{
            data : data,
            mapData: Highcharts.maps['countries/id/id-all'],
            joinBy: 'hc-key',
            name: 'Jumlah Pemanfaat',
            states: {
				
                hover: {
                    color: '#337ab7'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            },
			tooltip: {
                    valueSuffix: ' Jiwa'
                }
        }]
    });
});
	</script>
   
</head>
<body>



<?php
//NOTIVIKASI INVOICE 
						$k=mysql_query("select * from kecamatan WHERE web_kec!='' OR web_kec!=NULL ORDER BY id ASC"); 
							while($kec=mysql_fetch_array($k)){
								$tgl_now		= date('Y-m-d');	
								$thn_now 		= substr($tgl_now,0,4);
								$thn_lalu 		= $thn_now-1;
								$tgl_awal 		= $kec['tgl_pakai'];
								$bulan_awal 	= substr($tgl_awal,5);
								
								$tgl_bayar		= "$thn_now-$bulan_awal";
								$tgl_lalu		= "$thn_lalu-$bulan_awal";
								
								$in=mysql_query("select * from admin_invoice WHERE lokasi='$kec[id]' AND 
								tgl_invoice>='$tgl_bayar' order by idv DESC");
								$jumin = mysql_num_rows($in);
								$jumin1 = mysql_fetch_array($in);
								if($jumin<1){
									?>
								<div class="alert alert-danger alert-sm">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<span class="fw-semi-bold"><?php echo "$kec[id] $kec[nama_kec]"; ?></span> belum di buatkan invoice untuk periode saat ini (<?php echo $tgl_bayar; ?>)
								</div>
								
								<?php	
								}
									} //END NOTIVIKASI INVOICE
								?>
								
								
								
<div class="container-fluid" style="margin-top:7px">
	<div id ="container"></div>
</div>

</body>
</html>
