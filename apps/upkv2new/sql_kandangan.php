<?php session_start();
include "inc/inc.koneksi.php"; 

$kd_kab =2;
$tgl_now="2022-10-10";
$lokasi=3;

				
$sql    = mysql_query("select * from  transaksi_$lokasi WHERE tgl_transaksi='2022-09-30' and  rekening_debit='515.01' and rekening_kredit='221.02' and id_user!='1' GROUP BY id_simp_i");
while($row=mysql_fetch_array($sql)){
$id_simp= $row['id_simp_i'];
$keterangan_transaksi=$row['keterangan_transaksi'];
$jumlah=$row['jumlah'];
$id_user=$row['id_user'];
mysql_query("DELETE FROM `transaksi_$lokasi` WHERE tgl_transaksi='2022-09-30' and  rekening_debit='515.01' and rekening_kredit='221.02' and id_simp_i=$id_simp");

mysql_query("INSERT INTO `transaksi_$lokasi` (`idt`, `tgl_transaksi`, `rekening_debit`, `rekening_kredit`, `idtp`, `id_pinj`, `id_pinj_i`, `id_simp_i`, `keterangan_transaksi`, `jumlah`, `urutan`, `id_user`) VALUES 
								(NULL, '2022-09-30', '515.01', '221.02', '0', '0', '0', '$id_simp', '$keterangan_transaksi', '$jumlah', '0', '1')");
								echo $id_simp;
								echo "<br>";
}
?>