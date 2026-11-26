
        <h2 class="page-title">Update <span class="fw-semi-bold">Fitur</span></h2>
        <ul class="timeline">
            
<?php
include "inc/fungsi_indotgl.php";
$view=mysql_query("select * from update_fitur ORDER BY id DESC");
								while($row=mysql_fetch_array($view)){
									
if ($row['id'] % 2 == 0) { $posisi=""; } else { $posisi="on-left"; } //Mengatur Posisi by Ganjil Genap
		 if ($row['sdlc'] == 1){ $sdlc="Assess_Needs"; $sdlc_icon="glyphicon glyphicon-zoom-in"; $warna="danger"; } 
	else if ($row['sdlc'] == 2){ $sdlc="Design_Specification"; $sdlc_icon="glyphicon glyphicon-edit"; $warna="primary"; }
	else if ($row['sdlc'] == 3){ $sdlc="Development"; $sdlc_icon="fa fa-keyboard-o"; $warna="warning";} 
	else if ($row['sdlc'] == 4){ $sdlc="Implement_System"; $sdlc_icon="fa fa-laptop"; $warna="success";}
	else if ($row['sdlc'] == 5){ $sdlc="Maintenance"; $sdlc_icon="glyphicon glyphicon-cog"; $warna="info";}
?>
            <li class="<?php echo $posisi; ?>">
                <time class="event-time">
                    <span class="date">Release, <?php echo tgl_indo($row['tanggal']); ?></span>
                    <span class="time"> <?php echo jam($row['tanggal']); ?> <span class="fw-semi-bold"><?php echo ampm($row['tanggal']); ?></span></span>
                </time>
                <span class="event-icon event-icon-<?php echo $warna; ?>">
                    <i class="<?php echo $sdlc_icon; ?>"></i>
                </span>
                <section class="event">
                    <h4 class="event-heading"><a href="#"><?php echo "$row[judul]"; ?></a> <small>@<?php echo $sdlc; ?></small></h4>
                    <p class="fs-sm text-muted"><?php echo tgl_indo($row['tanggal']); ?> <?php echo jam($row['tanggal']); ?> <?php echo ampm($row['tanggal']); ?></p>
                    <p class="fs-mini">
                        <?php echo "$row[deskripsi]"; ?>
                    </p>
					<?php if (empty($row['foto'])) { echo ""; } else { ?>
                    <div class="event-image">
                        <a href="images/update_fitur/<?php echo "$row[foto]"; ?>" target="_blank">
                            <img src="images/update_fitur/<?php echo "$row[foto]"; ?>">
                        </a>
                    </div>
					<?php } ?>
					
                </section>
            </li>
 <?php
								}
 ?> 
			
        </ul>