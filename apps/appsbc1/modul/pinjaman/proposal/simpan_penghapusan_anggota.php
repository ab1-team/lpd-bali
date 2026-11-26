<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$loanid			= $_POST['loanid'];
$tglhapus		= $_POST['tglhapus'];
$pokok		= $_POST['totalpokok'];
$jasa		= $_POST['totaljasa'];
$sumber_biaya	= $_POST['sumber_biaya'];
$catatanhapus	= $_POST['catatanhapus'];
$user_id		= $_SESSION['id'];
$lu				= date('Y-m-d H:i:s');
$tgl			= date('Y-m-d');
$status			= "H";

$totalpokok		 = str_replace(".", "", $pokok);
$totaljasa		 = str_replace(".", "", $jasa);
$totalhapus		=$totalpokok+$totaljasa;

$pa=mysql_fetch_array(mysql_query("select * from $table WHERE id='$loanid'"));
$jenis_pp	=$pa['jenis_pp'];
$id_pinkel	=$pa['id_pinkel'];
$id_kel		=$pa['id_kel'];
$nia		=$pa['nia'];

$angg=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE id='$nia'"));
$namadepan	=$angg['namadepan'];

$kel=mysql_fetch_array(mysql_query("select * from kelompok_$_SESSION[kd_kab] WHERE id='$id_kel'"));
$nama_kelompok	=$kel['nama_kelompok'];



				
				//Angsuran Pokok Lunas
				if($jenis_pp==1) {
				$nama_jp		="SPP";
				$rekening_debit	="112.01";
				$rekening_kredit="131.02";

				}
				elseif($jenis_pp==2) {
				$nama_jp		="UEP";
				$rekening_debit	="113.01";
				$rekening_kredit="132.02";

				}
				elseif($jenis_pp==3) {
				$nama_jp		="PL";
				$rekening_debit	="115.01";
				$rekening_kredit="133.01";

				}
				
				


	//1. Mengubah Pinjaman Lama Menjadi H
	$update	= "UPDATE $table SET 			tgl_lunas			='$tglhapus',
											`status`			='H',
											catatan_verifikasi	='$catatanhapus',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$loanid' AND `status`='A' ";
	mysql_query($update);					
	
	//2. Menginsert transaksi pelunasan ke tabel transaksi
	$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
	$idtp			=$idt[0]+1;


	$input2 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglhapus','$rekening_debit','$rekening_kredit','$idtp','$id_pinkel','Angsuran Pokok Penghapusan $namadepan ($nama_kelompok $nama_jp-$id_pinkel)','$totalpokok','0','$user_id')";
	mysql_query($input2);
	
	if($totaljasa>0) {
		$inputj = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglhapus','$rekening_debit','$rekening_kredit','$idtp','$id_pinkel','Angsuran Jasa Penghapusan $namadepan ($nama_kelompok $nama_jp-$id_pinkel)','$totaljasa','0','$user_id')";
	mysql_query($inputj);
	}
	
	//3. Transfer dari Kas Pinjaman SPP/UEP ke Kas Operasional
	if($jenis_pp==1) {
			$rekening_debit_t="111.03";
			$rekening_kredit_t="112.08";
			$keterangan_transaksi_t="Transfer dari Kas SPP ke Kas Operasional (Penyesuaian Penghapusan Pinjaman)";
		} else if($jenis_pp==2) {
			$rekening_debit_t="111.04";
			$rekening_kredit_t="113.08";
			$keterangan_transaksi_t="Transfer dari Kas UEP ke Kas Operasional (Penyesuaian Penghapusan Pinjaman)";
		}
		
	$input4 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglhapus','$rekening_debit_t','$rekening_kredit_t','0','0','$keterangan_transaksi_t','$totalhapus','0','$user_id')";
	mysql_query($input4);

	
	//4. Insert Transaksi Pembayaran Hutang Cadangan Resiko/Biaya Penghapusan Pinjaman berdasarkan sumber biayanya
				if($sumber_biaya==1) {			//Dari alokasi Cadangan Resiko
				$rekening_debit_b	="215.02";
				$rekening_kredit_b	="111.30";
				$keterangan_transaksi_b="Biaya Penghapusan a.n. $namadepan ($nama_kelompok $nama_jp-$id_pinkel) via Cadangan Resiko";
				}
				elseif($sumber_biaya==2) {		//Dari Biaya Penghapusan Pinjaman (Surplus Berjalan)
				$rekening_debit_b	="513.01";
				$rekening_kredit_b	="111.28";
				$keterangan_transaksi_b="Biaya Penghapusan a.n. $namadepan ($nama_kelompok $nama_jp-$id_pinkel) via Surplus Berjalan";
				}
		
	$input3 = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tglhapus','$rekening_debit_b','$rekening_kredit_b','0','0','$keterangan_transaksi_b','$totalhapus','0','$user_id')";
	mysql_query($input3);
	
	
	

	

	
?>