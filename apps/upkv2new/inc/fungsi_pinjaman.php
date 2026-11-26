<?php	
function bulatkan($angka) {
		 $row=mysql_fetch_array(mysql_query("select pembulatan, length(pembulatan) as panjang from kecamatan WHERE id='$_SESSION[lokasi]' "));
		 
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
			$tgl_kondisi   	= substr($id_angsuranke,0,10); //2018-03-06-P-1234
			$jenis_sistem	= substr($id_angsuranke,11,1);
			$id_pinj		= substr($id_angsuranke,13);
			//Menentukan apakah Pokok atau Jasa
			if($jenis_sistem=='P') {
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			
			    if($dp['sistem_angsuran']==11){
			        $tglcair25	=$dp['tgl_cair'];
			        $jangka		=$dp['jangka'];
		        	$tglcairN	= date('Y-m-d', strtotime('+24 month', strtotime($tglcair25)));
				}else if ($dp['sistem_angsuran']==14){
			        $tglcair4	=$dp['tgl_cair'];
			        $jangka		=$dp['jangka'];
		        	$tglcairN	= date('Y-m-d', strtotime('+3 month', strtotime($tglcair4)));
			    }
			        else if ($dp['sistem_angsuran']==15){
			        $tglcair3	=$dp['tgl_cair'];
			        $jangka		=$dp['jangka'];
		        	$tglcairN	= date('Y-m-d', strtotime('+2 month', strtotime($tglcair3)));
			    }
			        else if ($dp['sistem_angsuran']==16){
			        $tglcair3	=$dp['tgl_cair'];
			        $jangka		=$dp['jangka'];
		        	$tglcairN	= date('Y-m-d', strtotime('+12 month', strtotime($tglcair3)));
			    }
			        else{   
			            $jangka		=$dp['jangka'];
			            $tglcairN	=$dp['tgl_cair']; //Tanggal Cair Normal
			        }
			}elseif ($jenis_sistem=='J') {
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sa_jasa AND pk.id='$id_pinj' "));
			$jangka		=$dp['jangka'];
			$tglcairN	=$dp['tgl_cair']; //Tanggal Cair Normal
			}
			
			$kec=mysql_fetch_array(mysql_query("select * from kecamatan c, jenis_toleransi jt WHERE c.tgl_toleransi=jt.id_toleransi AND c.id='$_SESSION[lokasi]' "));
			
			$id_toleransi	=$kec['id_toleransi'];
			$role_query		=$kec['role_query'];
			
			if($tgl_desa==null or $tgl_desa==""){
			$tglcairA	= $tglcairN;							//Tanggal Cair normal
			}else{ 
			$tglcairD	=substr($tglcairN,0,7)."-$tgl_desa"; 	//Tanggal Cair menjad tanggal desa
			$tglcairA 	= date('Y-m-d', strtotime('-1 days', strtotime($tglcairD))); //Pengurangan Hari karna PLL salah (kurang 1 hari)
			}
			
			$tglcairB	=substr($tglcairA,0,7)."-01"; //Tanggal Cair menjad tanggal 1
			
			$tglcair1 	= date('Y-m-d', strtotime($role_query, strtotime($tglcairA))); //Penambahan Hari
			$tglcair2 	= date('Y-m-d', strtotime($role_query, strtotime($tglcairB))); //role_query= +1 month
			
			$cair_tgl	=substr($tglcairA,8,2);
			
			if($id_toleransi=="M1") { 
				if($cair_tgl>=25) {
					$tgl_cair	=$tglcair2;
				}else{
					$tgl_cair	=$tglcairA;
				}
			} else {
				$tgl_cair	=$tglcair1;
			}
			
			
			
			$sistem		=$dp['sistem'];
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22	//Tanggal Cair
			$tgl2   	= substr($id_angsuranke,8,2); 	 //0123456789-11   16 19  22	//Tanggal Kondisi
			$tgl3   	= date("d"); //2015-07-06=2015-08-11=3  	//Tanggal Kondisi
			if($tgl2=='31') { $tglA=$tgl2; }else{ $tglA=$tgl3;}

			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_angsuranke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_angsuranke,0,4);
			
			if($dp['sistem_angsuran']==12){		//MINGGUAN
				$date1=date_create("$tgl_cair");
				$date2=date_create("$tgl_kondisi");
				$selisih_hari=date_diff($date1,$date2)->format("%a");
				$selisih_mg=floor(@($selisih_hari/7));
				if($selisih_mg>$jangka) {$selisih_minggu=$jangka;}else{$selisih_minggu=$selisih_mg;}
				$angsuranke=$selisih_minggu;
			}else{
			$selisihbln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);					//Selisih bulan dari bln cair sampai bln kondisi
			if ($tgl2 < $tgl1) { $selisih_bln=$selisihbln-1; } else { $selisih_bln=$selisihbln; }	//Selisih bulan dari tgl cair sampai tglkondisi

				if($selisih_bln>$jangka) { $selisih_bulan=$jangka; }else{ $selisih_bulan=$selisih_bln;	}	//Kondisi jika kadaluarsa
				
				$selsisih_sistem	=floor(@($selisih_bulan/$sistem));										//pada tgl kondisi, sudah wajib bayar ke berapa?
			
			if($sistem=='1') { $angsuranke=$selisih_bulan; }else{ $angsuranke=$selsisih_sistem;}
			}
			if($angsuranke<0){$angsuranke=0;}else{$angsuranke=$angsuranke;}
			return $angsuranke;
	}

function alokasi($id_pinj) {	//ALOKASI PINJAMAN
			$ap=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			$alokasi	=$ap['alokasi'];
		 return $alokasi;
}

function alokasi_jasa($id_pinj) {	//ALOKASI JASA
			$ap=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			$alokasi	=$ap['alokasi'];
			$jangka		=$ap['jangka'];
			$pros_jasa	=$ap['pros_jasa']/100;
			$alokasi_jasa=@(ceil($alokasi*$pros_jasa*$jangka));
		 return $alokasi_jasa;
}
	
function wajibpokok($id_wajibpokok) {	//KEWAJIBAN POKOK DIBULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_wajibpokok,0,10);
			$id_pinj		= substr($id_wajibpokok,11);
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			$tgl_cair	=$wp['tgl_cair'];
			$alokasi	=$wp['alokasi'];
			$pros_jasa	=$wp['pros_jasa'];
			$jangka		=$wp['jangka'];
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			$angs_pokok	=bulatkan(@($alokasi/$tempo));
			$ke			=angsuranke("$tgl_kondisi-P-$id_pinj");
			$sumpokok	=sumpokok("$tgl_kondisi-$id_pinj");
			if($ke<$jangka) {
			$wajibpokok	=$angs_pokok*(@($ke/$ke));
			}elseif($ke==$jangka-1){
			$wajibpokok	=$alokasi-$sumpokok;
			}else{
			$wajibpokok	=$alokasi-$sumpokok;
			}
			
		 return $wajibpokok;
}

function wajibpokokaja($id_pinj) {	//KEWAJIBAN POKOK KELOMPOK
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			$alokasi	=$wp['alokasi'];
			if($wp['sistem_angsuran']==11){
			$jangka		= ($wp['jangka'])-24;  
			}else if ($wp['sistem_angsuran']==14){
			$jangka			=($wp['jangka'])-3;		
			}else if ($wp['sistem_angsuran']==15){
			$jangka			=($wp['jangka'])-2;		
			}else if ($wp['sistem_angsuran']==16){
			$jangka			=($wp['jangka'])-12;		
			}else  {
			$jangka		=$wp['jangka'];
			}
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			$wajibpokokaja	=bulatkan(@($alokasi/$tempo));
			
		 return $wajibpokokaja;
}

