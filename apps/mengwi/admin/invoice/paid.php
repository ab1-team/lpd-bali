<?php 
		$jumU=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' ")); 
	echo $jumU;
	?>