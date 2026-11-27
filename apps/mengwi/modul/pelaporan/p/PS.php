<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";

$lokasi				=$_SESSION['lokasi'];
$idf				=substr($jenis_laporan,3);
$d					=$_POST['d'];
$m					=$_POST['m'];
$y					=$_POST['y'];
$tgl				="$y-$m-$d";
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
$thn_kondisi		="$y-01-01";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten a, kecamatan c where a.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$js=mysql_fetch_array(mysql_query("SELECT * FROM jenis_simpanan where id='$idf' "));
$jss=$js['nama_js'];

?>


<style type="text/css">
<!--
.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px;font-weight: bold;  }
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Arial, Helvetica, sans-serif}
.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PS-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN SIMPANAN <?= ($idf == '1') ? 'UMUM':'ANGGOTA'; ?> <br><?php echo strtoupper("$_POST[report] ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="15%" rowspan="2" class="left bottom">Nomor Rekening - JS</a></th>
			  <th width="5%" rowspan="2" class="left bottom">Tgl Buka</a></th>
              <th width="3%" rowspan="2" class="left bottom">CIF</a></th>
              <th width="15%" rowspan="2" class="left bottom">Nama Pemanfaat</a></th>
              <th width="20%" rowspan="2" class="left bottom">Alamat</a></th>
              <th colspan="2" class="left bottom">Mutasi</a></th>
              <th width="8%" rowspan="2" class="left bottom right">Saldo</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="8%" class="left bottom">Debit</th>
              <th width="8%" class="left bottom">Kredit</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.kd_kab=$_SESSION[kd_kab] ORDER BY d.id ASC");
		while($r = mysql_fetch_array($data)){
		$idd = $r['id'];
		$no = $no+1;
		$row = mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		
		$view = mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, jenis_simpanan sa, simpanan_anggota_$_SESSION[kd_kab] pi WHERE 
		a.id=pi.nia AND pi.jenis_simpanan=sa.id AND a.desa='$r[id]' AND jenis_simpanan='$idf' AND pi.lokasi=$_SESSION[lokasi] AND
		pi.tgl_buka >0  AND pi.tgl_buka <= '$tgl_kondisi' AND pi.status='A' ORDER BY a.nik ASC"); 
		if (mysql_num_rows($view)!=0){
		?>
		<tr>
			<td class="style27 left top right" colspan="9"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
			
	<?php } /*		<td class="style27 left top align-right">debit</td>
			<td class="style27 left top align-right">kredit</td>
			<td class="style27 left top align-right">saldo</td>
			<td class="style27 left top align-right">Status</td>    */ ?>
		</tr>
		<?php
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$debit		=sumnabung("$tgl_kondisi-$idp");
		$kredit		=sumambil("$tgl_kondisi-$idp");
		$saldo		=saldosimpanan("$tgl_kondisi-$idp");
		
		?>
		<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[nomor_rekening]"." - "."$jss"; ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($row['tgl_buka']); ?></td>
			  <td class="left top" align="center">	<?php echo "$row[id]";?></td>
			  <td class="left top" align="left">	<?php echo "$row[namadepan]";?></td>
              <td class="left top" align="left">	<?php echo "$row[alamat]";?></td>
              <td class="left top">					<?php echo number_format($debit);?></td>
              <td class="left top">					<?php echo number_format($kredit);?></td>
              <td class="left top right">			<?php echo number_format($saldo);?></td>
              
		</tr>
		<?php 
    		$sumdebit			=$sumdebit+$debit;
    		$sumkredit	    	=$sumkredit+$kredit;
    		$sumsaldo	    	=$sumsaldo+$saldo;
		    }
		}
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="6">Total</td>
			  <td class="left top">					<?php echo number_format($sumdebit);?></td>
              <td class="left top">					<?php echo number_format($sumkredit);?></td>
              <td class="left top right">			<?php echo number_format($sumsaldo);?></td>
		</tr>
		<td class="style10 top" colspan="17">&nbsp;</td>
</table>

<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>
		
</body>
<title>ps<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>