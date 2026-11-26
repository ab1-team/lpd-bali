<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table_transaksi		="transaksi_".$_SESSION['lokasi'];
$table_rekening			="rekening_".$_SESSION['lokasi'];

$idt					=$_POST['idt'];
$tgltransaksi			=$_POST['tgl_transaksi'];
$jenis_transaksi		=$_POST['jenis_transaksi'];
$rekening_kredit		=$_POST['rekening_1'];
$rekening_debit			=$_POST['rekening_2'];
$invoice_jual			=$_POST['invoice_jual'];
$invoice_beli			=$_POST['invoice_beli'];
$nominal				=$_POST['nominal'];
$urutan					=$_POST['urutan'];
$id_user				=$_SESSION['id'];

$ij	=noInvoice($invoice_jual);

if($invoice_jual>0){
	$row=mysql_fetch_array(mysql_query("SELECT * FROM invoice where id='$invoice_jual' "));
			$cus=mysql_fetch_array(mysql_query("select * from customer WHERE id='$row[id_customer]' "));
			$pak=mysql_fetch_array(mysql_query("select * from paket WHERE id='$row[id_paket]' "));
			if($row['id_paket']==0){$nama_proyek="Penjualan Ritail";}else{$nama_proyek=$pak['nama_proyek'];}
	$keterangan_transaksi="Terima Pembayaran $ij $cus[nama_customer], $nama_proyek";
}else if($invoice_beli>0){
	$row=mysql_fetch_array(mysql_query("SELECT * FROM invoice_beli i, supplier s where s.id=i.id_supplier AND i.id='$invoice_beli' "));
	$keterangan_transaksi="Bayar Tagihan #$row[nomor_invoice] $row[nama_supplier]";
}else{
	$keterangan_transaksi=$_POST['keterangan_transaksi'];;
}


$jumlah = str_replace(".", "", $nominal);

$tgl	=substr($tgltransaksi,0,2); //22/09/2019
$bln	=substr($tgltransaksi,3,2);
$thn	=substr($tgltransaksi,6,4);
$tgl_transaksi="$thn-$bln-$tgl";


$sql = mysql_query("SELECT *
				   FROM $table_transaksi 
				   WHERE idt= '$idt'");
$row	= mysql_num_rows($sql);


if ($row>0){
	$update	= "UPDATE $table_transaksi SET tgl_transaksi	='$tgl_transaksi',
											keterangan_transaksi	='$keterangan_transaksi',
											jumlah			='$jumlah',
											urutan			='$urutan'
									WHERE idt= '$idt'";
	mysql_query($update);

}else{

	$input = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,i_jual,i_beli,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rekening_debit','$rekening_kredit','$invoice_jual','$invoice_beli','$keterangan_transaksi','$jumlah','0','$id_user')";
	mysql_query($input);
	
}	
?>