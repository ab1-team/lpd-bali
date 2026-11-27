<?php session_start();
include "../../../inc/inc.koneksi.php"; 

$id_pinj=$_POST['cari'];
$r=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
					WHERE jpp.id=pk.jenis_pp AND pk.id='$id_pinj' "));
$kunci_alokasi =$r['alokasi'];
?>

<script type="text/javascript">
	$("#GoCairkan").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var jenis_pp			= $('#jenis_pp').val();
		var tgl_cair			= $('#tgl_cair').val();
		var alokasi				= $('#alokasi').val();
		var sumber				= $('#sumber').val();
		var metode				= $('#metode').val();
		var kunci_alokasi		= <?php echo $kunci_alokasi;?>
		
		if(alokasi.length==0){ alert('Alokasi tidak boleh kosong!'); $("#alokasi").focus(); return false; }
		if(alokasi<=0){ alert('Alokasi tidak boleh NOL!'); $("#alokasi").focus(); return false; }
		if(alokasi>kunci_alokasi){ alert('Maaf Alokasi tidak boleh melebihi Hasil rekomendasi Verifikasi!'); $("#alokasi").focus(); return false; }
							
		var pilih = confirm('Tgl Cair '+tgl_cair+ ', dan Alokasi '+alokasi+ '?');
		if (pilih==true) {			
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/waiting/simpan_cair.php",
				data: 	"id_pinj="+id_pinj+
						"&jenis_pp="+jenis_pp+
						"&tgl_cair="+tgl_cair+
						"&alokasi="+alokasi+
						"&sumber="+sumber+
						"&metode="+metode,
				success: function(data) {
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=W&s=suksesC';
				}
			});
		}
	});														
</script>

<div class="row">
	<div class="col-xs-4">
		<div class="form-group">
			Tanggal Pencairan
			<input type="text" class="form-control" name="tgl_cair" id="tgl_cair" value="<?php echo $r['tgl_cair'];?>"
			required="required" autocomplete="off" placeholder="Tanggal Pencairan"/>
		</div>
		<div class="form-group">
			Alokasi (Rp.)
			<input type="text" class="form-control" name="alokasi" id="alokasi" value="<?php echo $r['alokasi'];?>"
			required="required" autocomplete="off" placeholder="Alokasi Kelompok"/>
		</div>
	</div>
	<div class="col-xs-4">
		<div class="form-group">
		Metode Pembayaran
			<select data-placeholder="Metode Pembayaran"
				data-width="auto"
				data-minimum-results-for-search="10"
				tabindex="-1"
				class="select2 form-control" id="metode" name="metode">
				<option value="K">Kredit dari Kas <?php echo $r['nama_jpp'];?></option>";
				<option value="B">Transfer dari Bank <?php echo $r['nama_jpp'];?></option>";
			</select>
		</div>
		<div class="form-group">
			Sumber Dana
			<select data-placeholder="Sumber Dana"
			data-width="auto"
			data-minimum-results-for-search="10"
			tabindex="-1"
			class="select2 form-control" id="sumber" name="sumber">
				<?php
					$dsd=mysql_query("SELECT * FROM sumber_dana");
					while($sd=mysql_fetch_array($dsd)){
					echo "<option value='$sd[id]'>$sd[nama_sumber]</option>";
					}
				?>
			</select>
			<input type="hidden" name="id_pinj" id="id_pinj" value="<?php echo $r['id'];?>"/>
			<input type="hidden" name="jenis_pp" id="jenis_pp" value="<?php echo $r['jenis_pp'];?>"/>
		</div>
	</div>
	<div class="col-xs-4">
		<div class="text-center">
			<p class="fs-mini text-muted mt-sm pull-left">Cek Data Pencairan sebelum klik tombol Cairkan, data akan otomatis masuk ke jurnal transaksi</p>
			<button type="button" class="btn btn-danger width-200" id="GoCairkan"><i class="fa fa-money"></i> Cairkan</button>
		</div>
	</div>
</div>
<hr>