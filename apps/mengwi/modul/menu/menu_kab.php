<?php session_start();
include "inc/inc.koneksi.php";
?>
		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=1"><span class="icon"><i class="fa fa-home"></i></span>Home</a></li>
            <li><a class="collapsed" href="#sidebar-kecamatan" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-bank"></i></span>Cabang <i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-kecamatan" class="collapse">
					<?php
					$view=mysql_query("SELECT * FROM kecamatan WHERE kd_kab='$_SESSION[id]' ");
						while($row=mysql_fetch_array($view)){
							echo "<li><a href='?p=lc&idc=$row[id]'>$row[nama_kec]</a></li>";
						}
					?>
                </ul>
            </li>
            <li><a href="?p=lb&idb=<?php echo "$_SESSION[kd_kab]"; ?>"><span class="icon"><i class="fa fa-bank"></i></span>Pusat</a></li>
		</ul>