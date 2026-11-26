<?php
// koneksi ke mysql server hosting
include "../../inc/inc.koneksi.php";

// membuat header dokumen XML
header('Content-Type: text/xml');
echo "<?xml version='1.0'?>";

// membuat root tag untuk data XML
echo "<outbox>";

// query untuk membaca seluruh SMS yang ada di tabel outbox
$query = "SELECT * FROM sms_ucapan ORDER BY id";
$hasil = mysql_query($query);
while ($data = mysql_fetch_array($hasil))
{
   // representasi data sms
   echo "<data>";
   echo "<id>".$data['id']."</id>";
   echo "<destination>".$data['DestinationNumber']."</destination>";
   echo "<sms>".$data['TextDecoded']."</sms>";
   echo "<creator>".$data['CreatorID']."</creator>";
   echo "</data>";
}
echo "</outbox>";
?>