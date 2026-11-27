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
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND d.sebutan=sd.id AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$nama_bkad_sort     =$row['nama_bkad_sort'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$ttd_saksi			=$row['ttd_saksi'];
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

	if($status=="P") {$dok="Proposal"; $judul="DAFTAR USULAN"; $tanggal=$tgl_proposal; $tempat="Diusulkan di"; $lembar="Lamp-4";}
	else if ($status=="V") {$dok="Verified"; $judul="DAFTAR USULAN"; $tanggal=$tgl_verifikasi; $tempat="Diusulkan di"; $lembar="Lamp-4";}
    else {$dok="Pencairan"; $judul="TANDA TERIMA"; $tanggal=$tgl_cair; $tempat="Dicairkan di"; $lembar="Lembar-1";}

$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tanggal' "));
$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tanggal' "));
											

				
			?>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
      <td height="20" colspan="2" class="bottom" width="5%">
        <?php
        $logo=$row['logo'];
          if (empty($logo)) {
            echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
            }else{
            echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
            }
            echo "</td>";
            echo "<td class='bottom'>";
                      
      $nomor_bh =$row ['nomor_bh'];
      if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
    
      echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
      ?>
      </td>
      <td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen <?php echo $dok;?><br>
      Loan ID. <?php echo $id_pinj;?>
       <?php echo $lembar;?> </div></td>
    </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		<?php echo $judul;?><br>
		<span class="fw-semi-bold">PINJAMAN ANGGOTA</p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="191" height="24" class="style9">Nama Kelompok</td>
        <td width="360" height="24"><span class="style9">:</span><span class="style27"> <?php echo $nama_kelompok;?></span></td>
        <td width="153" height="24" class="style9">Alokasi Pinjaman</td>
        <td width="331" height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi);?>,-</span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alamat</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $alamat;?> <?php echo $nama_desa;?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $sistem_angsuran;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">Tanggal <?php echo $dok;?></td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tanggal); ?></span></td>
        <td height="25" class="style9">Prosentase Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa % $jenis_jasa/bulan";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">Nomor SPK. </td>
        <td height="25" class="style9">: <span class="style27"> <?php echo $row['spk_no'];?></span></td>
        <td height="25" class="style9">Pinjaman Ke- </td>
        <td height="24"><span class="style9">:</span></td>
      </tr>
      <tr>
        <td height="25" class="style9">&nbsp;</td>
        <td height="25" class="style27">&nbsp;</td>
        <td height="25" class="style9">&nbsp;</td>
        <td height="25" class="style27">&nbsp;</td>
      </tr>
</table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
			<th width="15%" class="style9 left bottom top" >N I K </th>
              <th width="18%" class="style9 left bottom top">Nama Anggota </th>
              <th width="5%" class="style9 left bottom top">Usia </th>
              <th width="2%" class="style9 left bottom top">JK</th>
			  <th width="15%" class="style9 left bottom top">Nomor HP	  </th> 
              <th width="22%" class="style9 left bottom top">Alamat Anggota </th>
              <th width="12%" class="style9 left bottom top">Alokasi Pinjaman Anggota </th>
              <th width="15%" class="style9 left bottom top right">Tanda Tangan </th>
        </tr>      
		
