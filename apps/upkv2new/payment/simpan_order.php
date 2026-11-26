<?php session_start();
include "../inc/koneksi_payment.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table_order="orderan";

$tgl_order	=date('Y-m-d H:i:s');
$nominal	="SN$_POST[denom]";
$nomor		=$_POST['hp'];
$status		=1;
$lokasi		=$_SESSION['lokasi'];
$id_user	=$_SESSION['id'];

$sql = mysql_query("SELECT *
				   FROM $table_order 
				   WHERE id= '$id'",$koneksi_1);
$row	= mysql_num_rows($sql);


if ($row<=0){
	
	$input = "INSERT INTO $table_order (id,tgl_order,nominal,nomor,status,lokasi,id_user)
				VALUES('','$tgl_order','$nominal','$nomor','$status','$lokasi','$id_user')";
	mysql_query($input,$koneksi_1);

	
	$agen_id	='ID27434';
	$password_agenid	='797781';
	$datetime	=date('Y-m-d H:i:s');
	$signature = sha1 (md5( $password_agenid ). strrev($agen_id).$datetime);

	$post = array( 'command' => "TOPUP",
	'user' => 'AP62855',
	'password' => '982447',
	'time' => date("Y-m-d H:i:s"),
	'VTYPE' => $nominal,
	'MSISDN' => $nomor,
	'TRXID' => $id_user,
	'sign' => $signature
	);
	$ch = curl_init('http://api.edunia.net/mpulsa');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch); //result anda kelola kembali
	curl_close($ch);

	$json = json_decode($result);
	$saldo=$json->saldo;
	
}
?>