<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
$id	= $_SESSION['ida'];
$row=mysql_fetch_array(mysql_query("select * from  anggota_$_SESSION[kd_kab] a, desa d, keluarga k, usaha u  WHERE u.id=a.usaha AND k.id=a.hubungan AND d.id=a.desa AND a.id='$id'"));
$idp=$row['petugas'];
$rows=mysql_fetch_array(mysql_query("select * from users where id='$idp'"));

	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$st=$row['status']; if ($st=="1") { $sp="Aktif"; $lb="label-success";}else{ $sp="Non-Aktif"; $lb="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}	
?>	
							<fieldset>
                                <div><div class="col-sm-4">N I K</div><label class="col-sm-8">: <?php echo $row['nik'];?></label></div>
                                <div><div class="col-sm-4">Nama Lengkap</div><label class="col-sm-8">: <?php echo $row['namadepan'];?></label></div>
                                <div><div class="col-sm-4">Jenis Kelamin</div><label class="col-sm-8">: <?php echo $row['jk'];?></label></div>
                                <div><div class="col-sm-4">Tempat, Tgl Lahir</div><label class="col-sm-8">: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($row['tgl_lahir']);?></label></div>
                                <div><div class="col-sm-4">Alamat</div><label class="col-sm-8">: <?php echo $row['alamat'];?></label></div>
                                <div><div class="col-sm-4">Desa / Kecamatan</div><label class="col-sm-8">: <?php echo $row['nama_desa'];?> / <?php echo $row['nama_kec'];?></label></div>
                                <div><div class="col-sm-4">Phone</div><label class="col-sm-8">: <?php echo $row['hp'];?></label></div>
                                <div><div class="col-sm-4">No. KK</div><label class="col-sm-8">: <?php echo $row['kk'];?></label></div>
                                <div><div class="col-sm-4">Penjamin</div><label class="col-sm-8">: <?php echo $row['penjamin'];?> (<?php echo $row['kekeluargaan'];?>)</label></div>
                                <div><div class="col-sm-4">Nama/Jenis Usaha</div><label class="col-sm-8">: <?php echo $row['nama_usaha'];?></label></div>
                                <div><div class="col-sm-4">Tanggal Register</div><label class="col-sm-8">: <?php echo tgl_indo($row['terdaftar']);?></label></div>
                                <div><div class="col-sm-4">Petugas</div><label class="col-sm-8">: <?php echo $rows['namadepan'];?></label></div>
                                <div><div class="col-sm-4">Status</div><label class="col-sm-8">: <?php echo "<span class='label $lb'>$sp</span>";?></label></div>
							</fieldset>
							<div class="form-actions">
                                <button href="#tab93"  data-toggle="tab" class="btn btn-inverse btn-rounded pull-right"><i class="fa fa-edit"></i> Ubah Data</button>
                                <label></label>
                            </div>