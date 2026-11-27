<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
$telpon_kec	=$kec['telpon_kec'];
$lembaga	=substr($kec['nama_lembaga_sort'],0,8);
$nama_kec	=strtoupper("$lembaga $kec[nama_kec]");

$tgl_tagihan	=$_POST['tgl_tagihan'];
$perintah		=$_POST['perintah'];
$tgl			=substr($tgl_tagihan,8,2); //2018-11-08


$querye = "SELECT datediff('$tgl_tagihan', CURDATE()) as selisih";
				$hasil = mysql_query($querye);
				$data  = mysql_fetch_array($hasil);

				$selisih = $data['selisih'];
				 
				$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
				$namahari = date("l", $x);
				 
				if ($namahari == "Sunday") { $namahari = "Minggu"; }
				else if ($namahari == "Monday") { $namahari = "Senin"; }
				else if ($namahari == "Tuesday") { $namahari = "Selasa"; }
				else if ($namahari == "Wednesday") { $namahari = "Rabu"; }
				else if ($namahari == "Thursday") { $namahari = "Kamis"; }
				else if ($namahari == "Friday") { $namahari = "Jumat"; }
				else if ($namahari == "Saturday") { $namahari = "Sabtu"; }

$hari		=strtoupper($namahari);				
$tgltagihan	=tgl_ind($tgl_tagihan);


							
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }
.text-center {text-align:center; }
.red {color:red; }
.green {color:green; }
-->
</style>
<body onLoad="window.print()">


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="8" class="bottom">
				<div class="style9 text-align-left"><?php echo "$kec[nama_lembaga_sort] $kec[sebutan_kec] $kec[nama_kec]";?><br>
				<?php echo $kec['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_kec'];?>
				</div>
			</td>
		  </tr> 	  
</table>

