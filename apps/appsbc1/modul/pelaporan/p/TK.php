<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../inc/fungsi_keuangan.php";

$lokasi				=$_SESSION['lokasi'];

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

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$surplus	=surplus("$tgl_kondisi");
$asetproduktif	=asetproduktif("$tgl_kondisi");


$sumnunggakpokok	=sumnunggakpokok("$tgl_kondisi");
$sumsaldopinjaman	=sumsaldopinjaman("$tgl_kondisi");
$pros1				=@(round($sumnunggakpokok/$sumsaldopinjaman*100,2));
if($pros1<5) {$nilai1="40"; $kategori1="SEHAT";}
elseif($pros1>=5 AND $pros1<10) {$nilai1="35"; $kategori1="SEHAT";}
elseif($pros1>=10 AND $pros1<12.5) {$nilai1="30"; $kategori1="CUKUP SEHAT";}
elseif($pros1>=12.5 AND $pros1<15) {$nilai1="25"; $kategori1="CUKUP SEHAT";}
elseif($pros1>=15 AND $pros1<17.5) {$nilai1="20"; $kategori1="KURANG SEHAT";}
elseif($pros1>=17.5 AND $pros1<20) {$nilai1="15"; $kategori1="KURANG SEHAT";}
elseif($pros1>=20 AND $pros1<25) {$nilai1="10"; $kategori1="TIDAK SEHAT";}
elseif($pros1>=25) {$nilai1="0"; $kategori1="TIDAK SEHAT";}

$saldoCR	=saldo("$tgl_kondisi-215")*-1; //Saldo Cadangan Resiko
$sumtotCR	=sumtotCR("$tgl_kondisi");
$pros2				=round($saldoCR/$sumtotCR*100,2);
if($pros2>=100) {$nilai2="20"; $kategori2="SEHAT";}
elseif($pros2>90 AND $pros2<100) {$nilai2="15"; $kategori2="CUKUP SEHAT";}
elseif($pros2>80 AND $pros2<=90) {$nilai2="12.5"; $kategori2="CUKUP SEHAT";}
elseif($pros2>70 AND $pros2<=80) {$nilai2="10"; $kategori2="KURANG SEHAT";}
elseif($pros2>60 AND $pros2<=70) {$nilai2="7.5"; $kategori2="KURANG SEHAT";}
elseif($pros2>50 AND $pros2<=60) {$nilai2="5"; $kategori2="TIDAK SEHAT";}
elseif($pros2<=50) {$nilai2="0"; $kategori2="TIDAK SEHAT";}

$surplus	=surplus("$tgl_kondisi");
$asetproduktif	=asetproduktif("$tgl_kondisi");
$bc				=@(round($sumtotCR-$saldoCR,2));
$abc			=@(round($surplus-$bc,2));
$pros3				=@(round($abc/$asetproduktif*100,2));
if($pros3>1) {$nilai3="10"; $kategori3="SEHAT";}
elseif($pros3>0.75 AND $pros3<=1) {$nilai3="8.75"; $kategori3="SEHAT";}
elseif($pros3>0.6 AND $pros3<=0.75) {$nilai3="7.5"; $kategori3="CUKUP SEHAT";}
elseif($pros3>0.45 AND $pros3<=0.6) {$nilai3="6.25"; $kategori3="CUKUP SEHAT";}
elseif($pros3>0.3 AND $pros3<=0.45) {$nilai3="5"; $kategori3="KURANG SEHAT";}
elseif($pros3>0.15 AND $pros3<=0.3) {$nilai3="3.75"; $kategori3="KURANG SEHAT";}
elseif($pros3>0 AND $pros3<=0.15) {$nilai3="2.5"; $kategori3="TIDAK SEHAT";}
elseif($pros3<=0) {$nilai3="0"; $kategori3="TIDAK SEHAT";}

$pendapatan	=pendapatan("$tgl_kondisi");
$biaya		=biaya("$tgl_kondisi");
$pros4		=@(round($biaya/$pendapatan*100,2));
if($pros4<40) {$nilai4="10"; $kategori4="SEHAT";}
elseif($pros4>=40 AND $pros4<50) {$nilai4="8.75"; $kategori4="SEHAT";}
elseif($pros4>=50 AND $pros4<60) {$nilai4="7.5"; $kategori4="CUKUP SEHAT";}
elseif($pros4>=60 AND $pros4<70) {$nilai4="6.25"; $kategori4="CUKUP SEHAT";}
elseif($pros4>=70 AND $pros4<80) {$nilai4="5.75"; $kategori4="KURANG SEHAT";}
elseif($pros4>=80 AND $pros4<90) {$nilai4="3.75"; $kategori4="KURANG SEHAT";}
elseif($pros4>=90 AND $pros4<100) {$nilai4="2.5"; $kategori4="TIDAK SEHAT";}
elseif($pros4>=100) {$nilai4="0"; $kategori4="TIDAK SEHAT";}

