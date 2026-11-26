<?php 
include "../inc/inc.koneksi.php";
include "../inc/fungsi_indotgl.php";
include "fungsi.php";

if (isset($_POST['id_pinjaman']))
{

	if ($_POST['id_pinjaman'] == NULL) 
	{
		$arr = array('status' => 404, 'msg' => 'Transaksi tidak valid ...');
	} else {

	$table_transaksi="transaksi_".$_POST['lokasi'];

	$idt=mysql_fetch_array(mysql_query("SELECT max(idtp) FROM $table_transaksi ORDER BY idtp DESC"));
	$idtp			=$idt[0]+1;
	
	$tgl = explode("/",$_POST['tgl']);

	$id_pinj				=$_POST['id_pinjaman'];			
	$jenis_pp				=$_POST['jenis_pp'];			
	$tgl_transaksi			=$tgl[2]."-".$tgl[1]."-".$tgl[0];			
	$urutan					=0;			
	$pokok					=$_POST['pokok'];
	$jasa					=$_POST['jasa'];
	$denda					=$_POST['denda'];
	$id_user				=$_POST['id_user'];

	$tgl_kondisi			= date('Y-m-d');

	$users=mysql_fetch_array(mysql_query("SELECT u.id FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$id_user));

	$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id=".$_POST['lokasi']));
	$lembaga = strtoupper($kec['nama_lembaga_sort']);
	$nama_kec = strtoupper($kec['nama_kec']);
	$u=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$id_user'"));
	$inisial = "$u[ins]-$idtp";

	$kel=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_".$_POST['lokasi']." pk, kelompok_".$_POST['lokasi']." k WHERE k.id=pk.id_kel AND pk.id='$id_pinj' "));
	$nama_kelompok=addslashes("$kel[nama_kelompok] ($id_pinj)");

	$namakelompok=addslashes("$kel[nama_kelompok]");
	$alamat_kelompok = $kel['alamat_kelompok'];
	$alamat = $kec['alamat_kec'];
	$telpon	= $kec['telpon_kec'];		
	$jenis_jasa	= $kel['jenis_jasa'];
	
				if($jenis_pp==1) { //SPP
					$nama_jp		="SPP";
					$rek_pokok_d	="112.01";
					$rek_jasa_d		="112.02";
					$rek_denda_d	="112.03";
					$rek_pokok_k	="131.02";
					$rek_jasa_k		="411.01";
					$rek_denda_k	="411.03";
					}
					elseif($jenis_pp==2) { //UEP
					$nama_jp		="UEP";
					$rek_pokok_d	="113.01";
					$rek_jasa_d		="113.02";
					$rek_denda_d	="113.03";
					$rek_pokok_k	="132.02";
					$rek_jasa_k		="411.02";
					$rek_denda_k	="411.04";
					}
					elseif($jenis_pp==3) { //PL
					$nama_jp		="PL";
					$rek_pokok_d	="115.01";
					$rek_jasa_d		="115.02";
					$rek_denda_d	="115.03";
					$rek_pokok_k	="133.01";
					$rek_jasa_k		="411.06";
					$rek_denda_k	="411.07";
					}
					elseif($jenis_pp==4) { //DKU
					$nama_jp		="PL";
					$rek_pokok_d	="116.01";
					$rek_jasa_d		="116.02";
					$rek_denda_d	="116.03";
					$rek_pokok_k	="134.02";
					$rek_jasa_k		="411.08";
					$rek_denda_k	="411.09";
					}

	$input_pokok = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES('','$tgl_transaksi','$rek_pokok_d', '$rek_pokok_k','$idtp','$id_pinj','Angs.Pokok $nama_jp $nama_kelompok','$pokok','$urutan','$id_user')";
								
	$input_jasa = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES('','$tgl_transaksi','$rek_jasa_d', '$rek_jasa_k','$idtp','$id_pinj','Angs.Jasa $nama_jp $nama_kelompok','$jasa','$urutan','$id_user')";
					
	$input_denda = "INSERT INTO $table_transaksi (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
					VALUES('','$tgl_transaksi','$rek_denda_d', '$rek_denda_k','$idtp','$id_pinj','Denda $nama_jp $nama_kelompok','$denda','$urutan','$id_user')";
								
	if ($pokok<=0 and $jasa>0 and $denda>0){
		mysql_query($input_jasa);
		mysql_query($input_denda);
		
	}else if ($pokok>0 and $jasa<=0 and $denda>0){
		mysql_query($input_pokok);
		mysql_query($input_denda);
		
	}else if ($pokok>0 and $jasa>0 and $denda<=0){
		mysql_query($input_pokok);
		mysql_query($input_jasa);
		
	}else if ($pokok>0 and $jasa<=0 and $denda<=0){
		mysql_query($input_pokok);
		
	}else if ($pokok<=0 and $jasa>0 and $denda<=0){
		mysql_query($input_jasa);
		
	}else if ($pokok<=0 and $jasa<=0 and $denda>0){
		mysql_query($input_denda);
		
	}else if($pokok>0 and $jasa>0 and $denda>0){
		mysql_query($input_pokok);
		mysql_query($input_jasa);
		mysql_query($input_denda);
	}
	
	$lembaga2 = "";
	if ((strlen($lembaga)+strlen($nama_kec)+1) > 31) 
	{
	    $lembaga = substr($lembaga,0,31);
	    $lembaga2 = $nama_kec;
	} else {
	    $lembaga = $lembaga." ".$nama_kec;
	}
	
	$alamat2 = "";
	if (strlen(trim($alamat)) > 31) {
	    $alamat = substr($alamat,0,31);
	    $alamat2 = substr($alamat,32,31);
	} 
	
	$alamat_kelompok2 = "";
	if (strlen($alamat_kelompok) > 31) {
	    $alamat_kelompok = substr($alamat_kelompok,0,31);
	    $alamat_kelompok2 = substr($alamat_kelompok,31,31);
	} 
	
	$arr = array(
		'status' => 1,
		'tgl' => $_POST['tgl'],
		'pokok' => $_POST['pokok'] > 0 ? number_format($_POST['pokok'],0,',','.') : 0,
		'jasa' => $_POST['jasa'] > 0 ? number_format($_POST['jasa'],0,',','.') : 0,
		'denda' => $_POST['denda'] > 0 ? number_format($_POST['denda'],0,',','.') : 0,
		'kelompok' => strtoupper($namakelompok),
		'telepon' => $telpon,
		'jenis_jasa' => $jenis_jasa,
		'lembaga' => $lembaga,
		'lembaga2' => $lembaga2,
		'kecamatan' => $nama_kec,
		'alamat' => trim($alamat),
		'alamat2' => trim($alamat2),
		'alamat_kelompok' => $alamat_kelompok,
		'alamat_kelompok2' => $alamat_kelompok2,
		'total' => number_format($_POST['pokok']+$_POST['jasa']+$_POST['denda'],0,',','.')
	);
	}

} else {
$kelompok = explode("-|-",$_POST['kelompok']);

$core=mysql_fetch_array(mysql_query("SELECT c.id id_kecamatan,c.kd_kab,u.id FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_POST['id']));
$text = "SELECT * FROM desa d, kelompok_".$core['kd_kab']." k, sistem_angsuran sa, pinjaman_kelompok_".$core['kd_kab']." pk WHERE sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi = ".$core['id_kecamatan']." AND d.nama_desa='".$kelompok[0]."' AND pk.status='A' AND k.nama_kelompok= '".$kelompok[1]."'";

$id = $core['id_kecamatan'];
$table_pk="pinjaman_kelompok_".$core['kd_kab'];

$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0){
	$r=mysql_fetch_array($sql);
	$jpp=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman WHERE id='$r[jenis_pp]' "));
						
	$tgl_cair	=$r['tgl_cair'];
	$alokasi	=$r['alokasi'];
	$jangka		=$r['jangka'];
	$sistem		=$r['sistem'];
	$pros_jasa	=$r['pros_jasa'];
	$jenis_pp	=$r['jenis_pp'];
	$tgl_now	=date('Y-m-d');
	
	if($jenis_pp==1) { $jenis_buku='112'; } else if($jenis_pp==2) { $jenis_buku='113'; }
	
	$tempo=$jangka/$sistem;
	$tgl_kondisi=date('Y-m')."-31";

	$nunggakpokok=nunggakpokok("$tgl_kondisi-$r[id]",$id,$table_pk); //tunggakan menjadi tagihan pada form angsuran
	$nunggakjasa=nunggakjasa("$tgl_kondisi-$r[id]",$id,$table_pk);
	
	$smpokok=sumpokok("$tgl_now-$r[id]",$id,$table_pk);
	if($smpokok=="") { $sumpokok="0"; }else{$sumpokok=$smpokok; }
	$proskembali = floor($sumpokok/$alokasi*100);
						
	$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id=".$core['id_kecamatan']));
	$tgl_pakai = $tp['tgl_pakai'];				
	
	$arr = array(
		'id_user' => $core['id'],
		'status' => 1,
		'lokasi' => $core['id_kecamatan'],
		'pokok' => $nunggakpokok,
		'jasa' => $nunggakjasa,
		'id_pinjaman' => $r['id'],
		'jenis_pp' => $r['jenis_pp'],
		'tgl_pakai' => $tgl_pakai,
		'tgl_cair' => $tgl_cair,
		'tgl' => date('d/m/Y'),
		'alokasi' => $alokasi,
		'persen' => $proskembali,
		'jumlah_pokok' => $sumpokok,
		'param1' => $kelompok[0],
		'param2' => $kelompok[1]);

} else {

	$arr = array('status' => 404);

}

}

die(json_encode($arr));



?>