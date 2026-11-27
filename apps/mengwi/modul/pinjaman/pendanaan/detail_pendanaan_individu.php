<?php session_start(); ?>

<script type="text/javascript">
			
	$(document).ready(function() {
					
	
	
	$("#GoVerifiedIndividu").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var tgl_dana	    	= $('#tgl_dana').val();
		var alokasi				= $('#alokasi').val();
		var pros_jasa			= $('#pros_jasa').val();
		var jangka				= $('#jangka').val();
		var sistem				= $('#sistem').val();
		var catatan_verifikasi	= $('#catatan_verifikasi').val();

		var pilih = confirm('Anda menentukan pinjaman dengan Alokasi '+alokasi+ '?');
			if (pilih==true) {			
				$.ajax({
				type: "POST",
				url: "modul/pinjaman/pendanaan/simpan_pendanaan_individu.php",
				data: 	"id_pinj="+id_pinj+
						"&tgl_dana="+tgl_dana+
						"&alokasi="+alokasi+
						"&pros_jasa="+pros_jasa+
						"&jangka="+jangka+
						"&sistem="+sistem+
						"&catatan_verifikasi="+catatan_verifikasi,
				success: function(data) {
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=V&s=ok';

				}
				});
			}
		});
	
	});	

</script>

<?php 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id	= $_POST['id'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, 
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																kc.id=a.lokasi AND d.id=a.desa AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND 
																a.id=pi.nia AND pi.id='$id'"));
																
$tgl_proposal		=$row['tgl_proposal'];
$proposal			=$row['proposal'];
$tgl_verifikasi		=$row['tgl_verifikasi'];
$alokasi			=$row['alokasi'];
$pros_jasa			=$row['pros_jasa'];
$jangka				=$row['jangka'];
$sistem_angsuran	=$row['nama_sistem'];
$tgl_now			=date('Y-m-d');	
$catatan_verifikasik	=$row['catatan_verifikasi'];															
?>
<div class="animated fadeInDown">
<section class="widget">
 <div class="widget-body">
<legend>
	<h4 class="page-title"><span class="fw-semi-bold"> <?php echo strtoupper($row['namadepan']);?></span> Loan ID. <?php echo "$row[id]";?>
	<span class="fw-semi-bold pull-right"><a href="#tabk12" data-toggle="tab"><i class="glyphicon glyphicon-arrow-left"></i> back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat] $row[nama_desa] Telp.$row[telpon]";?></p> 
</legend>	
		
	
						<?php
						
						//INPUT PROPOSAL KELOMPOK
echo "						
<div class='col-md-8'>
	<span class='fw-semi-bold'>FORM INPUT HASIL VERIFIKASI PINJAMAN INDIVIDU</span>
	<table width='100%' class='table table-hover'>
		<tr class='bg-body'>
		  <th width='20%'>Loan ID. $id </th>
		  <th width='20%'>Tanggal</th>
		  <th width='20%'>Alokasi</th>
		  <th width='10%'>Jasa</th>
		  <th width='10%'>Jangka</th>
		  <th width='15%'>Sistem</th>
		</tr>
		<tr>
		  <th >Data Proposal</th>
		  <td>$tgl_proposal</td>
		  <td>".number_format($proposal)."</td>
		  <td>$pros_jasa %</td>
		  <td>$jangka kali</td>
		  <td>$sistem_angsuran</td>
		</tr>
		<tr>
		  <th>Data Verifikasi</th>
		  <td>$tgl_verifikasi</td>
		  <td>".number_format($alokasi)."</td>
		  <td>$pros_jasa %</td>
		  <td>$jangka kali</td>
		  <td>$sistem_angsuran</td>
		</tr>
		<tr>
		  <th>Data Pendanaan</th>
		  <input type='hidden' name='id_pinj' id='id_pinj' value='$id'/>
		  <td><input type='text' name='tgl_dana' id='tgl_dana' class='form-control input text-align-center'
				value='$tgl_now' required='required' autocomplete='off' placeholder='Tanggal Pendanaan'></td>
		  <td><input type='text' name='alokasi' id='alokasi' class='form-control input text-align-center'
				value='$alokasi' required='required' autocomplete='off' placeholder='Rekomendasi Pinjaman'></td>
		  <td><input type='text' name='pros_jasa' id='pros_jasa' class='form-control input text-align-center'
				value='$pros_jasa' required='required' autocomplete='off' placeholder='Prosentase Jasa'></td>
		  <td><input type='text' name='jangka' id='jangka' class='form-control input text-align-center'
				value='$jangka' required='required' autocomplete='off' placeholder='Jangka Waktu'></td>
		  <td>
				<select id='sistem'  name='sistem'
					class='select form-control'
					tabindex='-1'> ";
					echo "<option value=$row[sistem_angsuran]>$row[nama_sistem]</option>";
							$datas=mysql_query('select * from sistem_angsuran'); 
								while($rows=mysql_fetch_array($datas)){
								echo "<option value=$rows[id]>$rows[nama_sistem]</option>";
								}
					echo "
				</select>
			</td>
		</tr>
	</table>
</div>
<div class='col-md-4'>
	<div class='form-group'>
		<i class='fa fa-pencil'></i> Catatan Verifikasi :
		<textarea rows='7' class='form-control' name='catatan_verifikasi' id='catatan_verifikasi' placeholder='Catatan Verifikasi untuk Kelompok $row[nama_kelompok]'>$catatan_verifikasik</textarea>
	</div>
	<div class='text-center'>
		<button href='' type='button' class='btn btn-danger btn-rounded width-200 mt-md' id='GoVerifiedIndividu'><i class='fa fa-check'></i> TETAPKAN DANA</button>
	</div>
</div>
";
?>
                        </tbody>
                    </table>
                </div>
            
        
</div>
</section>
</div>



