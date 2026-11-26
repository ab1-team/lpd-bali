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
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.sebutan=sd.id AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=number_format($row['pros_jasa'],2);
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
											$ttd_pdua			=$row['ttd_pdua'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
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
							
			                                $bendahara          = $row['bendahara'];
			 //tanda_tangan
			$ttd_saksi	        = $row['ttd_saksi'];
            $ttd_mengetahui		= $row['ttd_mengetahui'];
            $ttd_pdua			= $row['ttd_pdua'];
            $ttd_psatu			= $row['ttd_psatu'];
        if      ($ttd_psatu=="1") {$psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' "); }
        else if ($ttd_psatu=="2"){ $psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]'AND u.jabatan='7' "); }
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
      <td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
	  Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
	  Lembar-1 </div></td>
    </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		SURAT KUASA <br>
		<span class="fw-semi-bold">PENANDATANGANAN SPK</p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9"><div align="justify">Yang bertanda tangan dibawah ini, anggota kelompok <span class="style27"><?php echo $nama_kelompok;?></span> (<?php echo $nama_jpp; ?>) <?php echo "$row[sebutan_desa]"; ?> <span class="style27"><?php echo $nama_desa;?> </span><span class="style9"> <?php echo $sebutan_kec;?> <span class="style27"><?php echo $nama_kec;?> </span><span class="style9">memberikan kuasa sepenuhnya kepada : </span></span></div></td>
      </tr>
	  <tr>
        <td height="25" class="style9">Nama Lengkap<br>
			Jabatan <br>
			Alamat </td>
        <td height="25" colspan="23" class="style27">: <?php echo $ketua; ?> <br>: Ketua Kelompok <?php echo $nama_kelompok;?>
        <?php echo "$row[sebutan_desa] $nama_desa"; ?>        <br> : <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?></td>
      </tr>
	  <?php if($ttd_pdua=="2") { ?> 
      <tr>
        <td height="25" class="style9">Nama Lengkap<br>
          Jabatan <br>
          Alamat </td>
        <td height="25" colspan="23" class="style27">: <?php echo $sekretaris; ?> <br>
          : Sekretaris Kelompok <?php echo $nama_kelompok;?>
           <?php echo "$row[sebutan_desa] $nama_desa"; ?>          <br>
          : <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?></td>
      </tr>
      <?php } ?>
      
      <tr>
        <td height="24" colspan="4" class="style9"><div align="justify">Untuk bertindak mewakili Kelompok dalam perjanjian kredit dengan <?php echo "$row[nama_lembaga_long] ($row[nama_lembaga_sort])"; ?> <?php echo $sebutan_kec;?> <span class="style27"><?php echo $nama_kec;?></span> sesuai dengan registrasi pinjaman nomor  <strong><?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></strong> dan data pinjaman sebagai berikut : </div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Tanggal Pencairan</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_cair); ?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"d> <?php echo $sistem_angsuran;?></span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alokasi Pinjaman</td>
        <td height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi,0,'.',',');?>,-</span></td>
        <td height="25" class="style9">Prosentase Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $pros_jasa;?> % per bulan</span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Nomor SPK. </td>
        <td height="25" colspan="3">: <span class="style27"><?php echo $row['spk_no'];?></span></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9">Demikian surat kuasa ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.</td>
      </tr>
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
        <td height="25" class="style9"><span class="style9"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_cair); ?></span></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
</table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="bottom top">
      <tr>	  
          <th width="55" height="34" class="style9 bottom">No</th>
			<th width="158" class="style9 bottom" >N I K </th>
              <th width="316" class="style9 bottom">Nama Anggota <br>selaku Pemberi Kuasa </th>
              <th width="35" class="style9 bottom">JK</th>
              <th width="222" class="style9 bottom">Alamat Anggota </th>
              <th width="235" class="style9 bottom">Tanda Tangan </th>
        </tr>      
		
