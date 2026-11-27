
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
                <time class="event-time" datetime="2014-05-19 03:04">
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
					
					
<!--
                    <footer>
                        <div class="clearfix">
						
						<script type="text/javascript">
						$(document).ready(function() {
								
								$("#TampilLike<?php echo "$row[id]"; ?>").load('modul/update_fitur/tampil_like.php');
							
							});		
						</script>
						
                            <div id="TampilLike<?php echo "$row[id]"; ?>"></div>


                            <span class="thumb thumb-sm pull-right">
                                <a href="#">
                                    <img class="img-circle" src="demo/img/people/a1.jpg">
                                </a>
                            </span>
                            <span class="thumb thumb-sm pull-right">
                                <a href="#"><img class="img-circle" src="demo/img/people/a5.jpg"></a>
                            </span>
                            <span class="thumb thumb-sm pull-right">
                                <a href="#"><img class="img-circle" src="demo/img/people/a3.jpg"></a>
                            </span>


                        </div>
                        <ul class="post-comments mt-sm">
						<?php
						$views=mysql_query("select * from chat_fitur c, users u, jabatan j, level l, kecamatan k, kabupaten b WHERE k.kd_kab=b.id AND u.jabatan=j.id AND u.level=l.id AND u.lokasi=k.id AND c.id_sender=u.id AND id_fitur=$row[id] ORDER BY tanggal DESC");
								while($r=mysql_fetch_array($views)){
						?>
                            <li>
                                <span class="thumb-xs avatar pull-left mr-sm">
                                    <?php
										$foto=$r['foto'];
										if (empty($foto)) {
											echo "<img class='img-circle' src='img/avatar.png' alt='...'>";
											}else{
											echo "<img class='img-circle' alt='...' src='foto_users/$foto'>";
											}
										?>
                                </span>
                                <div class="comment-body">
                                    <h6 class="author fw-semi-bold"><?php echo "$r[namadepan] $r[namabelakang]"; ?> <small><?php echo tgl_ind($r['tanggal']); ?> <?php echo jam($r['tanggal']); ?><?php echo ampm($r['tanggal']); ?></small><br>
									<small><i class="fa fa-dot-circle-o"></i> <?php echo "$r[nama_jabatan] $r[nama_level] $r[nama_kec] $r[nama_kab]"; ?></small></h6>
                                    <p><?php echo "$r[isi]"; ?></p>
                                </div>
                            </li>
						<?php } ?>
                            <li>
                                <span class="thumb-xs avatar pull-left mr-sm">
									<?php
										$foto=$_SESSION['foto'];
										if (empty($foto)) {
											echo "<img class='img-circle' src='img/avatar.png' alt='...'>";
											}else{
											echo "<img class='img-circle' alt='...' src='foto_users/$foto'>";
											}
										?>
                                </span>
                                <div class="comment-body">
                                    <input class="form-control input-sm" type="text" placeholder="Tulis pendapat anda terkait fitur diatas...">
                                </div>
                            </li>
                        </ul>
                    </footer>
					
					-->
                </section>
            </li>
 <?php
								}
 ?> 
			
        </ul>