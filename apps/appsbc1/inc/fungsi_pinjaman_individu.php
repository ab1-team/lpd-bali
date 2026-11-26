<?php
function bulatkan($angka) {
		 $row=mysql_fetch_array(mysql_query("select *, length(pembulatan) as panjang from desa WHERE id='$_SESSION[lokasi]' "));
		 
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

function angsuranke($id_angsuranke){
			$tgl_kondisi   	= substr($id_angsuranke,0,10);
			$id_pinj_i		= substr($id_angsuranke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));
			
			$tgl_cair	=$dp['tgl_cair'];
			$jangka		=$dp['jangka'];
			$sistem		=$dp['sistem'];
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22	//Tanggal Cair
			$tgl2   	= substr($id_angsuranke,8,2); 	 //0123456789-11   16 19  22	//Tanggal Kondisi
			$tgl3   	= date("d"); //2015-07-06=2015-08-11=3  	//Tanggal Kondisi
			if($tgl2=='31') { $tglA=$tgl2; }else{ $tglA=$tgl3;}

			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_angsuranke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_angsuranke,0,4);
			
			$selisihbln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);									//Selisih bulan dari bln cair sampai bln kondisi
			if ($tgl2 < $tgl1) { $selisih_bln=$selisihbln-1; } else { $selisih_bln=$selisihbln; }	//Selisih bulan dari tgl cair sampai tglkondisi

				if($selisih_bln>$jangka) { $selisih_bulan=$jangka; }else{ $selisih_bulan=$selisih_bln;	}	//Kondisi jika kadaluarsa
				
				$selsisih_sistem	=floor(@($selisih_bulan/$sistem));										//pada tgl kondisi, sudah wajib bayar ke berapa?
			
			if($sistem=='1') { $angsuranke=$selisih_bulan; }else{ $angsuranke=$selsisih_sistem;}

			return $angsuranke;
	}

function alokasi($id_pinj_i) {	//ALOKASI PINJAMAN
			$ap=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' "));
			$alokasi	=$ap['alokasi'];
		 return $alokasi;
}

function alokasi_jasa($id_pinj) {	//ALOKASI JASA
			$ap=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			$alokasi	=$ap['alokasi'];
			$jangka		=$ap['jangka'];
			$pros_jasa	=$ap['pros_jasa']/100;
			$alokasi_jasa=@(ceil($alokasi*$pros_jasa*$jangka));
		 return $alokasi_jasa;
}
	
function wajibpokok($id_wajibpokok) {	//KEWAJIBAN POKOK DIBULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_wajibpokok,0,10);
			$id_pinj_i		= substr($id_wajibpokok,11);
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));
			$tgl_cair	=$wp['tgl_cair'];
			$alokasi	=$wp['alokasi'];
			$pros_jasa	=$wp['pros_jasa'];
			$jangka		=$wp['jangka'];
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			$angs_pokok	=bulatkan(@($alokasi/$tempo));
			$ke			=angsuranke("$tgl_kondisi-$id_pinj_i");
			$sumpokok	=sumpokok("$tgl_kondisi-$id_pinj_i");
			if($ke<$jangka) {
			$wajibpokok	=$angs_pokok*(@($ke/$ke));
			}elseif($ke==$jangka-1){
			$wajibpokok	=$alokasi-$sumpokok;
			}else{
			$wajibpokok	=$alokasi-$sumpokok;
			}
			
		 return $wajibpokok;
}

function wajibpokokaja($id_pinj_i) {	//KEWAJIBAN POKOK anggota
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));
			$alokasi	=$wp['alokasi'];
			$jangka		=$wp['jangka'];
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			$wajibpokokaja	=bulatkan(@($alokasi/$tempo));
			
		 return $wajibpokokaja;
}

function wajibpokokaja_anggota($id_pinj_i) {	//KEWAJIBAN POKOK AJA ANGGOTA
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE sa.id=pa.sistem_angsuran AND pa.id='$id_pinj_i' "));
			$alokasi	=$wp['alokasi'];
			$jangka		=$wp['jangka'];
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			
			if($_SESSION['lokasi']=='2'){ //Khusus Tompobulu
			$wajibpokokaja_anggota	=@($alokasi/$tempo);
			}else{
			$wajibpokokaja_anggota	=bulatkan(@($alokasi/$tempo));
			}
			
		 return $wajibpokokaja_anggota;
}

