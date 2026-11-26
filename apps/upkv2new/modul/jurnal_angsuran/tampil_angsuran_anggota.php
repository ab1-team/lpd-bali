<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";

$id_pinj	=$_POST['id_pinj'];

$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_pinkel='$id_pinj'; ");
		$no=0;
$data=mysql_num_rows($view);
if($data>0) {		
?>
<div class="modal-body" style="overflow: scroll; height: 450px;">
<div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="widget-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="2%">#</th>
                                <th width="44%" colspan="2">Identitas Pemanfaat</th>
                                <th width="18%">Pokok</th>
                                <th width="18%">Jasa</th>
                                <th width="18%">Denda</th>
                            </tr>
                            </thead>
                            <tbody>
								<?php
		
			while($row=mysql_fetch_array($view)){
				$no=$no+1;
				
				$tgl_kondisi=date('Y-m-d');
				$idp		=$row['id'];
																						
	?>
	
                            <tr>
                                <td class="hidden-xs"><?php echo $no;?></td>
                                <td>
									<?php
										$foto=$row['foto'];
										if (empty($foto)) {
											echo "<img class='img-rounded' src='img/avatar.png' alt='...' height='50'>";
											}else{
											echo "<img class='img-rounded' alt='' src='$foto' height='50'>";
											}
										?>
                                </td>
                                <td>
                                    <strong><?php echo strtoupper($row['namadepan']);?></strong><br>
									<?php echo number_format($row['alokasi'],0,',','.');?>
                                </td>
                                <td><input name="pokoka<?php echo $idp;?>" id="pokoka<?php echo $idp;?>" value="<?php echo tungg_pokok_anggota("$tgl_kondisi-$idp");?>" type="text" class="form-control text-align-right" required="required" autocomplete="off" placeholder="Pokok"></td>
                                <td><input name="jasaa<?php echo $idp;?>" id="jasaa<?php echo $idp;?>" value="<?php echo tungg_jasa_anggota("$tgl_kondisi-$idp");?>" type="text" class="form-control text-align-right" required="required" autocomplete="off" placeholder="Jasa"></td>
                                <td><input name="dendaa" id="dendaa" value="0" type="text" class="form-control text-align-right" required="required" autocomplete="off" placeholder="Denda"></td>
                                <td><input name="idp<?php echo $idp;?>" id="idp<?php echo $idp;?>" value="<?php echo $idp;?>" type="hidden"></td>
                            </tr>
							
							
		<script type="text/javascript">
			$(document).ready(function() {

                $("#SimpanAngsuranAnggota").click(function() {
                    var idp 	= $('#idp<?php echo $idp;?>').val();
                    var pokoka 	= $('#pokoka<?php echo $idp;?>').val();
                    var jasaa 	= $('#jasaa<?php echo $idp;?>').val();

                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/simpan_angsuran_anggota.php",
                        data: "idp="+idp+
							  "&pokoka="+pokoka+
							  "&jasaa="+jasaa,
                        success: function(data) {
							//alert('Berhasil !');

                        }
                    });

                });
				
            });
        </script>
														
							
		<?php } ?>
		
                            </tbody>

                        </table>
                    </div>
                </section>
				<div class='alert alert-info fs-mini'>
				Untuk memenuhi data awal Angsuran Komulatif per Anggota silahkan masukkan pada form tersebut diatas, 
				data tersebut sementara tidak berkaitan dengan form angsuran kelompok sampai data angsuran per anggota balance dengan
				angsuran rekap kelompok, dan akan terus kami monitor dan evaluasi, untuk Pertanyaan silahkan hubungi Technical Support kami, Terimakasih.
				</div>
            </div>
        </div>
</div>
<div class="modal-footer bg-primary">
	<button class="btn btn-primary btn-block" id="SimpanAngsuranAnggota" data-dismiss="modal" aria-hidden="true">SIMPAN ANGSURAN ANGGOTA</button>
</div>
	
<?php
}else{
	echo "
	<div class='alert alert-info fs-mini'>
		DATA ANGGOTA PEMANFAAT PADA PINJAMAN INI BELUM DIINPUT, SILAHKAN DIINPUT TERLEBIH DAHULU MELALUI MENU 
		<B>UNIT DANA BERGULIR > KELOMPOK > PINJAMAN AKTIF</B>.
	</div>
	";
}
?>	
