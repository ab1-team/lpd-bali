<?php 
include "../../inc/inc.koneksi.php";
$id	= $_POST['id'];
$row=mysql_fetch_array(mysql_query("select * FROM users u, news n WHERE u.id=n.penulis  AND n.id='$id'"));

echo "
<span class='mt-n-md pull-right'><a href='#tabnews1' data-toggle='tab'><i class='glyphicon glyphicon-home'></i></a></span><br>
<span class='fw-semi-bold h3'>$row[judul]</span><br>
<span class='text-muted fs-mini'><i class='fa fa-calendar'></i> $row[tanggal] <i class='ml-lg fa fa-user'></i> $row[namadepan] $row[namabelakang]</span><br>
<img src='images/news/$row[foto]' class='mt mb col-xs-12'/>
<span class='text-justify'>$row[berita]</span>
";
?>