function wajibjasaaja($id_pinj_i) {	//KEWAJIBAN jasa anggota
			$wj=mysql_fetch_array(mysql_query("select * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			$wajibjasa	=$alokasi*($pros_jasa/100);
			
		 return $wajibjasa;
}

function wajibjasaaja_anggota($id_pinj_i) {	//KEWAJIBAN JASA ANGGOTA
			$wj=mysql_fetch_array(mysql_query("select * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			
			$jangka		=$wj['jangka'];
			//$sistem		=$wj['sistem'];
			//$tempo		=@($jangka/$sistem);
			
			if($_SESSION['lokasi']=='2'){ //Khusus Tompobulu
			$wajibjasaaja_anggota=$alokasi*((14/100)/$jangka);
			}else if($_SESSION['lokasi']=='15'){ //Khusus Wedung
			$wajibjasaaja_anggota=$alokasi*((2/100)/$jangka);
			}else{
			$wajibjasaaja_anggota=$alokasi*($pros_jasa/100);
			}
			
		 return $wajibjasaaja_anggota;
}

function targetpokok($id_targetpokok) {	//TARGET POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_targetpokok,0,10);
			$id_pinj_i		= substr($id_targetpokok,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));
			$tgl_cair	=$tp['tgl_cair'];
			$alokasi	=$tp['alokasi'];
			$pros_jasa	=$tp['pros_jasa'];
			$jangka		=$tp['jangka'];
			$sistem		=$tp['sistem'];
			$tempo		=@($jangka/$sistem);
			$angs_pokok	=bulatkan(@($alokasi/$tempo));
			$ke			=angsuranke("$tgl_kondisi-$id_pinj_i");
			$wajibpokok	=$angs_pokok*(@($ke/$ke));
			$sumpokok	=sumpokok("$tgl_kondisi-$id_pinj_i");
			if($ke<$tempo) {
			$targetpokok	=$wajibpokok*$ke;
			}elseif($ke>=$tempo){
			$targetpokok	=$alokasi;
			}

		 return $targetpokok;
}

function wajibjasa($id_wajibjasa) {	//KEWAJIBAN JASA DIBULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_wajibjasa,0,10);
			$id_pinj_i		= substr($id_wajibjasa,11);
			$wj=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE pi.sistem_angsuran=sa.id AND pi.id='$id_pinj_i' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			$jangka		=$wj['jangka'];
			$sistem		=$wj['sistem'];
			$jenis_jasa		=$wj['jenis_jasa'];
			$tempo		=@($jangka/$sistem);
			$wapok			=wajibpokokaja("$id_pinj_i");

			$angsjasa	=bulatkan($alokasi*($pros_jasa/100));
			$angs_jasa	=$angsjasa*$sistem;
			$ke			=angsuranke("$tgl_kondisi-$id_pinj_i");
			$alljasa	=($alokasi*($pros_jasa/100))*$jangka;
			$minsatu	=$tempo-1;
			$alljasaminsatu	=$angs_jasa*$minsatu;
			
			if($ke<$tempo) {
				$wajibjasa1	=$angs_jasa;
			}elseif($ke==$tempo){
				$wajibjasa1	=$alljasa-$alljasaminsatu;
			}else{
				$wajibjasa1	=$alljasa-$alljasaminsatu;
			}

			for($j=1;$j<=$ke+1;$j++) {
			$alokasi		=alokasi($id_pinj_i);
			$sumpokok		=sumpokok("$tgl_kondisi-$id_pinj_i");
			$saldo			=$alokasi-$sumpokok;
				$wajibjasa2		=$saldo*($pros_jasa/100);
			}
			
			if ($jenis_jasa==1){$wajibjasa=$wajibjasa1;}else if ($jenis_jasa==2) {$wajibjasa=($wajibjasa2);} else{$wajibjasa=$wajibjasa1;}
			
		 return $wajibjasa;
}

function targetjasa($id_targetjasa) {	//TARGET JASA S.D. BULAN BERSANGKUTAN
	
			$tgl_kondisi   	= substr($id_targetjasa,0,10);
			$id_pinj_i		= substr($id_targetjasa,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));

			
			$alokasi		=$tp['alokasi'];
			$sistem		=$tp['sistem'];
			$jangka		=$tp['jangka'];
			$tempo				=@($jangka/$sistem);
			$pros_jasa		=$tp['pros_jasa'];
			$jenis_jasa		=$tp['jenis_jasa'];
			$wajibjasa		=wajibjasa("$tgl_kondisi-$id_pinj_i");
			$wapok			=wajibpokokaja("$id_pinj_i");
			$ke				=angsuranke("$tgl_kondisi-$id_pinj_i");
			
			if($ke<$tempo) {
				$targetjasa1	=$wajibjasa*$ke;
			}elseif($ke>=$tempo){
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}else{
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}
				
			
			for($j=1;$j<=$ke;$j++) {
				$saldo=$alokasi-($wapok*($j-1));
				$targetjasan		=$saldo*($pros_jasa/100);
				$targetjasa2		=$targetjasa2+$targetjasan;
			}
			
			if ($jenis_jasa==1){$bayar_jasa=$targetjasa1;}else if ($jenis_jasa==2) {$bayar_jasa=($targetjasa2);} else{$bayar_jasa=$targetjasa1;}
			
			//$bulat_jasa=bulatkan($bayar_jasa);
			
				
		 return $bayar_jasa;	 
			
}


function nunggakpokok($id_nunggakpokok) {	//TUNGGAKAN POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakpokok,0,10);
			$id_pinj_i		= substr($id_nunggakpokok,11);
			
			$targetpokok		=targetpokok("$tgl_kondisi-$id_pinj_i");
			$sumpokok			=sumpokok("$tgl_kondisi-$id_pinj_i");
			$nunggakp			=$targetpokok-$sumpokok;
			if($nunggakp<0) { $nunggakpokok="0"; }else{ $nunggakpokok=$nunggakp; }

		 return $nunggakpokok;
}

function nunggakjasa($id_nunggakjasa) {	//TUNGGAKAN JASA S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakjasa,0,10);
			$id_pinj_i		= substr($id_nunggakjasa,11);
			
			$st=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' AND jenis_pinjaman='I' "));
			$status=$st['status'];
			$tgl_lunas=$st['tgl_lunas'];

			$targetjasa		=targetjasa("$tgl_kondisi-$id_pinj_i");
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj_i");
			$nunggakj			=$targetjasa-$sumjasa;
			if($nunggakj<=0 OR $status=="L" AND $tgl_lunas<$tgl_kondisi) { $nunggakjasa="0"; } else{ $nunggakjasa=$nunggakj; }

		 return $nunggakjasa;
}

function pokok($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$p=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND substring(rekening_kredit,1,7)='1-10005' OR idtp='$idtp' AND substring(rekening_kredit,1,7)='1-10006' "));
			$pokok	=$p['jumlah'];
			return $pokok;
}

function jasa($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$j=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND substring(rekening_kredit,1,7)='4-60001' "));
			$jasa	=$j['jumlah'];
			return $jasa;
}

function denda($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$d=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND substring(rekening_kredit,1,7)='4-60002' "));
			$denda	=$d['jumlah'];
			return $denda;
}

function sumpokok($id_sumpokok) {
			$tgl_kondisi   	= substr($id_sumpokok,0,10);
			$idp			= substr($id_sumpokok,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			
			$pa=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id='$idp' "));
			if($pa['jenis_pinjaman']==1){ //Bulanan
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='pinj_bulanan' "));
			}else if($pa['jenis_pinjaman']==2){ //Musiman
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='pinj_musiman' "));
			}
			
			$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumpokok FROM $table_transaksi WHERE rekening_kredit='$rek[kd_rekening]_$idp' AND tgl_transaksi<='$tgl_kondisi' "));
			$sumpokok	=$sp['sumpokok'];
			return $sumpokok;
}

function sumjasa($id_sumjasa) {
			$tgl_kondisi   	= substr($id_sumjasa,0,10);
			$idp			= substr($id_sumjasa,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sj=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumjasa FROM $table_transaksi WHERE rekening_kredit='4-60001_$idp' AND tgl_transaksi<='$tgl_kondisi' "));
			$sumjasa	=$sj['sumjasa'];
			return $sumjasa;
}

function sumdenda($id_sumdenda) {
			$tgl_kondisi   	= substr($id_sumdenda,0,10);
			$id_pinj_i		= substr($id_sumdenda,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as id_sumdenda FROM $table_transaksi WHERE rekening_kredit='4-60002_$idp' AND tgl_transaksi<='$tgl_kondisi' "));
			$id_sumdenda	=$sd['id_sumdenda'];
			return $id_sumdenda;
}

function realisasiinipokok($id_bulnikok) {
			$thn_kondisi   	= substr($id_bulnikok,0,4)."01-01";
			$bln_kondisi   	= substr($id_bulnikok,0,7)."-01";
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$kc				= substr($id_bulnikok,11,1);
			$idp			= substr($id_bulnikok,13);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			
			$pa=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id='$idp' "));
			if($pa['jenis_pinjaman']==1){ //Bulanan
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='pinj_bulanan' "));
			}else if($pa['jenis_pinjaman']==2){ //Musiman
				$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='pinj_musiman' "));
			}
			
			if($kc=='D') { $tgl_awal=$tgl_kondisi; $tgl_akhir=$tgl_kondisi; }else if($kc=='M') { $tgl_awal=$bln_kondisi; $tgl_akhir=$tgl_kondisi; }else if($kc=='Y') { $tgl_awal=$thn_kondisi; $tgl_akhir=$tgl_kondisi; }

			$rp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumpokok FROM $table_transaksi WHERE rekening_kredit='$rek[kd_rekening]_$idp' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' "));
			$realisasiinipokok	=$rp['sumpokok'];
			return $realisasiinipokok;
}

function realisasiinijasa($id_buljas) {
			$thn_kondisi   	= substr($id_buljas,0,4)."01-01";
			$bln_kondisi   	= substr($id_buljas,0,7)."-01";
			$tgl_kondisi   	= substr($id_buljas,0,10);
			$kc				= substr($id_buljas,11,1);
			$idp		= substr($id_buljas,13);
			if($kc=='D') { $tgl_awal=$tgl_kondisi; $tgl_akhir=$tgl_kondisi; }else if($kc=='M') { $tgl_awal=$bln_kondisi; $tgl_akhir=$tgl_kondisi; }else if($kc=='Y') { $tgl_awal=$thn_kondisi; $tgl_akhir=$tgl_kondisi; }
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rj=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumjasa FROM $table_transaksi WHERE rekening_kredit='4-60001_$idp' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' "));
			$realisasiinijasa	=$rj['sumjasa'];
			return $realisasiinijasa;
}

function realisasimerahpokok($id_bulnikok) {
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$id_pinj_i		= substr($id_bulnikok,11);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumpokok FROM $table_transaksi WHERE id_pinj_i='$id_pinj_i' AND rekening_debit='111.01' AND tgl_transaksi >= '$tgl_kondisi' "));
			$realisasimerahpokok	=$rp['sumpokok'];
			return $realisasimerahpokok;
}

function realisasimerahjasa($id_bulnikok) {
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$id_pinj_i		= substr($id_bulnikok,11);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumpokok FROM $table_transaksi WHERE id_pinj_i='$id_pinj_i' AND rekening_debit='111.02' AND tgl_transaksi >= '$tgl_kondisi' "));
			$realisasimerahpokok	=$rp['sumpokok'];
			return $realisasimerahpokok;
}

function saldopinjaman($id_saldopinjaman) {
			$tgl_kondisi   	= substr($id_saldopinjaman,0,10);
			$id_pinj_i		= substr($id_saldopinjaman,11);
			
			$tp=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' "));
			$status	=$tp['status'];
			$tgl_lunas	=$tp['tgl_lunas'];
			
			$alokasi		=alokasi($id_pinj_i);
			$sumpokok		=sumpokok("$tgl_kondisi-$id_pinj_i");
			$saldo			=$alokasi-$sumpokok;
				if($saldo<=0 OR $status=='R' AND $tgl_lunas<=$tgl_kondisi) { $saldopinjaman="0"; }else{$saldopinjaman=$saldo;}
			return $saldopinjaman;
}


function SaldoPinjamanName($id) {	//Total Saldo Pinjaman by Name /Nia
			$tgl_kondisi   	= substr($id,0,10);
			$nia			= substr($id,11);
			
			$table_pinjaman	="pinjaman_anggota_$_SESSION[kd_kab]";
			
			$data=mysql_query("SELECT * FROM $table_pinjaman WHERE nia='$nia' AND status='A' ");
				while($r=mysql_fetch_array($data)){
					
					$saldopinjaman	=saldopinjaman("$tgl_kondisi-$r[id]");
											
					$sumsaldo=$sumsaldo+$saldopinjaman;
				}

			return $sumsaldo;
}

function saldo_jasa($id_saldo_jasa) { //Saldo Jasa
			$tgl_kondisi   	= substr($id_saldo_jasa,0,10);
			$id_pinj		= substr($id_saldo_jasa,11);
			
			$alokasi_jasa	=alokasi_jasa($id_pinj);
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj");
			$saldo_jasa			=$alokasi_jasa-$sumjasa;
			
			return $saldo_jasa;
}

function saldoPB($id) { //Saldo Pokok dan Jasa
			
			$saldo_pokok	=saldopinjaman($id);
			$saldo_jasa	=saldo_jasa($id);
			$saldoPB	=$saldo_pokok+$saldo_jasa;
			
			return $saldoPB;
}

function jangka($id_pinj_i){
			$dp=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj_i' "));
			
			$jangka		=$dp['jangka'];
			return $jangka;
	}

function bulanke($id_bulanke){
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj_i		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj_i' "));
			
			
			$tgl_cair	=$dp['tgl_cair'];
			$jangka		=$dp['jangka'];
			$sistem		=$dp['sistem'];
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2015-07-06=2015-08-11=3
			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			
				
				$selsisih_sistem	=floor(@($selisih_bln/$sistem));	//pada tgl kondisi, sudah wajib bayar ke berapa?
			
			if($sistem=='1') { $bulanke=$selisih_bln; }else{ $bulanke=$selsisih_sistem;}

			return $bulanke;
	}

function jum_nunggak($id_jum_nunggak) {
			$tgl_kondisi   	= substr($id_jum_nunggak,0,10);
			$id_pinj_i		= substr($id_jum_nunggak,11);
			
			$bulanke		=bulanke($tgl_kondisi."-".$id_pinj_i);
			$sumpokok		=sumpokok("$tgl_kondisi-$id_pinj_i");
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj_i");
			$wajibpokokaja	=wajibpokokaja($id_pinj_i);
			$wajibjasaaja	=wajibjasaaja($id_pinj_i);
			$sum			=$sumpokok+$wajibjasaaja;
			$wajib			=$wajibpokokaja+$sumjasa;
			$jum_angs		=floor(@($sum/$wajib));
			$jum_nunggak	=$bulanke-$jum_angs;
			
			return $jum_nunggak;
}

function kolek1($id_kolek1) { //Lancar (menunggak 1-4)
			$tgl_kondisi   	= substr($id_kolek1,0,10);
			$id_pinj_i		= substr($id_kolek1,11);
			$saldopinjaman	=saldoPB($tgl_kondisi."-".$id_pinj_i);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj_i);
			if ($jum_nunggak < 4){
				$kolek1	=$saldopinjaman; }else{ $kolek1	="0"; }
			return $kolek1;
}

function kolek2($id_kolek2) { //Kurang Lancar (menunggak >= 4)
			$tgl_kondisi   	= substr($id_kolek2,0,10);
			$id_pinj_i		= substr($id_kolek2,11);
			$saldopinjaman	=saldoPB($tgl_kondisi."-".$id_pinj_i);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj_i);
			$jangka			=jangka($id_pinj_i);
			if ($jum_nunggak >= 4 and $jum_nunggak <= $jangka){
				$kolek2	=$saldopinjaman; }else{ $kolek2	="0"; }
			return $kolek2;
}

function kolek3($id_kolek3) { //Diragukan (over 1-6)
			$tgl_kondisi   	= substr($id_kolek3,0,10);
			$id_pinj_i		= substr($id_kolek3,11);
			$saldopinjaman	=saldoPB($tgl_kondisi."-".$id_pinj_i);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj_i);
			$jangka			=jangka($id_pinj_i);
			if ($jum_nunggak > $jangka and $jum_nunggak < $jangka+6 ){
				$kolek3	=$saldopinjaman; }else{ $kolek3	="0"; }
			return $kolek3;
}

function kolek4($id_kolek4) { //Macet (over >= 6)
			$tgl_kondisi   	= substr($id_kolek4,0,10);
			$id_pinj_i		= substr($id_kolek4,11);
			$saldopinjaman	=saldoPB($tgl_kondisi."-".$id_pinj_i);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj_i);
			$jangka			=jangka($id_pinj_i);
			if ($jum_nunggak >= $jangka+6){
				$kolek4	=$saldopinjaman; }else{ $kolek4	="0"; }
			return $kolek4;
}

//BY DESA
function alokasiD($id_alokasiD) {
			$tgl_kondisi   	= substr($id_alokasiD,0,10); //2015-01-01=1=1111
			$idf			= substr($id_alokasiD,11,1);
			$idd			= substr($id_alokasiD,13);
			$y			= substr($id_alokasiD,0,4);
			$thn_kondisi		="$y-01-01";
			$apk=mysql_fetch_array(mysql_query("select *, sum(alokasi) AS sumalokasi from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function targetpokokD($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			$y				= substr($id_targetpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetpokok("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function targetjasaD($targetjasaD) {
			$tgl_kondisi   	= substr($targetjasaD,0,10); //2015-01-01=1=1111
			$idf			= substr($targetjasaD,11,1);
			$idd			= substr($targetjasaD,13);
			$y				= substr($targetjasaD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetjasa("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function sumpokokD($sumpokokD) {	//BELUM DIPAKE
			$tgl_kondisi   	= substr($sumpokokD,0,10); //2015-01-01=1=1111
			$idf			= substr($sumpokokD,11,1);
			$idd			= substr($sumpokokD,13);
			$y				= substr($sumpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumpokok("$tgl_kondisi-$idp");
			$sumpokok=$sumpokok+$tarpok;
			}
		 return $sumpokok;
}

function sumjasaD($sumjasaD) {
			$tgl_kondisi   	= substr($sumjasaD,0,10); //2015-01-01=1=1111
			$idf			= substr($sumjasaD,11,1);
			$idd			= substr($sumjasaD,13);
			$y				= substr($sumpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumjasa("$tgl_kondisi-$idp");
			$sumjasa=$sumjasa+$tarpok;
			}
		 return $sumjasa;
}

function sumrealpokokD($sumrealpokokD) {
			$tgl_kondisi   	= substr($sumrealpokokD,0,10); //2015-01-01=1=1111
			$idf			= substr($sumrealpokokD,11,1);
			$idd			= substr($sumrealpokokD,13);
			$y				= substr($sumrealpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$sumrealni	=sumpokok("$tgl_kondisi-$idp");
			$sumrealpokok=$sumrealpokok+$sumrealni;
			}
		 return $sumrealpokok;
}

function sumrealjasaD($sumrealjasaD) {
			$tgl_kondisi   	= substr($sumrealjasaD,0,10); //2015-01-01=1=1111
			$idf			= substr($sumrealjasaD,11,1);
			$idd			= substr($sumrealjasaD,13);
			$y				= substr($sumrealjasaD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumjasa("$tgl_kondisi-$idp");
			$sumrealjasa=$sumrealjasa+$tarpok;
			}
		 return $sumrealjasa;
}

function saldopinjamanD($saldopinjamanD) {
			$tgl_kondisi   	= substr($saldopinjamanD,0,10); //2015-01-01=1=1111
			$idf			= substr($saldopinjamanD,11,1);
			$idd			= substr($saldopinjamanD,13);
			$y				= substr($saldopinjamanD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=saldopinjaman("$tgl_kondisi-$idp");
			$saldopinjaman=$saldopinjaman+$tarpok;
			}
		 return $saldopinjaman;
}

function nunggakpokokD($nunggakpokokD) {
			$tgl_kondisi   	= substr($nunggakpokokD,0,10); //2015-01-01=1=1111
			$idf			= substr($nunggakpokokD,11,1);
			$idd			= substr($nunggakpokokD,13);
			$y				= substr($nunggakpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' OR
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' AND jenis_pinjaman='I' 
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakpokok("$tgl_kondisi-$idp");
			$nunggakpokok=$nunggakpokok+$tarpok;
			}
		 return $nunggakpokok;
}

function nunggakjasaD($nunggakjasaD) {
			$tgl_kondisi   	= substr($nunggakjasaD,0,10); //2015-01-01=1=1111
			$idf			= substr($nunggakjasaD,11,1);
			$idd			= substr($nunggakjasaD,13);
			$y				= substr($nunggakjasaD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
			a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A' AND jenis_pinjaman='I'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakjasa("$tgl_kondisi-$idp");
			$nunggakjasa=$nunggakjasa+$tarpok;
			}
		 return $nunggakjasa;
}

function kolek1D($id_kolek1D) {
			$tgl_kondisi   	= substr($id_kolek1D,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek1D,11,1);
			$idd			= substr($id_kolek1D,13);
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd'  AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A'");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek1("$tgl_kondisi-$idp");
			$kolek1=$kolek1+$tarpok;
			}
		 return $kolek1;
}

function kolek2D($id_kolek2D) {
			$tgl_kondisi   	= substr($id_kolek2D,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek2D,11,1);
			$idd			= substr($id_kolek2D,13);
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd'  AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A'");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek2("$tgl_kondisi-$idp");
			$kolek2=$kolek2+$tarpok;
			}
		 return $kolek2;
}

function kolek3D($id_kolek3D) {
			$tgl_kondisi   	= substr($id_kolek3D,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek3D,11,1);
			$idd			= substr($id_kolek3D,13);
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd'  AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A'");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek3("$tgl_kondisi-$idp");
			$kolek3=$kolek3+$tarpok;
			}
		 return $kolek3;
}

function kolek4D($id_kolek4D) {
			$tgl_kondisi   	= substr($id_kolek4D,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek4D,11,1);
			$idd			= substr($id_kolek4D,13);
			$tpk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND a.desa='$idd'  AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi'  AND pi.status='A'");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek4("$tgl_kondisi-$idp");
			$kolek4=$kolek4+$tarpok;
			}
		 return $kolek4;
}


//SUM KOLEK

function sumkolek1($id_sumkolek1) {
			$tgl_kondisi   	= substr($id_sumkolek1,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumkolek1,11,1);
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek1	=kolek1("$tgl_kondisi-$idp");
			$sumkolek1=$sumkolek1+$kolek1;
			}
		 return $sumkolek1;
}

function sumkolek2($id_sumkolek2) {
			$tgl_kondisi   	= substr($id_sumkolek2,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumkolek2,11,1);
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek2	=kolek2("$tgl_kondisi-$idp");
			$sumkolek2=$sumkolek2+$kolek2;
			}
		 return $sumkolek2;
}

