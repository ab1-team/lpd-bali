<?php

function bulan($start, $end, $period = "month")
{
    $day = 0;
    $month = 0;
    $month_array = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
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
		
		$tgl_beli		=$row['tgl_beli'];
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
 
 ?>