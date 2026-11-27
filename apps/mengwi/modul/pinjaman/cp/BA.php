<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";		 
function tanggal($date, $id){
    $tambah = "+$id month";
    $tgl2    = date('Y-m-d', strtotime($tambah, strtotime($date))); 
    return $tgl2; 
}

function sistem($id){
    $row=mysql_fetch_array(mysql_query("SELECT * FROM `sistem_angsuran` WHERE id=$id"));
    $ds="$row[sistem]";
    return $ds; 
}

function adajasa($id_bulanke){ //Dibulan Bersangkutan apakah ada kewajiban angsuran Pokok?
			$tgl_kondisi   	= substr($id_bulanke,0,10);
			$id_pinj		= substr($id_bulanke,11);
			$dp=mysql_fetch_array(mysql_query("select * from sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sa_jasa AND pk.id='$id_pinj' "));
			
			
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
			}else if ($dp['sistem_angsuran']==20){
				$tglcair	=$dp['tgl_cair'];
			    $tgl_cair	= date('Y-m-d', strtotime('+13 month', strtotime($tglcair))); //m2
			    $jangka		= ($dp['jangka'])-12;
			}else{
				$tgl_cair	=$dp['tgl_cair'];
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


?>

<table border=1>
    <tr>
        <td>
            id
        </td>
        <td>
            loan_id
        </td>
        <td>
            angsuran_ke
        </td>
        <td>
            jadwal_tanggal_jatuh_tempo
        </td>
        <td>
            target_pokok
        </td>
        <td>
            target_jasa
        </td>
        <td>
            sistem_angsuran
        </td>
        <td>
            sa_jasa
        </td>
    </tr>
    <?php
		$rcp=$_GET['rcp'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_1 pk WHERE pk.id='$rcp'"));
			$sa_pokok			=sistem($row['sistem_angsuran']);
			$sa_jasa			=sistem($row['sa_jasa']);
            if ($sa_pokok>=$sa_jasa) {$sistem=$sa_jasa;}elseif ($sa_jasa>$sa_pokok) {$sistem=$sa_pokok;}
			$tempo				=$jangka/$sistem;
			
			//Tempo Pokok
			if($row['sistem_angsuran']==11){
			$tempo_pokok		=($row['jangka'])-24/$sa_pokok; 
			}else if($row['sistem_angsuran']==14){
			$tempo_pokok		=($row['jangka'])-3/$sa_pokok;   
			}else if($row['sistem_angsuran']==15){
			$tempo_pokok		=($row['jangka'])-2/$sa_pokok;   
			}else if($row['sistem_angsuran']==20){
			$tempo_pokok		=($row['jangka'])-12/$sa_pokok;   
			}else{
			$tempo_pokok		=$jangka/$sa_pokok;
			}
			
    $jangka=$row['jangka'];
    $tgl_cair=$row['tgl_cair'];
    $pros_jasa=$row['pros_jasa'];
    $alokasi=$row['alokasi'];
		for($no=1;$no<=$jangka;$no++){
		    
		    
		    
		    
		    
		    
		    
    		    $tgl_ra = tanggal($tgl_cair,$no);
    		    $adaangsurankah=adaangsurankah("$tgl_ra-$rcp");
    			$wapok		=wajibpokokaja("$rcp");
    			$sumpok=$wapok*($tempo_pokok-1);
    			
    			
    				//pokok
    			if ($no<$tempo AND $adaangsurankah==0){
    				$pok=($wapok);
    			}elseif ($no>=$tempo AND $adaangsurankah==0){
    			    $pok=($alokasi-$sumpok);
    			}else{
    			    $pok="0";
    			}
    			
    			
    			    //jasa
				$wajibjasa=bulatkan(@(wajibjasaaja("$rcp")));
    		    $adajasa=adajasa("$tgl_ra-$rcp");
				$sumjasa=$wajibjasa*($tempo-1);
				if ($no<$tempo AND $adajasa==0){
					$wajas=($wajibjasa);
			    }elseif($no>=$tempo AND $adajasa==0){
					$wajas=(($alokasi*$pros_jasa/100)-$sumjasa);
			    }else{
				  $wajas="0";
			    }
				$saldo=$alokasi-($wapok*($no-1));
			  if ($jenis_jasa==1){$bayar_jasa=$wajas;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$wajas;}
		$jadwal=tanggal($tgl_cair,$no);
		 
		 ?>
		    <tr>
		        <td>
		            
		        </td>
		        <td>
		            <?php echo $row['id']; ?>
		        </td>
		        <td>
		            <?php echo $no; ?>
		        </td>
		        <td>
		            <?php echo $jadwal; ?>
		        </td>
		        <td>
		            <?php echo $pok; ?>
		        </td>
		        <td>
		            <?php echo $bayar_jasa; ?>
		        </td>
		        <td>
		            
		            <?php echo sistem($row['sistem_angsuran']); ?>
		        </td>
		        <td>
		            <?php echo sistem($row['sa_jasa']); ?>
		        </td>
		    </tr>
<?php } 
$jadwal=tanggal($tgl_cair,$no);
?>

		    <tr>
		        <td>
		            
		        </td>
		        <td>
		            <?php echo $row['id']; ?>
		        </td>
		        <td>
		            <?php echo $no; ?>
		        </td>
		        <td>
		            <?php echo $jadwal; ?>
		        </td>
		        <td>
		            <?php echo 0; ?>
		        </td>
		        <td>
		            <?php echo 0; ?>
		        </td>
		        <td>
		            
		            <?php echo sistem($row['sistem_angsuran']); ?>
		        </td>
		        <td>
		            <?php echo sistem($row['sa_jasa']); ?>
		        </td>
		    </tr>
</table>