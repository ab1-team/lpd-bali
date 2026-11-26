<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
$kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));
$row=mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[id]'"));
$jab=mysql_fetch_array(mysql_query("select * from jabatan j, level l, kecamatan k, pendidikan p WHERE p.id=$row[pendidikan] and j.id=$row[jabatan] and l.id=$row[level] and k.id=$row[lokasi]"));
	$sejak=tgl_indo($row['sejak']);
	$hingga=$row['hingga'];
	if ($hingga<=0) { $mj="Sekarang"; }else{ $mj=tgl_indo($hingga);}
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$st=$row['status']; if ($st=="1") { $sp="Aktif"; $lb="label-success";}else{ $sp="Non-Aktif"; $lb="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}	
	
	$jabatan	=$row['jabatan'];
	$level	=$row['level'];
											if($jabatan=="1" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
											else if($jabatan=="2" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_2'];}
											else if($jabatan=="3" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_3'];}
											else  {$nama_jabatan=$jab['nama_jabatan'];}
?>	
							<fieldset>
                                <div><div class="col-sm-4">N I K</div><label class="col-sm-8">: <?php echo $row['nik'];?></label></div>
                                <div><div class="col-sm-4">Nama Lengkap</div><label class="col-sm-8">: <?php echo $row['namadepan'];?> <?php echo $row['namabelakang'];?></label></div>
                                <div><div class="col-sm-4">Inisial</div><label class="col-sm-8">: <?php echo $row['ins'];?></label></div>
                                <div><div class="col-sm-4">Jenis Kelamin</div><label class="col-sm-8">: <?php echo $row['jk'];?></label></div>
                                <div><div class="col-sm-4">Tempat, Tanggal Lahir</div><label class="col-sm-8">: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($row['tgl_lahir']);?></label></div>
                                <div><div class="col-sm-4">Alamat</div><label class="col-sm-8">: <?php echo $row['alamat'];?></label></div>
                                <div><div class="col-sm-4">Phone</div><label class="col-sm-8">: <?php echo $row['hp'];?></label></div>
                                <div><div class="col-sm-4">Pendidikan</div><label class="col-sm-8">: <?php echo "$jab[deskripsi_p] ($jab[tingkat])";?></label></div>
                                <div><div class="col-sm-4">Jabatan</div><label class="col-sm-8">: <?php echo "$nama_jabatan";?></label></div>
                                <div><div class="col-sm-4">Level</div><label class="col-sm-8">: <?php echo "$jab[deskripsi_level] ($jab[nama_level])";?></label></div>
                                <div><div class="col-sm-4">Lokasi Tugas</div><label class="col-sm-8">: <?php echo "Kecamatan $jab[nama_kec]";?></label></div>
                                <div><div class="col-sm-4">Masa Jabatan</div><label class="col-sm-8">: <?php echo "$sejak - $mj";?></label></div>
                                <div><div class="col-sm-4">Status</div><label class="col-sm-8">: <?php echo "<span class='label $lb'>$sp</span>";?></label></div>
							</fieldset>
							<div class="form-actions">
                                <button href="#tab52"  data-toggle="tab" class="btn btn-inverse btn-rounded pull-right"><i class="fa fa-edit"></i> Ubah Data</button>
                                <label></label>
                            </div>