<?php 	
		$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj' AND alokasi>1 ");  /* query hitung jumlah anggota */
		$jml_anggota=mysql_num_rows($angg);
		$no=0;
		while($data=mysql_fetch_array($angg)){
		$nia=$data['nia'];
		
		$anggota=mysql_query("select * from anggota_$_SESSION[kd_kab] where id='$nia' order by namadepan ASC");  /* untuk memunculkan ke tabel tampil */	
		while($row6=mysql_fetch_array($anggota)){
						  
						  $nama_anggota=$row6['namadepan'];
						  $id_anggota=$row6['nik'];
						  $jenis_kelamin=$row6['jk'];
						  $tempat_lahir=$row6['tempat_lahir'];
						  $tgl_lahir=$row6['tgl_lahir'];
						  $alamat_anggota=$row6['alamat'];
						  $nomor_hp=$row6['hp'];
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9"><div align="center"><?php echo $id_anggota;?></div></td>
              <td class="style9"><?php echo $nama_anggota; ?></td>
              <td class="style9"><div align="center"><?php echo $jenis_kelamin; ?></div></td>
              <td class="style9"><span class="style9"><?php echo $alamat_anggota;?></span></td>
              <td class="style9"><?php echo $no;?>.</td>
            </tr>
  <?php
  } 
  }
  ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
    <td class="style9 align-center" valign="top" width="31%">
    <p align="center"> Mengetahui,</p>
   	<?php
			$no=0;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				
				while($upk=mysql_fetch_array($psatu)){
				$upk_namadepan  =$upk['namadepan'];
				$upk_namabelakang =$upk['namabelakang'];
				$jabatan	=$upk['jabatan'];
			    if($jabatan=="1") {$nama_jabatan=$row['sebutan_level_1'];}
			    else if ($jabatan=="7") {$nama_jabatan=$row['sebutan_level_7'];}
			
				$no=$no+1;
				}
					echo" <td class='style9' width='auto'><center><u><b>$upk_namadepan $upk_namabelakang</b></u><br>$nama_jabatan</center></td>";
					
				echo"</tr>
			</table>"; ?>
         
    </td>
    <td class="style9 align-center" valign="top" width="31%">
    <p align="center"> Penerima Kuasa,</p>
   	<?php
			$no=0;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				
				$ketua_kelp =$row['ketua'];
				$sek_kelp  =$row['sekretaris'];
				$ben_kelp  =$row['bendahara'];
				
			    if($ttd_pdua=="1") {
			        $p2 = [
			            [
			                "nama" => $ketua_kelp,
			                "jabatan" => "Ketua"
			            ]
			        ];
			    }
			    else if($ttd_pdua=="2") {
			        $p2 = [
			            [
			                "nama" => $ketua_kelp,
			                "jabatan" => "Ketua"
			            ],
			            [
			                "nama" => $sek_kelp,
			                "jabatan" => "Sekretaris"
			            ]
			        ];
			    }
			    else if($ttd_pdua=="3") {
			       $p2 = [
			            [
			                "nama" => $ketua_kelp,
			                "jabatan" => "Ketua"
			            ],
			            [
			                "nama" => $sek_kelp,
			                "jabatan" => "Sekretaris"
			            ],
			            [
			                "nama" => $ben_kelp,
			                "jabatan" => "Bendahara"
			            ]
			        ]; 
			    }
			    else if($ttd_pdua=="4") {
			        $p2 = [
			            [
			                "nama" => $ketua_kelp,
			                "jabatan" => "Ketua"
			            ],
			            [
			                "nama" => $ben_kelp,
			                "jabatan" => "Bendahara"
			            ]
			        ];
			    }
				
				foreach ($p2 as $p) {
				    echo" <td class='style9' width='auto'><center><u><b>$p[nama]</b></u><br>$p[jabatan]</center></td>";
				}
					
				echo"</tr>
			</table>"; ?>
         
    </td>

</tr>
</table>

<title>3. Surat Kuasa <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa]"; ?> <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
