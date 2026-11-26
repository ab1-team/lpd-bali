<?php 

/* -- Tunggakan -- */

function wajibpokokaja($id_pinj,$id,$table_pk) 
{	//KEWAJIBAN POKOK KELOMPOK
	$wp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, ".$table_pk." pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
	$alokasi	=$wp['alokasi'];
	$jangka		=$wp['jangka'];
	$sistem		=$wp['sistem'];
	$tempo		=@($jangka/$sistem);
	$wajibpokokaja	=bulatkan(@($alokasi/$tempo),$id);

	return $wajibpokokaja;
}

function wajibjasa($id_wajibjasa,$id,$table_pk) {	//KEWAJIBAN JASA DIBULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_wajibjasa,0,10);
			$id_pinj		= substr($id_wajibjasa,11);
			$wj=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, ".$table_pk." pk WHERE pk.sistem_angsuran=sa.id AND pk.id='$id_pinj' "));
			$alokasi	=$wj['alokasi'];
			$pros_jasa	=$wj['pros_jasa'];
			$jangka		=$wj['jangka'];
			$sistem		=$wj['sistem'];
			$tempo		=@($jangka/$sistem);

			$angsjasa	=bulatkan($alokasi*($pros_jasa/100),$id);
			$angs_jasa	=$angsjasa*$sistem;
			$ke			=angsuranke("$tgl_kondisi-$id_pinj",$id,$table_pk);
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

function targetjasa($id_targetjasa,$id,$table_pk) {	//TARGET JASA S.D. BULAN BERSANGKUTAN
	
			$tgl_kondisi   	= substr($id_targetjasa,0,10);
			$id_pinj		= substr($id_targetjasa,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, ".$table_pk." pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));

			
			$alokasi		=$tp['alokasi'];
			$sistem		=$tp['sistem'];
			$jangka		=$tp['jangka'];
			$tempo				=@($jangka/$sistem);
			$pros_jasa		=$tp['pros_jasa'];
			$jenis_jasa		=$tp['jenis_jasa'];
			$wajibjasa		=wajibjasa("$tgl_kondisi-$id_pinj",$id,$table_pk);
			$wapok			=wajibpokokaja("$id_pinj",$id,$table_pk);
			$ke				=angsuranke("$tgl_kondisi-$id_pinj",$id,$table_pk);
			
			if($ke<$tempo) {
				$targetjasa1	=$wajibjasa*$ke;
			}elseif($ke>=$tempo){
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}else{
				$targetjasa1	=($alokasi*($pros_jasa/100))*$jangka;
			}
			
			$targetjasa2 = null;
			
			for($j=1;$j<=$ke;$j++) {
				$saldo=$alokasi-($wapok*($j-1));
				$targetjasan		=$saldo*($pros_jasa/100);
				$targetjasa2		=$targetjasa2+$targetjasan;
			}
			
			if ($jenis_jasa==1){$bayar_jasa=$targetjasa1;}else if ($jenis_jasa==2) {$bayar_jasa=bulatkan($targetjasa2);} else{$bayar_jasa=$targetjasa1;}
			
			//$bulat_jasa=bulatkan($bayar_jasa);
			
				
		 return $bayar_jasa;	 
			
}


function sumpokok($id_sumpokok,$id) {
			$tgl_kondisi   	= substr($id_sumpokok,0,10);
			$id_pinj		= substr($id_sumpokok,11);
			$table_transaksi	="transaksi_".$id;
			$sp=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumpokok FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.01' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.01' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='115.01' AND tgl_transaksi<='$tgl_kondisi'"));
			$sumpokok	=$sp['sumpokok'];
			return $sumpokok;
}

