<?php

function sumnabung($id) {	//Total Nabung 
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_deposito' "));
			}

			//Nabung dan Bunga SUmum dan SDeposito
			$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				rekening_kredit='$rek[kd_rekening]_$ids' AND tgl_transaksi<='$tgl_kondisi' "));
				
			$sumnabung	=$sp['sumnabung'];
			return $sumnabung;
}

function sumambil($id) {	//Total Ambil
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_deposito' "));
			}

			$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE 
				rekening_debit='$rek[kd_rekening]_$ids' AND tgl_transaksi<='$tgl_kondisi' "));
				
			$sumambil	=$sp['sumambil'];
			return $sumambil;
}

function saldosimpanan($id) {	//Total Saldo Simpanan
			
			$sumnabung		=sumnabung($id);
			$sumambil		=sumambil($id);
			
			$saldosimpanan	=$sumnabung-$sumambil;
			return $saldosimpanan;
}

function SaldoSimpananName($id) {	//Total Saldo Simpanan by Name /Nia
			$tgl_kondisi   	= substr($id,0,10);
			$nia			= substr($id,11);
			
			$table_simpanan	="simpanan_anggota_$_SESSION[kd_kab]";
			
			$data=mysql_query("SELECT * FROM $table_simpanan WHERE nia='$nia' ");
				while($r=mysql_fetch_array($data)){
					
					$SaldoSimpananName	=saldosimpanan("$tgl_kondisi-$r[id]");
											
					$sumsaldoName=$sumsaldoName+$SaldoSimpananName;
				}

			return $sumsaldoName;
}

function saldoterendah($id) {	//Total Ambil
			$idst		= explode("-",$id);
			$tahun   	= $idst[0];
			$bulan   	= $idst[1];
			$ids   		= $idst[2];
			

			$bulan_kondisi = "$tahun-$bulan";
			
			if ($bulan=="02") {
				$from	= date('Y-m', strtotime($bulan_kondisi. '- 1 month'))."-29";
				$to	= date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-t', strtotime($bulan_kondisi)))));
			}else if ($bulan=="03") {
				$from	= date('Y-m-t', strtotime('-1 days', strtotime(date('Y-m-t', strtotime("$tahun-02")))));
				$to		= "$tahun-$bulan-29";
			}else{
			$from	= date('Y-m', strtotime($bulan_kondisi. '- 1 month'))."-29";
			$to		= "$tahun-$bulan-29";
			}
			
				$json = array();

						while (strtotime($from)<strtotime($to)){
						$from = mktime(0,0,0,date("m",strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
						$from=date("Y-m-d", $from);
						
						$json[]= saldosimpanan("$from-$ids");

						}
						
				$saldoterendah= min($json);
			
			return $saldoterendah;
}


function bungasimpananumum($id) {
$idst		= explode("-",$id);
			$thn   		= $idst[0];
			$bln   		= $idst[1];
			$ids   		= $idst[2];
			
			$bulan_kondisi = "$thn-$bln";
			
			if ($bln=="02") {
				$tgl_awal	= date('Y-m', strtotime($bulan_kondisi. '- 1 month'))."-30";
				$tgl_akhir	= date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-t', strtotime($bulan_kondisi)))));
			}else if ($bln=="03") {
				$tgl_awal	= date('Y-m-t', strtotime('-1 days', strtotime(date('Y-m-t', strtotime("$tahun-02")))));
				$tgl_akhir	= "$thn-$bln-29";
			}else{
			$tgl_awal	= date('Y-m', strtotime($bulan_kondisi. '- 1 month'))."-30";
			$tgl_akhir	= "$thn-$bln-29";
			}

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id='$_SESSION[lokasi]' "));
$r=mysql_fetch_array(mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[kd_kab] WHERE id='$ids' "));
	
	$tgl_buka	=$r['tgl_buka'];
	$saldoterendah		=saldoterendah($id);
	
	if($tgl_buka<=$tgl_awal AND $saldoterendah>="25000") { //Akan mendapat bunga jika nabungnya sudah lebih dari 1 periode dan Saldo Terendahnya diatas 25 ribu
		
		$bungasimpananumum	=floor($saldoterendah*$row['def_jasa_tabungan']/100);
	}else{
		$bungasimpananumum=0;
	}
	
		return $bungasimpananumum;
}


//Simpanan Deposito

function bulankeSD($id_bulanke){ //Bulan ke untuk Simpanan Deposito
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_simp_i		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] WHERE id='$id_simp_i' "));
			
			
			$tgl_buka	=$dp['tgl_buka'];
			$tgl_akhir = date('t', strtotime($tgl_kondisi));
			
			$tgl1   	= substr($tgl_buka,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2020-07-12=2021-01-06=3
			$bulan1   	= substr($tgl_buka,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_buka,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			
			if($tgl1<=$tgl2 OR $tgl2==$tgl_akhir AND $tgl1>$tgl2) {$bulanke=$selisih_bln;}else{$bulanke=$selisih_bln-1;}
			
			
			return $bulanke;
	}
	
function targetbungaSD($id_targetbungaSD){
			$tgl_kondisi   	= substr($id_targetbungaSD,0,10);
			$id_simp_i		= substr($id_targetbungaSD,11);
			$r=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] WHERE id='$id_simp_i' "));
			
			$bulanke		=bulankeSD($id_targetbungaSD);
			$saldosimpanan	=saldosimpanan($id_targetbungaSD);
			
			$targetbungaSD	=$saldosimpanan*$bulanke*$r['pros_jasa']/100;
			
			return $targetbungaSD;
	}
	
function bungapaidSD($id_bungapaidSD){
			$tgl_kondisi   	= substr($id_bungapaidSD,0,10);
			$id_simp_i		= substr($id_bungapaidSD,11);
			$r=mysql_fetch_array(mysql_query("select sum(jumlah) as sumbunga from transaksi_$_SESSION[lokasi] WHERE rekening_debit='5-80002' AND rekening_kredit='2-40003_$id_simp_i' AND tgl_transaksi<='$tgl_kondisi' "));
			
			$bungapaidSD		=$r['sumbunga'];
			
			return $bungapaidSD;
	}
	
function bungaUnpaidSD($id_bungaUnpaidSD){
			$tgl_kondisi   	= substr($id_bungaUnpaidSD,0,10);
			$id_simp_i		= substr($id_bungaUnpaidSD,11);
			
			$targetbungaSD	=targetbungaSD("$tgl_kondisi-$id_simp_i");
			$bungapaidSD	=bungapaidSD("$tgl_kondisi-$id_simp_i");
			
			$bungaUnpaidSD	=$targetbungaSD-$bungapaidSD;
			
			return $bungaUnpaidSD;
	}
	

function SumBungaUnpaidSD($tgl_kondisi) {	//Total Bunga Deposito Yang belum  terbayar sampai dengan hari ini

			$table_simpanan	="simpanan_anggota_$_SESSION[kd_kab]";
							
			$data=mysql_query("SELECT * FROM $table_simpanan WHERE jenis_simpanan='2' ");
				while($r=mysql_fetch_array($data)){
					
					$bungaUnpaidSD	=bungaUnpaidSD("$tgl_kondisi-$r[id]");
					
					$SumbungaUnpaidSD	=$SumbungaUnpaidSD+$bungaUnpaidSD;
				}
			
			return $SumbungaUnpaidSD;
}


?>