function sumkolek3($id_sumkolek3) {
			$tgl_kondisi   	= substr($id_sumkolek3,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumkolek3,11,1);
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek3	=kolek3("$tgl_kondisi-$idp");
			$sumkolek3=$sumkolek3+$kolek3;
			}
		 return $sumkolek3;
}

function sumkolek4($id_sumkolek4) {
			$tgl_kondisi   	= substr($id_sumkolek4,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumkolek4,11,1);
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.jenis_pp='$idf' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek4	=kolek4("$tgl_kondisi-$idp");
			$sumkolek4=$sumkolek4+$kolek4;
			}
		 return $sumkolek4;
}


function totCR($id_totCR) {
			$tgl_kondisi   	= substr($id_totCR,0,10); //2015-01-01=1=1111
			$idf			= substr($id_totCR,11,1);

			$sumcr1		=(sumkolek1("$tgl_kondisi-$idf"))*1/100;
			$sumcr2		=(sumkolek2("$tgl_kondisi-$idf"))*10/100;
			$sumcr3		=(sumkolek3("$tgl_kondisi-$idf"))*25/100;
			$sumcr4		=(sumkolek4("$tgl_kondisi-$idf"))*50/100;
			$totCR		=$sumcr1+$sumcr2+$sumcr3+$sumcr4;
			
		 return $totCR;
}

