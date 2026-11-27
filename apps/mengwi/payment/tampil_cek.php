<?php session_start();
include "../inc/koneksi_payment.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$produk	=$_POST['kode'];
$id_pel	=$_POST['id_pel'];
$id_user	=$_SESSION['id'];

$agen_id	='ID27434';
	$password_agenid	='797781';
	$datetime	=date('Y-m-d H:i:s');
	$signature = sha1 (md5( $password_agenid ). strrev($agen_id).$datetime);

	$post = array( 'command' => "INQUIRY",
	'user' => 'AP62855',
	'password' => '982447',
	'time' => date("Y-m-d H:i:s"),
	'PRODUCT' => $produk,
	'IDPEL' => $id_pel,
	'TRXID' => $id_user,
	'sign' => $signature
	);
	$ch = curl_init('http://api.edunia.net/mpulsa');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch); //result anda kelola kembali
	curl_close($ch);

	$json = json_decode($result);
	$idpel=$json->idpel;
	$nmpel=$json->nmpel;
	$tagihan=$json->tagihan;
?>

<section class="alert alert-info">
	<b>Informasi :</b>
	<table width="100%">
		<tr><td width="40%">ID. Pelanggan</td><td width="60%">: <?php echo $idpel; ?></td></tr>
		<tr><td width="40%">Nama Pelanggan</td><td width="60%">: <?php echo $nmpel; ?></td></tr>
		<tr><td width="40%">Tagihan</td><td width="60%">: <?php echo $tagihan; ?></td></tr>
	</table>
</section>