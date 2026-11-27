<?php 
if (!$_SESSION) {
    session_start();
}
include "../../../inc/inc.koneksi.php";

$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));

$ben_upk=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$ketua_upk=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]'"));

?>

<?php if ($_SESSION['level']=='pusat') { ?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]"; ?> pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>
<?php } ?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
	  <td class="style27 align-center" valign="top" width="31%"><br>Diperiksa Oleh:<br><?php echo "$kec[nama_lembaga_long]";?><br></td>
	  <td class="style27 align-center" valign="top" width="31%"><br>Dilaporkan Oleh:<br><?php echo "$kec[nama_lembaga_long]";?><br></td>
    </tr>

	<tr>
  	   <td class="style9 align-center" valign="top" width="31%" > 
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u>Basuki</u><br>Manajer </p>
  	   
  	   </td>
  	    <td class="style9 align-center" valign="top" width="31%" > 
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u>Dina</u><br>Bendahara </p>
  	   </td>
  	   
  	</tr>
    <tr>
        <td class="style27 align-center" valign="top" width="31%" colspan="2" > Mengetahui/Menyetujui: </td>
    </tr>
    <tr>
  	   <td class="style9 align-center" valign="top" width="31%" > 
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u>Eko Susanto</u><br>Ketua Koperasi</p>
  	   
  	   </td>
  	    <td class="style9 align-center" valign="top" width="31%" > 
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p>&nbsp;</p>
  	   <p><u>Ardiansyah Asdar</u><br>Ketua Dewan Pengawas</p>
  	   </td>
  	   
  	</tr>    
		
  
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>

