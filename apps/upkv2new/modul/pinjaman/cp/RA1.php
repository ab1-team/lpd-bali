<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.center {text-align:center;}
.kanan {text-align:right; padding-right:4px;}
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];

											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											
											$nama_desa			=$row['nama_desa'];
											$kd_kelompok		=$row['kd_kelompok'];
											$nama_kelompok		=$row['nama_kelompok'];
											$alamat_kelompok	=$row['alamat_kelompok'];
											$telpon				=$row['telpon'];
											$tgl_berdiri		=$row['tgl_berdiri'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_ju'];
											$jenis_kegiatan		=$row['nama_jk'];
											$tingkat_kelompok	=$row['nama_tk'];
											$fungsi_kelompok	=$row['nama_fgs'];
											$ketua				=$row['ketua'];
											$sekretaris			=$row['sekretaris'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
											
											if($status=="P"){$tglstatus=$tgl_proposal; $ket="Tanggal Proposal"; $dok="Proposal";
											}else if($status=="V"){$tglstatus=$tgl_verifikasi; $ket="Tanggal Verifikasi"; $dok="Verifikasi";
											}else if($status=="W" or $status=="A"){$tglstatus=$tgl_cair; $ket="Tanggal Cair"; $dok="Pencairan";
											}
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tglstatus' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tglstatus' "));
		
		

function bulanuitas($ke) {
    	$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='144' "));
$alokasi 		= $dp['alokasi'];
$pros_jasa 		= $dp['pros_jasa']/100;
$jangka			= $dp['jangka'];
$pembagi		= pow(1+$pros_jasa/12,$jangka);
$jumlah 		= bulatkan(($alokasi*$pros_jasa/12)/(1-(1/$pembagi)));
$saldo 			= $alokasi;

for($no=1;$no<=$ke;$no++){
$jasa 			=  bulatkan($saldo*$pros_jasa/12);
$pokok 			=  bulatkan($jumlah-$jasa);
$saldo 			=$saldo-$pokok;
$penambahan 	= $pokok;
if($no>=$jangka){
	$penambahan = 0;
}
$sumpokok 		= $sumpokok + $penambahan;
}

if($ke>=$jangka){
	$pokok 		= $alokasi-$sumpokok;
	$jasa 		= $jumlah-$pokok;
	$saldo      = 0;
}
$anuitas = "$pokok#$jasa#$jumlah#$saldo";
return $anuitas;
}
function bulanupokok($ke){
    $anuitas=bulanuitas($ke);   
	$exp	= explode("#", $anuitas);    
	$pokok = $exp[0];	
	return $pokok;
}
function bulanujasa($ke){
    $anuitas=bulanuitas($ke);
	$exp	= explode("#", $anuitas);   
	$jasa = $exp[1];	
	return $jasa;
}
function bulanujumlah($ke){
    $anuitas=bulanuitas($ke);
	$exp	= explode("#", $anuitas);  
	$jumlah = $exp[2];	 
	return $jumlah;
}
function bulanusaldo($ke){
    $anuitas=bulanuitas($ke);
	$exp	= explode("#", $anuitas);  
	$jumlah = $exp[3];	 
	return $jumlah;
}
		
		
		
function anuitas($ke) {
    	$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='144' "));

$alokasi 		= $dp['alokasi'];
$pros_jasa 		= $dp['pros_jasa']/100;
$jangka			= $dp['jangka'];
$pembagi		= pow(1+$pros_jasa/12,$jangka);
$jumlah 		= ($alokasi*$pros_jasa/12)/(1-(1/$pembagi));
$saldo 			= $alokasi;

for($no=1;$no<=$ke;$no++){
$jasa 			=$saldo*$pros_jasa/12;
$pokok 			= $jumlah-$jasa;
$saldo 			=$saldo-$pokok;
$penambahan 	= $pokok;
if($no>=$jangka){
	$penambahan = 0;
}
$sumpokok 		= $sumpokok + $penambahan;
}

if($ke>=$jangka){
	$pokok 		= $alokasi-$sumpokok;
	$jasa 		= $jumlah-$pokok;
}
$anuitas = "$pokok#$jasa#$jumlah#$saldo";
return $anuitas;
}
function anupokok($ke){
    $anuitas=anuitas($ke);   
	$exp	= explode("#", $anuitas);    
	$pokok = $exp[0];	
	return $pokok;
}
function anujasa($ke){
    $anuitas=anuitas($ke);
	$exp	= explode("#", $anuitas);   
	$jasa = $exp[1];	
	return $jasa;
}
function anujumlah($ke){
    $anuitas=anuitas($ke);
	$exp	= explode("#", $anuitas);  
	$jumlah = $exp[2];	 
	return $jumlah;
}
function anusaldo($ke){
    $anuitas=anuitas($ke);
	$exp	= explode("#", $anuitas);  
	$jumlah = $exp[3];	 
	return $jumlah;
}
		
		
			?>		
		<center class="style6">SIMULASI ANUITAS SIUPK<br> id_pinj : <?php echo $rcp; ?><br><br>
		   
		   
		<table width="40%" border="0" class="style9" align="left" cellpadding="3" cellspacing="0"> 
		   <tr>
		       <td>
		           Alokasi
		       </td>
		       <td>:</td>
		       <td><?php echo number_format($alokasi);?></td>
		   </tr>
		   <tr>
		       <td>
		           Pros_jasa
		       </td>
		       <td>:</td>
		       <td><?php echo $pros_jasa;?> % per tahun</td>
		   </tr>
		   <tr>
		       <td>
		           Jangka
		       </td>
		       <td>:</td>
		       <td><?php echo $jangka;?> bulan</td>
		   </tr>
		   
		<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0"> 
		    <tr>
		        <th width="3%" class="style9 top bottom  left" rowspan=2>
		            NO
		        </th>
		        <th class="style9 top bottom right left" colspan=4>
		            ASLI
		        </th>
		        
		        <th class="style9 top bottom right left" colspan=4>
		            PEMBULATAN
		        </th>
		    </tr>
		    <tr>
		        <th width="12.5%" class="center style9 top bottom  left" >Pokok</th>
		        <th width="12.5%" class="center style9 top bottom  left" >Jasa</th>
		        <th width="12.5%" class="center style9 top bottom  left" >Jumlah</th>
		        <th width="12.5%" class="center style9 top bottom right left" >Saldo Pinjaman</th>
		        <th width="12.5%" class="center style9 top bottom  left" >Pokok</th>
		        <th width="12.5%" class="center style9 top bottom  left" >Jasa</th>
		        <th width="12.5%" class="center style9 top bottom  left" >Jumlah</th>
		        <th width="12.5%" class="center style9 top bottom right left" >Saldo Pinjaman</th>
		    </tr>
		    <?php for($no=1;$no<=$jangka;$no++){
		    $pokok1         = anupokok($no);
		    $jasa1          = anujasa($no);
		    $jumlah1        = anujumlah($no);
		    $saldo1         = anusaldo($no);
		    $pokok2         = bulanupokok($no);
		    $jasa2          = bulanujasa($no);
		    $jumlah2        = bulanujumlah($no);
		    $saldo2         = bulanusaldo($no);
		    $jpokok1        = $jpokok1+$pokok1;
		    $jjasa1         = $jjasa1+$jasa1;
		    $jjumlah1       = $jjumlah1+$jumlah1;
		    $jpokok2        = $jpokok2+$pokok2;
		    $jjasa2         = $jjasa2+$jasa2;
		    $jjumlah2       = $jjumlah2+$jumlah2;
		    
		    ?>
		    <tr>
		        <td class="kanan style9 bottom   left" ><?php echo $no; ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($pokok1,2); ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($jasa1,2); ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($jumlah1,2); ?></td>
		        <td class="kanan style9 bottom right  left" ><?php echo number_format($saldo1,2); ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($pokok2,2); ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($jasa2,2); ?></td>
		        <td class="kanan style9 bottom   left" ><?php echo number_format($jumlah2,2); ?></td>
		        <td class="kanan style9 bottom  right left" ><?php echo number_format($saldo2,2); ?></td>
		    </tr>
<?php } ?>        
		    <tr>
		        <th class="kanan style9 bottom  top left" >&sum;</th>
		        <th class="kanan style9 bottom  top left" ><?php echo number_format($jpokok1); ?></th>
		        <th class="kanan style9 bottom  top left" ><?php echo number_format($jjasa1); ?></th>
		        <th class="kanan style9 bottom  top left" ><?php echo number_format($jjumlah1); ?></th>
		        <th class="kanan style9 bottom top right  left" ><?php echo number_format(); ?></th>
		        <th class="kanan style9 bottom top  left" ><?php echo number_format($jpokok2); ?></th>
		        <th class="kanan style9 bottom top  left" ><?php echo number_format($jjasa2); ?></th>
		        <th class="kanan style9 bottom top  left" ><?php echo number_format($jjumlah2); ?></th>
		        <th class="kanan style9 bottom top right left" ><?php echo number_format(); ?></th>
		    </tr>
		</table>
		 </center>
<title>5. Rencana Ansuran <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