//KESEHATAN
function sumnunggakpokok($id_sumnunggakpokok) {
			$tgl_kondisi   	= substr($id_sumnunggakpokok,0,10); //2015-01-01=1=1111
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$idp");
			$sumnunggakpokok=$sumnunggakpokok+$nunggakpokok;
			}
		 return $sumnunggakpokok;
}

function sumsaldopinjaman($id_sumsaldopinjaman) {
			$tgl_kondisi   	= substr($id_sumsaldopinjaman,0,10); //2015-01-01=1=1111
			$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND a.lokasi='$_SESSION[lokasi]'  AND pi.status='A'");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$saldopinjaman	=saldopinjaman("$tgl_kondisi-$idp");
			$id_sumsaldopinjaman=$id_sumsaldopinjaman+$saldopinjaman;
			}
		 return $id_sumsaldopinjaman;
}

function sumtotCR($id_sumtotCR) {
			$tgl_kondisi   	= substr($id_sumtotCR,0,10); //2015-01-01=1=1111

			$totCRSPP		=totCR("$tgl_kondisi-1");
			$totCRUEP		=totCR("$tgl_kondisi-2");
			$sumtotCR		=$totCRSPP+$totCRUEP;
			
		 return $sumtotCR;
}

//REKAP KECAMATAN
function alokasiC($id_alokasiC) {
			$tgl_kondisi   	= substr($id_alokasiC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_alokasiC,11,1);
			$idc			= substr($id_alokasiC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$alokasiD	=alokasiD("$tgl_kondisi-$idf-$row[id]");
			$alokasiC=$alokasiC+$alokasiD;
			}
		 return $alokasiC;
}

