<?php

function saldo($id_saldo) { //Saldo Debit Kredit by Kd Buku
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$kd_jb			= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	=$thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai and $kd_jb=="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_pakai' AND '$tglkondisi' ";
				}elseif($thn_kondisi==$thn_pakai and $kd_jb!="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}
			
			$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumd FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumk FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi='0'  AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldo=(saldoABD($kd_jb)+saldoATD("$tglkondisi-$kd_jb")+$sd['sumd'])-(saldoABK($kd_jb)+saldoATK("$tglkondisi-$kd_jb")+$sk['sumk']);
				}else if ($thn_kondisi>$thn_pakai) {
				$saldo=(saldoATD("$tglkondisi-$kd_jb")+$sd['sumd'])-(saldoATK("$tglkondisi-$kd_jb")+$sk['sumk']);
				}
			return $saldo;
}


function saldodebit($id_saldo) { //Saldo Debit neraca untuk 141 dan 151
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$kd_jb			= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	=$thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai and $kd_jb=="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_pakai' AND '$tglkondisi' ";
				}elseif($thn_kondisi==$thn_pakai and $kd_jb!="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}
				
			
			$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumd FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldo=(saldoABD($kd_jb)+saldoATD("$tglkondisi-$kd_jb")+$sd['sumd']);
				}else if ($thn_kondisi>$thn_pakai) {
				$saldo=(saldoATD("$tglkondisi-$kd_jb")+$sd['sumd']);
				}
			return $saldo;
}

function saldokredit($id_saldo) { //Saldo  Kredit untuk 141 dan 151
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$kd_jb			= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	=$thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai and $kd_jb=="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_pakai' AND '$tglkondisi' ";
				}elseif($thn_kondisi==$thn_pakai and $kd_jb!="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}
			$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumk FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi='0'  AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldo=(saldoABK($kd_jb)+saldoATK("$tglkondisi-$kd_jb")+$sk['sumk']);
				}else if ($thn_kondisi>$thn_pakai) {
				$saldo=(saldoATK("$tglkondisi-$kd_jb")+$sk['sumk']);
				}
			return $saldo;
}

function saldoATD($id_saldoATD) { //Saldo Awal Tahun Debit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$thn_kondisi   	= substr($id_saldoATD,0,4);
			$kd_jb			= substr($id_saldoATD,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoATK($id_saldoATK) { //Saldo Awal Tahun Debit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$thn_kondisi   	= substr($id_saldoATK,0,4);
			$kd_jb			= substr($id_saldoATK,11);
			$tahunlalu		=$thn_kondisi-1;

			$sak=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['satkredit'];
			return $sumk;
}

function saldoABD($kd_jb) { //Saldo Awal Debit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['sadebit'];
			return $sumd;
}

function saldoABKD($id_saldoABKD) { //Saldo Awal Bulan Debit by Kd Buku dengan KONDISI
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_jb			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sdebit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0'  AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			$sdebit=$sd['sdebit'];
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalbulanD=saldoABD($kd_jb)+$sdebit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalbulanD=$sdebit;
				}

			return $saldoawalbulanD;
}

function saldoABK($kd_jb) { //Saldo Awal Bulan Kredit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['sakredit'];
			return $sumk;
}


function saldoABKK($id_saldoABKK) { //Saldo Awal Bulan kREDIT by Kd Buku dengan KONDISI
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_saldoABKK,0,10);
			$kd_jb			= substr($id_saldoABKK,11);
			$bln_kondisi	= substr($id_saldoABKK,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoABKK,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo kREDIT pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as skredit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			$skredit=$sk['skredit'];
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalbulanK=saldoABK($kd_jb)+$skredit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalbulanK=$skredit;
				}

			return $saldoawalbulanK;
}

function saldoD($id_saldoD) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tgl_kondisi   	= substr($id_saldoD,0,10);
			$kd_jb			= substr($id_saldoD,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sdebit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			$sdebit		=$sd['sdebit'];
			return $sdebit;
}

function saldoK($id_saldoK) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tgl_kondisi   	= substr($id_saldoK,0,10);
			$kd_jb			= substr($id_saldoK,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as skredit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' "));
			$skredit		=$sk['skredit'];
			return $skredit;
}

//BY REKENING ===================================================

function namarek($kd_rek) { //Nama Rekening
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$rek=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening WHERE kd_rekening='$kd_rek'  "));
			$namarek		=$rek['nama_rekening'];
			return $namarek;
}



function SATDR($id_SATDR) { //Saldo Awal Tahun Debit by kd_rekening
			$kd_rek			= substr($id_SATDR,11);
			$thn_kondisi	= substr($id_SATDR,0,4);
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tahunlalu		=$thn_kondisi-1;
			$satd=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='debit'"));
			$satdebit		=$satd['satdebit'];
			return $satdebit;
}

