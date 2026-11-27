<?php session_start();

	include "../../inc/inc.koneksi.php";
	include "../../inc/selamat.php";
	$views=mysql_query("select * from cs");
								while($rows=mysql_fetch_array($views)){
										$idg="CS".$rows['id'];
										$foto=$rows['foto'];
								if ($rows['online']=="Y") { $circle="text-success"; }else{ $circle="text-muted";}
								
	//HEADER PENGIRIM
	echo "
        <div class='chat-sidebar-chat chat-sidebar-panel' id='chat-sidebar-group-$idg'>
            <h5 class='title'>
                <a class='js-back' href='#'><i class='fa fa-headphones mr-xs'></i> $rows[namadepan] $rows[namabelakang] ($rows[jabatan])
				<span><i class='fa fa-trash-o pull-right'></i></span>
				</a>
            </h5>
			<ul class='message-list'>	
				<li class='message animated bounceIn'>
                    <span class='thumb-sm'><a href='#'><img class='img-circle' src='foto_users/$foto' alt='...'></a></span>
                    <div class='message-body'><i class='fa fa-clock-o pull-right'> $jam</i><br>Selamat $waktu $sapa $_SESSION[namadepan], dengan $rows[namadepan] ada yang bisa kami bantu?</div>
                </li>
				
             ";
			//ISI DIALOG
				$viewss=mysql_query("select * from chat where id_receiver='$idg' order by tanggal asc");
											while($rowss=mysql_fetch_array($viewss)){
											$idsender=$rowss[id_sender];
											$idreceiver=$rowss[id_receiver];
				
											if ($idsender==$_SESSION[id]) {
												$warna="from-me";
												}else{
												$warna="";
												}
				$dat=mysql_fetch_array(mysql_query("select * from cs where id=$idsender"));
									$foto=$dat[foto];
	echo "		
				<li class='message $warna'>
                    <span class='thumb-sm'><a href='#' data-toggle='tooltip' data-placement='bottom' title='$rowss[tanggal]'><img class='img-circle' src='foto_users/$foto' alt='...'></a></span>
                    <div class='message-body'>$rowss[isi]</div>
                </li> "; }
    echo "  </ul>
        
		</div> 
		
		"; 
		} ?>
		
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
</script>