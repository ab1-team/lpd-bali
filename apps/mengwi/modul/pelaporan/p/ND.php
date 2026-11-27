<?php session_start();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

$kd_kab				=$_SESSION['idb'];
$idf				=substr($_GET['sub_report'],3);
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
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }

if($d=$d){
    $laporan="Harian";
    $jenis="Tanggal";
    $tgl_kondisi="$y-$m-$d";
    $tgl_kondisibulanlalu="$y-$ml-$d";
    $judulL="Kemaren";
    $judulC="Hari Ini";
} else if($m=$m){
    $laporan="Bulanan";
    $jenis="Bulan";
    $tgl_kondisi="$y-$m-31";
    $tgl_kondisibulanlalu="$y-$ml-31";
    $judulL="Bulan Lalu";
    $judulC="Bulan Ini";
} else if($y=$y){
    $laporan="Tahunan";
    $jenis="Tahun";
    $tgl_kondisi="$y-12-31";
    $tgl_kondisibulanlalu="$y-12-31";
    $judulL="Tahun Lalu";
    $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten WHERE id='$_SESSION[idb]' "));
?>

<style type="text/css">
    .style6 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 16px;
    }

    .style9 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
    }

    .style10 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
    }

    .top {
        border-top: 1px solid #000000;
    }

    .bottom {
        border-bottom: 1px solid #000000;
    }

    .left {
        border-left: 1px solid #000000;
    }

    .right {
        border-right: 1px solid #000000;
    }

    .all {
        border: 1px solid #000000;
    }

    .style26 {
        font-family: Verdana, Arial, Helvetica, sans-serif
    }

    .style27 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-weight: bold;
    }

    .align-justify {
        text-align: justify;
    }

    .align-center {
        text-align: center;
    }

    .align-right {
        text-align: right;
    }

    .pull-right {
        float: right;
        margin-left: 120px;
    }
</style>

