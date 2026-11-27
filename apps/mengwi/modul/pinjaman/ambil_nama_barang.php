<?php session_start();
include "../../inc/inc.koneksi.php";

$jenis_pp = $_GET['jenis_pp'];
if($jenis_pp=='13') {	
echo "<label class='control-label col-sm-5'>Nama Barang</label>
<div class='col-sm-7'>
<input type='text' name='nama_barang' class='form-control' id='nama_barang' required='required' autocomplete='off' placeholder='Barang Kredit' > </div>";}
?>