function angsuranke($id_angsuranke,$id,$table_pk){
			$tgl_kondisi   	= substr($id_angsuranke,0,10);
			$id_pinj		= substr($id_angsuranke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, ".$table_pk." pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			$kec=mysql_fetch_array(mysql_query("select * from kecamatan c, jenis_toleransi jt WHERE c.tgl_toleransi=jt.id_toleransi AND c.id=".$id));
			
			$id_toleransi	=$kec['id_toleransi'];
			$role_query		=$kec['role_query'];
			
			$tglcairA	=$dp['tgl_cair']; //Tanggal Cair Normal
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


function sumjasa($id_sumjasa,$id,$table_pk) {
			$tgl_kondisi   	= substr($id_sumjasa,0,10);
			$id_pinj		= substr($id_sumjasa,11);
			$table_transaksi	="transaksi_".$id;
			$sj=mysql_fetch_array(mysql_query("SELECT *, sum(jumlah) as sumjasa FROM $table_transaksi WHERE id_pinj='$id_pinj' AND rekening_debit='112.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='113.02' AND tgl_transaksi<='$tgl_kondisi' OR id_pinj='$id_pinj' AND rekening_debit='115.02' AND tgl_transaksi<='$tgl_kondisi'"));
			$sumjasa	=$sj['sumjasa'];
			return $sumjasa;
}

function bulatkan($angka,$id) {
		 $row=mysql_fetch_array(mysql_query("select *, length(pembulatan) as panjang from kecamatan WHERE id=".$id));
		 
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

function targetpokok($id_targetpokok,$id,$table_pk) {	//TARGET POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_targetpokok,0,10);
			$id_pinj		= substr($id_targetpokok,11);
			$tp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, ".$table_pk." pk WHERE sa.id=pk.sistem_angsuran AND pk.id='$id_pinj' "));
			$tgl_cair	=$tp['tgl_cair'];
			$alokasi	=$tp['alokasi'];
			$pros_jasa	=$tp['pros_jasa'];
			$jangka		=$tp['jangka'];
			$sistem		=$tp['sistem'];
			$tempo		=@($jangka/$sistem);
			$angs_pokok	=bulatkan(@($alokasi/$tempo),$id);
			$ke			=angsuranke("$tgl_kondisi-$id_pinj",$id,$table_pk);
			$wajibpokok	=$angs_pokok*(@($ke/$ke));
			$sumpokok	=sumpokok("$tgl_kondisi-$id_pinj",$id);
			if($ke<$tempo) {
			$targetpokok	=$wajibpokok*$ke;
			}elseif($ke>=$tempo){
			$targetpokok	=$alokasi;
			}

		 return $targetpokok;
}

function nunggakpokok($id_nunggakpokok,$id,$table_pk) {	//TUNGGAKAN POKOK S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakpokok,0,10);
			$id_pinj		= substr($id_nunggakpokok,11);
			
			$targetpokok		=targetpokok("$tgl_kondisi-$id_pinj",$id,$table_pk);
			$sumpokok			=sumpokok("$tgl_kondisi-$id_pinj",$id);
			$nunggakp			=$targetpokok-$sumpokok;
			if($nunggakp<0) { $nunggakpokok="0"; }else{ $nunggakpokok=$nunggakp; }

		 return $nunggakpokok;
}

function nunggakjasa($id_nunggakjasa,$id,$table_pk) {	//TUNGGAKAN JASA S.D. BULAN BERSANGKUTAN
			$tgl_kondisi   	= substr($id_nunggakjasa,0,10);
			$id_pinj		= substr($id_nunggakjasa,11);
			
			$st=mysql_fetch_array(mysql_query("SELECT * FROM ".$table_pk." WHERE id='$id_pinj' "));
			$status=$st['status'];
			$tgl_lunas=$st['tgl_lunas'];

			$targetjasa		=targetjasa("$tgl_kondisi-$id_pinj",$id,$table_pk);
			$sumjasa		=sumjasa("$tgl_kondisi-$id_pinj",$id,$table_pk);
			$nunggakj			=$targetjasa-$sumjasa;
			if($nunggakj<=0 OR $status=="L" AND $tgl_lunas<$tgl_kondisi ) { $nunggakjasa="0"; } else{ $nunggakjasa=$nunggakj; }

		 return $nunggakjasa;
}
?>