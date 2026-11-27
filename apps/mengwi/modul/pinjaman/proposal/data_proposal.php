<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
$id	= $_SESSION['idprop'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj,
													kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=pk.jenis_pp AND
																sa.id=pk.sistem_angsuran AND jj.id=pk.jenis_jasa AND
																k.id=pk.id_kel AND pk.id='$id'")); ?>

<?php if($row['status']=='P') { ?>
<fieldset>
<div><div class="col-sm-2">Loan ID</div><label class="col-sm-10">: <?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal Proposal</div><label class="col-sm-10">: <?php echo tgl_indo($row['tgl_proposal']);?></label></div>
<div><div class="col-sm-2">Alokasi Pengajuan</div><label class="col-sm-10">: <?php echo number_format($row['proposal']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-10">: <?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-10">: <?php echo "$row[nama_jj]";?> </label></div>
<div><div class="col-sm-2">Jangka</div><label class="col-sm-10">: <?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-10">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label></div>
<div><div class="col-sm-2">Jenis Pinjaman</div><label class="col-sm-10">: <?php echo "$row[nama_jpp] ($row[deskripsi_jpp])";?></label></div>
</fieldset>

<?php }elseif($row['status']=='V') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-5 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-5 text-center fw-semi-bold">VERIFIKASI</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-5">: <?php echo "$row[id]";?></label>										<label class="col-sm-5"><?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-5">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-5"><?php echo tgl_indo($row['tgl_verifikasi']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-5">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-5"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-5">: <?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>								<label class="col-sm-5"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-5">: <?php echo $row['nama_jj'];?> </label>								<label class="col-sm-5"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-5">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-5"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-5">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label>	<label class="col-sm-5"><?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label></div>
<div><div class="col-sm-2">Jenis Pinjaman</div>	<label class="col-sm-5">: <?php echo "$row[nama_jpp] ($row[deskripsi_jpp])";?></label>			<label class="col-sm-5"><?php echo "$row[nama_jpp] ($row[deskripsi_jpp])";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }elseif($row['status']=='W') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-4 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-3 text-center fw-semi-bold">WAITING</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-4">: <?php echo "$row[id]";?></label>										<label class="col-sm-3"><?php echo "$row[id]";?></label>									<label class="col-sm-3"><?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-4">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_indo($row['tgl_verifikasi']);?></label>				<label class="col-sm-3"><?php echo tgl_indo($row['tgl_tunggu']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-4">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-4">: <?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>								<label class="col-sm-3"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>							<label class="col-sm-3"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div><label class="col-sm-4">: <?php echo $row['nama_jj'];?> </label>								<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label>							<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-4">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-4">: <?php echo "$row[nama_sistem] ($row[deskripsi_sistem])";?></label>	<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label>							<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label></div>
<div><div class="col-sm-2">Jenis Pinjaman</div>	<label class="col-sm-4">: <?php echo "$row[nama_jpp] ($row[deskripsi_jpp])";?></label>			<label class="col-sm-3"><?php echo "$row[nama_jpp]";?></label>								<label class="col-sm-3"><?php echo "$row[nama_jpp]";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }else{ ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div>			<label class="col-sm-3 text-center fw-semi-bold">PROPOSAL</label>								<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-2 text-center fw-semi-bold">WAITING</label>				<label class="col-sm-2 text-center fw-semi-bold">PENCAIRAN</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-3">: <?php echo "$row[id]";?></label>										<label class="col-sm-3"><?php echo "$row[id]";?></label>									<label class="col-sm-2"><?php echo "$row[id]";?></label>						<label class="col-sm-2"><?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-3">: <?php echo tgl_ind($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_ind($row['tgl_verifikasi']);?></label>				<label class="col-sm-2"><?php echo tgl_ind($row['tgl_tunggu']);?></label>		<label class="col-sm-2"><?php echo tgl_ind($row['tgl_cair']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-3">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label>	<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-3">: <?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>								<label class="col-sm-3"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>							<label class="col-sm-2"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label>				<label class="col-sm-2"><?php echo number_format($row['pros_jasa']/$row['jangka'],2);?> %</label></div>
<div><div class="col-sm-2">Jenis Jasa</div>		<label class="col-sm-3">: <?php echo $row['nama_jj'];?> </label>										<label class="col-sm-3"><?php echo $row['nama_jj'];?> </label>							<label class="col-sm-2"><?php echo $row['nama_jj'];?> </label>				<label class="col-sm-2"><?php echo $row['nama_jj'];?> </label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-3">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label>				<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Sistem Angsuran</div><label class="col-sm-3">: <?php echo "$row[nama_sistem]";?></label>								<label class="col-sm-3"><?php echo "$row[nama_sistem]";?></label>							<label class="col-sm-2"><?php echo "$row[nama_sistem]";?></label>				<label class="col-sm-2"><?php echo "$row[nama_sistem]";?></label></div>
<div><div class="col-sm-2">Jenis Pinjaman</div>	<label class="col-sm-3">: <?php echo "$row[nama_jpp]";?></label>								<label class="col-sm-3"><?php echo "$row[nama_jpp]";?></label>								<label class="col-sm-2"><?php echo "$row[nama_jpp]";?></label>					<label class="col-sm-2"><?php echo "$row[nama_jpp]";?></label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>
<?php } ?>