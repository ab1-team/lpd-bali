<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$tgl_now    =date('Y-m-d');
$lokasi=$_SESSION['lokasi'];
$d					=$_POST['d'];
$m					=$_POST['m'];
$y					=$_POST['y'];
$tgl="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m")); $kc="M"; $tgl_kondisilalu=date("Y-m-t", strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$tgl_kon="$y-$m-15";
$tgl_last=date('Y-m-t', strtotime("$tgl_kon"));

?>
		       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM propinsi p, kabupaten k, kecamatan c, lkm l where p.id=k.kd_prov AND k.id=c.kd_kab AND c.id=l.lokasi AND l.lokasi='$lokasi'")); 
			$nama_kec	=$row ['nama_kec'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi		=$row ['visi_misi'];
			$nama_kab	=$row ['nama_kab'];
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR : $nomor_bh<br>";}
		
		
		?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
-->
</style>
<body onLoad="window.print()">
		<br>
		<?php if ($_SESSION['lokasi']=='68') { ?>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">


      <tr align="center">
        <td colspan="3" width="10%" class="style6 bottom">
										<img class='' alt='...' src='../../../images/DAPM.png' style='float:left; width:100; margin:10px 10px 10px 10px;'>
											
											<?php
											echo"
												</td>
												<td width='80%' class='style6 bottom'>

											";
													?>
													<br>
													<span class="style33"><?php echo strtoupper($row['nama_lembaga_long']);?></span><br>
													<span class="style3">(<?php echo strtoupper($row['nama_lembaga_sort']);?>)</span><br>
													 <span class="style333"><?php echo strtoupper("KECAMATAN $nama_kec");?><br></span>
													<span class="style9"><?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp. $telpon_kec";?><br>
													<?php echo "E-mail: $email_kec Website: $web_kec";?></span>
												</td>
												<td class="style6 bottom">
											<?php
											 $logo=$row['logo'];
											if (empty($logo)) {
											echo "<img class='' alt='...' src='../../../images/upk.png' style=' width:100; margin:10px 10px 10px 10px;'>";
											}else{
											echo "<img class='' alt='...' src='../../../images/logo/$logo' style=' width:100; margin:10px 10px 10px 10px;'>";
											} ?>

									</td>
			     				 </tr>	
								</table>
		<?php }else { ?>	

				<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr align="center">
				        <td colspan="3" class="style6 bottom">
						<?php
						                  $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab  AND c.id=l.lokasi AND l.lokasi='$lokasi'")); 
											$alamat_lkm =$row ['alamat'];
											$exp	    = explode("#", $alamat_lkm);    
	                                        $alamat1    = $exp[0];
			                                $desa1      = $exp[1];
			                                $kodepos1   = $exp[2];
															 $logo=$row['logo'];
															if (empty($logo)) {
															echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:90; margin:10px 0 10px 20px;'>";
															}else{
															echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:90; margin:10px 0 10px 20px;'>";
															}
						?>
						<br>
						<span><b><?php echo strtoupper($row['jenis_lkm']." LKM ".$row['nama_lkm_long']);?></b></span><br>
						 <?php echo strtoupper("KECAMATAN $nama_kec KABUPATEN $nama_kab");?><br>
						<span class="style9"><?php echo "$row[ijin_usaha] <br>$alamat1 $desa1 $nama_kec Kodepos $kodepos1 <br>Telp. $telpon_kec E-mail: $email_kec";?></span>
						</td>
				      </tr>	
				  </table>
		<?php  } ?>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM propinsi p, kabupaten k, kecamatan c, lkm l where p.id=k.kd_prov AND k.id=c.kd_kab AND c.id=l.lokasi AND l.lokasi='$lokasi' ")); 
			$nama_prov      =$row['nama_prov'];
			$nama_kab	    =$row ['nama_kab'];
			$nama_kec	    =$row ['nama_kec'];
			$alamat_kec	    =$row ['alamat_kec'];
			$telpon_kec	    =$row ['telpon_kec'];
			$email_kec	    =$row ['email_kec'];
			$web_kec	    =$row ['web_kec'];
			$visi		    =$row ['visi_misi'];
			$nama_kab	    =$row ['nama_kab'];
			$nomor_bh	    =$row ['nomor_bh'];
			$jlkm           =$row ['jenis_lkm'];
			$lkm_long       =$row ['nama_lkm_long'];
			$lkm_sort       =$row ['nama_lkm_sort'];
			$sandi          =$row ['sandi_lkm'];
			$alamat_lkm     =$row ['alamat'];
			$ijin_usaha	    =$row ['ijin_usaha'];
			$dasar_catat	=$row ['dasar_catat'];
			$n_saham		=$row ['nama_saham'];
			$rp_saham		=$row ['rp_saham'];
			$pros_saham		=$row ['pros_saham'];
			$n_direksi 		=$row ['nama_direksi'];
			$jab_direksi	=$row ['jab_direksi'];
			$n_kom   		=$row ['nama_kom'];
			$jab_kom    	=$row ['jab_kom'];
			
			$exp	    = explode("#", $alamat_lkm);    
	        $alamat1    = $exp[0];
			$desa1      = $exp[1];
			$kodepos1   = $exp[2];
			if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR : $nomor_bh<br>";}
		
		?>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
	    <tr>
	    <td class="style6 align-center" colspan="3" ><b>PROFIL LKM</b> 
	    <br><?php echo "$jlkm LKM $nama_kec" ;?></br>
	    <span class="style9 align-center">Untuk Periode Yang Berakhir Pada Tanggal <?php echo tgl_indo($tgl_last) ;?> </span>
	    <p class="style9 align-center"> &nbsp; </p>
	    </td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">1.</td>
            <td width="30%" class="style9">Nama LKM</td>
            <td width="60%" class="style9">: <?php echo "$lkm_long" ;?></td>
	    </tr>
	     <tr>
	        <td width="2%" class="style9">2.</td>
            <td width="30%" class="style9">Nomor Sandi LKM</td>
            <td width="60%" class="style9">: <?php echo "$sandi" ;?></td>
	    </tr>
	     <tr>
	        <td width="2%" class="style9">3.</td>
            <td width="30%" class="style9">Alamat Lengkap</td>
            <td width="60%" class="style9"></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">a. Alamat</td>
            <td width="60%" class="style9">: <?php echo "$alamat1" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">b. Kelurahan/Desa</td>
            <td width="60%" class="style9">: <?php echo "$desa1" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">c. Kecamatan</td>
            <td width="60%" class="style9">: <?php echo "$nama_kec" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">d. Kabupaten/Kota</td>
            <td width="60%" class="style9">: <?php echo "$nama_kab" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">e. Provinsi</td>
            <td width="60%" class="style9">: <?php echo "$nama_prov" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"> </td>
            <td width="30%" class="style9">f. Kode Pos</td>
            <td width="60%" class="style9">: <?php echo "$kodepos1" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">4.</td>
            <td width="30%" class="style9">Telepon dan Fax</td>
            <td width="60%" class="style9">: <?php echo "$telpon_kec" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">5.</td>
            <td width="30%" class="style9">Email</td>
            <td width="60%" class="style9">: <?php echo "$email_kec" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">6.</td>
            <td width="30%" class="style9">No. dan Tanggal Izin Usaha</td>
            <td width="50%" class="style9">: <?php echo "$ijin_usaha" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">7.</td>
            <td width="30%" class="style9">Dasar Pencatatan</td>
            <td width="60%" class="style9">: <?php echo "$dasar_catat" ;?></td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9">8.</td>
            <td width="30%" class="style9">Pemegang Saham</td>
            <td width="60%" class="style9">: </td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"></td>
	        <td colspan="2">
	            <br>
	         <table border="0" width="100%">
	             <tr>
	                 <td class="style9" width="33%">&nbsp; </td>
	                 <td colspan="2" class="style9 align-center" >Kepemilikan Saham **)</td>
	               </tr> 
	               <tr>
	                 <th class="style9 bottom top align-center" >Nama Pemegang Saham</th>
	                 <th class="style9 bottom top align-center" width="33%">Rupiah</th>
	                 <th class="style9 bottom top align-center" width="33%">Persentase(%)</th>
	                 </tr>
	   <?php
	   $jsaham =(substr_count($n_saham, "#"))+1;
	   for($s=1;$s<=$jsaham;$s++){
            	$exps1	    = explode("#", $n_saham);
            	$exps2	    = explode("#", $rp_saham);
            	$exps3	    = explode("#", $pros_saham);
            	$n_saham1   = $exps1[$s-1];
            	$rp_saham1  = $exps2[$s-1];
            	$pros_saham1= $exps3[$s-1];
            	?>
	       <tr>
	                 <td class="style9 bottom align-center" ><?php echo "$n_saham1" ;?>&nbsp;</td>
	                 <td class="style9 bottom align-center" width="33%"><?php echo number_format($rp_saham1) ;?>&nbsp;</td>
	                 <td class="style9 bottom align-center" width="33%"><?php echo "$pros_saham1" ;?>&nbsp;</td>
	                 </tr>
	  <?php 
	  $jrp_saham1 = $jrp_saham1+$rp_saham1;
	  $jpros_saham1=$jpros_saham1+$pros_saham1;
	  
	       
	   }
	   ?>
	               <tr>
	                 <td class="style9 bottom align-center" >&nbsp;</td>
	                 <td class="style9 bottom align-center" width="33%">&nbsp;</td>
	                 <td class="style9 bottom align-center" width="33%">&nbsp;</td>
	                 </tr>
	               <tr>
	                 <td class="style9 bottom align-center" >Total</td>
	                 <td class="style9 bottom align-center" width="33%"><?php echo number_format($jrp_saham1) ;?>&nbsp;</td>
	                 <td class="style9 bottom align-center" width="33%"><?php echo "$jpros_saham1" ;?>&nbsp;</td>
	                 </tr>
	         </table> 
	        </td>
	        </tr>
	        <tr>
	        <td width="2%" class="style9">&nbsp;</td>
	    </tr>
	        <tr>
	        <td width="2%" class="style9">9.</td>
            <td width="30%" class="style9">Direksi dan Komisaris</td>
            <td width="60%" class="style9">: </td>
	    </tr>
	    <tr>
	        <td width="2%" class="style9"></td>
	        <td colspan="2">
	         <table border="0" width="100%">
	               <tr>
	                   <td class="style9" width="50%"> <!-------DIREKSI---------->
    	                    <table border="0" width="100%">
        	                       <tr>
                	                 <th class="style9 bottom top align-center" width="50%">Nama Direksi</th>
                	                 <th class="style9 bottom top align-center" width="50%">Jabatan</th>
                	               </tr> 
                	       	   <?php
	   $jdir =(substr_count($n_direksi, "#"))+1;
	   for($d=1;$d<=$jdir;$d++){
            	$expd1	    = explode("#", $n_direksi);
            	$expd2	    = explode("#", $jab_direksi);
            	$n_direksi1   = $expd1[$d-1];
            	$jab_direksi1  = $expd2[$d-1];
            	?>
                	               <tr>
                	                 <td class="style9 bottom align-center" width="50%"><?php echo "$n_direksi1" ;?>&nbsp;</td>
                	                 <td class="style9 bottom align-center" width="50%"><?php echo "$jab_direksi1" ;?>&nbsp;</td>
                	                 </tr>
	  <?php }
	   ?>
    	                    </table>
	                   </td>
	                   <td class="style9" width="50%"> <!-------Komisaris---------->
    	                    <table border="0" width="100%">
        	                       <tr>
                	                 <th class="style9 bottom top align-center" width="50%">Nama Komisaris</th>
                	                 <th class="style9 bottom top align-center" width="50%">Jabatan</th>
                	               </tr>                 	       	   
                	           
                	           <?php
	   $jkom =(substr_count($n_kom, "#"))+1;
	   for($k=1;$k<=$jkom;$k++){
            	$expk1	    = explode("#", $n_kom);
            	$expk2	    = explode("#", $jab_kom);
            	$n_kom1   = $expk1[$k-1];
            	$jab_kom1  = $expk2[$k-1];
            	?>
                	               <tr>
                	                 <td class="style9 bottom align-center" width="50%"><?php echo "$n_kom1" ;?>&nbsp;</td>
                	                 <td class="style9 bottom align-center" width="50%"><?php echo "$jab_kom1" ;?>&nbsp;</td>
                	                 </tr>
	  <?php }
	   ?>
    	                    </table>
	                   </td>
	               </tr>
	               <tr>
	                 <td class="style9 " width="50%">&nbsp;</td>
	                 <td class="style9 " width="50%">&nbsp;</td>
	                 </tr>
	              
	         </table> 
	        </td>
	        </tr>
	        <tr>
	        <td width="2%" class="style9"></td>
            <td width="40%" class="style9">*) coret yang tidak perlu
            <br> **) hanya diisi untuk LKM berbentuk PT
            </td>
            
  </table>
  </table>
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  
  <tr>
	<?php
	$upk=mysql_fetch_array(mysql_query("SELECT * FROM users where lokasi='$lokasi' AND level='1' AND jabatan='1' "));  
	?>
	<tr>
        <td width="49%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
		 <p>&nbsp;</p>
          <p><?php echo "$nama_kec , ".tgl_indo($tgl_now);?></p>
		  <?php echo "$row[nama_lkm_long]"; ?>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p>&nbsp;</p></th>
        <th class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("<u>$upk[namadepan] $upk[namabelakang]</u> <br>$row[sebutan_level_1]");?></p></th>
  </tr>
  </tr>
	</table>
	

</body>
<title>Profil LKM</title>
      
</body>
