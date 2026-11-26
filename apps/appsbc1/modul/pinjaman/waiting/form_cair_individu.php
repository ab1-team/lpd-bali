<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_keuangan.php";

$id_pinj=$_SESSION['id_pinj'];
$r=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
$kunci_alokasi 		=$r['alokasi'];
$dpr				=explode("#", $r['data_proposal']);
$pros_by_admin		=$dpr[8];
	$mtr	= explode("#", $r['materai']);
	$materai = $mtr[0];
	$jum_materai = $mtr[1];
$biaya_administrasi	=$kunci_alokasi*$pros_by_admin/100;
$biaya_materai		=($materai+1000)*$jum_materai;
$totalterima		=$kunci_alokasi-$biaya_administrasi-$biaya_materai;
?>

<div class="row">
	<div class="col-xs-4">
		<div class="form-group">
			<label class="fs-sm">Tanggal Pencairan</label>
			<input type="text" class="form-control" name="tgl_cair" id="tgl_cair" value="<?php echo $r['tgl_cair'];?>"
			required="required" autocomplete="off" placeholder="Tanggal Pencairan"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Jumlah Alokasi (Rp.)</label>
			<input type="text" class="form-control" name="alokasi" id="alokasi" value="<?php echo number_format($kunci_alokasi,0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this), changeData(this.value);"
			required="required" autocomplete="off" placeholder="Jumlah Alokasi"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Biaya Administrasi (Rp.)</label>
			<input type="text" class="form-control" name="biaya_administrasi" id="biaya_administrasi" value="<?php echo number_format($biaya_administrasi,0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" placeholder="Biaya Administrasi (Rp.)"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Biaya Materai (Rp.)</label>
			<input type="text" class="form-control" name="biaya_materai" id="biaya_materai" value="<?php echo number_format($biaya_materai,0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" placeholder="Biaya Materai (Rp.)"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Biaya Lainnya (Rp.)</label>
			<input type="text" class="form-control" name="biaya_lainnya" id="biaya_lainnya" value="0" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" placeholder="Biaya Lainnya (Rp.)"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Kas Materai (Rp.)</label>
			<input type="text" class="form-control" name="kas_materai" id="kas_materai" value="<?php echo number_format($materai*(intval($biaya_materai/$materai)),0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" disabled="disabled"/>
			<input type="hidden" class="form-control" name="materai2" id="materai2" value="<?php echo number_format($materai,0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" disabled="disabled"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Pendapatan Materai (Rp.)</label>
			<input type="text" class="form-control" name="pendapatan_materai" id="pendapatan_materai" value="<?php echo number_format($biaya_materai % $materai,0,",",".");?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeData(this.value);"
			required="required" autocomplete="off" disabled="disabled"/>
		</div>
	</div>
	<div class="col-xs-4">
		<div class="form-group">
			<label class="fs-sm">Total Penerimaan (Rp.)</label>
			<input type="text" class="form-control" name="total_penerimaan" id="total_penerimaan" value="<?php echo number_format($totalterima,0,",",".");?>"  disabled
			required="required" autocomplete="off" placeholder="Total Penerimaan (Rp.)"/>
		</div>
		<div class="form-group">
			<label class="fs-sm">Metode Pembayaran</label>
			<div>
				<div class="col-xs-4">
					<div class="radio radio-primary">
						<input type="radio" name="radio1" id="radio1" value="option1">
						<label for="radio1">Tunai</label>
					</div>
				</div>
				<div class="col-xs-8">
					<div class="radio radio-primary">
						<input type="radio" name="radio1" id="radio2" value="option2">
						<label for="radio2">Transfer ke Tabungan</label>
					</div>
				</div>
			</div>
			
				<select data-placeholder="Nomor Rekening"
				data-width="auto"
				data-minimum-results-for-search="10"
				tabindex="-1"
				class="select2 form-control" id="nomor_rekening" name="nomor_rekening" disabled>
				<option value="">-- Pilih Rekening Tujuan --</option>
					<?php
						$sa=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa WHERE a.id=sa.nia AND sa.jenis_simpanan='1' AND sa.nia='$r[nia]' ");
						while($rek=mysql_fetch_array($sa)){
						echo "<option value='$rek[id]'>$rek[nomor_rekening] - ".strtoupper($rek['namadepan'])."</option>";
						}
					?>
				</select>
				<input type="hidden" name="id_pinj" id="id_pinj" value="<?php echo $r['id'];?>"/>
				<input type="hidden" name="metode_bayar" id="metode_bayar" value="" >
				<p class="fs-mini text-success mt-sm pull-left">Saldo Kas Rp. <?php $tgl_kondisi=date('Y-m-d'); echo number_format(saldoR("$tgl_kondisi-1-10001"),0,',','.');?></p>
			</div>
		<div class="text-center">
			<p class="fs-mini text-muted mt-sm pull-left">Cek Data Pencairan sebelum klik tombol Cairkan, data akan otomatis masuk ke jurnal transaksi</p>
			<button type="button" class="btn btn-danger btn-block btn-lg"  id="GoCairkanIndividu" disabled>CAIRKAN <span id="MetodeBayar"></span></button>
		</div>
	</div>
