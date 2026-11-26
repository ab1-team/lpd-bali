<?php session_start(); 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../inc/fungsi_indotgl.php";
$id_pinj	=$_SESSION['id_pinkel'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, 
													kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=pk.jenis_pp AND
																sa.id=pk.sistem_angsuran AND 
																k.id=pk.id_kel AND pk.id='$id_pinj'"));	
$tgl_now				=date('Y-m-d');
$tgl_cair				=tgl_indo($row['tgl_cair']);
$targetpokok=targetpokok("$tgl_now-$id_pinj");
$totpokok=sumpokok("$tgl_now-$id_pinj");
$targetjasa=targetjasa("$tgl_now-$id_pinj");
$totjasa=sumjasa("$tgl_now-$id_pinj");
$totdenda=sumdenda("$tgl_now-$id_pinj");
$saldopokok=$targetpokok-$totpokok;
$saldojasa=$targetjasa-$totjasa;
if($saldopokok<=0) {$ketpokok="Lunas";}else{$ketpokok="Saldo $saldopokok";}
if($saldojasa<=0) {$ketjasa="Lunas";}else{$ketjasa="Masih Ada Saldo Jasa Rp. ".number_format($saldojasa)." 
namun jika sesuai dengan SOP pinjaman tsb telah dinyatakan lunas, silahkan klik tombol Validasi Lunas";}
?>
<script type="text/javascript">

	function ValidasiLunas(ID) {
		var idp	= ID;
	   var pilih = confirm('Anda akan Validasi Lunas Loan ID. '+idp+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/pinjaman/validasi_lunas/simpan_validasi.php",
				data	: "idp="+idp,
				success	: function(data){
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=vL&s=suksesVL';
				}
			});
		}
	}

</script>

<div class="alert alert-info animated fadeInDown">
<h3 class="fw-semi-bold"><i class="fa fa-gavel"></i> Validasi Pelunasan ID.<?php echo $id_pinj;?></h3>
<?php 
if ($_SESSION['level']==1 and $_SESSION['jabatan']==1) {$tombol="";}else {$tombol="disabled"; }
echo "
<p class='text-justify'>Dengan mempertimbangkan Standar Operasional Prosedur (SOP) yang berlaku di  $row[nama_lembaga_sort] Kecamatan $row[nama_kec]
dan mengingat sumpah jabatan, dengan ini Ketua $row[nama_lembaga_sort] Kecamatan $row[nama_kec] selaku manajer, menyatakan dengan sebenar-benarnya
bahwa :
</p>
	<table>
		<tr>
			<td width='15%'>Nama Kelompok </td>
			<td width='15%'>: ".strtoupper($row['nama_kelompok'])."</td>
			<td width='15%'>Alokasi Pinjaman </td>
			<td width='15%'>: Rp. ".number_format($row['alokasi'])."</td>
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
			<td>Jenis Pinjaman</td>
			<td>: $row[nama_jpp]</td>
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
			<td colspan='2'><img src='images/lunas.png'/></td>
			<td colspan='3'>
			<p>Pinjaman tersebut diatas telah kami nyatakan LUNAS dan Surat Perjanjian Kredit (SPK) nomor $row[spk_no] tanggal $tgl_cair dinyatakan selesai beserta seluruh hak dan kewajibannya.</p>
			<a href='javascript:ValidasiLunas(\"{$row[id]}\")' class='btn btn-danger btn-rounded width-300 $tombol'><i class='fa fa-legal'></i> Validasi Lunas ! <i>(Ketua Only)</i></a>
			</td>
		</tr>
	</table>
";
?>
								
</div>