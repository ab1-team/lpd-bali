<?php session_start();
include "../../../inc/inc.koneksi.php";
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj	= $_POST['id_pinj'] ?: '0';
$jenis_pp	= $_POST['jenis_pp'] ?: '0';
$tgl_cair	= $_POST['tgl_cair'] ?: '0';
$alokasi	= $_POST['alokasi'] ?: '0';
$sumber		= $_POST['sumber'] ?: '0';
$metode		= $_POST['metode'] ?: '0';
$lu			= date('Y-m-d H:i:s') ?: '0';
$user_id	= $_SESSION['id'] ?: '0';
$id_user	= $_SESSION['id'] ?: '0';

$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] pi, anggota_$_SESSION[kd_kab] a WHERE a.id=pi.nia AND pi.id='$id_pinj' "));
$namadepan=addslashes("$kel[namadepan] ($id_pinj)");

//Kode Rekening sesuai dengan metode pembayaran			
			if($metode=="K" AND $jenis_pp==1) {
				$keterangan_transaksi="Pencairan Individu via Kas SPP $namadepan";
				$rekening_debit		="131.01";
				$rekening_kredit	="112.07";
				}elseif($metode=="K" AND $jenis_pp==2) {
				$keterangan_transaksi="Pencairan Individu via Kas UEP $namadepan";
				$rekening_debit		="132.01";
				$rekening_kredit	="113.07";
				}elseif($metode=="K" AND $jenis_pp==4) { //DKU
				$keterangan_transaksi="Pencairan Individu via Kas DKU $namadepan";
				$rekening_debit		="134.01";
				$rekening_kredit	="116.07";
				}elseif($metode=="K" AND $jenis_pp==5) { //DSPP
				$keterangan_transaksi="Pencairan Individu via Kas DSPP $namadepan";
				$rekening_debit		="135.01";
				$rekening_kredit	="117.07";
				}elseif($metode=="B" AND $jenis_pp==1) {
				$keterangan_transaksi="Pencairan Individu via Bank SPP $namadepan";
				$rekening_debit		="131.03";
				$rekening_kredit	="122.07";
				}elseif($metode=="B" AND $jenis_pp==2) {
				$keterangan_transaksi="Pencairan Individu via Bank UEP $namadepan";
				$rekening_debit		="132.03";
				$rekening_kredit	="123.07";
				}elseif($metode=="K" AND $jenis_pp==9) { //IU
				$keterangan_transaksi="Pencairan Individu via Kas IU $namadepan";
				$rekening_debit		="136.01";
				$rekening_kredit	="118.07";
				}elseif($metode=="K" AND $jenis_pp==8) { //SPPro
				$keterangan_transaksi="Pencairan Individu via Kas SPPro $namadepan";
				$rekening_debit		="133.01";
				$rekening_kredit	="115.07";
				}elseif($metode=="K" AND $jenis_pp==3) { //PL
				$keterangan_transaksi="Pencairan Individu via Kas PL $namadepan";
				$rekening_debit		="133.01";
				$rekening_kredit	="115.07";
				}elseif($metode=="K" AND $jenis_pp==10) { //Cash Tempo
				$keterangan_transaksi="Pencairan Individu via Kas CT $namadepan";
				$rekening_debit		="133.01";
				$rekening_kredit	="114.07";
				    
				}elseif($metode=="K" AND $jenis_pp==11) { //Manunggal Motor
				$keterangan_transaksi="Pencairan Individu via Kas MM $namadepan";
				$rekening_debit		="134.01";
				$rekening_kredit	="115.07";
				    
				}elseif($metode=="K" AND $jenis_pp==12) { //Manunggal Karya
				$keterangan_transaksi="Pencairan Individu via Kas MK $namadepan";
				$rekening_debit		="135.01";
				$rekening_kredit	="116.07";
				    
				}elseif($metode=="K" AND $jenis_pp==13) { //Kredit Barang
				$keterangan_transaksi="Pencairan Individu via Kas KB $namadepan";
				$rekening_debit		="137.01";
				$rekening_kredit	="114.07";
				    
				}
				
$jum=mysql_num_rows(mysql_query("SELECT * FROM $table_transaksi WHERE id_pinj_i='$id_pinj'"));

if($jum<=0)	{
		
//ACTION
	$input1	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_cair	='$tgl_cair',
											alokasi		='$alokasi',
											sumber		='$sumber',
											`status`		='A',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input1);

	

	
	$input3 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,id_pinj_i,keterangan_transaksi,jumlah,id_user)
				VALUES(null,'$tgl_cair', '$rekening_debit', '$rekening_kredit','$id_pinj','$keterangan_transaksi','$alokasi','$id_user')";
	mysql_query($input3);
	

	}else{
	alert('Pinjaman ini telah dicairkan');
	}
?>