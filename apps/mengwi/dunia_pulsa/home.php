<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";

$agen_id	='ID27207';
$password_agenid	='481360';
$datetime	=date('Y-m-d H:i:s');
$signature = sha1 (md5( $password_agenid ). strrev($agen_id).$datetime);

$post = array( 'command' => "SALDO",
'user' => 'AP82748',
'password' => '784254',
'time' => date("Y-m-d H:i:s"),
'sign' => $signature
);
$ch = curl_init('http://api.edunia.net/mpulsa');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$result = curl_exec($ch); //result anda kelola kembali
curl_close($ch);

?>		
<script type="text/javascript">	


		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
</script>
						
    <div class="row hidden-print">
	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix" style="background-color:#00008B;">
                            <span class="h5 text-white">Saldo
								<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini"><?php echo $jum_akt;?> Groups</span></a></li>
								</ul>
							</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-money"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <h3><?php echo $result;?>
                                </h3>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
           