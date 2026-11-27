<?php session_start();

	include "../../inc/inc.koneksi.php";
	$views=mysql_query("select * from level");
								while($rows=mysql_fetch_array($views)){
										$idg="G".$rows['id'];

	//HEADER PENGIRIM
	echo "
        <div class='chat-sidebar-chat chat-sidebar-panel' id='chat-sidebar-group-$idg'>
            <h5 class='title'>
                <a class='js-back' href='#'><i class='fa fa-users mr-xs'></i> Group $rows[nama_level]
				<span><i class='fa fa-trash-o pull-right'></i></span>
				</a>
            </h5>
			<ul class='message-list'>	
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
				$dat=mysql_fetch_array(mysql_query("select * from users where id=$idsender"));
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