<?php

function bulatkan($angka) {
		 $row=mysql_fetch_array(mysql_query("select *, length(pembulatan) as panjang from kecamatan WHERE id='$_SESSION[lokasi]' "));
		 
		 $pembulatan	=$row['pembulatan']; //Pembulatannya ex: -500
		 $length		=$row['panjang']-1; //Jumlah karakter pada kolom pembulatan
		 $uang			=floor($angka);
		 
		 $bulat 		= substr($pembulatan, 1); //Angka pembulatnya : 50
		 
		 if($length<=2) {
			$pecahan 		= substr($uang, -2); //Pecahan yang akan dibulatkan ex: 33
			$pengali		= $bulat*2;
		 } else {
			$pecahan 		= substr($uang, -3);
			$pengali		= 1000;
		 }
		
		
		 if ($pembulatan>0) { //Pembulatan Keatas
			 if($pecahan<$bulat and $pecahan>0) { //.333
				$pembulatan = $uang + ($bulat-$pecahan); 
			 }else if($pecahan>$bulat ) { 
				$pembulatan = $uang + $pengali-$pecahan; //.666
			 }else if($pecahan==0 or $pecahan==$bulat){
				$pembulatan = $uang;
			 }
			 
		 } else  if ($pembulatan<0) { //Pembulatan Kebawah
			 if($pecahan<$bulat and $pecahan>0) { //.333
				$pembulatan = $uang - $pecahan;
			 }else if($pecahan>$bulat ) {		//.666
				$pembulatan = $uang + (($bulat*2)-$pecahan);
			 }else if($pecahan==0 or $pecahan==$bulat){
				$pembulatan = $uang;
			 }
			 
		 } else { 
			$pembulatan = $uang; }
 

		 return $pembulatan;
}


function kode($kd_rek) { //mencari jenis simpanan (umum atau berjangka)
    $code     = substr($kd_rek,4,3);
			return $code;
}


function jenisrek($js) { //mencari jenis simpanan (umum atau berjangka)
            $sm         = substr($js,0,1); // 1-1 -> jumlah '=' - jenis simp
            $rek        = substr($js,2);
    if($sm==1){ 
            if($rek==1){
                $ifrek="(rekening_debit='119.01' OR  
                		 rekening_debit='221.03' OR 
                		 rekening_debit='221.04' OR 
                		 rekening_debit='221.05' OR
                		 rekening_debit='515.01')";
            }elseif($rek==2){
                $ifrek="(rekening_debit='119.02' OR  
                		 rekening_debit='222.03' OR 
                		 rekening_debit='222.04' OR  
                		 rekening_debit='222.05' OR
                		 rekening_debit='515.02')";
            }elseif($rek==3){
                $ifrek="(rekening_debit='119.05' OR  
                		 rekening_debit='223.03' OR 
                		 rekening_debit='223.04' OR  
                		 rekening_debit='223.05' OR
                		 rekening_debit='515.03')";
            }else{
                $ifrek="(rekening_debit='119.01' OR  
                		 rekening_debit='221.03' OR 
                		 rekening_debit='221.04' OR  
                		 rekening_debit='221.05' OR
                		 rekening_debit='515.01')";
            }  
    }else{
            if($rek==1){
                $ifrek="(rekening_debit='119.01' OR  
                		 rekening_debit='221.03' OR 
                		 rekening_debit='221.04' OR 
                		 rekening_debit='221.05' OR
                		 rekening_debit='515.01')";
            }elseif($rek==2){
                $ifrek="(rekening_debit='119.02' OR  
                		 rekening_debit='222.03' OR 
                		 rekening_debit='222.04' OR  
                		 rekening_debit='222.05' OR
                		 rekening_debit='515.02')";
            }elseif($rek==3){
                $ifrek="(rekening_debit='119.05' OR  
                		 rekening_debit='223.03' OR 
                		 rekening_debit='223.04' OR  
                		 rekening_debit='223.05' OR
                		 rekening_debit='515.03')";
            }else{
                $ifrek="(rekening_debit='119.01' OR  
                		 rekening_debit='221.03' OR 
                		 rekening_debit='221.04' OR 
                		 rekening_debit='221.05' OR
                		 rekening_debit='515.01')";
            }}
			return $ifrek;
}


function sumnabung($id) {	//Total Nabung 
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='221.01' OR rekening_kredit='221.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='222.01' OR rekening_kredit='222.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==3){ //Simpanan Program
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='223.01' OR rekening_kredit='223.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}

			$sumnabung	=$sp['sumnabung'];
			return $sumnabung;
}

function sumambil($id) {	//Total Ambil
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='221.03' OR rekening_debit='221.04' OR rekening_debit='221.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='222.03' OR rekening_debit='222.04' OR rekening_debit='222.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==3){ //Simpanan Program
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='223.03' OR rekening_debit='223.04' OR rekening_debit='223.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}

			$sumambil	=$sp['sumambil'];
			return $sumambil;
}

