<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "I";
$id_kel			= "0";
$id_pinkel		= "0";
$id_pinj		= $_POST['id_pinj'];
$nia			= $_POST['nia'];
$jenis_pp		= $_POST['jenis_pp'];
$nama_barang	= $_POST['nama_barang'];
$proposal		= $_POST['proposali'];
$tgl_proposal	= $_POST['tgl_proposal'];
$pros_jasa		= $_POST['pros_jasa'];
$jenis_jasa		= $_POST['jenis_jasa'];
$jangka			= $_POST['jangka'];
$sistem			= $_POST['sistem'];
$sa_jasa		= $_POST['sa_jasa'];
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "P";

$jumlah_p = (int)str_replace(".", "", $proposal);

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);
if($_SESSION['kd_kab']==32 OR $_SESSION['kd_kab']==1 OR $_SESSION['kd_kab']==48 ){
    if ($row>0){
	    $input	= "UPDATE $table			SET jenis_pp		='$jenis_pp',
											nama_barang			='$nama_barang',
											tgl_proposal		='$tgl_proposal',
											proposal			='$jumlah_p',
											alokasi				='$jumlah_p',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nama_barang,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp', '$nama_barang','$nia','$tgl_proposal','$jumlah_p','$jumlah_p','$pros_jasa','$jenis_jasa','$jangka','$sistem','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);
}}else{
    if ($row>0){
	$input	= "UPDATE $table			SET jenis_pp			='$jenis_pp',
											tgl_proposal		='$tgl_proposal',
											proposal			='$jumlah_p',
											alokasi				='$jumlah_p',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp','$nia','$tgl_proposal','$jumlah_p','$jumlah_p','$pros_jasa','$jenis_jasa','$jangka','$sistem','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);
}}
?>