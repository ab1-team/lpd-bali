<?php
  include "inc/inc.koneksi.php";
  session_start();
  $nilai=$_GET['n'];
  mysql_query("UPDATE users SET online='T', nilai='$nilai' WHERE id = '$_SESSION[id]'");
  session_destroy();
  
  if($_SESSION['level']=="kab") {
  header ('location:index.php?st=4');
  }else if($_SESSION['level']=="pusat") {
  header ('location:admin/index.php?st=4');
  }else{
  header ('location:index.php?st=4');
  }
?>