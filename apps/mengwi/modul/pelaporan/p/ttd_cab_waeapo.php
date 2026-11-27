<?php session_start();
include "../../../inc/inc.koneksi.php";

$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));

$ketuaupk=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tanggal' "));
$ketua_cab=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

?>

<?php if ($_SESSION['level']=='pusat') { ?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]"; ?> pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>
<?php } else if ($_SESSION['level']=='kab') { ?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "Operator Kab. $_SESSION[nama_kab]"; ?> pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>
<?php } else {?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
	 
    
    <tr>
  	   <td class="style9 align-center" valign="top" width="31%" ><b>Disetujui Oleh :<br><?php echo $kec['nama_lembaga_long'] ;?></b> 
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u>Basuki</u><br>Manajer</p>
  	   
  	   </td>
  	    <td class="style9 align-center" valign="top" width="31%" > <b>Dilaporkan Oleh :<br><?php echo $kec['nama_lembaga_long'] ;?></b>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u><?php echo "$ketua_cab[namadepan] $ketua_cab[namabelakang]";?></u><br>Pimpinan <?php echo $kec['nama_kec'] ;?></p>
  	   </td>
  	   
  	</tr>    
		
  
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
	<?php } ?>
</table>

