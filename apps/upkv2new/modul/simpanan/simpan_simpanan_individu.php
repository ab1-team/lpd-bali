<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";

$nia			= $_POST['nia'] ;
$norek			= $_POST['norek'] ;
$nkred			= $_POST['nkred'] ;
$js		    	= $_POST['js'] ;
$jumlah			= $_POST['jumlah'] ;
$tgl_buka		= $_POST['tgl_buka'] ;
$tgl_tutup		= $_POST['tgl_tutup'] ;
$pros_jasa		= $_POST['pros_jasa'] ;
$openrek		= $_POST['openrek'] ;
$jangka			= ($_POST['jangka'] == 'undefined' || !$_POST['jangka'] || $_POST['jangka'] == '') ? '0':$_POST['jangka'];
$bunga			= $_POST['bunga'] ;
$pajak			= $_POST['pajak'] ;
$admin			= $_POST['admin'] ;
$sp		    	= $_POST['sp'] ;
$lembaga		= $_POST['lembaga'] ;
$jabatan		= $_POST['jabatan'] ;
$pengampu		= $_POST['pengampu'] ;
$hubungan		= $_POST['hubungan'] ;
$catatan_simp   = $_POST['catatan_simpanan'] ;
$lu				= date('Y-m-d H:i:s') ;
$user_id		= $_SESSION['id'] ;
$status			= "A" ;

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] where id='$nia' "));

$sql="INSERT INTO $table(`id`, `lokasi`, `nomor_rekening`, `jenis_simpanan`, `nia`, `jumlah`, `tgl_up`, `jangka`, `pros_jasa`, `tgl_buka`, `tgl_tutup`, `tgl_st`, `bunga`, `pajak`, `admin`, `status`, `sp`, `lembaga`, `jabatan`, `pengampu`, `hubungan`,`catatan_simpanan`, `lu`, `user_id`)
				VALUES('$nkred','$_SESSION[lokasi]','$norek','$js', '$nia', '$jumlah','$tgl_buka','$jangka','$pros_jasa','$tgl_buka','$tgl_tutup','0000-00-00','$bunga','$pajak','$admin','$status','$sp','$lembaga','$jabatan','$pengampu','$hubungan','$catatan_simp','$lu','$user_id')";


if (mysql_query($sql)) {  
  //mendapatkan id terakhir dengan fungsi mysql_insert_id  
  $last_id = mysql_insert_id($konek); 
  
if($js==1) {		//Tabungan Umum
$rekening_debit		="119.01";	
$rekening_kredit	="221.01";
$id_simp_i			=$nkred;
$keterangan_transaksi="Setoran Awal SU $nm[namadepan]";	
$keterangan_transaksi2="Biaya buka buku $nm[namadepan]";
}else if($js==2) {		//Tabungan Deposito
$rekening_debit		="119.02";	
$rekening_kredit	="222.01";
$id_simp_i			=$nkred;
$field				="last_deposito";
$keterangan_transaksi="Setor SD  $nm[nomor_rekening] $nm[namadepan]";
$keterangan_transaksi2="Biaya buka buku $nm[nomor_rekening] $nm[namadepan]";
}else if($js==3) {		//Tabungan Program
$rekening_debit		="119.05";	
$rekening_kredit	="223.01";
$id_simp_i			=$nkred;
$keterangan_transaksi="Setor SPr  $nm[nomor_rekening] $nm[namadepan]";
$keterangan_transaksi2="Biaya buka buku $nm[nomor_rekening] $nm[namadepan]";
}
  
  mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp, id_simp_i, keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('$tgl_buka','$rekening_debit', '$rekening_kredit', '0','$nkred','$keterangan_transaksi','$jumlah','0','$user_id')");
if($openrek>0){
  mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp, id_simp_i, keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('$tgl_buka','221.03', '413.01', '0','$nkred','$keterangan_transaksi2','$openrek','0','$user_id')");
}
 }

 //menutup koneksi mysql   
 mysql_close($konek); 

				
	

?>