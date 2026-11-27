<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];
$idtp				=$_GET['idtp'];
$idt				=$_GET['idt'];

if ($idtp=='none') {
$r=mysql_fetch_array(mysql_query("SELECT * FROM	anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t, users u WHERE
	a.id=pi.nia and pi.id=t.id_pinj_i AND u.id=t.id_user AND t.idt='$idt' " ));
} else {
$r=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, $table_transaksi t, $table_rekening r, users u, pinjaman_anggota_$_SESSION[kd_kab] pi, sistem_angsuran sa
								WHERE  c.id=a.lokasi AND d.id=a.desa AND a.id=pi.nia AND pi.id=t.id_pinj_i AND pi.jenis_pp=jpp.id AND t.idtp='$idtp' AND r.kd_rekening=t.rekening_debit AND u.id=t.id_user AND sa.id=pi.sistem_angsuran"));
}

	$alokasi	=$r['alokasi'];
	$id_pinj_i	=$r['id_pinj_i'];
	$jangka		=$r['jangka'];
	$sistem		=$r['sistem'];
	$tempoo		=@($jangka/$sistem);
	$temp2		=$tempoo%2;
	if($temp2==0) {$temp=$tempoo/2;}else{$temp=($tempoo+1)/2;}
	if($temp<=1) {$tempo="1";} elseif($tempo<=3) {$tempe="3";} else{$tempo=$temp;}
	
	$pokok	=pokok($idtp);
	$jasa	=jasa($idtp);
	$denda	=denda($idtp);
	$total_bayar	=$pokok+$jasa+$denda;
	
	$saldo			=saldopinjaman("$r[tgl_transaksi]-$id_pinj_i");
	$nunggakpokok	=nunggakpokok("$r[tgl_transaksi]-$id_pinj_i");
	$nunggakjasa	=nunggakjasa("$r[tgl_transaksi]-$id_pinj_i");

//Jumlah Transaksi s.d. Record ini
$jtras=mysql_num_rows(mysql_query("SELECT * FROM $table_transaksi WHERE id_pinj_i='$id_pinj_i' and tgl_transaksi<='$r[tgl_transaksi]' GROUP BY idtp"));	


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
.style3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; color:000;
}
-->
</style>
<body onLoad="window.print()">
 <p class="style3">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
    <p class="style2">&nbsp;</p>
<p class="style2"><?php FOR($no=1;$no<=$tempo;$no++) {echo "<br>";}?></p>
<p class="style2"><?php FOR($no=1;$no<=$jtras;$no++) {echo "<br>";}?></p>
<table width="100%" action="" border="0" align="center" cellpadding="2" cellspacing="0" class="style1" >
	  <tr>
		<td width="6%" height="10">&nbsp;</td>
	    <td width="5%"><div align="center"><?php echo $jtras-1; ?></div></td>
        <td width="10%"><div align="center"><?php echo tgl_ind($r['tgl_transaksi']);?></div></td>
        <td width="10%"><div align="right"><?php echo number_format($pokok);?></div></td>
        <td width="10%"><div align="right"><?php echo number_format($nunggakpokok);?></div></td>
        <td width="10%"><div align="right"><?php echo number_format($jasa);?></div></td>
        <td width="10%"><div align="right"><?php echo number_format($nunggakjasa);?></div></td>
			 <?php
			 // if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td width="10%"><div align="right">'.number_format($denda).'</div></td>';}
			 // ?>
        <td width="10%"><div align="right"><?php echo number_format($saldo);?></div></td>
        <td width="6%"><div align="center"><?php echo "$r[ins]-$r[idtp]";?></div></td>
        <td width="9%">&nbsp;</td>
      </tr>
</table>  

</body>

