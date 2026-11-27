<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_kelompok_$_SESSION[kd_kab]";
$tablei		="pinjaman_anggota_$_SESSION[kd_kab]";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idpinjres		= $_POST['idpinjres'];
$id_kelres		= $_POST['id_kelres'];
$jenis_ppres	= $_POST['jenis_ppres']; // Jenis PP Perubahan
$jenis_ppasli	= $_POST['jenis_ppasli']; //Jenis PP Asli
$tglres			= $_POST['tglres'];
$alokasires		= $_POST['alokasires'];
$saldopinjamanres= $_POST['saldopinjamanres'];
$pros_jasares	= $_POST['pros_jasares'];
$jenis_jasares	= $_POST['jenis_jasares'];
$jangkares		= $_POST['jangkares'];
$sistemres		= $_POST['sistemres'];
$sistemjres		= $_POST['sistemjres'];
$user_id		= $_SESSION['id'];
$lu				= date('Y-m-d H:i:s');
$tgl			= date('Y-m-d');
$status			= "A";


$kel=mysql_fetch_array(mysql_query("select * from kelompok_$_SESSION[kd_kab] WHERE id='$id_kelres'"));
$nama_kelompok	=$kel['nama_kelompok'];


				//Asli
				if($jenis_ppasli==1) {
				$nama_jp		="SPP";
				$rekening_debit	="112.01";
				$rekening_kredit="131.02";

				}
				elseif($jenis_ppasli==2) {
				$nama_jp		="UEP";
				$rekening_debit	="113.01";
				$rekening_kredit="132.02";

				}
				elseif($jenis_ppasli==3) {
				$nama_jp		="PL";
				$rekening_debit	="115.01";
				$rekening_kredit="133.01";

				}
				
				//Rescedulling
				if($jenis_ppres==1) {
				$rekening_debit_c	="131.01";
				$rekening_kredit_c	="112.07";
				
				}
				elseif($jenis_ppres==2) {
				$rekening_debit_c	="132.01";
				$rekening_kredit_c	="113.07";
				
				}
				elseif($jenis_ppres==3) {
				$rekening_debit_c	="133.01";
				$rekening_kredit_c	="115.07";
				
				}


	//1. Mengubah Pinjaman Lama Menjadi R
	$update	 = "UPDATE $table SET 			tgl_lunas			='$tgl',
											`status`				='R',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$idpinjres' AND `status`='A' ";
	mysql_query($update);					
	
	$updatei = "UPDATE $tablei SET 			tgl_lunas			='$tgl',
											`status`				='R',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id_pinkel= '$idpinjres' AND `status`='A' ";
	mysql_query($updatei);		
	//2. Menginsert transaksi pelunasan ke tabel transaksi
	$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
	$idtp			=$idt[0]+1;


	$input2 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglres','$rekening_debit','$rekening_kredit','$idtp','$idpinjres','Angsuran Rescedulling $nama_kelompok ($nama_jp-$idpinjres)','$saldopinjamanres','$urutan','$user_id')";
	mysql_query($input2);
	
	
	
	//3. Menginsert pinjaman baru ke tabel Pinjaman_kelompok
	$input3 = "INSERT INTO $table (id_kel,jenis_pp,tgl_proposal,tgl_verifikasi,tgl_dana,tgl_tunggu,tgl_cair,proposal,verifikasi,alokasi,sumber,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,catatan_verifikasi,lu,user_id)
				VALUES('$id_kelres', '$jenis_ppres', '$tglres', '$tglres', '$tglres', '$tglres', '$tglres', '$alokasires', '$alokasires','$alokasires','1','$pros_jasares','$jenis_jasares','$jangkares','$sistemres','$sistemjres','$status','Rescedulling $idpinjres','$lu','$user_id')";
	mysql_query($input3);
	
	$idpn=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE catatan_verifikasi='Rescedulling $idpinjres'"));
	$id_new=$idpn['id'];
	
	

	
	if($jenis_ppres!=$jenis_ppasli) {

		if($jenis_ppasli==1 AND $jenis_ppres==2) {
			$rekening_debit_t="113.18";
			$rekening_kredit_t="112.17";
			$keterangan_transaksi_t="Transfer dari Kas SPP ke Kas UEP";
		} else if($jenis_ppasli==1 AND $jenis_ppres==3) {
			$rekening_debit_t="115.04";
			$rekening_kredit_t="112.18";
			$keterangan_transaksi_t="Transfer dari Kas SPP ke Kas Lainnya";
		} else if($jenis_ppasli==2 AND $jenis_ppres==3) {
			$rekening_debit_t="115.05";
			$rekening_kredit_t="113.17";
			$keterangan_transaksi_t="Transfer dari Kas UEP ke Kas Lainnya";
		}
		//5. Transfer ke Kas Lain
		$input5 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglres','$rekening_debit_t','$rekening_kredit_t','0','0','$keterangan_transaksi_t','$alokasires','$urutan','$user_id')";
		mysql_query($input5);
		
	}
	
	
	//4. Menginsert transaksi Pencairan ke tabel transaksi
		$input4 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES('','$tglres','$rekening_debit_c','$rekening_kredit_c','0','$id_new','Pencairan Rescedulling $nama_kelompok ($nama_jp-$idpinjres)','$alokasires','$urutan','$user_id')";
		mysql_query($input4);
	

	
?>