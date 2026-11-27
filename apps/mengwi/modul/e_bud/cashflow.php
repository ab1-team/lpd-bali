<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];

$tahun_anggaran		="$_SESSION[tahunanggaran]";
?>

<script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
		window.open(theURL,winName,features);
			}
			
	$("#ControlRP").load('modul/e_bud/control_rp.php');
	$("#ControlRP1").load('modul/e_bud/control_rp.php');
	$("#ControlRB").load('modul/e_bud/control_rb.php');
	$("#ControlRB1").load('modul/e_bud/control_rb.php');
	$("#ControlSP").load('modul/e_bud/control_sp.php');
											
</script>
 
<legend class="h4"><strong> Perencanaan Cash Flow </strong>
</legend>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
		     <form method="POST" target='_blank' action='modul/pelaporan/p/SPB.php' id="cashflow" name="cashflow">
		         <table class="table table-hover">
					<tr>
						<th width="20%">Tanggal </th>
						<th align="center">: <input  id="tanggal" name="tanggal" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD"  /> (YYYY-MM-DD) </th>
						<th align="center">&nbsp;</th>
					</tr>
					<tr>
						<th width="20%">Cadangan Awal Bulan</th>
						<th align="center">: <input style="text-align:right;" id="cab" name="cab" type="text" value="0" align="right" />  </th>
						<th align="center">&nbsp;</th>
					</tr>
					<tr>
						<th width="20%">Cash On Hand </th>
						<th align="center">: <input style="text-align:right;" id="coh" name="coh" type="text" value="0"  /> </th>
						<th align="center">&nbsp;</th>
					</tr>
				</table>
              <br> 
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th width="50%">Rencana Biaya </th>
						<th align="center">Cash Flow</th>
						<th align="center">Diambil</th>
					</tr>
				</thead>
				<tbody>
				   
				<?php
				$view=mysql_query("select * from jenis_buku WHERE posisi='5' AND lokasi='0' OR posisi='5' AND lokasi='$_SESSION[lokasi]' ORDER by id ASC ");
					while($row=mysql_fetch_array($view)){
				$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE kd_jb='$row[kd_jb]' ORDER by kd_rekening ASC ");
					echo "
					<tr>
						<td colspan=3><strong>$row[nama_jb]</strong> </td></tr>";
						$no=0;
							while($r=mysql_fetch_array($data)){
								$no=$no+1;
								$urut="$r[kd_jb]$no";
								$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
									$angkarencana=$s['ra'];
									
									$kd_rekening=$r['kd_rekening'];
																							
							echo	"<tr><td>$r[kd_rekening]. $r[nama_rekening] </td>
										
	<td><input style='text-align:right;' type='text' id='baris$urut' name='baris$urut'  value='0' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></td>
	<td><input style='text-align:right;' type='text' id='baris2$urut' name='baris2$urut'  value='0' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></td>
	
		<input type='hidden' id='coba$urut' name='coba$urut' value='ini isi asfa efaecobacoba$urut' >
									</tr>";
																						
							?>
							<?php
							
							
							
							}
																					
						echo "<tr><td>ini tambahannya</td>
										<input type='hidden' id='tahun_anggaran$urut' name='tahun_anggaran$urut' value='$tahun_anggaran' > 
										<input type='hidden' id='kd_rekening$urut' name='kd_rekening$urut' value='$r[kd_rekening]' > 
										
	<td><input style= 'text-align:right;' type='text' id='baris$urut' name='baris$urut'  value='0' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></td>
	<td><input style= 'text-align:right;' type='text' id='baris2$urut' name='baris2$urut'  value='0' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></td>
	
		<input type='hidden' id='coba$urut' name='coba$urut' value='ini isi asfa efaecobacoba$urut' >
									</tr>
						</td>
					</tr> 
				";
				}
				?>
	
																	
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th></th><th colspan=2 align="center"><button  type="submit">Proses</button></th>
					</tr>
				</tfoot>
			</table>
				</form>	
	<!--		<form method="POST" action='modul/pinjaman/cp/CF.php' target='_blank'>-->
	<!--<input type="hidden" id="coba" name="coba" value="ini isi coba" > -->
 <!--               <button type="submit">Proses</button>-->
 <!--           </form>-->
		</div>
		
	</div>
	
</div>

