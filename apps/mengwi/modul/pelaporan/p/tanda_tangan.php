<?php session_start();
include "../../../inc/inc.koneksi.php";

$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));
$ttd_pelapor	= $kec['ttd_pelapor'];
$ttd_bp			= $kec['ttd_bp'];
$ttd_bkad			= $kec['ttd_mengetahui_lap'];

	 if($ttd_pelapor=="1") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' ORDER BY u.jabatan ASC "); }
else if($ttd_pelapor=="2") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' ORDER BY u.jabatan ASC "); }
else if($ttd_pelapor=="3") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='2' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' ORDER BY u.jabatan ASC "); }
else if($ttd_pelapor=="4") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1'  ORDER BY u.jabatan ASC "); }
else if($ttd_pelapor=="5") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1'  AND u.jabatan='3' ORDER BY u.jabatan ASC "); }
	 if($ttd_bp=="1") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan='1' ORDER BY `jabatan` ASC"); }
else if($ttd_bp=="2") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND namadepan!='' ORDER BY `jabatan` ASC"); }
else if($ttd_bp=="4") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan=26 ORDER BY `jabatan` ASC"); }
else if($ttd_bp=="5") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan=2 ORDER BY `jabatan` ASC"); }

if($ttd_bkad=="1") { $databkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan='1' ORDER BY u.jabatan ASC "); }
else if($ttd_bkad=="4") { $databkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan='2' ORDER BY u.jabatan ASC "); }
else if($ttd_bkad=="2") { $databkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' ORDER BY u.jabatan ASC "); }
else if($ttd_bkad=="8") { $databkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan=26 ORDER BY u.jabatan ASC "); }
else if($ttd_bkad=="9") { $databkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2 AND u.jabatan=2' ORDER BY u.jabatan ASC "); }
//Tim Penanganan Masalah
else if($ttd_bkad=="5") { $databkadtpm=mysql_query("SELECT * FROM users u, jabatan j, `level` l WHERE u.jabatan=j.id
AND u.lokasi='$_SESSION[lokasi]' AND u.`level`=l.id 
AND u.level='2' 
AND u.jabatan='1' OR u.jabatan=j.id 
AND u.lokasi='$_SESSION[lokasi]' AND u.`level`=l.id
AND u.level='6' 
AND u.jabatan='1'"); }



$bkad=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='1' AND level='2' AND lokasi='$_SESSION[lokasi]' ORDER BY u.jabatan ASC "));
$sekbkad=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='2' AND level='2' AND lokasi='$_SESSION[lokasi]'  "));
$benbkad=mysql_fetch_array(mysql_query("select * from users WHERE jabatan='3' AND level='2' AND lokasi='$_SESSION[lokasi]' "));
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
<?php } else if ($_SESSION['lokasi']=='69') { ?>
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr><td colspan="5">&nbsp;</td></tr>	
	<tr>
	<td class="style27 align-center" valign="top" width="31%" colspan="2">
	   <br>Diperiksa Oleh:<br><br>
	 </td>
	 
	  
	<td class="style27 align-center" valign="top" width="31%"><br>Dilaporkan Oleh:<br><?php echo "$kec[nama_lembaga_long]";?><br>
	  
	  </td>
	</tr>
	
	<tr>
	
	<td class="style27">
	<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>
				<td class="style9"  align="center">
				<u><?php echo ("$sekbkad[namadepan] $sekbkad[namabelakang]"); ?></u><br>Sekretaris BKAD</center>
				</td>
				<td class="style9" align="center">
				 <u><?php echo ("$benbkad[namadepan] $benbkad[namabelakang]"); ?></u><br>Bendahara BKAD</center>
				</td>
				</tr>
	</table>
	</td>
	
	<td colspan="2">
	<?php 
			$no=0;
			
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				while($upk=mysql_fetch_array($data)){
			$jabatan	=$upk['jabatan'];
			if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			else if($jabatan=="2") {$nama_jabatan=$kec['sebutan_level_2'];}
			else if($jabatan=="3") {$nama_jabatan=$kec['sebutan_level_3'];}
			else  {$nama_jabatan=$upk['nama_jabatan'];}
			$no=$no+1;
			echo"<td class='style9' width='auto'><center><u>$upk[namadepan] $upk[namabelakang]</u><br>$nama_jabatan</center></td>";
		}
				echo"</tr>
			</table>"; ?>
	</td>
	 </tr>
	 <td height="20" colspan="5" class="style9"cellpadding="3" cellspacing="0"><b><div align="center">Mengetahui/Menerima</div></b></td>
      </tr>
      <tr></tr>
	  <td colspan='3' class="style9" align="center">
		<p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
		<u><?php echo ("$bkad[namadepan] $bkad[namabelakang]"); ?></u><br>Ketua BKAD</center>
		</td>
	  	      
</table>
<?php } else { ?>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
	  <td class="style27 align-center" valign="top" width="31%">
	  <?php  if($ttd_bp=="3") { echo""; } else { ?>
	  <br>Diperiksa Oleh:<br><?php echo "$kec[nama_bp_long]";?><br>
		<?php
			$no=0;
			
			echo "
			<table width='100%'>
			<tr><td colspan='3'>&nbsp;</td></tr>
			<tr><td colspan='3'>&nbsp;</td></tr>
            <tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				while($bp=mysql_fetch_array($databp)){
				$no=$no+1;
					echo"<td class='style9' width='auto'><center><u>$bp[namadepan] $bp[namabelakang]</u><br>$bp[nama_jabatan]</center></td>";}
				echo"</tr>
			</table>";
		

	  }		?>
		
	  </td>

	  <td class="style27 align-center" valign="top" width="31%"><br>Dilaporkan Oleh:<br><?php echo "$kec[nama_lembaga_long]";?><br>
	  <?php 
			$no=0;
			
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				while($upk=mysql_fetch_array($data)){
			$jabatan	=$upk['jabatan'];
			if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			else if($jabatan=="2") {$nama_jabatan=$kec['sebutan_level_2'];}
			else if($jabatan=="3") {$nama_jabatan=$kec['sebutan_level_3'];}
			else  {$nama_jabatan=$upk['nama_jabatan'];}
			$no=$no+1;
			echo"<td class='style9' width='auto'><center><u>$upk[namadepan] $upk[namabelakang]</u><br>$nama_jabatan</center></td>";
		}
				echo"</tr>
			</table>"; ?>
	  </td>
  </tr>


  <tr>
  	<td class="style27 align-center" colspan="3">
  <?php  if(($_SESSION['lokasi']=='194') ){?>
	  <br>Mengetahui<br><br><br>
		<?php
			
			echo "
			<table width='100%' border='0'>
				
				<tr>
					<td class='style9' width='auto' align='center'><b>Camat Poncowarno</b><br><br><br><br><u>Drs.Budiono,M.Si</u><br>NIP.196910161990011001</td>";
					$no=0;
			while($bkad1=mysql_fetch_array($databkad)){
			$no=$no+1;echo"
					<td class='style9' width='auto' align='center'><b>$bkad1[nama_jabatan] $kec[nama_bkad_sort]</b><br><br><br><br><u>$bkad1[namadepan] $bkad1[namabelakang]</u></td>";}
				echo"</tr>
						</table>"; 	?>
						
			<?php } else if(($_SESSION['lokasi']=='214') ){?>
        	  <br>Mengetahui<br><br><br>
        		<?php
        			
        			echo "
        			<table width='100%' border='0'>
        				
        				<tr>
        					<td class='style9' width='auto' align='center'><b>Kasi PM Kec. Gombong</b><br><br><br><br><u>Sigit Harsono, SH</u><br>NIP. 196302101986031023</td>";
        					$no=0;
        			while($bkad1=mysql_fetch_array($databkad)){
        			$no=$no+1;echo"
        					<td class='style9' width='auto' align='center'><b>$bkad1[nama_jabatan] $kec[nama_bkad_sort]</b><br><br><br><br><u>$bkad1[namadepan] $bkad1[namabelakang]</u></td>";}
        				echo"</tr>
        						</table>"; 	?>
						

			<?php  } else if(($ttd_bkad=="1") OR ($ttd_bkad=="4")){ ?>

				  <br>Mengetahui/Menerima:<br><?php echo "$kec[nama_bkad_long]";?><br>
					<?php
						$no=0;
						
						echo "
						<table width='100%'>

							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr>";
							while($bkad1=mysql_fetch_array($databkad)){
						$no=$no+1;
						echo"<td class='style9' width='auto'><center><u>$bkad1[namadepan] $bkad1[namabelakang]</u><br>$bkad1[nama_jabatan]</center></td>";}
							echo"</tr>
						</table>"; 	?>

				<?php  } else if($ttd_bkad=="5"){ ?>

				  <br>Mengetahui/Menerima:<br><br>
					<?php
						$no=0;
						
						echo "
						<table width='100%' border='0'>

							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr><td colspan='5'>&nbsp;</td></tr>
							<tr>";
							while($bkad1=mysql_fetch_array($databkadtpm)){
						$no=$no+1;
						echo"<td class='style9' width='auto'><center><u>$bkad1[namadepan] $bkad1[namabelakang]</u><br>$bkad1[nama_jabatan] $bkad1[nama_level]</center></td>";}
							echo"</tr>
						</table>"; 	?>

					<?php } ?>



					<?php if ($ttd_bkad=='3') { ?>
					  <br>Mengetahui/Menerima:<br><?php echo "$kec[nama_bkad_long]";?><br/>
					  			<p>&nbsp;</p>
					  			<p>&nbsp;</p>
				       		    <p>___________________</p>
					  <?php  } ?>
	</td>


</tr>
  <?php if($_SESSION['kd_kab']=='12') {;?>
  <tr>
	  <td class="style27 align-center" colspan="3">Mengetahui,<br>Badan Pengurus Perkumpulan (BPP)<br><br><br><br><br>
	  <?php echo "<u>$bkad[namadepan] $bkad[namabelakang]</u>"; ?></td>
  </tr>
  <?php } ?>
  
  </tr>
	<tr><td colspan="3">&nbsp;</td></tr>	
	<tr>
	<td class="style10 top align-right" colspan="3">Dicetak Oleh: <?php echo "$u[namadepan] $u[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?></td>
	</tr>
</table>

<?php } ?>