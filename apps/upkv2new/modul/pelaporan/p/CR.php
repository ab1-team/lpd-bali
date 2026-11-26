<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];





		$nod=0;
		$dataa=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		while($ra=mysql_fetch_array($dataa)){
		    
		$viewa=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' ORDER BY k.kd_kelompok ASC"); 
		while($rowa=mysql_fetch_array($viewa)){
		    
		}
		}
		$nod=0;
		$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$nod=$nod+1;
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
		<?php
		$view=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		$sumsaldopinjaman	=0;
		$sumnunggakpokok	=0;
		$sumkolek1			=0;
		$sumkolek2			=0;
		$sumkolek3			=0;
		$sumkolek4			=0;
		$sumkolek5			=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp);
		$kolek1			=kolek1($tgl_kondisi."-".$idp);
		$kolek2			=kolek2($tgl_kondisi."-".$idp);
		$kolek3			=kolek3($tgl_kondisi."-".$idp);
		$kolek4			=kolek4($tgl_kondisi."-".$idp);
		$kolek5			=kolek5($tgl_kondisi."-".$idp);
		
		$jangka			=jangka($idp);
		
		if($jum_nunggak>0 and $jum_nunggak<$jangka){$sig_nunggak=floor($jum_nunggak)."+";}elseif($jum_nunggak>$jangka){$sig_nunggak=$jangka."+";}else{$sig_nunggak=$jum_nunggak;}
		
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumkolek1			=$sumkolek1+$kolek1;
		$sumkolek2			=$sumkolek2+$kolek2;
		$sumkolek3			=$sumkolek3+$kolek3;
		$sumkolek4			=$sumkolek4+$kolek4;
		$sumkolek5			=$sumkolek5+$kolek5;
		$sumsaldopinjaman1	=$sumsaldopinjaman1+$saldopinjaman;
		$sumnunggakpokok1	=$sumnunggakpokok1+$nunggakpokok;
		$sumkolek11			=$sumkolek11+$kolek1;
		$sumkolek21			=$sumkolek21+$kolek2;
		$sumkolek31			=$sumkolek31+$kolek3;
		$sumkolek41			=$sumkolek41+$kolek4;
		$sumkolek51			=$sumkolek51+$kolek5;
		}
		} 


$sumkolek1	=$sumkolek11;
$sumkolek2	=$sumkolek21;
$sumkolek3	=$sumkolek31;
$sumkolek4	=$sumkolek41;
$sumkolek5	=$sumkolek51;

if ($_SESSION['lokasi']=='96') { //khusus KEBUMEN
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*15/100;
$cr4		=$sumkolek4*25/100;
$cr5		=$sumkolek5*100/100;
} elseif ($_SESSION['lokasi']=='72') { //khusus KECAMATAN SERIRIT
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*25/100;
$cr4		=$sumkolek4*50/100;
$cr5		=$sumkolek5*100/100;
} else { 
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*25/100;
$cr4		=$sumkolek4*50/100;
$cr5		=$sumkolek5*100/100;
}
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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="4" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. CR-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="4" class="style6 bottom"><br>LAPORAN CADANGAN RESIKO <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
				<td class="style6 bottom align-right"><br><?php echo $jpp;?></td>
			</tr>
			<tr align="center" height="40px">
              <th width="2" class="left bottom top">NO</th>
              <th width="20" class="left bottom top">TINGKAT KOLEKTIBILITAS</th>
              <th width="63" class="left bottom top">CADANGAN RESIKO PENGHAPUSAN</th>
              <th width="91" class="left bottom top">SALDO PINJAMAN</th>
              <th width="86" class="all">JUMLAH CADANGAN RESIKO</th>
			</tr>
			<tr align="center" height="15px" style="background:rgba(0,0,0, 0.4);">
              <td class="left bottom">1</td>
              <td class="left bottom">2</td>
              <td class="left bottom">3</td>
              <td class="left bottom">4</td>
              <td class="left bottom right">5 = 3 * 4</td>
            </tr>
			<tr>
              <td class="left bottom" height="20px" align="center">1</td>
              <td class="left bottom">KOLEKTIBILITAS I</td>
              <td class="left bottom" align="center">1 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek1);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr1);?></td>
            </tr>
			<tr>
			<td class="left bottom" height="20px" align="center">2</td>
              <td class="left bottom">KOLEKTIBILITAS II</td>
              <td class="left bottom" align="center">10 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek2);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr2);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">3</td>
              <td class="left bottom">KOLEKTIBILITAS III</td>
              <td class="left bottom" align="center"><?php if ($_SESSION['lokasi']=='96') {echo "15 %";}else{echo "25 %";} ?></td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek3);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr3);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">4</td>
              <td class="left bottom">KOLEKTIBILITAS IV</td>
              <td class="left bottom" align="center"><?php if ($_SESSION['lokasi']=='96') {echo "25 %";}else{echo "50 %";} ?></td>
              <td class="left bottom"  align="right"><?php echo number_format($sumkolek4);?></td>
              <td class="left bottom right"  align="right"><?php echo number_format($cr4);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">5</td>
			  <td class="left bottom">KOLEKTIBILITAS V</td>
			  <td class="left bottom" align="center">100 %</td>
			  <td class="left bottom" align="right"><?php echo number_format($sumkolek5);?></td>
			  <td class="left bottom right" align="right"><?php echo number_format($cr5);?></td>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5);?></th>
			  <th class="left bottom right" align="right"><?php echo number_format($cr1+$cr2+$cr3+$cr4+$cr5);?></th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">PERSENTASE CADANGAN RESIKO</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format(($cr1+$cr2+$cr3+$cr4+$cr5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">Non-Performing Loan (NPL) Gross <br> [K3+K4+K5 / Saldo * 100%]</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format(($sumkolek3+$sumkolek4+$sumkolek5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">Non-Performing Loan (NPL) Nett <br> [K5 / Saldo * 100%]</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format(($sumkolek5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
	</table>
	
<?php include "tanda_tangan.php"; ?> 

</body>
<title>CR<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>