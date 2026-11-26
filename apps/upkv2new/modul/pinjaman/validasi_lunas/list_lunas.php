<?php 
if (!isset($_SESSION)) session_start();
include '../../../inc/inc.koneksi.php';
include "../../../inc/fungsi_pinjaman.php";

$tgl_now = date('Y-m-d');

$limit = $_GET['length'];
$start = $_GET['start'];
$search = $_GET['search']['value'];

$order = $_GET['order'][0]['column'];
$type = $_GET['order'][0]['dir'];
$ordering = $order . ' ' . $type;

$views = mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
					WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' order by tgl_cair asc LIMIT $start, $limit");

$num_rows = mysql_num_rows($views);

if ($_GET['draw'] <= '1') {
    $total_views = mysql_query("SELECT id FROM pinjaman_kelompok_$_SESSION[kd_kab] WHERE status='A' order by tgl_cair asc");

    $total_rows = 0;
    $tgl_now = date('Y-m-d');
    while ($total = mysql_fetch_array($total_views)) {
        if (saldopinjaman("$tgl_now-$total[id]")<=0) {
            ++$total_rows;
        }
    }
    
    $_SESSION['total_rows'] = $total_rows;
} else {
    $total_rows = $_SESSION['total_rows'];
}

$no = $start;
$data = [];
while ( $rows = mysql_fetch_array($views) ) {
    $idpinj			= $rows['id'];
	$saldopinjaman	= saldopinjaman("$tgl_now-$idpinj");

	if ($saldopinjaman<=0) {
	    $kel = mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
						    WHERE d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp and pk.id=$idpinj AND (pk.id LIKE '%$search%' OR pk.tgl_cair LIKE '%$search%' 
						    OR k.kd_kelompok LIKE '%$search%' OR k.nama_kelompok LIKE '%$search%' OR d.nama_desa LIKE '%$search%')");

		while ( $row = mysql_fetch_array($kel) ) {
			$no          = $no+1;
			$id_pinj	 = $row['id'];
			$sumpok		 = sumpokok("$tgl_now-$id_pinj");

			$data[] = [
			    "no"            => $no,
			    "id"            => $row['id'],
			    'tgl_cair'      => $row['tgl_cair'],
			    "nama_kelompok" => "$row[kd_kelompok] - " . strtoupper($row['nama_kelompok']) . " " . strtoupper($row['nama_desa']),
			    "alokasi"       => number_format($row['alokasi']),
			    "sumpokok"      => number_format($sumpok),
			    "saldo"         => number_format($saldopinjaman),
			    "status"        => "LUNAS",
			    "warna"         => "$row[warna_jpp]"
			];
		}
	}
}

if ($total_rows < 1) {
    $output = [
        "draw"              =>  intval($_GET["draw"]),
        "recordsTotal"      =>  0,
        "recordsFiltered"   =>  0,
        "data"              =>  ['' => '']
    ];
} else {
    $output = [
        "draw"              =>  intval($_GET["draw"]),
        "recordsTotal"      =>  $num_rows,
        "recordsFiltered"   =>  $total_rows,
        "data"              =>  $data
    ];
}

echo json_encode($output);

?>