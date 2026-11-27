<?php session_start(); 
	// require connection.php
	include "../../inc/inc.koneksi.php";
	include "../../inc/fungsi_pinjaman_individu.php";

	$term = $_GET['term'];
	$data = "SELECT * FROM users u, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
	
			a.id=pi.nia AND pi.status='A' AND u.lokasi=$_SESSION[lokasi] AND u.id=pi.user_id AND
			 pi.jenis_pinjaman='I' AND a.namadepan like '%$term%' OR
			a.id=pi.nia AND pi.status='A' AND u.lokasi=$_SESSION[lokasi] AND u.id=pi.user_id AND
			 pi.jenis_pinjaman='I' AND a.nik like '%$term%'
			order by a.namadepan asc";
 
	$query = mysql_query($data);
	$num = mysql_num_rows($query);
   	if($num > 0){
		$json = array();
		while ($row = mysql_fetch_array($query)){
			$tgl_kondisi	=date('Y-m')."-31";
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$row[id]"); //tunggakan menjadi tagihan pada form angsuran
			$nunggakjasa	=nunggakjasa("$tgl_kondisi-$row[id]");
			$totalbayar		=$nunggakpokok+$nunggakjasa;
			$smpokok		=sumpokok("$tgl_kondisi-$row[id]");
			if($smpokok=="") { $sumpokok="0"; }else{$sumpokok=$smpokok; }
	$json[] = array(
		'label' => $row['nik'].' '.$row['nama_desa'].' '.$row['namadepan'], // text sugesti saat user mengetik di input box
		'value' => $row['nik'].' '.$row['nama_desa'].' '.$row['namadepan'], // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
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