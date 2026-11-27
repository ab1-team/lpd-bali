<?php
$server = getenv("LPD_DB_HOST") ?: "db"; 

$database = getenv("LPD_DB_NAME") ?: "lpdbalii_demo";
$username = getenv("LPD_DB_USER") ?: "lpdapp";
$password = getenv("LPD_DB_PASS") ?: "lpdapp2026";
$konek = mysql_connect($server, $username, $password) or die ("Gagal konek ke server MySQL" .mysql_error());
$bukadb = mysql_select_db($database) or die ("Gagal membuka database $database" .mysql_error());

date_default_timezone_set('Asia/Jakarta');

/*
 * Identitas lembaga. Satu aplikasi dipakai untuk LPD, BUMDes, koperasi, dll.
 * Nilai diambil dari data desa/kecamatan bila tersedia, sehingga seluruh
 * tampilan dan dokumen otomatis memakai nama lembaga yang benar.
 */
if (!defined('LEMBAGA_SORT') || !defined('LEMBAGA_LONG')) {
	$lembaga_sort = 'LPD';
	$lembaga_long = 'Lembaga Perkreditan Desa';

	$where_lembaga = '';
	if (isset($_SESSION['lokasi']) && $_SESSION['lokasi'] != '') {
		$where_lembaga = "d.id='".mysql_real_escape_string($_SESSION['lokasi'])."'";
	} elseif (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '') {
		$where_lembaga = "d.web_desa='".mysql_real_escape_string($_SERVER['HTTP_HOST'])."'";
	}

	if ($where_lembaga != '') {
		$q_lembaga = mysql_query("SELECT d.*, k.* FROM desa d LEFT JOIN kecamatan k ON k.kd_kec=d.kd_kec WHERE $where_lembaga LIMIT 1");
		if ($q_lembaga && mysql_num_rows($q_lembaga) > 0) {
			$lembaga_row = mysql_fetch_array($q_lembaga);

			foreach (array('nama_lembaga_sort', 'sebutan_lembaga') as $field) {
				if (!empty($lembaga_row[$field])) { $lembaga_sort = $lembaga_row[$field]; break; }
			}
			foreach (array('nama_lembaga_long', 'lembaga_long') as $field) {
				if (!empty($lembaga_row[$field])) { $lembaga_long = $lembaga_row[$field]; break; }
			}
		}
	}

	define('LEMBAGA_SORT', $lembaga_sort);
	define('LEMBAGA_LONG', $lembaga_long);
}



?>