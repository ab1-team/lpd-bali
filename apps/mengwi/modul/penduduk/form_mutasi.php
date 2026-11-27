<?php session_start();
include "../../inc/inc.koneksi.php"; 
?>

<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=kecamatan>
  $("#kecamatan").change(function(){
    var kecamatan = $("#kecamatan").val();
    $.ajax({
        url: "modul/penduduk/ambilkec.php",
        data: "kecamatan="+kecamatan,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=jenis_buku>
            $("#desamut").html(msg);
        }
    });
  });
  
  
  $("#MutasiKan").click(function() {
                    var nik				= $('#nik').val();
                    var kecamatan				= $('#kecamatan').val();
                    var desamut				= $('#desamut').val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/penduduk/simpan_desamut.php",
                        data: 	"nik="+nik+
								"&kecamatan="+kecamatan+
								"&desamut="+desamut,
                        
						success: function(data) {
							$("#suksesmut").load('modul/penduduk/sukses_anggota.php');
							
                        }
                    });

                });
				
				
  
});




 ]]>

</script>  
  
<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div class='widget-top-overflow windget-padding-md clearfix bg-primary'>
                            <span class='h5 fw-bold'><i class='fa fa-refresh'></i> Mutasi Antar Kecamatan <span class='pull-right'><a class='text-white' data-toggle='collapse' data-parent='#accordionKelompok' href='#collapseKelompok'><i class='glyphicon glyphicon-remove'></i></a></span></span>
                        </div>
						
	<div class="row mt">
		<div class="col-xs-12">
		<div id="suksesmut"></div>
        <div class="col-md-8">
			<div class="form-group">
				Kecamatan
				<select data-placeholder="-- Pilih Kecamatan --"
					data-width="auto"
					data-minimum-results-for-search="10"
					tabindex="-1"
					class="select2 form-control" id="kecamatan" name="kecamatan">
					<?php
						echo "<option>-- Pilih Kecamatan --</option>";
						$kec=mysql_query("SELECT * FROM kecamatan WHERE kd_kab=$_SESSION[kd_kab] "); //
						while($c=mysql_fetch_array($kec)){
						echo "<option value='$c[id]'>$c[nama_kec]</option>";
						}
					?>
				</select>
			</div>
			<div class="form-group">
				Desa
				<select id="desamut"  name="desamut"
                                                data-placeholder="-- Pilih Desa --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
										</select>
				<input type="hidden" name="nik"  maxlength="16" class="form-control input-lg" id="nik" value="<?php echo $_POST['cari'];?>" >
			</div>
			
			</div>
		<div class="col-md-4">
			<div class="form-group">
			&nbsp;
			<div class="text-center">
				<button type="button" class="btn btn-danger width-100" id="MutasiKan"><h3><i class="fa fa-refresh"></i></h3>LAKUKAN<br>MUTASI</button>
			</div>
			</div>
		</div>
</div>
</div>
<hr>
</div>
</section>
