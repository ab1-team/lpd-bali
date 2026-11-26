<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";



$idc				=$_SESSION['lokasi'];

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

$yll				=$y-1;

?>
<body>
<table width="96%" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td>
            tahun sampai dengan : <?php echo $y;?>
        </td>
        <td>
            alokasi
        </td>
        <td>
            target pokok
        </td>
        <td>
            target jasa
        </td>
        <td>
            real pokok
        </td>
        <td>
            real jasa
        </td>
    </tr>
    <?php
		$kolom = "tb$yll";
		$clalu=mysql_query("SELECT kd_rekening, $kolom as jumlah FROM rekening_$_SESSION[lokasi] WHERE kd_jb=''"); 
		    while($cl=mysql_fetch_array($clalu)){
		        if($cl['kd_rekening']=="999.01"){
		            $sumalokasiCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.02"){
		            $sumtargetpokokCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.03"){
		            $sumtargetjasaCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.04"){
		            $sumreallaluCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.05"){
		            $sumreallalujasaCL=$cl['jumlah'];
		        }
		            $isi=$cl['kd_rekening'];
		    } 
                $yll=$y-1;
			$tgl_awal       ="$y-01-01";
			$tgl_akhir      ="$y-12-31";
			
			$apk=mysql_fetch_array(mysql_query("SELECT sum(alokasi) AS sumalokasi FROM 
			kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >='$tgl_awal' AND pk.tgl_lunas <= '$tgl_akhir' AND 
			pk.status='L' 
			"));
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >='$tgl_awal' AND pk.tgl_lunas <= '$tgl_akhir' AND 
			pk.status='L'
			");
			$sumalokasi	=$apk['sumalokasi'];
			while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$targetpokok	=targetpokok("$tgl_akhir-$idp");
			$stargetpokok=$stargetpokok+$targetpokok;
			
			$targetjasa	=targetjasa("$tgl_akhir-$idp");
			$stargetjasa=$stargetjasa+$targetjasa;
			
			$sumpokok	=sumpokok("$tgl_akhir-$idp");
			$ssumpokok=$ssumpokok+$sumpokok;
			
			$sumjasa	=sumjasa("$tgl_akhir-$idp");
			$ssumjasa=$ssumjasa+$sumjasa;
			
			}
    ?>
    <tr>
        <td>
            jumlah tahun lalu
        </td>
        <td>
            <?php echo $sumalokasiCL; //alokasi?>
        </td>
        <td>
            <?php echo $sumtargetpokokCL; //target pokok?>
        </td>
        <td>
            <?php echo $sumtargetjasaCL; //target jasa?>
        </td>
        <td>
            <?php echo $sumreallaluCL; //real pokok?>
        </td>
        <td>
            <?php echo $sumreallalujasaCL; //real jasa?>
        </td>
    </tr>
    <tr>
        <td>
            jumlah tahun ini saja
        </td>
        <td>
            <?php echo $sumalokasi; //alokasi?>
        </td>
        <td>
            <?php echo $stargetpokok; //target pokok?>
        </td>
        <td>
            <?php echo $stargetjasa; //target jasa?>
        </td>
        <td>
            <?php echo $ssumpokok; //real pokok?>
        </td>
        <td>
            <?php echo $ssumjasa; //real jasa?>
        </td>
    </tr>
    <tr>
        <td>
            jumlah tahun ini + tahun lalu
        </td>
        <td>
            <?php echo $sumalokasiCL+$sumalokasi; //alokasi?>
        </td>
        <td>
            <?php echo $sumtargetpokokCL+$stargetpokok; //target pokok?>
        </td>
        <td>
            <?php echo $sumtargetjasaCL+$stargetjasa; //target jasa?>
        </td>
        <td>
            <?php echo $sumreallaluCL+$ssumpokok; //real pokok?>
        </td>
        <td>
            <?php echo $sumreallalujasaCL+$ssumjasa; //real jasa?>
        </td>
    </tr>
</table>
</body>
 <title>P2-H1<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title> 