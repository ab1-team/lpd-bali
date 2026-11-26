<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

$table		="transaksi_$_SESSION[lokasi]";

$id_simp_i 		=$_POST['id_simp_i'];
$tgl_awal		=$_POST['tgl_awal'];
$tgl_akhir		=$_POST['tgl_akhir'];
$jumlah			=str_replace(".", "", $_POST['bungasimpananumum']);
$cari=mysql_num_rows(mysql_query("select * from transaksi_$_SESSION[lokasi] where rekening_debit='5-80001' AND rekening_kredit='2-40002_$idsimp'  AND tgl_transaksi>='$tgl_awal' AND tgl_transaksi<='$tgl_akhir' "));

$bulan		=bulan_indo($tgl_akhir);							
								
if($jumlah>0 AND $cari==0) {

$rekening_debit		="5-80001";				//Bunga Simpanan Umum
$rekening_kredit	="2-40002_$id_simp_i";	//Simpanan Umum
$user_id			= $_SESSION['id'];

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where a.id=sa.nia AND sa.id='$id_simp_i' "));
$keterangan_transaksi	="Bunga SU $nm[nomor_rekening] $nm[namadepan] $bulan";
 
 mysql_query("INSERT INTO $table (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_akhir','$rekening_debit', '$rekening_kredit', '0','$keterangan_transaksi','$jumlah','0','$user_id')");
			
}

?>