<?php
if ($perintah=='preview') {
?>


<p align="center" class="style6">LAPORAN TAGIHAN<br>JATUH TEMPO : <?php echo tgl_indo($tgl_tagihan);?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="5%" class="style9 left bottom top" >LOAN ID</th>
              <th width="7%" class="style9 left bottom top">TGL CAIR</th>
              <th width="35%" class="style9 left bottom top">NAMA KELOMPOK</th>
              <th width="10%" class="style9 left bottom top">POKOK</th>
              <th width="10%" class="style9 left bottom top">JASA</th>
              <th width="10%" class="style9 left bottom top">JUMLAH</th>
              <th width="15%" class="style9 left bottom top right">KETERANGAN</th>
        </tr>    
		
<?php 	

$table_kelompok	="kelompok_$_SESSION[kd_kab]";
		$table_pk		="pinjaman_kelompok_$_SESSION[kd_kab]";
		$view=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
							WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND 
							substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
							
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idpinj			=$row['id'];
								$tgl_cair		=$row['tgl_cair'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_tagihan-$idpinj");
								$nunggakpokok	=nunggakpokok("$tgl_tagihan-$idpinj");
								$nunggakjasa	=nunggakjasa("$tgl_tagihan-$idpinj");
				
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $idpinj;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_cair); ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $row['kd_kelompok']." - ".strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']);?></span></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakjasa); ?></td>
			  <td class="style9 left top text-right"><?php echo number_format($nunggakpokok+$nunggakjasa); ?></td>
              <td class="style9 left top right">&nbsp;</td>
            </tr>
  <?php 
$tot_pokok	=$tot_pokok+$nunggakpokok;
$tot_jasa	=$tot_jasa+$nunggakjasa;
$tot_jumlah	=$tot_pokok+$tot_jasa;
  } ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="4"><div align="center" >JUMLAH</div></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_pokok);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jasa);?></th>
              <th class="style9 left bottom top text-right"><?php echo number_format($tot_jumlah);?></th>
              <th class="style9 left bottom top right">&nbsp;</th>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<?php
}else if ($perintah=='terkirim') {
?>


<p align="center" class="style6">LAPORAN SMS TERKIRIM<br>TANGGAL : <?php echo tgl_indo($tgl_tagihan);?> </p>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="5%" class="style9 left bottom top" >TGL KIRIM</th>
              <th width="7%" class="style9 left bottom top">TERKIRIM KE</th>
              <th width="10%" class="style9 left bottom top">LOAN ID</th>
              <th width="35%" class="style9 left bottom top">ISI SMS</th>
              <th width="10%" class="style9 left bottom top">JENIS SMS</th>
        </tr>    
		
<?php 	
		$view=mysql_query("SELECT * FROM sms_backup
							WHERE CreatorID='$_SESSION[lokasi]' AND tgl_kirim='$tgl_tagihan' ORDER BY id ASC ");
							
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$tgl_kirim			=$row['tgl_kirim'];
								$nomor				=$row['DestinationNumber'];
								$loan_id			=$row['loan_id'];
								$isi				=$row['TextDecoded'];
								$js			=$row['jenis_sms'];
								if($js==1) {$jenis_sms="Notifikasi Pembayaran"; }else if($js==2) { $jenis_sms="SMS Tagihan"; }
				
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo tgl_ind($tgl_kirim);?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $nomor; ?></div></td>
              <td class="style9 left top text-center"><span class="style9"><?php echo $loan_id;?></span></td>
			  <td class="style9 left top"><?php echo $isi; ?></td>
			  <td class="style9 left top text-center"><?php echo $jenis_sms; ?></td>
            </tr>
			
								<?php } ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>

<?php
}else if ($perintah=='kirim') {
	
	$table_kelompok	="kelompok_$_SESSION[kd_kab]";
		$table_pk		="pinjaman_kelompok_$_SESSION[kd_kab]";
		$v=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
							WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND 
							substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
	while($r=mysql_fetch_array($v)){
								$no=$no+1;
								$idpinj			=$r['id'];
								$tgl_cair		=$r['tgl_cair'];
								$tgl_now		=date('Y-m-d');
								$saldopinjaman	=saldopinjaman("$tgl_tagihan-$idpinj");
								$nunggakpokok	=nunggakpokok("$tgl_tagihan-$idpinj");
								$nunggakjasa	=nunggakjasa("$tgl_tagihan-$idpinj");
								$namakelompok	=strtoupper(addslashes("$r[nama_kelompok]"));
								$telpon			=$r['telpon'];
								$jumhp			=strlen($telpon);
	
	$cek_sms=mysql_num_rows(mysql_query("SELECT * FROM sms_backup WHERE jenis_sms='2' AND tgl_kirim='$tgl_now' AND loan_id='$_SESSION[lokasi]-$idpinj' "));
	
// SMS TAGIHAN 
	
	$total_tagihan=number_format($nunggakpokok+$nunggakjasa);
		$TextDecoded="[$nama_kec] ANGSURAN $namakelompok Rp.$total_tagihan AKAN MEMASUKI JATUH TEMPO, MOHON SEGERA DIBAYARKAN SEBELUM $hari $tgltagihan, TERIMAKASIH. INFO:$telpon_kec.";
		
	if ($total_tagihan!=0 AND $jumhp>=10 AND $cek_sms<=0) {
		$query	=mysql_query("INSERT INTO sms_ucapan (id,DestinationNumber,TextDecoded,CreatorID)
				VALUES('','$telpon','$TextDecoded', '$_SESSION[lokasi]')");
				
		$query2	=mysql_query("INSERT INTO sms_backup (id,jenis_sms,tgl_kirim,loan_id,DestinationNumber,TextDecoded,CreatorID)
				VALUES('','2','$tgl_now','$_SESSION[lokasi]-$idpinj','$telpon','$TextDecoded', '$_SESSION[lokasi]')");
	}	
				
	if ($query){
          echo '
		 <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9 bottom right">
			<tr>	  
				<td height="34" class="left">'.$TextDecoded.'</td>
				<td width="15%" class="left green" >BERHASIL DIANTRIKAN</td>
			</tr>
			</table>
		  ';
        }else{
          echo '
		  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9 bottom right">
			<tr>	  
				<td height="34" class="left">'.$TextDecoded.'</td>
				<td width="15%" class="left red" >GAGAL DIANTRIKAN</td>
			</tr>
			</table>
		  ';
        } 
				
	}
	
	echo '
	<p class="style6">Kenapa SMS Tagihan Gagal Diantrikan?</p>
	<ul class="style12">
		<li>Nomor penerima SMS tidak ditemukan atau penulisan nomor tidak valid, contoh nomor yang valid : 085743071234, contoh penulisan yang salah : 085-743-07-1234</li>
		<li>SMS Tagihan telah dikirimkan sebelumnya, dihari yang sama sistem kami membatasi 1 pengiriman untuk 1 kelompok.</li>
	</ul>
	';
	
}
?>

<title>LAPORAN TAGIHAN</title>
       
</body>