function wajibpokokaja_anggota($id_pinj) {	//KEWAJIBAN POKOK AJA ANGGOTA
			$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE sa.id=pa.sistem_angsuran AND pa.id='$id_pinj' "));
			$alokasi	=$wp['alokasi'];
			if($wp['sistem_angsuran']==11){
			$jangka		= ($wp['jangka'])-24;  
			}else if ($wp['sistem_angsuran']==14){
			$jangka			= ($wp['jangka'])-3;
			}else if ($wp['sistem_angsuran']==15){
			$jangka			= ($wp['jangka'])-2;
			}else{
			$jangka		=$wp['jangka'];
			}
			$sistem		=$wp['sistem'];
			$tempo		=@($jangka/$sistem);
			
			if($_SESSION['lokasi']=='2'){ //Khusus Tompobulu
			$wajibpokokaja_anggota	=@($alokasi/$tempo);
			}else{
			$wajibpokokaja_anggota	=bulatkan(@($alokasi/$tempo));
			}
			
		 return $wajibpokokaja_anggota;
}

function wajibjasaaja($id_pinj)
{	//KEWAJIBAN jasa kelompok
	$wj = mysql_fetch_array(mysql_query("select * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk,sistem_angsuran s WHERE pk.sa_jasa=s.id AND pk.id='$id_pinj' "));
	$alokasi	= $wj['alokasi'];
	$jangka		= $wj['jangka'];
	$sistem     = $wj['sistem'];
	$pros_jasa	= $wj['pros_jasa'];
	$wajibjasa	= $alokasi * ($pros_jasa / 100) * $sistem;

	return $wajibjasa;
}

function wajibjasaaja_anggota($id_pinj) {	//KEWAJIBAN JASA ANGGOTA
			$wj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE sa.id=pa.sistem_angsuran AND pa.id='$id_pinj' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			
			$jangka		=$wj['jangka'];
			$sistem		=$wj['sistem'];
			//$tempo		=@($jangka/$sistem);
			
			if($_SESSION['lokasi']=='2' AND $wj['jenis_pinjaman']=='K'){ //Khusus Tompobulu
			$wajibjasaaja_anggota=$alokasi*((14/100)/$jangka);
			}else if($_SESSION['lokasi']=='15' AND $wj['jenis_pinjaman']=='K'){ //Khusus Wedung
			$wajibjasaaja_anggota=$alokasi*(2/100);
			}else if($_SESSION['lokasi']=='68' AND $wj['jenis_pinjaman']=='K'){ //Khusus sariwangi Tasikmalaya
			$wajibjasaaja_anggota			=$alokasi*(1.833333/100);
			}else if($_SESSION['lokasi']=='197' AND $wj['jenis_pinjaman']=='K'){ //Khusus Salopa Tasikmalaya
			$wajibjasaaja_anggota			=$alokasi*(2.5/100);
			}else if($_SESSION['lokasi']=='125' AND $wj['jenis_pinjaman']=='K'){ //Khusus Karangjaya Tasikmalaya
			$wajibjasaaja_anggota			=$alokasi*(1.7/100);
			}else if($_SESSION['lokasi']=='114' AND $wj['jenis_pinjaman']=='K'){ //Khusus Widang Tuban Jatim
			$wajibjasaaja_anggota			=$alokasi*(1.75/100);
			}else if($_SESSION['lokasi']=='118' AND $wj['jenis_pinjaman']=='K'){ //Khusus Senori Tuban Jatim
			$wajibjasaaja_anggota			=$alokasi*(2/100);
			}else if($_SESSION['lokasi']=='115' AND $wj['jenis_pinjaman']=='K'){ //Khusus Rengel Tuban Jatim
			
												if($sistem=="1") {
													$wajibjasaaja_anggota			=$alokasi*(1.25/100);
												}else if($sistem=="4") {
													$wajibjasaaja_anggota			=$alokasi*(1.5/100);
												}else if($sistem=="6") {
													$wajibjasaaja_anggota			=$alokasi*(1.75/100);
												}else{
													$wajibjasaaja_anggota			=$alokasi*(1.25/100);
												}
			}else{
			$wajibjasaaja_anggota=$alokasi*($pros_jasa/100);
			}
			
		 return $wajibjasaaja_anggota;
}