function sumnabungt($id) {	//Total Nabung 
    $ide	= explode("#", $id);
			$tgl_kondisi   		= $ide[0];
			$ids				= $ide[1];
			$idt				= $ide[2];
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='221.01' OR rekening_kredit='221.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='222.01' OR rekening_kredit='222.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
				
			}else if($sa['jenis_simpanan']==3){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='223.01' OR rekening_kredit='223.02' ) AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
				
			}

			$sumnabung	=$sp['sumnabung'];
			return $sumnabung;
}

function sumambilt($id) {	//Total Ambil
            $ide	= explode("#", $id);
			$tgl_kondisi   		= $ide[0];
			$ids				= $ide[1];
			$idt				= $ide[2];
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='221.03' OR rekening_debit='221.04' OR rekening_debit='221.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='222.03' OR rekening_debit='222.04' OR rekening_debit='222.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
			
			}else if($sa['jenis_simpanan']==3){ //Simpanan Program
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='223.03' OR rekening_debit='223.04' OR rekening_debit='223.05') AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids' AND idt<='$idt'"));
				
			}

			$sumambil	=$sp['sumambil'];
			return $sumambil;
}

function saldosimpanan($id) {	//Total Saldo Simpanan
			
			$sumnabung		=sumnabung($id);
			$sumambil		=sumambil($id);
			
			$saldosimpanan	=$sumnabung-$sumambil;
			return $saldosimpanan;
}

function saldosimpanant($id) {	//Total Saldo Simpanan
			
			$sumnabung		=sumnabungt($id);
			$sumambil		=sumambilt($id);
			
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
			
			
			$from	= $bulan_kondisi."-01";
			$to		= "$tahun-$bulan-31";
			
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
			
			
			$from	= $bulan_kondisi."-01";
			$to		= "$tahun-$bulan-31";
			
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
			$r=mysql_fetch_array(mysql_query("select sum(jumlah) as sumbunga from transaksi_$_SESSION[lokasi] WHERE rekening_debit='515.02' AND rekening_kredit='222.02' AND id_simp_i='$id_simp_i' AND tgl_transaksi<='$tgl_kondisi'  "));
			
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


//saldo simpanan rata2 dipercepat tapi rawan salah, jadi harus hati2 =============================================

function sumnabungb($id) {	//Total Nabung 
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='221.01' OR rekening_kredit='221.02' ) AND tgl_transaksi>'$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_deposito' "));
			
			}else if($sa['jenis_simpanan']==3){ //Simpanan Program
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumnabung FROM $table_transaksi WHERE
				(rekening_kredit='223.01' OR rekening_kredit='223.02') AND tgl_transaksi>'$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}

			$sumnabung	=$sp['sumnabung'];
			return $sumnabung;
}

function sumambilb($id) {	//Total Ambil
			$tgl_kondisi   		= substr($id,0,10);
			$ids				= substr($id,11);
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			
			
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			if($sa['jenis_simpanan']==1){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='221.03' OR rekening_debit='221.04' OR rekening_kredit='221.05') AND tgl_transaksi>='$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}else if($sa['jenis_simpanan']==2){ //Simpanan Deposito
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_deposito' "));
			
			}else if($sa['jenis_simpanan']==3){ //Simpanan Umum
			
				$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumambil FROM $table_transaksi WHERE
				(rekening_debit='223.03' OR rekening_debit='223.04' OR rekening_kredit='223.05' ) AND tgl_transaksi>='$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				
			}

			$sumambil	=$sp['sumambil'];
			return $sumambil;
}

function saldosimpananb($id) {	//Total Saldo Simpanan
			$tgl_kondisi   		= substr($id,0,10);
			$tgl_akhir_lalu 	= date('Y-m-t', strtotime('-1 month', strtotime($tgl_kondisi)));
			$ids				= substr($id,11);
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			$sumnabungb		=sumnabungb($id);
			$sumambilb		=sumambilb($id);
			$saldosimpananb	=$sumnabungb-$sumambilb+$sa['jumlah'];
		/*	if($sa['tgl_up']<$tgl_akhir_lalu){
				mysql_query("UPDATE `simpanan_anggota_$_SESSION[kd_kab]  SET `jumlah` = '$saldosimpananb', `tgl_up` = '$tgl_akhir_lalu',  where id='$ids' "));	
			} */
			return $saldosimpananb;
}