<?php 	
		$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj' AND alokasi>1");  /* query hitung jumlah anggota */
		$jml_anggota=mysql_num_rows($angg);
		$no=0;
		while($data=mysql_fetch_array($angg)){
		$nia=$data['nia'];
		$alok_anggota=$data['alokasi'];
		
		$anggota=mysql_query("select *,YEAR(curdate()) - YEAR(tgl_lahir) AS usia from anggota_$_SESSION[kd_kab] a, usaha u WHERE a.id='$nia' AND a.usaha = u.id  order by namadepan ASC");  /* untuk memunculkan ke tabel tampil */	
		while($row6=mysql_fetch_array($anggota)){
						  
						  $nama_anggota		=$row6['namadepan'];
						  $id_anggota		=$row6['nik'];
						  $jenis_kelamin	=$row6['jk'];
						  $hp				=$row6['hp'];  
						  $tempat_lahir		=$row6['tempat_lahir'];
						  $tgl_lahir		=$row6['tgl_lahir'];
						  $usia				=$row6['usia'];
						  $alamat_anggota	=$row6['alamat'];
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $id_anggota;?></div></td>
              <td class="style9 left top"><?php echo $nama_anggota; ?></td>
              <td class="style9 left top"><div align="center"><?php echo $usia; ?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $jenis_kelamin; ?></div></td>
              <td class="style9 left top"><?php if($hp=$hp AND $hp!='08'){ echo $hp;}else{echo "<div align='center'> - </div>";} ?></td>  
              <td class="style9 left top"><span class="style9"><?php echo substr($alamat_anggota,0,50);?></span></td>
              <td class="style9 left top"><div align="right"><?php echo number_format($alok_anggota);?>,-</div></td>
              <td class="style9 left top right"><?php echo $no;?>.</td>
            </tr>
  <?php 
  $sum_anggota=$sum_anggota+$alok_anggota;
  } } ?>
			<tr>
              <td height="33" class="style9 top left" colspan="7"><div align="center" >JUMLAH</div></td>
              <td class="style9 left top"><div align="right"><?php echo number_format($sum_anggota);?>,-</div></td>
              <td class="style9 left top right"></td>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      
      <tr>
        <td  colspan="3" class="top">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
        <td width="18%" class="style9"><?php echo $tempat; ?> </td>
        <td width="33%" class="style9">: <?php echo substr($row['wt_cair'],6); ?></td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
        <td class="style9">Pada Tanggal </td>
        <td class="style9">: <?php echo tgl_indo($tanggal); ?></td>
      </tr>
      		<?php 
		if($_SESSION['lokasi']==267){ //ttd ketua UPK di proposal dihilangkan
			if($status=="P" OR $status=="V"){
			$ketua_lembaga 	= " ";
			$nama_ketua		= " ";
		}else{
			$ketua_lembaga 	= "$row[sebutan_level_1] $row[nama_lembaga_sort]";
			$nama_ketua		= ("$ketuaupk[namadepan] $ketuaupk[namabelakang]");
		}}else{
			$ketua_lembaga 	= "$row[sebutan_level_1] $row[nama_lembaga_sort]";
			$nama_ketua		= ("$ketuaupk[namadepan] $ketuaupk[namabelakang]");
		}
		?>
      <tr>
        <td width="49%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><?php echo  $ketua_lembaga;?></p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
          <p>Ketua Kelompok </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo $nama_ketua; ?></p></th>
        <th colspan="2" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo ($ketua); ?></p></th>
  </tr>
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td colspan="2" class="style9">&nbsp;</td>
      </tr>
      
      <?php if($ttd_saksi=="1") { ?> 	  
      <tr>
        <td class="style9" colspan="3"><div align="center">Mengetahui sekaligus menjadi Saksi,<br><?php echo "$row[sebutan_kades] $nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="3"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo ($row['kades']);?></b> <?php if(!empty($row['nip']) or $row['nip']>0) { echo "<b>$row[pangkat]</b> <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="2") { ?> 	  
      <tr>
        <td class="style9" colspan="3"><div align="center">Mengetahui sekaligus menjadi Saksi,<br>Ketua <?php echo $nama_bkad_sort; ?> <?php echo "$sebutan_kec $nama_kec";?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="3"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo ("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="3") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui sekaligus menjadi Saksi,</div></td>
      </tr>
      <tr>
        <td class="style9">
            <?php if ($_SESSION['lokasi']=='248') { ?>
              <div align="center">Ketua BKD <br> 
            </div>
            <?php }else{?>
              <div align="center">Ketua <?php echo $nama_bkad_sort; ?> <br> <?php echo "$sebutan_kec $nama_kec";?>
            </div>
            <?php } ?>
              
        </td>
        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <?php if ($_SESSION['lokasi']=='248') { ?>
          <p>................</p>
        <?php }else{?>
          <p><?php echo ("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p>
        <?php } ?>  
        </th>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo ($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="4") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui sekaligus menjadi Saksi,</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center">Saksi 1</div></td>
        <td class="style9" colspan="2"><div align="center">Saksi 2</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>___________________</p></div></td>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>___________________</p></div></td>
      </tr>
<?php } ?>
      
      <tr>
        <td height="19" colspan="3" class="style9">&nbsp;</td>
      </tr>
</table>
<title>3. Tanda Terima <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