function targetpokok($id_targetpokok) {	//TARGET POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_targetpokok,0,10);
			$id_pinj		= substr($id_targetpokok,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			$alokasi	=$tp['alokasi'];
			$pros_jasa	=$tp['pros_jasa'];
			if($tp['sistem_angsuran']==11){
				$tglcair	=$tp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+25 month', strtotime($tglcair))); //m24
			    $jangka		= ($tp['jangka'])-24;
			}else if ($tp['sistem_angsuran']==14){
				$tglcair	=$tp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+4 month', strtotime($tglcair))); //m3
			    $jangka		= ($tp['jangka'])-3;
			}else if ($tp['sistem_angsuran']==15){
				$tglcair	=$tp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+3 month', strtotime($tglcair))); //m2
			    $jangka		= ($tp['jangka'])-2;
			}else if ($tp['sistem_angsuran']==16){
				$tglcair	=$tp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+13 month', strtotime($tglcair))); //m12
			    $jangka		= ($tp['jangka'])-12;
			}else{
			    $tgl_cair	=$tp['tgl_cair'];
			    $jangka		=$tp['jangka'];
			}
			$sistem		=$tp['sistem'];
			$tempo		=@($jangka/$sistem);
			$angs_pokok	=bulatkan(@($alokasi/$tempo));
			$ke			=angsuranke("$tgl_kondisi-P-$id_pinj");
			$wajibpokok	=$angs_pokok*(@($ke/$ke));
			$sumpokok	=sumpokok("$tgl_kondisi-$id_pinj");
			if($ke<$tempo) {
			$targetpokok	=$wajibpokok*$ke;
			}elseif($ke>=$tempo){
			$targetpokok	=$alokasi;
			}

		 return $targetpokok;

}

function wajibjasa($id_wajibjasa) {	//KEWAJIBAN JASA DIBULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_wajibjasa,0,10);
			$id_pinj		= substr($id_wajibjasa,11);
			$wj=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE pk.sa_jasa=sa.id AND pk.id='$id_pinj' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			$jangka		=$wj['jangka'];
			$sistem		=$wj['sistem'];
			$tempo		=@($jangka/$sistem);

			$angsjasa	=($alokasi*($pros_jasa/100));
			$angs_jasa	=$angsjasa*$sistem;
			$ke			=angsuranke("$tgl_kondisi-J-$id_pinj");
			$alljasa	=($alokasi*($pros_jasa/100))*$jangka;
			$minsatu	=$tempo-1;
			$alljasaminsatu	=$angs_jasa*$minsatu;
			
			if($ke<$tempo) {
				$wajibjasa	=$angs_jasa;
			}elseif($ke==$tempo){
				$wajibjasa	=$alljasa-$alljasaminsatu;
			}else{
				$wajibjasa	=$alljasa-$alljasaminsatu;
			}

		 return $wajibjasa;
}

function targetjasa($id_targetjasa) {	//TARGET JASA S.D. BULAN BERSANGKUTAN
	
			$tgl_kondisi   	= substr($id_targetjasa,0,10);
			$id_pinj		= substr($id_targetjasa,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sa_jasa AND pk.id='$id_pinj' "));

			
			$alokasi		=$tp['alokasi'];
			$sistem		=$tp['sistem'];
			$jangka		=$tp['jangka'];
			$tempo				=@($jangka/$sistem);
			$pros_jasa		=$tp['pros_jasa'];
			$jenis_jasa		=$tp['jenis_jasa'];
			$wajibjasa		=wajibjasa("$tgl_kondisi-$id_pinj");
			$wapok			=wajibpokokaja("$id_pinj");
			$ke				=angsuranke("$tgl_kondisi-J-$id_pinj");
			
			if($ke<$tempo) {
				$targetjasa1	=$wajibjasa*$ke;
			}elseif($ke>=$tempo){
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}else{
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}
				
			$targetjasa2		=0;
			for($j=1;$j<=$ke;$j++) {
				$saldo=$alokasi-($wapok*($j-1));
				$targetjasan		=$saldo*($pros_jasa/100);
				$targetjasa2		=$targetjasa2+$targetjasan;
			}
			
			if ($jenis_jasa==1){$bayar_jasa=$targetjasa1;}else if ($jenis_jasa==2) {$bayar_jasa=bulatkan($targetjasa2);} else{$bayar_jasa=$targetjasa1;}
			
			//$bulat_jasa=bulatkan($bayar_jasa);
			
				
		 return $bayar_jasa;	 
			
}


function nunggakpokok($id_nunggakpokok) {	//TUNGGAKAN POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakpokok,0,10);
			$id_pinj		= substr($id_nunggakpokok,11);
			
			$targetpokok		=targetpokok("$tgl_kondisi-$id_pinj");
			$sumpokok			=sumpokok("$tgl_kondisi-$id_pinj");
			$nunggakp			=$targetpokok-$sumpokok;
			if($nunggakp<0) { $nunggakpokok="0"; }else{ $nunggakpokok=$nunggakp; }

		 return $nunggakpokok;
}

function nunggakjasa($id_nunggakjasa) {	//TUNGGAKAN JASA S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakjasa,0,10);
			$id_pinj		= substr($id_nunggakjasa,11);
			
			$st=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			$status=$st['status'];
			$tgl_lunas=$st['tgl_lunas'];

			$targetjasa		=targetjasa("$tgl_kondisi-$id_pinj");
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj");
			$nunggakj			=$targetjasa-$sumjasa;
			if($nunggakj<=0 OR $status=="L" AND $tgl_lunas<$tgl_kondisi ) { $nunggakjasa="0"; } else{ $nunggakjasa=$nunggakj; }

		 return $nunggakjasa;
}

function pokok($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$p=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND rekening_debit='112.01' OR idtp='$idtp' AND rekening_debit='113.01' OR idtp='$idtp' AND rekening_debit='114.01' OR idtp='$idtp' AND rekening_debit='115.01' OR idtp='$idtp' AND rekening_debit='116.01' OR idtp='$idtp'  AND rekening_debit='117.01' "));
			$pokok	=$p['jumlah'];
			return $pokok;
}

function jasa($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$j=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND rekening_debit='112.02' OR idtp='$idtp' AND rekening_debit='113.02' OR idtp='$idtp' AND rekening_debit='114.02' OR idtp='$idtp' AND rekening_debit='115.02' OR idtp='$idtp' AND rekening_debit='116.02' OR idtp='$idtp'  AND rekening_debit='117.02' "));
			$jasa	=$j['jumlah'];
			return $jasa;
}

function denda($idtp) {
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$d=mysql_fetch_array(mysql_query("SELECT * FROM $table_transaksi WHERE idtp='$idtp' AND rekening_debit='112.03' OR idtp='$idtp' AND rekening_debit='113.03' OR  idtp='$idtp' AND rekening_debit='114.03' OR idtp='$idtp' AND rekening_debit='115.03' OR idtp='$idtp' AND rekening_debit='116.03' OR idtp='$idtp'  AND rekening_debit='117.03' "));
			$denda	=$d['jumlah'];
			return $denda;
}

function sumpokok($id_sumpokok) {
			$tgl_kondisi   	= substr($id_sumpokok,0,10);
			$id_pinj		= substr($id_sumpokok,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sp=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumpokok FROM $table_transaksi WHERE 
			id_pinj='$id_pinj' AND rekening_debit='112.01' AND tgl_transaksi<='$tgl_kondisi' OR 
			id_pinj='$id_pinj' AND rekening_debit='113.01' AND tgl_transaksi<='$tgl_kondisi' OR 
			id_pinj='$id_pinj' AND rekening_debit='114.01' AND tgl_transaksi<='$tgl_kondisi' OR 
			id_pinj='$id_pinj' AND rekening_debit='115.01' AND tgl_transaksi<='$tgl_kondisi' OR 
			id_pinj='$id_pinj' AND rekening_debit='116.01' AND tgl_transaksi<='$tgl_kondisi' OR 
			id_pinj='$id_pinj' AND rekening_debit='117.01' AND tgl_transaksi<='$tgl_kondisi'"));
			$sumpokok	=$sp['sumpokok'];
			return $sumpokok;
}

function sumjasa($id_sumjasa) {
			$tgl_kondisi   	= substr($id_sumjasa,0,10);
			$id_pinj		= substr($id_sumjasa,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sj=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumjasa FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='114.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='115.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='116.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='117.02' AND tgl_transaksi<='$tgl_kondisi'"));
			$sumjasa	=$sj['sumjasa'];
			return $sumjasa;
}

function sumdenda($id_sumdenda) {
			$tgl_kondisi   	= substr($id_sumdenda,0,10);
			$id_pinj		= substr($id_sumdenda,11);
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$sd=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as id_sumdenda FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.03' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.03' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='114.03' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='115.03' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='116.03' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='117.03' AND tgl_transaksi<='$tgl_kondisi'"));
			$id_sumdenda	=$sd['id_sumdenda'];
			return $id_sumdenda;
}

function realisasiinipokok($id_bulnikok) {
			$thn_kondisi   	= substr($id_bulnikok,0,4)."01-01";
			$bln_kondisi   	= substr($id_bulnikok,0,7)."-01";
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$last_day_of_month = date('Y-m-t', strtotime($tgl_kondisi));
			$kc				= substr($id_bulnikok,11,1);
			$id_pinj		= substr($id_bulnikok,13);
			if($kc=='D') { $tgl_awal=$tgl_kondisi; $tgl_akhir=$tgl_kondisi; }else 
			if($kc=='M') { $tgl_awal=$bln_kondisi; $tgl_akhir=$last_day_of_month; }else 
			if($kc=='Y') { $tgl_awal=$thn_kondisi; $tgl_akhir=$tgl_kondisi; }
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rp=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumpokok FROM $table_transaksi WHERE 
			id_pinj='$id_pinj' AND rekening_debit='112.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR 
			id_pinj='$id_pinj' AND rekening_debit='113.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR 
			id_pinj='$id_pinj' AND rekening_debit='114.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR 
			id_pinj='$id_pinj' AND rekening_debit='115.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR 
			id_pinj='$id_pinj' AND rekening_debit='116.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR 
			id_pinj='$id_pinj' AND rekening_debit='117.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' "));
			$realisasiinipokok	=$rp['sumpokok'];
			return $realisasiinipokok;
}

function realisasiinijasa($id_buljas) {
			$thn_kondisi   	= substr($id_buljas,0,4)."01-01";
			$bln_kondisi   	= substr($id_buljas,0,7)."-01";
			$tgl_kondisi   	= substr($id_buljas,0,10);
			$last_day_of_month = date('Y-m-t', strtotime($tgl_kondisi));
			$kc				= substr($id_buljas,11,1);
			$id_pinj		= substr($id_buljas,13);
			if($kc=='D') { $tgl_awal=$tgl_kondisi; $tgl_akhir=$tgl_kondisi; }else if($kc=='M') { $tgl_awal=$bln_kondisi; $tgl_akhir=$last_day_of_month; }else if($kc=='Y') { $tgl_awal=$thn_kondisi; $tgl_akhir=$tgl_kondisi; }
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rj=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumjasa FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='113.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='114.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='115.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='116.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='117.02' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir'"));
			$realisasiinijasa	=$rj['sumjasa'];
			return $realisasiinijasa;
}


function realisasimerahpokok($id_bulnikok) {
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$id_pinj		= substr($id_bulnikok,11);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rp=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumpokok FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.01' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.01' AND tgl_transaksi >= '$tgl_kondisi'  OR id_pinj='$id_pinj' AND rekening_debit='114.01' AND tgl_transaksi >= '$tgl_awal' AND tgl_transaksi <= '$tgl_akhir' OR id_pinj='$id_pinj' AND rekening_debit='115.01' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='116.01' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='117.01' AND tgl_transaksi >= '$tgl_kondisi' "));
			$realisasimerahpokok	=$rp['sumpokok'];
			return $realisasimerahpokok;
}

function realisasimerahjasa($id_bulnikok) {
			$tgl_kondisi   	= substr($id_bulnikok,0,10);
			$id_pinj		= substr($id_bulnikok,11);
			
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$rp=mysql_fetch_array(mysql_query("SELECT sum(jumlah) as sumpokok FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.02' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.02' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='114.02' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='115.02' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='116.02' AND tgl_transaksi >= '$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='117.02' AND tgl_transaksi >= '$tgl_kondisi'"));
			$realisasimerahpokok	=$rp['sumpokok'];
			return $realisasimerahpokok;
}

function saldopinjaman($id_saldopinjaman) { //Saldo Pokok
			$tgl_kondisi   	= substr($id_saldopinjaman,0,10);
			$id_pinj		= substr($id_saldopinjaman,11);
			
			$tp=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			$status	=$tp['status'];
			$tgl_lunas	=$tp['tgl_lunas'];
			
			$alokasi		=alokasi($id_pinj);
			$sumpokok		=sumpokok("$tgl_kondisi-$id_pinj");
			$saldo			=$alokasi-$sumpokok;
				if($saldo<=0 OR $status=='R' AND $tgl_lunas<=$tgl_kondisi) { $saldopinjaman="0"; }else{$saldopinjaman=$saldo;}
			return $saldopinjaman;
}

function saldo_jasa($id_saldo_jasa) { //Saldo Jasa
			$tgl_kondisi   	= substr($id_saldo_jasa,0,10);
			$id_pinj		= substr($id_saldo_jasa,11);
			
			$alokasi_jasa	=alokasi_jasa($id_pinj);
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj");
			$saldo_jasa			=$alokasi_jasa-$sumjasa;
			if($saldo_jasa<=0){
			    $saldo_jasa=0;
			}
			return $saldo_jasa;
}

function jangka($id_pinj){
			$dp=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
			
			$jangka		=$dp['jangka'];
			return $jangka;
	}


function adaangsurankah($id_bulanke){ //Dibulan Bersangkutan apakah ada kewajiban angsuran Pokok?
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			
			
			if($dp['sistem_angsuran']==11){
				$tglcair	=$dp['tgl_cair'];
				$tgl_cair	= date('Y-m-d', strtotime('+25 month', strtotime($tglcair)));
				$jangka		= ($dp['jangka'])-24;
			}else if ($dp['sistem_angsuran']==14){
				$tglcair	=$dp['tgl_cair'];
				$tgl_cair	= date('Y-m-d', strtotime('+4 month', strtotime($tglcair)));
				$jangka		= ($dp['jangka'])-3;
			}else if ($dp['sistem_angsuran']==15){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+3 month', strtotime($tglcair))); //m2
			    $jangka		= ($dp['jangka'])-2;
			}else if ($dp['sistem_angsuran']==16){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+13 month', strtotime($tglcair))); //m12
			    $jangka		= ($dp['jangka'])-12;
			}else{
				$tgl_cair	=$dp['tgl_cair'];
				if($tgl_cair=='0000-00-00'){$tgl_cair=$dp['tgl_proposal'];}
				$jangka		=$dp['jangka'];
			}
			$sistem		=$dp['sistem'];
			$tempo		=$jangka/$sistem;
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2015-07-06=2015-08-11=3
			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			if($selisih_bln<1){$sisabagi = $selisih_bln;}else{
			$sisabagi	=$selisih_bln % $sistem; //Bulan YBS ada kewajiban angsuran jika sisa bagi = NOL
			}
			return $sisabagi;
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
	
function bulanke($id_bulanke){
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			
			if($dp['sistem_angsuran']==11){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+25 month', strtotime($tglcair)));
			    $jangka		= ($dp['jangka'])-24;
			}else if ($dp['sistem_angsuran']==14){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+4 month', strtotime($tglcair)));
			    $jangka		= ($dp['jangka'])-3;
			}else if ($dp['sistem_angsuran']==15){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+3 month', strtotime($tglcair))); //m2
			    $jangka		= ($dp['jangka'])-2;
			}else if ($dp['sistem_angsuran']==16){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+13 month', strtotime($tglcair))); //m12
			    $jangka		= ($dp['jangka'])-12;
			}else{
			    $tgl_cair	=$dp['tgl_cair'];
			    $jangka		=$dp['jangka'];
			}
			$sistem		=$dp['sistem'];
			
			$tgl1   	= substr($tgl_cair,8,2); 	 //0123456789-11   16 19  22
			$tgl2   	= substr($id_bulanke,8,2); //2015-07-06=2015-08-11=3
			$bulan1   	= substr($tgl_cair,5,2);
			$bulan2   	= substr($id_bulanke,5,2);
			$tahun1   	= substr($tgl_cair,0,4);
			$tahun2   	= substr($id_bulanke,0,4);
			
			if($tgl2>=$tgl1){$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1);		//Selisih bulan dari tgl cair sampai tglkondisi
			}else{
			$selisih_bln	=(($tahun2-$tahun1)*12)+($bulan2-$bulan1)-1;		//Selisih di bulan angsuran sebelum tanggal cair
			}
			
				
				$selsisih_sistem	=floor(@($selisih_bln/$sistem));	//pada tgl kondisi, sudah wajib bayar ke berapa?
			
			if($sistem=='1') { $bulanke=$selisih_bln; }else{ $bulanke=$selsisih_sistem;}

			return $bulanke;
	}

function jum_nunggak($id_jum_nunggak) {
			$tgl_kondisi   	= substr($id_jum_nunggak,0,10);
			$id_pinj		= substr($id_jum_nunggak,11);
			
			$bulanke		=bulanke($tgl_kondisi."-".$id_pinj);
			$sumpokok		=sumpokok("$tgl_kondisi-$id_pinj");
			$wajibpokokaja	=wajibpokokaja($id_pinj);
			$jum_angs		=floor(@($sumpokok/$wajibpokokaja));
			$jum_nunggak	=$bulanke-$jum_angs;
			
			return $jum_nunggak;
}

function kolek1($id_kolek1) {
			$tgl_kondisi   	= substr($id_kolek1,0,10);
			$id_pinj		= substr($id_kolek1,11);
			$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$id_pinj);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj);
			if ($_SESSION['lokasi']=='209'){ //Khusus Paninggaran Pekalongan
				if ($jum_nunggak < 1){
					$kolek1	=$saldopinjaman; }else{ $kolek1	="0"; }
			}else{
				if ($jum_nunggak <=0){
					$kolek1	=$saldopinjaman; }else{ $kolek1	="0"; }
			}
			return $kolek1;
}

function kolek2($id_kolek2) {
			$tgl_kondisi   	= substr($id_kolek2,0,10);
			$id_pinj		= substr($id_kolek2,11);
			$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$id_pinj);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj);
			if ($_SESSION['lokasi']=='209'){	//Khusus Paninggaran Pekalongan
				if ($jum_nunggak >=1 and $jum_nunggak <=2){
					$kolek2	=$saldopinjaman; }else{ $kolek2	="0"; }
			}else{
				if ($jum_nunggak >0 and $jum_nunggak <=2){
					$kolek2	=$saldopinjaman; }else{ $kolek2	="0"; }
			}
			return $kolek2;
}

