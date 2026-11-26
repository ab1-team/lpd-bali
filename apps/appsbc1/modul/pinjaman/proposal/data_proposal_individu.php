<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
$id	= $_SESSION['idprop'];
$row=mysql_fetch_array(mysql_query("select * from desa d, sistem_angsuran sa, jenis_jasa jj, 
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																d.id=a.desa AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND
																a.id=pi.nia AND pi.id='$id'"));	 ?>

<?php if($row['status']=='P') { ?>
<fieldset>
<div><div class="col-sm-2">Loan ID</div><label class="col-sm-10">: <?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal Proposal</div><label class="col-sm-10">: <?php echo tgl_indo($row['tgl_proposal']);?></label></div>
<div><div class="col-sm-2">Alokasi Pengajuan</div><label class="col-sm-10">: <?php echo number_format($row['proposal']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-10">: <?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-10">: <?php echo "$row[nama_jj]";?> </label></div>
<div><div class="col-sm-2">Jangka</div><label class="col-sm-10">: <?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-10">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label></div>
</fieldset>

<?php }elseif($row['status']=='V') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-5 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-5 text-center fw-semi-bold">VERIFIKASI</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-5">: <?php echo "$row[kd_kelompok] - $row[id]";?></label>					<label class="col-sm-5"><?php echo "$row[kd_kelompok] - $row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-5">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-5"><?php echo tgl_indo($row['tgl_verifikasi']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-5">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-5"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-5">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-5"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-5">: <?php echo $row['nama_jj'];?> </label>								<label class="col-sm-5"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-5">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-5"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-5">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label>	<label class="col-sm-5"><?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }elseif($row['status']=='W') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-4 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-3 text-center fw-semi-bold">WAITING</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-4">: <?php echo "$row[kd_kelompok] - $row[id]";?></label>					<label class="col-sm-3"><?php echo "$row[kd_kelompok] - $row[id]";?></label>				<label class="col-sm-3"><?php echo "$row[kd_kelompok] - $row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-4">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_indo($row['tgl_verifikasi']);?></label>				<label class="col-sm-3"><?php echo tgl_indo($row['tgl_tunggu']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-4">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-4">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label>							<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-4">: <?php echo $row['nama_jj'];?> </label>								<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label>							<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-4">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-4">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label>	<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label>							<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }else{ ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div>			<label class="col-sm-3 text-center fw-semi-bold">PROPOSAL</label>								<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-2 text-center fw-semi-bold">WAITING</label>				<label class="col-sm-2 text-center fw-semi-bold">PENCAIRAN</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-3">: <?php echo "$row[kd_kelompok] - $row[id]";?></label>					<label class="col-sm-3"><?php echo "$row[kd_kelompok] - $row[id]";?></label>				<label class="col-sm-2"><?php echo "$row[kd_kelompok] - $row[id]";?></label>	<label class="col-sm-2"><?php echo "$row[kd_kelompok] - $row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-3">: <?php echo tgl_ind($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_ind($row['tgl_verifikasi']);?></label>				<label class="col-sm-2"><?php echo tgl_ind($row['tgl_tunggu']);?></label>		<label class="col-sm-2"><?php echo tgl_ind($row['tgl_cair']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-3">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label>	<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-3">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label>							<label class="col-sm-2"><?php echo $row['pros_jasa'];?> %</label>				<label class="col-sm-2"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div>		<label class="col-sm-3">: <?php echo $row['nama_jj'];?> </label>										<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label>							<label class="col-sm-2"><?php echo $row['nama_jj'];?> </label>				<label class="col-sm-2"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-3">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label>				<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-3">: <?php echo "$row[nama_sistem]";?></label>								<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label>							<label class="col-sm-2"><?php echo "$row[nama_sistem]";?></label>				<label class="col-sm-2"><?php echo "$row[nama_sistem]";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>
<?php } ?>