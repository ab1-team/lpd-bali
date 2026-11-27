<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

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

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

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
				<td height="20" colspan="2" class="bottom">
					<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>	
				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. NP-<?php echo $idf;?> Lembar-1 </div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="3" class="style6 bottom align-center"><br>NERACA PERCOBAAN <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?><br><br></td></td>
			</tr>
														<tr>
															<th  class="left bottom top">Rekening</th>
															<th class="left bottom top top">Debit</th>
															<th class="left bottom top top">Kredit</th>
														</tr>

														
												<?php
													$view=mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r where a.id=r.id_akun ");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														$jenis_saldo=$row['jenis_saldo'];
														
														$saldo=saldoR("$tgl_kondisi-".$row['kd_rekening']);		//menggunakan fungsi Saldo by buku
											
																if($jenis_saldo=='debit') {
																	$debit=$saldo;
																	$kredit="0";
																}else if($jenis_saldo=='kredit') {
																	$debit="0";
																	$kredit=$saldo;
																}
														
																	
														echo "
														<tr height='25'>
															<td class='left'>$row[kd_rekening]. $row[nama_rekening]</td>
															<td class='left align-right'>".number_format($debit)."</td>
															<td class='left right align-right'>".number_format($kredit)."</td>
														</tr> 
														";					
														$sumdebit=$sumdebit+$debit;
														$sumkredit=$sumkredit+$kredit;

														}
														 ?>
														
														<tr height="30">
															<th class="left bottom align-center">Jumlah</th>
															<th class="left bottom align-right"><?php echo number_format($sumdebit);?></th>
															<th class="left bottom align-right"><?php echo number_format($sumkredit);?></th>
														</tr>
	</table>
	
<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>NP<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>