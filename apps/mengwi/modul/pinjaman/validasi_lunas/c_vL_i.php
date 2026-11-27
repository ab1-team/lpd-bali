<?php session_start(); 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/fungsi_indotgl.php";
$id_pinj	=$_SESSION['id_pinkel'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, 
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																kc.id=a.lokasi AND d.id=a.desa AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND 
																a.id=pi.nia AND pi.id='$id_pinj'"));	
$tgl_now				=date('Y-m-d');
$tgl_cair				=tgl_indo($row['tgl_cair']);
$r=mysql_fetch_array(mysql_query("SELECT * FROM users u, jabatan j WHERE lokasi='$_SESSION[lokasi]' AND u.jabatan=j.id"));
$jabatan = $r['nama_jabatan'];
$targetpokok=targetpokok("$tgl_now-$id_pinj");
$totpokok=sumpokok("$tgl_now-$id_pinj");
$targetjasa=targetjasa("$tgl_now-$id_pinj");
$totjasa=sumjasa("$tgl_now-$id_pinj");
$totdenda=sumdenda("$tgl_now-$id_pinj");
$ssaldopokok=$targetpokok-$totpokok;
$ssaldojasa=$targetjasa-$totjasa;
if($ssaldopokok<=0) {$ketpokok="Lunas"; $saldopokok="0";}else{$ketpokok="Saldo $ssaldopokok";$saldopokok=$targetpokok-$totpokok;}
if($ssaldojasa<=0) {$ketjasa="Lunas"; $saldojasa="0";}else{$ketjasa="Masih Ada Saldo Jasa Rp. ".number_format($ssaldojasa)." 
namun jika sesuai dengan SOP pinjaman tsb telah dinyatakan lunas, silahkan klik tombol Validasi Lunas"; $saldojasa=$targetjasa-$totjasa;}
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000; }
.bottom	{border-bottom: 1px solid #000; padding:0 0 5px 5px;}
.left	{border-left: 1px solid #000; }
.right	{border-right: 1px solid #000; }
.pull-right	{float: right; }
.style7{color: #000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;}
.ngisor	{border-bottom: 1px solid #000; padding:0 0 5px 5px;}
.style8 {background-color: #ec4606; color: #fff; padding: 5px;}
-->
</style>
<body onLoad="window.print()">

<table width="91%" border="0" align="center" cellpadding="3" cellspacing="0" class="top left right">
	<tr>
		<td class="style7">
			<h3 class="style6">Validasi Pelunasan ID.<?php echo $id_pinj;?></h3>

			<p class='text-justify'>Dengan mempertimbangkan Standar Operasional Prosedur (SOP) yang berlaku di  <?php echo $row['nama_lembaga_sort']; ?> Kecamatan <?php echo $row['nama_kec']; ?>
			dan mengingat sumpah jabatan, dengan ini Ketua <?php echo $row['nama_lembaga_sort']; ?> Kecamatan <?php echo $row['nama_kec'];?> selaku <?php if ($r['jabatan']=='1') { ?>
             <?php echo $row['sebutan_level_1']; ?>

             <?php }else if ($r['jabatan']=='2') { ?>
             <?php echo $row['sebutan_level_2']; ?>

             <?php }else if ($r['jabatan']=='3') { ?>
             <?php echo $row['sebutan_level_3']; ?>

             <?php }else{ ?>
              <?php echo $jabatan; ?>
             <?php } ?>, menyatakan dengan sebenar-benarnya
			bahwa :
			</p>
		</td>
	</tr>
</table>



	<table width="91%" border="0" align="center" cellpadding="3" cellspacing="0" class="style7 top left right">
		<tr>
			<td width='15%'>Nama Lengkap </td>
			<td width='15%'>: <?php echo strtoupper($row['namadepan']);?></td>
			<td width='15%' class="">Alokasi Pinjaman </td>
			<td width='15%'>: Rp. <?php echo number_format($row['alokasi']);?></td>
		</tr>
		<tr>
			<td>Alamat </td>
			<td>: <?php echo $row['alamat']; ?></td>
			<td>Jasa </td>
			<td>: <?php echo number_format($row['pros_jasa']/$row['jangka'],2); ?> %</td>
		</tr>
		<tr>
			<td>Desa</td>
			<td>: <?php echo $row['nama_desa']; ?></td>
			<td>Jangka Waktu </td>
			<td>: <?php echo $row['jangka']; ?> kali</td>
		</tr>
		<tr>
			<td>Jenis Pinjaman</td>
			<td>: <?php echo $row['nama_jpp'] ; ?></td> 
			<td>Sistem Angsuran </td>
			<td>: <?php echo $row['nama_sistem'] ; ?></td>
		</tr>
	</table>
												
<table width="91%" border="0" align="center" cellspacing="0" class="style7 left right bottom top">
	<tr>
		<td><h4 style="padding-top:13px; ">REKAPITULASI</h4></td>
	</tr>
</table>
	<table width="91%" border="0" align="center" cellpadding="3" cellspacing="0" class="style7 left right bottom">
		<tr>
			<th>&nbsp;</th>
			<th>TARGET</th>
			<th>REALISASI</th>
			<th>SALDO</th>
			<th colspan="2">KETERANGAN</th>
		</tr> 
		<tr>
			<td>Pokok</td>
			<td align="center"><?php echo number_format($targetpokok); ?></td>
			<td align="center"><?php echo number_format($totpokok); ?></td>
			<td align="center"><?php echo number_format($saldopokok); ?></td>
			<td align="center" colspan="2"><?php echo $ketpokok ?></td>
		</tr>
		<tr>
			<td>Jasa</td>
			<td align="center"><?php echo number_format($targetjasa); ?></td>
			<td align="center"><?php echo number_format($totjasa); ?></td>
			<td align="center"><?php echo number_format($saldojasa); ?></td>
			<td align="center" colspan="2"><?php echo $ketjasa; ?></td>
		</tr>
		<tr>
			<td colspan='2' align="center" class="top"><img src='lunas.png'  width="90%"/></td>
			<td colspan='3' class="top">
			<p>Pinjaman tersebut diatas telah kami nyatakan LUNAS dan Surat Perjanjian Kredit (SPK) nomor <?php echo $row['spk_no']; ?> tanggal <?php echo $tgl_cair; ?> dinyatakan selesai beserta seluruh hak dan kewajibannya.</p>
			</td>
			<td width="25%" align="center" class="top">
				<p><?php if ($r['jabatan']=='1') { ?>
             <?php echo $row['sebutan_level_1']; ?>

             <?php }else if ($r['jabatan']=='2') { ?>
             <?php echo $row['sebutan_level_2']; ?>

             <?php }else if ($r['jabatan']=='3') { ?>
             <?php echo $row['sebutan_level_3']; ?>

             <?php }else{ ?>
              <?php echo $jabatan; ?>
             <?php } ?> 
</p>
             <br>
             <br>

             <b><?php echo strtoupper("$r[namadepan] $r[namabelakang]"); ?></b>
			</td>
		</tr>
	</table>


								
</div>
</body>