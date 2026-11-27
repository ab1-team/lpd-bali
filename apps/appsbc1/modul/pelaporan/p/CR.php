<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=1;
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=1;
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));


$sumkolek1	=sumkolek1("$tgl_kondisi-$idf");
$sumkolek2	=sumkolek2("$tgl_kondisi-$idf");
$sumkolek3	=sumkolek3("$tgl_kondisi-$idf");
$sumkolek4	=sumkolek4("$tgl_kondisi-$idf");

$cr1		=$sumkolek1*0.5/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*50/100;
$cr4		=$sumkolek4*100/100;
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
					<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. CR-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="5" class="style6 bottom align-center"><br>LAPORAN CADANGAN RESIKO <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?><br><br></td>

			</tr>
			<tr align="center" height="40px">
              <th width="2" class="left bottom top">NO</th>
              <th width="20" class="left bottom top">TINGKAT KOLEKTIBILITAS</th>
              <th width="63" class="left bottom top">CADANGAN RESIKO PENGHAPUSAN</th>
              <th width="91" class="left bottom top">SALDO PINJAMAN/ TOTAL RESIKO</th>
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
              <td class="left bottom" height="30px" align="center">1</td>
              <td class="left bottom">LANCAR</td>
              <td class="left bottom" align="center">0.5 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek1);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr1);?></td>
            </tr>
			<tr>
			<td class="left bottom" height="30px" align="center">2</td>
              <td class="left bottom">KURANG LANCAR</td>
              <td class="left bottom" align="center">10 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek2);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr2);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="30px" align="center">3</td>
              <td class="left bottom">DIRAGUKAN</td>
              <td class="left bottom" align="center">50 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolek3);?></td>
              <td class="left bottom right" align="right"><?php echo number_format($cr3);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="30px" align="center">4</td>
              <td class="left bottom">MACET</td>
              <td class="left bottom" align="center">100 %</td>
              <td class="left bottom"  align="right"><?php echo number_format($sumkolek4);?></td>
              <td class="left bottom right"  align="right"><?php echo number_format($cr4);?></td>
			</tr>
			<tr align="center" height="40px">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4);?></th>
			  <th class="left bottom right" align="right"><?php echo number_format($cr1+$cr2+$cr3+$cr4);?></th>
		  </tr>
	</table>
	
<?php include "tanda_tangan.php"; ?> 

</body>
<title>CR<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>