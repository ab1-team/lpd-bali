<?php session_start();
if (!$_SESSION['kd_kab']) die;

include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_simpanan_individu.php";

$table		="transaksi_$_SESSION[lokasi]";

$id_simp_i 		=$_POST['id_simp_i'] ?: '0';
$tgl_awal		=$_POST['tgl_awal'] ?: '0';
$tgl_akhir		=$_POST['tgl_akhir'] ?: '0';
$jumlah1			=str_replace(".", "", $_POST['bungasimpananumum']) ?: '0';
$jumlah2			=str_replace(".", "", $_POST['pajaksimpananumum']) ?: '0';
$jumlah3			=str_replace(".", "", $_POST['adminsimpananumum']) ?: '0';
$cari=mysql_num_rows(mysql_query("select * from transaksi_$_SESSION[lokasi] where rekening_debit='515.01' AND id_simp_i='$id_simp_i'  AND tgl_transaksi>='$tgl_awal' AND tgl_transaksi<='$tgl_akhir' "));

$bulan		=bln_indo($tgl_akhir);							
$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where a.id=sa.nia AND sa.id='$id_simp_i' "));
$keterangan_transaksi1	="Bunga SU $nm[nomor_rekening] $nm[namadepan] $bulan";
$keterangan_transaksi2	="Pajak SU $nm[nomor_rekening] $nm[namadepan] $bulan";
$keterangan_transaksi3	="Admin SU $nm[nomor_rekening] $nm[namadepan] $bulan";
								
if($cari==0) {
if($nm['jenis_simpanan']==1){
$rekening_debit1		="515.01";				//Bunga Simpanan Umum
$rekening_debit2		="221.05";				//pajak Simpanan Umum
$rekening_debit3		="221.03";				//admin Simpanan Umum
$rekening_kredit1   	="221.02";	            //Bunga Simpanan Umum
$rekening_kredit2   	="231.01";          	//pajak Simpanan Umum
$rekening_kredit3   	="413.01";	            //admin Simpanan Umum
}else{
$rekening_debit1		="515.03";				//Bunga Simpanan Umum
$rekening_debit2		="223.05";				//pajak Simpanan Umum
$rekening_debit3		="223.03";				//admin Simpanan Umum
$rekening_kredit1   	="223.02";	            //Bunga Simpanan Umum
$rekening_kredit2   	="231.03";          	//pajak Simpanan Umum
$rekening_kredit3   	="413.03";	            //admin Simpanan Umum
}
$user_id			= $_SESSION['id'];

 if($jumlah1>0){	//Bunga Simpanan Umum
 mysql_query("INSERT INTO $table (idt,tgl_transaksi,rekening_debit,rekening_kredit,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES(null,'$tgl_akhir','$rekening_debit1', '$rekening_kredit1', '$id_simp_i','$keterangan_transaksi1','$jumlah1','0','$user_id')");
 } 
 if($jumlah2>0){	//pajak Simpanan Umum
 mysql_query("INSERT INTO $table (idt,tgl_transaksi,rekening_debit,rekening_kredit,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES(null,'$tgl_akhir','$rekening_debit2', '$rekening_kredit2', '$id_simp_i','$keterangan_transaksi2','$jumlah2','0','$user_id')");
 }
  if($jumlah3>0){	//admin Simpanan Umum
 mysql_query("INSERT INTO $table (idt,tgl_transaksi,rekening_debit,rekening_kredit,id_simp_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES(null,'$tgl_akhir','$rekening_debit3', '$rekening_kredit3', '$id_simp_i','$keterangan_transaksi3','$jumlah3','0','$user_id')");
 }
}
			if($nm['tgl_up']<$tgl_akhir){
			    $saldosimpananb = saldosimpananb("$tgl_akhir-$id_simp_i");
				mysql_query("UPDATE `simpanan_anggota_$_SESSION[kd_kab]`  SET `jumlah` = '$saldosimpananb', `tgl_up` = '$tgl_akhir'  where id='$id_simp_i' ");	
			} 
?>