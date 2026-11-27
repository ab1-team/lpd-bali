<?php
include "inc/inc.koneksi.php";
?>
<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#TampilChat").load('modul/chat/tampil.php');
	$("#TampilChatGroup").load('modul/chat/tampil_group.php');
	$("#TampilChatCS").load('modul/chat/tampil_cs.php');
	
});
</script>

<div class="chat-sidebar-content">
        <header class="chat-sidebar-header col-md-12">
            <h4 class="chat-sidebar-title">e-chat
				<a href="#" data-toggle="chat-sidebar"><i class="fa fa-times pull-right text-muted"></i></a>
				<a href="#tabe3" data-toggle="tab"><i class="fa fa-headphones pull-right mr-xs text-muted"></i></a>
				<a href="#tabe2" data-toggle="tab"><i class="fa fa-users pull-right mr-xs text-muted"></i></a>
				<a href="#tabe1" data-toggle="tab"><i class="fa fa-user pull-right mr-xs text-muted"></i></a>
			</h4>
            <div class="form-group no-margin">
                <div class="input-group input-group-dark">
                    <input class="form-control fs-mini" id="chat-sidebar-search" type="text" placeholder="Search...">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
        </header>
		
<div id="tabs1c" class="tab-content2 mb-lg">

    <div class="tab-pane active" id="tabe1">
	<div class="chat-sidebar-contacts chat-sidebar-panel open">
	<h4 class="sidebar-nav-title">Personal Chat :</h4>
    <div class="list-group chat-sidebar-user-group">
                <?php
				include "inc/inc.koneksi.php";
				$view=mysql_query("SELECT * FROM users WHERE id!='$_SESSION[id]' order by lo desc");
								while($row=mysql_fetch_array($view)){
								
								if ($row['online']=="Y") { $circle="text-success"; }else{ $circle="text-muted";}
								
				$jab=mysql_fetch_array(mysql_query("select * from jabatan j, level l, kecamatan k WHERE j.id=$row[jabatan] and l.id=$row[level] and k.id=$row[lokasi]"));
				echo "			
				<a class='list-group-item' href='#chat-sidebar-user-$row[id]'> 
                    <i class='fa fa-circle $circle pull-right'></i>
                    <span class='thumb-sm pull-left mr'>
                        <img class='img-circle' src='foto_users/$row[foto]' alt='...'>
                    </span>
                    <h5 class='message-sender'>$row[namadepan] $row[namabelakang]</h5>
                    <p class='message-preview'>$jab[nama_jabatan] $jab[nama_level] $jab[nama_kec]</p>
					
                </a> ";
			
				} ?>
	</div>
    </div>
	
				<div id="TampilChat"></div>

	
       
	</div>

<!--TAB 2 GROUP -->	
	<div class="tab-pane" id="tabe2">
        <div class="chat-sidebar-contacts chat-sidebar-panel open">
		<h4 class="sidebar-nav-title">Groups :</h4>
            <div class="list-group chat-sidebar-user-group">
				<?php $view=mysql_query("select * from level");
							while($row=mysql_fetch_array($view)){
							$idg="G".$row['id'];
				?>
                <a class="list-group-item" href="#chat-sidebar-group-<?php echo $idg;?>">
                    <h5 class="message-sender"><i class="fa fa-users"></i> <?php echo $row['nama_level'];?></h5>
                    <p class="text-mute fs-sm ml-lg"><?php echo $row['deskripsi_level'];?></p>
                </a>
				<?php } ?>
            </div>
        </div>
		
		<div id="TampilChatGroup"></div>
		
        
        <footer class="chat-sidebar-footer form-group">
            <input class="form-control input-dark fs-mini" id="chat-sidebar-input" type="text"  placeholder="Type your message">
        </footer>
		
	</div>
	
<!--TAB 2 GROUP -->	
	<div class="tab-pane" id="tabe3">
        <div class="chat-sidebar-contacts chat-sidebar-panel open">
		<h4 class="sidebar-nav-title">Customer Service :</h4>
            <div class="list-group chat-sidebar-user-group">
				<?php $view=mysql_query("select * from cs");
							while($row=mysql_fetch_array($view)){
							$idg="CS".$row['id'];
							if ($row['online']=="Y") { $circle="text-success"; }else{ $circle="text-muted";}
				?>
                <a class="list-group-item" href="#chat-sidebar-group-<?php echo $idg;?>">
					<i class="fa fa-circle <?php echo $circle; ?> pull-right"></i>
                    <h5 class="message-sender"><i class="fa fa-headphones"></i> <?php echo $row['jabatan'];?> </h5>
                    <p class="text-mute fs-sm ml-lg"><?php echo $row['namadepan'];?> <?php echo $row['namabelakang'];?></p>
                </a>
				<?php } ?>
            </div>
        </div>
		
		<div id="TampilChatCS"></div>
		
        
        <footer class="chat-sidebar-footer form-group">
            <input class="form-control input-dark fs-mini" id="chat-sidebar-input" type="text"  placeholder="Type your message">
        </footer>
		
	</div>
	
</div>
</div>