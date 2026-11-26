<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_kelompok_$_SESSION[kd_kab]";

$id_pinj		= $_POST['id_pinj'];
$id_kel			= $_POST['id_kel'];
$jenis_pp		= $_POST['jenis_pp'];
$tgl_proposal	= $_POST['tgl_proposal'];
$proposal		= $_POST['proposal'];
$pros_jasa		= $_POST['pros_jasa'];
$jenis_jasa		= $_POST['jenis_jasa'];
$jangka			= $_POST['jangka'];
$sistem_angsuran= $_POST['sistem'];
$sa_jasa		= $_POST['sa_jasa']; //Sistem Angsuran Jasa
$user_id		= $_SESSION['id'];
$lu				= date('Y-m-d H:i:s');
$status			= "P";

$des=mysql_fetch_array(mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] pk WHERE d.id=pk.desa AND pk.id='$id_kel' "));

$_SESSION['nama_desa']	= $des['nama_desa']; //untuk mengirim ke input pemanfaat
$_SESSION['id_desa']	= $des['desa']; //untuk mengirim ke input pemanfaat
$_SESSION['id_kel']		= $_POST['id_kel']; //untuk mengirim ke input pemanfaat
$_SESSION['jenis_pp']	= $_POST['jenis_pp']; //untuk mengirim ke input pemanfaat
$_SESSION['proposal']	= $_POST['proposal']; //untuk mengirim ke input pemanfaat
$_SESSION['sts']		= "P"; //untuk mengirim ke input pemanfaat

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE id= '$id_pinj' AND `status`='P' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET jenis_pp			='$jenis_pp',
											tgl_proposal			='$tgl_proposal',
											proposal			='$proposal',
											alokasi				='$proposal',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem_angsuran',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND `status`='P' ";
	mysql_query($input);					
}else{
	
	$input = "INSERT INTO $table (id_kel,jenis_pp,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$id_kel', '$jenis_pp', '$tgl_proposal', '$proposal','$proposal','$pros_jasa','$jenis_jasa','$jangka','$sistem_angsuran','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);

	}
?>