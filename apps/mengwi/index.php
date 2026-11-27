<?php
include "inc/inc.koneksi.php";

$actual_link = "$_SERVER[HTTP_HOST]";

$kec	=mysql_query("SELECT * FROM kecamatan WHERE web_kec='$actual_link' OR web_alternatif='$actual_link' ");
$kab	=mysql_query("SELECT * FROM kabupaten WHERE web_kab='$actual_link' OR web_kab_alternatif='$actual_link' ");
$prop	=mysql_query("SELECT * FROM propinsi WHERE web_prop='$actual_link' OR web_prop_alternatif='$actual_link' ");
$pus	=mysql_query("SELECT * FROM pusat WHERE web='$actual_link' OR web_alternatif='$actual_link' ");

$tampilkec  = mysql_fetch_array ($kec);
$ok_kec	=mysql_num_rows($kec);
$ok_kab	=mysql_num_rows($kab);
$ok_prop	=mysql_num_rows($prop);
$ok_pus	=mysql_num_rows($pus);

if ($ok_kec > 0){
	if($tampilkec['kd_kab']=='2' OR
		$tampilkec['kd_kab']=='4'OR
		$tampilkec['kd_kab']=='7'OR
		$tampilkec['kd_kab']=='10'OR
		$tampilkec['kd_kab']=='11'OR
		$tampilkec['kd_kab']=='12'OR
		$tampilkec['kd_kab']=='15'OR
		$tampilkec['kd_kab']=='18'OR
		$tampilkec['kd_kab']=='20'OR
		$tampilkec['kd_kab']=='22'OR
		$tampilkec['kd_kab']=='23'OR
		$tampilkec['kd_kab']=='26'){
		header("location:http://$tampilkec[web_kec]");
		}else{

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?php echo "$tampilkec[nama_lembaga_sort] $tampilkec[nama_kec]";?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon icon -->
        <link rel="shortcut icon" href="images/<?php 
                    $logo=$tampilkec['logo'];
					if (empty($logo)) {
						echo "upeka.png";
						}else{
						echo "logo/$logo";
						}
	?>" type="image/x-icon">
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- animation css -->
        <link rel="stylesheet"
            href="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/css/plugins/animate.min.css">
        <!-- vendor css -->
        <link rel="stylesheet"
            href="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/css/style.css">
        <link rel="stylesheet" href="./css/style.css">

    </head>

    <body>
        <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
            <div class="row align-items-center w-100 align-items-stretch bg-white">
                <div class="relative d-none d-lg-flex col-lg-8 aut-bg-img align-items-center">
                    <span class="title-text z-10">
                        <h3><?php echo "$tampilkec[nama_lembaga_sort]";?></h3>
                    </span>
                    <div class="backdrop"></div>
                    <div class="z-10 title-side relative">
                        <h3 class="text-white p-2">
                            <?php echo "$tampilkec[nama_lembaga_long] - $tampilkec[nama_kec]";?>
                        </h3>
                        <!--<p class="text-white text-lg"><?php echo "$tampilkec[nama_lembaga_long] - $tampilkec[nama_kec]";?>.</p>-->
                    </div>
                </div>
                <div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center tilt" style="z-index: 999999; transform: perspective(1000px) rotateX(0deg) rotateY(0deg); will-change: transform;">
                    <form action="modul/login/cek_login.php" method="POST"
                                        onSubmit="return validasicontact(this)">
                        <div class=" auth-content text-center">
                            <div class="mb-4">
                                <?php $logo=$tampilkec['logo']; ?>
                                <img src="images/<?= (empty($logo)) ? 'upeka.png':'logo/'.$logo;?>" alt="..." width="90">
                            </div>
                            <h3 class="mb-4">Silahkan Login</h3>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="uname" id="uname"
                                    placeholder="Username">
                            </div>
                            <div class="input-group mb-4">
                                <input type="password" class="form-control" name="pass" id="pass"
                                    placeholder="password">
                            </div>
                            <button class="btn btn-primary shadow-2 mb-4" name="login" type="submit" id="login">
                                Login <i class="fas fa-sign-in"></i>
                            </button>
                            <div id="Konfirmasi"></div>
                            <div class="w-100 text-center mt-3" style="font-size: 12px">
                                Development By PT. Asta Brata Teknologi <br> SIM Koperasi@2.0.0 All Right Reserved
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Required Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
            integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script
            src="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/js/plugins/popper.min.js">
        </script>
        <script
            src="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/js/plugins/bootstrap.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js" integrity="sha512-K9tDZvc8nQXR1DMuT97sct9f40dilGp97vx7EXjswJA+/mKqJZ8vcZLifZDP+9t08osMLuiIjd4jZ0SM011Q+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        
        <script>
            VanillaTilt.init(document.querySelector(".tilt"), {
        		max: 25,
        		speed: 400
        	});
        </script>
        
        <script type="text/javascript">
            window.onload = function () {
                var input = document.getElementById("uname").focus();
            }

            $(document).ready(function () {

                $("#login").click(function () {
                    var uname = $('#uname').val();
                    var pass = $('#pass').val();

                    if (uname.length == 0) {
                        $("#Konfirmasi").load('modul/login/dilarang_uname.php');
                        $("#uname").focus();
                        return false;
                    }
                    if (pass.length == 0) {
                        $("#Konfirmasi").load('modul/login/dilarang_pass.php');
                        $("#pass").focus();
                        return false;
                    }
                });
            });
        </script>
    </body>

</html>

<?php
	}
}else if ($ok_kab > 0){

header('location:kab');

}else if ($ok_prop > 0){

header('location:prop');

}else if ($ok_pus > 0){

header('location:admin');

}
?>