function saldoratarata($id) {	//Total Saldo Simpanan
			$table_transaksi	="transaksi_$_SESSION[lokasi]";
			$tgl_kondisi   		= substr($id,0,10);
			$tgl_akhir_lalu 	= date('Y-m-t', strtotime('-1 month', strtotime($tgl_kondisi)));
			$jtgl_lalu   		= substr($tgl_akhir_lalu,8,10);
			$ids				= substr($id,11);
			$sa                 = mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			$tgl_buka           = $sa['tgl_buka'];
			
			
			$amasuk             = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as n FROM $table_transaksi WHERE
				(rekening_kredit='221.01' OR rekening_kredit='221.02' OR
				 rekening_kredit='223.01' OR rekening_kredit='223.02') 
				 AND id_simp_i='$ids'"));
			$akeluar            = mysql_fetch_array(mysql_query("SELECT SUM(jumlah) as n FROM $table_transaksi WHERE
				(rekening_debit='221.03' OR rekening_debit='221.04' OR rekening_debit='221.05' OR
				 rekening_debit='223.03' OR rekening_debit='223.04' OR rekening_debit='223.05') 
				 AND id_simp_i='$ids'"));
				 
				 
				 
			$jmas               = $amasuk['n'];
			$jkel               = $akeluar['n'];
			$tgl_now            = date('Y-m-d');
			
            
            $tgl   = substr($tgl_now,8,2);			
            if($tgl>=26){
                $tgl_awal = date('Y-m-26', strtotime('-1 month', strtotime($tgl_now))); //
                $tanggalkeadaan = date('Y-m-t', strtotime($tgl_awal)); //
                $tanggal_keadaan = substr($tgl_akhir_lalu,8,2);
                $tgl_akhir = date('Y-m-25');
                $bulan_kondisi = date('Y-m-01'); //
            }else{
// 			var_dump($jmas);
                $tanggal_keadaan = substr($tgl_akhir_lalu,8,2);
                $tgl_awal = date('Y-m-26', strtotime('-2 month', strtotime($tgl_now))); //
                $tgl_akhir = date('Y-m-25', strtotime('-1 month', strtotime($tgl_now))); //
                $bulan_kondisi = date('Y-m-01', strtotime('-1 month', strtotime($tgl_now))); //
            }
                    $pemasukan=0;
					$pengeluaran=0;
			$masuk              = (mysql_query("SELECT * FROM $table_transaksi WHERE
				(rekening_kredit='221.01' OR rekening_kredit='221.02' OR
				 rekening_kredit='223.01' OR rekening_kredit='223.02') 
				AND tgl_transaksi>='$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				while($setor=mysql_fetch_array($masuk)){
					$tgltrans  = substr($setor['tgl_transaksi'],8,10);
					$angka = $tanggal_keadaan-25+number_format($tgltrans);
					$penambahan = ($tanggal_keadaan-$angka+1)*$setor['jumlah'];
					$pemasukan  = $pemasukan+$penambahan; 
				            }
				            
			$keluar             = (mysql_query("SELECT * FROM $table_transaksi WHERE
				(rekening_debit='221.03' OR rekening_debit='221.04' OR rekening_debit='221.05' OR
				 rekening_debit='223.03' OR rekening_debit='223.04' OR rekening_debit='223.05') 
				AND tgl_transaksi>='$sa[tgl_up]' AND tgl_transaksi<='$tgl_kondisi' AND id_simp_i='$ids'"));
				while($tarik=mysql_fetch_array($keluar)){
					$tgltrans  = substr($tarik['tgl_transaksi'],8,10);
					$angka = $tanggal_keadaan-25+number_format($tgltrans);
					$pengurangan = ($tanggal_keadaan-$angka+1)*$tarik['jumlah'];
					$pengeluaran  = $pengeluaran+$pengurangan; 
				            }
				$jlalu = saldosimpanan("$tgl_akhir_lalu-$ids");            
				$tglbk = substr($tgl_buka,8,10);
				$jtgl   = 25-$tglbk;
				$rata2          = (($pemasukan-$pengeluaran)/$tanggal_keadaan)+$jlalu;
				// var_dump("(($pemasukan-$pengeluaran)/$tanggal_keadaan)+$jlalu");
			return $rata2;
}

function updatedata($id) {	//Total Saldo Simpanan
			$tgl_kondisi   		= substr($id,0,10);
			$tgl_akhir_lalu 	= date('Y-m-t', strtotime('-1 month', strtotime($tgl_kondisi)));
			$ids				= substr($id,11);
			$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
			$sumnabungb		=sumnabungb($id);
			$sumambilb		=sumambilb($id);
			$saldosimpananb	=$sumnabungb-$sumambilb+$sa['jumlah'];
			if($sa['tgl_up']<$tgl_akhir_lalu){
				mysql_query("UPDATE `simpanan_anggota_$_SESSION[kd_kab]  SET `jumlah` = '$saldosimpananb', `tgl_up` = '$tgl_akhir_lalu',  where id='$ids' ");	
			} 
			return $saldosimpananb;
}


?>