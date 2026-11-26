<?php session_start();

function saldo($id_saldo) { //Saldo Debit Kredit by Kd Buku
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$id_akun	= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$tgl_awaltahun	=$thn_kondisi."-01-01";
				
			$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
			
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumd FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=substring(t.rekening_debit,1,7) AND r.id_akun='$id_akun' AND $kondisi "));
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumk FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=substring(t.rekening_kredit,1,7) AND r.id_akun='$id_akun' AND $kondisi "));
			
			$ja=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun WHERE id='$id_akun' "));
			$jenis_saldo		=$ja['jenis_saldo'];
			
			if($jenis_saldo=="debit") {
				$saldo=(saldoAT("$tglkondisi-$id_akun")+$sd['sumd'])-$sk['sumk'];
			}else if($jenis_saldo=="kredit") {
				$saldo=(saldoAT("$tglkondisi-$id_akun")+$sk['sumk'])-$sd['sumd'];
			}
			
			
				
			return $saldo;
}

function saldoAT($id_saldoATD) { //Saldo Awal Tahun by Kd Rekening
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$thn_kondisi   	= substr($id_saldoATD,0,4);
			$kd_jb			= substr($id_saldoATD,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE id_akun='$kd_jb' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoABD($kd_jb) { //Saldo Awal Debit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$sad=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sadebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['sadebit'];
			return $sumd;
}

function saldoABKD($id_saldoABKD) { //Saldo Awal Bulan Debit by Kd Buku dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_rekening	= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_transaksi WHERE substring(rekening_debit,1,7)='$kd_rekening' AND $kondisi "));
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_transaksi WHERE substring(rekening_kredit,1,7)='$kd_rekening' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}



function saldoABK($kd_jb) { //Saldo Awal Bulan Kredit by Kd Buku
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$sak=mysql_fetch_array(mysql_query("SELECT sum(awal) AS sakredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['sakredit'];
			return $sumk;
}


function saldoABKK($id_saldoABKD) { //Saldo Awal Bulan Kredit by Kd Buku dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_rekening			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_transaksi WHERE substring(rekening_kredit,1,7)='$kd_rekening' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}

function saldoD($id_saldoD) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tgl_kondisi   	= substr($id_saldoD,0,10);
			$kd_jb			= substr($id_saldoD,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=substring(t.rekening_debit,1,7) AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=substring(t.rekening_debit,1,7) AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
			$sdebit		=$sd['sdebit'];
			return $sdebit;
}

function saldoK($id_saldoK) { //Saldo Debit by Kd Buku Pada saat Kondisi
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$table_rekening	="rekening_".$_SESSION['lokasi'];
			$tgl_kondisi   	= substr($id_saldoK,0,10);
			$kd_jb			= substr($id_saldoK,11);
			$kondisi		="tgl_transaksi = '$tgl_kondisi' ";
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as skredit FROM jenis_buku jb, $table_rekening r, $table_transaksi t WHERE jb.kd_jb=r.kd_jb AND r.kd_rekening=t.substring(rekening_kredit,1,7) AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi='0' AND jb.kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR jb.kd_jb=r.kd_jb AND r.kd_rekening=t.substring(rekening_kredit,1,7) AND r.kd_jb='$kd_jb' AND $kondisi AND jb.lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' "));
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

function saldoR($id_saldoR) { //Saldo by Kd Rekening
			
			$tglkondisi   	= substr($id_saldoR,0,10);
			$kd_rek			= substr($id_saldoR,11);
			
			$rek=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND r.kd_rekening='$kd_rek' "));
			$jenis_saldo		=$rek['jenis_saldo'];
			
			if($jenis_saldo=="debit") {
				$saldo=saldoATR("$tglkondisi-$kd_rek")+saldoDR("$tglkondisi-$kd_rek")-saldoKR("$tglkondisi-$kd_rek");
			}else if($jenis_saldo=="kredit") {
				$saldo=saldoATR("$tglkondisi-$kd_rek")+saldoKR("$tglkondisi-$kd_rek")-saldoDR("$tglkondisi-$kd_rek");
			}
				
			return $saldo;
}

function saldoATR($id_saldoATDR) { //Saldo Awal Tahun by Kd Rekening
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$thn_kondisi   	= substr($id_saldoATDR,0,4);
			$kd_rek			= substr($id_saldoATDR,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoDR($id_saldoABDR) { //Saldo Debit by Kd Rekening dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABDR,0,10);
			$kd_rek			= substr($id_saldoABDR,11);
			$bln_kondisi	= substr($id_saldoABDR,0,7);
			$thn_kondisi	= substr($id_saldoABDR,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi >= '$tgl_awaltahun' AND tgl_transaksi <= '$tgl_kondisi' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sdr=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_transaksi WHERE substring(rekening_debit,1,7)='$kd_rek' AND $kondisi "));
			
			$saldoDebitRekening=$sdr['sdebit'];

			return $saldoDebitRekening;
}

function saldoKR($id_saldoABKR) { //Saldo Kredit by Kd Rekening dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKR,0,10);
			$kd_rek			= substr($id_saldoABKR,11);
			$bln_kondisi	= substr($id_saldoABKR,0,7);
			$thn_kondisi	= substr($id_saldoABKR,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi >= '$tgl_awaltahun' AND tgl_transaksi <= '$tgl_kondisi' ";
				
			$table_transaksi	="transaksi_".$_SESSION['lokasi']; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="rekening_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as skredit FROM $table_transaksi WHERE substring(rekening_kredit,1,7)='$kd_rek' AND $kondisi "));
			
			$saldoawalbulanD=$sd['skredit'];

			return $saldoawalbulanD;
}

//E-BUDGETING
function saldoRB($id_saldoRB) { //Total Saldo Buku Besar by rekening_kredit by Bulan di transaksi 
			$bln_kondisi   	= substr($id_saldoRB,0,7);
			$kd_rekening   	= substr($id_saldoRB,8); //2017-01-101
			
			$awal			="$bln_kondisi-01";
			$akhir			="$bln_kondisi-31";
			
			$tp=mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			$bln_pakai   	= substr($tgl_pakai,0,7);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE substring(rekening_kredit,1,7)='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRB		=$sbbk['sbbkredit'];
			return $saldoRB;
}

function saldoRT($id_saldoRT) { //Total Saldo Buku Besar by rekening_kredit by Tahun di transaksi 
			$tahun_kondisi   	= substr($id_saldoRT,0,4);
			$kd_rekening   	= substr($id_saldoRT,5); //2017-01-101
			
			$awal			="$tahun_kondisi-01-01";
			$akhir			="$tahun_kondisi-12-31";
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE substring(rekening_kredit,1,7)='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRT		=$sbbk['sbbkredit'];
			return $saldoRT;
}

function saldoRBB($id_saldoRBB) { //Total Saldo Buku Besar by rekening_debit by Bulan di transaksi 
			$bln_kondisi   	= substr($id_saldoRBB,0,7);
			$kd_rekening   	= substr($id_saldoRBB,8); //2017-01-101
			
			$awal			="$bln_kondisi-01";
			$akhir			="$bln_kondisi-31";
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbkredit FROM $table_transaksi WHERE substring(rekening_debit,1,7)='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRBB		=$sbbk['sbbkredit'];
			return $saldoRBB;
}

function saldoRBT($id_saldoRBT) { //Total Saldo Buku Besar by rekening_kredit by Tahun di transaksi 
			$tahun_kondisi   	= substr($id_saldoRBT,0,4);
			$kd_rekening   	= substr($id_saldoRBT,5); //2017-01-101
			
			$awal			="$tahun_kondisi-01-01";
			$akhir			="$tahun_kondisi-12-31";
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sbbk=mysql_fetch_array(mysql_query("SELECT sum(jumlah) AS sbbdebit FROM $table_transaksi WHERE substring(rekening_debit,1,7)='$kd_rekening' AND tgl_transaksi between '$awal' AND '$akhir' "));
			$saldoRBT		=$sbbk['sbbdebit'];
			return $saldoRBT;
}




//Pendapatan
function pendapatan($tgl_kondisi) {
			$jb=mysql_query("select * from jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='4' ");
				while($row=mysql_fetch_array($jb)){
			$saldo_p=saldoR("$tgl_kondisi-$row[kd_rekening]");
			$pendapatan=$pendapatan+$saldo_p;
			}
		 return $pendapatan;
}

function biaya($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='5' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo_b=saldoR("$tgl_kondisi-$r[kd_rekening]");
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
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR posisi='1' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$asetekonomi=$asetekonomi+$saldo;
			}
		 return $asetekonomi;
}

function modalawal($tgl_kondisi) {
	$row=mysql_fetch_array(mysql_query("SELECT * FROM desa where id='$_SESSION[lokasi]' "));
			
				$modalawal=(saldo("$tgl_kondisi-311")*-1)+(saldo("$tgl_kondisi-312")*-1)+(saldo("$tgl_kondisi-313")*-1);

		 return $modalawal;
}

function asetproduktif($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_buku WHERE posisi='1' AND ap='1' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR posisi='1' AND ap='1' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldo("$tgl_kondisi-$r[kd_jb]");
			$asetproduktif=$asetproduktif+$saldo;
			}
		 return $asetproduktif;
}

function aktiva($tgl_kondisi) {
			$jbb=mysql_query("select * from jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='1' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo=saldoR("$tgl_kondisi-$r[kd_rekening]");
			$aktiva=$aktiva+$saldo;
			}
		 return $aktiva;
}

//Passiva
function passiva($tgl_kondisi) {
			$jb=mysql_query("select * from jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND a.posisi='2' OR a.id=r.id_akun AND a.posisi='3' ");
				while($row=mysql_fetch_array($jb)){
			$saldo_p=saldoR("$tgl_kondisi-$row[kd_rekening]");
			$passiva=$passiva+$saldo_p;
			}
		 return $passiva;
}

?>