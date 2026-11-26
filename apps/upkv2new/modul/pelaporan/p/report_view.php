<?php session_start();
include "../../../inc/inc.koneksi.php";
set_time_limit(120); // Set the time limit to 120 seconds




$idf			=$_POST['idf'];
$jenis_laporan	=$_POST['report'];
if (empty($idf)) {
	$_POST['sub_report']	=$_POST['sub_report'];
}else{
	$_POST['sub_report']	="$jenis_laporan-$idf";
}
$sub_laporan	=$_POST['sub_report'];
$format			='P';

$sub_tipe	=$_POST['sub_tipe'];


if (empty($sub_tipe)) {
}else{
	$sub_laporan	="$sub_tipe-$sub_laporan";
}

if (empty($sub_laporan)) {
	$file	=$jenis_laporan;
}else{
	$file	=substr($sub_laporan,0,2);
}

if($format=='excel'){
	include "../../../modul/pelaporan/master_excel.php";
}else{
	include "$file.php";
}


											
?>

    <button onclick="closeTab()" style="
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: red;
    color: white;
    border: 2px solid white; 
    border-radius: 20px;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold; 
    cursor: pointer;
    z-index: 1000;
	">
        CLOSE
    </button>

    <script>
        function closeTab() {
            window.close();
        }
    </script>

    <style>
        @media print {
            button {
                display: none;
            }
        }
    </style>