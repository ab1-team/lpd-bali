<?php
session_start(); // WAJIB paling atas, sebelum apapun!

include "../../inc/inc.koneksi.php";

function anti_injection($data) {
    $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter;
}

$uname = anti_injection($_POST['uname']);
$pass  = anti_injection($_POST['pass']);
$ip    = $_SERVER['REMOTE_ADDR'];
$url   = $_SERVER['HTTP_HOST'];

if (!ctype_alnum($uname) || !ctype_alnum($pass)) {
    // Pakai JavaScript redirect agar tidak bentrok dengan header
    echo "<script>alert('Cek Uname dan Passwordnya!'); window.history.back();</script>";
    exit;
}

$login_lpd  = mysql_query("SELECT * FROM users WHERE uname='$uname' AND pass='$pass'");
$ketemu_lpd = mysql_num_rows($login_lpd);

if ($ketemu_lpd > 0) {
    $r   = mysql_fetch_array($login_lpd);
    $row = mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.id=d.kd_kec AND d.id='$r[lokasi]'"));

    $_SESSION['id']        = $r['id'];
    $_SESSION['uname']     = $r['uname'];
    $_SESSION['pass']      = $r['pass'];
    $_SESSION['level']     = $r['level'];
    $_SESSION['jabatan']   = $r['jabatan'];
    $_SESSION['lokasi']    = $r['lokasi'];
    $_SESSION['hak_akses'] = $r['hak_akses'];
    $_SESSION['kd_kab']    = $row['kd_kab'];

    $kunjung = (int)$r['kunjungan'] + 1;
    $tanggal = date("Y-m-d H:i:s");
    mysql_query("UPDATE users SET online='Y', lo='$tanggal', ip='$ip', kunjungan='$kunjung' WHERE id='$r[id]'");

    header('location: ../../2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=1');
    exit; // Wajib setelah header redirect!

} else {
    echo "<script>alert('Username dan Password tidak dikenal!'); window.location.href='../../';</script>";
    exit;
}
?>