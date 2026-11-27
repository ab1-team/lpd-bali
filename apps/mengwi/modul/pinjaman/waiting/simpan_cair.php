<?php session_start();
include "../../../inc/inc.koneksi.php";
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj	= $_POST['id_pinj'];
$jenis_pp	= $_POST['jenis_pp'];
$tgl_cair	= $_POST['tgl_cair'];
$alokasi	= $_POST['alokasi'];
$sumber		= $_POST['sumber'];
$metode		= $_POST['metode'];
$lu			= date('Y-m-d H:i:s');
$user_id	= $_SESSION['id'];
$id_user	= $_SESSION['id'];

$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k WHERE k.id=pk.id_kel AND pk.id='$id_pinj' "));
$nama_kelompok=addslashes("$kel[nama_kelompok] ($id_pinj)");

//Kode Rekening sesuai dengan metode pembayaran			
			if($metode=="K" AND $jenis_pp==1) {
				$keterangan_transaksi="Pencairan via Kas SPP $nama_kelompok";
				$rekening_debit		="131.01";
				$rekening_kredit	="112.07";
				}elseif($metode=="K" AND $jenis_pp==2) {
				$keterangan_transaksi="Pencairan via Kas UEP $nama_kelompok";
				$rekening_debit		="132.01";
				$rekening_kredit	="113.07";
				}elseif($metode=="K" AND $jenis_pp==4) { //DKU
				$keterangan_transaksi="Pencairan via Kas DKU $nama_kelompok";
				$rekening_debit		="134.01";
				$rekening_kredit	="116.07";
				}elseif($metode=="B" AND $jenis_pp==1) {
				$keterangan_transaksi="Pencairan via Bank SPP $nama_kelompok";
				$rekening_debit		="131.03";
				$rekening_kredit	="122.07";
				}elseif($metode=="B" AND $jenis_pp==2) {
				$keterangan_transaksi="Pencairan via Bank UEP $nama_kelompok";
				$rekening_debit		="132.03";
				$rekening_kredit	="123.07";
				}
				elseif($metode=="K" AND $jenis_pp==3) {
				$keterangan_transaksi="Pencairan via Kas PL $nama_kelompok";
				$rekening_debit		="133.01";
				$rekening_kredit	="115.07";
				}
				elseif($metode=="K" AND $jenis_pp==6) {
				$keterangan_transaksi="Pencairan via Kas P2B $nama_kelompok";
				$rekening_debit		="133.01";
				$rekening_kredit	="115.07";
				}
				elseif($metode=="K" AND $jenis_pp==7) {
				$keterangan_transaksi="Pencairan via Kas PKKPM $nama_kelompok";
				$rekening_debit		="134.01";
				$rekening_kredit	="116.07";
				}elseif($metode=="K" AND $jenis_pp==8) {
				$keterangan_transaksi="Pencairan via Kas SPPro $nama_kelompok";
				$rekening_debit		="133.01";
				$rekening_kredit	="115.07";
				}
				
$jum=mysql_num_rows(mysql_query("SELECT * FROM $table_transaksi WHERE id_pinj='$id_pinj'"));

if($jum<=0)	{
		
//ACTION
	$input1	= "UPDATE pinjaman_kelompok_$_SESSION[kd_kab] SET tgl_cair	='$tgl_cair',
											alokasi		='$alokasi',
											sumber		='$sumber',
											`status`	='A',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input1);

	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_cair		='$tgl_cair',
											sumber		='$sumber',
											`status`	='A',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id_pinkel= '$id_pinj'";
	mysql_query($input2);
	

	
	$input3 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_cair', '$rekening_debit', '$rekening_kredit','0','$id_pinj','0','$keterangan_transaksi','$alokasi','0','$id_user')";
	mysql_query($input3);
	

	}else{
	alert('Pinjaman ini telah dicairkan');
	}
?>