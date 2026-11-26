<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl="$y-$m-$d";
$tgl_akhir	 = date('t', strtotime(date('t', strtotime($tgl))));

if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $kl="LH"; $tgl_kondisi="$y-$m-$d";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $kl="LB"; $tgl_kondisi="$y-$m-$tgl_akhir";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $kl="LT"; $tgl_kondisi="$y-12-31";}else{$laporan="Global";}

?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
-->
</style>
<body onLoad="window.print()">
		<br>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		
		
		?>

      <tr align="center">
        <td colspan="3" class="style6 bottom">
		<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_lpd.gif' style='float:left; width:100; margin-left:15px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="SK Gubernur Bali No.$nomor_bh<br>";}
                
                  echo strtoupper("<b><span class='style6'>LEMBAGA PERKREDITAN DESA (LPD) </span><br> 
				  <span class='style3'>$row[sebutan_desa] $row[nama_desa]</span><br>
				  KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>
				  $bh $row[alamat_desa] Telp. $row[telpon_desa]"; 
                  ?>      
				</div>
		</td>
      </tr>	  

		  <tr>
			<td width="15%" height="20" class="style9 top">Nomor </td>
			<td width="35%" height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "______/$kl/LPD".tgl_rom($tgl)."";?></span></td>
			<td width="50%" colspan="2" rowspan="3" class="style9 top">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="20" class="style9">Tanggal</td>
			<td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_kondisi);?></span></td>
		  </tr>
		  <tr>
		    <td height="20" class="style9">Perihal</td>
		    <td height="20"><span class="style9">:</span><span class="style27"> Laporan <?php echo $laporan;?></span></td>
      </tr>
		  <tr>
			<td height="20" class="style9">&nbsp;</td>
			<td height="20"><span class="style27">&nbsp;&nbsp;<?php echo $jenis;?> <?php echo tgl_indo($tgl);?></span></td>
		    <td colspan="2" class="style9">KEPADA YTH. </td>
		  </tr>
		  <tr>
			<td colspan="2" rowspan="2" class="style9">&nbsp;</td>
		    <td colspan="2" class="style27">
				KEPALA LP LPD KAB. <?php echo $row['nama_kab'];?>
			</td>
		  </tr>
		  <tr>
			<td colspan="2" class="style27">Di
            <p class="align-center">T E M P A T</td>
		  </tr>
		  <tr>
		    <td colspan="5" class="style9 align-justify"><p>&nbsp;</p>
	        <p>&nbsp;</p></td>
      </tr>
		  <tr>
		  <td class="style9 align-justify">&nbsp;</td>
      <td colspan="4" class="style9 align-justify"><p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan laporan perkembangan LPD <?php echo "$row[sebutan_desa] $row[nama_desa]";?> <span class="style27"></span><?php echo $jenis;?> <?php echo tgl_indo($tgl);?> sebagai berikut:</p>

        <p>
		<ol class="style9">
              <li>Surat Pengantar</li>
              <li>Neraca</li>
              <li>Rugi Laba</li>
              <li>Laporan Kegiatan</li>
              <li>Laporan Sektoral</li>
              <li>Neraca Percobaan</li>
              <li>Berita Acara Uang Kas</li>
              <li>Penempatan ABA</li>
		</ol>
		</p>
		<p>Adapun laporan softcopy dapat diakses secara online melalui www.sim.lpd-bali.id dengan memasukkan username dan password sesuai dengan level user dan jabatannya.</p>
		<p>Demikian laporan ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
		<p>&nbsp;</p></td>
  </tr>
  </table>
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  
  <tr>
	<?php
	$lpd=mysql_fetch_array(mysql_query("SELECT * FROM users where lokasi='$lokasi' AND level='1' AND jabatan='1' "));  
	$bp=mysql_fetch_array(mysql_query("SELECT * FROM users where lokasi='$lokasi' AND level='3' AND jabatan='1' ")); 
	?>
      <td width="462" class="style9 align-justify"><p align="center">Mengetahui,<br>
        <?php echo "Badan Pengawas LPD $row[sebutan_desa] $row[nama_desa]"; ?><br>
        Ketua</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
      <p align="center"><span class="style27"><?php echo strtoupper("$bp[namadepan] $bp[namabelakang]");?></span></p></td>
	  <td width="440" class="style9 align-justify"><div align="center">
        <p>Lembaga Perkreditan Desa<br>
          <?php echo "$row[sebutan_desa] $row[nama_desa]"; ?><br>Kepala,</p>
        <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span class="style27"><?php echo strtoupper("$lpd[namadepan] $lpd[namabelakang]");?></span></p>
      </div></td>
  </tr>
  <tr>
	  <td class="style9" colspan="2">
	  Tembusan Disampaikan Kepada Yth:<br>
		1. Arsip
	  </td>
  </tr>
	</table>
	
</body>
<title>Pengantar Laporan <?php echo $laporan;?></title>
      
</body>
