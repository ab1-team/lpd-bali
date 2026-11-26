<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";


$kec=mysql_fetch_array(mysql_query("select * from desa d, sebutan_desa sd WHERE sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$idp				=$_GET['idp'];

$text	= "SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t WHERE d.id=a.desa AND a.id=pi.nia AND pi.id=t.id_pinj_i AND pi.jenis_pinjaman='I'  AND t.id_pinj_i='$idp' ORDER BY t.tgl_transaksi  ";
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
		<br><br>SILAHKAN PILIH NAMA PEMANFAAT TERLEBIH DAHULU :)</p>";
}else{
?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php echo "LPD $kec[sebutan_desa] $kec[nama_desa]";?><br>
				<?php echo $kec['alamat_desa'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_desa'];?>
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $r['nik'];?>-<?php echo $r['id_pinj_i'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		REKENING KORAN/<br>
		<span class="fw-semi-bold">RIWAYAT PEMBAYARAN ANGSURAN</p></td>
      </tr>
      <tr>
        <td width="19%" height="24" class="style9">Nama Pemanfaat</td>
        <td width="32%" height="24"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($r['namadepan']);?></span></td>
        <td width="19%" height="24" class="style9">Tanggal Cair</td>
        <td width="30%" height="24"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($r['tgl_cair']); ?></span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alamat</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[alamat]";?></span></td>
        <td height="24" class="style9"> Alokasi Pinjaman </td>
        <td height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($r['alokasi']);?>,-</span></td>
      </tr>
	  <tr>
        <td height="24" class="style9"><?php echo "$kec[sebutan_desa]";?></td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[nama_desa]";?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$r[nama_sistem] ($r[jangka] bulan)";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">Telpon</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$r[hp]";?></span></td>
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
	    <th width="10%" class="style9 top bottom right">LAINNYA</th>
	    <th width="2%" class="style9 top bottom right">P</th>
    </tr>
	<tr>
	    <td height="25" class="style9 left bottom align-center" colspan="4">T A R G E T &nbsp; P E M B A Y A R A N</td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($r['alokasi']);?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($r['alokasi']);?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($alokasi_jasa);?></td>
	    <td class="style9 bottom right align-right">0</td>
	    <td class="style9 bottom right align-right">0</td>
	    <td class="style9 bottom right align-center">&nbsp;</td>
	</tr>
	  <?php
	  
	  $data	= mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t WHERE a.id=pi.nia AND pi.id=t.id_pinj_i AND pi.jenis_pinjaman='I'  AND t.id_pinj_i='$idp' ORDER BY t.tgl_transaksi  ");
								$no=0;
								while($row=mysql_fetch_array($data)){
								$no=$no+1;	
									if($row['rekening_debit']=="111.01") { 
										$pokok	=pokok($row['idtp']);
										$jasa	="0";
										$denda	="0";
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_debit']=="111.02") {
										$pokok	="0";
										$jasa	=jasa($row['idtp']);
										$denda	="0";
										$lainnya="0";
										$pencairan="0";
										$rekening=$row['rekening_debit'];
										}elseif($row['rekening_debit']=="111.03") {
										$pokok	="0";
										$jasa	="0";
										$denda	=denda($row['idtp']);
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_kredit']=="111.14") {
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$lainnya	="0";
										$pencairan=$row['jumlah'];
										}else{
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$pencairan	="0";
										$lainnya=$row['jumlah'];
										}

										$u=mysql_fetch_array(mysql_query("select * from users WHERE id='$row[id_user]' "));
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
	    <td class="style9 bottom right align-right"><?php echo number_format($lainnya);?></td>
	    <td class="style9 bottom right align-center"><?php echo $u['ins'];?></td>
	</tr>
  <?php 
  $sumcair=$sumcair+$pencairan;
						$sumpokok=$sumpokok+$pokok;
						$sumjasa=$sumjasa+$jasa;
						$sumdenda=$sumdenda+$denda;
						$sumlainnya=$sumlainnya+$lainnya;
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
	    <th class="style9 bottom right align-right"><?php echo number_format($sumlainnya);?></th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	</tr>
	<tr>
	    <th height="25" colspan="4" class="style9 left bottom"><div align="center">S A L D O</div></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($saldo_cair);?></th>
	    <th class="style9 bottom align-right"><?php echo number_format($saldo_pokok);?></th>
	    <th class="style9 left bottom right align-right"><?php echo number_format($saldo_jasa);?></th>
	    <th class="style9 bottom right align-right" colspan="3">&nbsp;</th>
	</tr>
	<tr>
		<td class="style10 top align-right" colspan="10">Dicetak Oleh: <?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?> | Paraf : [ &nbsp; &nbsp; &nbsp; &nbsp; ]</td>
	</tr>
</table>

<?php } ?>	          
</body>
<title>RK. Rekening Koran Riwayat Angsuran Kelompok</title>