<?php

function saldokab($id_saldokab) {
			$tglkondisi   	= substr($id_saldokab,0,10); //2016-03-11-111-24
			$kd_jb			= substr($id_saldokab,11,3);
			$kdkab			= substr($id_saldokab,15);
			
			$kec=mysql_query("select * from kecamatan WHERE kd_kab='$kdkab' ");
				while($r=mysql_fetch_array($kec)){
			$lokasi ="$r[kd_kab]-$r[id]";
			$idkec	=$r['id'];
			$table_transaksi	="transaksi_$idkec";
			$table_rekening		="rekening_$idkec";
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$idkec' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$thn_pakai   	= substr($tgl_pakai,0,4);
			$thn_kondisi   	= substr($id_saldokab,0,4);
			$tahunlalu		=$thn_kondisi-1;
			$tgl_awaltahun	=$thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai and $kd_jb=="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_pakai' AND '$tglkondisi' ";
				}elseif($thn_kondisi==$thn_pakai and $kd_jb!="411") {		//bulan berikutnya di tahun yang sama
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="t.tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
				}
			
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumd FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$kdkab-$idkec,%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$kdkab-$idkec,%' "));
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumk FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi='0'  AND jb.kecuali NOT LIKE '%$kdkab-$idkec,%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi  AND jb.lokasi LIKE '%$kdkab-$idkec,%' "));
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldo=(saldoABD($kd_jb-$idkec)+saldoATD("$tglkondisi-$kd_jb-$idkec")+$sd['sumd'])-(saldoABK($kd_jb-$idkec)+saldoATK("$tglkondisi-$kd_jb-$idkec")+$sk['sumk']);
				}else if ($thn_kondisi>$thn_pakai) {
				$saldo=(saldoATD("$tglkondisi-$kd_jb-$idkec")+$sd['sumd'])-(saldoATK("$tglkondisi-$kd_jb-$idkec")+$sk['sumk']);
				}
			$saldokab=$saldokab+$saldo;
			}
			
		 return $saldokab;
}