function kolek3($id_kolek3) {
			$tgl_kondisi   	= substr($id_kolek3,0,10);
			$id_pinj		= substr($id_kolek3,11);
			$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$id_pinj);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj);
			if ($jum_nunggak >2 and $jum_nunggak <=4){
				$kolek3	=$saldopinjaman; }else{ $kolek3	="0"; }
			return $kolek3;
}

function kolek4($id_kolek4) {
			$tgl_kondisi   	= substr($id_kolek4,0,10);
			$id_pinj		= substr($id_kolek4,11);
			$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$id_pinj);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj);
			if ($jum_nunggak >4 and $jum_nunggak <=6){
				$kolek4	=$saldopinjaman; }else{ $kolek4	="0"; }
			return $kolek4;
}

function kolek5($id_kolek5) {
			$tgl_kondisi   	= substr($id_kolek5,0,10);
			$id_pinj		= substr($id_kolek5,11);
			$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$id_pinj);
			$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$id_pinj);
			if ($jum_nunggak >6){
				$kolek5	=$saldopinjaman; }else{ $kolek5	="0"; }
			return $kolek5;
}

//BY DESA
function alokasiD($id_alokasiD) {
			$tgl_kondisi   	= substr($id_alokasiD,0,10); //2015-01-01=11=1111
			$pchar			= substr($id_alokasiD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_alokasiD,11,2);
			$idd			= substr($id_alokasiD,14);
			}else{
			$idf			= substr($id_alokasiD,11,1);
			$idd			= substr($id_alokasiD,13);	
			}
			$y			= substr($id_alokasiD,0,4);
			$thn_kondisi		="$y-01-01";
			$apk=mysql_fetch_array(mysql_query("select sum(alokasi) AS sumalokasi from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' 
			"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function alokasiDA($id_alokasiDA) { //Rekap Desa Aktif Only
			$tgl_kondisi   	= substr($id_alokasiDA,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_alokasiDA,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_alokasiDA,11,2);
			$idd			= substr($id_alokasiDA,14);
			}else{
			$idf			= substr($id_alokasiDA,11,1);
			$idd			= substr($id_alokasiDA,13);	
			}
			$y			= substr($id_alokasiDA,0,4);
			$thn_kondisi		="$y-01-01";
			$apk=mysql_fetch_array(mysql_query("select sum(alokasi) AS sumalokasi from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' 
			"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function targetpokokD($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);	
			}
			$y				= substr($id_targetpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$sumtarpok		=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' 
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
			$pchar			= substr($targetjasaD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($targetjasaD,11,2);
			$idd			= substr($targetjasaD,14);
			}else{
			$idf			= substr($targetjasaD,11,1);
			$idd			= substr($targetjasaD,13);	
			}
			$y				= substr($targetjasaD,0,4);
			$thn_kondisi	="$y-01-01";
			$sumtarpok		=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' 
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
			$pchar			= substr($sumpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($sumpokokD,11,2);
			$idd			= substr($sumpokokD,14);
			}else{
			$idf			= substr($sumpokokD,11,1);
			$idd			= substr($sumpokokD,13);	
			}
			$y				= substr($sumpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
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
			$pchar			= substr($sumjasaD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($sumjasaD,11,2);
			$idd			= substr($sumjasaD,14);
			}else{
			$idf			= substr($sumjasaD,11,1);
			$idd			= substr($sumjasaD,13);	
			}
			$y				= substr($sumpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select pk.id FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
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
			$pchar			= substr($sumrealpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($sumrealpokokD,11,2);
			$idd			= substr($sumrealpokokD,14);
			}else{
			$idf			= substr($sumrealpokokD,11,1);
			$idd			= substr($sumrealpokokD,13);	
			}
			$y				= substr($sumrealpokokD,0,4);
			$sumrealpokok	=0;
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' 
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
			$pchar			= substr($sumrealjasaD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($sumrealjasaD,11,2);
			$idd			= substr($sumrealjasaD,14);
			}else{
			$idf			= substr($sumrealjasaD,11,1);
			$idd			= substr($sumrealjasaD,13);	
			}
			$y				= substr($sumrealjasaD,0,4);
			$thn_kondisi	="$y-01-01";
			$sumrealjasa 	=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
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
			$pchar			= substr($saldopinjamanD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($saldopinjamanD,11,2);
			$idd			= substr($saldopinjamanD,14);
			}else{
			$idf			= substr($saldopinjamanD,11,1);
			$idd			= substr($saldopinjamanD,13);	
			}
			$y				= substr($saldopinjamanD,0,4);
			$thn_kondisi	="$y-01-01";
			$saldopinjaman	=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
			
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
			$pchar			= substr($nunggakpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($nunggakpokokD,11,2);
			$idd			= substr($nunggakpokokD,14);
			}else{
			$idf			= substr($nunggakpokokD,11,1);
			$idd			= substr($nunggakpokokD,13);	
			}
			$y				= substr($nunggakpokokD,0,4);
			$thn_kondisi	="$y-01-01";
			$nunggakpokok	=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
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
			$pchar			= substr($nunggakjasaD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($nunggakjasaD,11,2);
			$idd			= substr($nunggakjasaD,14);
			}else{
			$idf			= substr($nunggakjasaD,11,1);
			$idd			= substr($nunggakjasaD,13);	
			}
			$y				= substr($nunggakjasaD,0,4);
			$nunggakjasa	=0;
			$thn_kondisi	="$y-01-01";
			$tpk=mysql_query("select pk.id, pk.tgl_lunas, pk.`status` from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
			");
		while($row=mysql_fetch_array($tpk)){
			$idp		=$row['id'];
			$tgl_lunas	=$row['tgl_lunas'];
			$status		=$row['status'];
			$tarjas		=nunggakjasa("$tgl_kondisi-$idp");
				 if($tgl_lunas<=$tgl_kondisi and $status=="L") { 
			    $tarpok = "0";	
				 } else if($tgl_lunas<=$tgl_kondisi and $status=="R") { 
				$tarpok = "0";			  
				 } else if($tgl_lunas<=$tgl_kondisi and $status=="H") { 
				$tarpok = "0";		  
				 }else{ 
				$tarpok	= $tarjas;
				 }
			$nunggakjasa=$nunggakjasa+$tarpok;
			}
		 return $nunggakjasa;
}

function kolek1D($id_kolek1D) {
			$tgl_kondisi   	= substr($id_kolek1D,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_kolek1D,0,4); //2015
			$pchar			= substr($id_kolek1D,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek1D,11,2);
			$idd			= substr($id_kolek1D,14);
			}else{
			$idf			= substr($id_kolek1D,11,1);
			$idd			= substr($id_kolek1D,13);	
			}
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek1("$tgl_kondisi-$idp");
			$kolek1=$kolek1+$tarpok;
			}
		 return $kolek1;
}

function kolek2D($id_kolek2D) {
			$tgl_kondisi   	= substr($id_kolek2D,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_kolek2D,0,4); //2015
			$pchar			= substr($id_kolek2D,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek2D,11,2);
			$idd			= substr($id_kolek2D,14);
			}else{
			$idf			= substr($id_kolek2D,11,1);
			$idd			= substr($id_kolek2D,13);	
			}
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek2("$tgl_kondisi-$idp");
			$kolek2=$kolek2+$tarpok;
			}
		 return $kolek2;
}

function kolek3D($id_kolek3D) {
			$tgl_kondisi   	= substr($id_kolek3D,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_kolek3D,0,4); //2015
			$pchar			= substr($id_kolek3D,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek3D,11,2);
			$idd			= substr($id_kolek3D,14);
			}else{
			$idf			= substr($id_kolek3D,11,1);
			$idd			= substr($id_kolek3D,13);	
			}
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek3("$tgl_kondisi-$idp");
			$kolek3=$kolek3+$tarpok;
			}
		 return $kolek3;
}

