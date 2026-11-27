<?php session_start();
include "../../inc/inc.koneksi.php";
$maxp=mysql_fetch_array(mysql_query("select * from pola_angsuran_$_SESSION[kd_kab] WHERE user_id='$_SESSION[id]' order by id DESC limit 1"));
$maksidpola=$maxp['id'];
$_SESSION['id_pola']=$maxp['id'];
?>
<script type="text/javascript">
$(document).ready(function() {

	$("#checkbox1").click(function() {
		var id_pola		= <?php echo $maksidpola; ?>;
		var a1		= "1";
									
		$.ajax({
		type	: "POST",
		url		: "modul/pinjaman/simpan_edit_pola.php",
		data	: "id_pola="+id_pola+
					"&a1="+a1,
		});
	});
								
});
			
</script>
                <section class="widget widget-chart-changes bg-success-light">
                    <div class="widget-body">
                        <div class="chart bg-success btlr btrr">
                            <p class="text-white ml mt-n-xs"><strong>Pola Pembayaran</strong><span class="pull-right mr">Id.Pola: <?php echo $maksidpola;?></span></p>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-xs-2">
                                        <div class="checkbox checkbox-success">
                                            <input id="checkbox1" type="checkbox"><label for="checkbox1">1</label>
                                            <input id="checkbox2" type="checkbox"><label for="checkbox2">2</label>
                                            <input id="checkbox3" type="checkbox"><label for="checkbox3">3</label>
                                            <input id="checkbox4" type="checkbox"><label for="checkbox4">4</label>
                                        </div>
                                </div>
                                <div class="col-xs-2">
										<div class="checkbox checkbox-success">
                                            <input id="checkbox5" type="checkbox"><label for="checkbox5">5</label>
                                            <input id="checkbox6" type="checkbox"><label for="checkbox6">6</label>
                                            <input id="checkbox7" type="checkbox"><label for="checkbox7">7</label>
                                            <input id="checkbox8" type="checkbox"><label for="checkbox8">8</label>
                                        </div>
                                </div>
								<div class="col-xs-2">
										<div class="checkbox checkbox-success">
                                            <input id="checkbox9" type="checkbox"><label for="checkbox9">9</label>
                                            <input id="checkbox10" type="checkbox"><label for="checkbox10">10</label>
                                            <input id="checkbox11" type="checkbox"><label for="checkbox11">11</label>
                                            <input id="checkbox12" type="checkbox"><label for="checkbox12">12</label>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>