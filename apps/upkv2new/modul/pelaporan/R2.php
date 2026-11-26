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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$tgl_lalu = date('Y-m-d', strtotime('-1 month', strtotime($tgl_kondisi))); //operasi penjumlahan tanggal sebanyak 6 hari

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='' "));
$jpp=$jp['nama_jpp'];



			$tgl_pakai		=$row['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$tgl_awal   	= substr($tgl_kondisi,0,7)."-01";
			$thn_kondisi   	= $y;
			$tahunlalu		=$thn_kondisi-1;
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	=$thn_kondisi."-01-01";
			
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_lalu' ";
				$kondisi2		="tgl_transaksi between '$tgl_awal' AND '$tgl_kondisi' ";


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
				<td height="20" colspan="5" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. NC.OJK-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td align="center" height="30" colspan="6" class="style6 bottom"><br>LAPORAN RUGI LABA <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			</tr>
			<tr align="center" height="97%">
              <th width="2%" class="left bottom top">NO</th>
              <th width="25%" class="left bottom top">NAMA AKUN</th>
              <th width="10%%" class="left bottom top">KODE AKUN</th>
              <th width="15%" class="left  bottom top">SD. BULAN LALU</th>
              <th width="15%" class="left  bottom top">BULAN INI</th>
              <th width="15%" class="left right  bottom top">SD. BULAN INI</th>
              
			</tr><ol type="I" name="A" id="A">
			<?php
                $no = 0;
                $view=mysql_query("select * from rekening_ojk WHERE super_sub='4' AND id<34 ORDER by urutan ASC ");
						    $jaset  = 0;
                            $shu    = 0;
						    
						while($row=mysql_fetch_array($view)){
                    if($row['sub']==0){
						    $no=$no+1;
                    ?>
            			<tr>
                          <th class="left bottom" height="100%" align="center"><li type="A" value=<?php echo $no;?>></li></td>
                           <th class=" bottom" align="left"><?php echo $row['nama_akun'];?></td>
                <?php }else{  $noo =$noo+1 ;  ?>
                
                        <tr>
                          <td class="left bottom" height="100%" align="center"></td>
                           <td class="bottom" align="left"><li type="1" value=<?php echo $noo;?>><?php echo $row['nama_akun'];?></li></td>
                        <?php 
                        
                        } 
                        ?>
                          <td class="left bottom" align="center"><?php echo $row['kode'];?></td>
                          <td class="left bottom " align="right"><?php
                          if($row['rekening']!=0){
                                  $subsaldo=0;
        						$categories = '';
        				    $reks = explode("#", $row['rekening']);

        				    foreach($reks as $rek) {
        				            $rek = trim($rek);
        				    $rows=mysql_fetch_array(mysql_query("select sum(jumlah) AS jsaldo from transaksi_$_SESSION[lokasi] WHERE $kondisi AND (rekening_debit LIKE '$rek' OR rekening_kredit LIKE '$rek')"));
        				    $saldo= $rows['jsaldo'];
                            $subsaldo=$subsaldo+$saldo;
        				    }
                                    echo number_format($subsaldo);
                                $po=$po+$subsaldo;
                          }
        				    ?></td>
                          <td class="left bottom " align="right"><?php
                          if($row['rekening']!=0){
                                  $subsaldo2=0;
        				    foreach($reks as $rek) {
        				            $rek = trim($rek);
        				    $rows2=mysql_fetch_array(mysql_query("select sum(jumlah) AS jsaldo from transaksi_$_SESSION[lokasi] WHERE $kondisi2 AND (rekening_debit LIKE '$rek' OR rekening_kredit LIKE '$rek')"));
        				    $saldo2= $rows2['jsaldo'];
                            $subsaldo2=$subsaldo2+$saldo2;
        				    }
                                    echo number_format($subsaldo2);
                            $jaset2=$jaset2+$subsaldo2;
                          }
        				    ?></td>
                          <td class="left bottom right" align="right"><?php
                          if($row['rekening']!=0){ echo number_format($subsaldo+$subsaldo2);}?></td>
                        </tr>
                    <?php
                     if($row['id']==27){?>
                         <tr>
                <th class=" left bottom " height="100%" align="center"></td>
                <th class="  bottom " height="100%" colspan=2 align="left">Jumlah Pendapatan Operasional</td>
                <th class=" left bottom " height="100%"  align="right"><?php echo number_format($po);?></td>
                <th class=" left bottom " height="100%"  align="right"><?php echo number_format($jaset2);?></td>
                <th class=" left bottom right" height="100%"  align="right"><?php echo number_format($po+$jaset2);?></td>
                </tr>
                    <?php }
                    
                     if($row['id']==33){?>
                         <tr>
                <th class=" left bottom " height="100%" align="center"></td>
                <th class="  bottom " height="100%" colspan=2 align="left">Jumlah Beban Operasional</td>
                <th class=" left bottom " height="100%"  align="right"><?php echo number_format($po);?></td>
                <th class=" left bottom " height="100%"  align="right"><?php echo number_format($jaset2);?></td>
                <th class=" left bottom right" height="100%"  align="right"><?php echo number_format($po+$jaset2);?></td>
                </tr>
                    <?php }
                    
                    
                    if($row['id']==28){$noo=0; $po=0; $jaset2=0;}
                } ?>
                </ol>
                <tr>
                <th class="top" height="100%" colspan=6 align="center"></td>
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
<title>R2-OJK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>