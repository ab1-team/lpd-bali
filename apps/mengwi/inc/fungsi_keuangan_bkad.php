<?php
//SALDO BY BUKU
function saldo($id_saldo) { //Saldo Debit Kredit by Kd Buku
			$table_transaksi	="bkad_transaksi";
			$table_rekening		="bkad_rekening";
			
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$kd_jb			= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$tgl_awaltahun	=$thn_kondisi."-01-01";
				
			$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
			
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumd FROM bkad_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumk FROM bkad_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));

			$saldo=$sd['sumd']-$sk['sumk'];
				
			return $saldo;
}


function saldoABKD($id_saldoABKD) { //Saldo Awal Bulan Debit by Kd Buku dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_jb			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="bkad_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="bkad_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM bkad_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}

function saldoABKK($id_saldoABKD) { //Saldo Awal Bulan Kredit by Kd Buku dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_jb			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="bkad_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="bkad_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM bkad_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}

//SALDO BY REKENING
function saldoR($id_saldoR) { //Saldo Debit Kredit by Kd Rekening
			
			$tglkondisi   	= substr($id_saldoR,0,10);
			$kd_rek			= substr($id_saldoR,11);
	
			$saldo=saldoDR("$tglkondisi-$kd_rek")-saldoKR("$tglkondisi-$kd_rek");
				
			return $saldo;
}

function saldoDR($id_saldoDR) { //Saldo Debit by Kd Rekening
			
			$tglkondisi   	= substr($id_saldoDR,0,10);
			$kd_rek			= substr($id_saldoDR,11);
	
			$saldo=saldoATDR("$tglkondisi-$kd_rek")+saldoABDR("$tglkondisi-$kd_rek");
				
			return $saldo;
}

function saldoKR($id_saldoKR) { //Saldo Kredit by Kd Rekening
			
			$tglkondisi   	= substr($id_saldoKR,0,10);
			$kd_rek			= substr($id_saldoKR,11);
	
			$saldo=saldoATKR("$tglkondisi-$kd_rek")+saldoABKR("$tglkondisi-$kd_rek");
				
			return $saldo;
}

function saldoATDR($id_saldoATDR) { //Saldo Awal Tahun Debit by Kd Rekening
			$table_rekening		="bkad_rekening";
			$thn_kondisi   	= substr($id_saldoATDR,0,4);
			$kd_rek			= substr($id_saldoATDR,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek' AND jenis_mutasi='debit' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoATKR($id_saldoATKR) { //Saldo Awal Tahun Debit by Rekening
			$table_rekening		="bkad_rekening";
			$thn_kondisi   	= substr($id_saldoATKR,0,4);
			$kd_rek			= substr($id_saldoATKR,11);
			$tahunlalu		=$thn_kondisi-1;

			$sak=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_rekening='$kd_rek' AND jenis_mutasi='kredit' "));
			$sumkr		=$sak['satkredit'];
			return $sumkr;
}

function saldoABDR($id_saldoABDR) { //Saldo Awal Bulan Debit by Kd Rekening dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABDR,0,10);
			$kd_rek			= substr($id_saldoABDR,11);
			$bln_kondisi	= substr($id_saldoABDR,0,7);
			$thn_kondisi	= substr($id_saldoABDR,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="bkad_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="bkad_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=t.rekening_debit AND r.kd_rekening='$kd_rek' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}

function saldoABKR($id_saldoABKR) { //Saldo Awal Bulan Kredit by Kd Rekening dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKR,0,10);
			$kd_rek			= substr($id_saldoABKR,11);
			$bln_kondisi	= substr($id_saldoABKR,0,7);
			$thn_kondisi	= substr($id_saldoABKR,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="bkad_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="bkad_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=t.rekening_kredit AND r.kd_rekening='$kd_rek' AND t.lokasi='$_SESSION[lokasi]' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}

?>