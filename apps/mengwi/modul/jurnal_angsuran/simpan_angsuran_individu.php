<?php session_start();
include "../../inc/inc.koneksi.php";
$table_transaksi="transaksi_".$_SESSION['lokasi'];

$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
$idtp			=$idt[0]+1;
			
$id_pinj				=$_POST['id_pinj'];			
$jenis_pp				=$_POST['jenis_pp'];			
$tgl_transaksi			=$_POST['tgl_transaksi'];			
$urutan					=0;			
$pokok					=$_POST['pokok'];
$jasa					=$_POST['jasa'];
$denda					=$_POST['denda'];
$id_user				=$_SESSION['id'];

$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] pi, anggota_$_SESSION[kd_kab] a WHERE a.id=pi.nia AND pi.id='$id_pinj' "));
$namadepan	=addslashes("$kel[namadepan] ($id_pinj)");

			if($jenis_pp==1) {
				$nama_jp		="SPP";
				$rek_pokok_d	="112.01";
				$rek_jasa_d		="112.02";
				$rek_denda_d	="112.03";
				$rek_pokok_k	="131.02";
				$rek_jasa_k		="411.01";
				$rek_denda_k	="411.03";
				}
				elseif($jenis_pp==2) {
				$nama_jp		="UEP";
				$rek_pokok_d	="113.01";
				$rek_jasa_d		="113.02";
				$rek_denda_d	="113.03";
				$rek_pokok_k	="132.02";
				$rek_jasa_k		="411.02";
				$rek_denda_k	="411.04";
				}
				elseif($jenis_pp==3) { //PL
				$nama_jp		="PL";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.01";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}
				elseif($jenis_pp==4) { //DKU
				$nama_jp		="DKU";
				$rek_pokok_d	="116.01";
				$rek_jasa_d		="116.02";
				$rek_denda_d	="116.03";
				$rek_pokok_k	="134.02";
				$rek_jasa_k		="411.08";
				$rek_denda_k	="411.09";
				}
				elseif($jenis_pp==5) { //DSPP
				$nama_jp		="DSPP";
				$rek_pokok_d	="117.01";
				$rek_jasa_d		="117.02";
				$rek_denda_d	="117.03";
				$rek_pokok_k	="135.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}elseif($jenis_pp==6) { //P2B
				$nama_jp		="P2B";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}elseif($jenis_pp==7) { //PKKPM
				$nama_jp		="PKKPM";
				$rek_pokok_d	="116.01";
				$rek_jasa_d		="116.02";
				$rek_denda_d	="116.03";
				$rek_pokok_k	="134.02";
				$rek_jasa_k		="411.08";
				$rek_denda_k	="411.09";
				}elseif($jenis_pp==8) { //SPPro
				$nama_jp		="SPPro";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.06";
				$rek_denda_k	="411.07";
				}elseif($jenis_pp==9) { //IU
				$nama_jp		="IU";
				$rek_pokok_d	="118.01";
				$rek_jasa_d		="118.02";
				$rek_denda_d	="118.03";
				$rek_pokok_k	="136.02";
				$rek_jasa_k		="411.10";
				$rek_denda_k	="411.11";
				}elseif($jenis_pp==10) { //Cash tempo
				$nama_jp		="CT";
				$rek_pokok_d	="114.01";
				$rek_jasa_d		="114.02";
				$rek_denda_d	="114.03";
				$rek_pokok_k	="133.02";
				$rek_jasa_k		="411.07";
				$rek_denda_k	="411.08";
				}elseif($jenis_pp==11) { //Manunggal Motor
				$nama_jp		="MM";
				$rek_pokok_d	="115.01";
				$rek_jasa_d		="115.02";
				$rek_denda_d	="115.03";
				$rek_pokok_k	="134.02";
				$rek_jasa_k		="411.09";
				$rek_denda_k	="411.10";
				}elseif($jenis_pp==12) { //Manunggal Karya
				$nama_jp		="MK";
				$rek_pokok_d	="116.01";
				$rek_jasa_d		="116.02";
				$rek_denda_d	="116.03";
				$rek_pokok_k	="135.02";
				$rek_jasa_k		="411.11";
				$rek_denda_k	="411.12";
				}elseif($jenis_pp==13) { //Kredit Barang
				$nama_jp		="KB";
				$rek_pokok_d	="114.01";
				$rek_jasa_d		="114.02";
				$rek_denda_d	="114.03";
				$rek_pokok_k	="137.02";
				$rek_jasa_k		="411.13";
				$rek_denda_k	="411.14";
				}

$input_pokok = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_pokok_d', '$rek_pokok_k','$idtp','0','$id_pinj','Angs.Pokok $nama_jp $namadepan','$pokok','$urutan','$id_user')";
							
$input_jasa = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_jasa_d', '$rek_jasa_k','$idtp','0','$id_pinj','Angs.Jasa $nama_jp $namadepan','$jasa','$urutan','$id_user')";
				
$input_denda = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,id_pinj_i,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$tgl_transaksi','$rek_denda_d', '$rek_denda_k','$idtp','0','$id_pinj','Denda $nama_jp $namadepan','$denda','$urutan','$id_user')";
							
if ($pokok<=0 and $jasa>0 and $denda>0){
	mysql_query($input_jasa);
	mysql_query($input_denda);
	
}else if ($pokok>0 and $jasa<=0 and $denda>0){
	mysql_query($input_pokok);
	mysql_query($input_denda);
	
}else if ($pokok>0 and $jasa>0 and $denda<=0){
	mysql_query($input_pokok);
	mysql_query($input_jasa);
	
}else if ($pokok>0 and $jasa<=0 and $denda<=0){
	mysql_query($input_pokok);
	
}else if ($pokok<=0 and $jasa>0 and $denda<=0){
	mysql_query($input_jasa);
	
}else if ($pokok<=0 and $jasa<=0 and $denda>0){
	mysql_query($input_denda);
	
}else if($pokok>0 and $jasa>0 and $denda>0){
	mysql_query($input_pokok);
	mysql_query($input_jasa);
	mysql_query($input_denda);
	
}	
?>