function kolek4D($id_kolek4D) {
			$tgl_kondisi   	= substr($id_kolek4D,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_kolek4D,0,4); //2015
			$pchar			= substr($id_kolek4D,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek4D,11,2);
			$idd			= substr($id_kolek4D,14);
			}else{
			$idf			= substr($id_kolek4D,11,1);
			$idd			= substr($id_kolek4D,13);	
			}
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=kolek4("$tgl_kondisi-$idp");
			$kolek4=$kolek4+$tarpok;
			}
		 return $kolek4;
}

function kolek5D($id_kolek5D) {
			$tgl_kondisi   	= substr($id_kolek5D,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_kolek5D,0,4); //2015
			$pchar			= substr($id_kolek5D,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek5D,11,2);
			$idd			= substr($id_kolek5D,14);
			}else{
			$idf			= substr($id_kolek5D,11,1);
			$idd			= substr($id_kolek5D,13);	
			}
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
								
				while($row=mysql_fetch_array($tpk)){
			$idp5	=$row['id'];
			$tarpok5	=kolek5("$tgl_kondisi-$idp5");
			$kolek5=$kolek5+$tarpok5;
			}
		 return $kolek5;
}

//SUM KOLEK

function sumkolek1($id_sumkolek1) {
			$tgl_kondisi   	= substr($id_sumkolek1,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_sumkolek1,0,4); //2015
			$pchar			= substr($id_sumkolek1,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumkolek1,11,2);
			}else{
			$idf			= substr($id_sumkolek1,11,1);
			}
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek1	=kolek1("$tgl_kondisi-$idp");
			$sumkolek1=$sumkolek1+$kolek1;
			}
		 return $sumkolek1;
}

