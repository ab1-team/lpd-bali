<?php session_start();
include "../../../inc/inc.koneksi.php";
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj			= $_POST['id_pinj'];
$tgl_cair			= $_POST['tgl_cair'];
$alokasi			= str_replace(".", "", $_POST['alokasi']);
$biaya_administrasi	= str_replace(".", "", $_POST['biaya_administrasi']);
$biaya_materai		= str_replace(".", "", $_POST['biaya_materai']);
$kas_materai		= str_replace(".", "", $_POST['kas_materai']);
$pendapatan_materai	= str_replace(".", "", $_POST['pendapatan_materai']);
$biaya_lainnya		= str_replace(".", "", $_POST['biaya_lainnya']);
$total_penerimaan	= str_replace(".", "", $_POST['total_penerimaan']);
$metode_bayar		= $_POST['metode_bayar'];
$id_simpanan		= $_POST['nomor_rekening'];
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];
$id_user			= $_SESSION['id'];

if($id_pinj<9){$lid="000$id_pinj";}else if($id_pinj<99){$lid="00$id_pinj";}else if($id_pinj<999){$lid="0$id_pinj";}else{$lid="$id_pinj";}

$ids=mysql_fetch_array(mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[kd_kab] WHERE id='$id_simpanan' "));
$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] pi, anggota_$_SESSION[kd_kab] a WHERE a.id=pi.nia AND pi.id='$id_pinj' "));
$namadepan=addslashes("$kel[namadepan]");

//Keterangan Transaksi sesuai dengan metode pembayaran			
			if($metode_bayar=="tunai") {
				$keterangan_transaksi="Pencairan via Kas Tunai LID $lid a.n. $namadepan";
				}elseif($metode_bayar=="transfer") {
				$keterangan_transaksi="Pencairan LID $lid via Kas Transfer ke No.Rek $ids[nomor_rekening] $namadepan";
				}
				
$jum=mysql_num_rows(mysql_query("SELECT * FROM $table_transaksi WHERE rekening_debit='1-10005_$id_pinj'"));

if($jum<=0)	{
		
//1. Ubah Status Pinjaman menjadi A
	$input1	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_cair	='$tgl_cair',
											alokasi		='$alokasi',
											`status`		='A',
											lu			='$lu',
											user_id		='$user_id'
						WHERE id= '$id_pinj'";
	mysql_query($input1);


//2. Inputkan Data Transaksi Pencairan /Kredit Kas dan Debet Pinjaman
	$input2 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10005_$id_pinj', '1-10001','0','$keterangan_transaksi','$alokasi','$id_user')";
	mysql_query($input2);
	
	
//3. Inputkan Data Transaksi Pendapatan Administrasi
if($biaya_administrasi>0) {
	$input3 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10001', '4-60003_$id_pinj','0','Pendapatan Adm kredit LID $id_pinj $namadepan','$biaya_administrasi','$id_user')";
	mysql_query($input3);
}


//4. Inputkan Data Transaksi Pembelian dan Pendapatan Materai
if($kas_materai>0) {
	$input4a = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10001', '1-30001_$id_pinj','0','Pembayaran Materai dari $namadepan','$kas_materai','$id_user')";
	mysql_query($input4a);
}

if($pendapatan_materai>0) {
	$input4b = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10001', '4-60004_$id_pinj','0','Pendapatan Materai dari $namadepan','$pendapatan_materai','$id_user')";
	mysql_query($input4b);
}

//5. Inputkan Data Transaksi Pendapatan Lainnya
if($biaya_lainnya>0) {
	$input5 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10001', '4-70004_$id_pinj','0','Pembayaran Lainnya dari $namadepan','$biaya_lainnya','$id_user')";
	mysql_query($input5);
}

//6. Jika Metode Transfer ke Tabungan, Inputkan Data Transaksi Setoran Simpanan ke Kas
if($metode_bayar=="transfer") {
	$input6 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,id_user)
				VALUES('','$tgl_cair', '1-10001', '2-40002_$id_simpanan','0','Transfer dari Pencairan LID $id_pinj $namadepan','$total_penerimaan','$id_user')";
	mysql_query($input6);
}

	}else{
	alert('Pinjaman ini telah dicairkan');
	}
?>