function targetpokokC($id_targetpokokC) {
			$tgl_kondisi   	= substr($id_targetpokokC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_targetpokokC,11,1);
			$idc			= substr($id_targetpokokC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$targetpokokD	=targetpokokD("$tgl_kondisi-$idf-$row[id]");
			$targetpokokC=$targetpokokC+$targetpokokD;
			}
		 return $targetpokokC;
}

function targetjasaC($id_targetjasaC) {
			$tgl_kondisi   	= substr($id_targetjasaC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_targetjasaC,11,1);
			$idc			= substr($id_targetjasaC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$targetjasaD	=targetjasaD("$tgl_kondisi-$idf-$row[id]");
			$targetjasaC=$targetjasaC+$targetjasaD;
			}
		 return $targetjasaC;
}

function sumrealpokokC($id_sumrealpokokC) {
			$tgl_kondisi   	= substr($id_sumrealpokokC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumrealpokokC,11,1);
			$idc			= substr($id_sumrealpokokC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$sumrealpokokD	=sumrealpokokD("$tgl_kondisi-$idf-$row[id]");
			$sumrealpokokC=$sumrealpokokC+$sumrealpokokD;
			}
		 return $sumrealpokokC;
}

function sumrealjasaC($id_sumrealjasaC) {
			$tgl_kondisi   	= substr($id_sumrealjasaC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_sumrealjasaC,11,1);
			$idc			= substr($id_sumrealjasaC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$sumrealjasaD	=sumrealjasaD("$tgl_kondisi-$idf-$row[id]");
			$sumrealjasaC=$sumrealjasaC+$sumrealjasaD;
			}
		 return $sumrealjasaC;
}

