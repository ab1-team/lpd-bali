<?php
//SALDO BY BUKU
function saldo($id_saldo) { //Saldo Debit Kredit by Kd Buku
			$table_transaksi	="admin_transaksi";
			$table_rekening		="admin_rekening";
			
			$tglkondisi   	= substr($id_saldo,0,10);
			$thn_kondisi   	= substr($id_saldo,0,4);
			$kd_jb			= substr($id_saldo,11);
			$tahunlalu		=$thn_kondisi-1;
			$tgl_awaltahun	=$thn_kondisi."-01-01";
				
			$kondisi		="tgl_transaksi between '$tgl_awaltahun' AND '$tglkondisi' ";
			
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumd FROM admin_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi "));
			$sk=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumk FROM admin_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi "));

			$saldo=(saldoATD("$tglkondisi-$kd_jb")+$sd['sumd'])-(saldoATK("$tglkondisi-$kd_jb")+$sk['sumk']);
				
			return $saldo;
}

function saldoATD($id_saldoATD) { //Saldo Awal Tahun Debit by Kd Buku
			$table_rekening		="admin_rekening";
			$thn_kondisi   	= substr($id_saldoATD,0,4);
			$kd_jb			= substr($id_saldoATD,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='debit' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoATK($id_saldoATK) { //Saldo Awal Tahun Debit by Kd Buku
			$table_rekening		="admin_rekening";
			$thn_kondisi   	= substr($id_saldoATK,0,4);
			$kd_jb			= substr($id_saldoATK,11);
			$tahunlalu		=$thn_kondisi-1;

			$sak=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satkredit FROM $table_rekening WHERE kd_jb='$kd_jb' AND jenis_mutasi='kredit' "));
			$sumk		=$sak['satkredit'];
			return $sumk;
}


function saldoABKD($id_saldoABKD) { //Saldo Awal Bulan Debit by Kd Buku dengan KONDISI
			
			$tgl_kondisi   	= substr($id_saldoABKD,0,10);
			$kd_jb			= substr($id_saldoABKD,11);
			$bln_kondisi	= substr($id_saldoABKD,0,7);
			$thn_kondisi	= substr($id_saldoABKD,0,4);
			$tgl_awaltahun	= $thn_kondisi."-01-01";
			
			$kondisi="tgl_transaksi < '$tgl_kondisi' AND tgl_transaksi >= '$tgl_awaltahun' ";
				
			$table_transaksi	="admin_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="admin_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM admin_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_debit AND r.kd_jb='$kd_jb' AND $kondisi "));
			
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
				
			$table_transaksi	="admin_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="admin_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM admin_buku jb, $table_rekening r, $table_transaksi t WHERE jb.id=r.kd_jb AND r.kd_rekening=t.rekening_kredit AND r.kd_jb='$kd_jb' AND $kondisi "));
			
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
			$table_rekening		="admin_rekening";
			$thn_kondisi   	= substr($id_saldoATDR,0,4);
			$kd_rek			= substr($id_saldoATDR,11);
			$tahunlalu		=$thn_kondisi-1;

			$sad=mysql_fetch_array(mysql_query("SELECT sum(tb$tahunlalu) AS satdebit FROM $table_rekening WHERE kd_rekening='$kd_rek' AND jenis_mutasi='debit' "));
			$sumd		=$sad['satdebit'];
			return $sumd;
}

function saldoATKR($id_saldoATKR) { //Saldo Awal Tahun Debit by Rekening
			$table_rekening		="admin_rekening";
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
				
			$table_transaksi	="admin_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="admin_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=t.rekening_debit AND r.kd_rekening='$kd_rek' AND $kondisi "));
			
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
				
			$table_transaksi	="admin_transaksi"; //Mencari saldo Debit pada transaksi pada bulan kondisi sebelumnya
			$table_rekening		="admin_rekening";
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sdebit FROM $table_rekening r, $table_transaksi t WHERE r.kd_rekening=t.rekening_kredit AND r.kd_rekening='$kd_rek' AND $kondisi "));
			
			$saldoawalbulanD=$sd['sdebit'];

			return $saldoawalbulanD;
}



//INVOICE

function sumBayar($idv) { //Jumlah Bayar

			$table_transaksi	="admin_transaksi";
			$row=mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah FROM $table_transaksi WHERE idv='$idv' ")); //Deklarasi Jumlah Pembayaran Sebelumnya
			$sumBayar		=$row['sumjumlah'];

			return $sumBayar;
}


function sumTagihan($idv) { //Jumlah Tagihan

			$tag=mysql_fetch_array(mysql_query("select * FROM admin_invoice WHERE idv='$idv' ")); //Deklarasi Jumlah Tagihan
			$tagihan	=$tag['jumlah'];

			return $tagihan;
}

function sumSaldo($idv) { //Jumlah Saldo

			$sumBayar	=sumBayar($idv);
			$tagihan	=sumTagihan($idv);
			
			$saldo=$tagihan-$sumBayar;

			return $saldo;
}

function AllSaldo() { //Saldo Tagihan UNPAID (Semua)
			$jb=mysql_query("select * from admin_invoice WHERE status='UNPAID' ");
				while($row=mysql_fetch_array($jb)){
			$sumSaldo=sumSaldo("$row[idv]");
			$AllSaldo=$AllSaldo+$sumSaldo;
			}
		 return $AllSaldo;
}


//Pendapatan
function pendapatan($tgl_kondisi) {
			$jb=mysql_query("select * from admin_buku WHERE posisi='4' ");
				while($row=mysql_fetch_array($jb)){
			$saldo_p=saldo("$tgl_kondisi-$row[id]")*-1;
			$pendapatan=$pendapatan+$saldo_p;
			}
		 return $pendapatan;
}

function biaya($tgl_kondisi) {
			$jbb=mysql_query("select * from admin_buku WHERE posisi='5' ");
				while($r=mysql_fetch_array($jbb)){
			$saldo_b=saldo("$tgl_kondisi-$r[id]");
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

?>