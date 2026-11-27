<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-align:center; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$nama_bkad_sort     =$row['nama_bkad_sort'];
											
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$alokasi			=$row['alokasi'];
											$prov               =($row['provisi']*$row['alokasi'])/100;
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
											
											$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
											$nama_lembaga_long	=$row ['nama_lembaga_long'];
											$nama_bp_sort		=$row ['nama_bp_sort'];
											$nama_tv_long		=$row ['nama_tv_long'];

											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabp			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='3' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuamgw           =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$tgl_cair' "));

											
											
											$spk_no				=$row['spk_no'];
											$nik				=$row['nik'];
											$namadepan			=$row['namadepan'];
											$alamat				=$row['alamat'];
											$telpon				=$row['telpon'];
											$tempat_lahir		=$row['tempat_lahir']; 
											$tgl_lahir			=$row['tgl_lahir'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_usaha'];
											$jenis_kelamin		=$row['jk'];
											$nomor_kk			=$row['kk'];
											$penjamin			=$row['penjamin'];
											$hubungan			=$row['hubungan'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$tgl_now			=date('Y-m-d');
											
											$nama_kec = $_SESSION['unit'];
				
			?>
	
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $_SESSION[unit] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$row[id_pinkel]-$id_pinj";?>
			 SPK-Anggota </div></td>
	  </tr> 
</table>

<p class="style16">
	<br><b><u>Bukti Pengeluaran Kredit</u><br><br>
	
	<span class="style28">Nomor : <?php echo $spk_no;?><br>Tanggal : <?php echo tgl_indo($tgl_cair);?></span><br><br>
</p>
<?php
$provisi = mysql_fetch_array(mysql_query("SELECT jumlah as jum FROM `transaksi_163` WHERE `rekening_debit` LIKE '111.04'"));
$administrasi = mysql_fetch_array(mysql_query("SELECT jumlah as jumad FROM `transaksi_163` WHERE `rekening_debit` LIKE '111.05'"));
$ttd = mysql_fetch_array(mysql_query("SELECT *  FROM `tanda_tangan` WHERE `level` =1 "));

?>

	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
            <tr>
                <td width="100">&nbsp;</td>
                <td width="5" align="right">1.</td>
                <td width="75">Biaya Provisi</td>
                <td width="5" align="right">:</td>
                <td width="5">Rp.</td>
                <td width="100" align="right"><?= number_format($prov)?>.-</td>
                <td width="150"></td>
            </tr>
            <tr>
                <td width="100">&nbsp;</td>
                <td width="5" align="right">2.</td>
                <td width="75">Biaya Administrasi</td>
                <td width="5" align="right">:</td>
                <td width="5">Rp.</td>
                <td width="100" align="right"><?= number_format($administrasi['jumad'])?>.-</td>
                <td width="150"></td>
            </tr>
            <tr>
                <td width="100">&nbsp;</td>
                <td width="5">&nbsp;</td>
                <td width="5" colspan="5"><b>_______________________________________________________________________________________________________________</td>
            </tr>
            <?php
            $angka1 = $prov;
            $angka2 = $administrasi['jumad'];
            $hasil = $angka1 + $angka2
            ?>
            <tr>
                <td width="100">&nbsp;</td>
                <td width="5" align="right"></td>
                <td width="75"><b>JUMLAH BIAYA</td>
                <td width="5" align="right"><b>:</td>
                <td width="5"><b>Rp.</td>
                <td width="100" align="right"><b><?= number_format($hasil)?>.-</td>
                <td width="150"></td>
            </tr>
        </table><br><br><br><br>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                <td width="100">&nbsp;</td>
                <td width="100" align="right"></td>
                <td width="175"></td>
                <td class="style9" width="200" align="center"><?php echo $row['nama_kec'];?>, <?php echo tgl_indo($tgl_cair);?></td>
                <td width="150"></td>
            </tr>
            <tr>
                <td width="100">&nbsp;</td>
                <td class="style9" width="200" align="center">Dikeluarkan Oleh<br>Bendahara</td>
                <td width="175"></td>
                <td class="style9" width="200" align="center">Diterima Oleh<br>Debitur/Peminjam</td>
                <td width="150"></td>
            </tr>
            <tr>
                <td width="200"colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td width="200"colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td width="200"colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td width="200"colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td width="100">&nbsp;</td>
                <td class="style9" width="200" align="center"><b><?php echo strtoupper($ketuamgw['namadepan']);?> <?php echo strtoupper($ketuamgw['namabelakang']);?></b></td>
                <td width="175"></td>
                <td class="style9" width="100" align="center"><b><?php echo strtoupper($row['namadepan']);?></td>
                <td width="150"></td>
            </tr>
        </table>

<title>Bukti Pengeluaran Kredit <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>