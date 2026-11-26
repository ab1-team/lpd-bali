<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";

$lokasi				=$_SESSION['lokasi'];
$table_rekening		="rekening_".$lokasi;

$d					=$_GET['d'];
$m					=$_GET['m'];
$y					=$_GET['y'];
$tgl				="$y-$m-$d";


$row=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d where c.id=d.kd_kec AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="4" class="bottom">
			<div class="style9">LPD <?php echo $row ['nama_desa'];?><br>
			<?php echo $row['alamat_desa'];?> Telp.<?php echo $row['telpon_desa'];?>
			</div>
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. DR Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="6" class="style6 bottom"><br>DETAIL SALDO PER REKENING <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="6%" height="30" class="style9 top bottom">INS</th>
	    <th width="50%" class="style9 all">KODE DAN NAMA REKENING</th>
	    <th width="18%" class="style9 top bottom right">JUMLAH</th>
	    <th width="11%" class="style9 top bottom right">POSISI</th>
	    <th width="11%" class="style9 top bottom right">MUTASI</th>
    </tr>
	  <?php
		$data=mysql_query("select * from jenis_buku jb, $table_rekening r WHERE jb.kd_jb=r.kd_jb ORDER by kd_rekening ASC ");
		while($ju=mysql_fetch_array($data)){
		$no=$no+1;
		$jm=$ju['jenis_mutasi'];
		$saldorekeningD	=SATDR("$tgl-".$ju['kd_rekening'])+SABDR("$tgl-".$ju['kd_rekening']);
		$saldorekeningK	=SATKR("$tgl-".$ju['kd_rekening'])+SABKR("$tgl-".$ju['kd_rekening']);
		if($jm=='debit') {$saldorekening=$saldorekeningD;}else{$saldorekening=$saldorekeningK;}
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $ju['ins'];?></td>
	    <td class="style9 left right bottom"><?php echo "$ju[kd_rekening]/$ju[pasangan] $ju[nama_rekening]";?></td>
	    <td class="style9 right bottom align-right"><?php echo number_format($saldorekening);?></td>
	    <td class="style9 right bottom align-center"><?php if($ju['posisi']=='1') { $posisi="Neraca"; }else{$posisi="Rugi-Laba";} echo $posisi;?></td>
	    <td class="style9 right bottom align-center"><?php echo $ju['jenis_mutasi'];?></td>

	</tr>
  <?php } ?>
	<tr>
	<td class="style10" colspan="3">User: <?php echo "$u[namadepan] $u[namabelakang]";?></td><td class="style10 align-right" colspan="3">Dicetak pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>
	          
</body>
<title>DR02. Detail Rekening <?php echo "$jenis ".tgl_indo($tgl);?></title>