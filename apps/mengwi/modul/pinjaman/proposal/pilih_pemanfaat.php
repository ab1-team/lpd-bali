<?php session_start();
include "../../../inc/inc.koneksi.php"; 

$id_pinj=$_POST['cari'];
$r=mysql_fetch_array(mysql_query("select * from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
					WHERE k.id=pk.id_kel AND pk.id='$id_pinj' "));
?>


<script type="text/javascript">
	$(document).ready(function() {

				$("#alokasi_anggota").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});

					
					
					$("#alokasi_anggota").keyup(function(){
						var nia = $("#nia").val();
						var id_pinkel = $("#id_pinkel").val();

						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/cek_pemanfaat.php",
							data	: "nia="+nia+
								"&id_pinkel="+id_pinkel,
							success	: function(data){
								$("#cek_pemanfaat").html(data);
								
							}
						});
					});
					
					
	
	//SIMPAN ALOKASI ANGGOTA				
				 $("#SimpanAlokasiAnggotaProp").click(function() {
                    var id_kel			= $('#id_kel').val();
                    var id_pinkel		= $('#id_pinkel').val();
                    var nia				= $('#nia').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var alokasi_anggota	= $('#alokasi_anggota').val();
					var nomer			= /^[0-9]+$/;
					
					if(nia.length==0){ $("#nia").focus(); return false; }
					if(alokasi_anggota.length==0){ $("#alokasi_anggota").focus(); return false; }
					if(!nia.match(nomer)){ $("#nia").focus(); return false; }
						
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/register/simpan_proposal_a.php",
                        data: 	"id_kel="+id_kel+
								"&id_pinkel="+id_pinkel+
								"&nia="+nia+
								"&jenis_pp="+jenis_pp+
								"&alokasi_anggota="+alokasi_anggota,
                        
						success: function(data) {
                            $("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');

                        }
                    });

                });

					
		});
</script>

<div class="form-group">
	<div class="col-sm-7">
		<label>Cari NIK/Nama Pemanfaat:</label>
		<div class="input-group input-group-transparent">
			<span class="input-group-addon">
                <i class="glyphicon glyphicon-search"></i> <i class="glyphicon glyphicon-user"></i>
            </span>
			<input list="calonpemanfaat" name="nia" id="nia" class="select2 form-control" data-placeholder="Pilih nama calon pemanfaat">
			<datalist id="calonpemanfaat" name="calonpemanfaat">
			  <?php														
					$view=mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE lokasi='$_SESSION[lokasi]' and desa='$r[desa]' order by namadepan ASC "); //ANGGOTA
					while($row=mysql_fetch_array($view)){
					echo "<option value='$row[id]'>$row[nik] - $row[namadepan] - $row[alamat]</option>";
					}
				?>
			</datalist>
			</input>
		</div>
	</div>
	<div class="col-sm-5">
		<label>Alokasi Pengajuan:</label>
		<div class="input-group">
        <input type="text" class="form-control" name="alokasi_anggota" id="alokasi_anggota" required="required" autocomplete="off" placeholder="Masukkan Alokasi untuk calon Pemanfaat"/>
        <input type="hidden" name="id_kel" id="id_kel" value="<?php echo $r['id_kel'];?>"/>
        <input type="hidden" name="id_pinkel" id="id_pinkel" value="<?php echo $r['id'];?>"/>
        <input type="hidden" name="jenis_pp" id="jenis_pp" value="<?php echo $r['jenis_pp'];?>"/>
		
			<span class="input-group-btn">
                <button type="button" class="btn btn-primary" id="SimpanAlokasiAnggotaProp"><i class="fa fa-plus"></i></button>
            </span>
		</div>

	</div>
</div>
<div class="form-group">
<div class="col-sm-12">
	<div id="cek_pemanfaat"></div>
	<div class="alert alert-success fs-mini">
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
		<i class="glyphicon glyphicon-info-sign"></i> <strong>Petunjuk!</strong><br>
		Setelah dipilih salah satu pemanfaat, akan muncul digit angka yang merupakan ID Pemanfaat, kemudian masukkan alokasi dan klik tombol <i class="fa fa-plus"></i>.
	</div>
</div>
</div>