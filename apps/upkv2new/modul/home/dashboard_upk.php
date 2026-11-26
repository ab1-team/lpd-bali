<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
include "inc/fungsi_pinjaman.php";

$now	=date('Y-m-t');
$akt	=aktiva("$now");
$ak1	=substr($akt,0,-6);
$ak2	=substr($akt,-6);

$ma=modalawal("$now");
$ap=asetproduktif("$now");
$pd=$ap-$ma;
$pr=@(floor($pd/$ma*100));

?>

<script type="text/javascript">	


		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
</script>
						
    <div class="row hidden-print">
		<a href="modul/pinjaman/cp/LTA.php" target="_blank">1. Laporan Tagihan Hari Ini (Kelompok)</a><br>
		<a href="modul/pinjaman/cp/i_LTA.php" target="_blank">2. Laporan Tagihan Hari Ini (Individu)</a><br>
		<a href="modul/pinjaman/cp/LTU.php" target="_blank">3. Laporan Tunggakan s.d. Hari Ini (Kelompok)</a><br>
		<a href="modul/pinjaman/cp/i_LTU.php" target="_blank">4. Laporan Tunggakan s.d. Hari Ini (Individu)</a><br>
		<a href="modul/pinjaman/cp/RPY.php" target="_blank">5. Laporan Reminder (Kelompok)</a><br>
		<a href="modul/pinjaman/cp/i_RPY.php" target="_blank">6. Laporan Reminder (Individu)</a><br>
