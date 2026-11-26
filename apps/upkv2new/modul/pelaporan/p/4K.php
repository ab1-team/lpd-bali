<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$lokasi				=$_SESSION[lokasi];

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
$thn_kondisi		="$y-01-01";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];
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
		<td height="20" colspan="7" class="bottom">
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
		<td height="20" colspan="3" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. KK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="10" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP KELOMPOK<br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">KELOMPOK</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="3%">&Sigma;</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Menunggak 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Menunggak 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Menunggak 5-6</th>
              <th class="left bottom right" width="10%">KOLEK V <br>Menunggak &gt; 6</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
		<tr>
			<td class="style27 left right top" colspan="10"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
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
		    
$jum++;
			$ra=mysql_fetch_array(mysql_query( "SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND jatuh_tempo<='$tgl_kondisi' ORDER BY jatuh_tempo DESC"));
			
			$penguranganp =0;
			$penguranganj =0;
			if (!($ra)) {// jika $ra kosong (angsuran ke 0)
			    $ra=mysql_fetch_array(mysql_query( "SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND jatuh_tempo<='$tgl2' ORDER BY jatuh_tempo DESC"));
			    if (!($ra)) {// jika $ra kosong (angsuran ke 0)
			    	$ra = array("wajib_pokok"=>"0", "wajib_jasa"=>"0", "target_pokok"=>"0", "target_jasa"=>"0", "realisasi_pokok"=>"0", "realisasi_jasa"=>"0", "sum_pokok"=>"0", "sum_jasa"=>"0", "saldo_pokok"=>"$row[alokasi]", "saldo_jasa"=>($row['alokasi']*$row['pros_jasa']), "tunggakan_pokok"=>"0", "tunggakan_jasa"=>"0");
		    	}
		    	$penguranganp = $ra['wajib_pokok'];
			    $penguranganj = $ra['wajib_jasa'];
			}
			$real=mysql_fetch_array(mysql_query( "SELECT * FROM real_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND tgl_transaksi<='$tgl_kondisi' ORDER BY id DESC"));
			if (!($real)) {// jika $ra kosong (angsuran ke 0)
			    	$real = array("wajib_pokok"=>"0", "wajib_jasa"=>"0", "target_pokok"=>"0", "target_jasa"=>"0", "realisasi_pokok"=>"0", "realisasi_jasa"=>"0", "sum_pokok"=>"0", "sum_jasa"=>"0", "saldo_pokok"=>"$row[alokasi]", "saldo_jasa"=>($row['alokasi']*$row['pros_jasa']), "tunggakan_pokok"=>"0", "tunggakan_jasa"=>"0");
		    }
			$noo=$noo+1;
			
			$nunggakpokok   = $ra['target_pokok']-$real['sum_pokok']-$penguranganp;
			if($nunggakpokok<0){
			    $nunggakpokok=0;
			}
			$nunggakjasa    = $ra['target_jasa']-$real['sum_jasa']-$penguranganj;
			if($nunggakjasa<0){
			    $nunggakjasa=0;
			}
			
			
            $date = $tgl_kondisi;
            $timeStart = strtotime($row['tgl_cair']);
            $timeEnd = strtotime("$date");
            
            
            
			$mkon   =substr($tgl_kondisi,5,2);
			$ykon   =substr($tgl_kondisi,0,4);
			$mc     =substr($row['tgl_cair'],5,2);
			$yc     =substr($row['tgl_cair'],0,4);
            $sy=($ykon-$yc)*12;
            $sm=$mkon-$mc;
            
            if($nunggakpokok==0){
			    $skor2=0;
			    $ra2['target_pokok']=$tgl_kondisi;
			}else{
			    $ra2=mysql_fetch_array(mysql_query( "SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND angsuran_ke = 2"));
			    if($nunggakpokok<=$ra2['target_pokok']){
			        $skor2=1;
    			}else{
    			    $ra2=mysql_fetch_array(mysql_query( "SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND angsuran_ke = 4"));
    			    if($nunggakpokok<=$ra2['target_pokok']){
    			        $skor2=2;
    			    }else{
        			    $ra2=mysql_fetch_array(mysql_query( "SELECT * FROM rencana_angsuran_$_SESSION[lokasi] WHERE loan_id=$row[id] AND angsuran_ke = 6"));
        			    if($nunggakpokok<=$ra2['target_pokok']){
        			        $skor2=3;
        			    }else{
        			        $skor2=4;
        			    }
        			}
    			}
			}
			
			
			
			if($ra['angsuran_ke']>=$row['jangka']){
			// tanggal awal
            $tanggal_awal = $ra['jatuh_tempo'];
            
            // tanggal akhir
            $tanggal_akhir = $tgl_kondisi;
            
            // menghitung selisih bulan
            $selisih_bulan = (date("Y", strtotime($tanggal_akhir)) - date("Y", strtotime($tanggal_awal))) * 12 + (date("m", strtotime($tanggal_akhir)) - date("m", strtotime($tanggal_awal)));
            
            $skor=(($skor2*2)+$selisih_bulan)/2;
            $pager ="$row[jangka]+";
			}else{
			    $skor=$skor2;
			    $pager =ceil($nunggakpokok/$ra['wajib_pokok']);
			}
			
			
			
			if($row['sistem_angsuran']!=1)
			{
			    $skor=$nunggakpokok/(($row['alokasi']/$row['jangka'])*2);
			}
            if($skor<=0){
			    $kolek1 = $real['saldo_pokok'];
			    $kolek2 = 0;
			    $kolek3 = 0;
			    $kolek4 = 0;
			    $kolek5 = 0;
			}elseif($skor<=1){
			    $kolek1 = 0;
			    $kolek2 = $real['saldo_pokok'];
			    $kolek3 = 0;
			    $kolek4 = 0;
			    $kolek5 = 0;
			}elseif($skor<=2){
			    $kolek1 = 0;
			    $kolek2 = 0;
			    $kolek3 = $real['saldo_pokok'];
			    $kolek4 = 0;
			    $kolek5 = 0;
			}elseif($skor<=3){
			    $kolek1 = 0;
			    $kolek2 = 0;
			    $kolek3 = 0;
			    $kolek4 = $real['saldo_pokok'];
			    $kolek5 = 0;
			}else{
			    $kolek1 = 0;
			    $kolek2 = 0;
			    $kolek3 = 0;
			    $kolek4 = 0;
			    $kolek5 = $real['saldo_pokok'];
			}
            
            
            if($row['jangka']>12){
                    if($skor<=0){
    			    $kolek1 = $real['saldo_pokok'];
    			    $kolek2 = 0;
    			    $kolek3 = 0;
    			    $kolek4 = 0;
    			    $kolek5 = 0;
    			}elseif($skor<=1){
    			    $kolek1 = 0;
    			    $kolek2 = $real['saldo_pokok'];
    			    $kolek3 = 0;
    			    $kolek4 = 0;
    			    $kolek5 = 0;
    			}elseif($skor<=3){
    			    $kolek1 = 0;
    			    $kolek2 = 0;
    			    $kolek3 = $real['saldo_pokok'];
    			    $kolek4 = 0;
    			    $kolek5 = 0;
    			}elseif($skor<=4){
    			    $kolek1 = 0;
    			    $kolek2 = 0;
    			    $kolek3 = 0;
    			    $kolek4 = $real['saldo_pokok'];
    			    $kolek5 = 0;
    			}else{
    			    $kolek1 = 0;
    			    $kolek2 = 0;
    			    $kolek3 = 0;
    			    $kolek4 = 0;
    			    $kolek5 = $real['saldo_pokok'];
    			}
            }
            
            
            
            
            
			
			
			
			
			//Bold Font for Field Name
			//Bold Font for Field Name
			
		?>
		<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] - $row[id]"; ?></td>
			  <td class="left top">					<?php echo number_format($real['saldo_pokok']);?></td>
              <td class="left top">					<?php echo number_format($nunggakpokok);?></td>
              <td class="left top align-center">	<?php echo $pager;?></td>
              <td class="left top">					<?php echo number_format($kolek1);?></td>
              <td class="left top">					<?php echo number_format($kolek2);?></td>
              <td class="left top">					<?php echo number_format($kolek3);?></td>
              <td class="left top">					<?php echo number_format($kolek4);?></td>
              <td class="left top right">			<?php echo number_format($kolek5);?></td>
		</tr>
		<?php
		$sumsaldopinjaman	=$sumsaldopinjaman+$real['saldo_pokok'];
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumkolek1			=$sumkolek1+$kolek1;
		$sumkolek2			=$sumkolek2+$kolek2;
		$sumkolek3			=$sumkolek3+$kolek3;
		$sumkolek4			=$sumkolek4+$kolek4;
		$sumkolek5			=$sumkolek5+$kolek5;
		$sumsaldopinjaman1	=$sumsaldopinjaman1+$real['saldo_pokok'];
		$sumnunggakpokok1	=$sumnunggakpokok1+$nunggakpokok;
		$sumkolek11			=$sumkolek11+$kolek1;
		$sumkolek21			=$sumkolek21+$kolek2;
		$sumkolek31			=$sumkolek31+$kolek3;
		$sumkolek41			=$sumkolek41+$kolek4;
		$sumkolek51			=$sumkolek51+$kolek5;
		
		
		
		
		}
		?>
		<tr align="right" height="15px" class="style27">
			<td class="style27 bottom left top align-center" colspan="2"><?php echo "Jumlah ".strtoupper($r['nama_desa']);?></td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok);?></td>	
			  <td class="left top bottom"></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek1);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek2);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek3);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek4);?></td>			
			  <td class="all">			                    <?php echo number_format($sumkolek5);?></td>	
		</tr>
		<?php
		} 
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">J U  M L A H</td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman1);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok1);?></td>	
			  <td class="left top bottom"></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek11);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek21);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek31);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek41);?></td>			
			  <td class="all">			                    <?php echo number_format($sumkolek51);?></td>			
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 		
	          
</body>
<title>KK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>