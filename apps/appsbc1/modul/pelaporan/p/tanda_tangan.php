<?php session_start();
include "../../../inc/inc.koneksi.php";

$u=mysql_fetch_array(mysql_query("select * from users WHERE id='$_SESSION[id]' "));

$ket=mysql_fetch_array(mysql_query("SELECT * FROM users u WHERE lokasi='$_SESSION[lokasi]' AND level='1' AND jabatan='1' "));
$bp=mysql_fetch_array(mysql_query("SELECT * FROM users u WHERE lokasi='$_SESSION[lokasi]' AND level='3' AND jabatan='1' "));
?>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>

	  <td class="style27 align-center" valign="top" width="31%">
	  <br>Diperiksa Oleh:<br>Badan Pengawas<br><br><br><br><br><br>
		<?php echo strtoupper("$bp[namadepan] $bp[namabelakang]"); ?>
		
	  </td>

	  <td class="style27 align-center" valign="top" width="31%"><br>Dilaporkan Oleh:<br>Kepala,<br><br><br><br><br><br>
	  <?php echo strtoupper("$ket[namadepan] $ket[namabelakang]"); ?>
	  </td>
  </tr>

	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?> | Paraf [.........]</td>
	</tr>
</table>