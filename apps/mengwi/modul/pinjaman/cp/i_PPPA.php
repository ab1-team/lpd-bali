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
			$r	=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us,
													keluarga k, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
																k.id=a.hubungan AND sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp' "));
																
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			

			
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
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo "$id_pinj";?></div></td>
	  </tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
	  
      <tr>
        <td height="15" colspan="6" class="bottom"><p align="center" class="style6">PENILAIAN PERMOHONAN PINJAMAN INDIVIDU<br>
		*) DIISI OLEH VERIFIKATOR
        </p></td>
      </tr>
      
      <tr>
        <td height="25" colspan="6" class="style27">A. IDENTITAS DEBITUR </td>
      </tr>
      
      <tr>
        <td width="4%" class="align-justify style9"><div align="right">1.</div></td>
        <td width="25%" class="align-justify style9">Nama Debitur</td>
        <td colspan="4" class="style27">: <?php echo strtoupper($r['namadepan']);?></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">2.</div></td>
        <td class="align-justify style9">Jenis Kelamin</td>
        <td colspan="4" class="style27">: <?= ($r['jk'] == 'L') ? 'Laki-laki':'Perempuan';?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">3.</div></td>
        <td height="0" class="align-justify style9">N I K</td>
        <td height="0" colspan="4" class="style27">: <?php echo $r['nik'];?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">4.</div></td>
        <td height="0" class="align-justify style9">Tempat, Tanggal Lahir </td>
        <td height="0" colspan="4" class="style27">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">5.</div></td>
        <td height="0" class="align-justify style9">Alamat</td>
        <td height="0" colspan="4" class="style27"><span class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></span></td>
      </tr>
      <tr>
        <td height="0" class="align-justify style9"><div align="right">6.</div></td>
        <td height="0" class="align-justify style9">No. Handphone</td>
        <td height="0" colspan="4" class="style27"><span class="style27">: <?php echo "$r[hp]";?></span></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">7.</div></td>
        <td class="align-justify style9">Jenis Usaha</td>
        <td colspan="4" class="style27">: <?php echo $r['nama_usaha'];?></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">8.</div></td>
        <td class="align-justify style9">Jumlah Kredit yang diminta</td>
        <td colspan="4" class="style27"><span class="style27">: <?php echo number_format($r['proposal']);?></span></td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">9.</div></td>
        <td class="align-justify style9">Sistem angsuran</td>
        <td colspan="4" class="style27">: <?php echo $r['nama_sistem'];?> (<?php echo $r['deskripsi_sistem'];?>)</td>
      </tr>
      <tr>
        <td class="align-justify style9"><div align="right">10.</div></td>
        <td class="align-justify style9">jangka waktu</td>
        <td colspan="4" class="style27">: <?php echo $r['jangka'];?> bulan</td>
      </tr>
 </table>     
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="25" colspan="6" class="align-justify style9"><strong>B. INFORMASI PENDAPATAN &amp; PENGELUARAN</strong></td>
      </tr>
      <tr>
        <td rowspan="6" align="right" valign="top" class="style9 align-justify"><div align="right">1.</div></td>
        <td width="60%" colspan="2" class="style9 align-justify">Pendapatan Keluarga 1 (satu) bulan</td>
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
        <td colspan="6" class="align-justify style9"><strong>C. IDENTITAS JAMINAN</strong></td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">1.</div></td>
        <td colspan="2" class="style9 align-justify">Tabungan di Bank/Koperasi/BMT atas nama pribadi</td>
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
        <td colspan="6" class="align-justify style9"><strong>D. PENILAIAN</strong></td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">1.</div></td>
        <td colspan="2" class="style9 align-justify">Ratio  pendapatan keluarga (bersih)  per bulan dibagi angsuran per bulan</td>
        <td colspan="3" class="style9 align-justify">: ............% (min 200%)</td>
      </tr>
      <tr>
        <td class="style9 align-justify"><div align="right">2.</div></td>
        <td colspan="2" class="style9 align-justify">Ratio tabungan di kelompok dibagi kredit yang diajukan</td>
        <td colspan="3" class="style9 align-justify">: ............% (min 20%)</td>
      </tr>
</table>
	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

    <tr>
      <td width="45%" class="style9 align-justify"><p><span class="style27"> E. KESIMPULAN</span><br>
        Debitur ini LAYAK / TIDAK LAYAK untuk diberikan kredit sebesar:<br>
        <br> 
        <strong><u></u>Rp. <?php echo number_format($r['alokasi']);?> </u></strong></p>
        <p>Dengan Catatan :<br><br><br><br>
		*) coret yang tidak perlu. </p>
      </td>
	    <td width="5%" height="20" colspan="-1" class="style9 align-justify"><p>&nbsp;</p>      </td>
        <td width="50%" colspan="2" class="style9"><p><br>
        Diverifikasi Pada : ................................................<br>
        Oleh : Tim Verifikasi <?php echo $row['sebutan_kec']; ?> <?php echo $nama_kec; ?><br>
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
</body>
<title>Surat Penilaian Individu</title>