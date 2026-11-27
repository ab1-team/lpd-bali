<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="fa fa-camera"></i> Galery Foto</h3>
	</legend>
        <div class="row gallery" id="grid">
		<?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from users u, news n WHERE u.id=n.penulis AND n.lokasi='$_SESSION[lokasi]' AND n.status='P' order by n.tanggal DESC");
								while($row=mysql_fetch_array($view)){ 
		?>
            <div class="col-sm-6 col-md-4 gallery-item" >
                <div class="thumbnail">
                    <a href="images/news/<?php echo $row['foto'];?>" target="_blank"><img src="images/news/<?php echo $row['foto']; ?>"></a>
                    <div class="caption">
                        <h5 class="mt-0 mb-xs"><?php echo $row['judul'];?></h5>
                        <ul class="post-links">
                            <li><a href="#"><?php echo $row['tanggal'];?></a></li>
                            <li><a href="#"><span class="text-danger"><i class="fa fa-heart-o"></i> <?php echo $row['namadepan'];?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
		<?php } ?>

            <div class="col-sm-6 col-md-3 js-shuffle-sizer"></div>
        </div>
    </div>
</section>