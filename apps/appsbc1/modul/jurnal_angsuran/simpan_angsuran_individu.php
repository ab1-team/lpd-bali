<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
$idtp			=$idt[0]+1;

$ds=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]'"));
$nama_desa	=strtoupper($ds['nama_desa']);
$telpon_desa	=$ds['telpon_desa'];
			
$id_pinj				=$_POST['id_pinj'];	
$_SESSION['id_pinj']	=$id_pinj;						
$tgl_transaksi			=$_POST['tgl_transaksi'];			
$urutan					=0;			
$pokok					=str_replace(".", "", $_POST['pokok']);
$jasa					=str_replace(".", "", $_POST['jasa']);
$denda					=str_replace(".", "", $_POST['denda']);
$id_user				=$_SESSION['id'];

$angg=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] pi, anggota_$_SESSION[kd_kab] a WHERE a.id=pi.nia AND pi.id='$id_pinj' "));
$namadepan	=addslashes("$angg[namadepan] ($id_pinj)");
$nama		=strtoupper(addslashes("$angg[namadepan]"));
$nomor_rekening			=$angg['no_rekening'];
$telpon			=$angg['hp'];
$jenis_jasa		=$angg['jenis_jasa'];

				$kas			="1-10001";
				$rek_pokok_k	="1-10005_$id_pinj";
				$rek_jasa_k		="4-60001_$id_pinj";
				$rek_denda_k	="4-60002_$id_pinj";


$input_pokok = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$kas', '$rek_pokok_k','$idtp','Angs.Pokok $nomor_rekening $namadepan','$pokok','$urutan','$id_user')";
							
$input_jasa = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$kas', '$rek_jasa_k','$idtp','Angs.Jasa $nomor_rekening $namadepan','$jasa','$urutan','$id_user')";
				
$input_denda = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$kas', '$rek_denda_k','$idtp','Denda $nomor_rekening $namadepan','$denda','$urutan','$id_user')";
							
if ($pokok>0){
	mysql_query($input_pokok);
}

if ($jasa>0){
	mysql_query($input_jasa);
}

if ($denda>0){
	mysql_query($input_denda);
}


//SMS
$jumhp		=strlen($telpon); //Memeriksa jumlah digit pada nomor telpon, normalnya minimal ada 10 digit
$numerik	=is_numeric($telpon); //Memeriksa apakah nomor telpon berupa Angka 1=true, 0=false
if($jumhp>=10 AND $numerik==1) { 
	
$saldo			=saldopinjaman("$tgl_kondisi-$id_pinj");

$saldo_jasa		=saldo_jasa("$tgl_kondisi-$id_pinj");

if($jenis_jasa==1) { $saldopinjaman_jasa=$saldo_jasa; }else{$saldopinjaman_jasa=0; }

$totalsaldo	=number_format($saldo+$saldopinjaman_jasa);
if($totalsaldo==0) { $total_saldo="PELUNASAN"; }else{$total_saldo="SALDO Rp.$totalsaldo"; }

$total_bayar=number_format($pokok+$jasa+$denda);
$tgltransaksi	=tgl_ind($tgl_transaksi);
$TextDecoded="[LPD $nama_desa] $tgltransaksi TELAH DITERIMA ANGSURAN $nama Rp.$total_bayar, $total_saldo, TERIMAKASIH. INFO-HUB:$telpon_desa.";
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