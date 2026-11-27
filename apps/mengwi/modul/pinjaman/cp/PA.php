<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];

											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$_SESSION['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											
											$nama_desa			=$row['nama_desa'];
											$kd_kelompok		=$row['kd_kelompok'];
											$nama_kelompok		=$row['nama_kelompok'];
											$alamat_kelompok	=$row['alamat_kelompok'];
											$telpon				=$row['telpon'];
											$tgl_berdiri		=$row['tgl_berdiri'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_ju'];
											$jenis_kegiatan		=$row['nama_jk'];
											$tingkat_kelompok	=$row['nama_tk'];
											$fungsi_kelompok	=$row['nama_fgs'];
											$ketua				=$row['ketua'];
											$sekretaris			=$row['sekretaris'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
											$u_max				=$row['usia_mak'];
											$premi				=$row['besar_premi'];
											$j_a				=$row['pengaturan_asuransi'];
											$sebutan_lvl1       =$row['sebutan_level_1']; 
											$sebutan_lvl3       =$row['sebutan_level_3']; 
											$nama_lembaga       =$row['nama_lembaga_sort'];
											if($premi==""){$besar_premi=1;}
											else		  {$besar_premi=$premi;}
											
											if($status=="P"){$tglstatus=$tgl_proposal; $ket="Tanggal Proposal"; $dok="Proposal";
											}else if($status=="V"){$tglstatus=$tgl_verifikasi; $ket="Tanggal Verifikasi"; $dok="Verifikasi";
											}else if($status=="W" or $status=="A"){$tglstatus=$tgl_cair; $ket="Tanggal Cair"; $dok="Pencairan";
											}
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tglstatus' "));
											$bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$tglstatus' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tglstatus' "));
			?>			
		

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="3" class="bottom">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
			</td>
			<td height="20" class="bottom"><div align="right" class="style9">Dokumen <?php echo $dok;?><br>
			Loan ID. <?php echo $id_pinj;?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		DAFTAR PESERTA ASURANSI <?php echo strtoupper($row['nama_asuransi_p']);?><br>
		<span class="fw-semi-bold">PLAN ASURANSI CICILAN BULANAN</p></td>
      </tr>
      <tr>
        <td width="19%" height="24" class="style9">Nama Kelompok</td>
        <td width="32%" height="24"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($nama_kelompok);?></span></td>
		<td height="25" class="style9"><?php echo $ket;?></td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tglstatus); ?></span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alamat</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $alamat_kelompok;?></span></td>
        <td width="19%" height="24" class="style9">Alokasi Pinjaman</td>
        <td width="30%" height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi);?>,-</span></td>
      </tr>
      <tr>
		<td height="24" class="style9"> Desa </td>
		<td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$nama_desa";?></span></td>
		<td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$sistem_angsuran ($jangka bulan)";?></span></td>
	  </tr>
	  <tr>
		<td height="24" class="style9"> Ketua </td>
		<td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$ketua";?> </span></td>
        <td height="25" class="style9">Sistem Bagi Hasil </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa %/bulan, $nama_jj";?> </span></td>
      </tr>  
</table>
<br>

	  <table width="97%" border="0" align="center" cellpadding="5" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="2%" height="34" rowspan="2" class="style9 bottom top left right">No</th>
			  <th width="10%" rowspan="2" class="style9 bottom top">Nama Anggota</th>
              <th width="10%" rowspan="2" class="style9 left bottom top">TTL</th>
              <th width="10%" rowspan="2" class="style9 left bottom top">Nama Penjamin</th>
              <th width="3%" rowspan="2" class="style9 left bottom top">Masa<br/>Pinj.</th>
              <th  colspan="2" class="style9 left bottom top">Pinjaman</th>
              <th width="10%" rowspan="2" class="style9 left bottom top">Jumlah</th>
              <th width="10%" rowspan="2" class="style9 left bottom top">Premi<br/> (<?php echo "$besar_premi";?>%)</th>
			  <th width="10%" rowspan="2" class="style9 left bottom top">keterangan</th>
              <th rowspan="2" class="style9 left bottom top  right">TTD</th>
        </tr>      
		<tr>
			<th width="10%" class="style9 left bottom ">Pokok</th>
			<th width="10%" class="style9 left bottom ">Jasa</th>
		</tr>
	
		<?php 
		$view2=mysql_query("select *,DATEDIFF(CURDATE(),DATE(a.tgl_lahir))/365.25 AS diff from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa, keluarga k where pa.nia=a.id AND id_pinkel='$_SESSION[id_pinkel]' AND k.id=a.hubungan and alokasi>1 order by pa.id");
					$no=0;
								while($row=mysql_fetch_array($view2)){
								$no=$no+1;
								$row_nama			=$row['namadepan'];
								$row_tempat			=$row['tempat_lahir'];
								$row_tanggal		=$row['tgl_lahir'];
								$row_penjamin		=$row['penjamin'];
								$row_hubungan		=$row['kekeluargaan'];
								$row_jangka			=$row['jangka'];
								$row_pokok			=$row['alokasi'];
								if($j_a=="2"){
								$row_jasa			=$row['alokasi']*$pros_jasa/100*$row_jangka;
								}else{
								$row_jasa			="0";
								}
								$row_jumlah			=$row_jasa+$row_pokok;
								
								$usia_sekarang 		=$row['diff'];
								if($usia_sekarang>$u_max){
								$row_keterangan		= "Tidak dapat<br>asuransi";
								} else{
								$row_keterangan		= "Dapat<br>asuransi";
								}
								if($usia_sekarang>$u_max){
								$row_premi			="0";
								} else{
								$row_premi		= $row_jumlah*$besar_premi/100;
								}
								
								?>
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left "><div align="center" ><?php
			  //nomor
					echo "$no"; 
					
				
			  
			  ?></div></td>
              <td class="style9 top  left"><div align="left"><?php 
			  //Nama Anggota
			  
			  echo "$row_nama";
			  
			  ?></div></td>
			  <td class="style9 top  left"><div align="center"><?php 
			  //TTL
			  
			  echo "$row_tempat,<br>$row_tanggal";
			  
			  
			  ?></div></td>
			  <td class="style9 top  left"><div align="left"><?php 
			  //Penjamin
			  
			  echo "$row_penjamin ($row_hubungan)";
			  
			  ?></div></td>
			  <td class="style9 top  left"><div align="center"><?php 
			  //jangka
			  
			  echo "$row_jangka";
			  
			  ?></div></td>
			  
              <td class="style9 left top"><div align="right"><?php	
				
				//KOLOM POKOK
				echo number_format($row_pokok);
			  //echo "$pok<br><br>";} ?>
			  </div></td>
			  
              <td class="style9 left top"><div align="right"><?php 
				 
				//KOLOM JASA
				echo number_format($row_jasa);
			  //echo "".number_format($bayar_jasa)."<br><br>"; } ?></div></td>
			  
			  
              <td class="style9 left top"><div align="right"><?php 
				
				//KOLOM JUMLAH
				echo number_format($row_jumlah);
			  //echo "$jumlah<br><br>";}
			  
			  ?></div></td>
			  
			  <td class="style9 left top"><div align="right"><?php 
				
				//Premi
				echo number_format($row_premi);
			  ?></div></td>
			  
			  <td class='style9 left top ' width='8%'><div align='left'>
			  
			  
			  
			  
			  <?php
				//keterangan
			   echo "$row_keterangan"; ?></div></td>
			  
			  <?php 
				//ttd
				//echo "<td class='style9 left top ' width='8%'><div align='left'>$tgl_sekarang_bgt<br><br></div></td>"; 
				echo "<td class='style9 left top right'><div align='left'>$no<br><br></div></td>"; 
					/*if(($no%2)!=0){
						echo "<td class='style9 left top ' width='8%'><div align='left'>$no<br><br></div></td>"; 
					}else{
						echo "<td class='style9 left botom' width='8%'><div align='left'><br><br></div></td>";
					}
				
			  
				//ttd
					if(($no%2)==0){
						echo "<td class='style9 left botom right' width='8%'><div align='left'><br>$no</div></td>"; 
					}else{
						echo "<td class='style9 left top right' width='8%'><div align='left'><br><br></div></td>";
					}
				*/
			  ?>
            </tr>
			<?php } ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
		 <?php $view3=mysql_query("select pa.jangka AS jangka, sum(pa.alokasi) AS jpokok, sum(pa.alokasi*pa.pros_jasa/100*pa.jangka) AS jjasa from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa, keluarga k where pa.nia=a.id AND id_pinkel='$_SESSION[id_pinkel]' AND k.id=a.hubungan order by pa.id");
		 while($row=mysql_fetch_array($view3)){
								$jpokok			= $row['jpokok'];
								
								$jjumlah		= ($jpokok+$jjasa);
								$r_premi=mysql_fetch_array(mysql_query("select pa.jangka AS jangka, sum(pa.alokasi) AS jpokok, sum(pa.alokasi*pa.pros_jasa/100*pa.jangka) AS jjasa from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa, keluarga k where pa.nia=a.id AND id_pinkel='$_SESSION[id_pinkel]' AND k.id=a.hubungan AND (DATEDIFF(CURDATE(),DATE(a.tgl_lahir))/365.25) < $u_max order by pa.id")); 
								if($j_a=="2"){
								$jjasa		 	= $row['jjasa'];
								$jpremi			= ($r_premi['jpokok']+$r_premi['jjasa'])*$besar_premi/100;
								}else{
								$jjasa			="0";
								$jpremi			= ($r_premi['jpokok'])*$besar_premi/100;
								}
								$jangka			= $row['jangka'];
		  ?>
		 
		 <tr>
			<td colspan="5" height="34" class="style9 left bottom top">&nbsp;</td>
			<td width="10%" class="style9 left bottom top">&nbsp;</td>
			<td width="10%" class="style9 left bottom top">&nbsp;</td>
			<td width="10%" class="style9 left bottom top">&nbsp;</td>
			<td width="10%" class="style9 left bottom top">&nbsp;</td>
			<?php 
			  if(($no%2)==0){
						echo "
			  <th width='10%' class='style9 left bottom top'>&nbsp;</th>
			  <th width='10%' class='style9 bottom right top'>&nbsp;</th>"; 
					}else{
						echo "
			  <th width='10%' class='style9 left bottom'>&nbsp;</th>
			  <th width='10%' class='style9 left bottom right'>&nbsp;</th>";
					}
			  
			  ?>
		 </tr>
		 <tr>	  
          <th colspan="5" height="34" class="style9 left bottom top">Jumlah</th>
		  
              <th width="10%" class="style9 left bottom top"><?php echo number_format($jpokok); ?></th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($jjasa); ?></th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($jjumlah); ?></th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($jpremi); ?></th>
			  <th width="10%" class="style9 left bottom top">&nbsp;</th>
			  <th width="10%" class="style9 bottom right top">&nbsp;</th>
              
        </tr> 
		 <?php }?>
</table>
<br>	  
<table width="97%" align="center" cellpadding="3" cellspacing="0"> 
      <tr>
      <td align="center" colspan="3" class="style9" >&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
        </div></td>
        <td width="50%" colspan="2" class="style26"><div align="center" class="style9">
          <p><?php echo("$nama_kec");?>, <?php echo tgl_indo(date('Y-m-d'));?></p>
        </div></td>
      </tr>	
	<tr>
	    <td width="15%" class="style9 align-justify">&nbsp;</td>
      <td width="25%" class="style9 align-justify"><div align="center"><br>
       Ketua <?php echo "$sebutan_lvl1 $nama_lembaga";?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo "$ketuaupk[namadepan] $ketuaupk[namabelakang]";?></span></p>
      </div>        </td>
      <td width="51%" class="style9 align-justify"><div align="center"><br>
        <?php echo "$sebutan_lvl3 $nama_lembaga ";?>
             <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo "$bendaharaupk[namadepan] $bendaharaupk[namabelakang]";?></span></p>
      </div></td>
  </tr>
</table>
<title>Daftar Peserta Asuransi <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
