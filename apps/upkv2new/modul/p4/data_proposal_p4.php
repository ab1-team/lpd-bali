<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_thumb.php";
$id	= $_SESSION['idprop'];
$row=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab]
																WHERE id='$id'"));	 

$tgl_proposal		=$row['tgl_proposal'];
$proposal			=$row['proposal'];
$tgl_verifikasi		=$row['tgl_verifikasi'];
$alokasi			=$row['alokasi'];
$pros_jasa			=$row['pros_jasa'];
$jangka				=$row['jangka'];
$tgl_now			=date('Y-m-d');	
$catatan_verifikasik	=$row['catatan_verifikasi'];		

	
if($row['status']=='P') { ?>

<script type="text/javascript">
			
	$(document).ready(function() {
					
	
	
	$("#GoVerifiedTernak").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var tgl_verifikasi		= $('#tgl_verifikasi').val();
		var alokasi				= $('#alokasi').val();
		var pros_jasa			= $('#pros_jasa').val();
		var jangka				= $('#jangka').val();
		var catatan_verifikasi	= $('#catatan_verifikasi').val();

		var pilih = confirm('Anda menentukan pinjaman dengan Alokasi '+alokasi+ '?');
			if (pilih==true) {			
				$.ajax({
				type: "POST",
				url: "modul/p4/simpan_verifikasi_p4.php",
				data: 	"id_pinj="+id_pinj+
						"&tgl_verifikasi="+tgl_verifikasi+
						"&alokasi="+alokasi+
						"&pros_jasa="+pros_jasa+
						"&jangka="+jangka+
						"&catatan_verifikasi="+catatan_verifikasi,
				success: function(data) {
					$("#Berhasil").load('modul/p4/sukses.php');
				}
				});
			}
		});
	
	});	

</script>

<?php
						
						//INPUT PROPOSAL KELOMPOK
						echo "						
										<div class='col-md-8'>
											<span class='fw-semi-bold'>FORM INPUT HASIL VERIFIKASI P4</span>
											<table width='100%' class='table table-hover'>
												<tr class='bg-body'>
												  <th width='20%'>Loan ID. $id </th>
											      <th width='20%'>Tanggal</th>
											      <th width='20%'>Alokasi</th>
											      <th width='10%'>Jasa</th>
										          <th width='10%'>Jangka</th>
												</tr>
												<tr>
												  <th  height='100px'>Data Proposal</th>
												  <td>$tgl_proposal</td>
												  <td>".number_format($proposal)."</td>
												  <td>$pros_jasa %</td>
												  <td>$jangka kali</td>
												</tr>
												<tr>
												  <th  height='100px'>Data Verifikasi<span class='fs-sm'><br>(Masukkan hasil Verifikasi Anda dibaris ini)</span></th>
												  <input type='hidden' name='id_pinj' id='id_pinj' value='$id'/>
												  <td><input type='text' name='tgl_verifikasi' id='tgl_verifikasi' class='form-control input text-align-center'
														value='$tgl_now' required='required' autocomplete='off' placeholder='Tanggal Verifikasi'></td>
												  <td><input type='text' name='alokasi' id='alokasi' class='form-control input text-align-center'
														value='$alokasi' required='required' autocomplete='off' placeholder='Rekomendasi Pinjaman'></td>
												  <td><input type='text' name='pros_jasa' id='pros_jasa' class='form-control input text-align-center'
														value='$pros_jasa' required='required' autocomplete='off' placeholder='Prosentase Jasa'></td>
												  <td><input type='text' name='jangka' id='jangka' class='form-control input text-align-center'
														value='$jangka' required='required' autocomplete='off' placeholder='Jangka Waktu'></td>
												</tr>
											</table>
											<p class='fs-sm text-justify mt-n-sm'>
											<span class='fw-semi-bold'> Verified Sign:</span><br>
													Dengan menekan tombol 'VERIFIKASI' dengan ini Verifikator $row[nama_lembaga_sort] Kecamatan $row[nama_kec] menyatakan dengan sebenar-benarnya dengan mendasar pada hasil survey 
													lapangan bahwa pemanfaat dengan identitas tersebut diatas ADA keberadaannya dan dapat dipertanggungjawabkan sesuai dengan peraturan yang 
													berlaku. Serta LAYAK untuk diberikan modal sesuai dengan hasil rekomendari Verifikasi diatas.
											</p>
										</div>
										<div class='col-md-4'>
											<div class='form-group'>
												<i class='fa fa-pencil'></i> Catatan Verifikasi :
												<textarea rows='10' class='form-control' value='$catatan_verifikasik' name='catatan_verifikasi' id='catatan_verifikasi' placeholder='Catatan Verifikasi untuk $row[namadepan]'></textarea>
											</div>
											<div class='text-center'>
												<div id='Berhasil'></div>
												<button href='' type='button' class='btn btn-danger btn-rounded width-200 mt-md' id='GoVerifiedTernak'><i class='fa fa-check'></i> VERIFIKASI</button>
											</div>
										</div>
										";
						 ?>

