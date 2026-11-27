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
					$view=mysql_query("SELECT * FROM propinsi WHERE id='$_SESSION[id]' ");
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
					$view=mysql_query("SELECT * FROM kabupaten WHERE kd_prov='$_SESSION[id]' ");
						while($rowb=mysql_fetch_array($view)){
							echo "<li><a href='?p=lb&idb=$rowb[id]'>$rowb[nama_kab]</a></li>";
						}
					?>
                </ul>
            </li>
			
			<li><a class="collapsed" href="#sidebar-kec1" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-bank"></i></span>Kecamatan<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-kec1" class="collapse">
				
					<?php
					$view=mysql_query("SELECT * FROM kabupaten WHERE kd_prov='$_SESSION[id]' ");
						while($row=mysql_fetch_array($view)){
							echo "
							<li>
								<a class='collapsed' href='#sidebar-sub-kec2$row[id]' data-toggle='collapse' data-parent='#sidebar-kec2$row[id]'>Kab. $row[nama_kab]<i class='toggle fa fa-angle-down'></i></a>
								<ul id='sidebar-sub-kec2$row[id]' class='collapse'> ";
								
								$views=mysql_query("SELECT * FROM kecamatan WHERE kd_kab='$row[id]' ");
									while($rows=mysql_fetch_array($views)){
										echo "<li><a href='?p=lc&idc=$rows[id]'>Kec. $rows[nama_kec]</a></li>";
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