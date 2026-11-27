<?php session_start();
include "inc/inc.koneksi.php";

$th=date('Y');

$d1=pendapatan("$th-01-31");
$d2=pendapatan("$th-02-31");
$d3=pendapatan("$th-03-31");
$d4=pendapatan("$th-04-31");
$d5=pendapatan("$th-05-31");
$d6=pendapatan("$th-06-31");
$d7=pendapatan("$th-07-31");
$d8=pendapatan("$th-08-31");
$d9=pendapatan("$th-09-31");
$d10=pendapatan("$th-10-31");
$d11=pendapatan("$th-11-31");
$d12=pendapatan("$th-12-31");

//Pendapatan per Bulan
$p1=$d1;
$p2=$d2-$d1;
$p3=$d3-$d2;
$p4=$d4-$d3;
$p5=$d5-$d4;
$p6=$d6-$d5;
$p7=$d7-$d6;
$p8=$d8-$d7;
$p9=$d9-$d8;
$p10=$d10-$d9;
$p11=$d11-$d10;
$p12=$d12-$d11;

$y1=biaya("$th-01-31");
$y2=biaya("$th-02-31");
$y3=biaya("$th-03-31");
$y4=biaya("$th-04-31");
$y5=biaya("$th-05-31");
$y6=biaya("$th-06-31");
$y7=biaya("$th-07-31");
$y8=biaya("$th-08-31");
$y9=biaya("$th-09-31");
$y10=biaya("$th-10-31");
$y11=biaya("$th-11-31");
$y12=biaya("$th-12-31");

//Biaya per bulan
$b1=$y1;
$b2=$y2-$y1;
$b3=$y3-$y2;
$b4=$y4-$y3;
$b5=$y5-$y4;
$b6=$y6-$y5;
$b7=$y7-$y6;
$b8=$y8-$y7;
$b9=$y9-$y8;
$b10=$y10-$y9;
$b11=$y11-$y10;
$b12=$y12-$y11;

//Surplus per bulan
$s1=$p1-$b1;
$s2=$p2-$b2;
$s3=$p3-$b3;
$s4=$p4-$b4;
$s5=$p5-$b5;
$s6=$p6-$b6;
$s7=$p7-$b7;
$s8=$p8-$b8;
$s9=$p9-$b9;
$s10=$p10-$b10;
$s11=$p11-$b11;
$s12=$p12-$b12;

$pendapatan	=pendapatan("$th-12-31");
$biaya		=biaya("$th-12-31");
$surplus	=$pendapatan-$biaya;

?>
					
					

