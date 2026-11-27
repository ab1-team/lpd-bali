<?php session_start();
include "inc/inc.koneksi.php";
?>
	<h5 class="sidebar-nav-title">Data <a class="action-link" href="#"><i class="glyphicon glyphicon-refresh"></i></a></h5>
		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=1"><span class="icon"><i class="fa fa-home"></i></span>Home</a></li>
            <li><a class="collapsed" href="#sidebar-prop" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-bank"></i></span>Propinsi<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-prop" class="collapse">
					<?php
					$view=mysql_query("SELECT * FROM propinsi WHERE id!='1' ");
						while($row=mysql_fetch_array($view)){
							echo "<li><a href='?p=x&idc=$row[id]'>$row[nama_prop]</a></li>";
						}
					?>
                </ul>
            </li>
			<li><a class="collapsed" href="#sidebar-kab1" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-bank"></i></span>Kabupaten<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-kab1" class="collapse">
				
					<?php
					$view=mysql_query("SELECT * FROM propinsi WHERE id!='1' ");
						while($row=mysql_fetch_array($view)){
							echo "
							<li>
								<a class='collapsed' href='#sidebar-sub-kab2$row[id]' data-toggle='collapse' data-parent='#sidebar-kab2$row[id]'>$row[nama_prop]<i class='toggle fa fa-angle-down'></i></a>
								<ul id='sidebar-sub-kab2$row[id]' class='collapse'> ";
								
								$views=mysql_query("SELECT * FROM kabupaten WHERE kd_prov='$row[id]' ");
									while($rows=mysql_fetch_array($views)){
										echo "<li><a href='?p=lb&idb=$rows[id]'>$rows[nama_kab]</a></li>";
									}
							echo "
								</ul>
							</li>
							";
						}
					?>
                </ul>
            </li>
			
			<li><a class="collapsed" href="#sidebar-kec1" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-bank"></i></span>Kecamatan<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-kec1" class="collapse">
				
					<?php
					$view=mysql_query("SELECT * FROM propinsi WHERE id!='1' ");
						while($row=mysql_fetch_array($view)){
							echo "
							<li>
								<a class='collapsed' href='#sidebar-sub-kec2$row[id]' data-toggle='collapse' data-parent='#sidebar-kec2$row[id]'>$row[nama_prop]<i class='toggle fa fa-angle-down'></i></a>
								<ul id='sidebar-sub-kec2$row[id]' class='collapse'> ";
								
								$views=mysql_query("SELECT * FROM kabupaten WHERE kd_prov='$row[id]' ");
									while($rows=mysql_fetch_array($views)){
										echo "
										
											<li><a class='collapsed' href='#sidebar-sub-kec3$rows[id]' data-toggle='collapse' data-parent='#sidebar-kec3$rows[id]'>$rows[nama_kab]<i class='toggle fa fa-angle-down'></i></a>
												<ul id='sidebar-sub-kec3$rows[id]' class='collapse'> ";
												
											$viewss=mysql_query("SELECT * FROM kecamatan WHERE kd_kab='$rows[id]' ");
											while($rowss=mysql_fetch_array($viewss)){
												echo "
													<li><a href='?p=lc&idc=$rowss[id]'>&nbsp; &nbsp; <i class='fa fa-sign-out'></i> $rowss[nama_kec]</a></li>
													";
											}
										
										echo "
												</ul>
											</li>
										
										";
									}
							echo "
								</ul>
							</li>
							";
						}
					?>
                </ul>
            </li>
		</ul>
	
	<?php 
		$unpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' ")); 
		$paid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='PAID' ")); 
	
	if($_SESSION['id']=='1' or $_SESSION['id']=='2') {
	?>
	
	<h5 class="sidebar-nav-title">Manajemen <a class="action-link" href="#"><i class="glyphicon glyphicon-refresh"></i></a></h5>
		<ul class="sidebar-nav"> 
            <li><a href="?p=users_upk"><span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>DATA USER</a></li>
			<li><a class="collapsed" href="#sidebar-invoice" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>INVOICE<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-invoice" class="collapse">
					<li><a href="?p=form_invoice">NEW INVOICE</a></li>
					<li><a href="?p=invoice&sts=UNPAID">UNPAID <span class="badge bg-danger pull-right animated bounceIn mr-sm"><?php echo $unpaid; ?></span></a></li>
					<li><a href="?p=invoice&sts=PAID">PAID <span class="badge bg-success pull-right animated bounceIn mr-sm"><?php echo $paid; ?></span></a></li>
				</ul>
            </li>
			<li><a class="collapsed" href="#sidebar-transaksi" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>TRANSAKSI<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-transaksi" class="collapse">
					<li><a href="?p=trx">JURNAL UMUM</a></li>
					<li><a href="?p=tutup_buku">TUTUP BUKU</a></li>
				</ul>
            </li>
			<li><a href="?p=laporan"><span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>LAPORAN</a></li>
		</ul>
		
	<?php } ?>