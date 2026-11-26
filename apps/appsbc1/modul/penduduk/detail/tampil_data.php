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

<table width="100%">
<tr>
<td width="23%" height="25" align="center" valign="top">
<body>
			<span class="thumb-sm avatar img-user mt-sm text-align-center" style="width:180px;">
							
				
				<div id="camera">
				<?php
										$foto="../../../foto_anggota/$row[nik].png";
										if(file_exists($foto)){
											echo "<img  alt='' src='foto_anggota/$row[nik].png'>";
										}else{
											echo "<img  src='img/avatar.png'>";
										}
										?>
				</div>
				<div id="ambil">
					<button type="button" onClick="foto()" class="btn btn-sm btn-block btn-primary" <?php echo $disabled; ?>><i class="glyphicon glyphicon-camera"></i> AMBIL FOTO</button>
				</div>
				<div id="webcam" style="display:none">
					<button type="button" onClick="preview()" class="btn btn-sm btn-block btn-primary"><i class="glyphicon glyphicon-camera"></i> TANGKAP</button>
				</div>
				<div id="simpanfoto" style="display:none">
					<div class="btn-group">
                            <button type="button" class="btn btn-sm btn-grey" onClick="batal()"><i class="glyphicon glyphicon-remove"></i> REMOVE </button>
                            <button type="button" class="btn btn-sm btn-grey" onClick="simpanfoto()" style="font-weight:bold;"> &nbsp; <i class="glyphicon glyphicon-qrcode"></i> SIMPAN</button>
                        </div>
				</div>
			</span>
 
    <script src="modul/penduduk/js/webcam.min.js"></script>
    <script language="Javascript">
        // konfigursi webcam
        Webcam.set({
            width: 240,
			height: 180,

			// device capture size
			dest_width: 240,
			dest_height: 180,

			// final cropped size
			crop_width: 180,
			crop_height: 180,
            image_format: 'jpg',
            jpeg_quality: 100
        });
		
		function foto() {
			Webcam.attach('#camera');
			document.getElementById('webcam').style.display = '';
			document.getElementById('ambil').style.display = 'none';
		}
	
        function preview() {
            // untuk preview gambar sebelum di upload
            Webcam.freeze();
            // ganti display webcam menjadi none dan simpan menjadi terlihat
            document.getElementById('webcam').style.display = 'none';
            document.getElementById('simpanfoto').style.display = '';
        }
        
        function batal() {
            // batal preview
            Webcam.unfreeze();
            
            // ganti display webcam dan simpan seperti semula
            document.getElementById('webcam').style.display = '';
            document.getElementById('simpanfoto').style.display = 'none';
			document.getElementById('ambil').style.display = 'none';
        }
		
		function simpanfoto() {
			// ambil foto
			Webcam.snap(function(data_uri) {

				// upload foto
				Webcam.upload(data_uri, 'modul/penduduk/upload_foto.php?nik=<?php echo $row['nik'];?>', function(code, text) {});

				// tampilkan hasil gambar yang telah di ambil                
				Webcam.unfreeze();
				Webcam.reset();
				document.getElementById('camera').innerHTML =
					'<img src="' + data_uri + '"/>';
				document.getElementById('ambil').style.display = '';
				document.getElementById('webcam').style.display = 'none';
				document.getElementById('simpanfoto').style.display = 'none';

			});
		}
		
    </script>
    
</body>
</td>
<td width="15%">
 <p>N I K</p>
  <p>Nama Lengkap</p>
  <p>Jenis Kelamin</p>
  <p>Tempat, Tgl Lahir</p>
  <p>Alamat</p>
  <p>Desa / Kecamatan</p>
  <p>Phone</p>
  <p>No. KK</p>
  <p>Penjamin</p>
  <p>Nama/Jenis Usaha</p>
  <p>Tanggal Register</p>
  <p>Petugas</p>
  <p>Status</p>
</td>
<th width="62%">
  <p>: <?php echo $row['nik'];?></p>
  <p>: <?php echo $row['namadepan'];?></p>
  <p>: <?php echo $row['jk'];?></p>
  <p>: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($row['tgl_lahir']);?></p>
  <p>: <?php echo $row['alamat'];?></p>
  <p>: <?php echo $row['nama_desa'];?> / <?php echo $row['nama_kec'];?></p>
  <p>: <?php echo $row['hp'];?></p>
  <p>: <?php echo $row['kk'];?></p>
  <p>: <?php echo $row['penjamin'];?> (<?php echo $row['kekeluargaan'];?>)</p>
  <p>: <?php echo $row['nama_usaha'];?></p>
  <p>: <?php echo tgl_indo($row['terdaftar']);?></p>
  <p>: <?php echo $row['namadepan'];?></p>
  <p>: <?php echo "<span class='label $lb'>$sp</span>";?></p></td>
</th>
</table>