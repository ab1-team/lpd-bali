<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$idp	=$_GET['idp'];

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE jpp.id=pi.jenis_pp AND sd.id=d.sebutan AND jj.id=pi.jenis_jasa AND sa.id=pi.sistem_angsuran AND a.desa=d.id and a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' AND pi.status='A' AND pi.id= '$idp' "));
	
$jum_angsuran	=@($row['jangka']/$row['sistem']);
$id_pinj		=$row['id'];
$_SESSION['id_pinj']	=$row['id'];
$sistem			=$row['sistem'];
$alokasi			=$row['alokasi'];
$tgl_cair           = $row['tgl_cair'];
$pros_jasa			=$row['pros_jasa'];
$jenis_jasa			=$row['jenis_jasa'];
$nama_jj			=$row['nama_jj'];
$jangka				=$row['jangka'];
$sistem				=$row['sistem'];
$tempo				=@($jangka/$sistem);
$datenow		=date('Y-m-d');
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
.green {color:green; }
.red {color:red; }
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
			<td height="20" colspan="3" class="bottom">
				<?php
				$logo=$kec['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$kec ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>KECAMATAN $kec[nama_kec] KABUPATEN $kec[nama_kab]</b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
			?>	
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $row['nik'];?>-<?php echo $row['id'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="5" class="bottom"><p align="center" class="style6">
		LAPORAN PERKEMBANGAN PINJAMAN INDIVIDU<br>
		NAMA PEMANFAAT : <b><?php echo strtoupper($row['namadepan']);?></b></p></td>
      </tr>
      <tr>
        <td width="15%" rowspan="6">
		<?php
										$foto=$row['foto'];
										if (empty($foto)) {
											echo "<img  src='../../../img/avatar.png' alt='...' style='width:110px; margin-left:25px;' >";
											}else{
											echo "<img  alt='' src='$foto' style='width:110px; margin-left:25px;'>";
											}
										?>
		</td>
        <td width="15%" height="15" class="style9">NIK</td>
        <td width="27%" height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['nik']);?></span></td>
        <td width="15%" height="15" class="style9">Loan ID</td>
        <td width="28%" height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_jpp]-$row[id]"; ?></span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Pemanfaat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['namadepan']);?></span></td>
        <td height="15" class="style9">Tanggal Cair</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($row['tgl_cair']); ?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Alamat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[alamat]";?></span></td>
        <td height="15" class="style9"> Alokasi Pinjaman </td>
        <td height="15"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($row['alokasi']);?>,-</span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Desa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_desa]";?></span></td>
        <td height="15" class="style9">Prosentase, Jenis Jasa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[pros_jasa] %/bulan, $row[nama_jj]";?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Telpon</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[hp]";?></span></td>
        <td height="15" class="style9">Sistem Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_sistem] ($row[jangka] bulan)";?> </span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Penjamin</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[penjamin]";?></span></td>
        <td height="15" class="style9">Jumlah Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "Rp. ".number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj)*$sistem))." x $jum_angsuran";?> </span></td>
      </tr> 
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<thead>
	<tr>
	    <th width="4%" height="30" class="style9 all" rowspan="2">KE</th>
	    <th width="10%" class="style9 top bottom right" rowspan="2">BULAN</th>
	    <th class="style9 top bottom right" colspan="2">TARGET</th>
	    <th class="style9 top bottom right" colspan="2">REALISASI</th>
	    <th width="10%" class="style9 top bottom right" rowspan="2">SALDO PINJAMAN</th>
	    <th class="style9 right top bottom" colspan="2">TUNGGAKAN</th>
    </tr>
	<tr>
	    <th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
		<th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
		<th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
	</tr>
	</thead>
	
	<tbody>
		
		
		<!-- Menampilkan data pada tabel -->
		<?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			      
				$tanggal  			 = substr($tgl_cair,8,2);
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			    $tanggal_kondisi = "$th-$bln-$tanggal";
			    $tgl_akhir_kon =  date('Y-m-t', strtotime($tanggal_kondisi));
			    $date	            ="$th-$bln";
				$datenow            =date('Y-m');
				$bulan_tampil       =strtoupper(tgl_indo($date));
			 	$targetpokok        =number_format(targetpokok("$th-$bln-$tanggal-$id_pinj"));	
			    $targetjasa         =number_format(targetjasa("$th-$bln-$tanggal-$id_pinj"));	
			    $realisasiinipokok  =number_format(realisasiinipokok("$th-$bln-$tanggal-M-$id_pinj"));
	    		$realisasiinijasa   =number_format(realisasiinijasa("$th-$bln-$tanggal-M-$id_pinj"));
		    	$saldopinjaman      =number_format(saldopinjaman("$tgl_akhir_kon-$id_pinj"));
	    		$nunggakpokok       =number_format(nunggakpokok("$tgl_akhir_kon-$id_pinj"));
	    		$nunggakjasa        =number_format(nunggakjasa("$tgl_akhir_kon-$id_pinj"));
	    		
	    		
                  			if($date == $datenow) {
			?>
            <tr>
			  <td class="style9 left right  align-center">  <?php echo "<div class='green style27'>$noo</div>"; ?></td>
			  <td class="style9  right  align-left">        <?php echo "<div class='green style27'>$bulan_tampil</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$targetpokok</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$targetjasa</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$realisasiinipokok</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$realisasiinijasa</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$saldopinjaman</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$nunggakpokok</div>"; ?></td>
			  <td class="style9 right   align-right">      <?php echo "<div class='green style27'>$nunggakjasa</div>"; ?></td>
            </tr>
            
                <?php
                        $tottargetpokok	    =$targetpokok;
                        $tottargetjasa		=$targetjasa;
                        $sumpokok		    =$realisasiinipokok;
                        $sumjasa		    =$realisasiinijasa;
                        $totsaldopinjaman	=$saldopinjaman;
                        $totnunggakpokok	=$nunggakpokok;
                        $totnunggakjasa	    =$nunggakjasa; 
                  			}else{
                ?>
            <tr>
			  <td class="style9 left right  align-center">  <?php echo $noo; ?></td>
			  <td class="style9  right  align-left">        <?php echo $bulan_tampil; ?></td>
			  <td class="style9 right   align-right">      <?php echo $targetpokok; ?></td>
			  <td class="style9 right   align-right">      <?php echo $targetjasa; ?></td>
			  <td class="style9 right   align-right">      <?php echo $realisasiinipokok; ?></td>
			  <td class="style9 right   align-right">      <?php echo $realisasiinijasa; ?></td>
			  <td class="style9 right   align-right">      <?php echo $saldopinjaman; ?></td>
			  <td class="style9 right   align-right">      <?php echo $nunggakpokok; ?></td>
			  <td class="style9 right   align-right">      <?php echo $nunggakjasa; ?></td>
            </tr>
                <?php 
                
                }}
                
?> 
		    <tr>			  
			  <td class="style9 left right  align-center"> > > </td>	  
			  <td class="style9  right  align-center"> > > > > ></td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>	  
			  <td class="style9 right   align-center">-</td>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
		 <tr>	  
          <th width="2%" height="28px" colspan="2" class="style27 left top bottom right align-right">REKAPITULASI</th>
              <th width="10%" class="style27 bottom top right align-right"><?php echo ($tottargetpokok); ?></th>
              <th width="10%" class="style27 bottom top right align-right"><?php echo ($tottargetjasa); ?></th>
			  <th width="10%" class="style27 bottom top right align-right"><?php echo ($sumpokok); ?></th>
			  <th width="10%" class="style27 bottom top right align-right"><?php echo ($sumjasa); ?></th>
			  <th width="10%" class="style27 bottom top right align-right"><?php echo ($totsaldopinjaman); ?></th>
			  <th width="10%" class="style27 bottom top right align-right"><?php echo ($totnunggakpokok); ?></th>
			  <th width="10%" class="style27 bottom top right align-right"><?php echo ($totnunggakjasa); ?></th>
        </tr> 
	</tbody>
	
	<?php
}
	?>           
</body>
<title>Laporan Perkembangan Pinajaman Individu | By Name</title>