$asetekonomi	=asetekonomi("$tgl_kondisi");
$pros5		=@(round($sumsaldopinjaman/$asetekonomi*100,2));
if($pros5>=85) {$nilai5="10"; $kategori5="SEHAT";}
elseif($pros5>80 AND $pros5<85) {$nilai5="7.5"; $kategori5="CUKUP SEHAT";}
elseif($pros5>75 AND $pros5<80) {$nilai5="6.25"; $kategori5="CUKUP SEHAT";}
elseif($pros5>70 AND $pros5<75) {$nilai5="5"; $kategori5="KURANG SEHAT";}
elseif($pros5>65 AND $pros5<70) {$nilai5="3.75"; $kategori5="KURANG SEHAT";}
elseif($pros5>60 AND $pros5<65) {$nilai5="2.5"; $kategori5="TIDAK SEHAT";}
elseif($pros5<=60) {$nilai5="0"; $kategori5="TIDAK SEHAT";}

$modalawal	=modalawal("$tgl_kondisi");
$pros6		=@(round((($asetekonomi-$sumtotCR)/$modalawal)*100,2));
if($pros6>110) {$nilai6="10"; $kategori6="SEHAT";}
elseif($pros6>107.5 AND $pros6<=110) {$nilai6="8.75"; $kategori6="SEHAT";}
elseif($pros6>105 AND $pros6<=107.5) {$nilai6="7.5"; $kategori6="CUKUP SEHAT";}
elseif($pros6>102 AND $pros6<=105) {$nilai6="6.25"; $kategori6="CUKUP SEHAT";}
elseif($pros6>100 AND $pros6<=102) {$nilai6="5"; $kategori6="KURANG SEHAT";}
elseif($pros6>97.5 AND $pros6<=100) {$nilai6="3.75"; $kategori6="KURANG SEHAT";}
elseif($pros6>95 AND $pros6<=97.5) {$nilai6="2.5"; $kategori6="TIDAK SEHAT";}
elseif($pros6<=95) {$nilai6="0"; $kategori6="TIDAK SEHAT";}

$total_nilai = $nilai1+$nilai2+$nilai3+$nilai4+$nilai5+$nilai6;
if($total_nilai>87.5 AND $total_nilai<=100) { $kesimpulan="SEHAT";}
elseif($total_nilai>62.5 AND $total_nilai<=87.5) { $kesimpulan="CUKUP SEHAT";}
elseif($total_nilai>37.5 AND $total_nilai<=62.5) { $kesimpulan="KURANG SEHAT";}
elseif($total_nilai<=37.5) { $kesimpulan="TIDAK SEHAT";}
?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
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
				<td height="20" colspan="6" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. TK-<?php echo $idf;?> Lembar-1 </div>				</td>
			</tr> 
            <tr>
				<td height="20" colspan="10" class="style6 bottom"><br>LAPORAN TINGKAT KESEHATAN <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			</tr>
			<tr align="center" height="40px">
              <th width="24" rowspan="2" class="left bottom top">NO</th>
              <th width="183" rowspan="2" class="left bottom top">RASIO</th>
              <th colspan="2" rowspan="2" class="left bottom top">ITEM DAN PERHITUNGAN</th>
              <th colspan="4" class="left bottom top">KLASIFIKASI TINGKAT KESEHATAN </th>
              <th colspan="2" rowspan="2" class="all">HASIL</th>
            </tr>
			<tr align="center" height="15px" style="background:rgba(0,0,0, 0.4);">
              <th width="98" class="left bottom">SEHAT</th>
              <th width="93" class="left bottom">CUKUP SEHAT</th>
              <th width="93" class="left bottom">KURANG SEHAT</th>
              <th width="85" class="left bottom">TIDAK SEHAT</th>
            </tr>
			<tr>
			  <td rowspan="3" align="center" class="left bottom">1</td>
			  <td rowspan="3" class="left bottom">Rasio Saldo Kredit Berisiko</td>
			  <td height="20" class="left">a. Tunggakan</td>
			  <td align="right"><?php echo number_format($sumnunggakpokok);?></td>
			  <td rowspan="3" class="left bottom">P&lt;5% nilai 40<br>P&lt;10% nilai 35 </td>
			  <td rowspan="3" class="left bottom">P&lt;12.5% nilai 30<br>
			    P&lt;15% nilai 25 </td>
			  <td rowspan="3" class="left bottom">P&lt;17.5% nilai 20<br>
			    P&lt;20% nilai 15 </td>
			  <td rowspan="3" class="left bottom">P&lt;25% nilai 10<br>
			    P&ge;25% nilai 0 </td>
			  <td width="68" rowspan="3" align="center" class="left bottom">Nilai:<br><strong><?php echo $nilai1;?></strong></td>
			  <td width="100" rowspan="3" align="center" class="bottom right">Kategori:<br><strong><?php echo $kategori1;?></strong></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> b. Saldo Pinjaman</td>
			  <td align="right" class="bottom"><?php echo number_format($sumsaldopinjaman);?></td>
  </tr>
			<tr>
              <th width="152" height="20" class="left bottom"><p>Prosentase (a/bx100%)</p>              </th>
              <th width="92" class="bottom"><?php echo $pros1;?>%</th>
            </tr>
			<tr>
			  <td rowspan="3" align="center" class="left bottom">2</td>
			  <td rowspan="3" class="left bottom">Rasio Cadangan Risiko Kredit</td>
			  <td height="20" class="left">a. Cad. Risiko yg tlh dihimpun</td>
			  <td align="right"><?php echo number_format($saldoCR);?></td>
			  <td rowspan="3" class="left bottom">P&ge;100% nilai 20 </td>
			  <td rowspan="3" class="left bottom">P&gt;90% nilai 15 <br>
		      P&gt;80% nilai 12.5 </td>
			  <td rowspan="3" class="left bottom">P&gt;70% nilai 10 <br>