</div>


<script type="text/javascript">

function changeData(id) {
	var alokasi = document.getElementById("alokasi").value.split('.').join('');
	var biaya_administrasi = document.getElementById("biaya_administrasi").value.split('.').join('');
	var biaya_materai = document.getElementById("biaya_materai").value.split('.').join('');
	var materai2 = document.getElementById("materai2").value.split('.').join('');
	var biaya_lainnya = document.getElementById("biaya_lainnya").value.split('.').join('');
	if(alokasi.length==0){ alokasiv="0"; }else{ alokasiv=alokasi; }
	if(biaya_administrasi.length==0){ biayaadministrasi="0"; }else{ biayaadministrasi=biaya_administrasi; }
	if(biaya_materai.length==0){ biayamaterai="0"; }else{ biayamaterai=biaya_materai; }
	if(biaya_lainnya.length==0){ biayalainnya="0"; }else{ biayalainnya=biaya_lainnya; }
	var totalpenerimaan= eval(alokasiv) - eval(biayaadministrasi) - eval(biayamaterai) - eval(biayalainnya);
	document.getElementById("total_penerimaan").value=tandaPemisahTitik(totalpenerimaan);

	var pendmaterai= eval(biaya_materai) % materai2;
	document.getElementById("pendapatan_materai").value=tandaPemisahTitik(pendmaterai);
	
	var kasmaterai= eval(biaya_materai) - eval(pendmaterai);
	document.getElementById("kas_materai").value=tandaPemisahTitik(kasmaterai);
}

												
$(document).ready(function() {
	

	$('#radio1').click(function () {
					//check if checkbox is checked
		if ($(this).is(':checked')) {
			$('#nomor_rekening').attr('disabled', true); //enable input
			$('#GoCairkanIndividu').removeAttr('disabled'); //enable input
			$('#metode_bayar').val('tunai');
			$('#MetodeBayar').html("(TUNAI)");
		} else {
			$('#nomor_rekening').removeAttr('disabled'); //disable input
		}
	});
	
	$('#radio2').click(function () {
		if ($(this).is(':checked')) {
			$('#nomor_rekening').removeAttr('disabled'); //enable input
			$('#GoCairkanIndividu').removeAttr('disabled'); //enable input
			$('#metode_bayar').val('transfer');
			$('#MetodeBayar').html("(TRANSFER)");
		} else {
			$('#nomor_rekening').attr('disabled', true); //disable input
		}
	});
				
	$("#GoCairkanIndividu").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var tgl_cair			= $('#tgl_cair').val();
		var alokasi				= $('#alokasi').val();
		var biaya_administrasi	= $('#biaya_administrasi').val();
		var biaya_materai		= $('#biaya_materai').val();
		var kas_materai			= $('#kas_materai').val();
		var pendapatan_materai	= $('#pendapatan_materai').val();
		var biaya_lainnya		= $('#biaya_lainnya').val();
		var total_penerimaan	= $('#total_penerimaan').val();
		var metode_bayar		= $('#metode_bayar').val();
		var nomor_rekening		= $('#nomor_rekening').val();
		var kunci_alokasi		= <?php echo $kunci_alokasi;?>
		
		if(metode_bayar=="transfer" && nomor_rekening.length==0){ alert('Silahkan pilih Nomor Rekening Tujuan!'); $("#nomor_rekening").focus(); return false; }
		if(alokasi.length==0){ alert('Alokasi tidak boleh kosong!'); $("#alokasi").focus(); return false; }
		if(alokasi<=0){ alert('Alokasi tidak boleh NOL!'); $("#alokasi").focus(); return false; }
		if(alokasi>kunci_alokasi){ alert('Maaf Alokasi tidak boleh melebihi Hasil rekomendasi dan Verifikasi!'); $("#alokasi").focus(); return false; }
							
		var pilih = confirm('Tgl Cair '+tgl_cair+ ', dan Alokasi '+alokasi+ '?');
		if (pilih==true) {			
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/waiting/simpan_cair_individu.php",
				data: 	"id_pinj="+id_pinj+
						"&tgl_cair="+tgl_cair+
						"&alokasi="+alokasi+
						"&biaya_administrasi="+biaya_administrasi+
						"&biaya_materai="+biaya_materai+
						"&kas_materai="+kas_materai+
						"&pendapatan_materai="+pendapatan_materai+
						"&biaya_lainnya="+biaya_lainnya+
						"&total_penerimaan="+total_penerimaan+
						"&metode_bayar="+metode_bayar+
						"&nomor_rekening="+nomor_rekening,
				success: function(data) {
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=W&s=suksesC';
				}
			});
		}
	});	

});	
</script>