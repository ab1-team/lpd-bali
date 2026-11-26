<?php
function bulan($start, $end, $period = "month") //misal 29 desember ke 28 februari
{
    // $thn_awal	= substr($start,0,4);
    // $bln_awal	= substr($start,5,2);   //12
    // $tgl_awal	= substr($start,8,2);   //29
    // $thn_end	= substr($end,0,4);     
    // $bln_end	= substr($end,5,2);     //02
    // $tgl_end	= substr($end,8,2);     //28
    // $tgl_kondisi= date('Y-m-t', strtotime("$end")); 
    // $tgl_endt	= substr($tgl_kondisi,8,2);  //28/29
    
    //     $thn = ($thn_end-$thn_awal)*12;
    //     $bln = ($bln_end-$bln_awal);
    //     if($tgl_end>=$tgl_awal AND $tgl_endt<=$tgl_awal){
    //         $tgl=1;
    //     }else{
    //         $tgl=0;
    //     }
    // $selisih=$thn+$bln+$tgl;
    // return $selisih;
    
    
    
    
    
    
    
    
    
    $day = 0;
    $month = 0;
    $month_array = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $datestart = strtotime($start);
    $dateend = strtotime($end);
    $month_start = strftime("%m", $datestart);
    $current_year = strftime("%y", $datestart);
    $diff = $dateend - $datestart;
    $date = $diff / (60 * 60 * 24);
    $day = $date;

    $awal = 1;

    while($date > 0)
    {
        if($awal)
        {
            $loop = $month_start - 1;
            $awal = 0;
        }
        else
        {
            $loop = 0;
        }
        for ($i = $loop; $i < 12; $i++)
        {
            if($current_year % 4 == 0 && $i == 1)
                $day_of_month = 29;
            else
                $day_of_month = $month_array[$i];

            $date -= $day_of_month;

            if($date <= 0)
            {
                if($date == 0)
                    $month++;
                break;
            }
            $month++;
        }

        $current_year++;
    }
    switch($period)
    {
        case "day"   : return $day; break;
        case "month" : return $month; break;
        case "year"  : return intval($month / 12); break;
    }
 }
 
 
 function nilaibuku($id) {
		$tgl_kondisi	= substr($id,0,10);
		$idi			= substr($id,11);
	$row=mysql_fetch_array(mysql_query("select * from inventaris_$_SESSION[kd_kab] WHERE id='$idi' "));
		
		$tgl_beli		=tgl_toleransi($row['tgl_beli']);
		$unit			=$row['unit'];
		$harsat			=$row['harsat'];
		$harga			=$unit*$harsat;
		$umur_ekonomis	=$row['umur_ekonomis'];
		$penyusutan		=floor(@($harga/$umur_ekonomis));
		$ak_umur		=bulan($tgl_beli,$tgl_kondisi);
		$ak_susut		=@($penyusutan*$ak_umur);
		$nilaibuku		=$harga-$ak_susut;
		if($nilaibuku<0) {$nilai_buku=1;}else{$nilai_buku=$nilaibuku;}
		 return $nilai_buku;
}

function tgl_toleransi($id){
		$tgl	= substr($id,8,2);
		if($tgl>=30 AND $_SESSION['lokasi']==96){
		    $tole   = date('Y-m-d', strtotime('+15 days', strtotime($id))); //tembak tanggalnya ke tanggal +15 hari biar jd bulan depan
    		$bln1   = substr($tole,5,2);
    		$thn1   = substr($tole,0,4);
		    $tanggal = "$thn1-$bln1-01";
		}else{
		    $tanggal = $id;
		}
	return $tanggal;
		
}
 
 ?>