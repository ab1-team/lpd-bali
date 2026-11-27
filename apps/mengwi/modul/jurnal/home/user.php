<?php
$dus=mysql_fetch_array(mysql_query("SELECT * FROM users u WHERE u.lokasi=$_SESSION[lokasi] AND u.level=5 AND u.jabatan=1 ORDER BY id DESC"));
if($dus['id']==$dus['pass'] AND $dus['uname']=="pendanaan"){
?>

<style type="text/css">
<!--
#mask {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 9000;
  background-color: #000;
  display: none;
}
 
#boxes .window {
  position: absolute;
  left: 0;
  top: 0;
  width: 440px;
  height: 200px;
  display: none;
  z-index: 9999;
  padding: 20px;
  border-color:#dd5826;
  border-width: 15px;
  border-radius: 15px;
  text-align: left;
}
 
#boxes #dialog {
  width: 500px;
  text-align: justify;
  height: 440px;
  padding: 20px;
  background-color: #ffffff;
  font-family: 'Segoe UI Light', sans-serif;
  font-size: 15pt;
}
 
#popupfoot {
  font-size: 16pt;
  position: absolute;
  bottom: 0px;
  width: 250px;
  left: 250px;
}
#style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; line-height:1.2; background-color: #5d8fc2;padding: 10px; }
-->
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {	
	var id = '#dialog';
 
	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();
 
	//Set heigth and width to mask to fill up the whole screen
	$('#mask').css({'width':maskWidth,'height':maskHeight});
 
	//transition effect
	$('#mask').fadeIn(500);	
	$('#mask').fadeTo("slow",0.9);	
 
	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();
 
	//Set the popup window to center
	$(id).css('top',  winH/2-$(id).height()/2);
	$(id).css('left', winW/2-$(id).width()/2);
 
	//transition effect
	$(id).fadeIn(2000); 	
 
	//if close button is clicked
	$('.window .close').click(function (e) {
	//Cancel the link behavior
	e.preventDefault();
 
	$('#mask').hide();
	$('.window').hide();
	});
 
	//if mask is clicked
	$('#mask').click(function () {
	$(this).hide();
	$('.window').hide();
	});
 
	});
</script>
<meta charset="utf-8">

<div id="boxes">
  <div id="dialog" class="window">
	<center><h1 style="color:#dd5826;"> <i class="fa fa-warning"></i> PENTING </h1></center>
	<p>Saat ini fitur <b>Pendanaan</b> telah diaktifkan. <br>Silahkan input penetapan alokasi pinjaman untuk kelompok yang sudah diinput hasil verifikasinya dengan login menggunakan user id berikut:
	<pre>
	Username    : <?php echo $dus['uname']; ?> 
	Password    : <?php echo $dus['pass']; ?>
	</pre>
	Silakan klik di luar kotak popup untuk keluar.</p>
	<div id="style10" class="align-justify">popup ini akan terus muncul hingga Username dan/atau password akun tim pendanaan telah diubah</div>
    <br>
  </div>
  <div id="mask"></div>
</div>
<?php } ?>