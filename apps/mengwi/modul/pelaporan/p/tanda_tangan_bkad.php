<?php session_start();
include "../../../inc/inc.koneksi.php";

$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));
$ttd_pelapor	= $kec['ttd_pelapor'];
$ttd_bp			= $kec['ttd_bp'];


$data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' ");

	 if($ttd_bp=="1") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan='1' "); }
else if($ttd_bp=="2") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' "); }

?>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
	  <td class="style27 align-center" width="48%">
	  <?php  if($ttd_bp=="3") { echo""; } else { ?>
	  <br>Diperiksa Oleh:<br><?php echo "$kec[nama_bp_long]";?><br>
		<?php
			$no=0;
			while($bp=mysql_fetch_array($databp)){
			$no=$no+1;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>
					<td class='style9' width='50%'>$no. $bp[namadepan] $bp[namabelakang]<br>&nbsp;&nbsp;&nbsp;&nbsp;($bp[nama_jabatan])</td>
					<td class='style9' width='50%'>: </td>
				</tr>
			</table>";
		}

	  }		?>
		
		
	  </td>
	  <td width="4%">&nbsp;</td>
	  <td class="style27 align-center" width="48%"><br>Dilaporkan Oleh:<br>BKAD <?php echo "$kec[nama_kec]";?><br>
	  <?php 
			$no=0;
			while($upk=mysql_fetch_array($data)){

			$no=$no+1;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>
					<td class='style9' width='50%'>$no. $upk[namadepan] $upk[namabelakang]<br>&nbsp;&nbsp;&nbsp;&nbsp;($upk[nama_jabatan])</td>
					<td class='style9' width='50%'>: </td>
				</tr>
			</table>";
		} ?>
	  </td>
  </tr>
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>