<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=2;
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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

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
	  <?php
$lancar     = 0;
$diragukan  = 0;
$macet      = 0;
      
        
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d, lkm l WHERE c.kd_kec=d.kd_kec AND c.id=l.lokasi AND l.lokasi='$lokasi' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
$view=mysql_query("SELECT pa.id, 
								  pa.alokasi, 
								  a.namadepan, 
								  pa.tgl_cair, 
								  pa.tgl_lunas, 
								  pa.pros_jasa,
								  pa.`status`, 
								  pa.jangka, 
								  sa.sistem, 
								  sa.nama_sistem, 
								  a.nik	
								  
		FROM 
			anggota_$_SESSION[kd_kab] a, 
			sistem_angsuran sa, 
			pinjaman_anggota_$_SESSION[kd_kab] pa 
		WHERE 
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_cair <= '$tgl_kondisi' AND pa.jenis_pinjaman='I' AND pa.`status`='A'  OR
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_cair <= '$tgl_kondisi' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.jenis_pinjaman='I' AND pa.`status`='L' OR
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_cair <= '$tgl_kondisi' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.jenis_pinjaman='I' AND pa.`status`='R' OR
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_cair <= '$tgl_kondisi' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.jenis_pinjaman='I' AND pa.`status`='H'
		ORDER BY a.nik ASC"); 
		$jkel=mysql_num_rows($view);
		?>
		<?php
		
		while($row=mysql_fetch_array($view)){
		$idp	=$row['id'];
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		if($saldopinjaman==0){
		    $jum_nunggak	=0; 
		}else{
		        $jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp); 
		    if($jum_nunggak<=0){
		        $jum_nunggak	=0; 
		    }
		}
		
			  if($jum_nunggak<=3){
			      $lancar=$lancar+$saldopinjaman;
			  }elseif($jum_nunggak<=5){
			      $diragukan=$diragukan+$saldopinjaman;
			  }else{
			      $macet=$macet+$saldopinjaman;
			  }
			  
			  ?>
			  
			  </td> 

	<?php
		}}
        
        
		$kdata=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d, lkm l WHERE c.kd_kec=d.kd_kec AND c.id=l.lokasi AND l.lokasi='$lokasi' ORDER BY d.id ASC");
		$kno=0;
		while($kr=mysql_fetch_array($kdata)){
		$kidd=$kr['id'];
$kview=mysql_query("SELECT pk.id, 
								  pk.alokasi, 
								  k.nama_kelompok, 
								  pk.tgl_cair, 
								  pk.tgl_lunas, 
								  pk.pros_jasa,
								  pk.`status`, 
								  pk.jangka, 
								  sa.sistem, 
								  sa.nama_sistem, 
								  k.kd_kelompok	
								  
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$kr[id]' AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A'  OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$kr[id]' AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$kr[id]' AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$kr[id]' AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H'
		ORDER BY k.kd_kelompok ASC"); 
		$kjkel=mysql_num_rows($kview);
		?>
		<?php
		
		while($krow=mysql_fetch_array($kview)){
		$kidp	=$krow['id'];
		$ksaldopinjaman	=ksaldopinjaman($tgl_kondisi."-".$kidp);
		if($ksaldopinjaman==0){
		    $kjum_nunggak	=0; 
		}else{
		        $kjum_nunggak	=kjum_nunggak($tgl_kondisi."-".$kidp); 
		    if($kjum_nunggak<=0){
		        $kjum_nunggak	=0; 
		    }
		}
		
			  if($kjum_nunggak<=3){
			      $lancar=$lancar+$ksaldopinjaman;
			  }elseif($kjum_nunggak<=5){
			      $diragukan=$diragukan+$ksaldopinjaman;
			  }else{
			      $macet=$macet+$ksaldopinjaman;
			  }
			  
			  ?>
			  
			  </td> 

	<?php
		}}
		?>



<?php
$totals = $lancar+$diragukan+$macet;
$npl = ($diragukan+$macet)/$totals*100;
?>














<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="5" class="bottom">
					<?php
			    $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab  AND c.id=l.lokasi AND l.lokasi='$lokasi'")); 
											$alamat_lkm =$row ['alamat'];
											$exp	    = explode("#", $alamat_lkm);    
	                                        $alamat1    = $exp[0];
			                                $desa1      = $exp[1];
			                                $kodepos1   = $exp[2];
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$ijin_usaha	=$row ['ijin_usaha'];
			if (empty($ijin_usaha)) {$ijin="";}else{$ijin="Badan Hukum No.$ijin_usaha<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[jenis_lkm] LKM $row[nama_lkm_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$ijin $alamat1 $desa1 $kodepos1 Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. CRK-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td height="10" colspan="6" class="style6 bottom" align="center" ><br>CADANGAN PENYISIHAN PENGHAPUSAN KREDIT <br><br></td>
				
				<tr>
            <td colspan="2"  class="style9">NAMA LKM</td>
            <td colspan="2"   class="style9">: <?php echo "$row[nama_lkm_long]" ;?></td>
	    </tr>
	     <tr>
            <td colspan="2"  class="style9">SANDI LKM</td>
            <td colspan="2"  class="style9">: <?php echo "$row[sandi_lkm]" ;?></td>
	     </tr>
	     <tr>
            <td colspan="2"  class="style9 bottom">PERIODE LAPORAN</td>
            <td colspan="4"  class="style9 bottom">: <?php echo tgl_indo($tgl_kondisi) ;?></td>
	        </tr>
			</tr>
			<tr align="center" height="100%">
              <th width="2%" class="left bottom top">NO</th>
              <th width="20%" class="left bottom top">TINGKAT KOLEKTIBILITAS</th>
              <th width="5%%" class="left bottom top">%</th>
              <th width="30%" class="left bottom top">SALDO PINJAMAN</th>
              <th width="20%" class="left bottom top">BEBAN PENYISIHAN PENGHAPUSAN PINJAMAN</th>
              <th width="20%" class="left right bottom top">NPL</th>
			</tr>
			<tr align="center" height="100%" style="background:rgba(0,0,0, 0.4);">
              <td class="left bottom">a</td>
              <td class="left bottom">b</td>
              <td class="left bottom">c</td>
              <td class="left bottom">d</td>
              <td class="left bottom">e = c * d</td>
              <td class="left bottom right">f=(2+3)/Saldo</td>
            </tr>
			<tr>
              <td class="left bottom" height="100%" align="center">1</td>
              <td class="left bottom">Lancar</td>
              <td class="left bottom" align="center">0 %</td>
              <td class="left bottom" align="right"><?php echo number_format($lancar);?></td>
              <td class="left bottom" align="right"><?php echo number_format(0);?></td>
              <th class="left bottom right" align="center" rowspan=4><?php echo number_format($npl,2);?>%</td>
            </tr>
			<tr>
			<td class="left bottom" height="100%" align="center">2</td>
              <td class="left bottom">Diragukan</td>
              <td class="left bottom" align="center">50 %</td>
              <td class="left bottom" align="right"><?php echo number_format($diragukan);?></td>
              <td class="left bottom" align="right"><?php echo number_format($diragukan/2);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="100%" align="center">3</td>
              <td class="left bottom">Macet</td>
              <td class="left bottom" align="center">100%</td>
              <td class="left bottom" align="right"><?php echo number_format($macet);?></td>
              <td class="left bottom" align="right"><?php echo number_format($macet);?></td>
			</tr>
			
			<tr align="center" height="100%">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format($totals);?></th>
			  <th class="left bottom" align="right"><?php echo number_format(($diragukan/2)+$macet);?></th>
		  </tr>
			
	</table>
	
<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>
</body>
<title>C2<?php echo tgl_indo($tgl);?></title> 