<?php

$server = getenv("LPD_DB_HOST") ?: "db"; 
$username = "siur9777_new";  
$password = "siur9777_new";
$database = "information_schema";

$konek = mysql_connect($server, $username, $password) or die ("Gagal konek ke server MySQL" .mysql_error());
$bukadb = mysql_select_db($database) or die ("Gagal membuka database" .mysql_error());

$table_name = $_GET['table_name'];
$table_schema = $_GET['table_schema'];

$query = mysql_query("SELECT * FROM COLUMNS WHERE TABLE_SCHEMA='$table_schema' AND TABLE_NAME='$table_name'");

$alter = [];
while ($info = mysql_fetch_array($query)) {
    if ($info['COLUMN_KEY'] == 'PRI') continue;
    
    $db = $info['TABLE_SCHEMA'];
    $table = $info['TABLE_NAME'];
    $field = $info['COLUMN_NAME'];
    $type = $info['DATA_TYPE'];
    $length = ($type == 'int') ? '11':$info['CHARACTER_MAXIMUM_LENGTH'];
    
    $types = ($type == 'date' || $type == 'text') ? $type:$type . '(' .  $length . ')';
    $default = ($type == 'date') ? '0000-00-00':'0';
 
    $alter[] = "ALTER TABLE $db.$table CHANGE $field $field $types NULL DEFAULT $default";   
}

for ($i=0; $i<count($alter); $i++) {
    $query = mysql_query("$alter[$i]");
    var_dump($query);
}
?>