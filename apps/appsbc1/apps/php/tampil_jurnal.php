<?php session_start();
include "../../inc/inc.koneksi.php";
	
	$id_user	=$_SESSION['id'];
	$tgl_awal	=date('Y-m-d')." 00:00:00";
	$tgl_akhir	=date('Y-m-d')." 23:59:59";
	$kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";
	$data=mysql_query("select * from transaksi_$_SESSION[lokasi] WHERE id_user='$id_user' AND $kondisi  order by idt desc");
		
	$ketemu	=mysql_num_rows($data);
	
if ($ketemu > 0){
	  	while($tr=mysql_fetch_array($data)){
			
			if($tr['rekening_debit']=="1-10001") { $warna="green1"; $ket="Debit"; $tanda="arrow-right";}else{ $warna="red2"; $ket="Kredit"; $tanda="arrow-left";}
			if(strlen($tr['keterangan_transaksi'])<=35) { $keterangan_transaksi=$tr['keterangan_transaksi'];}else{ $keterangan_transaksi=substr($tr['keterangan_transaksi'],0,35).'...'; }
	echo '
					
					
		<a href="#" data-menu="notifikasi_transaksi" class="border border-'.$warna.'-dark rounded-s shadow-xs bg-white">
			<i class="fa font-20 fa-'.$tanda.' color-'.$warna.'-dark"></i>
			<span>'.$keterangan_transaksi.'</span>
			<strong>'.$tr['idt'].'. '.$tr['tgl_transaksi'].' | Rp. '.number_format($tr['jumlah'],0,',','.').'</strong>
			<u class="color-'.$warna.'-dark">'.$ket.'</u>
			<i class="fa fa-check-circle color-'.$warna.'-dark"></i>
		</a>
		
		 
	';
		}

}else{
	echo "<p class='text-center color-gray-dark'>TIDAK ADA TRANSAKSI</p>";
	
}
?>


	 