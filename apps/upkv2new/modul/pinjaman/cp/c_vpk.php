<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

<?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT *, pk.id as id_pinj FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,  jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan  AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND  jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id_pinj'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang'];
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
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

											if($status=='P'){
											$judul="LEMBAR PENILAIAN VERIFIKASI";
											$catatan_verifikasiv="";
											$tgl_verifikasiv	="";
											$alokasiv			="";
											$pros_jasav			="";
											$jangkav			="";
											$sistem_angsuranv	="";
											$dok				="Proposal";
											}else{
											$judul="LEMBAR HASIL PENILAIAN VERIFIKASI";
											$catatan_verifikasiv=$row['catatan_verifikasi'];
											$alokasiv			=number_format($row['alokasi']);
											$tgl_verifikasiv	=tgl_ind($row['tgl_verifikasi']);
											$pros_jasav			=$row['pros_jasa']. " %";
											$jangkav			=$row['jangka']. " kali";
											$sistem_angsuranv	=$row['nama_sistem'];
											$dok				="Verifikasi";
											}
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
    
      echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
      ?>
      </td>
      <td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen <?php echo $dok;?><br>
	SN. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
	 Lamp-7 </div></td>
    </tr> 
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		<?php echo $judul;?> <br>
		<span class="fw-semi-bold">PINJAMAN KELOMPOK BERGULIR </p></td>
      </tr>
      
      
      <tr>
        <td height="20" colspan="4" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="4" class="style27">IDENTITAS KELOMPOK </td>
      </tr>
      <tr>
        <td height="20" class="style9">ID Kelompok </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $kd_kelompok;?></span></td>
        <td height="20" class="style9">Tanggal Berdiri </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_berdiri);?></span></td>
      </tr>
      <tr>
        <td width="191" height="20" class="style9">Nama Kelompok</td>
        <td width="360" height="20"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($nama_kelompok);?></span></td>
        <td width="153" height="20" class="style9">Jenis Produk Pinj. </td>
        <td width="331" height="20"><span class="style9">:</span><span class="style27"> <?php echo $nama_jpp;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9">Alamat</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $alamat_kelompok;?></span></td>
        <td height="20" class="style9">Jenis Usaha </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $jenis_usaha;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9"><?php echo "$row[sebutan_desa]"; ?></td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $nama_desa;?></span></td>
        <td height="20" class="style9">Jenis Kegiatan </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $jenis_kegiatan;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9">Kecamatan</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $nama_kec; ?></span></td>
        <td height="20" class="style9">Tingkat Kelompok </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $tingkat_kelompok;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9">Telpon</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $telpon; ?></span></td>
        <td height="20" class="style9">Fungsi Kelompok </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $fungsi_kelompok;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9">Nama Ketua </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $ketua; ?></span></td>
        <td height="20" class="style9">Last Update </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $lu;?></span></td>
      </tr>
      <tr>
        <td height="20" class="style9">Nama Sekretaris</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $sekretaris; ?></span></td>
        <td height="20" class="style9">Petugas/PJ</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo "$nama_user";?></span></td>
      </tr>
</table>
<br>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">    
      <tr>
        <td height="20" colspan="6" class="style27 bottom">DATA  PINJAMAN KELOMPOK </td>
      </tr>
	  <tr>
	    <th width="24%" height="20" class="style9 all">ID.Reg. #<?php echo $id_pinj;?></th>
	    <th width="15%" class="style9 top bottom">TANGGAL</th>
	    <th width="19%" class="style9 all">ALOKASI</th>
	    <th width="14%" class="style9 top bottom">JASA</th>
	    <th width="15%" class="style9 top bottom left">JANGKA</th>
	    <th width="13%" class="style9 all">SISTEM </th>
  </tr>
	  <tr>
	    <td height="30" class="style27 left right">DATA PROPOSAL</td>
	    <td class="style9"><div align="center"><?php echo tgl_ind($tgl_proposal);?></div></td>
	    <td class="style9 left right"><div align="center"><?php echo number_format($proposal);?></div></td>
	    <td class="style9"><div align="center"><?php echo "$pros_jasa %, $jenis_jasa";?> </div></td>
	    <td class="style9 left"><div align="center"><?php echo $jangka;?> kali </div></td>
	    <td class="style9 left right"><div align="center"><?php echo $sistem_angsuran;?> </div></td>
  </tr>
	  <tr>
	    <td height="30" class="style27  top left right">DATA VERIFIKASI </td>
	    <td  class="style9 top"><div align="center"><?php echo $tgl_verifikasiv;?></div></td>
	    <td class="style9 top left right"><div align="center"><?php echo $alokasiv;?></div></td>
	    <td class="style9 top"><div align="center"><?php echo "$pros_jasav, $jenis_jasa";?> </div></td>
	    <td class="style9 top left"><div align="center"><?php echo $jangkav;?></div></td>
	    <td class="style9 top left right"><div align="center"><?php echo $sistem_angsuranv;?> </div></td>
  </tr>
	  <tr>
	    <td height="30" class="style27  top left">CATATAN VERIFIKASI </td>
	    <td colspan="5"  class="style9 top right">: <?php echo $catatan_verifikasiv;?></td>
  </tr>
	  <tr>
        <td height="30" colspan="6" class="style27  left right bottom">&nbsp;</td>
      </tr>
