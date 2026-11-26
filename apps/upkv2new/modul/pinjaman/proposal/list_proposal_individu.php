<?php 
if (!isset($_SESSION)) session_start();
include '../../../inc/inc.koneksi.php';
include "../../../inc/fungsi_pinjaman_individu.php";

$sT = $_GET['status'];
$limit = $_GET['length'];
$start = $_GET['start'];
$search = $_GET['search']['value'];

$order = $_GET['order'][0]['column'];
$type = $_GET['order'][0]['dir'];

$ordering = $order . ' ' . $type;

if ($sT == 'P') {
    $where = 'pi.tgl_proposal';
    $like = 'pi.tgl_proposal';
} elseif ($sT == 'V') {
    $where = 'pi.tgl_verifikasi';
    $like = 'pi.tgl_verifikasi';
} elseif ($sT == 'W') {
    $where = 'pi.tgl_tunggu';
    $like = 'pi.tgl_tunggu';
} elseif ($sT == 'A') {
    $where = 'pi.tgl_cair';
    $like = 'pi.tgl_cair';
}

$view = mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
					WHERE d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp AND a.lokasi='$_SESSION[lokasi]' AND pi.jenis_pinjaman='I'
					AND pi.status='$sT' AND (pi.id LIKE '%$search%' OR $like LIKE '%$search%' OR a.nik LIKE '%$search%' OR a.namadepan LIKE '%$search%' OR 
					d.nama_desa LIKE '%$search%' OR jpp.nama_jpp LIKE '%$search%') 
					order by $ordering LIMIT $start, $limit");

$rows = mysql_num_rows($view);
$total_rows = mysql_num_rows(mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
					WHERE d.id=a.desa AND a.id=pi.nia AND jpp.id=pi.jenis_pp AND a.lokasi='$_SESSION[lokasi]' AND pi.jenis_pinjaman='I'
					AND pi.status='$sT' order by tgl_proposal asc"));

$no = $start;
while($row=mysql_fetch_array($view)) {
    $no = $no+1;
	$idpinj = $row['id'];
	$tgl_now = date('Y-m-d');
	$sts = $row['status'];
	
	if ($sts == 'P') {
        $tgl = $row['tgl_proposal'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "nik"       => $row['nik'],
            "nama"      => strtoupper($row['namadepan']),
            "desa"      => $row['nama_desa'],
            "proposal"  => number_format($row['proposal']),
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'V') {
        $tgl = $row['tgl_verifikasi'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "nik"       => $row['nik'],
            "nama"      => strtoupper($row['namadepan']),
            "desa"      => $row['nama_desa'],
            "proposal"  => number_format($row['proposal']),
            "alokasi"   => number_format($row['alokasi']),
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'W') {
        $tgl = $row['tgl_tunggu'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "nik"       => $row['nik'],
            "nama"      => strtoupper($row['namadepan']),
            "desa"      => $row['nama_desa'],
            "proposal"  => number_format($row['proposal']),
            "alokasi"   => number_format($row['alokasi']),
            "status"    => $row['nama_jpp']
        ];
    } elseif ($sts == 'A') {
        $saldopinjaman = saldopinjaman("$tgl_now-$idpinj");
        $tgl = $row['tgl_cair'];
        $data[] = [
            "no"        => $no,
            "loan_id"   => $row['id'],
            "tgl"       => $tgl,
            "nik"       => $row['nik'],
            "nama"      => strtoupper($row['namadepan']),
            "desa"      => $row['nama_desa'],
            "alokasi"   => number_format($row['alokasi']),
            "saldo"     => number_format($saldopinjaman),
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