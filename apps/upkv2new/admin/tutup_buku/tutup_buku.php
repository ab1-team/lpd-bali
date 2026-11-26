<?php
$rek=mysql_fetch_array(mysql_query("SELECT * FROM admin_rekening "));
$tgl_open		="01";
$tgl_close		="31";
?>
<script type="text/javascript">
			$(document).ready(function() {
			
				$("#TampilStep").load('admin/tutup_buku/step1.php');
				
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