<?php }elseif($row['status']=='V') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-5 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-5 text-center fw-semi-bold">VERIFIKASI</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-5">: <?php echo "$row[id]";?></label>										<label class="col-sm-5"><?php echo "$row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-5">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-5"><?php echo tgl_indo($row['tgl_verifikasi']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-5">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-5"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-5">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-5"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-5">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-5"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }elseif($row['status']=='W') { ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div><label class="col-sm-4 text-center fw-semi-bold">PROPOSAL</label>										<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-3 text-center fw-semi-bold">WAITING</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-4">: <?php echo "$row[id]";?></label>										<label class="col-sm-3"><?php echo "$row[id]";?></label>									<label class="col-sm-3"><?php echo "$row[kd_kelompok] - $row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-4">: <?php echo tgl_indo($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_indo($row['tgl_verifikasi']);?></label>				<label class="col-sm-3"><?php echo tgl_indo($row['tgl_tunggu']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-4">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-4">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label>							<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-4">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>

<?php }else{ ?>
<fieldset>
<div><div class="col-sm-2">&nbsp;</div>			<label class="col-sm-3 text-center fw-semi-bold">PROPOSAL</label>								<label class="col-sm-3 text-center fw-semi-bold">VERIFIKASI</label>							<label class="col-sm-2 text-center fw-semi-bold">WAITING</label>				<label class="col-sm-2 text-center fw-semi-bold">PENCAIRAN</label></div>
<div><div class="col-sm-2">Loan ID</div>		<label class="col-sm-3">: <?php echo "$row[id]";?></label>									<label class="col-sm-3"><?php echo "$row[id]";?></label>									<label class="col-sm-2"><?php echo "$row[kd_kelompok] - $row[id]";?></label>	<label class="col-sm-2"><?php echo "$row[kd_kelompok] - $row[id]";?></label></div>
<div><div class="col-sm-2">Tanggal</div>		<label class="col-sm-3">: <?php echo tgl_ind($row['tgl_proposal']);?></label>					<label class="col-sm-3"><?php echo tgl_ind($row['tgl_verifikasi']);?></label>				<label class="col-sm-2"><?php echo tgl_ind($row['tgl_tunggu']);?></label>		<label class="col-sm-2"><?php echo tgl_ind($row['tgl_cair']);?></label></div>
<div><div class="col-sm-2">Alokasi</div>		<label class="col-sm-3">: <?php echo number_format($row['proposal']);?></label>					<label class="col-sm-3"><?php echo number_format($row['alokasi']);?></label>				<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label>	<label class="col-sm-2"><?php echo number_format($row['alokasi']);?></label></div>
<div><div class="col-sm-2">Prosentase Jasa</div><label class="col-sm-3">: <?php echo $row['pros_jasa'];?> %</label>								<label class="col-sm-3"><?php echo $row['pros_jasa'];?> %</label>							<label class="col-sm-2"><?php echo $row['pros_jasa'];?> %</label>				<label class="col-sm-2"><?php echo $row['pros_jasa'];?> %</label></div>
<div><div class="col-sm-2">Jangka</div>			<label class="col-sm-3">: <?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-3"><?php echo $row['jangka'];?> bulan</label>							<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label>				<label class="col-sm-2"><?php echo $row['jangka'];?> bulan</label></div>
<div><div class="col-sm-2">Catatan Verifikasi</div>	<div class="col-sm-10"><textarea class="form-control" disabled><?php echo "$row[catatan_verifikasi]";?></textarea></div></div>
</fieldset>
<?php } ?>