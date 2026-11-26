<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

        function minimum($data)
        {
            $result = $data;
            if ($result < 0) {
                $result = 0;
            }
            return $result;
        }


$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";
$yll				=$y-1;
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
$thn_kondisi		="$y-01-01";
$thn_kondisi_lalu	="$yll-12-31";

	 $tgl_awal            = "$y-$m-01";
    
            if ($d = $d) {
                $laporan = "Harian";
                $jenis = "Tanggal";
                $tgl_kondisi = "$y-$m-$d";
                $kc = "D";
                $tgl_kondisilalu = "$y-$m-$dl";
                $judulL = "Kemaren";
                $judulC = "Hari Ini";
                $tgl_awal    = "$y-$m-$d";
            } else if ($m = $m) {
                $laporan = "Bulanan";
                $jenis = "Bulan";
                $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01"));
                $kc = "M";
                $tgl_kondisilalu=date("Y-m-t", strtotime("$y-$ml-01"));
                $judulL = "Bulan Lalu";
                $judulC = "Bulan Ini";
                $tgl_awal    = "$y-$m-01";
            } else if ($y = $y) {
                $laporan = "Tahunan";
                $jenis = "Tahun";
                $tgl_kondisi = "$y-12-31";
                $kc = "Y";
                $tgl_kondisilalu = "$y-12-31";
                $judulL = "Tahun Lalu";
                $judulC = "Tahun Ini";
                $tgl_awal    = "$y-01-01";
            } else {
                $laporan = "Global";
            }

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

$kd_kec=$row['kd_kec'];

?>


<style type="text/css">
<!--
.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px;font-weight: bold;  }
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Arial, Helvetica, sans-serif}
.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="10" class="bottom">
			<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN <?php echo $jpp;?> REKAP KELOMPOK <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Kelompok - Loan ID</a></th>
			  <th width="4%" rowspan="2" class="left bottom">Tgl Cair</a></th>
              <th width="3%" rowspan="2" class="left bottom">Tem<br>po</a></th>
              <th width="7%" rowspan="2" class="left bottom">Alokasi</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Pros Jasa</a></th>
              <th colspan="2" class="left bottom">Target Pengembalian</a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulL;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi <?php echo $judulC;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulC;?> </a></th>
              <th width="8%" rowspan="2" class="left bottom">Saldo Pinjaman </th>
              <th width="2%" rowspan="2" class="left bottom">%</th>
              <th colspan="2" class="left bottom right">Tunggakan Pengembalian</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom right">Jasa</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
