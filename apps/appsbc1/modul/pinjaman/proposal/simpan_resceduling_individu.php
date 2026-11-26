<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idpinjres		= $_POST['idpinjres'];
$niares			= $_POST['niares'];
$jenis_ppres	= $_POST['jenis_ppres']; // Jenis PP Perubahan
$jenis_ppasli	= $_POST['jenis_ppasli']; //Jenis PP Asli
$tglres			= $_POST['tglres'];
$alokasires		= $_POST['alokasires'];
$saldopinjamanres= $_POST['saldopinjamanres'];
$pros_jasares	= $_POST['pros_jasares'];
$jenis_jasares	= $_POST['jenis_jasares'];
$jangkares		= $_POST['jangkares'];
$sistemres		= $_POST['sistemres'];
$sa_jasares		= $_POST['sa_jasares'];
$user_id		= $_SESSION['id'];
$lu				= date('Y-m-d H:i:s');
$tgl			= date('Y-m-d');
$status			= "A";


$kel=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE id='$niares'"));
$namadepan	=$kel['namadepan'];


	//1. Mengubah Pinjaman Lama Menjadi R
	$update	= "UPDATE $table SET 			tgl_lunas			='$tglres',
											`status`				='R',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$idpinjres' AND `status`='A' ";
	mysql_query($update);					
	
	//2. Menginsert transaksi pelunasan ke tabel transaksi
	$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
	$idtp			=$idt[0]+1;


	$input2 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglres','111.01','131.02','$idtp','$idpinjres','Angsuran Rescedulling $namadepan ($idpinjres)','$saldopinjamanres','0','$user_id')";
	mysql_query($input2);
	
	
	
	//3. Menginsert pinjaman baru ke tabel Pinjaman_anggota
	$input3 = "INSERT INTO $table (lokasi,jenis_pinjaman, id_kel,id_pinkel,jenis_pp,nia,tgl_cair,alokasi,spk_no,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$_SESSION[lokasi]','I','0','0','1','$niares','$tglres', '$alokasires','','$pros_jasares','$jenis_jasares','$jangkares','$sistemres','$sa_jasares','$status','$lu','$user_id')";
	mysql_query($input3);
	
	$idpn=mysql_fetch_array(mysql_query("SELECT max(id) FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id_user='$_SESSION[id]' ORDER BY id DESC"));
	$id_new			=$idpn[0];
	
	
	
	//4. Menginsert transaksi Pencairan ke tabel transaksi
		$input4 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES('','$tglres','111.14','131.01','0','0','$id_new','Pencairan Rescedulling $namadepan ($idpinjres)','$alokasires','0','$user_id')";
		mysql_query($input4);
	

	
?>