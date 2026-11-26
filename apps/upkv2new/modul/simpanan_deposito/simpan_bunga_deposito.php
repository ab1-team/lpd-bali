<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_simpanan_individu.php";

$table		="transaksi_$_SESSION[lokasi]";

$id_simp_i 			=$_POST['id_simp_i'] ?: '0';
$tgl_transaksi		=$_POST['tgl_transaksi'] ?: '0';
$jumlah				=str_replace(".", "", $_POST['bungaSimpananDeposito']) ?: '0';

$bulan			=substr($tgl_transaksi,0,7) ?: '0';
$tgl_indo		=tgl_indo($bulan) ?: '0';

$tgl_awal	 ="$bulan-01";
$tgl_akhir	 =date('Y-m-d', strtotime(date('Y-m-t', strtotime($tgl_transaksi))));

$cari=mysql_num_rows(mysql_query("select * from transaksi_$_SESSION[lokasi] where rekening_debit='515.02' AND rekening_kredit='222.02' AND id_simp_i='$id_simp_i' AND tgl_transaksi>='$tgl_awal' AND tgl_transaksi<='$tgl_akhir'  "));
																
								
if($jumlah>0 AND $cari<=0) {

 
	//Jika bunga hanya digunakan untuk menambah deposito di rekening tabungan yang sama
	 
		$simp=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where a.id=sa.nia AND sa.id='$id_simp_i' "));
	    
		mysql_query("INSERT INTO $table (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES(null,'$tgl_transaksi','515.02', '222.02', '0','$id_simp_i','Bunga SD $simp[nomor_rekening] $simp[namadepan] $tgl_indo','$jumlah','0','$_SESSION[id]')");

	
	//Jika bunga juga akan ditransfer ke rekening tabungan lain
	
	/*
$id_simp_7			=$_POST['dibayar_ke'];
	if($id_simp_i != $id_simp_7) { 
	
		$simp7=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$id_simp_7' "));				
		$jenis_simpanan		=$simp7['jenis_simpanan'];
		
		if($jenis_simpanan==1) {
			$rekening_debit		="2-40003_$id_simp_i";		//dari	Simpanan Deposito
			$rekening_kredit	="2-40002_$id_simp_7";		//ke	Simpanan Umum
		}else if($jenis_simpanan==2) {
			$rekening_debit		="2-40003_$id_simp_i";		//dari	Simpanan Deposito
			$rekening_kredit	="2-40003_$id_simp_7";		//ke	Simpanan Deposito
		}
		

		//Transfer ke rekening tabungan Lain
		 mysql_query("INSERT INTO $table (tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
						VALUES('$tgl_transaksi','$rekening_debit', '$rekening_kredit', '0','Transfer dari $simp[nomor_rekening] ke $simp7[nomor_rekening]','$jumlah','0','$_SESSION[id]')");
		
	}
	*/
}

?>