<?php session_start(); 
	// require connection.php
	include "../../inc/inc.koneksi.php";
	include "../../inc/fungsi_pinjaman.php";

	$term = $_GET['term'];
 
	$data = "select * from kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			c.kd_kec=d.kd_kec and k.id=pk.id_kel AND pk.status='A' AND c.id='$_SESSION[lokasi]' and k.lokasi=c.id and k.desa=d.id AND k.kd_kelompok like '%$term%' OR 
			c.kd_kec=d.kd_kec and k.id=pk.id_kel AND pk.status='A' AND c.id='$_SESSION[lokasi]' and k.lokasi=c.id and k.desa=d.id AND k.nama_kelompok like '%$term%' OR 
			c.kd_kec=d.kd_kec and k.id=pk.id_kel AND pk.status='A' AND c.id='$_SESSION[lokasi]' and k.lokasi=c.id and k.desa=d.id AND k.ketua like '%$term%' OR
			c.kd_kec=d.kd_kec and k.id=pk.id_kel AND pk.status='A' AND c.id='$_SESSION[lokasi]' and k.lokasi=c.id and k.desa=d.id AND d.nama_desa like '%$term%'
			order by d.id, k.nama_kelompok asc";
	
	$query = mysql_query($data);
	$num = mysql_num_rows($query);
   	if($num > 0){
		$json = array();
		while ($row = mysql_fetch_array($query)){
			$tgl_kondisi	=date('Y-m-t');
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$row[id]"); //tunggakan menjadi tagihan pada form angsuran
			$nunggakjasa	=nunggakjasa("$tgl_kondisi-$row[id]");
			$totalbayar		=$nunggakpokok+$nunggakjasa;
			$smpokok		=sumpokok("$tgl_kondisi-$row[id]");
			if($smpokok=="") { $sumpokok="0"; }else{$sumpokok=$smpokok; }
	$json[] = array(
		'label' => "$row[kd_kelompok] [$row[nama_desa]] $row[nama_kelompok] $row[ketua]", // text sugesti saat user mengetik di input box
		'value' => "$row[kd_kelompok] [$row[nama_desa]] $row[nama_kelompok] $row[ketua]", // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
		'pokok' => $nunggakpokok,
		'jasa' => $nunggakjasa,
		'denda' => 0,
		'totalbayar' => $totalbayar,
		'id_pinj' => $row['id'],
		'jenis_pp' => $row['jenis_pp'],
		'tgl_pakai' => $row['tgl_pakai'],
		'tgl_cair' => $row['tgl_cair'],
		'alokasi' => $row['alokasi'],
		'jumpokok' => $sumpokok,
	);
}
header("Content-Type: text/json");
echo json_encode($json);
	}
?>