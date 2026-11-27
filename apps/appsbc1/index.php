<?php
include "inc/inc.koneksi.php";

$actual_link = "$_SERVER[HTTP_HOST]";

$desa	=mysql_query("SELECT * FROM desa WHERE web_desa='$actual_link' ");

$lpd  = mysql_fetch_array ($desa);
?>
<!DOCTYPE html><html>
<head>
    <link rel="shortcut icon" href="images/logo_bumdes.png?v=20261127" type="image/x-icon">
	<title>SIM <?php echo LEMBAGA_SORT; ?> - V.2.0</title>
    <link href="css/application.min.css" rel="stylesheet">
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
	
<style type="text/css">

body {
background: url(images/bg_main.png) no-repeat fixed;
   background-size: 100% 32%;
   background-position:bottom center;
}

.efek-ketik
        {
            font-size: 14px;
            width: 100%;
            white-space:nowrap;
            overflow:hidden;
            -webkit-animation: ketik 4s steps(50, end);
            animation: ketik 4s steps(50, end);
        }
 
        @keyframes ketik{
            from { width: 0; }
        }
 
        @-webkit-keyframes ketik{
            from { width: 0; }
        }
</style>	

</head>
<body>

<div class="widget-body">
<div class="table-responsive">
<table id="datatable-table" class="table table-hover">
                        <thead class="bg-primary text-white">
                        <tr>
							<th class="no-sort"><i class="glyphicon glyphicon-th-large"></i> <?php echo strtoupper(LEMBAGA_LONG); ?> <?php echo $lpd['nama_desa'];?><span class="pull-right"><div class="efek-ketik">SISTEM INFORMASI MANAJEMEN</div></span></th>
                        </tr>
                        </thead>
</table>
</div>
	
<br><br><br><br>	
<div class="row mt-xlg">
	<div class="col-sm-4 text-align-center">
		<img class="mt-xlg" src="images/logo_bumdes.png?v=20261127" style="width:100px;"/>
	</div>
	<div class="col-sm-4">

						<div class="row">
							<form action="modul/login/cek_login.php" method="post">
								<div class="form-group">
									<div class="input-group input-group mb-n-md">
										<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i>
										</span>
										<input class="form-control input-lg" name="uname" id="uname" type="text" placeholder="Username" autocomplete="off"/>
									</div>
								</div>
								<br>
								<div class="form-group">
									<div class="input-group input-group mb-n-md">
										<span class="input-group-addon">
										<i class="glyphicon glyphicon-lock"></i>
										</span>
										<input class="form-control input-lg" name="pass" id="pass" type="password" placeholder="Password" autocomplete="off"/>
									</div>
								</div>
								<br>
								<div id="Konfirmasi"></div>
								<div class="form-group">
									<button class="btn btn-primary mb btn-block btn-lg" type="submit" id="login"><i class="fa fa-paper-plane"></i> &nbsp; L O G &nbsp; I N</button>
								</div>
								
								<p class="fs-sm text-muted text-align-center">
									Development by. Asta Brata Teknologi, PT<br>
									<?php echo LEMBAGA_SORT; ?>-Bali&copy;2018.All Right Reserved.
								</p>
							</form>
						</div>
		
	</div>
	<div class="col-sm-4 text-align-center">
		<img class="mt-xlg" src="images/logo_bumdes.png?v=20261127" style="width:250px;"/>
	</div>
</div>
</div>

<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript">
	window.onload = function() {
		var input = document.getElementById("uname").focus();
		}
		
	$(document).ready(function() {
	
			$("#login").click(function() {
                    var uname			= $('#uname').val();
                    var pass			= $('#pass').val();
					
					if(uname.length==0){ $("#Konfirmasi").load('modul/login/dilarang_uname.php'); $("#uname").focus(); return false; }
					if(pass.length==0){ $("#Konfirmasi").load('modul/login/dilarang_pass.php'); $("#pass").focus(); return false; }
							


                });	
	
	});	
</script>

</body>
</html>