function saldopinjamanC($id_saldopinjamanC) {
			$tgl_kondisi   	= substr($id_saldopinjamanC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_saldopinjamanC,11,1);
			$idc			= substr($id_saldopinjamanC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$saldopinjamanD	=saldopinjamanD("$tgl_kondisi-$idf-$row[id]");
			$saldopinjamanC=$saldopinjamanC+$saldopinjamanD;
			}
		 return $saldopinjamanC;
}

function proskembaliC($id_proskembaliC) {
			$tgl_kondisi   	= substr($id_proskembaliC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_proskembaliC,11,1);
			$idc			= substr($id_proskembaliC,13);

			$sumrealpokokC	=sumrealpokokC("$tgl_kondisi-$idf-$idc");
			$targetpokokC	=targetpokokC("$tgl_kondisi-$idf-$idc");
			$proskembaliC=@($sumrealpokokC/$targetpokokC*100);
			
		 return $proskembaliC;
}

function nunggakpokokC($id_nunggakpokokC) {
			$tgl_kondisi   	= substr($id_nunggakpokokC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_nunggakpokokC,11,1);
			$idc			= substr($id_nunggakpokokC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$nunggakpokokD	=nunggakpokokD("$tgl_kondisi-$idf-$row[id]");
			$nunggakpokokC=$nunggakpokokC+$nunggakpokokD;
			}
		 return $nunggakpokokC;
}

