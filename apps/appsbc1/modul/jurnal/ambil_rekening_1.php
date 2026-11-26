<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_transaksi = $_GET['jenis_transaksi'];	

if($jenis_transaksi==1){ //Brangkas Masuk
																
$kel = mysql_query("select * from rekening_$_SESSION[lokasi] WHERE id_akun='4' OR id_akun='5' OR id_akun='6' OR id_akun='7' ORDER BY kd_rekening ASC ");
echo "<option value=''>-- Pilih Sumber Dana --</option>";
while($k = mysql_fetch_array($kel)){
     echo "<option value='$k[kd_rekening]'>$k[kd_rekening]. $k[nama_rekening]</option>";
}

}else if($jenis_transaksi==2){ //Brangkas Keluar
																
$kel = mysql_query("select * from rekening_$_SESSION[lokasi] WHERE id_akun='1' ORDER BY kd_rekening ASC ");
echo "<option value=''>-- Pilih Sumber Dana --</option>";
while($k = mysql_fetch_array($kel)){
     echo "<option value='$k[kd_rekening]'>$k[kd_rekening]. $k[nama_rekening]</option>";
}

}else if($jenis_transaksi==3){ //Pemindahan Saldo/aset
																
$kel = mysql_query("select * from rekening_$_SESSION[lokasi] WHERE id_akun='1' OR id_akun='2' OR id_akun='3' ORDER BY kd_rekening ASC ");
echo "<option value=''>-- Pilih Sumber Dana --</option>";
while($k = mysql_fetch_array($kel)){
     echo "<option value='$k[kd_rekening]'>$k[kd_rekening]. $k[nama_rekening]</option>";
}

}
?>