P&gt;60% nilai 7.5 </td>
			  <td rowspan="3" class="left bottom">P&gt;50% nilai 5 <br>
P&le;50% nilai 0 </td>
			  <td rowspan="3" align="center" class="left bottom">Nilai:<br><strong><?php echo $nilai2;?></strong></td>
			  <td rowspan="3" align="center" class="bottom right">Kategori:<br><strong><?php echo $kategori2;?></strong></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> b. Risiko Kolektibilitas</td>
			  <td align="right" class="bottom"><?php echo number_format($sumtotCR);?></td>
  </tr>
			<tr>
			<th width="152" height="20" class="left bottom"><p>Prosentase (a/bx100%)</p></th>
              <th width="92" class="bottom"><?php echo $pros2; ?>%</th>
            </tr>
			<tr>
			<td rowspan="5" align="center" class="left bottom">3</td>
              <td rowspan="5" class="left bottom">Rasio Laba Bersih terhadap 
              Kekayaan UPK</td>
              <td height="20" class="left">a. Surplus Berjalan</td>
              <td align="right"><?php echo number_format($surplus);?></td>
              <td rowspan="5" class="left bottom">P&gt;1% nilai 10 <br>
P&gt;0.75% nilai 8.75</td>
              <td rowspan="5" class="left bottom">P&gt;0.6% nilai 7.5 <br>
P&gt;0.45% nilai 6.25 </td>
              <td rowspan="5" class="left bottom">P&gt;0.3% nilai 5 <br>
P&gt;0.15% nilai 3.75 </td>
              <td rowspan="5" class="left bottom">P&gt;0% nilai 2.5 <br>
