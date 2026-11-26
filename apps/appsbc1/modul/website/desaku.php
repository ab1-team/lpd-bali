		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tabD01" data-toggle="tab"><i class="glyphicon glyphicon-road"></i> Desa<span class="fw-semi-bold">Ku</span></a></li>
                        <?php
						$desa=mysql_query("select * from kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' order by d.id asc");
						$jum_desa = mysql_num_rows($desa);
						$no=0;
							while($da=mysql_fetch_array($desa)){
							$kd_kab=$da['kd_kab'];
						echo "
						<li class=''><a href='#tabD$da[id]' data-toggle='tab'><i class='fa fa-bank'></i> $da[nama_desa]</a></li>
						";
						 } ?>
                    </ul>
                    <div id="tabs5c" class="tab-content">
						<div class="active tab-pane" id="tabD01">
							<div class="alert alert-success animated fadeInDown mt">
								<h3 class="text-align-center"><i class="glyphicon glyphicon-road"></i><br>Selamat Datang di Desa Kami,<br><br></h3>
								<img src="images/desa.jpg" class="col-xs-6"/>
								<p class="text-justify"><?php echo "<span class='fw-semi-bold'>Kecamatan $kec[nama_kec]</span> terdiri dari $jum_desa desa dibawah wilayah Administrasi Pemerintah Kabupaten $kec[nama_kab]
								Provinsi $kec[nama_prov].";?></p>
								<p class="text-justify"><?php echo "Sampai dengan saat ini, di kecamatan $kec[nama_kec] terdapat $jum_kel kelompok SPP/UEP dengan pemanfaat sejumlah
								$jum_angg orang yang semuanya berdomisili secara hukum di wilayah kecamatan $kec[nama_kec] Kabupaten $kec[nama_kab].";?></p>
								<p class="text-justify"><?php echo "Adapun perkembangan kelompok di kecamatan $kec[nama_kec] berdasarkan jenis, tingkat, dan fungsinya dapat dilihat pada tabel berikut :";?></p>

								<p class="text-justify">1. Berdasarkan Jenis Produk Pinjaman :</p>
								<table class="table">
									<tr><th>Jenis Produk Pinjaman</th><th>Jumlah Kelompok</th></tr>
								<?php
								$djpp=mysql_query("select * from jenis_produk_pinjaman order by id asc");
									while($jpp=mysql_fetch_array($djpp)){
									$jum_keljpp=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE lokasi='$kec[id]' AND jenis_produk_pinjaman='$jpp[id]' "));
									echo "
									<tr><td>$jpp[deskripsi_jpp]</td><td class='text-right'>$jum_keljpp</td></tr>
									";
								}
								?>
								</table>

								<p class="text-justify">2. Berdasarkan Jenis Usaha :</p>
								<table class="table">
									<tr><th>Jenis Usaha</th><th>Jumlah Kelompok</th></tr>
								<?php
								$djpp=mysql_query("select * from jenis_usaha order by id asc");
									while($ju=mysql_fetch_array($djpp)){
									$jum_keljpp=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE lokasi='$kec[id]' AND jenis_usaha='$ju[id]' "));
									echo "
									<tr><td>$ju[deskripsi_ju]</td><td class='text-right'>$jum_keljpp</td></tr>
									";
								}
								?>
								</table>

								<p class="text-justify">2. Berdasarkan Jenis Kegiatan :</p>
								<table class="table">
									<tr><th>Jenis Kegiatan</th><th>Jumlah Kelompok</th></tr>
								<?php
								$djpp=mysql_query("select * from jenis_kegiatan order by id asc");
									while($jk=mysql_fetch_array($djpp)){
									$jum_keljk=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE lokasi='$kec[id]' AND jenis_kegiatan='$jk[id]' "));
									echo "
									<tr><td>$jk[deskripsi_jk]</td><td class='text-right'>$jum_keljk</td></tr>
									";
								}
								?>
								</table>

								<p class="text-justify">4. Berdasarkan Tingkat Kelompok :</p>
								<table class="table">
									<tr><th>Tingkat Kelompok</th><th>Jumlah Kelompok</th></tr>
								<?php
								$djpp=mysql_query("select * from tingkat_kelompok order by id asc");
									while($tk=mysql_fetch_array($djpp)){
									$jum_keltk=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE lokasi='$kec[id]' AND tingkat_kelompok='$tk[id]' "));
									echo "
									<tr><td>$tk[deskripsi_tk]</td><td class='text-right'>$jum_keltk</td></tr>
									";
								}
								?>
								</table>
								
								<p class="text-justify">5. Berdasarkan Fungsi Kelompok :</p>
								<table class="table">
									<tr><th>Fungsi Kelompok</th><th>Jumlah Kelompok</th></tr>
								<?php
								$dfk=mysql_query("select * from fungsi_kelompok order by id asc");
									while($fk=mysql_fetch_array($dfk)){
									$jum_kelfk=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE lokasi='$kec[id]' AND fungsi_kelompok='$fk[id]' "));
									echo "
									<tr><td>$fk[deskripsi_fgs]</td><td class='text-right'>$jum_kelfk</td></tr>
									";
								}
								?>
								</table>
								
								
							</div>
						</div>
						
				<?php
				$desas=mysql_query("select * from kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' order by d.id asc");
				while($ds=mysql_fetch_array($desas)){
					$jum_kelD=mysql_num_rows(mysql_query("select * from kelompok_$kd_kab WHERE desa='$ds[id]' "));
					$jum_anggD=mysql_num_rows(mysql_query("select * from anggota_$kd_kab WHERE desa='$ds[id]' "));
						echo "
				
						<div class='tab-pane' id='tabD$ds[id]'>
							<header>
								<legend><i class='fa fa-bank'></i> $ds[nama_desa]</legend>
							</header>
							<p class='text-justify text-muted'>Desa $ds[nama_desa] terletak di wilayah administrasi pemerintah kecamatan $ds[nama_kec] Kabupaten $kec[nama_kab]
								Provinsi $kec[nama_prov].</p>
							<p class='text-justify text-muted'>Saat ini Kepala Pemerintahan Desa $ds[nama_desa] dijabat oleh seorang Kepala Desa bernama $ds[kades] yang dibantu
							oleh seorang Sekretaris Desa bernama $ds[sekdes]. Sedangkan untuk membantu kegiatan desa khususnya dibidang perekonomian 
							ditugaskan kepada seorang Kader Ekonomi Desa (KED) bernama $ds[ked].</p>
							<p class='text-justify text-muted'>Batas Wilayah Desa secara geografis dapat digambarkan sebagai berikut :</p>
							<ul class='text-list text-muted'>
								<li>Barat berbatasan dengan : </li>
								<li>Utara berbatasan dengan : </li>
								<li>Timur berbatasan dengan : </li>
								<li>Selatan berbatasan dengan : </li>
							</ul>
							<p class='text-justify text-muted'>Sampai dengan saat ini, Desa $ds[nama_desa] terdiri dari $jum_kelD kelompok SPP/UEP dengan
							jumlah anggota pemanfaat sejumlah $jum_anggD warga yang semuanya merupakan masyarakat berdomisili secara hukum di wilayah
							Desa $ds[nama_desa] Kecamatan $ds[nama_kec] yang dibuktikan dengan KTP.</p>
							<p class='text-justify text-muted'>$ds[deskripsi_desa].</p>
                        </div> ";
				}
				?>
						
                    </div>
                </div>
            </div>
        </div>