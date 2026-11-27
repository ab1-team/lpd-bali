<?php session_start(); 
include "inc/fungsi_keuangan.php";
include "inc/inc.koneksi.php";
echo saldo("2019-12-31-214")*-1;
    
    $sql = "SHOW TABLES FROM $database";
    $result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_row($result)) {
    echo "Table: {$row[0]}\n";
}

mysql_free_result($result)

?>