$view=mysql_query("SELECT pk.id, 
								  pk.alokasi, 
								  k.nama_kelompok, 
								  pk.tgl_cair, 
								  pk.tgl_lunas, 
								  pk.pros_jasa,
								  pk.`status`, 
								  pk.jangka, 
								  sa.sistem, 
								  k.kd_kelompok	
								  
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		$jkel=mysql_num_rows($view);
			$salokasi       =0;
        	$stargetpokok   =0;
        	$stargetjasa    =0;
        	$sreallalu      =0;
        	$sreallalujasa  =0;
        	$srealpokok     =0;
        	$srealjasa      =0;
        	$sspokok        =0;
        	$ssjasa         =0;
        	$ssaldopinjaman =0;
        	$snunggakpokok  =0;
        	$snunggakjasa   =0;
		?>
		<tr>
			<td class="style27 left top right" colspan="18"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
		<?php
		
		while($row=mysql_fetch_array($view)){
                        $jum++;
                        $tgl2    = date('Y-m-d', strtotime('+1 month', strtotime($tgl_kondisi)));
                        $ra = mysql_fetch_array(mysql_query("SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND jatuh_tempo<='$tgl_kondisi' ORDER BY jatuh_tempo DESC"));
    
                        $penguranganp = 0;
                        $penguranganj = 0;
                        if (!($ra)) { // jika $ra kosong (angsuran ke 0)
                            $ra = mysql_fetch_array(mysql_query("SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND jatuh_tempo<='$tgl2' ORDER BY jatuh_tempo DESC"));
                            if (!($ra)) { // jika $ra kosong (angsuran ke 0)
                                $ra = array("wajib_pokok" => "0", "wajib_jasa" => "0", "target_pokok" => "0", "target_jasa" => "0", "realisasi_pokok" => "0", "realisasi_jasa" => "0", "sum_pokok" => "0", "sum_jasa" => "0", "saldo_pokok" => "$row[alokasi]", "saldo_jasa" => ($row['alokasi'] * $row['pros_jasa'] * $row['jangka']), "tunggakan_pokok" => "0", "tunggakan_jasa" => "0");
                            }
                            $penguranganp = $ra['wajib_pokok'];
                            $penguranganj = $ra['wajib_jasa'];
                        }
                        $real = mysql_fetch_array(mysql_query( "SELECT *FROM real_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND tgl_transaksi<='$tgl_kondisi' ORDER BY tgl_transaksi DESC, id DESC "));
                        $real2 = mysql_fetch_array(mysql_query( "SELECT sum(realisasi_pokok) as realisasi_pokok,sum(realisasi_jasa) as realisasi_jasa FROM real_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND tgl_transaksi<='$tgl_kondisi' AND tgl_transaksi>='$tgl_awal' ORDER BY tgl_transaksi DESC, id DESC"));
                        if (!($real)) { // jika $ra kosong (angsuran ke 0)
                            $real = array("wajib_pokok" => "0", "wajib_jasa" => "0", "target_pokok" => "0", "target_jasa" => "0", "realisasi_pokok" => "0", "realisasi_jasa" => "0", "sum_pokok" => "0", "sum_jasa" => "0", "saldo_pokok" => "$row[alokasi]", "saldo_jasa" => ($row['alokasi'] * $row['pros_jasa'] * $row['jangka']), "tunggakan_pokok" => "0", "tunggakan_jasa" => "0");
                        }
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$pros_jasa 		=number_format($row['pros_jasa'],2);
		$tgl_lunas		=$row['tgl_lunas'];
		$status			=$row['status'];
                        $target_pokok   = $ra['target_pokok'];
                        $target_jasa    = $ra['target_jasa'];
                        $mtrans         = substr($real['tgl_transaksi'], 5, 2);
                        if ($mtrans == $m) {
                            $realp          = $real2['realisasi_pokok'];
                            $realj          = $real2['realisasi_jasa'];
                        } else {
                            $realp          = 0;
                            $realj          = 0;
                        }
                        $plalu          = minimum($real['sum_pokok'] - $realp);
                        $jlalu          = minimum($real['sum_jasa'] - $realj);
                        $sum_pokok      = $real['sum_pokok'];
                        $sum_jasa       = $real['sum_jasa'];
                        $saldo_pokok    = minimum($real['saldo_pokok']);
                        $saldo_jasa    = minimum($ra['target_jasa'] - $real['sum_jasa']);
    
		//$sumpokok		=sumpokok("$tgl_kondisi-$idp"); //01.19.25
		$sumpokok		=$reallalu+$realpokok;
		//$sumjasa		=sumjasa($tgl_kondisi."-".$idp);
		$sumjasa		=$reallalujasa+$realjasa;
		//$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$saldopinjaman	=$alokasi-$sumpokok;
		//$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		//$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		$nunggakp			=$target_pokok-$sum_pokok;
		if($nunggakp<0) { $nunggakpokok="0"; }else{ $nunggakpokok=$nunggakp; }
		$nunggakj			=$target_jasa-$sum_jasa;
		if($nunggakj<=0 OR $status=="L" AND $tgl_lunas<$tgl_kondisi ) { $nunggakjasa="0"; } else{ $nunggakjasa=$nunggakj; }
		
		$angsuranke		=$ra['angsuran_ke'];
		
		?>
			<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] -$idp"; ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($row['tgl_cair']); ?></td>
			  <td class="left top" align="center">	<?php echo "$row[jangka]/$row[sistem]*$angsuranke";?></td>
			  <td class="left top">					<?php echo number_format($alokasi);?></td>
			  <td class="left top">					<?php echo substr($pros_jasa,0,4);?>%</td>
              <td class="left top">					<?php echo number_format($target_pokok);?></td>
              <td class="left top">					<?php echo number_format($target_jasa);?></td>
			  <td class="left top">					<?php echo number_format($plalu);?></td>              
              <td class="left top">					<?php echo number_format($jlalu);?></td>
			  <td class="left top">					<?php echo number_format($realp);?></td>
              <td class="left top">					<?php echo number_format($realj);?></td>
              <td class="left top">					<?php echo number_format($sum_pokok);?></td>
              <td class="left top">					<?php echo number_format($sum_jasa);?></td>
              <td class="left top">					<?php echo number_format($saldo_pokok);?></td>
              <td class="left top">					<?php $pros=round(@($sum_pokok/$target_pokok*100),2); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			
	<?php if($tgl_lunas<=$tgl_kondisi and $status=="L") { 
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">V-LUNAS <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="R") { 
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">Rescedulling <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="H") {
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">Penghapusan <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php }else{ ?>
			<td class="left top">					<?php echo number_format($nunggakpokok);?></td>
			<td class="left top right">				<?php echo number_format($nunggakjasa);?></td>
	<?php }
                        
	$salokasi       =$salokasi+$alokasi;
	$stargetpokok   =$stargetpokok+$target_pokok;
	$stargetjasa    =$stargetjasa+$target_jasa;
	$sreallalu      =$sreallalu+$plalu;
	$sreallalujasa  =$sreallalujasa+$jlalu;
	$srealpokok     =$srealpokok+$realp;
	$srealjasa      =$srealjasa+$realj;
	$sspokok        =$sspokok+$sum_pokok;
	$ssjasa         =$ssjasa+$sum_jasa;
	$ssaldopinjaman =$ssaldopinjaman+$saldo_pokok;
	$snunggakpokok  =$snunggakpokok+$nunggakpokok;
	$snunggakjasa   =$snunggakjasa+$nunggakjasa;
	
	$sumalokasi =$sumalokasi+$alokasi;
	$sumtargetpokok =$sumtargetpokok+$target_pokok;
	$sumtargetjasa =$sumtargetjasa+$target_jasa;
	$sumreallalu =$sumreallalu+$plalu;
	$sumreallalujasa =$sumreallalujasa+$jlalu;
	$sumrealpokok =$sumrealpokok+$realp;
	$sumrealjasa =$sumrealjasa+$realj;
	$sumsumpokok =$sumsumpokok+$sum_pokok;
	$sumsumjasa =$sumsumjasa+$sum_jasa;
	$sumsaldopinjaman =$sumsaldopinjaman+$saldo_pokok;
	$sumnunggakpokok =$sumnunggakpokok+$nunggakpokok;
	$sumnunggakjasa =$sumnunggakjasa+$nunggakjasa;
		}
		
		if($jkel>0){
		?>
		
		<tr align="right" height="15px" class="style9">
		<th class="left top bottom" align="center" colspan=4>Jumlah</th>
			  <th class="left top bottom">					<?php echo number_format($salokasi);?></th>
			  <th class="left top bottom">				</th>
              <th class="left top bottom">					<?php echo number_format($stargetpokok);?></th>
              <th class="left top bottom">					<?php echo number_format($stargetjasa);?></th>
			  <th class="left top bottom">					<?php echo number_format($sreallalu);?></th>              
              <th class="left top bottom">					<?php echo number_format($sreallalujasa);?></th>
			  <th class="left top bottom">					<?php echo number_format($srealpokok);?></th>
              <th class="left top bottom">					<?php echo number_format($srealjasa);?></th>
              <th class="left top bottom">					<?php echo number_format($sspokok);?></th>
              <th class="left top bottom">					<?php echo number_format($ssjasa);?></th>
              <th class="left top bottom">					<?php echo number_format($ssaldopinjaman);?></th>
              <th class="left top bottom">					<?php $spros=round(@($sspokok/$stargetpokok*100),2); if($spros>=100) {echo "100";}else{echo number_format($spros,2);}?>%</th>
			<th class="left top bottom">					<?php echo number_format($snunggakpokok);?></th>
			<th class="left top  bottom right">				<?php echo number_format($snunggakjasa);?></th>    
		</tr>
		
		<?php }}
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top">					<?php echo number_format($sumalokasi);?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format($sumtargetpokok);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasa);?></td>
			  <td class="left top">					<?php echo number_format($sumreallalu);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumsumjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $pross=round(@($sumsumpokok/$sumtargetpokok*100),2); if($pross>=100) {echo "100";}else{echo number_format($pross,2);}?>%</td>
			  <td class="left top">					<?php echo number_format($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format($sumnunggakjasa);?></td>	
		</tr>
		
	
		<td class="style10 top" colspan="18"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $_GET['y'];?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>PK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title> 