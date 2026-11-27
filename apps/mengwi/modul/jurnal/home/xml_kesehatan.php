<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_pinjaman.php";

// membuat header dokumen XML
header('Content-Type: text/xml');
echo "<?xml version='1.0'?>";

// membuat root tag untuk data XML
echo "<outbox>";


//Kesehatan
$tgl_kondisi	=date('Y-m-d');
$surplus	=surplus("$tgl_kondisi");
$asetproduktif	=asetproduktif("$tgl_kondisi");


$sumnunggakpokok	=sumnunggakpokok("$tgl_kondisi");
$sumsaldopinjaman	=sumsaldopinjaman("$tgl_kondisi");
$pros1				=@(round($sumnunggakpokok/$sumsaldopinjaman*100,2));
if($pros1<5) {$nilai1="40"; $kategori1="SEHAT"; $warna1="progress-bar-success"; $caret1="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros1>=5 AND $pros1<10) {$nilai1="35"; $kategori1="SEHAT"; $warna1="progress-bar-success"; $caret1="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros1>=10 AND $pros1<12.5) {$nilai1="30"; $kategori1="CUKUP"; $warna1="progress-bar-primary"; $care1t="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros1>=12.5 AND $pros1<15) {$nilai1="25"; $kategori1="CUKUP"; $warna1="progress-bar-primary"; $caret1="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros1>=15 AND $pros1<17.5) {$nilai1="20"; $kategori1="KURANG"; $warna1="progress-bar-warning"; $caret1="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros1>=17.5 AND $pros1<20) {$nilai1="15"; $kategori1="KURANG"; $warna1="progress-bar-warning"; $caret1="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros1>=20 AND $pros1<25) {$nilai1="10"; $kategori1="TIDAK SEHAT"; $warna1="progress-bar-danger"; $caret1="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros1>=25) {$nilai1="0"; $kategori1="TIDAK SEHAT"; $warna="progress-bar-danger"; $caret1="<i class='fa fa-caret-down text-danger'></i>";}

$saldoCR	=saldo("$tgl_kondisi-215")*-1; //Saldo Cadangan Resiko
$sumtotCR	=sumtotCR("$tgl_kondisi");
$pros2				=round($saldoCR/$sumtotCR*100,2);
if($pros2>=100) {$nilai2="20"; $kategori2="SEHAT"; $warna2="progress-bar-success"; $caret2="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros2>90 AND $pros2<100) {$nilai2="15"; $kategori2="CUKUP"; $warna2="progress-bar-primary"; $caret2="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros2>80 AND $pros2<=90) {$nilai2="12.5"; $kategori2="CUKUP"; $warna2="progress-bar-primary"; $caret2="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros2>70 AND $pros2<=80) {$nilai2="10"; $kategori2="KURANG"; $warna2="progress-bar-warning"; $caret2="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros2>60 AND $pros2<=70) {$nilai2="7.5"; $kategori2="KURANG"; $warna2="progress-bar-warning"; $caret2="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros2>50 AND $pros2<=60) {$nilai2="5"; $kategori2="TIDAK SEHAT"; $warna2="progress-bar-danger"; $caret2="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros2<=50) {$nilai2="0"; $kategori2="TIDAK SEHAT"; $warna2="progress-bar-danger"; $caret2="<i class='fa fa-caret-down text-danger'></i>";}

$surplus	=surplus("$tgl_kondisi");
$asetproduktif	=asetproduktif("$tgl_kondisi");
$bc				=@(round($sumtotCR-$saldoCR,2));
$abc			=@(round($surplus-$bc,2));
$pros3				=@(round($abc/$asetproduktif*100,2));
if($pros3>1) {$nilai3="10"; $kategori3="SEHAT"; $warna3="progress-bar-success"; $caret3="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros3>0.75 AND $pros3<=1) {$nilai3="8.75"; $kategori3="SEHAT"; $warna3="progress-bar-success"; $caret3="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros3>0.6 AND $pros3<=0.75) {$nilai3="7.5"; $kategori3="CUKUP"; $warna3="progress-bar-primary"; $caret3="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros3>0.45 AND $pros3<=0.6) {$nilai3="6.25"; $kategori3="CUKUP"; $warna3="progress-bar-primary"; $caret3="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros3>0.3 AND $pros3<=0.45) {$nilai3="5"; $kategori3="KURANG"; $warna3="progress-bar-warning"; $caret3="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros3>0.15 AND $pros3<=0.3) {$nilai3="3.75"; $kategori3="KURANG"; $warna3="progress-bar-warning"; $caret3="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros3>0 AND $pros3<=0.15) {$nilai3="2.5"; $kategori3="TIDAK SEHAT"; $warna3="progress-bar-danger"; $caret3="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros3<=0) {$nilai3="0"; $kategori3="TIDAK SEHAT"; $warna3="progress-bar-danger"; $caret3="<i class='fa fa-caret-down text-danger'></i>";}

$pendapatan	=pendapatan("$tgl_kondisi");
$biaya		=biaya("$tgl_kondisi");
$pros4		=@(round($biaya/$pendapatan*100,2));
if($pros4<40) {$nilai4="10"; $kategori4="SEHAT"; $warna4="progress-bar-success"; $caret4="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros4>=40 AND $pros4<50) {$nilai4="8.75"; $kategori4="SEHAT"; $warna4="progress-bar-success"; $caret4="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros4>=50 AND $pros4<60) {$nilai4="7.5"; $kategori4="CUKUP"; $warna4="progress-bar-primary"; $caret4="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros4>=60 AND $pros4<70) {$nilai4="6.25"; $kategori4="CUKUP"; $warna4="progress-bar-primary"; $caret4="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros4>=70 AND $pros4<80) {$nilai4="5.75"; $kategori4="KURANG"; $warna4="progress-bar-warning"; $caret4="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros4>=80 AND $pros4<90) {$nilai4="3.75"; $kategori4="KURANG"; $warna4="progress-bar-warning"; $caret4="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros4>=90 AND $pros4<100) {$nilai4="2.5"; $kategori4="TIDAK SEHAT"; $warna4="progress-bar-danger"; $caret4="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros4>=100) {$nilai4="0"; $kategori4="TIDAK SEHAT"; $warna4="progress-bar-danger"; $caret4="<i class='fa fa-caret-down text-danger'></i>";}

$asetekonomi	=asetekonomi("$tgl_kondisi");
$pros5		=@(round($sumsaldopinjaman/$asetekonomi*100,2));
if($pros5>=85) {$nilai5="10"; $kategori5="SEHAT"; $warna5="progress-bar-success"; $caret5="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros5>80 AND $pros5<85) {$nilai5="7.5"; $kategori5="CUKUP"; $warna5="progress-bar-primary"; $caret5="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros5>75 AND $pros5<80) {$nilai5="6.25"; $kategori5="CUKUP"; $warna5="progress-bar-primary"; $caret5="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros5>70 AND $pros5<75) {$nilai5="5"; $kategori5="KURANG"; $warna5="progress-bar-warning"; $caret5="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros5>65 AND $pros5<70) {$nilai5="3.75"; $kategori5="KURANG"; $warna5="progress-bar-warning"; $caret5="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros5>60 AND $pros5<65) {$nilai5="2.5"; $kategori5="TIDAK SEHAT"; $warna5="progress-bar-danger"; $caret5="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros5<=60) {$nilai5="0"; $kategori5="TIDAK SEHAT"; $warna5="progress-bar-danger"; $caret5="<i class='fa fa-caret-down text-danger'></i>";}

$modalawal	=modalawal("$tgl_kondisi");
$pros6		=@(round((($asetekonomi-$sumtotCR)/$modalawal)*100,2));
if($pros6>110) {$nilai6="10"; $kategori6="SEHAT"; $warna6="progress-bar-success"; $caret6="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros6>107.5 AND $pros6<=110) {$nilai6="8.75"; $kategori6="SEHAT"; $warna6="progress-bar-success"; $caret6="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros6>105 AND $pros6<=107.5) {$nilai6="7.5"; $kategori6="CUKUP"; $warna6="progress-bar-primary"; $caret6="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros6>102 AND $pros6<=105) {$nilai6="6.25"; $kategori6="CUKUP"; $warna6="progress-bar-primary"; $caret6="<i class='fa fa-caret-up text-success'></i>";}
elseif($pros6>100 AND $pros6<=102) {$nilai6="5"; $kategori6="KURANG"; $warna6="progress-bar-warning"; $caret6="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros6>97.5 AND $pros6<=100) {$nilai6="3.75"; $kategori6="KURANG"; $warna6="progress-bar-warning"; $caret6="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros6>95 AND $pros6<=97.5) {$nilai6="2.5"; $kategori6="TIDAK SEHAT"; $warna6="progress-bar-danger"; $caret6="<i class='fa fa-caret-down text-danger'></i>";}
elseif($pros6<=95) {$nilai6="0"; $kategori6="TIDAK SEHAT"; $warna6="progress-bar-danger"; $caret6="<i class='fa fa-caret-down text-danger'></i>";}

$total_nilai = $nilai1+$nilai2+$nilai3+$nilai4+$nilai5+$nilai6;
if($total_nilai>87.5 AND $total_nilai<=100) { $kesimpulan="SEHAT";}
elseif($total_nilai>62.5 AND $total_nilai<=87.5) { $kesimpulan="CUKUP SEHAT";}
elseif($total_nilai>37.5 AND $total_nilai<=62.5) { $kesimpulan="KURANG SEHAT";}
elseif($total_nilai<=37.5) { $kesimpulan="TIDAK SEHAT";}


$pros_n1	=$nilai1*100/40;
$pros_n2	=$nilai2*100/20;
$pros_n3	=$nilai3*100/10;
$pros_n4	=$nilai4*100/10;
$pros_n5	=$nilai5*100/10;
$pros_n6	=$nilai6*100/10;
//End Kesehatan

{
   // representasi data sms
   echo "<data>";
   echo "<kategori1>".$kategori1."</kategori1>";
   echo "<kategori2>".$kategori2."</kategori2>";
   echo "<kategori3>".$kategori3."</kategori3>";
   echo "<kategori4>".$kategori4."</kategori4>";
   echo "<kategori5>".$kategori5."</kategori5>";
   echo "<kategori6>".$kategori6."</kategori6>";
   echo "<total_nilai>".$total_nilai."</total_nilai>";
   echo "<kesimpulan>".$kesimpulan."</kesimpulan>";
   echo "</data>";
}
echo "</outbox>";
?>