function sumkolek2($id_sumkolek2) {
			$tgl_kondisi   	= substr($id_sumkolek2,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_sumkolek2,0,4); //2015
			$pchar			= substr($id_sumkolek2,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumkolek2,11,2);
			}else{
			$idf			= substr($id_sumkolek2,11,1);
			}
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek2	=kolek2("$tgl_kondisi-$idp");
			$sumkolek2=$sumkolek2+$kolek2;
			}
		 return $sumkolek2;
}

function sumkolek3($id_sumkolek3) {
			$tgl_kondisi   	= substr($id_sumkolek3,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_sumkolek3,0,4); //2015
			$pchar			= substr($id_sumkolek3,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumkolek3,11,2);
			}else{
			$idf			= substr($id_sumkolek3,11,1);
			}
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek3	=kolek3("$tgl_kondisi-$idp");
			$sumkolek3=$sumkolek3+$kolek3;
			}
		 return $sumkolek3;
}

function sumkolek4($id_sumkolek4) {
			$tgl_kondisi   	= substr($id_sumkolek4,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_sumkolek4,0,4); //2015
			$pchar			= substr($id_sumkolek4,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumkolek4,11,2);
			}else{
			$idf			= substr($id_sumkolek4,11,1);
			}
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek4	=kolek4("$tgl_kondisi-$idp");
			$sumkolek4=$sumkolek4+$kolek4;
			}
		 return $sumkolek4;
}

function sumkolek5($id_sumkolek5) {
			$tgl_kondisi   	= substr($id_sumkolek5,0,10); //2015-01-01=1=1111
			$thn_kondisi   	= substr($id_sumkolek5,0,4); //2015
			$pchar			= substr($id_sumkolek5,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumkolek5,11,2);
			}else{
			$idf			= substr($id_sumkolek5,11,1);
			}
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
								k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$_SESSION[lokasi]' AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$kolek5	=kolek5("$tgl_kondisi-$idp");
			$sumkolek5=$sumkolek5+$kolek5;
			}
		 return $sumkolek5;
}

if ($_SESSION['lokasi']=='96') { //khusus KEBUMEN
function totCR($id_totCR) {
			$tgl_kondisi   	= substr($id_totCR,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_totCR,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_totCR,11,2);
			}else{
			$idf			= substr($id_totCR,11,1);
			}

			$sumcr1		=(sumkolek1("$tgl_kondisi-$idf"))*1/100;
			$sumcr2		=(sumkolek2("$tgl_kondisi-$idf"))*10/100;
			$sumcr3		=(sumkolek3("$tgl_kondisi-$idf"))*15/100;
			$sumcr4		=(sumkolek4("$tgl_kondisi-$idf"))*25/100;
			$sumcr5		=(sumkolek5("$tgl_kondisi-$idf"))*100/100;
			$totCR		=$sumcr1+$sumcr2+$sumcr3+$sumcr4+$sumcr5;
			
		 return $totCR;
}}else{
function totCR($id_totCR) {
			$tgl_kondisi   	= substr($id_totCR,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_totCR,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_totCR,11,2);
			}else{
			$idf			= substr($id_totCR,11,1);
			}

			$sumcr1		=(sumkolek1("$tgl_kondisi-$idf"))*1/100;
			$sumcr2		=(sumkolek2("$tgl_kondisi-$idf"))*10/100;
			$sumcr3		=(sumkolek3("$tgl_kondisi-$idf"))*25/100;
			$sumcr4		=(sumkolek4("$tgl_kondisi-$idf"))*50/100;
			$sumcr5		=(sumkolek5("$tgl_kondisi-$idf"))*100/100;
			$totCR		=$sumcr1+$sumcr2+$sumcr3+$sumcr4+$sumcr5;
			
		 return $totCR;	
}}


function aloAD($id_aloAD) {
			$tgl_kondisi   	= substr($id_aloAD,0,10); //2015-01-01=11=1111
			$pchar			= substr($id_aloAD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_aloAD,11,2);
			$idd			= substr($id_aloAD,14);
			}else{
			$idf			= substr($id_aloAD,11,1);
			$idd			= substr($id_aloAD,13);	
			}
			$y			= substr($id_aloAD,0,4);
			$m			= substr($id_aloAD,5,2);
			$d			= substr($id_aloAD,8,2);