P&lt;0% nilai 0 </td>
              <td rowspan="5" align="center" class="left bottom">Nilai:<br><strong><?php echo $nilai3; ?></strong></td>
              <td rowspan="5" align="center" class="bottom right">Kategori:<br><strong><?php echo $kategori3; ?></strong></td>
			</tr>
			<tr>
			  <td height="20" class="left"> b. Risiko Kolektibilitas</td>
			  <td align="right"><?php echo number_format($sumtotCR);?></td>
  </tr>
			<tr>
			  <td height="20" class="left">c. Cadangan Risiko</td>
			  <td align="right"><?php echo number_format($saldoCR);?></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> d. Aset Produktif</td>
			  <td align="right" class="bottom"><?php echo number_format($asetproduktif);?></td>
  </tr>
			<tr>
			  <th width="152" height="20" class="left bottom"><p>Prosentase (a-(b-c)/dx100%)</p></th>
			  <th width="92" class="bottom"><?php echo $pros3;?>%</th>
  </tr>
			<tr>
			  <td rowspan="3" align="center" class="left bottom">4</td>
			  <td rowspan="3" class="left bottom">Rasio Biaya Operasional</td>
			  <td height="20" class="left">a. Biaya Operasional</td>
			  <td align="right"><?php echo number_format($biaya);?></td>
			  <td rowspan="3" class="left bottom">P&lt;40% nilai 10 <br>
		      P&lt;50% nilai 8.75 </td>
			  <td rowspan="3" class="left bottom">P&lt;60% nilai 7.5 <br>
		      P&lt;70% nilai 6.25 </td>
			  <td rowspan="3" class="left bottom">P&lt;80% nilai 5.75 <br>
		      P&lt;90% nilai 3.75 </td>
			  <td rowspan="3" class="left bottom">P&lt;100% nilai 2.5 <br>
		      P&ge;100% nilai 0 </td>
			  <td rowspan="3" align="center" class="left bottom">Nilai:<br><strong><?php echo $nilai4;?></strong></td>
			  <td rowspan="3"  align="center" class="bottom right">Kategori:<br>			    <strong><?php echo $kategori4;?></strong></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> b. Pendapatan</td>
			  <td align="right" class="bottom"><?php echo number_format($pendapatan);?></td>
  </tr>
			<tr>
			<th width="152" height="20" class="left bottom"><p>Prosentase (a/bx100%)</p></th>
              <th width="92" class="bottom"><?php echo $pros4;?>%</th>
            </tr>
			<tr>
			  <td rowspan="3" align="center" class="left bottom">5</td>
			  <td rowspan="3" class="left bottom">Rasio Saldo Kredit terhadap Kekayaan UPK</td>
			  <td height="20" class="left">a. Saldo Pinjaman</td>
			  <td align="right"><?php echo number_format($sumsaldopinjaman);?></td>
			  <td rowspan="3" class="left bottom">P&ge;85% nilai 10 </td>
			  <td rowspan="3" class="left bottom">P&gt;80% nilai 7.5<br>
		      P&gt;75% nilai 6.25</td>
			  <td rowspan="3" class="left bottom">P&gt;70% nilai 5 <br>
			    P&gt;65% nilai 3.75 </td>
			  <td rowspan="3" class="left bottom">P&gt;60% nilai 2.5 <br>
			    P&le;60% nilai 0</td>
			  <td rowspan="3" align="center" class="left bottom">Nilai:<br>
			  <strong><?php echo $nilai5;?></strong></td>
			  <td rowspan="3" align="center" class="bottom right">Kategori:<br>
		      <strong><?php echo $kategori5;?></strong></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> b. Aset Ekonomi</td>
			  <td align="right" class="bottom"><?php echo number_format($asetekonomi);?></td>
  </tr>
			<tr>
			<th width="152" height="20" class="left bottom"><p>Prosentase (a/bx100%)</p></th>
			  <th width="92" class="bottom"><?php echo $pros5;?>%</th>
		  </tr>
			<tr>
			  <td rowspan="4" align="center" class="left bottom">6</td>
			  <td rowspan="4" class="left bottom">Rasio Kekayaan Bersih UPK</td>
			  <td height="20" class="left">a. Aset Ekonomi</td>
			  <td align="right"><?php echo number_format($asetekonomi);?></td>
			  <td rowspan="4" class="left bottom">P&gt;110% nilai 10 <br>
P&gt;107.5% nilai 8.75</td>
			  <td rowspan="4" class="left bottom">P&gt;105% nilai 7.5<br>
			    P&gt;102% nilai 6.25</td>
			  <td rowspan="4" class="left bottom">P&gt;100% nilai 5 <br>
			    P&gt;97.5% nilai 3.75 </td>
			  <td rowspan="4" class="left bottom">P&gt;95% nilai 2.5 <br>
			    P&le;95% nilai 0</td>
			  <td rowspan="4" align="center" class="left bottom">Nilai:<br><strong><?php echo $nilai6;?></strong></td>
			  <td rowspan="4" align="center" class="bottom right">Kategori:<br><strong><?php echo $kategori6;?></strong></td>
  </tr>
			<tr>
			  <td height="20" class="left"> b. Risiko Kolektibilitas</td>
			  <td align="right"><?php echo number_format($sumtotCR);?></td>
  </tr>
			<tr>
			  <td height="20" class="left bottom"> c. Modal Awal</td>
			  <td align="right" class="bottom"><?php echo number_format($modalawal);?></td>
  </tr>
			<tr>
			  <th width="152" height="20" class="left bottom"><p>Prosentase (a-b/cx100%)</p></th>
			  <th width="92" class="bottom"><?php echo $pros6;?>%</th>
  </tr>
			<tr align="center" height="30px">
              <th colspan="4" align="center" class="left bottom">TINGKAT KESEHATAN  UPK</th>
			  <th align="center" class="left bottom">&gt; 87.5 - 100</th>
			  <th align="center" class="left bottom">&gt; 62.5 - 87.5</th>
			  <th align="center" class="left bottom">&gt; 37.5 - 62.5</th>
			  <th align="center" class="left bottom">&le; 37.5</th>
			  <th align="center" class="left bottom">Total Nilai<br>
		      <?php echo $total_nilai;?></th>
			  <th class="bottom right">Kesimpulan<br>
		      <?php echo $kesimpulan;?></th>
		  </tr>
			
		<tr>
			<td class="style10 top" colspan="10">&nbsp;</td>
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 

</body>
<title>TK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>