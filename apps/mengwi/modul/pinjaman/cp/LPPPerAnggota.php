<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$idp	=$_GET['idp'];

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE jpp.id=pk.jenis_pp AND sd.id=d.sebutan AND jj.id=pk.jenis_jasa AND sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.id='$idp' "));
	
$jum_angsuran	=@($row['jangka']/$row['sistem']);
$id_pinj		=$row['id'];
$_SESSION['id_pinj']	=$row['id'];
$sistem			=$row['sistem'];
$alokasi			=$row['alokasi'];
$tgl_cair			=$row['tgl_cair'];
$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
$jenis_jasa			=$row['jenis_jasa'];
$nama_jj			=$row['nama_jj'];
$jangka				=$row['jangka'];
$sistem				=$row['sistem'];
$tempo				=@($jangka/$sistem);
$datenow		=date('Y-m-d');
$tottargetpokok	=targetpokok("$datenow-$id_pinj");
$tottargetjasa		=targetjasa("$datenow-$id_pinj");
$sumpokok		=sumpokok("$datenow-$id_pinj");
$sumjasa		=sumjasa("$datenow-$id_pinj");
$totsaldopinjaman	=saldopinjaman("$datenow-$id_pinj");
$totnunggakpokok	=nunggakpokok("$datenow-$id_pinj");
$totnunggakjasa	=nunggakjasa("$datenow-$id_pinj");
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
		<br><br>SILAHKAN PILIH NAMA KELOMPOK TERLEBIH DAHULU :)</p>";
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
		
			echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>$kec[sebutan_kec] $kec[nama_kec] KABUPATEN $kec[nama_kab]</b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
			?>	
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $row['kd_kelompok'];?>-<?php echo $row['id'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="5" class="bottom"><p align="center" class="style6">
		LAPORAN PERKEMBANGAN PINJAMAN PER ANGGOTA<br>
		<b><?php echo strtoupper("KELOMPOK $row[nama_jpp] $row[nama_kelompok] $row[sebutan_desa] $row[nama_desa]");?></b></p></td>
      </tr>
      <tr>
        <td width="15%" rowspan="7">
			&nbsp;
		</td>
        <td width="15%" height="15" class="style9">ID. Kelompok</td>
        <td width="27%" height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['kd_kelompok']);?></span></td>
        <td width="15%" height="15" class="style9">Loan ID</td>
        <td width="28%" height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_jpp]-$row[id]"; ?></span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Kelompok</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['nama_kelompok']);?></span></td>
        <td height="15" class="style9">Nomor SPK</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[spk_no]"; ?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Alamat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[alamat_kelompok]";?></span></td>
        <td height="15" class="style9"> Tanggal Cair </td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($row['tgl_cair']); ?></span></td>
      </tr>
	  <tr>
        <td height="15" class="style9"><?php echo "$row[sebutan_desa]";?></td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_desa]";?></span></td>
        <td height="15" class="style9">Alokasi Pinjaman</td>
        <td height="15"><span class="style9">:</span><span class="style27">  Rp. <?php echo number_format($row['alokasi']);?>,-</span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Telpon/SMS</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[telpon]";?></span></td>
        <td height="15" class="style9">Prosentase, Jenis Jasa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa %/bulan, $row[nama_jj]";?> </span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Ketua</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[ketua]";?></span></td>
        <td height="15" class="style9">Sistem Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_sistem] ($row[jangka] bulan)";?> </span></td>
      </tr>
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<thead>
	<tr>
	    <th width="2%" height="30" class="style9 all" rowspan="2">NO</th>
	    <th width="20%" class="style9 top bottom right" rowspan="2">IDENTITAS ANGGOTA</th>
	    <th width="7%" class="style9 top bottom right" rowspan="2">ALOKASI</th>
	    <th class="style9 top bottom right" colspan="2">TARGET</th>
	    <th class="style9 top bottom right" colspan="2">REALISASI</th>
	    <th width="7%" class="style9 top bottom right" rowspan="2">SALDO PINJAMAN<br>POKOK</th>
	    <th class="style9 right top bottom" colspan="2">TUNGGAKAN</th>
    </tr>
	<tr>
	    <th width="7%" class="style9 right bottom" >POKOK</th>
        <th width="7%" class="style9 right bottom">JASA</th>
		<th width="7%" class="style9 right bottom" >POKOK</th>
        <th width="7%" class="style9 right bottom">JASA</th>
		<th width="7%" class="style9 right bottom" >POKOK</th>
        <th width="7%" class="style9 right bottom">JASA</th>
	</tr>
	</thead>
	
	<tbody>
		
		
		<!-- Menampilkan data pada tabel -->
<?php
		$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_pinkel='$id_pinj'; ");
		$no=0;
			while($row=mysql_fetch_array($view)){
				$no=$no+1;
				$tgl_kondisi=date('Y-m-d');
				$id_pinj_i	=$row['id'];
				$alokasi=alokasi("$id_pinj_i");
				$targetpokok=targetpokok("$tgl_kondisi-$id_pinj_i");
				$targetjasa=targetjasa("$tgl_kondisi-$id_pinj_i");
				$kom_pokok	=kompokok("$id_pinj_i");
				$kom_jasa	=komjasa("$id_pinj_i");
				$saldo_pokok_anggota=saldo_pokok_anggota("$id_pinj_i");
				$tungg_pokok_anggota=tungg_pokok_anggota("$tgl_kondisi-$id_pinj_i");
				$tungg_jasa_anggota=tungg_jasa_anggota("$tgl_kondisi-$id_pinj_i");
																						
	?>
            <tr>			  
			  <td class="style9 left bottom right align-center" height="30"><?php echo $no;?></td>
			  <td class="style9 bottom right"><?php echo "$row[nik] ".strtoupper($row['namadepan'])."";?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format(alokasi($row['id']),0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($targetpokok,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($targetjasa,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($kom_pokok,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($kom_jasa,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($saldo_pokok_anggota,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($tungg_pokok_anggota,0,',','.');?></td>
			  <td class="style9 bottom right align-right"><?php echo number_format($tungg_jasa_anggota,0,',','.');?></td>
            </tr>
<?php 

$sum_alokasi	=$sum_alokasi+$alokasi;
$sum_targetpokok=$sum_targetpokok+$targetpokok;
$sum_targetjasa=$sum_targetjasa+$targetjasa;
$sum_kom_pokok=$sum_kom_pokok+$kom_pokok;
$sum_kom_jasa=$sum_kom_jasa+$kom_jasa;
$sum_saldo_pokok_anggota=$sum_saldo_pokok_anggota+$saldo_pokok_anggota;
$sum_tungg_pokok_anggota=$sum_tungg_pokok_anggota+$tungg_pokok_anggota;
$sum_tungg_jasa_anggota=$sum_tungg_jasa_anggota+$tungg_jasa_anggota;

} ?>
		
		<!-- Menampilkan Jumlah Total pada tabel -->
		 <tr>	  
          <th height="36px" colspan="2" class="style27 left bottom right align-center">REKAPITULASI</th>
              <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_alokasi); ?></th>
              <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_targetpokok); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_targetjasa); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_kom_pokok); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_kom_jasa); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_saldo_pokok_anggota); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_tungg_pokok_anggota); ?></th>
			  <th width="7%" class="style27 bottom right align-right"><?php echo number_format($sum_tungg_jasa_anggota); ?></th>
        </tr> 
	</tbody>
	
	<?php
}
	?>           
</body>
<title>Laporan Perkembangan Pinjaman by Anggota</title>