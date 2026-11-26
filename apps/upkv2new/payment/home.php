<?php session_start();
include "inc/koneksi_payment.php";
include "inc/fungsi_indotgl.php";

$agen_id	='ID27434';
$password_agenid	='797781';
$datetime	=date('Y-m-d H:i:s');
$signature = sha1 (md5( $password_agenid ). strrev($agen_id).$datetime);

$post = array( 'command' => "SALDO",
'user' => 'AP62855',
'password' => '982447',
'time' => date("Y-m-d H:i:s"),
'sign' => $signature
);
$ch = curl_init('http://api.edunia.net/mpulsa');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$result = curl_exec($ch); //result anda kelola kembali
curl_close($ch);

$json = json_decode($result);
$saldo=$json->saldo;

?>		
<script type="text/javascript">	


		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
</script>
						
    <div class="col-md-3 col-sm-6">
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-primary">
                            <span class="h5 text-white"><i class="fa fa-group"></i> GROUP AND MEMBERS</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified bg-primary-light">
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center"><?php echo $saldo;?></div> GROUP</a></li>
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center"><?php echo $saldo;?></div> MEMBERS</a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
           