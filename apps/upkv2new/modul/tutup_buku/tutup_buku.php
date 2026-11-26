<?php
$lokasi			=$_SESSION['lokasi'];
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$rek=mysql_fetch_array(mysql_query("SELECT * FROM rekening_$lokasi "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
?>
<script type="text/javascript">
			$(document).ready(function() {
			
				$("#TampilStep").load('modul/tutup_buku/step1.php');
				
            });
        </script>

<h3><i class="fa fa-book"></i> Tutup Buku Tahunan</h3>

<section class="widget">
	<div class="widget-body">
		<form role="form">
			<fieldset>
				<div id="TampilStep"></div>
			</fieldset>
		</form>
	</div>
</section>