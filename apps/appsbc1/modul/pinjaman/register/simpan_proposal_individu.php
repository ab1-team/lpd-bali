<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "1";

$id_pinkel		= "0";
$id_pinj_i		= $_POST['id_pinj_i'];
$nia			= $_POST['nia'];
$jenis_pp		= "1";

$pros_jasa		= $_POST['pros_jasa'];
$jenis_jasa		= $_POST['jenis_jasa'];
$jangka			= $_POST['jangka'];
$sistem			= $_POST['sistem'];
$sa_jasa		= $_POST['sa_jasa'];
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "P";
$materai        = $_POST['materai'];
$jum_materai    = $_POST['jum_materai'];
$mtr            ="$materai#$jum_materai";

$proposali				= str_replace(".", "", $_POST['proposali']);

$penghasilan_pemohon	= str_replace(".", "", $_POST['penghasilan_pemohon']);
$penghasilan_sutri		= str_replace(".", "", $_POST['penghasilan_sutri']);
$penghasilan_lain		= str_replace(".", "", $_POST['penghasilan_lain']);

$biaya_pangan		= str_replace(".", "", $_POST['biaya_pangan']);
$listrik_air		= str_replace(".", "", $_POST['listrik_air']);
$telpon_internet	= str_replace(".", "", $_POST['telpon_internet']);
$biaya_pendidikan	= str_replace(".", "", $_POST['biaya_pendidikan']);
$biaya_sandang		= str_replace(".", "", $_POST['biaya_sandang']);
$upacara_adat		= str_replace(".", "", $_POST['upacara_adat']);
$angsuran_bank_lain	= str_replace(".", "", $_POST['angsuran_bank_lain']);
$biaya_lain			= str_replace(".", "", $_POST['biaya_lain']);

$aktiva_uang_tunai	= str_replace(".", "", $_POST['aktiva_uang_tunai']);
$simpanan			= str_replace(".", "", $_POST['simpanan']);
$kendaraan			= str_replace(".", "", $_POST['kendaraan']);
$tanah				= str_replace(".", "", $_POST['tanah']);
$bangunan			= str_replace(".", "", $_POST['bangunan']);
$aktiva_lain		= str_replace(".", "", $_POST['aktiva_lain']);

$pinjaman_pribadi	= str_replace(".", "", $_POST['pinjaman_pribadi']);
$pinjaman_lpd		= str_replace(".", "", $_POST['pinjaman_lpd']);
$pinjaman_bank		= str_replace(".", "", $_POST['pinjaman_bank']);

$deskripsi_jaminan	= $_POST['deskripsi_jaminan'];
$nilai_jual			= str_replace(".", "", $_POST['nilai_jual']);


$pendapatan		="$penghasilan_pemohon#$penghasilan_sutri#$penghasilan_lain";
$biaya 			="$biaya_pangan#$listrik_air#$telpon_internet#$biaya_pendidikan#$biaya_sandang#$upacara_adat#$angsuran_bank_lain#$biaya_lain";
$aktiva 		="$aktiva_uang_tunai#$simpanan#$kendaraan#$tanah#$bangunan#$aktiva_lain";
$pasiva			="$pinjaman_pribadi#$pinjaman_lpd#$pinjaman_bank";
$jaminan		="$nilai_jual#$deskripsi_jaminan";
$data_proposal	="$_POST[tgl_proposal]#$proposali#$jangka#$pros_jasa#$jenis_jasa#$sistem#$sa_jasa#$_POST[tujuan_permohonan]#$_POST[biaya_admin]";


$row = mysql_num_rows(mysql_query("SELECT * FROM $table WHERE id= '$id_pinj_i'"));

if ($row>0){
	
			$update	= "UPDATE $table SET 	pendapatan			='$pendapatan',
											biaya				='$biaya',
											aktiva				='$aktiva',
											pasiva				='$pasiva',
											jaminan				='$jaminan',
											data_proposal		='$data_proposal',
											alokasi				='$proposali',
											jangka				='$jangka',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											sistem_angsuran		='$sistem',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
											materai				='$mtr'
						WHERE id='$id_pinj_i' ";
	mysql_query($update);							
}else{
	
	
	$des=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));
	
	$lok	=$_SESSION['lokasi'];
 
	$nkred	=$des['last_debitur']+1;

	
		 if($lok<10) {$lokasi="000$lok";}
	else if($lok>=10 AND $lok<100) {$lokasi="00$lok";}
	else if($lok>=100 AND $lok<1000) {$lokasi="0$lok";}
	else if($lok>=1000 AND $lok<10000) {$lokasi="$lok";}
	
		 if($nkred<10) {$nkred="000$nkred";}
	else if($nkred>=10 AND $nkred<100) {$lkred="00$nkred";}
	else if($nkred>=100 AND $nkred<1000) {$lkred="0$nkred";}
	else if($nkred>=1000 ) {$lkred="$nkred";}
	
	$no_rekening	="$lokasi.1.12.$lkred";
	
	
	$input = "INSERT INTO $table (lokasi,jenis_pinjaman,no_rekening,id_pinkel,jenis_pp,nia,pendapatan,biaya,aktiva,pasiva,jaminan,data_proposal,alokasi,jangka,pros_jasa,jenis_jasa,sistem_angsuran,sa_jasa,status,lu,user_id,materai)
				VALUES('$_SESSION[lokasi]','$jenis_pinjaman','$no_rekening', '$id_pinkel', '$jenis_pp','$nia','$pendapatan','$biaya','$aktiva','$pasiva','$jaminan','$data_proposal','$proposali','$jangka','$pros_jasa','$jenis_jasa','$sistem','$sa_jasa','$status','$lu','$user_id','$mtr')";
	mysql_query($input);
	
	$des=mysql_fetch_array(mysql_query("select * from desa where id='$_SESSION[lokasi]'"));
 
	$last_norek	=$des['last_debitur']+1;
	
	$update	= "UPDATE desa SET last_debitur='$last_norek' WHERE id= '$_SESSION[lokasi]'";
	mysql_query($update);
}
?>