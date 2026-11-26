<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";	

	$now	=date('Y-m-t');
	$pendapatan	=pendapatan("$now");
	$biaya		=biaya("$now");
	$surplus	=$pendapatan-$biaya;
	
	$simp_umum	=saldoR("$now-2-40002");
	$simp_dept	=saldoR("$now-2-40003");
	$pinj_umum	=saldoR("$now-1-10005");

?>

					<script type="text/javascript">
						 var ChartFinance = $('#ChartFinance');
						 var ChartLabaRugi = $('#ChartLabaRugi');
							 if (ChartLabaRugi.length){
												var verticalDemoChart = new Chart(ChartLabaRugi, {
													type: 'bar',
													data: {
													  datasets: [
														{
														  label: "Income",
														  backgroundColor: "#4A89DC",
														  data: [<?php echo $pendapatan;?>,0]
														}, {
														  label: "Cost",
														  backgroundColor: "#FC6E51",
														  data: [<?php echo $biaya;?>,0]
														}, {
														  label: "Profit",
														  backgroundColor: "#A0D468",
														  data: [<?php echo $surplus;?>,0]
														}
													  ]
													},
													options: {
														responsive: true, maintainAspectRatio:false,
														legend: {display: true, position:'right', labels:{fontSize:10, padding:15,boxWidth:10},},
														title: {display: true,text: 'Diagram Rugi Laba'},
														scales: {
															yAxes: [{
																ticks: {
																	// Untuk menyingkat angka milyar pada label menjadi 
																	callback: function(value, index, values) {
																		return value/1000000 + ' J';
																	},
																fontSize:10
																}
															}]
														}
													}
												});	
											}
											
								if(ChartFinance.length){
									var doughnutDemoChart = new Chart(ChartFinance, {
										type: 'doughnut',
										data: {
										  labels: ["SU", "SD", "Loan"],
										  datasets: [{
											backgroundColor: ["#CCD1D9","#FC6E51","#5D9CEC"],
											borderColor:"rgba(255,255,255,0.5)",
											data: [<?php echo "$simp_umum, $simp_dept, $pinj_umum";?>]
										  }]
										},
										options: {
											responsive: true, maintainAspectRatio:false,
											legend: {display: true, position:'right', labels:{fontSize:10, padding:15,boxWidth:10},},
											tooltips:{enabled:true}, animation:{duration:1500}, layout:{ padding: {bottom: 30}},
											title: {display: true,text: 'Diagram Simpin'}
										}
									});		
								}
							</script>