<?php session_start();
if(isset($_SESSION['id'])){
	include "index_home.php";
	?>
	<script type="text/javascript">
		$("#Asset").load('php/cek_asset.php');
		$("#Debitur").load('php/cek_debitur.php');
		$("#Surplus").load('php/cek_surplus.php');
		$("#Kreditur").load('php/cek_kreditur.php');
		$("#CekDPR").load('php/cek_dpr.php');
		$("#CekRekomendasiAnalis").load('php/cek_rekomendasi_analis.php');
		$("#CekRekomendasiKepala").load('php/cek_rekomendasi_kepala.php');
		$("#CekRekomendasiBawas").load('php/cek_rekomendasi_bawas.php');
		$("#CekWaitingList").load('php/cek_waiting_list.php');
		$("#ChartFinance").load('php/chart_finance.php');
		$("#ChartLabaRugi").load('php/chart_finance.php');
	</script>
	<?php
}else{
	include "landing.php";
}
 ?>