</table>
<br>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">    
      <tr>
        <td height="20" colspan="5" class="style27 bottom">DATA  PINJAMAN ANGGOTA </td>
      </tr>
	  <tr>
	    <th width="5%" height="20" class="style9 all">NO</th>
	    <th width="22%" class="style9 top bottom">NAMA ANGGOTA </th>
	    <th width="17%" class="style9 all">PROPOSAL (Rp.) </th>
	    <th width="22%" class="style9 top bottom">REKOMENDASI (Rp.) </th>
	    <th width="34%" class="style9 all">CATATAN</th>
      </tr>
	  <?php
		$dpa=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_pinkel='$id_pinj' AND pa.id_kel='$id_kel' order by pa.id");
		while($pa=mysql_fetch_array($dpa)){
		$no=$no+1;
		
											if($status!='P'){
											$catatan_anggotav	=$pa['catatan_verifikasi'];
											$alokasiap			=number_format($pa['alokasi']);
											$alokasiav			=$pa['alokasi'];
											}elseif($status=='P'){
											$catatan_anggotav	="";
											$alokasiap			="";
											$alokasiav			="";
											}
		?>
	  <tr>
	    <td height="30" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom"><?php echo $pa['namadepan'];?></td>
	    <td class="style9 left right bottom"><div align="right"><?php echo number_format($pa['proposal']);?></div></td>
	    <td class="style9 bottom"><div align="right"><?php echo $alokasiap;?></div></td>
	    <td class="style9 left bottom right"><?php echo $catatan_anggotav;?></td>
	</tr>
  <?php 
  $totproposal=$totproposal+$pa['proposal'];
  $totalokasi	=$totalokasi+$alokasiav;
  } ?>
  <tr>
	    <td height="30" class="style27 left bottom align-center" colspan="2">Jumlah</td>
	    <td class="style27 left right bottom"><div align="right"><?php echo number_format($totproposal);?></div></td>
	    <td class="style27 bottom"><div align="right"><?php echo number_format($totalokasi);?></div></td>
	    <td class="style9 left bottom right"></td>
	</tr>
</table>
	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

    <tr>
      <td width="45%" class="style10 align-justify"><p><span class="style27"> Verified Sign:</span><br>
        Tim Verifikasi Unit Pengelola Kegiatan Kecamatan <?php echo $nama_kec; ?> menyatakan dengan sebenar-benarnya sesuai dengan hasil survey lapangan bahwa kelompok dengan identitas tersebut diatas <span class="style27">ADA/TIDAK ADA</span>*)  keberadaannya dan dapat dipertanggungjawabkan sesuai dengan peraturan yang berlaku. Serta <span class="style27">LAYAK/TIDAK LAYAK</span>*) untuk diberikan pinjaman sesuai dengan hasil rekomendari Verifikasi diatas.<br>
		Form ini digunakan sebagai dasar Verified pada SI UPK Online. </p>
        <p>*) coret yang tidak perlu. </p></td>
	    <td width="5%" height="20" colspan="-1" class="style9 align-justify"><p>&nbsp;</p>      </td>
        <td width="50%" colspan="2" class="style9"><p>Diverifikasi Oleh,<br>Tim Verifikasi Kecamatan  <?php echo $nama_kec; ?><br>
        </p>
		<?php
		$dtv=mysql_query("SELECT * FROM jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi='$lokasi' AND u.level='4' AND u.hingga<=0 AND u.status='1' ORDER By j.id ASC");
		while($tv=mysql_fetch_array($dtv)){
		echo "
			<table width='100%'>
				<tr>
				<td width='60%' class='style27'>".strtoupper($tv['namadepan'])." ".strtoupper($tv['namabelakang'])."<br>
				<span class='style9'>(".$tv['nama_jabatan'].")</span></td>
				<td width='30%' class='bottom'></td>
				</tr>
				<tr><td height='10'>$nbsp</td></tr>
			</table>";
		}
		?>      </td>
  </tr>
</table>
<div style="page-break-after: always;">
</div>
<?php } ?>        
</body>
<title><?php echo "$judul $nama_kelompok $nama_desa"; ?></title>