<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];
$idtp				=$_GET['idtp'];


$r=mysql_fetch_array(mysql_query("SELECT * FROM sebutan_desa sd, desa d, anggota_$_SESSION[kd_kab] a, $table_transaksi t, $table_rekening r, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi
								WHERE  sd.id=d.sebutan AND d.id=a.desa AND a.id=pi.nia AND pi.id=t.id_pinj_i AND t.idtp='$idtp' AND r.kd_rekening=t.rekening_debit AND sa.id=pi.sistem_angsuran"));

								
$u=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$r[id_user]' "));

								
	
	$idt	=$r['idt'];
	$alokasi	=$r['alokasi'];
	$id_pinj	=$r['id_pinj_i'];
	$bln_transaksi=substr($r['tgl_transaksi'],0,7);
	$tgl_kondisi	="$bln_transaksi-31";
	
	$pokok	=pokok($idtp);
	$jasa	=jasa($idtp);
	$denda	=denda($idtp);
	$total_bayar	=$pokok+$jasa+$denda;
	
	$angsuranke		=angsuranke("$tgl_kondisi-$id_pinj"); //Menggunakan fungsi Angsuranke dengan tgl kondisi dan kode pinjamn
	$jum_angsuran	=@($r['jangka']/$r['sistem']);
	
	
	$targetpokok	=targetpokok("$tgl_kondisi-$id_pinj");
	$targetjasa		=targetjasa("$tgl_kondisi-$id_pinj");
	
	$sum_pokok		=sumpokok("$r[tgl_transaksi]-$id_pinj");
	$sum_jasa		=sumjasa("$r[tgl_transaksi]-$id_pinj");
	
	$saldo			=saldopinjaman("$r[tgl_transaksi]-$id_pinj");
	$nunggakpokok	=nunggakpokok("$tgl_kondisi-$id_pinj");
	$nunggakjasa	=nunggakjasa("$tgl_kondisi-$id_pinj");
	
	$wajibpokok	=wajibpokok("$tgl_kondisi-$id_pinj");
	$wajibpokokaja	=wajibpokokaja($id_pinj);
	$wajibjasa	=wajibjasa("$tgl_kondisi-$id_pinj");
	
	$untuk		=@(floor($sum_pokok/$wajibpokokaja));
	
		
	//Menghitung pengembalian bulan selanjutnya		
		if 		($sum_pokok<$alokasi and $saldo>$wajibpokok)	{ $ansjut_p=$wajibpokok; 			$ansjut_j=$wajibjasa;	}	//Normal
		elseif 	($saldo<$wajibpokok and $saldo>0) 			{ $ansjut_p=$saldo; 				$ansjut_j=$wajibjasa;	}	//Angsuran Terakhir
		elseif 	($sum_pokok>=$alokasi) 						{ $ansjut_p=$alokasi-$sum_pokok;	$ansjut_j='0';			}	//Lunas
		
	//Menghitung total angsuran bulan depan
		$totansjut_p=$ansjut_p+$nunggakpokok;
		$totansjut_j=$ansjut_j+$nunggakjasa;
		
		
		//Ucapan Terimakasih dan tanggal cetak
		$tgl=date('d/m/Y H:i:s A');
		$tgl1=substr($r['tgl_cair'],8,2);
		$tgl2=substr($r['tgl_transaksi'],8,2);
		$tgl_sel=$tgl2-$tgl1;
		if ($tgl_sel < 0){
		$ucapan="Terimakasih telah membayar sebelum jatuh tempo.";
		}else if ($tgl_sel == 0){
		$ucapan="Terimakasih telah membayar tepat waktu.";
		}else if ($tgl_sel > 0){
		$ucapan="Pembayaran sebelum tgl.$tgl1 TERLAMBAT $tgl_sel hari.";
		}
?>

<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>

<body onLoad="window.print()">
<table width="100%" action="" border="0" align="center" cellpadding="1" cellspacing="1.5" class="style1"> 	         
      
      <tr>
        <th colspan="4" class="bottom"><b>LPD <?php echo strtoupper("$r[sebutan_desa] $r[nama_desa]");?></b><br>
            <?php echo $r['alamat_desa'];?><br>
            <?php echo " Telp. ".$r['telpon_desa'];?></th>
        <td width="4%" rowspan="17">&nbsp;</td>
        <td width="19%">Kode Transaksi <br>
        Tanggal Transasksi</td>
        <td width="15%">: <?php echo "$idt-$idtp/KM".tgl_rom($r['tgl_transaksi'])."";?> <br>
          : <?php echo tgl_indo($r['tgl_transaksi']);?></td>
        <th width="14%" class="style26">BUKTI ANGSURAN </th>
      </tr>
	  
      <tr>
        <td width="15%">Loan ID</td>
        <td width="11%"><strong>: <?php echo $r['id_pinj_i'];?></strong></td>
        <td colspan="2"><div align="right">Angsuran ke: <?php echo ("$untuk dari $jum_angsuran");?></div></td>
        <th class="bottom top">STATUS PINJAMAN</th>
        <th class="bottom top">POKOK</th>
        <th class="bottom top">JASA</th>
      </tr>
	  <tr>
	    <td>N I K </td>
        <td colspan="3">: <?php echo $r['nik'];?></td>
        <td>Alokasi Pinjaman </td>
        <td align="right"><?php echo number_format($r['alokasi']);?>,-</td>
        <td align="right"><?php echo $r['pros_jasa'];?>% per bln </td>
      </tr>
      <tr>
        <td>Nama Debitur </td>
        <td colspan="3"><b>: <?php echo strtoupper($r['namadepan']);?></b></td>
        <td>Target  Pengembalian (<?php echo $angsuranke;?>x)</td>
        <td align="right"><?php echo number_format($targetpokok);?>,-</td>
        <td align="right"><?php echo number_format($targetjasa);?>,-</td>
      </tr>
	  <tr>
	    <td>Alamat</td>
        <td colspan="3">: <?php echo "$r[alamat] $r[nama_desa]";?></td>
        <td class="bottom">Realisasi  Pengembalian</td>
        <td class="bottom" align="right"><?php echo number_format($sum_pokok);?>,-</td>
        <td class="bottom" align="right"><?php echo number_format($sum_jasa);?>,-</td>
      </tr>
      <tr>
        <td>Tanggal Cair </td>
        <td colspan="3">: <?php echo tgl_indo($r['tgl_cair']);?></td>
        <th>Saldo  Pinjaman</th>
        <th align="right"><?php echo number_format($saldo);?>,-</th>
        <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td>Sistem Angsuran </td>
        <td colspan="3">: <?php echo "$r[jangka] @$r[nama_sistem] = $jum_angsuran x";?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Pokok</td>
        <td>: </td>
        <td width="10%"><div align="right"><?php echo number_format($pokok);?>,-</div></td>
        <td width="12%">&nbsp;</td>
        <th class="bottom top">TAGIHAN BULAN DEPAN</th>
        <th class="bottom top">POKOK</th>
        <th class="bottom top">JASA</th>
      </tr>
	  <tr>
	    <td>Jasa</td>
	    <td>: </td>
	    <td><div align="right"><?php echo number_format($jasa);?>,-</div></td>
	    <td>&nbsp;</td>
	    <td>Tunggakan  s.d. Bulan Ini</td>
        <td align="right"><?php echo number_format($nunggakpokok);?>,-</td>
        <td align="right"><?php echo number_format($nunggakjasa);?>,-</td>
      </tr>
      <tr>
        <td class="bottom">Denda</td>
        <td class="bottom">: </td>
        <td class="bottom"><div align="right"><?php echo number_format($denda);?>,-</div></td>
        <td class="bottom">&nbsp;</td>
        <td class="bottom">Angsuran  Bulan Depan</td>
        <td align="right" style="border-bottom:1px solid #000;"><?php echo number_format($ansjut_p);?>,-</td>
        <td align="right" style="border-bottom:1px solid #000;"><?php echo number_format($ansjut_j);?>,-</td>
      </tr>
	  <tr>
	    <th height="27">JUMLAH BAYAR </th>
        <td>:</td>
        <td><div align="right"><b><?php echo number_format($total_bayar);?>,-</b></div></td>
        <td>&nbsp;</td>
        <th>TOTAL TAGIHAN (H+1) </th>
        <th align="right"><?php echo number_format($totansjut_p+$totansjut_j);?>,-</th>
        <td>&nbsp;</td>
	  </tr>
      
      <tr>
        <td colspan="4">Terbilang : </td>
        <td><div align="center">Diterima Oleh </div></td>
        <td rowspan="5">&nbsp;</td>
        <td><div align="center">Penyetor,</div></td>
      </tr>
      <tr>
        <th colspan="4" rowspan="3"><?php echo strtoupper(toterbilang($total_bayar));?> RUPIAH</th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" rowspan="2" class="style2 top">
			- <?php echo $ucapan;?><br>
			- Dicetak pada <?php echo date('d-m-Y H:i:s A');?><br>
			- Lembar 1 untuk Kelompok, lembar 2 Arsip UPK<br>
			- Bawalah kartu angsuran dan slip ini pada saat mengangsur bulan depan<br>
			- Cek status pinjaman kelompok anda di www.lpd-bali.id		</td>
        <th valign="top"><div align="center" class="bottom"><?php echo strtoupper("$u[namadepan] $u[namabelakang]");?></div></th>
        <th valign="top"><div align="center" class="bottom"><?php echo strtoupper("$r[namadepan]");?></div></th>
      </tr>
      <tr>
        <th colspan="3" valign="middle">&nbsp;</th>
      </tr>
</table>  

     
</body>
