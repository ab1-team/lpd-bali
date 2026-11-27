<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body>
<?php
 // onLoad="window.print()"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit="baris51216";
$coba	= $_POST[$unit]; 
if (empty($coba)) {
    echo "coba is empty";
  } else {
    echo $coba;
  }
echo "berhasil";
}else{
    echo "gagal";
}
?>
<title>5. Rencana Ansuran Individu</title>
</body>
