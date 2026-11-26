<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
$id	= $_SESSION['ida'];
$table	= "kelompok_$_SESSION[kd_kab]";
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
																fungsi_kelompok fgs, users u, sistem_angsuran sa, $table k
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=k.jenis_produk_pinjaman AND ju.id=k.jenis_usaha AND 			
																jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
																k.id='$id'"));

	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	//$st=$row['status']; if ($st=="1") { $sp="Aktif"; $lb="label-success";}else{ $sp="Non-Aktif"; $lb="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}	
?>	
							<fieldset>
                                <div><div class="col-sm-4">ID</div><label class="col-sm-8">: <?php echo $row['kd_kelompok'];?></label></div>
                                <div><div class="col-sm-4">Nama Kelompok</div><label class="col-sm-8">: <?php echo $row['nama_kelompok'];?></label></div>
                                <div><div class="col-sm-4">Alamat</div><label class="col-sm-8">: <?php echo $row['alamat_kelompok'];?></label></div>
                                <div><div class="col-sm-4">Desa</div><label class="col-sm-8">: <?php echo $row['nama_desa'];?></label></div>
                                <div><div class="col-sm-4">Kecamatan</div><label class="col-sm-8">: <?php echo $row['nama_kec'];?></label></div>
                                <div><div class="col-sm-4">Telpon</div><label class="col-sm-8">: <?php echo $row['telpon'];?></label></div>
                                <div><div class="col-sm-4">Nama Ketua </div><label class="col-sm-8">: <?php echo $row['ketua'];?></label></div>
                                <div><div class="col-sm-4">Nama Sekretaris </div><label class="col-sm-8">: <?php echo $row['sekretaris'];?></label></div>
                                <div><div class="col-sm-4">Nama Bendahara </div><label class="col-sm-8">: <?php echo $row['bendahara'];?></label></div>
                                <div><div class="col-sm-4">Tanggal Berdiri </div><label class="col-sm-8">: <?php echo tgl_indo($row['tgl_berdiri']);?></label></div>
                                <div><div class="col-sm-4">Jenis Produk</div><label class="col-sm-8">: <?php echo $row['nama_jpp'];?> (<?php echo $row['deskripsi_jpp'];?>)</label></div>
                                <div><div class="col-sm-4">Jenis Usaha</div><label class="col-sm-8">: <?php echo $row['nama_ju'];?></label></div>
                                <div><div class="col-sm-4">Jenis Kegiatan</div><label class="col-sm-8">: <?php echo $row['nama_jk'];?></label></div>
                                <div><div class="col-sm-4">Tingkat</div><label class="col-sm-8">: <?php echo $row['nama_tk'];?></label></div>
                                <div><div class="col-sm-4">Fungsi Kelompok </div><label class="col-sm-8">: <?php echo $row['nama_fgs'];?></label></div>
                                <div><div class="col-sm-4">Last Update </div><label class="col-sm-8">: <?php echo $row['lo'];?></label></div>
                                <div><div class="col-sm-4">Petugas/PJ </div><label class="col-sm-8">: <?php echo "$row[namadepan] $row[namabelakang]";?></label></div>
							</fieldset>