<?php session_start();
include "../../inc/inc.koneksi.php";

$nia	=$_SESSION['id'];

	if($nia<9){$nia_id="0000$nia";}else if($nia<99){$nia_id="000$nia";}else if($nia<999){$nia_id="00$nia";}else if($nia<9999){$nia_id="0$nia";}else{$nia_id="$nia";}
	
echo "#$nia_id";
?>