function SATKR($id_SATKR) { //Saldo Awal Tahun KREDIT by kd_rekening
			$kd_rek			= substr($id_SATKR,11);
			$thn_kondisi	= substr($id_SATKR,0,4);
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tahunlalu		=$thn_kondisi-1;
			$satk=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='kredit'"));
			$satkredit		=$satk['satkredit'];
			return $satkredit;
}

function SABDR($id_SABDR) { //Total Saldo Awal Bulan Debit by kd_rekening
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_SABDR,0,10);
			$kd_rek			= substr($id_SABDR,11);
			$thn_kondisi	= substr($id_SABDR,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$tgl_awaltahun	= "$thn_kondisi-01-01";
			
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$table_transaksi="transaksi_".$_SESSION['lokasi'];
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}

			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='debit'"));
			$sumd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_debit='$kd_rek' AND $kondisi "));
			$sadebit		=$sad['sadebit'];	//Saldo Awal bulan penggunaan
			$sumdebit		=$sumd['sumjumlah'];	//Saldo Awal bulan penggunaan
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalD=$sadebit+$sumdebit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalD=$sumdebit;
				}
			return $saldoawalD;
}

function SABKR($id_SABKR) { //Total Saldo Awal Bulan Debit by kd_rekening
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_SABKR,0,10);
			$kd_rek			= substr($id_SABKR,11);
			$thn_kondisi	= substr($id_SABKR,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$table_transaksi="transaksi_".$_SESSION['lokasi'];
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' "; //Update  $thn_pakai pada 07/01/2017 karena pada tutup buku eror rekening 131
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}

			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='kredit'"));
			$sumk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_kredit='$kd_rek' AND $kondisi "));
			$sakredit		=$sak['sakredit'];	//Saldo Awal bulan penggunaan
			$sumkredit		=$sumk['sumjumlah'];	//Saldo Awal bulan penggunaan
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalD=$sakredit+$sumkredit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalD=$sumkredit;
				}
			return $saldoawalD;
}

function saldoawalD($id_saldoawalD) { //Total Saldo Awal Tahun+Bulan Debit by kd_rekening
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_saldoawalD,0,10);
			$kd_rek			= substr($id_saldoawalD,11);
			$bln_kondisi	= substr($id_saldoawalD,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoawalD,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$table_transaksi="transaksi_".$_SESSION['lokasi'];
			$tahunlalu		=$thn_kondisi-1;
			$satd=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  "));
			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  "));
			$satdebit		=$satd['satdebit'];	//Saldo Awal Tahun dengan Kondisi
			$sadebit		=$sad['sadebit'];	//Saldo Awal bulan penggunaan
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalD=$satdebit+$sadebit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalD=$satdebit;
				}
			return $saldoawalD;
}

function saldoawalK($id_saldoawalK) { //Total Saldo Awal Tahun+Bulan Debit by kd_rekening
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_saldoawalK,0,10);
			$kd_rek			= substr($id_saldoawalK,11);
			$bln_kondisi	= substr($id_saldoawalK,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoawalK,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$table_transaksi="transaksi_".$_SESSION['lokasi'];
			$tahunlalu		=$thn_kondisi-1;
			$satk=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_rekening='$kd_rek'  "));
			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_rekening='$kd_rek' "));
			$satkredit		=$satk['satkredit'];	//Saldo Awal Tahun dengan Kondisi
			$sakredit		=$sak['sakredit'];	//Saldo Awal bulan penggunaan
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalK=$satkredit+$sakredit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalK=$satkredit;
				}
			return $saldoawalK;
}

