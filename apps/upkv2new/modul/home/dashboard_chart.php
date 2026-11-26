<?php
session_start();
include '../../inc/inc.koneksi.php';
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_pinjaman.php";
include "./charts.php";
?>

<script src="/modul/home/highchats/code/highcharts.js"></script>
<script src="/modul/home/highchats/code/modules/series-label.js"></script>
<script src="/modul/home/highchats/code/modules/exporting.js"></script>

<div id="pendapatandanbiaya" style="min-width: 310px; height: 360px; margin: 0 auto"></div> 

<script type="text/javascript">
    Highcharts.chart('pendapatandanbiaya', {
    	chart: {
          backgroundColor: '#eeeeee'
    	},
    
        title: {
            text: '<code>Realisasi Pendapatan dan Biaya<br><?php echo "Tahun $th";?></code>'
        },
        xAxis: {
            categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember']
        },
    	yAxis:{
    		labels:{
    			formatter:function(){
    				return(this.value/1000000)+" Juta";
    			}
    		}
    	},
        labels: {
            items: [{
                html: 'Total RPB <?php echo $th;?>',
                style: {
                    left: '67px',
                    top: '70px',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                }
            }]
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
        }, {
            type: 'column',
            name: 'Surplus',
            data: [<?php echo "$s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10, $s11, $s12"; ?>],
    		color: Highcharts.getOptions().colors[3]
        }, {
            type: 'spline',
            name: 'Surplus Line',
            data: [<?php echo "$s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10, $s11, $s12"; ?>],
    		color: Highcharts.getOptions().colors[4],
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[4],
                fillColor: 'white'
            }
        }, {
            type: 'pie',
            name: 'Rp',
            data: [{
                name: 'Pendapatan',
                y: <?php echo $pendapatan; ?>,
                color: Highcharts.getOptions().colors[7] // Jane's color
            }, {
                name: 'Biaya',
                y: <?php echo $biaya; ?>,
                color: Highcharts.getOptions().colors[8] // John's color
            }, {
                name: 'Surplus',
                y: <?php echo $surplus; ?>,
                color: Highcharts.getOptions().colors[3] // Joe's color
            }],
            center: [85, 0],
            size: 100,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });
</script>