function nunggakjasaC($id_nunggakjasaC) {
			$tgl_kondisi   	= substr($id_nunggakjasaC,0,10); //2015-01-01=1=1111
			$idf			= substr($id_nunggakjasaC,11,1);
			$idc			= substr($id_nunggakjasaC,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$nunggakjasaD	=nunggakjasaD("$tgl_kondisi-$idf-$row[id]");
			$nunggakjasaC=$nunggakjasaC+$nunggakjasaD;
			}
		 return $nunggakjasaC;
}

function kolek1C($id_kolek1C) {
			$tgl_kondisi   	= substr($id_kolek1C,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek1C,11,1);
			$idc			= substr($id_kolek1C,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek1D	=kolek1D("$tgl_kondisi-$idf-$row[id]");
			$kolek1C=$kolek1C+$kolek1D;
			}
		 return $kolek1C;
}

function kolek2C($id_kolek2C) {
			$tgl_kondisi   	= substr($id_kolek2C,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek2C,11,1);
			$idc			= substr($id_kolek2C,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek2D	=kolek2D("$tgl_kondisi-$idf-$row[id]");
			$kolek2C=$kolek2C+$kolek2D;
			}
		 return $kolek2C;
}

function kolek3C($id_kolek3C) {
			$tgl_kondisi   	= substr($id_kolek3C,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek3C,11,1);
			$idc			= substr($id_kolek3C,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek3D	=kolek3D("$tgl_kondisi-$idf-$row[id]");
			$kolek3C=$kolek3C+$kolek3D;
			}
		 return $kolek3C;
}

