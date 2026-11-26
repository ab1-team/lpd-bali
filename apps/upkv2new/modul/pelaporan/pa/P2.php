<?php session_start(); 
$kd_hal=$_POST['pilih_hal'];
if($kd_hal==1){
    include "H1.php";
}elseif($kd_hal==2){
    include "H2.php";
}else{
    echo "error no page selected";
}
?>