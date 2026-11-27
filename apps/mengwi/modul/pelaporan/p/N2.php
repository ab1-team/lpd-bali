<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];
$table_transaksi	="transaksi_".$_SESSION['lokasi'];
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
$ylalu              =$y-1;
$tgl				="$y-$m-$d";
$tb                 ="tb$ylalu";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='' "));
$jpp=$jp['nama_jpp'];


			$tgl_pakai		=$row['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$thn_kondisi   	= $y;
			$tahunlalu		=$thn_kondisi-1;
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	=$thn_kondisi."-01-01";
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";

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
.pull-right {
  float: right;
  margin-left:120px;
}
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="3" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. NC.OJK-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td align="center" height="30" colspan="4" class="style6 bottom"><br>LAPORAN NERACA <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			</tr>
			<tr align="center" height="97%">
              <th width="2%" class="left bottom top">NO</th>
              <th width="50%" class="left bottom top">NAMA AKUN</th>
              <th width="15%%" class="left bottom top">KODE AKUN</th>
              <th width="25%" class="left right bottom top">JUMLAH</th>
              
			</tr>
			<?php
                    for ($x = 1; $x <= 3; $x++) { 
                    switch ($x) {
                          case "1":
                             ?><th class="left top bottom right" height="100%" colspan=4 align="left">A. KAS</td><?php
                            break;
                          case "2":
                             ?><th class="left top bottom right" height="100%" colspan=4 align="left">B. LIABILITAS</td><?php
                            break;
                          case "3":
                             ?><th class="left top bottom right" height="100%" colspan=4 align="left">C. EKUITAS</td><?php
                            break;
                        }
                $no = 0;
                $view=mysql_query("select * from rekening_ojk WHERE super_sub='$x' ORDER by urutan ASC ");
						    $jaset = 0;
						while($row=mysql_fetch_array($view)){
                    if($row['sub']==0){
						    $no=$no+1;
                    ?>
            			<tr>
                          <td class="left bottom" height="100%" align="center"><?php echo $no;?></td>
                           <td class="left bottom" align="left"><?php echo $row['nama_akun'];?></td>
                <?php }else{    ?>
                        <ol type='a'>
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li><?php echo $row['nama_akun'];?></li></td>
                        </ol>
                        <?php } ?>
                          <td class="left bottom" align="center"><?php echo $row['kode'];?></td>
                          <td class="left bottom right" align="right"><?php
                                  $subsaldo=0;
        						$categories = '';
        				    $reks = explode("#", $row['rekening']);
        				    
        				    /*
        				     if($reks[0]=="A"){
        				        $raset=mysql_fetch_array(mysql_query("select r.$tb AS jaset, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.kd_rekening='141.01' OR r.kd_rekening='151.01' OR r.kd_rekening='161.01'"));
        				        $aset=mysql_fetch_array(mysql_query("select (sum(jumlah) AS jaset from $table_transaksi t WHERE $kondisi AND t.rekening_debit=$raset[kd_rekening] "));
        				        $subsaldo=$aset['jaset']+$raset['jaset'];
        				    }elseif($reks[0]=="P"){
        				        $rsusut=mysql_fetch_array(mysql_query("select r.$tb AS jsusut, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.kd_rekening='141.02' OR r.kd_rekening='151.02' OR r.kd_rekening='161.02' OR r.kd_rekening='141.03' OR r.kd_rekening='151.03' OR r.kd_rekening='161.03'"));
        				        $susut=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jsusut from $table_transaksi t WHERE $kondisi AND t.rekening_kredit=$raset[kd_rekening] "));
        				        $subsaldo=($susut['jsusut']+$rsusut['jsusut'])*-1;
        				    }elseif($reks[0]=="R"){
        				        $rempat=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE  SUBSTR(r.rekening_debit,1,1)='4'"));
        				        $rlima=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE SUBSTR(r.rekening_debit,1,1)='5'"));
        				        $empat=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_debit=r.kd_rekening AND SUBSTR(t.rekening_debit,1,1)='4'"));
        				        $lima=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_debit=r.kd_rekening AND SUBSTR(t.rekening_debit,1,1)='5' "));
        				        $subsaldo=($rempat['jrl']-$rlima['jrl'])+($empat['jrl']-$lima['jrl']);
        				    }elseif($reks[0]=="C"){
        				        $rsatu=mysql_fetch_array(mysql_query("select r.$tb AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE  r.rekening_kredit='215.01'"));
        				        $rdua=mysql_fetch_array(mysql_query("select r.$tb AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.rekening_debit='215.02'"));
        				        $satu=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t  WHERE $kondisi AND t.rekening_kredit=$rsatu[kd_rekening] "));
        				        $dua=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t  WHERE $kondisi AND t.rekening_debit=$rdua[kd_rekening]  "));
        				        $subsaldo=($rsatu['jrl']-$rdua['jrl'])+($satu['jrl']-$dua['jrl']);
        				    $subsaldo=$aset['jaset']+$raset['jaset'];
        				    $subsaldo=($rsusut['jsusut']+$susut['jsusut'])*-1;
        				    
        				    */
        				    
        				    if($reks[0]=="C"){ /////////////////////            133
        				        $rsatu=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE  r.kd_rekening='215.01'"));
        				        $rdua=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.kd_rekening='215.02'"));
        				        $satu=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_kredit=r.kd_rekening AND t.rekening_kredit='215.01'"));
        				        $dua=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_debit=r.kd_rekening AND t.rekening_debit='215.02' "));
        				        $subsaldo=(($rsatu['jrl']-$rdua['jrl'])+($satu['jrl']-$dua['jrl']))*-1;
        				    }elseif($reks[0]=="A"){ /////////////////////////   140
        				        $raset=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jaset, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.kd_rekening='141.01' OR r.kd_rekening='151.01' OR r.kd_rekening='161.01'"));
        				        $aset=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jaset from $table_transaksi t, $table_rekening r WHERE $kondisi AND t.rekening_debit=r.kd_rekening AND (t.rekening_debit='141.01' OR t.rekening_debit='151.01' OR t.rekening_debit='161.01')"));
        				        $subsaldo=$aset['jaset']+$raset['jaset'];
        				    }elseif($reks[0]=="P"){ /////////////////////       141
        				        $rsusut=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jsusut, r.kd_rekening AS kd_rekening from $table_rekening r WHERE r.kd_rekening='141.02' OR r.kd_rekening='151.02' OR r.kd_rekening='161.02' OR r.kd_rekening='141.03' OR r.kd_rekening='151.03' OR r.kd_rekening='161.03'"));
        				        $susut=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jsusut from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_kredit=r.kd_rekening AND (t.rekening_kredit='141.02' OR t.rekening_kredit='151.02' OR t.rekening_kredit='161.02' OR t.rekening_kredit='141.03' OR t.rekening_kredit='151.03' OR t.rekening_kredit='161.03')"));
        				        $subsaldo=($rsusut['jsusut']+$susut['jsusut'])*-1;
        				    }elseif($reks[0]=="R"){ /////////////////////       342
        				        $rempat=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE  SUBSTR(r.kd_rekening,1,1)='4'"));
        				        $rlima=mysql_fetch_array(mysql_query("select sum(r.$tb) AS jrl, r.kd_rekening AS kd_rekening from $table_rekening r WHERE SUBSTR(r.kd_rekening,1,1)='5'"));
        				        $empat=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_kredit=r.kd_rekening AND SUBSTR(t.rekening_kredit,1,1)='4'"));
        				        $lima=mysql_fetch_array(mysql_query("select (sum(jumlah)) AS jrl from $table_transaksi t, $table_rekening r  WHERE $kondisi AND t.rekening_debit=r.kd_rekening AND SUBSTR(t.rekening_debit,1,1)='5' "));
        				        $subsaldo=(($rempat['jrl']-$rlima['jrl'])+($empat['jrl']-$lima['jrl']))*-1;
        				    }else{
        				    foreach($reks as $rek) {
        				            $rek = trim($rek);
                            $saldo=saldo("$tgl_kondisi-".$rek);
                            $subsaldo=$subsaldo+$saldo;
        				    }}
        				    if(substr($row['kode'],0,1)==1 or substr($row['kode'],0,1)==4){
                                    echo number_format($subsaldo);
        				    }else{
                                    echo number_format($subsaldo*-1);
        				    }
                            $jaset=$jaset+$subsaldo;
                            if($x==1){
                            $k=$k+$subsaldo;
                            }
                            if($x==2){
                            $l=$l+$subsaldo;
                            }
                            if($x==3){
                            $e=$e+$subsaldo;
                            }
                            if($row['kode']==110 OR $row['kode']==121 OR $row['kode']==122 OR $row['kode']==123){
                            $ks=$ks+$subsaldo;
                            }
                            if($row['kode']==210 OR $row['kode']==221 OR $row['kode']==222){
                            $ll=$ll+$subsaldo;
                            }
                            
        				    ?></td>
                        </tr>
                    <?php
                } 
                            if($x==1){?>
                <tr>
                <th class="left top bottom" height="100%" colspan=3 align="center">Jumlah Aset</td>
                <th class="left top bottom right" align="right"><?php echo number_format($k); ?></td>
                </tr>
                <?php    }elseif($x==2){?>
                <tr>
                <th class="left top bottom" height="100%" colspan=3 align="center">Jumlah Liabilitas</td>
                <th class="left top bottom right" align="right"><?php echo number_format($l*-1); ?></td>
                </tr>
                <?php    }elseif($x==3){?>
                <tr>
                <th class="left top bottom" height="100%" colspan=3 align="center">Jumlah Ekuitas</td>
                <th class="left top bottom right" align="right"><?php echo number_format($e*-1); ?></td>
                </tr>
                <?php    }
                        
                        
                    }
						?>
                <tr>
                <th class="left top bottom" height="100%" colspan=3 align="center">Jumlah Liabilitas Dan Ekuitas</td>
                <th class="left top bottom right" align="right"><?php echo number_format(($l+$e)*-1); ?></td>
                </tr>
                
                <tr>
                   <th class="top left bottom" align="left" colspan=2>A. Rasio Likuiditas</td>
                  <th class="top left bottom" align="right">&nbsp;</td>
                  <th class="top left bottom right" align="right"><?php echo number_format($ks/$ll*-1*100,2)?>%</td>
                </tr>
                        
                        <ol type='a'>
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li>Kas dan Setara Kas</li></td>
                        </ol>
                          <td class="left bottom" align="right">&nbsp;</td>
                          <td class="left bottom right" align="right"><?php echo number_format($ks)?></td>
                        </tr>
                        <ol type='a'>
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li>Liabilitas Lancar</li></td>
                        </ol>
                          <td class="left bottom" align="right">&nbsp;</td>
                          <td class="left bottom right" align="right"><?php echo number_format($ll*-1)?></td>
                        </tr>
                        
                <tr>
                   <th class="top left bottom" align="left" colspan=2>B. Rasio Solvabilitas</td>
                  <th class="top left bottom" align="right">&nbsp;</td>
                  <th class="top left bottom right" align="right"><?php echo number_format($k/$l*-1*100,2)?>%</td>
                </tr>
                        
                        <ol type='a'>
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li>Total Aset</li></td>
                        </ol>
                          <td class="left bottom" align="right">&nbsp;</td>
                          <td class="left bottom right" align="right"><?php echo number_format($k)?></td>
                        </tr>
                        <ol type='a'>
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li>Total Liabilitas</li></td>
                        </ol>
                          <td class="left bottom" align="right">&nbsp;</td>
                          <td class="left bottom right" align="right"><?php echo number_format($l*-1)?></td>
                        </tr>
                        
                        
                <tr>
                <th class="top" height="100%" colspan=4 align="center"></td>
                </tr>
	</table>
			<?php
			$ma=modalawal("$tgl_kondisi");
			$ap=asetproduktif("$tgl_kondisi");
			if($_SESSION['kd_kab']=='23'){ // Khusus Kabupaten Blitar
			$pd=$ap-$ma;
			$pr=@($pd/$ma*100);
			} else {
			$pd=$k-$ma;
			$pr=@($pd/$ma*100);
			}
			?>
	</table>
	
<?php include "tanda_tangan.php"; ?> 

</body>
<title>NC-OJK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>