<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";
include "../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

?>

<style type="text/css">
<!--
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 20px; font-weight: bold; text-align:center; }
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; text-align:center; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.top  {border-top: 1px solid #000000; }
.bottom {border-bottom: 1px solid #000000; }
.left {border-left: 1px solid #000000; }
.right  {border-right: 1px solid #000000; }
.all  {border: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; }
.center {text-align:center; }
.justify {text-align:justify; }
-->
</style>
<body onLoad="window.print()">

         <?php
    $ids=$_GET['ids'];
    $lem=mysql_fetch_array(mysql_query("select * from sebutan_desa sd, desa d WHERE sd.id=d.sebutan AND d.id='$_SESSION[lokasi]'"));
    $row=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa WHERE a.id=sa.nia AND sa.id='$ids'"));
    $u=mysql_fetch_array(mysql_query("select * from users WHERE level='1' AND jabatan='1'"));
								
		$id_pinj      =$row['id'];
		$jangka      =$row['jangka'];
		$pros_jasa	=$row['pros_jasa'];
		$tgl_buka	=$row['tgl_buka'];
		$tanggal	= substr($tgl_buka,8,2);
		
		$tgl_lunas = date('Y-m-d', strtotime('+'.$jangka.' month', strtotime($tgl_buka)));
	
      ?>
  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0"  class="style9 justify">
       <tr>
			<td height="20" colspan="3" class="all">
				<div class="style16 text-align-left">
				<img class='' alt='...' src='../../images/logo_bumdes.png' style='float:left; width:90; margin-left:20px;'/>
				<?php
					echo "<div class='style16'>".strtoupper("<b>".LEMBAGA_LONG." <br> $lem[sebutan_desa] $lem[nama_desa]</b>")."<br><span class='style27'>$lem[alamat_desa] Telp. $lem[telpon_desa]</span> </div>"; 
                  ?>      
				</div>			
			</td>
	  </tr>
       <tr>
         <td height="20" colspan="3" align="center" class="style10 left right">SURAT DEPOSITO BERJANGKA<br>
             <span class="style9">NOMOR. <?php echo "$row[nomor_rekening]/SB/".LEMBAGA_SORT.tgl_rom($tgl_buka).""; ?></span></td>
       </tr>
       <tr>
         <td height="20" colspan="3" class="left right">Telah diterima penyetoran deposito berjangka dari : </td>
       </tr>
       <tr>
         <td height="20" class="left">Nama Kreditur </td>
         <td height="20" colspan="2" class="right">: <strong><?php echo strtoupper("$row[namadepan]");?></strong></td>
       </tr>
       <tr>
         <td height="20" class="left">Alamat</td>
         <td height="20" colspan="2" class="right">: <strong><?php echo strtoupper("$row[alamat]");?></strong></td>
       </tr>
       <tr>
         <td height="20" class="left">Uang Sejumlah </td>
         <td height="20" colspan="2" class="right">: <strong><?php echo number_format($row['jumlah'],0,",",".");?></strong></td>
       </tr>
       <tr>
         <td width="20%" height="20" class="left">Terbilang</td>
         <td height="20" colspan="2" class="right">: <strong><?php echo strtoupper(ucwords(toTerbilang($row['jumlah']))); ?> RUPIAH</strong></td>
       </tr>
       <tr>
         <td height="20" colspan="3" class="left right">Untuk disimpan berjangka dalam waktu <strong><?php echo $row['jangka'];?> </strong>bulan, mulai sejak tanggal <strong><?php echo tgl_indo($row['tgl_buka']);?></strong> sampai dengan tanggal <strong><?php echo tgl_indo($tgl_lunas);?></strong> dengan bunga <strong><?php echo $pros_jasa; ?>%</strong> per bulan dengan syarat-syarat yang telah ditetapkan oleh <?php echo LEMBAGA_SORT; ?> <?php echo "$lem[sebutan_desa] $lem[nama_desa]";?>.</td>
       </tr>
       <tr>
         <td height="20" class="left">&nbsp;</td>
         <td width="31%" height="20">
		 <?php
//Membuat QR-Code
$qr="../../images/qrcode/$row[nik].png";
$tempdir = "../../images/qrcode/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($qr)) { 
	
		$isi_teks = $row['nik'];
		$namafile = $row['nik'].".png";
		$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 3;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
}	
		 echo "<img src='$qr' style='margin:-15px 0 -30px 0;'/>";
		?>
		 </td>
         <td width="49%" align="center" class="right"><span class="style9"><?php echo "$lem[nama_desa]";?>, <?php echo tgl_indo($row['tgl_buka']);?><br>Kepala,</span>
		 <br><br><br><br>
		 	<br><br>
		   <strong><?php echo strtoupper("$u[namadepan] $u[namabelakang]");?></strong></td>
       </tr>
       <tr>
         <td height="20" colspan="3" class="left right"><strong>Kwitansi:</strong><br>
         Yang bertanda tangan dibawah ini telah menerima kembali uang simpanan berjangka nomor <?php echo "$row[nomor_rekening]/SB/".LEMBAGA_SORT.tgl_rom($tgl_buka).""; ?> seperti tersebut diatas dari <?php echo LEMBAGA_LONG; ?> <?php echo "$lem[sebutan_desa] $lem[nama_desa]";?>.</td>
       </tr>
       <tr>
         <td height="20" class="left bottom center style16" colspan="2">Rp. <?php echo number_format($row['jumlah'],0,",",".");?></td>
         <td height="20" align="center" class="right bottom"><span class="style9"><?php echo "$lem[nama_desa]";?>, <?php echo tgl_indo($row['tgl_tutup']);?><br>
           Penerima,</span><br>
           <br>
           <br>
         <br>
         <strong><?php echo strtoupper("$row[namadepan]");?></strong></td>
       </tr> 
</table>

<title>Sertifikat Berjangka <?php echo "$row[namadepan] ($ids)";?></title>
       
</body>
