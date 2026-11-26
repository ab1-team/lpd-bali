<?php
	//untuk mengetahui hari ini hari apa,
$day = date ("D");
switch ($day) {
case 'Sun' : $hari = "Minggu"; break;
case 'Mon' : $hari = "Senin"; break;
case 'Tue' : $hari = "Selasa"; break;
case 'Wed' : $hari = "Rabu"; break;
case 'Thu' : $hari = "Kamis"; break;
case 'Fri' : $hari = "Jum'at"; break;
case 'Sat' : $hari = "Sabtu"; break;
default : $hari = "Hari Eror";
}
	
	function bln_indo($tgl){
			$bulan   = getBulan(substr($tgl,5,2));
			return $bulan;		 
	}
	
	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan   = getBulan(substr($tgl,5,2));
			$tahun   = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	
	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			}

function tgl_indon($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan   = getRom(substr($tgl,5,2));
			$tahun   = substr($tgl,0,4);
			return $tanggal.'-'.$bulan.'-'.$tahun;		 
	}	
	
function tgl_ind($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan   = getRom(substr($tgl,5,2));
			$tahun   = substr($tgl,0,4);
			return $tanggal.'/'.$bulan.'/'.$tahun;		 
	}	
	function getRom($bln){
				switch ($bln){
					case 1: 
						return "01";
						break;
					case 2:
						return "02";
						break;
					case 3:
						return "03";
						break;
					case 4:
						return "04";
						break;
					case 5:
						return "05";
						break;
					case 6:
						return "06";
						break;
					case 7:
						return "07";
						break;
					case 8:
						return "08";
						break;
					case 9:
						return "09";
						break;
					case 10:
						return "10";
						break;
					case 11:
						return "11";
						break;
					case 12:
						return "12";
						break;
				}
			}

function tgl_rom($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan   = getBln(substr($tgl,5,2));
			$tahun   = substr($tgl,0,4);
			return '/'.$bulan.'/'.$tahun;		 
	}	
	function getBln($bln){
				switch ($bln){
					case 1: 
						return "I";
						break;
					case 2:
						return "II";
						break;
					case 3:
						return "III";
						break;
					case 4:
						return "IV";
						break;
					case 5:
						return "V";
						break;
					case 6:
						return "VI";
						break;
					case 7:
						return "VII";
						break;
					case 8:
						return "VIII";
						break;
					case 9:
						return "IX";
						break;
					case 10:
						return "X";
						break;
					case 11:
						return "XI";
						break;
					case 12:
						return "XII";
						break;
				}
			}

function jam($tgl){
			$tanggal = substr($tgl,11,8); //2015-12-19 19:58:39

			return $tanggal;		 
	}

function ampm($tgl){
			$tanggal = substr($tgl,11,2); //2015-12-19 19:58:39
		if ($tanggal < 13 ) { $ampm="am"; }else {$ampm="pm";}
			return $ampm;		 
	}	
?>