function kolek4C($id_kolek4C) {
			$tgl_kondisi   	= substr($id_kolek4C,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek4C,11,1);
			$idc			= substr($id_kolek4C,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek4D	=kolek4D("$tgl_kondisi-$idf-$row[id]");
			$kolek4C=$kolek4C+$kolek4D;
			}
		 return $kolek4C;
}

function kolek5C($id_kolek5C) {
			$tgl_kondisi   	= substr($id_kolek5C,0,10); //2015-01-01=1=1111
			$idf			= substr($id_kolek5C,11,1);
			$idc			= substr($id_kolek5C,13);
			$data=mysql_query("SELECT * FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek5D	=kolek5D("$tgl_kondisi-$idf-$row[id]");
			$kolek5C=$kolek5C+$kolek5D;
			}
		 return $kolek5C;
}

function adaangsurankah_anggota($id_bulanke){ //Dibulan Bersangkutan apakah ada kewajiban angsuran Pokok?
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sistem_angsuran AND pi.id='$id_pinj' "));
			
			
			$tgl_cair	=$dp['tgl_cair'];
			$jangka		=$dp['jangka'];
			$sistem		=$dp['sistem'];
			$tempo		=$jangka/$sistem;
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2015-07-06=2015-08-11=3
			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			
			$sisabagi	=$selisih_bln % $sistem; //Bulan YBS ada kewajiban angsuran jika sisa bagi = NOL

			return $sisabagi;
	}
	
function adaJasakah_anggota($id_bulanke){ //Dibulan Bersangkutan apakah ada kewajiban angsuran Jasa?
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sa_jasa AND pi.id='$id_pinj' "));
			
			
			$tgl_cair	=$dp['tgl_cair'];
			$jangka		=$dp['jangka'];
			$sistem		=$dp['sistem'];
			$tempo		=$jangka/$sistem;
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2015-07-06=2015-08-11=3
			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			
			$sisabagi	=$selisih_bln % $sistem; //Bulan YBS ada kewajiban angsuran jika sisa bagi = NOL

			return $sisabagi;
	}
?>