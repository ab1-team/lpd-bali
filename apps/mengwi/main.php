<?php session_start(); 
if(isset($_SESSION['id'])){
    header('Location:/2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=1');
}else{
	session_destroy();
	header('Location:index.php?st=1');
	
}
?>	