<body onLoad="window.print()">

    <table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
        <tr>
            <td height="20" class="bottom">
                <div class="style9"><?php echo "$row[nama_lembaga]<br>Pusat Waeapo Kabupaten $row[nama_kab]";?><br>
                    <?php echo $row['alamat_kab'];?> Telp.<?php echo $row['telpon_kab'];?> </div>
            </td>
            <td height="20" class="bottom">
                <div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
                    Koperasi Jasa LKM</div>
            </td>
        </tr>
        <tr>
            <td height="20" class="style6"><br>NERACA <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
            <td height="20" class="style6 pull-right"><br>REKAP PUSAT WAEAPO</td>
        </tr>
        <tr>
            <th height="30" class="left top bottom">AKTIVA</th>
            <th class="all">PASSIVA</th>
        </tr>
        <tr>
            <td class="left top bottom" width="50%">
                <table width='100%' cellpadding="0" cellspacing="0" class="style9">
                    <?php
						$view=mysql_query("SELECT * FROM jenis_akun WHERE posisi='1' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
                            if ($row['kd_jb'] == null || !$row['kd_jb']) continue;
                            $kd_jb = explode('|',$row['kd_jb']);
                            $star = $kd_jb[0];
                            $finish = $kd_jb[1];
                            $kecuali = $_SESSION['kd_kab'];
                            $data = mysql_query("SELECT * FROM jenis_buku WHERE kd_jb BETWEEN '$star' AND '$finish' AND kd_kab = '$kecuali' ORDER by kd_jb ASC");
						echo "
						<tr>
							<td><strong>$row[nama_akun]</strong><br> ";
							while($r=mysql_fetch_array($data)){
                                
							echo	"
							<table width='100%' class='style9'>
								<tr>
									<td width='70%'><strong>$r[kd_jb]. $r[nama_jb]</strong><br>";

                                    $d_kec = mysql_query("SELECT * FROM kecamatan WHERE kd_kab = '$kecuali'");
                                    while ($kec = mysql_fetch_array($d_kec)) {
                                        $sort = $kec['kd_kab'] . '-' . $kec['kd_kec'];
                                        $buku = mysql_query("SELECT * FROM jenis_buku WHERE kd_jb=$r[kd_jb] AND kecuali NOT LIKE '%$sort%' AND lokasi='0' OR kd_jb=$r[kd_jb] AND lokasi LIKE '%$sort%' ORDER by kd_jb ASC");
                                        $kd_kec = $kec['kd_kec'];
                                        while ($jb = mysql_fetch_array($buku)) {
                                            
                                            $tmp_saldo_aktiva = $tgl_kondisi."-".$jb['kd_jb'];
                                            $saldo_aktiva1 = saldo($tmp_saldo_aktiva,$kd_kec);
                                            echo "
                                            <table width='100%' class='style9'>
                                                <tr>
                                                    <td width='70%'>$kec[nama_kec]</td>
                                                    <td width='30%' class='align-right'>" . number_format($saldo_aktiva1) . "</td>
                                                </tr>
                                            </table>
                                            ";

                                            $aktiva = $aktiva + $saldo_aktiva1;
                                        }
                                    }

                            echo
                                "</td>
								</tr>
							</table>
							";
							}
							echo "
							</td>
						</tr> ";					
						}
						?>
                    <tr>
                        <th class="top"><span class='pull-right'><?php echo number_format($aktiva);?></span></th>
                    </tr>
                </table>

            </td>
            <td class="all" width="50%">
                <table width='100%' cellpadding="0" cellspacing="0" class="style9">
                    <?php
						$view=mysql_query("SELECT * FROM jenis_akun WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
                            if ($row['kd_jb'] == null || !$row['kd_jb']) continue;
                            $kd_jb = explode('|',$row['kd_jb']);
                            $star = $kd_jb[0];
                            $finish = $kd_jb[1];
                            $kecuali = $_SESSION['kd_kab'];
                            $data = mysql_query("SELECT * FROM jenis_buku WHERE kd_jb BETWEEN '$star' AND '$finish' AND kd_kab = '$kecuali' ORDER by kd_jb ASC");
						echo "
						<tr>
							<td><strong>$row[nama_akun]</strong><br> ";
							while($r=mysql_fetch_array($data)){

                            echo	"
							<table width='100%' class='style9'>
								<tr>
									<td width='70%'><strong>$r[kd_jb]. $r[nama_jb]</strong><br>";
                                    $d_kec = mysql_query("SELECT * FROM kecamatan WHERE kd_kab = '$kecuali'");
                                    while ($kec = mysql_fetch_array($d_kec)) {
                                        $sort = $kec['kd_kab'] . '-' . $kec['kd_kec'];
                                        $buku = mysql_query("SELECT * FROM jenis_buku WHERE kd_jb=$r[kd_jb] AND kecuali NOT LIKE '%$sort%' AND lokasi='0' OR kd_jb=$r[kd_jb] AND lokasi LIKE '%$sort%' ORDER by kd_jb ASC");
                                        $kd_kec = $kec['kd_kec'];
                                        while ($jb = mysql_fetch_array($buku)) {
                                            
                                            $tmp_saldo_passiva = $tgl_kondisi."-".$jb['kd_jb'];
                                            $saldo_passiva1 = saldo($tmp_saldo_passiva,$kd_kec)*-1;
                                            echo "
                                            <table width='100%' class='style9'>
                                                <tr>
                                                    <td width='70%'>$kec[nama_kec]</td>
                                                    <td width='30%' class='align-right'>" . number_format($saldo_passiva1) . "</td>
                                                </tr>
                                            </table>
                                            ";

                                            $passiva = $passiva + $saldo_passiva1;
                                        }
                                    }
                            echo
                                "</td>
								</tr>
							</table>
							";
							}
							echo "
							</td>
						</tr> 
						";					
						}
						?>
                    <tr>
                        <!-- <td><strong>Surplus/Devisit</strong><span class="pull-right">
                                <?php echo number_format(surplus("$tgl_kondisi-$kd_kab"));?></span></td> -->
                        <td>
                            <strong>Laba/Rugi Berjalan</strong> <br>
                            <?php 
                            $d_kec = mysql_query("SELECT * FROM kecamatan WHERE kd_kab = '$_SESSION[kd_kab]'");
                            $jumlah = 0;
                            while ($kec = mysql_fetch_array($d_kec)) {
                                $jumlah = surplus("$tgl_kondisi",$kec['kd_kec']);
                                $tmp_saldo = $tgl_kondisi."-".$jb['kd_jb'];
                                $saldo_passiva1 = saldo($tmp_saldo,$kd_kec)*-1;
                                echo "
                                <table width='100%' class='style9'>
                                    <tr>
                                        <td width='70%'>$kec[nama_kec]</td>
                                        <td width='30%' class='align-right'>" . number_format($jumlah) . "</td>
                                    </tr>
                                </table>
                                ";
                            }
                            ?>
                            <!-- <span class="pull-right"><?php echo number_format($jumlah);?></span> -->
                        </td>
                    </tr>
                    <tr>
                        <th class="top"><span
                                class='pull-right'><?php echo number_format(surplus($tgl_kondisi)+$passiva);?></span>
                        </th>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if($kd_kab==48) {?>
        <?php include "ttd_pusat_waeapo.php"; }?>
    </table>


    <title>NK<?php echo " - $idf $jenis ".tgl_indo($tgl);?></title>