function saldoBBD($id_saldoBBD) { //Total Debit Buku Besar by rekening_kredit di transaksi 
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_kondisi   	= substr($id_saldoBBD,0,10);
			$kd_rek			= substr($id_saldoBBD,11);
			$thn_kondisi	= substr($id_saldoBBD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbdebit FROM $table_transaksi WHERE rekening_debit='$kd_rek' AND $kondisi"));
			$saldoBBD		=$sbbd['sbbdebit'];
			return $saldoBBD;
}

function saldoBBK($id_saldoBBK) { //Total Kredit Buku Besar by rekening_kredit di transaksi 
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_kondisi   	= substr($id_saldoBBK,0,10);
			$kd_rek			= substr($id_saldoBBK,11);
			$thn_kondisi	= substr($id_saldoBBK,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE rekening_kredit='$kd_rek' AND $kondisi"));
			$saldoBBK		=$sbbk['sbbkredit'];
			return $saldoBBK;
}

//E-BUDGETING
function saldoRB($id_saldoRB) { //Total Saldo Buku Besar by rekening_kredit by Bulan di transaksi 
			$bln_kondisi   	= substr($id_saldoRB,0,7);
			$kd_rekening   	= substr($id_saldoRB,8); //2017-01-101
			
			$awal			="$bln_kondisi-01";
			$akhir			=date('Y-m-t', strtotime("$bln_kondisi-01"));;
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$bln_pakai   	= substr($tgl_pakai,0,7);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE rekening_kredit='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRB		=$sbbk['sbbkredit'];
			return $saldoRB;
}

function saldoRT($id_saldoRT) { //Total Saldo Buku Besar by rekening_kredit by Tahun di transaksi 
			$tahun_kondisi   	= substr($id_saldoRT,0,4);
			$kd_rekening   	= substr($id_saldoRT,5); //2017-01-101
			
			$awal			="$tahun_kondisi-01-01";
			$akhir			="$tahun_kondisi-12-31";
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE rekening_kredit='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRT		=$sbbk['sbbkredit'];
			return $saldoRT;
}

function saldoRBB($id_saldoRBB) { //Total Saldo Buku Besar by rekening_debit by Bulan di transaksi 
			$bln_kondisi   	= substr($id_saldoRBB,0,7);
			$kd_rekening   	= substr($id_saldoRBB,8); //2017-01-101
			
			$awal			="$bln_kondisi-01";
			$akhir			=date('Y-m-t', strtotime("$bln_kondisi-01"));;
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE rekening_debit='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRBB		=$sbbk['sbbkredit'];
			return $saldoRBB;
}

function saldoRBT($id_saldoRBT) { //Total Saldo Buku Besar by rekening_kredit by Tahun di transaksi 
			$tahun_kondisi   	= substr($id_saldoRBT,0,4);
			$kd_rekening   	= substr($id_saldoRBT,5); //2017-01-101
			
			$awal			="$tahun_kondisi-01-01";
			$akhir			="$tahun_kondisi-12-31";
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbdebit FROM $table_transaksi WHERE rekening_debit='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRBT		=$sbbk['sbbdebit'];
			return $saldoRBT;
}




function pendapatan($tgl_kondisi) {
			$jb=mysql_query("select * from jenis_buku jb, rekening_$_SESSION[lokasi] r WHERE jb.kd_jb=r.kd_jb AND jb.posisi='4' AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND jb.posisi='4' AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ");
				while($row=mysql_fetch_array($jb)){
			$saldo_p=saldoawalK("$tgl_kondisi-".$row['kd_rekening'])+saldoBBK("$tgl_kondisi-".$row['kd_rekening']);
			$pendapatan=$pendapatan+$saldo_p;
			}
		 return $pendapatan;
}

function biaya($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku jb, rekening_$_SESSION[lokasi] r WHERE jb.kd_jb=r.kd_jb AND jb.posisi='5' AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR jb.kd_jb=r.kd_jb AND jb.posisi='5' AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo_b=saldoawalD("$tgl_kondisi-".$r['kd_rekening'])+saldoBBD("$tgl_kondisi-".$r['kd_rekening']);
			$biaya=$biaya+$saldo_b;
			}
		 return $biaya;
}

function surplus($tgl_kondisi) {
			$pendapatan	=pendapatan("$tgl_kondisi");
			$biaya		=biaya("$tgl_kondisi");
			$surlus		=$pendapatan-$biaya;
		 return $surlus;
}



function asetekonomi($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR posisi='1' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$asetekonomi=$asetekonomi+$saldo;
			}
		 return $asetekonomi;
}

function modalawal($tgl_kondisi) {
	$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
			if($row['kd_prov']=="2") { //Jawa Tengah
				$modalawal=(saldo("$tgl_kondisi-311")*-1)+(saldo("$tgl_kondisi-312")*-1)+(saldo("$tgl_kondisi-313")*-1);
			}else{
				$modalawal=(saldo("$tgl_kondisi-311")*-1)+(saldo("$tgl_kondisi-312")*-1);
			}
		 return $modalawal;
}

function asetproduktif($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' AND ap='1' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR posisi='1' AND ap='1' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$asetproduktif=$asetproduktif+$saldo;
			}
		 return $asetproduktif;
}

function aktiva($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR posisi='1' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$aktiva=$aktiva+$saldo;
			}
		 return $aktiva;
}

function number_format_negatif($number) {
    if($number<0){
        $tampil="(".number_format($number*-1).")";
    }else{
        $tampil=number_format($number);
    }
		 return $tampil;
}




?>