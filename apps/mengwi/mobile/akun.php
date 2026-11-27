<?php 
include "../inc/inc.koneksi.php";

$e = $_POST['id'];
$user = mysql_fetch_array(mysql_query("
		SELECT 
			c.nama_kec,
			c.nama_lembaga_sort,
			u.uname,u.namadepan,u.namabelakang,
			u.hp, u.alamat, u.nik
		FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$e));
					

$data = array(
	'nama' => $user['namadepan']." ".$user['namabelakang'],
	'lembaga' => $user['nama_lembaga_sort'],
	'unit' => $user['nama_kec'],
	'alamat' => $user['alamat'],
	'hp'	=> $user['hp'],
	'nik' => $user['nik']
);

die(json_encode($data));
?>		
				
        