<?php
if (!isset($_SESSION)) session_start();
include '../../../inc/inc.koneksi.php';
include "../../../inc/fungsi_pinjaman.php";

$sT = $_GET['status'];
$limit = $_GET['length'];
$start = $_GET['start'];
$search = $_GET['search']['value'];

$order = $_GET['order'][0]['column'];
$type = $_GET['order'][0]['dir'];

$ordering = $order . ' ' . $type;

if ($sT == 'P') {
    $where = 'pk.tgl_proposal';
    $like = 'tgl_proposal';
} elseif ($sT == 'V') {
    $where = 'pk.tgl_verifikasi';
    $like = 'tgl_verifikasi';
} elseif ($sT == 'W') {
    $where = 'pk.tgl_tunggu';
    $like = 'tgl_tunggu';
} elseif ($sT == 'A') {
    $where = 'pk.tgl_cair';
    $like = 'tgl_cair';
}

$view = mysql_query("SELECT d.nama_desa, jpp.nama_jpp, k.kd_kelompok, k.nama_kelompok, pk.alokasi, pk.id, pk.proposal, pk.status, $where
                    FROM desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
				    WHERE d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp AND k.lokasi='$_SESSION[lokasi]' AND pk.status='$sT' 
				    AND (nama_desa LIKE '%$search%' OR kd_kelompok LIKE '%$search%' OR nama_kelompok LIKE '%$search%'
				    OR status LIKE '%$search%' OR $like LIKE '%$search%' OR nama_kelompok LIKE '%$search%')
				    order by $ordering LIMIT $start, $limit");

$rows = mysql_num_rows($view);
$total_rows = mysql_num_rows(mysql_query("SELECT d.nama_desa, jpp.nama_jpp, k.kd_kelompok, k.nama_kelompok, pk.alokasi, pk.id, pk.proposal, pk.status, $where
                    FROM desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, pinjaman_kelompok_$_SESSION[kd_kab] pk
				    WHERE d.id=k.desa AND k.id=pk.id_kel AND jpp.id=pk.jenis_pp AND k.lokasi='$_SESSION[lokasi]' AND pk.status='$sT' 
				    AND (nama_desa LIKE '%$search%' OR kd_kelompok LIKE '%$search%' OR nama_kelompok LIKE '%$search%'
				    OR status LIKE '%$search%' OR $like LIKE '%$search%' OR nama_kelompok LIKE '%$search%')
				    order by $ordering"));

$no = $start;
while($row=mysql_fetch_array($view)){
	$no = $no+1;
	$idpinj			= $row['id'];
	$tgl_now		= date('Y-m-d');
	$sts			= $row['status'];
    $jum_pem        = mysql_num_rows(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$row[id]'"));
    
    if ($sts == 'P') {
        $tgl = $row['tgl_proposal'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "kd_kel"    => $row['kd_kelompok'],
            "nama_kel"  => strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']),
            "proposal"  => number_format($row['proposal']),
            "anggota"   => $jum_pem,
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'V') {
        $tgl = $row['tgl_verifikasi'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "kd_kel"    => $row['kd_kelompok'],
            "nama_kel"  => strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']),
            "proposal"  => number_format($row['proposal']),
            "alokasi"   => number_format($row['alokasi']),
            "anggota"   => $jum_pem,
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'W') {
        $tgl = $row['tgl_tunggu'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "kd_kel"    => $row['kd_kelompok'],
            "nama_kel"  => strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']),
            "proposal"  => number_format($row['proposal']),
            "alokasi"   => number_format($row['alokasi']),
            "anggota"   => $jum_pem,
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'A') {
        $saldopinjaman	= saldopinjaman("$tgl_now-$idpinj");
        $tgl = $row['tgl_cair'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "kd_kel"    => $row['kd_kelompok'],
            "nama_kel"  => strtoupper($row['nama_kelompok'])." ".strtoupper($row['nama_desa']),
            "alokasi"   => number_format($row['alokasi']),
            "saldo"     => number_format($saldopinjaman),
            "anggota"   => $jum_pem,
            "status"    => $row['nama_jpp']
        ];
    }
}

if ($total_rows < 1) {
    $output = [
        "draw"              =>  intval($_POST["draw"]),
        "recordsTotal"      =>  0,
        "recordsFiltered"   =>  0,
        "data"              =>  ['' => '']
    ];
} else {
    $output = [
        "draw"              =>  intval($_POST["draw"]),
        "recordsTotal"      =>  $rows,
        "recordsFiltered"   =>  $total_rows,
        "data"              =>  $data
    ];
}

echo json_encode($output);
?>