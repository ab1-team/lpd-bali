<?php 
include "../inc/inc.koneksi.php";
include "../inc/fungsi_indotgl.php";
include "fungsi.php";

$kec=mysql_fetch_array(mysql_query("SELECT c.id,c.kd_kab,u.uname,u.namadepan,u.namabelakang FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_GET['id']));
$id = $kec['id']; 
$table_kelompok="kelompok_".$kec['kd_kab'];
$table_pk="pinjaman_kelompok_".$kec['kd_kab'];

$jum_kel = mysql_num_rows(mysql_query("select * from $table_kelompok WHERE lokasi='".$id."'"));
$jum_akt = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='".$id."' AND pk.status='A' "));

$jum_prop = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='".$id."' AND pk.status='P' "));
$jum_ver = mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='".$id."' AND pk.status='V' "));
$jum_wait =mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='".$id."' AND pk.status='W' "));

/* -- Tagihan -- */

$tgl=date('d');
$tgl_kondisi=date('Y-m-d');
$data1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
$data2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
$data3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");

$tagihan = array();

$no = 0;
while($row=mysql_fetch_array($data1))
{
	$tagihan[$no] = array(
	    'id' => $row['id'],
		'tgl' => tgl_indo($row['tgl_cair']),
		'nama' => $row['nama_kelompok'].' '.$row['nama_desa']
	);
	$no+=1;
}
$no = 0;
while($r=mysql_fetch_array($data2))
{
	$id_pinj=$r['id'];
	$nunggakpokok = nunggakpokok($tgl_kondisi."-".$id_pinj,$id,$table_pk);
	$tagihan[$no]['pokok'] = ($nunggakpokok);

	$no+=1;
}
$no = 0;
while($r=mysql_fetch_array($data3))
{
	$id_pinj=$r['id'];
	$nunggakjasa = nunggakjasa($tgl_kondisi."-".$id_pinj,$id,$table_pk);
	$tagihan[$no]['jasa'] = number_format($nunggakjasa);
	$no+=1;
}



$bln=date('Y-m');
$table_transaksi	="transaksi_".$id;
$tung0=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' ORDER BY pk.id ASC"); 
$tung1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' ORDER BY pk.id ASC");
$tung2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' ORDER BY pk.id ASC");
$tung3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='".$id."' ORDER BY pk.id ASC");

$tunggakan = array();
$noo = 0;
while($r=mysql_fetch_array($tung0))
{
	$idpinj = $r['id'];
	$tgl_now = date('Y-m-d');
	$nunggakpokok = nunggakpokok("$tgl_now-$idpinj",$id,$table_pk);
	$nunggakjasa = nunggakjasa("$tgl_now-$idpinj",$id,$table_pk);
	if ($nunggakpokok > 0 or $nunggakjasa > 0) {
		$no=1; $noo=$noo+$no;
	}
}

$no=0;
while($row=mysql_fetch_array($tung1))
{
	$idpinj = $row['id'];
	$tgl_cair = $row['tgl_cair'];
	$tgl_now = date('Y-m-d');
	$nunggakpokok = nunggakpokok("$tgl_now-$idpinj",$id,$table_pk);
	$nunggakjasa = nunggakjasa("$tgl_now-$idpinj",$id,$table_pk);
	if ($nunggakpokok > 0 or $nunggakjasa > 0) {
		$tunggakan[$no] = array(
			'tgl' => ($tgl_cair != "0000-00-00"?tgl_indo($tgl_cair):""),
			'nama' => $row['nama_kelompok'].' '.$row['nama_desa']
		); $no+=1;
	}
}

$no=0;
while($row=mysql_fetch_array($tung2)){
	$idpinj = $row['id'];
	$tgl_now = date('Y-m-d');
	$nunggakpokok = nunggakpokok("$tgl_now-$idpinj",$id,$table_pk);
	$nunggakjasa = nunggakjasa("$tgl_now-$idpinj",$id,$table_pk);
	if ($nunggakpokok > 0 or $nunggakjasa > 0) {
		$tunggakan[$no]['tunggakan'] = number_format($nunggakpokok,0,',','.');
		$no+=1;
	}
}

$no=0;
while($row=mysql_fetch_array($tung3))
{	
	$idpinj	= $row['id'];
	$tgl_now = date('Y-m-d');
	$nunggakpokok = nunggakpokok("$tgl_now-$idpinj",$id,$table_pk);
	$nunggakjasa = nunggakjasa("$tgl_now-$idpinj",$id,$table_pk);
	if ($nunggakpokok > 0 or $nunggakjasa > 0) {
		$tunggakan[$no]['jasa'] = number_format($nunggakjasa,0,',','.');
		$no+=1;
	}
}	

/* -- Agenda -- */

$dpk1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='W' AND k.lokasi='".$id."' ORDER BY pk.tgl_cair ASC ");
$dpk2=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.lokasi='".$id."' ORDER BY pk.tgl_cair ASC ");
$dpk3=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.lokasi='".$id."' ORDER BY pk.tgl_cair ASC ");

$agenda = array();
$status = array();
if($jum_wait>0) 
{
	$i = 0;
	while($pk1=mysql_fetch_array($dpk1))
	{
		if (($i+1) == mysql_num_rows($dpk1))
		{
		$tgl_cair=$pk1['tgl_cair'];

		//MENCARI TANGGAL CAIR ITU HARI APA
		$query = "SELECT datediff('$tgl_cair', CURDATE()) as selisih";
		$hasil = mysql_query($query);
		$data  = mysql_fetch_array($hasil);

		$selisih = $data['selisih'];
		 
		$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
		$namahari = date("l", $x);
		 
		if ($namahari == "Sunday") $namahari = "Minggu";
		else if ($namahari == "Monday") $namahari = "Senin";
		else if ($namahari == "Tuesday") $namahari = "Selasa";
		else if ($namahari == "Wednesday") $namahari = "Rabu";
		else if ($namahari == "Thursday") $namahari = "Kamis";
		else if ($namahari == "Friday") $namahari = "Jumat";
		else if ($namahari == "Saturday") $namahari = "Sabtu";

		// dipilih tanggal 1 Maret 2010 sebagai acuan  
		// hari pasaran tanggal 1 Maret 2010 adalah 'Pon'  
		$tgl1 = "2010-03-01";    

		// array urutan nama hari pasaran dimulai dari 'Pon'  
		$pasaran = array('Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing');  
		  
		// proses mencari selisih hari antara kedua tanggal  
		$pecah1 = explode("-", $tgl1);  
		$date1 = $pecah1[2];  
		$month1 = $pecah1[1];  
		$year1 = $pecah1[0];  
		  
		$pecah2 = explode("-", $tgl_cair);  
		$date2 = $pecah2[2];  
		$month2 = $pecah2[1];  
		$year2 =  $pecah2[0];  
		  
		$jd1 = GregorianToJD($month1, $date1, $year1);  
		$jd2 = GregorianToJD($month2, $date2, $year2);  
		  
		$selisih = $jd2 - $jd1;  
		  
		// hitung modulo 5 dari selisih harinya  
		$mod = $selisih % 5;

		$hari = array($namahari);
		if (isset($pasaran[$mod])) $hari[] = $tgl_cair;
		$tgl_stat =  implode(" ",$hari).", ".($tgl_cair != "0000-00-00"?tgl_indo($tgl_cair):"");
		$kelompok_stat = $pk1['nama_kelompok']." ".$pk1['nama_desa'];
		}
		$i+=1;
	}
} 
	$alokasi = 0;
	while($pk2=mysql_fetch_array($dpk2))
	{
		$alokasi = number_format($pk2['alokasi']);
	}

	$pemanfaat = 0;
	while($pk3=mysql_fetch_array($dpk3))
	{
		$pemanfaat=mysql_num_rows(mysql_query("select * from pinjaman_anggota_".$kec['kd_kab']." WHERE id_pinkel=".$pk3['id']));
	}								

$data = array(
	'status' => 1,
	'name' => $kec['namadepan']." ".$kec['namabelakang'],
	'group' => array(
		'active' => $jum_akt,
		'registered' => $jum_kel,
		'prop' => $jum_prop,
		'ver' => $jum_ver,
		'wait' => $jum_wait),
	'tagihan' => array(
		'group' => mysql_num_rows($data1),
		'tagihan' => $tagihan
		),
	'tunggakan' => array(
		'group' => $noo,
// 		'tunggakan' => $tunggakan
		),
// 	'agenda' => array(
// 		'group' => $jum_wait,
// 		'tgl' => $tgl_stat,
// 		'kelompok' => $kelompok_stat,
// 		'alokasi' => $alokasi,
// 		'pemanfaat' => $pemanfaat)
);

die(json_encode($data));
?>		
				
        