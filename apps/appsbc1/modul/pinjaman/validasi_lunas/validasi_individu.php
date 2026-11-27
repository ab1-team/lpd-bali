<?php session_start(); 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/fungsi_indotgl.php";
$id_pinj	=$_SESSION['id_pinkel'];
$row=mysql_fetch_array(mysql_query("select * from sebutan_desa sd, desa d, sistem_angsuran sa, 
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																sd.id=d.sebutan AND d.id=a.desa AND
																sa.id=pi.sistem_angsuran AND 
																a.id=pi.nia AND pi.id='$id_pinj'"));	
$tgl_now				=date('Y-m-d');
$tgl_cair				=tgl_indo($row['tgl_cair']);
$targetpokok=targetpokok("$tgl_now-$id_pinj");
$totpokok=sumpokok("$tgl_now-$id_pinj");
$targetjasa=targetjasa("$tgl_now-$id_pinj");
$totjasa=sumjasa("$tgl_now-$id_pinj");
$totdenda=sumdenda("$tgl_now-$id_pinj");
$saldopokok=saldopinjaman("$tgl_now-$id_pinj");
$saldojasa=saldo_jasa("$tgl_now-$id_pinj");
if($saldopokok<=0) {$ketpokok="Lunas";}else{$ketpokok="Saldo $saldopokok";}
if($saldojasa<=0) {$ketjasa="Lunas";}else{$ketjasa="Masih Ada Saldo Jasa Rp. ".number_format($saldojasa)." 
namun jika sesuai dengan SOP pinjaman tsb telah dinyatakan lunas, silahkan klik tombol Validasi Lunas";}
?>
<script type="text/javascript">
	
	$('#checkbox1').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {
						$('#ValidasiLunas').removeAttr('disabled'); //enable input
					} else {
						$('#ValidasiLunas').attr('disabled', true); //disable input
					}
				});
				
	function ValidasiLunas(ID) {
		var idp	= ID;
	   var pilih = confirm('Anda akan Validasi Lunas Loan ID. '+idp+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/pinjaman/validasi_lunas/simpan_validasi_individu.php",
				data	: "idp="+idp,
				success	: function(data){
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=vL_i&s=suksesVL';
				}
			});
		}
	}

</script>

<div class="alert alert-info animated fadeInDown">
<h3 class="fw-semi-bold">
	<img class='' alt='...' src='images/logo_bumdes.png' style='align:center; width:70px; margin-right:5px;'> 
	<i class="fa fa-gavel"></i> Validasi Pelunasan ID.<?php echo $id_pinj;?>
</h3>
<?php 
if ($_SESSION['level']==1 and $_SESSION['jabatan']==1) {$tombol="";}else {$tombol="disabled"; }
echo "
<p class='text-justify'>Dengan mempertimbangkan Standar Operasional Prosedur (SOP) yang berlaku di ".LEMBAGA_SORT." $row[sebutan_desa] $row[nama_desa] Kecamatan $row[nama_kec]
dan mengingat sumpah jabatan, dengan ini Kepala ".LEMBAGA_SORT." $row[sebutan_desa] $row[nama_desa], menyatakan dengan sebenar-benarnya
bahwa :
</p>
	<table>
		<tr>
			<td width='20%'>Nama Debitur </td>
			<td width='20%'>: ".strtoupper($row['namadepan'])."</td>
			<td width='20%'>Alokasi Pinjaman </td>
			<td width='20%'>: Rp. ".number_format($row['alokasi'])."</td>
			<td rowspan='4'><img src='images/lunas.png'/></td>
		</tr>
		<tr>
			<td>Alamat </td>
			<td>: $row[alamat]</td>
			<td>Jasa </td>
			<td>: $row[pros_jasa] %</td>
		</tr>
		<tr>
			<td>Desa</td>
			<td>: $row[nama_desa]</td>
			<td>Jangka Waktu </td>
			<td>: $row[jangka] kali</td>
		</tr>
		<tr>
			<td>Nomor HP</td>
			<td>: $row[hp]</td>
			<td>Sistem Angsuran </td>
			<td>: $row[nama_sistem]</td>
		</tr>
	</table>
												
<span class='fw-semi-bold'>REKAPITULASI</span>
	<table width='50%' class='table'>
		<tr class='bg-body'>
			<th>&nbsp;</th>
			<th>TARGET</th>
			<th>REALISASI</th>
			<th>SALDO</th>
			<th>KETERANGAN</th>
		</tr>
		<tr>
			<td>Pokok</td>
			<td>".number_format($targetpokok)."</</td>
			<td>".number_format($totpokok)."</</td>
			<td>".number_format($saldopokok)."</td>
			<td>$ketpokok</td>
		</tr>
		<tr>
			<td>Jasa</td>
			<td>".number_format($targetjasa)."</</td>
			<td>".number_format($totjasa)."</</td>
			<td>".number_format($saldojasa)."</td>
			<td>$ketjasa</td>
		</tr>
		<tr>
			<td colspan='5'></td>
		</tr>
	</table>
	
	<div class='checkbox checkbox-primary'>
		<input id='checkbox1' type='checkbox' $disabled>
		<label for='checkbox1'>
			Pinjaman tersebut diatas telah kami nyatakan LUNAS dan Surat Perjanjian Kredit (SPK) nomor $row[spk_no] tanggal $tgl_cair dinyatakan selesai beserta seluruh hak dan kewajibannya.
		&nbsp; &nbsp; 
		<a href=modul/pelaporan/pdf/p_PenarikanJaminan.php?&idp=$id_pinj target='_blank'><strong><i class='glyphicon glyphicon-print'></i> Cetak Surat Penarikan Jaminan </strong></a> 
		&nbsp; &nbsp;
		<a href=modul/pelaporan/pdf/c_vL_i.php?&idp=$id_pinj target='_blank'><strong><i class='glyphicon glyphicon-print'></i> Cetak Kuitansi Pelunasan </strong></a>
		</label>
	</div>
	<a href='javascript:ValidasiLunas(\"{$row[id]}\")' id='ValidasiLunas' class='btn btn-danger btn-lg btn-block' disabled><i class='fa fa-legal'></i> Validasi Lunas ! <i>(Kepala ".LEMBAGA_SORT." Only)</i></a>		
";
?>
								
</div>