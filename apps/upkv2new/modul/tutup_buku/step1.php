<script type="text/javascript">
			$(document).ready(function() {

                $("#TutupBuku").click(function() {
                    var tahun = $('#tahun').val();
					
						if(tahun.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); $("#tahun").focus(); return false; }

                    $.ajax({
                        type: "POST",
                        url: "modul/tutup_buku/insert_kolom.php",
                        data: "tahun="+tahun,
                        success: function(data) {
							$("#TampilStep").load('modul/tutup_buku/step2.php');
                        }
                    });

                });
				
            });
        </script>
		
<legend class="h4"><strong> Step 1 :</strong>  Tentukan Tahun Buku</legend>
<div class="row">
	<div class="col-sm-4">
		<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control input-lg" id="tahun" name="tahun" value="<?php echo date('Y'); ?>" 
					required="required" autocomplete="off" placeholder="Tahun Tutup Buku">
				<span class="input-group-btn">
					<button type="button" class="btn btn-info input-lg" id="TutupBuku"><i class="glyphicon glyphicon-book text-white"></i> Lanjutkan Tutup Buku</button>
				</span>
			</div>
			<div class='alert alert-danger mt animated fadeInDown'>
			<strong>PENGINGAT</strong><br>
			Tutup buku <b>hanya</b> diperbolehkan di akses di <b>tahun ke-2</b> pemakaian SIUPK online. Melakukan tutup buku di tahun pertama pemakaian dapat menyebabkan <b>data keuangan <i>error</i></b>. Jika anda yakin, silakan tekan tombol lanjut
		</div>
			<div id="Dilarang"></div>
		</div>
	</div>
</div>

<div class="alert alert-info animated fadeInDown">
	<legend><strong>Perhatian</strong></legend>
	<ol>
		<li>Untuk melakukan tutup buku tahunan isilah angka tahun tutup buku sesuai dengan tahun buku, kemudian klik Tombol Tutup Buku</li>
		<li>Anda dapat mengisi data tutup buku pada tahun berikutnya, dengan cara merubah angka tahunnya</li>
		<li>Anda dapat merubah data tutup buku dilain waktu jika Anda anggap belum sesuai</li>
		<li>Tombol Tutup Buku akan berfungsi setelah memasuki bulan Desember</li>
		<li>Untuk tutup buku Harian dan Tutup Buku Bulanan telah dilakukan otomatis oleh sistem, </li>
		<li>Tutup buku Harian dilakukan otomatis setiap hari Pukul 24.00 Waktu Server</li>
		<li>Tutup Buku Bulanan dilakukan otomatis setiap tanggal <b><?php echo $tgl_close;?></b> dibulan bersangkutan pada pukul 24.00 Waktu Server </li>
	</ol>
</div>