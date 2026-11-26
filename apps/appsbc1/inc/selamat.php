<?php
//Selamat Siang, Pagi, Malam, Sore
$skr = getdate();
	$hours = $skr['hours'];			
		if ($hours <= 11) {
				$waktu="Pagi";
			} elseif ($hours > 11 and $hours <= 15) {
				$waktu="Siang";
			} elseif ($hours > 15 and $hours <= 18) {
				$waktu="Sore";
			} elseif ($hours > 18) {
				$waktu="Malam";
			}
			
	$jam=date('H:i');
			
//Bapak/Ibu
$kel=$_SESSION['jk']; 
	if($kel=="L") {
		$sapa="Pak"; 
		}else{ 
		$sapa="Bu"; 
		}