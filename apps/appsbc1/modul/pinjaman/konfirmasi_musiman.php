<script type="text/javascript">
$(document).ready(function() {

	$("#BuatPola").click(function() {
		var id		= "";
									
		$.ajax({
		type	: "POST",
		url		: "modul/pinjaman/simpan_pola.php",
		data	: "id="+id,
				
		success	: function(data) {
				$("#PolaBayar").load('modul/pinjaman/pola_pembayaran.php');
				}
		});
					
	});
								
});
			
</script>



                <section class="widget widget-chart-changes bg-success-light">
                    <div class="widget-body">
                        <div class="chart bg-success btlr btrr">
                            <p class="text-white ml mt-n-xs"><strong>Konfirmasi</strong></p>
                        </div>
                        <div class="text-align-center">
                            Apakah Anda yakin akan membuat<br>Pola Pembayaran Angsuran secara Musiman?<br><br>
							<button type="button" class="btn btn-success mb-lg" id="BuatPola">Ya, Buat Pola Angsuran Musiman</button>
                        </div>
                    </div>
                </section>