<?php
// koneksi ke mysql di server hosting
include "../../inc/inc.koneksi.php";

// baca ID data yang akan dihapus yang dikirim via CURL dari localhost
$id = $_POST['id'];
// hapus data SMS berdasarkan ID
$query = "DELETE FROM sms_ucapan WHERE id = '$id'";
mysql_query($query);

?>