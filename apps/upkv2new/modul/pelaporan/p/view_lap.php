<?php
session_start();
include "../../../inc/inc.koneksi.php";

//get data post dari form
$data       = json_decode(file_get_contents('php://input'));
$ip         = $data->ip;
$uname      = $data->uname;

if(empty($data->key)){
   
    echo 'Permintaan ditolak';
    http_response_code(400);
    exit();
}

//generate key dari data yang diterima --> post (form)
$key_hash1 = hash_hmac("sha256", $ip, $uname);
$key_hash2 = $data->key;

//verifikasi key
if(password_verify($key_hash1, $key_hash2)){
    
    // echo "<br> OKOK OKOK <br>";
    // echo $data->tgl;
    // echo $data->bln;
    // echo $data->thn;
    // echo "<br>";
    // echo $data->report;
    // echo "<br>";
    // echo $data->sub_report;
    $sub_laporan = $data->sub_report;
    $jenis_laporan = $data->report;
    
    if (empty($sub_laporan)) {
	$file	=$jenis_laporan;
    }else{
    	$file	=substr($sub_laporan,0,2);
    }
    
    $lokasi = $data->loc;
    $kd_kab = "SELECT kd_kab from kecamatan where id='$lokasi'";
    $result = mysql_query($kd_kab);
    $row    = mysql_fetch_assoc($result); 
    
    $_SESSION['lokasi'] = $lokasi;
    $_SESSION['kd_kab'] = $row['kd_kab'];
    $_POST["d"] = $data->tgl;
    $_POST["m"] = $data->bln;
    $_POST["y"] = $data->thn;
    $_POST["report"] = $data->report;
    $_POST["sub_report"] = $data->sub_report;
    
    // echo "<input type='hidden' id='tgl' name'tgl' value=$data->tgl";
    // echo "<input type='hidden' id='bln' name'bln' value=$data->bln";
    // echo "<input type='hidden' id='thn' name'thn' value=$data->thn";
    
    // $tgl = $_POST['tgl'];
    // $bln = $_POST['bln'];
    // $thn = $_POST['thn'];
    
    // echo $tgl;
    // echo $bln;
    // echo $thn;
    // print_r($_SERVER);
    
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";
    // print_r($_POST);
    // print_r($_GET);
    // print_r($_FILES);
    
    // echo "ini bisa $d-$m-$y";
    
    include "$file.php";
    
    
}else{
    echo "You Don't Have Permission";
}