if		($d!="00")	{$tgl_sql="tgl_cair=$tgl_kondisi";}
elseif	($m!="00")	{$tgl_sql="month(pk.tgl_cair) = '$m' AND year(pk.tgl_cair) = '$y'";}
elseif	($y!="00")	{$tgl_sql="year(pk.tgl_cair) = '$y'";}
else				{$tgl_sql="1=1";}
			$apk=mysql_fetch_array(mysql_query("select sum(alokasi) AS sumalokasi 
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$idd' AND jenis_pp='$idf'  AND $tgl_sql AND pk.`status`='A'"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function PropAD($id_PropAD) {
			$tgl_kondisi   	= substr($id_PropAD,0,10); //2015-01-01=11=1111
			$pchar			= substr($id_PropAD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_PropAD,11,2);
			$idd			= substr($id_PropAD,14);
			}else{
			$idf			= substr($id_PropAD,11,1);
			$idd			= substr($id_PropAD,13);	
			}
			$y			= substr($id_PropAD,0,4);
			$m			= substr($id_PropAD,5,2);
			$d			= substr($id_PropAD,8,2);
if		($d!="00")	{$tgl_sql="tgl_cair=$tgl_kondisi";}
elseif	($m!="00")	{$tgl_sql="month(pk.tgl_cair) = '$m' AND year(pk.tgl_cair) = '$y'";}
elseif	($y!="00")	{$tgl_sql="year(pk.tgl_cair) = '$y'";}
else				{$tgl_sql="1=1";}
			$apk=mysql_fetch_array(mysql_query("select sum(proposal) AS sumalokasi 
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$idd' AND jenis_pp='$idf'  AND $tgl_sql AND pk.`status`='A'"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function aloAC($id_aloAD) {
			$tgl_kondisi   	= substr($id_aloAD,0,10); //2015-01-01=11=1111
			$pchar			= substr($id_aloAD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_aloAD,11,2);
			$idd			= substr($id_aloAD,14);
			}else{
			$idf			= substr($id_aloAD,11,1);
			$idd			= substr($id_aloAD,13);	
			}
			$y			= substr($id_aloAD,0,4);
			$m			= substr($id_aloAD,5,2);
			$d			= substr($id_aloAD,8,2);
if		($d!="00")	{$tgl_sql="tgl_cair=$tgl_kondisi";}
elseif	($m!="00")	{$tgl_sql="month(pk.tgl_cair) = '$m' AND year(pk.tgl_cair) = '$y'";}
elseif	($y!="00")	{$tgl_sql="year(pk.tgl_cair) = '$y'";}
else				{$tgl_sql="1=1";}
			$apk=mysql_fetch_array(mysql_query("select sum(alokasi) AS sumalokasi 
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.lokasi='$_SESSION[lokasi]' AND jenis_pp='$idf'  AND $tgl_sql AND pk.`status`='A'"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function PropAC($id_PropAD) {
			$tgl_kondisi   	= substr($id_PropAD,0,10); //2015-01-01=11=1111
			$pchar			= substr($id_PropAD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_PropAD,11,2);
			$idd			= substr($id_PropAD,14);
			}else{
			$idf			= substr($id_PropAD,11,1);
			$idd			= substr($id_PropAD,13);	
			}
			$y			= substr($id_PropAD,0,4);
			$m			= substr($id_PropAD,5,2);
			$d			= substr($id_PropAD,8,2);
if		($d!="00")	{$tgl_sql="tgl_cair=$tgl_kondisi";}
elseif	($m!="00")	{$tgl_sql="month(pk.tgl_cair) = '$m' AND year(pk.tgl_cair) = '$y'";}
elseif	($y!="00")	{$tgl_sql="year(pk.tgl_cair) = '$y'";}
else				{$tgl_sql="1=1";}
			$apk=mysql_fetch_array(mysql_query("select sum(proposal) AS sumalokasi 
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.lokasi='$_SESSION[lokasi]' AND jenis_pp='$idf'  AND $tgl_sql AND pk.`status`='A'"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

//KESEHATAN
function sumnunggakpokok($id_sumnunggakpokok) {
			$tgl_kondisi   	= substr($id_sumnunggakpokok,0,10); //2015-01-01=1=1111
			
			if ($_SESSION['lokasi']=='68') { $kecuali="AND pk.jenis_pp!='3' "; }else{ $kecuali=""; } //Khusus Sariwangi Tasikmalaya
			$data=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE k.id=pk.id_kel AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi' AND k.lokasi='$_SESSION[lokasi]'  AND pk.status='A' $kecuali ");
				while($row=mysql_fetch_array($data)){
			$idp	=$row['id'];
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$idp");
			$sumnunggakpokok=$sumnunggakpokok+$nunggakpokok;
			}
		 return $sumnunggakpokok;
}

function sumsaldopinjaman($id_sumsaldopinjaman) {
			$tgl_kondisi   	= substr($id_sumsaldopinjaman,0,10); //2015-01-01=1=1111
			$view=mysql_query("select kd_rr from rekening_riil WHERE kd_rr='P' ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' AND lokasi='0' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
			while($r=mysql_fetch_array($data)){
				
				$saldo_aktiva=saldo("$tgl_kondisi-".$r['kd_jb']);			
			$sumsaldopinjaman=$sumsaldopinjaman+$saldo_aktiva;
							}
			}
		 return $sumsaldopinjaman;
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
			$pchar			= substr($id_alokasiC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_alokasiC,11,2);
			$idc			= substr($id_alokasiC,14);
			}else{
			$idf			= substr($id_alokasiC,11,1);
			$idc			= substr($id_alokasiC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$alokasiD	=alokasiD("$tgl_kondisi-$idf-$row[id]");
			$alokasiC=$alokasiC+$alokasiD;
			}
		 return $alokasiC;
}

function targetpokokC($id_targetpokokC) {
			$tgl_kondisi   	= substr($id_targetpokokC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokC,11,2);
			$idc			= substr($id_targetpokokC,14);
			}else{
			$idf			= substr($id_targetpokokC,11,1);
			$idc			= substr($id_targetpokokC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$targetpokokD	=targetpokokD("$tgl_kondisi-$idf-$row[id]");
			$targetpokokC=$targetpokokC+$targetpokokD;
			}
		 return $targetpokokC;
}

function targetjasaC($id_targetjasaC) {
			$tgl_kondisi   	= substr($id_targetjasaC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetjasaC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetjasaC,11,2);
			$idc			= substr($id_targetjasaC,14);
			}else{
			$idf			= substr($id_targetjasaC,11,1);
			$idc			= substr($id_targetjasaC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$targetjasaD	=targetjasaD("$tgl_kondisi-$idf-$row[id]");
			$targetjasaC=$targetjasaC+$targetjasaD;
			}
		 return $targetjasaC;
}

function sumrealpokokC($id_sumrealpokokC) {
			$tgl_kondisi   	= substr($id_sumrealpokokC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_sumrealpokokC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumrealpokokC,11,2);
			$idc			= substr($id_sumrealpokokC,14);
			}else{
			$idf			= substr($id_sumrealpokokC,11,1);
			$idc			= substr($id_sumrealpokokC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$sumrealpokokD	=sumrealpokokD("$tgl_kondisi-$idf-$row[id]");
			$sumrealpokokC=$sumrealpokokC+$sumrealpokokD;
			}
		 return $sumrealpokokC;
}

function sumrealjasaC($id_sumrealjasaC) {
			$tgl_kondisi   	= substr($id_sumrealjasaC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_sumrealjasaC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_sumrealjasaC,11,2);
			$idc			= substr($id_sumrealjasaC,14);
			}else{
			$idf			= substr($id_sumrealjasaC,11,1);
			$idc			= substr($id_sumrealjasaC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$sumrealjasaD	=sumrealjasaD("$tgl_kondisi-$idf-$row[id]");
			$sumrealjasaC=$sumrealjasaC+$sumrealjasaD;
			}
		 return $sumrealjasaC;
}

function saldopinjamanC($id_saldopinjamanC) {
			$tgl_kondisi   	= substr($id_saldopinjamanC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_saldopinjamanC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_saldopinjamanC,11,2);
			$idc			= substr($id_saldopinjamanC,14);
			}else{
			$idf			= substr($id_saldopinjamanC,11,1);
			$idc			= substr($id_saldopinjamanC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$saldopinjamanD	=saldopinjamanD("$tgl_kondisi-$idf-$row[id]");
			$saldopinjamanC=$saldopinjamanC+$saldopinjamanD;
			}
		 return $saldopinjamanC;
}


function proskembaliC($id_proskembaliC) {
			$tgl_kondisi   	= substr($id_proskembaliC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_proskembaliC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_proskembaliC,11,2);
			$idc			= substr($id_proskembaliC,14);
			}else{
			$idf			= substr($id_proskembaliC,11,1);
			$idc			= substr($id_proskembaliC,13);
			}

			$sumrealpokokC	=sumrealpokokC("$tgl_kondisi-$idf-$idc");
			$targetpokokC	=targetpokokC("$tgl_kondisi-$idf-$idc");
			$proskembaliC=@($sumrealpokokC/$targetpokokC*100);
			
		 return $proskembaliC;
}

function nunggakpokokC($id_nunggakpokokC) {
			$tgl_kondisi   	= substr($id_nunggakpokokC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_nunggakpokokC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_nunggakpokokC,11,2);
			$idc			= substr($id_nunggakpokokC,14);
			}else{
			$idf			= substr($id_nunggakpokokC,11,1);
			$idc			= substr($id_nunggakpokokC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$nunggakpokokD	=nunggakpokokD("$tgl_kondisi-$idf-$row[id]");
			$nunggakpokokC=$nunggakpokokC+$nunggakpokokD;
			}
		 return $nunggakpokokC;
}

function nunggakjasaC($id_nunggakjasaC) {
			$tgl_kondisi   	= substr($id_nunggakjasaC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_nunggakjasaC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_nunggakjasaC,11,2);
			$idc			= substr($id_nunggakjasaC,14);
			}else{
			$idf			= substr($id_nunggakjasaC,11,1);
			$idc			= substr($id_nunggakjasaC,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$nunggakjasaD	=nunggakjasaD("$tgl_kondisi-$idf-$row[id]");
			$nunggakjasaC=$nunggakjasaC+$nunggakjasaD;
			}
		 return $nunggakjasaC;
}

function kolek1C($id_kolek1C) {
			$tgl_kondisi   	= substr($id_kolek1C,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_kolek1C,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek1C,11,2);
			$idc			= substr($id_kolek1C,14);
			}else{
			$idf			= substr($id_kolek1C,11,1);
			$idc			= substr($id_kolek1C,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek1D	=kolek1D("$tgl_kondisi-$idf-$row[id]");
			$kolek1C=$kolek1C+$kolek1D;
			}
		 return $kolek1C;
}

function kolek2C($id_kolek2C) {
			$tgl_kondisi   	= substr($id_kolek2C,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_kolek2C,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek2C,11,2);
			$idc			= substr($id_kolek2C,14);
			}else{
			$idf			= substr($id_kolek2C,11,1);
			$idc			= substr($id_kolek2C,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek2D	=kolek2D("$tgl_kondisi-$idf-$row[id]");
			$kolek2C=$kolek2C+$kolek2D;
			}
		 return $kolek2C;
}

function kolek3C($id_kolek3C) {
			$tgl_kondisi   	= substr($id_kolek3C,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_kolek3C,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek3C,11,2);
			$idc			= substr($id_kolek3C,14);
			}else{
			$idf			= substr($id_kolek3C,11,1);
			$idc			= substr($id_kolek3C,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek3D	=kolek3D("$tgl_kondisi-$idf-$row[id]");
			$kolek3C=$kolek3C+$kolek3D;
			}
		 return $kolek3C;
}

function kolek4C($id_kolek4C) {
			$tgl_kondisi   	= substr($id_kolek4C,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_kolek4C,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek4C,11,2);
			$idc			= substr($id_kolek4C,14);
			}else{
			$idf			= substr($id_kolek4C,11,1);
			$idc			= substr($id_kolek4C,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek4D	=kolek4D("$tgl_kondisi-$idf-$row[id]");
			$kolek4C=$kolek4C+$kolek4D;
			}
		 return $kolek4C;
}

function kolek5C($id_kolek5C) {
			$tgl_kondisi   	= substr($id_kolek5C,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_kolek5C,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_kolek5C,11,2);
			$idc			= substr($id_kolek5C,14);
			}else{
			$idf			= substr($id_kolek5C,11,1);
			$idc			= substr($id_kolek5C,13);
			}
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$kolek5D	=kolek5D("$tgl_kondisi-$idf-$row[id]");
			$kolek5C=$kolek5C+$kolek5D;
			}
		 return $kolek5C;
}


//KECAMATAN LALU
function alokasiCL($id_alokasiCL) {
			$tgl_kondisi   	= substr($id_alokasiCL,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_alokasiCL,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_alokasiCL,11,2);
			$idc			= substr($id_alokasiCL,14);
			}else{
			$idf			= substr($id_alokasiCL,11,1);
			$idc			= substr($id_alokasiCL,13);
			}
			
			$apk=mysql_fetch_array(mysql_query("SELECT sum(alokasi) AS sumalokasi FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function targetpokokCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetpokok("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function targetjasaCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetjasa("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function sumrealpokokCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumpokok("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function sumrealjasaCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumjasa("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function saldopinjamanCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$saldopinjaman		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=saldopinjaman("$tgl_kondisi-$idp");
			$saldopinjaman=$saldopinjaman+$tarpok;
			}
		 return $saldopinjaman;
}

function nunggakpokokCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakpokok("$tgl_kondisi-$idp");
			$saldopinjaman=$sumtarpok+$tarpok;
			}
		 return $saldopinjaman;
}

function nunggakjasaCL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idc			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idc			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.lokasi='$idc' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakjasa("$tgl_kondisi-$idp");
			$saldopinjaman=$sumtarpok+$tarpok;
			}
		 return $saldopinjaman;
}

