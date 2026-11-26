<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.align-justify {text-align:justify; }
.style28 {font-size: 10px}
-->
</style>
<body onLoad="window.print()">

     	    <?php
			$rcp=$_GET['rcp'];
			$id_pinkel=$_GET['id_pinkel'];
			$r	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE 
			c.kd_kec=d.kd_kec AND d.id=k.desa AND k.id=pa.id_kel AND a.id=pa.nia AND a.id='$rcp' AND pa.id_pinkel='$id_pinkel' "));
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c WHERE b.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
			

			
			?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="3" class="bottom">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>			</td>
			<td height="20" colspan="3" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
            Loan ID. <?php echo $r['id_pinkel'];?></div></td>
  </tr> 	  
      <tr>
        <td height="15" colspan="6" class="bottom"><p align="center" class="style6">PENILAIAN PERMOHONAN PINJAMAN ANGGOTA KELOMPOK
        </p></td>
      </tr>
      
      <tr>
        <td height="25" colspan="6" class="style27">A. IDENTITAS PEMINJAM (ANGGOTA)</td>
      </tr>
      
      <tr>
        <td width="4%" class="align-justify style9"><div align="right">1.</div></td>
        <td class="align-justify style9">Nama anggota</td>
        <td colspan="4" class="style27">: <?php echo $r['namadepan'];?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">2.</div></td>
        <td height="0" class="align-justify style9">N I K</td>
        <td height="0" colspan="4" class="style27">: <?php echo $r['nik'];?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">3.</div></td>
        <td height="0" class="align-justify style9">Tempat, Tanggal Lahir </td>
        <td height="0" colspan="4" class="style27">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">4.</div></td>
        <td height="0" class="align-justify style9">Alamat</td>
        <td height="0" colspan="4" class="style27"><span class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></span></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">5.</div></td>
        <td class="align-justify style9">Jenis kelamin</td>
        <td colspan="4" class="style27">: <?php echo $r['jk'];?></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">6.</div></td>
        <td class="align-justify style9"><p> Lama menjadi anggota Kelompok</p></td>
        <td colspan="4" class="style27">:</td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">7.</div></td>
        <td class="align-justify style9">Pekerjaan pokok/utama</td>
        <td colspan="4" class="style27">:</td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">8.</div></td>
        <td class="align-justify style9">Jumlah Kredit yang diminta</td>
        <td colspan="4" class="style27"><span class="style27">: <?php echo number_format($r['alokasi']);?></span></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">9.</div></td>
        <td width="40%" class="align-justify style9">Jenis usaha yang akan dibiayai</td>
        <td colspan="4" class="style27">:</td>
      </tr>
      
      <tr>
        <td height="25" colspan="4" class="align-justify style9 left top"><strong>B. INFORMASI DALAM KELOMPOK</strong></td>
        <td width="7%" height="25" class="align-justify style9 left top"><div align="center"><strong>YA</strong></div></td>
        <td width="7%" height="25" class="align-justify style9 left top right"><div align="center"><strong>TIDAK</strong></div></td>
      </tr>
      
      <tr>
        <td class="style9 align-justify left top"><div align="right">1.</div></td>
        <td colspan="3" class="style9 align-justify top"><p>Apakah anggota ini aktif dalam pertemuan Kelompok</p></td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">2.</div></td>
        <td colspan="3" class="style9 align-justify top">Apakah anggota ini aktif memberikan usul, pendapat, saran dan sebagainya</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify  left top"><div align="right">3.</div></td>
        <td colspan="3" class="style9 align-justify  top">Apakah anggota ini menunjukkan sikap tenang dan terbuka</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">4.</div></td>
        <td colspan="3" class="style9 align-justify top">Apakah anggota ini jujur, disiplin, dan berusaha menepati janji</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">5.</div></td>
        <td colspan="3" class="style9 align-justify top">Apakah anggota ini bersedia membayar iuran-iuran di Kelompok</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">6.</div></td>
        <td colspan="3" class="style9 align-justify top"><p>Apakah anggota ini disiplin dalam membayar pinjamannya</p></td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">7.</div></td>
        <td colspan="3" class="style9 align-justify top">Apakah anggota ini rajin menabung di Kelompok</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top"><div align="right">8.</div></td>
        <td colspan="3" class="style9 align-justify top">Apakah bersedia menjaminkan harta/tabungan sebagai jaminan kredit yang diminta</td>
        <td class="style9 align-justify left top">&nbsp;</td>
        <td class="style9 align-justify left top right">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9 align-justify left top bottom"><div align="right">9.</div></td>
        <td colspan="3" class="style9 align-justify top bottom">Apakah bersedia menandatangani perjanjian kredit berdua (suami/istri/orang tua)</td>
        <td class="style9 align-justify left top bottom">&nbsp;</td>
        <td class="style9 align-justify left top bottom right">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="25" colspan="6" class="align-justify style9"><strong>C. INFORMASI PENDAPATAN &amp; PENGELUARAN</strong></td>
      </tr>
      <tr>
        <td rowspan="6" align="right" valign="top" class="style9 align-justify"><div align="right">1.</div></td>
        <td colspan="2" class="style9 align-justify">Pendapatan Keluarga 1 (satu) bulan</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pendapatan dari usaha suami</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pendapatan dari usaha istri</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pendapatan dari hasil kebun, sawah, ladang</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pendapatan lain-lain</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <th colspan="2" class="style9 align-justify"><div align="center" class="style28">Jumlah pendapatan </div></th>
        <td colspan="3" class="align-justify style9"><strong>: Rp. </strong></td>
      </tr>
      <tr>
        <td rowspan="10" valign="top" class="style9 align-justify"><div align="right">2.</div></td>
        <td colspan="2" class="style9 align-justify">Pengeluaran keluarga</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pembelian alat/barang dagangan</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran Kebutuhan Makan/minum</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran Sabun-Cuci-mandi</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran untuk Sekolah</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran untuk sosial</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran listrik, air, telphon dll</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Angsuran pinjaman di bank/koperasi/perorangan</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify">Pengeluaran lain-lain</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td colspan="2" class="style9 align-justify"><div align="center" class="style28"><strong>Jumlah Pengeluaran </strong></div></td>
        <td colspan="3" class="align-justify style9"><strong>: Rp. </strong></td>
      </tr>
      <tr>
        <td colspan="6" class="align-justify style9"><strong>D. IDENTITAS JAMINAN</strong></td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">1.</div></td>
        <td colspan="2" class="style9 align-justify">Tabungan di Kelompok atas nama pribadi</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">2.</div></td>
        <td colspan="2" class="style9 align-justify">Nilai harta lain berupa ...............................................</td>
        <td colspan="3" class="style9 align-justify">: Rp. </td>
      </tr>
      <tr>
        <td class="style9 align-justify">&nbsp;</td>
        <td colspan="2" class="style9 align-justify"><div align="center" class="style28"><strong>Total Nilai Jaminan</strong></div></td>
        <td colspan="3" class="style9 align-justify"><strong>: Rp. </strong></td>
      </tr>
      <tr>
        <td colspan="6" class="align-justify style9"><strong>E. PENILAIAN</strong></td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">1.</div></td>
        <td colspan="2" class="style9 align-justify">Ratio  pendapatan keluarga (bersih)  per bulan dibagi angsuran per bulan</td>
        <td colspan="3" class="style9 align-justify">: ......% (min 200%)</td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">2.</div></td>
        <td colspan="2" class="style9 align-justify">Ratio tabungan di kelompok dibagi kredit yang diajukan</td>
        <td colspan="3" class="style9 align-justify">: ......% (min 20%)</td>
      </tr>
