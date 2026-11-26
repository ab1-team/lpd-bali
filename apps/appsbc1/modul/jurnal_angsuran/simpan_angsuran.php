<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];



$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
$idtp			=$idt[0]+1;
			
$id_pinj				=$_POST['id_pinj'];	
$_SESSION['id_pinj']	=$id_pinj;			
$jenis_pp				=$_POST['jenis_pp'];			
$tgl_transaksi			=$_POST['datetimepicker1'];			
$urutan					=0;			
$pokok					=$_POST['pokok'];
$jasa					=$_POST['jasa'];
$denda					=$_POST['denda'];
$id_user				=$_SESSION['id'];

$tgl_kondisi			=date('Y-m-d');

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]'"));
$telpon_kec	=$kec['telpon_kec'];
$lembaga	=substr($kec['nama_lembaga_sort'],0,8);
$nama_kec	=strtoupper("$lembaga $kec[nama_kec]");
$u=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$id_user'"));



$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k WHERE k.id=pk.id_kel AND pk.id='$id_pinj' "));
$nama_kelompok=addslashes("$kel[nama_kelompok] ($id_pinj)");

$namakelompok=strtoupper(addslashes("$kel[nama_kelompok]"));
$telpon			=$kel['telpon'];		
$jenis_jasa		=$kel['jenis_jasa'];

			if($jenis_pp==1) { //SPP
				$nama_jp		="SPP";
				$rek_pokok_d	="112.01";
				$rek_jasa_d		="112.02";
				$rek_denda_d	="112.03";
				$rek_pokok_k	="131.02";
				$rek_jasa_k		="411.01";
				$rek_denda_k	="411.03";
				}
				elseif($jenis_pp==2) { //UEP
				$nama_jp		="UEP";
				$rek_pokok_d	="113.01";
				$rek_jasa_d		="113.02";
				$rek_denda_d	="113.03";
				$rek_pokok_k	="132.02";
				$rek_jasa_k		="411.02";
				$rek_denda_k	="411.04";
				}
				elseif($jenis_pp==3) { //PL
				$nama_jp		="PL";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}
				elseif($jenis_pp==4) { //DKU
				$nama_jp		="DKU";
				$rek_pokok_d	="116.01";
				$rek_jasa_d		="116.02";
				$rek_denda_d	="116.03";
				$rek_pokok_k	="134.02";
				$rek_jasa_k		="411.08";
				$rek_denda_k	="411.09";
				}
				elseif($jenis_pp==5) { //DSPP
				$nama_jp		="DSPP";
				$rek_pokok_d	="117.01";
				$rek_jasa_d		="117.02";
				$rek_denda_d	="117.03";
				$rek_pokok_k	="135.02";
				$rek_jasa_k		="411.10";
				$rek_denda_k	="411.11";
				}elseif($jenis_pp==6) { //P2B
				$nama_jp		="P2B";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}elseif($jenis_pp==7) { //PKKPM
				$nama_jp		="PKKPM";
				$rek_pokok_d	="116.01";
				$rek_jasa_d		="116.02";
				$rek_denda_d	="116.03";
				$rek_pokok_k	="134.02";
				$rek_jasa_k		="411.08";
				$rek_denda_k	="411.09";
				}elseif($jenis_pp==8) { //SPPro
				$nama_jp		="SPPro";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}

$input_pokok = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_pokok_d', '$rek_pokok_k','$idtp','$id_pinj','Angs.Pokok $nama_jp $nama_kelompok','$pokok','$urutan','$id_user')";
							
$input_jasa = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_jasa_d', '$rek_jasa_k','$idtp','$id_pinj','Angs.Jasa $nama_jp $nama_kelompok','$jasa','$urutan','$id_user')";
				
$input_denda = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_denda_d', '$rek_denda_k','$idtp','$id_pinj','Denda $nama_jp $nama_kelompok','$denda','$urutan','$id_user')";
							
if ($pokok<=0 and $jasa>0 and $denda>0){
	mysql_query($input_jasa);
	mysql_query($input_denda);
	
}else if ($pokok>0 and $jasa<=0 and $denda>0){
	mysql_query($input_pokok);
	mysql_query($input_denda);
	
}else if ($pokok>0 and $jasa>0 and $denda<=0){
	mysql_query($input_pokok);
	mysql_query($input_jasa);
	
}else if ($pokok>0 and $jasa<=0 and $denda<=0){
	mysql_query($input_pokok);
	
}else if ($pokok<=0 and $jasa>0 and $denda<=0){
	mysql_query($input_jasa);
	
}else if ($pokok<=0 and $jasa<=0 and $denda>0){
	mysql_query($input_denda);
	
}else if($pokok>0 and $jasa>0 and $denda>0){
	mysql_query($input_pokok);
	mysql_query($input_jasa);
	mysql_query($input_denda);
	
}

//SMS
$jumhp		=strlen($telpon); //Memeriksa jumlah digit pada nomor telpon, normalnya minimal ada 10 digit
$numerik	=is_numeric($telpon); //Memeriksa apakah nomor telpon berupa Angka
if($jumhp>=10 AND $numerik==1) {
	
$saldo			=saldopinjaman("$tgl_kondisi-$id_pinj");

$saldo_jasa		=saldo_jasa("$tgl_kondisi-$id_pinj");

if($jenis_jasa==1) { $saldopinjaman_jasa=$saldo_jasa; }else{$saldopinjaman_jasa=0; }

$totalsaldo	=number_format($saldo+$saldopinjaman_jasa);
if($totalsaldo==0) { $total_saldo="PELUNASAN"; }else{$total_saldo="SALDO Rp.$totalsaldo"; }

$total_bayar=number_format($pokok+$jasa+$denda);
$tgltransaksi	=tgl_ind($tgl_transaksi);
$TextDecoded="[$nama_kec] $tgltransaksi TELAH DITERIMA ANGSURAN $namakelompok Rp.$total_bayar, $total_saldo, TERIMAKASIH. INFO-HUB:$telpon_kec.";
$query=mysql_query("INSERT INTO sms_ucapan (id,DestinationNumber,TextDecoded,CreatorID)
				VALUES('','$telpon','$TextDecoded', '$_SESSION[lokasi]')");
				
mysql_query("INSERT INTO sms_backup (id,jenis_sms,tgl_kirim,loan_id,DestinationNumber,TextDecoded,CreatorID)
				VALUES('','2','$tgl_now','$_SESSION[lokasi]-$idpinj','$telpon','$TextDecoded', '$_SESSION[lokasi]')");
if($query) {
	$_SESSION['sms']="terkirim"; //untuk membuat notifikasi pengiriman SMS ke file modul/jurnal_angsuran/sukses_angsuran.php
	$_SESSION['telpon']=$telpon;
}else{
	$_SESSION['sms']="failed";
}
				
}
?>