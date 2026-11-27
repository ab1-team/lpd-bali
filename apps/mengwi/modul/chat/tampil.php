<?php session_start();

	include "../../inc/inc.koneksi.php";
	$views=mysql_query("select * from users where id!='$_SESSION[id]'");
								while($rows=mysql_fetch_array($views)){
								
								$_SESSION['idu']=$rows['id']; //Gagal Array
								$_SESSION['namareceiver']=$rows['namadepan']; //Gagal Array
								
								if ($rows['online']=="Y") { $circle="text-success"; }else{ $circle="text-muted";}
	//HEADER PENGIRIM
	echo "
        <div class='chat-sidebar-chat chat-sidebar-panel' id='chat-sidebar-user-$rows[id]'>
            <h5 class='title'>
                <a class='js-back' href='#'><i class='fa fa-chevron-left mr-xs'></i> $rows[namadepan] $rows[namabelakang]
				<span><i class='fa fa-trash-o pull-right'></i></span>
				</a>
            </h5>
			<ul class='message-list'>	
             ";
			//ISI DIALOG
				$viewss=mysql_query("select * from chat where id_sender=$rows[id] and id_receiver=$_SESSION[id] or id_sender=$_SESSION[id] and id_receiver=$rows[id] order by tanggal asc");
											while($rowss=mysql_fetch_array($viewss)){
											$idsender=$rowss[id_sender];
											$idreceiver=$rowss[id_receiver];
				$data=mysql_query("select * from users where id=$idsender");
											if ($idreceiver==$_SESSION[id]) {
												$warna="";
												$foto=$rows[foto];
												}else{
												$warna="from-me";
												while($dat=mysql_fetch_array($data)){
												$foto=$dat[foto];
												
													}
												}
	echo "		
				<li class='message $warna'>
                    <span class='thumb-sm'><a href='#' data-toggle='tooltip' data-placement='bottom' title='$rowss[tanggal]'><img class='img-circle' src='foto_users/$foto' alt='...'></a></span>
                    <div class='message-body'>$rowss[isi]</div>
                </li> "; }
    echo "  </ul> "; ?>

	

	</div>
	
	
	<?php } ?>
	
	<footer class="chat-sidebar-footer form-group">
            
            <input class="form-control input-dark fs-mini" name="content_txt" id="contentText" type="text"  autocomplete="off" placeholder="Tulis pesan anda untuk <?php echo $_SESSION['namareceiver'];?>...">
	</footer>
	
<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#contentText").keyup(function (e) {
			if(e.keyCode != 13) return;
            
			var contentText = $('#contentText').val();
			var id_receiver = $('#id_receiver').val();
			if ((val = $(this).val().trim()) == '') return;
			
			jQuery.ajax({
					type: "POST", 
					url: "modul/chat/simpan.php", 
					data:	"&id_receiver="+id_receiver+
							"&content_txt="+contentText,
					success:function(response){
						$("#TampilChat").append(response);
					}
				
				});
				
			<?php
			$roww=mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[id]'"));
			$foto=$roww['foto'];
			?>
			var $currentMessageList = $('.chat-sidebar-chat.open .message-list'),
                $message = $('<li class="message from-me">' +
                    '<span class="thumb-sm"><img class="img-circle" src="foto_users/<?php echo $foto;?>" alt="..."></span>' +
                    '<div class="message-body"></div>' +
                    '</li>');
            $message.appendTo($currentMessageList).find('.message-body').text(val);
			$(this).val('');
	});
	
});
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#contentText").keyup(function (e) {
			if(e.keyCode != 13) return;
            
			var contentText = $('#contentText').val();
			var id_receiver = $('#id_receiver').val();
			if ((val = $(this).val().trim()) == '') return;
			
			jQuery.ajax({
					type: "POST", 
					url: "modul/chat/simpan.php", 
					data:	"&id_receiver="+id_receiver+
							"&content_txt="+contentText,
					success:function(response){
						$("#TampilChat").append(response);
					}
				
				});
				
			<?php
			$roww=mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[id]'"));
			$foto=$roww['foto'];
			?>
			var $currentMessageList = $('.chat-sidebar-chat.open .message-list'),
                $message = $('<li class="message from-me">' +
                    '<span class="thumb-sm"><img class="img-circle" src="foto_users/<?php echo $foto;?>" alt="..."></span>' +
                    '<div class="message-body"></div>' +
                    '</li>');
            $message.appendTo($currentMessageList).find('.message-body').text(val);
			$(this).val('');
	});
	
});
</script>