</table>
	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

    <tr>
      <td width="45%" class="style9 align-justify"><p><span class="style27"> F. KESIMPULAN</span><br>
        Anggota/peminjam ini LAYAK / TIDAK LAYAK untuk diberikan kredit sebesar:<br>
        <br> 
        <strong>Rp.</strong> .............................................. </p>
        <p>Dengan Catatan :<br><br><br><br>
		*) coret yang tidak perlu. </p>
      </td>
	    <td width="5%" height="20" colspan="-1" class="style9 align-justify"><p>&nbsp;</p>      </td>
        <td width="50%" colspan="2" class="style9"><p><br>
        Diverifikasi Pada : ................................................<br>
        Oleh : Tim Verifikasi Kecamatan  <?php echo $nama_kec; ?><br>
        </p>
		<?php
		$dtv=mysql_query("SELECT * FROM jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi='$_SESSION[lokasi]' AND u.level='4' AND u.hingga<=0 AND u.status='1' ");
		while($tv=mysql_fetch_array($dtv)){
		echo "
			<table width='100%'>
				<tr>
				<td width='60%' class='style27'>".strtoupper($tv['namadepan'])." ".strtoupper($tv['namabelakang'])."<br>
				<span class='style9'>(".$tv['nama_jabatan'].")</span></td>
				<td width='30%' class='bottom'></td>
				</tr>
				<tr><td height='3'>$nbsp</td></tr>
			</table>";
		}
		?>      </td>
  </tr>
</table>
<?php if ($_SESSION['lokasi']=='198') { ?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

    <tr>
      <td width="36%" class="style9 align-justify"></td>
      <td width="20%" height="20" colspan="-1" class="style9 " align="center">Calon Penerima Manfaat<br><br><br><br><br><br> <b><?php echo $r['namadepan'];?></b></td>
      <td width="36%" colspan="2" class="style9"></td>
  </tr>
</table>

<?php }?>

</body>
<title>Surat Pernyataan Anggota  <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>