//DESA LALU
function alokasiDL($id_alokasiCL) {
			$tgl_kondisi   	= substr($id_alokasiCL,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_alokasiCL,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_alokasiCL,11,2);
			$idd			= substr($id_alokasiCL,14);
			}else{
			$idf			= substr($id_alokasiCL,11,1);
			$idd			= substr($id_alokasiCL,13);
			}
			
			$apk=mysql_fetch_array(mysql_query("SELECT sum(alokasi) AS sumalokasi FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			"));
			$sumalokasi	=$apk['sumalokasi'];
		 return $sumalokasi;
}

function targetpokokDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetpokok("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function targetjasaDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=targetjasa("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function sumrealpokokDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumpokok("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function sumrealjasaDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=sumjasa("$tgl_kondisi-$idp");
			$sumtarpok=$sumtarpok+$tarpok;
			}
		 return $sumtarpok;
}

function saldopinjamanDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$saldopinjaman		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=saldopinjaman("$tgl_kondisi-$idp");
			$saldopinjaman=$saldopinjaman+$tarpok;
			}
		 return $saldopinjaman;
}

function nunggakpokokDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakpokok("$tgl_kondisi-$idp");
			$saldopinjaman=$sumtarpok+$tarpok;
			}
		 return $saldopinjaman;
}

function nunggakjasaDL($id_targetpokokD) {
			$tgl_kondisi   	= substr($id_targetpokokD,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_targetpokokD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_targetpokokD,11,2);
			$idd			= substr($id_targetpokokD,14);
			}else{
			$idf			= substr($id_targetpokokD,11,1);
			$idd			= substr($id_targetpokokD,13);
			}
			$sumtarpok		=0;

			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_cair >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.status='L'
			");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$tarpok	=nunggakjasa("$tgl_kondisi-$idp");
			$saldopinjaman=$sumtarpok+$tarpok;
			}
		 return $saldopinjaman;
}


function penghapusan($id_hapus) {	//TARGET POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_hapus,0,10);
			$id_pinj		= substr($id_hapus,11);
			$tp=mysql_fetch_array(mysql_query("select * from transaksi_$_SESSION[lokasi] t WHERE t.id_pinj='$id_pinj'  ORDER BY idt DESC"));
			$hapus			= $tp['jumlah'];
		 return $hapus;
}

function penghapusanD($id_hapusD) {
			$tgl_kondisi   	= substr($id_hapusD,0,10); //2015-01-01=idf=idd
			$pchar			= substr($id_hapusD,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_hapusD,11,2);
			$idd			= substr($id_hapusD,14);
			}else{
			$idf			= substr($id_hapusD,11,1);
			$idd			= substr($id_hapusD,13);	
			}
			$y				= substr($id_hapusD,0,4);
			$thn_kondisi	="$y-01-01";
			$sumhapus		=0;
			$tpk=mysql_query("select pk.id from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
			k.id=pk.id_kel AND pk.jenis_pp='$idf' AND k.desa='$idd' AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'");
				while($row=mysql_fetch_array($tpk)){
			$idp	=$row['id'];
			$hapus	=penghapusan("$tgl_kondisi-$idp");
			$sumhapus=$sumhapus+$hapus;
			}
		 return $sumhapus;
}

function penghapusanC($id_hapusC) {
			$tgl_kondisi   	= substr($id_hapusC,0,10); //2015-01-01=1=1111
			$pchar			= substr($id_hapusC,12,1);
			if($pchar=="1" OR $pchar=="2" OR $pchar=="3" OR $pchar=="4" OR $pchar=="5" OR $pchar=="6" OR $pchar=="7" OR $pchar=="8" OR $pchar=="9" OR $pchar=="0" ){
			$idf			= substr($id_hapusC,11,2);
			$idc			= substr($id_hapusC,14);
			}else{
			$idf			= substr($id_hapusC,11,1);
			$idc			= substr($id_hapusC,13);
			}
			$hapusC			=0;
			$data=mysql_query("SELECT id FROM desa WHERE kd_kec='$idc' ");
				while($row=mysql_fetch_array($data)){
			$hapusD			=penghapusanD("$tgl_kondisi-$idf-$row[id]");
			$hapusC=$hapusC+$hapusD;
			}
		 return $hapusC;
}
?>