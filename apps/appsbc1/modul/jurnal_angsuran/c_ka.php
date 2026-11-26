<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];
$idtp				=$_GET['idtp'];
$idt				=$_GET['idt'];

if ($idtp=='none') {
$r=mysql_fetch_array(mysql_query("SELECT * FROM	kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk, $table_transaksi t, users u WHERE
	k.id=pk.id_kel and pk.id=t.id_pinj AND u.id=t.id_user AND t.idt='$idt' " ));

	$pokok	=0;
	$jasa	=0;
	$denda	=0;	
} else {
$r=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, $table_transaksi t, $table_rekening r, users u, pinjaman_kelompok_$_SESSION[kd_kab] pk, sistem_angsuran sa
								WHERE  c.id=k.lokasi AND d.id=k.desa AND k.id=pk.id_kel AND pk.id=t.id_pinj AND pk.jenis_pp=jpp.id AND t.idtp='$idtp' AND r.kd_rekening=t.rekening_debit AND u.id=t.id_user AND sa.id=pk.sistem_angsuran"));
	$pokok	=pokok($idtp);
	$jasa	=jasa($idtp);
	$denda	=denda($idtp);								
}

	$alokasi	=$r['alokasi'];
	$id_pinj	=$r['id_pinj'];
	$jangka		=$r['jangka'];
	$sistem		=$r['sistem'];
	$tempoo		=@($jangka/$sistem);
	if($tempoo<=1) {$tempo=2;}else{$tempo=$tempoo;}
	
	$bln_transaksi=substr($r['tgl_transaksi'],0,7);
	$tgl_kondisi	="$bln_transaksi-31";
	
	
	$total_bayar	=$pokok+$jasa+$denda;
	
	$saldo			=saldopinjaman("$r[tgl_transaksi]-$id_pinj");
	$nunggakpokok	=nunggakpokok("$tgl_kondisi-$id_pinj");
	$nunggakjasa	=nunggakjasa("$tgl_kondisi-$id_pinj");

//Jumlah Transaksi s.d. Record ini
$jtras=mysql_num_rows(mysql_query("SELECT * FROM $table_transaksi WHERE id_pinj='$id_pinj' and tgl_transaksi<='$r[tgl_transaksi]' AND idtp<='$_GET[idtp]' AND idtp!='0' GROUP BY idtp"));	


?>

<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px; color:000;
}
-->
</style>
<body onLoad="window.print()">
<br><br><br><br><br><br><br><br><br><br><br><br>
<p class="style2"><?php FOR($no=1;$no<=$tempo/2;$no++) {echo "<br>";}?></p>
<p class="style2"><?php FOR($no=1;$no<=$jtras;$no++) {echo "<br>";}?></p>

<table width="87%" action="" border="0" align="center" cellpadding="2" cellspacing="1.5" class="style1" >
	  <tr>
	    <td width="4%"><div align="center"><?php echo $jtras; ?></div></td>
        <td width="15%"><div align="center"><?php echo tgl_ind($r['tgl_transaksi']);?></div></td>
        <td width="13%"><div align="right"><?php echo number_format($pokok);?></div></td>
        <td width="14%"><div align="right"><?php echo number_format($nunggakpokok);?></div></td>
        <td width="14%"><div align="right"><?php echo number_format($jasa);?></div></td>
        <td width="14%"><div align="right"><?php echo number_format($nunggakjasa);?></div></td>
        <td width="15%"><div align="right"><?php echo number_format($saldo);?></div></td>
        <td width="13%"><div align="center"><?php echo "$r[ins]-$r[idtp]";?></div></td>
      </tr>
</table>  

</body>
