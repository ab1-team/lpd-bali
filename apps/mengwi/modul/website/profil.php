<section class="widget windget-padding-lg">
	<div class="widget-body">
		<h3>PROFIL <span class="fw-semi-bold">LEMBAGA</span></h3>
		<table>
			<tr><td width="40%" height="35px" class="h4">Nama Lembaga</td><td width="60%" class="fw-semi-bold h4">: UPK <?php echo $kec['nama_kec'];?></td></tr>
			<tr><td height="35px" class="h4">Alamat Kantor</td><td class="fw-semi-bold h4">: <?php echo $kec['alamat_kec'];?></td></tr>
			<tr><td height="35px" class="h4">Kecamatan</td><td class="fw-semi-bold h4">: <?php echo $kec['nama_kec'];?></td></tr>
			<tr><td height="35px" class="h4">Kabupaten</td><td class="fw-semi-bold h4">: <?php echo $kec['nama_kab'];?></td></tr>
			<tr><td height="35px" class="h4">Propinsi</td><td class="fw-semi-bold h4">: <?php echo $kec['nama_prov'];?></td></tr>
			<tr><td height="35px" class="h4">Telpon Kantor</td><td class="fw-semi-bold h4">: <?php echo $kec['telpon_kec'];?></td></tr>
			<tr><td height="35px" class="h4">E-mail</td><td class="fw-semi-bold h4">: <?php echo $kec['email_kec'];?></td></tr>
			<tr><td height="35px" class="h4">Website</td><td class="fw-semi-bold h4">: <?php echo $kec['web_kec'];?></td></tr>
			<tr><td height="35px" class="h4">Visi Misi</td><td class="fw-semi-bold h4">: <?php echo $kec['visi_misi'];?></td></tr>
			<tr><td height="35px" class="h4">Jam Kerja</td><td class="fw-semi-bold h4">: <?php echo "$kec[jam_masuk] - $kec[jam_pulang]";?></td></tr>
			<tr><td height="35px" class="h4">Tanggal Aktif</td><td class="fw-semi-bold h4">: <?php echo tgl_indo($kec['tgl_pakai']);?></td></tr>
			<tr><td height="35px" class="h4">Jumlah Kelompok</td><td class="fw-semi-bold h4">: <?php echo $jum_kel;?> Registered</td></tr>
			<tr><td height="35px" class="h4">Jumlah Anggota</td><td class="fw-semi-bold h4">: <?php echo $jum_angg;?> Registered</td></tr>
		</table>
	</div>
</section>