function saldoATD($id_saldoATD) { //Saldo Awal Tahun Debit by Kd Buku
			
			$thn_kondisi   	= substr($id_saldoATD,0,4);
			$kd_jb			= substr($id_saldoATD,11,3);
			$idkec			= substr($id_saldoATD,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_rekening	="rekening_$idkec";
			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoATK($id_saldoATK) { //Saldo Awal Tahun Debit by Kd Buku
			$thn_kondisi   	= substr($id_saldoATK,0,4);
			$kd_jb			= substr($id_saldoATK,11,3);
			$idkec			= substr($id_saldoATK,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_rekening	="rekening_".$idkec;
			$thn_kondisi   	= substr($id_saldoATK,0,4);
			$kd_jb			= substr($id_saldoATK,11,3);
			$idkec			= substr($id_saldoATK,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_rekening	="rekening_$idkec";
			
			$sak=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['satkredit'];
			return $sumk;
}

function saldoABD($id_saldoABD) { //Saldo Awal Debit by Kd Buku
			$kd_jb   	= substr($id_saldoABD,0,3); //111-24
			$idkec		= substr($id_saldoABD,4);
			
			$table_rekening	="rekening_$idkec";
			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['sadebit'];
			return $sumd;
}

function saldoABKD($id_saldoABKD) { //Saldo Awal Bulan Debit by Kd Buku dengan KONDISI
			
			$thn_kondisi   	= substr($id_saldoABKD,0,4);
			$kd_jb			= substr($id_saldoABKD,11,3);
			$idkec			= substr($id_saldoABKD,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$idkec' "));
			$tgl_pakai=$tp['tgl_pakai'];
			$lokasi ="$tp[kd_kab]-$tp[id]";
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_jb			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_".$idkec; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$idkec;
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$lokasi%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$lokasi%' "));
			$sdebit=$sd['sdebit'];
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalbulanD=saldoABD("$kd_jb-$idkec")+$sdebit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalbulanD=$sdebit;
				}

			return $saldoawalbulanD;
}

function saldoABK($id_saldoABK) { //Saldo Awal Bulan Kredit by Kd Buku
			$kd_jb   	= substr($id_saldoABK,0,3); //111-24
			$idkec		= substr($id_saldoABK,4);
			
			$table_rekening	="rekening_$idkec";
			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['sakredit'];
			return $sumk;
}


function saldoABKK($id_saldoABKK) { //Saldo Awal Bulan kREDIT by Kd Buku dengan KONDISI
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$idkec' "));
			$tgl_pakai=$tp['tgl_pakai'];
			$lokasi ="$tp[kd_kab]-$tp[id]";
			
			$tgl_kondisi   	= substr($id_saldoABKK,0,10);
			$kd_jb			= substr($id_saldoABKK,11,3);
			$idkec			= substr($id_saldoABKK,15);
			$bln_kondisi	= substr($id_saldoABKK,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoABKK,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_$idkec"; //Mencari saldo kREDIT pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_$idkec";
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as skredit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$lokasi%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$lokasi%' "));
			$skredit=$sk['skredit'];
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$saldoawalbulanK=saldoABK("$kd_jb-$idkec")+$skredit;
				}else if ($thn_kondisi>$thn_pakai) {
				$saldoawalbulanK=$skredit;
				}

			return $saldoawalbulanK;
}

function saldoD($id_saldoD) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$thn_kondisi   	= substr($id_saldoD,0,4);
			$kd_jb			= substr($id_saldoD,11,3);
			$idkec			= substr($id_saldoD,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_transaksi	="transaksi_".$idkec;
			$table_rekening	="rekening_".$idkec;
			$tgl_kondisi   	= substr($id_saldoD,0,10);
			$kd_jb			= substr($id_saldoD,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='$idkec' "));
			$sdebit		=$sd['sdebit'];
			return $sdebit;
}

function saldoK($id_saldoK) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$thn_kondisi   	= substr($id_saldoK,0,4);
			$kd_jb			= substr($id_saldoK,11,3);
			$idkec			= substr($id_saldoK,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_transaksi	="transaksi_".$idkec;
			$table_rekening	="rekening_".$idkec;
			$tgl_kondisi   	= substr($id_saldoK,0,10);
			$kd_jb			= substr($id_saldoK,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as skredit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='$idkec' "));
			$skredit		=$sk['skredit'];
			return $skredit;
}

//BY REKENING ===================================================

function namarek($kd_rek) { //Nama Rekening
			$thn_kondisi   	= substr($kd_rek,0,4);
			$kd_jb			= substr($kd_rek,11,3);
			$idkec			= substr($kd_rek,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$table_rekening	="rekening_".$idkec;
			$rek=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening WHERE kd_rekening='$kd_rek'  "));
			$namarek		=$rek['nama_rekening'];
			return $namarek;
}

function SATDR($id_SATDR) { //Saldo Awal Tahun Debit by kd_rekening
			$thn_kondisi   	= substr($id_SATDR,0,4);
			$kd_jb			= substr($id_SATDR,11,3);
			$idkec			= substr($id_SATDR,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$kd_rek			= substr($id_SATDR,11);
			$thn_kondisi	= substr($id_SATDR,0,4);
			$table_rekening	="rekening_".$idkec;
			$tahunlalu		=$thn_kondisi-1;
			$satd=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='debit'"));
			$satdebit		=$satd['satdebit'];
			return $satdebit;
}

function SATKR($id_SATKR) { //Saldo Awal Tahun KREDIT by kd_rekening
			$thn_kondisi   	= substr($id_SATKR,0,4);
			$kd_jb			= substr($id_SATKR,11,3);
			$idkec			= substr($id_SATKR,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$kd_rek			= substr($id_SATKR,11);
			$thn_kondisi	= substr($id_SATKR,0,4);
			$table_rekening	="rekening_".$idkec;
			$tahunlalu		=$thn_kondisi-1;
			$satk=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='kredit'"));
			$satkredit		=$satk['satkredit'];
			return $satkredit;
}

function SABDR($id_SABDR) { //Total Saldo Awal Bulan Debit by kd_rekening
			$thn_kondisi   	= substr($id_SABDR,0,4);
			$kd_jb			= substr($id_SABDR,11,3);
			$idkec			= substr($id_SABDR,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$idkec' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_SABDR,0,10);
			$kd_rek			= substr($id_SABDR,11);
			$thn_kondisi	= substr($id_SABDR,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$table_rekening	="rekening_".$idkec;
			$table_transaksi="transaksi_".$idkec;
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}

			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='debit'"));
			$sumd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_debit='$kd_rek' AND '$kondisi' "));
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
			$thn_kondisi   	= substr($id_SABKR,0,4);
			$kd_jb			= substr($id_SABKR,11,3);
			$idkec			= substr($id_SABKR,15);
			$tahunlalu		=$thn_kondisi-1;
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$idkec' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			
			$tgl_kondisi   	= substr($id_SABKR,0,10);
			$kd_rek			= substr($id_SABKR,11);
			$thn_kondisi	= substr($id_SABKR,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$table_rekening	="rekening_".$idkec;
			$table_transaksi="transaksi_".$idkec;
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}

			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_rekening='$kd_rek'  AND jenis_mutasi='kredit'"));
			$sumk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sumjumlah FROM $table_transaksi WHERE rekening_kredit='$kd_rek' AND '$kondisi' "));
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
			$tgl_kondisi   	= substr($id_saldoawalD,0,10); //2016-03-11-111.11-24
			$kd_rek			= substr($id_saldoawalD,11,6);
			$kdkab			= substr($id_saldoawalD,18);
			
			$kec=mysql_query("select * from kecamatan WHERE kd_kab='$kdkab' ");
				while($r=mysql_fetch_array($kec)){
			
			$tgl_pakai		=$r['tgl_pakai'];
			
			$bln_kondisi	= substr($id_saldoawalD,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoawalD,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$table_rekening	="rekening_$r[id]";
			$table_transaksi="transaksi_$r[id]";
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
				$saldoawalDkab=$saldoawalDkab+$saldoawalD;
				}
			return $saldoawalDkab;
}

function saldoawalK($id_saldoawalK) { //Total Saldo Awal Tahun+Bulan Debit by kd_rekening
			$tgl_kondisi   	= substr($id_saldoawalK,0,10); //2016-03-11-111.11-24
			$kd_rek			= substr($id_saldoawalK,11,6);
			$kdkab			= substr($id_saldoawalK,18);
			
			$kec=mysql_query("select * from kecamatan WHERE kd_kab='$kdkab' ");
				while($r=mysql_fetch_array($kec)){
			$tgl_pakai		=$r['tgl_pakai'];

			$bln_kondisi	= substr($id_saldoawalK,0,7);
			$bln_pakai		= substr($tgl_pakai,0,7);
			$thn_kondisi	= substr($id_saldoawalK,0,4);
			$thn_pakai		= substr($tgl_pakai,0,4);
			
			$table_rekening	="rekening_$r[id]";
			$table_transaksi="transaksi_$r[id]";
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
				
			$saldoawalKkab=$saldoawalKkab+$saldoawalK;
			}
			return $saldoawalKkab;
}

function saldoBBD($id_saldoBBD) { //Total Debit Buku Besar by rekening_kredit di transaksi 

			$tgl_kondisi   	= substr($id_saldoBBD,0,10); //2016-03-11-111.11-24
			$kd_rek			= substr($id_saldoBBD,11,6);
			$kdkab			= substr($id_saldoBBD,18);
			
			$kec=mysql_query("select * from kecamatan WHERE kd_kab='$kdkab' ");
				while($r=mysql_fetch_array($kec)){
				
			$tgl_pakai		=$r['tgl_pakai'];
			$thn_pakai		= substr($tgl_pakai,0,4);
			$thn_kondisi	= substr($id_saldoBBD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}
			
			$table_transaksi	="transaksi_$r[id]";
			$sbbd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbdebit FROM $table_transaksi WHERE rekening_debit='$kd_rek' AND $kondisi"));
			$saldoBBD		=$sbbd['sbbdebit'];
			$saldoBBDkab=$saldoBBDkab+$saldoBBD;
			}
			return $saldoBBDkab;
}

function saldoBBK($id_saldoBBK) { //Total Kredit Buku Besar by rekening_kredit di transaksi 
			
			$tgl_kondisi   	= substr($id_saldoBBK,0,10); //2016-03-11-111.11-24
			$kd_rek			= substr($id_saldoBBK,11,6);
			$kdkab			= substr($id_saldoBBK,18);
			
			$kec=mysql_query("select * from kecamatan WHERE kd_kab='$kdkab' ");
				while($r=mysql_fetch_array($kec)){
			$tgl_pakai		=$r['tgl_pakai'];
			$thn_pakai		= substr($tgl_pakai,0,4);
			$tgl_kondisi   	= substr($id_saldoBBK,0,10);
			$thn_kondisi	= substr($id_saldoBBK,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			if($thn_kondisi==$thn_pakai) {		//bulan berikutnya di tahun yang sama
				$kondisi		="tgl_transaksi between '$tgl_pakai' AND '$tgl_kondisi' ";
				}else if ($thn_kondisi>$thn_pakai) {
				$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tgl_kondisi' ";
				}
			
			$table_transaksi	="transaksi_$r[id]";
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE rekening_kredit='$kd_rek' AND $kondisi"));
			$saldoBBK		=$sbbk['sbbkredit'];
			
			$saldoBBKkab=$saldoBBKkab+$saldoBBK;
			}
			return $saldoBBKkab;
}

function pendapatan($id_pendapatan) {
			$tgl_kondisi   	= substr($id_pendapatan,0,10); //2016-03-11-111-24
			$idkab			= substr($id_pendapatan,11);
			
			$jb=mysql_query("select * from jenis_buku jb, rekening_1 r WHERE jb.kd_jb=r.kd_jb AND jb.posisi='4' AND jb.lokasi='0' OR jb.kd_jb=r.kd_jb AND jb.posisi='4' AND jb.kd_kab='$idkab' ");
				while($row=mysql_fetch_array($jb)){
			$saldo_p=saldoawalK("$tgl_kondisi-$row[kd_rekening]-$idkab")+saldoBBK("$tgl_kondisi-$row[kd_rekening]-$idkab");
			$pendapatan=$pendapatan+$saldo_p;
			}
		 return $pendapatan;
}

function biaya($id_biaya) {
			$tgl_kondisi   	= substr($id_biaya,0,10); //2016-03-11-111-24
			$idkab			= substr($id_biaya,11);
			
			$jbb=mysql_query("select * from jenis_buku jb, rekening_1 r WHERE jb.kd_jb=r.kd_jb AND jb.posisi='5' AND jb.lokasi='0' OR jb.kd_jb=r.kd_jb AND jb.posisi='5' AND jb.kd_kab='$idkab' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo_b=saldoawalD("$tgl_kondisi-$r[kd_rekening]-$idkab")+saldoBBD("$tgl_kondisi-$r[kd_rekening]-$idkab");
			$biaya=$biaya+$saldo_b;
			}
		 return $biaya;
}

function surplus($id_surplus) {
			$tgl_kondisi   	= substr($id_surplus,0,10); //2016-03-11-111-24
			$idkab			= substr($id_surplus,11);
			
			$pendapatan	=pendapatan("$tgl_kondisi-$idkab");
			$biaya		=biaya("$tgl_kondisi-$idkab");
			$surlus		=$pendapatan-$biaya;
		 return $surlus;
}

function asetproduktif($tgl_kondisi) {
			
			$kas_op		=saldo("$tgl_kondisi-111");
			$kas_spp	=saldo("$tgl_kondisi-112");
			$kas_uep	=saldo("$tgl_kondisi-113");
			$bank_op	=saldo("$tgl_kondisi-121");
			$bank_spp	=saldo("$tgl_kondisi-122");
			$bank_uep	=saldo("$tgl_kondisi-123");
			$pinj_spp	=saldo("$tgl_kondisi-131");
			$pinj_uep	=saldo("$tgl_kondisi-132");
			
			$asetproduktif=$kas_op+$kas_spp+$kas_uep+$bank_op+$bank_spp+$bank_uep+$pinj_spp+$pinj_uep;
		 return $asetproduktif;
}

function asetekonomi($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$asetekonomi=$asetekonomi+$saldo;
			}
		 return $asetekonomi;
}

function modalawal($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='3' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]")*-1;
			$modalawal=$modalawal+$saldo;
			}
		 return $modalawal;
}

?>