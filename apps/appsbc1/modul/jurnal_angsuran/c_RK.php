<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";


$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$idp				=$_GET['idp'];

$text	= "SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk, sistem_angsuran sa, jenis_jasa jj, $table_transaksi t WHERE d.id=k.desa AND k.id=pk.id_kel AND sa.id=pk.sistem_angsuran AND jj.id=pk.jenis_jasa AND pk.id=t.id_pinj AND t.id_pinj='$idp'  ";
$sql 	= mysql_query($text);
$r		= mysql_fetch_array($sql);

$alokasi_jasa	=alokasi_jasa($idp);
?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<?php 
if($idp=="") {
	echo "<p align='center' class='style6'>
		<br><br>KAMI TAU KALAU ANDA BELUM MEMILIH KELOMPOKNYA<br>SILAHKAN PILIH KELOMPOK TERLEBIH DAHULU :)</p>";
}else{
?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php echo "$kec[nama_lembaga_sort] Kecamatan $kec[nama_kec]";?><br>
				<?php echo $kec['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_kec'];?>
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $r['kd_kelompok'];?>-<?php echo $r['id_pinj'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		REKENING KORAN<br>
		<span class="fw-semi-bold">RIWAYAT ANGSURAN KELOMPOK</p></td>
      </tr>
      <tr>
        <td width="19%" height="24" class="style9">Nama Kelompok</td>
        <td width="32%" height="24"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($r['nama_kelompok']);?></span></td>
        <td width="19%" height="24" class="style9">Tanggal Cair</td>
        <td width="30%" height="24"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($r['tgl_cair']); ?></span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alamat</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[alamat_kelompok]";?></span></td>
        <td height="24" class="style9"> Alokasi Pinjaman </td>
        <td height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($r['alokasi']);?>,-</span></td>
      </tr>
	  <tr>
        <td height="24" class="style9">Desa</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[nama_desa]";?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[nama_sistem] ($r[jangka] bulan)";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">Ketua</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$r[ketua]";?></span></td>
        <td height="25" class="style9">Prosentase, Jenis Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$r[pros_jasa] %/bulan, $r[nama_jj]";?> </span></td>
      </tr>  
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="8%" class="style9 top bottom">TANGGAL</th>
	    <th width="6%" class="style9 all">ID.TRX</th>
	    <th width="40%" class="style9 top bottom">KETERANGAN</th>
	    <th width="10%" class="style9 all">PENCAIRAN</th>
	    <th width="10%" class="style9 top bottom">POKOK</th>
	    <th width="10%" class="style9 all">JASA</th>
	    <th width="10%" class="style9 top bottom right">DENDA</th>
	    <th width="2%" class="style9 top bottom right">P</th>
    </tr>
	<tr>
	    <td height="25" class="style9 left bottom align-center" colspan="4">T A R G E T &nbsp; P E M B A Y A R A N</td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($r['alokasi']);?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($r['alokasi']);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($alokasi_jasa);?></td>
	    <td class="style9 bottom right align-right">0</td>
	    <td class="style9 bottom right align-center">&nbsp;</td>
	</tr>
	 <?php
		$data=mysql_query("SELECT * FROM users u, $table_transaksi t WHERE u.id=t.id_user AND t.id_pinj='$idp' ORDER BY t.tgl_transaksi, t.urutan ");
		while($row=mysql_fetch_array($data)){
		$no=$no+1;
			if($row['rekening_debit']=="112.01" OR $row['rekening_debit']=="113.01" OR $row['rekening_debit']=="115.01" OR $row['rekening_debit']=="116.01") {
										$pokok	=pokok($row['idtp']);
										$jasa	="0";
										$denda	="0";
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_debit']=="112.02" OR $row['rekening_debit']=="113.02" OR $row['rekening_debit']=="115.02" OR $row['rekening_debit']=="116.02") {
										$pokok	="0";
										$jasa	=jasa($row['idtp']);
										$denda	="0";
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_debit']=="112.03" OR $row['rekening_debit']=="113.03" OR $row['rekening_debit']=="115.03" OR $row['rekening_debit']=="116.03") {
										$pokok	="0";
										$jasa	="0";
										$denda	=denda($row['idtp']);
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_kredit']=="112.07" OR $row['rekening_kredit']=="113.07" OR $row['rekening_kredit']=="122.07"  OR $row['rekening_kredit']=="123.07" OR $row['rekening_kredit']=="115.07" OR $row['rekening_kredit']=="115.01") {
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$pencairan=$row['jumlah'];
										$rekening=$row['rekening_kredit'];
										}
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo tgl_ind($row['tgl_transaksi']);?></td>
	    <td class="style9 left right bottom align-center"><?php echo "$row[idt]";?></td>
	    <td class="style9 bottom"><?php echo $row['keterangan_transaksi'];?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($pencairan);?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($pokok);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($jasa);?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format($denda);?></td>
	    <td class="style9 bottom right align-center"><?php echo $row['ins'];?></td>
	</tr>
  <?php 
  $sumcair=$sumcair+$pencairan;
						$sumpokok=$sumpokok+$pokok;
						$sumjasa=$sumjasa+$jasa;
						$sumdenda=$sumdenda+$denda;
						$saldo_pokok=alokasi($idp)-$sumpokok;
						$saldo_cair=alokasi($idp)-$sumcair;
						$saldo_jasa=$alokasi_jasa-$sumjasa;
						
						} ?>
	<tr>
	    <th height="25" colspan="4" class="style9 left bottom"><div align="center">JUMLAH PEMBAYARAN</div></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($sumcair);?></th>
	    <th class="style9 bottom align-right"><?php echo number_format($sumpokok);?></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($sumjasa);?></th>
	    <th class="style9 bottom right align-right"><?php echo number_format($sumdenda);?></th>
	    <th class="style9 bottom right align-center"><?php echo $r['ins'];?></th>
	</tr>
	<tr>
	    <th height="25" colspan="4" class="style9 left bottom"><div align="center">S A L D O</div></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($saldo_cair);?></th>
	    <th class="style9 bottom align-right"><?php echo number_format($saldo_pokok);?></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($saldo_jasa);?></th>
	    <th class="style9 bottom right align-right">0</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	</tr>
	<tr>
		<td class="style10 top align-right" colspan="9">Dicetak Oleh: <?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?> | Paraf : [ &nbsp; &nbsp; &nbsp; &nbsp; ]</td>
	</tr>
</table>

<?php } ?>	          
</body>
<title>RK. Rekening Koran Riwayat Angsuran Kelompok</title>