<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../js/bar128.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; padding:0 0 5px 5px;}
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.pull-right	{float: right; }
-->
</style>
<body onLoad="window.print()">

     	    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk, sistem_angsuran sa, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa
							WHERE b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=a.desa AND k.id=pk.id_kel AND a.id=pa.nia AND sa.id=pa.sistem_angsuran AND pk.id=pa.id_pinkel
							 AND pa.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = substr($tgl_cair,5,2);
											$tahun  			 = substr($tgl_cair,0,4);
											if($_SESSION['lokasi']=='2'){ //Khusus Tompobulu
											$pros_jasa			="14";
											}else if($_SESSION['lokasi']=='15'){ //Khusus Wedung
											$pros_jasa			="2";
											}else{
											$pros_jasa			=$row['pros_jasa'];
											}
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$tempo				=$jangka/$sistem;
											$temp				=$tempo/2;
											if($temp<=1) {$tempe="1"; $bulangs=$bulan+$sistem;} elseif($temp<=3) {$tempe="3"; $bulangs=$bulan+$sistem;} else{$tempe=$temp; $bulangs=$bulan+1;}
											$sistem_angsuran	=$row['nama_sistem'];
				
			?>
	
    <table width="88%" border="0" align="center" cellpadding="3" cellspacing="0">
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
			?>		</td>
			<td height="20" colspan="1" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$row[kd_kelompok]/$id_pinj/$row[id]";?>
			</div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		BUKTI TRANSAKSI / TANDA TERIMA<br>
		<span class="fw-semi-bold">PINJAMAN ANGGOTA</p></td>
      </tr>
	  <tr>
        <td height="0" colspan="4">&nbsp;</td>
      </tr>
	  <tr>
        <th colspan="4" class="style6 bottom"><BR></th>
      </tr>
	  <tr>
	    <th height="47" colspan="4" class="style6  left right"><span class="style9 pull-right">
	      <?php echo bar128(stripslashes("$row[kd_kelompok] $id_pinj $row[id]")); ?></span></th>
      </tr>
	  <tr>
	    <th height="47" colspan="4" class="style6  left right">K W I T A N S I</th>
      </tr>
	  <tr>
	    <td width="144" rowspan="11" class="style9 left">&nbsp;</td>
	    <td height="25" class="style9">&nbsp;</td>
	    <td colspan="2" class="right">&nbsp;</td>
      </tr>
	  <tr>
	    <td class="style9">Telah Diterima Dari </td>
	    <td colspan="2" class="style9 right">: <strong>UPK Kecamatan <?php echo $row['nama_kec']; ?></strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td class="style9">Uang Sebanyak </td>
	    <td colspan="2" class="right style9">: <strong><?php echo ucwords(toTerbilang($alokasi));?> Rupiah</strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td class="style9">Untuk Pembayaran </td>
	    <td colspan="2" class="right style9">: <strong>Pinjaman Anggota Kelompok <?php echo "$row[nama_kelompok]"; ?></strong>
        <p class="bottom"></td>
      </tr>
	  
	  <tr>
	    <th class="style9">&nbsp;</th>
	    <td colspan="2" class="right style9"><strong>&nbsp;&nbsp;a.n. <?php echo "$row[namadepan] NIK.$row[nik]"; ?></strong>
		<p class="bottom"></td>
      </tr>
	  <tr>
	    <th class="style9">&nbsp;</th>
	    <td colspan="2" class="right style9"> <strong>&nbsp;&nbsp;Beralamat di <?php echo "$row[alamat] $row[nama_desa] $row[nama_kec]"; ?></strong>
          <p class="bottom"></td>
      </tr>
	  <tr>
	    <th class="style9">&nbsp;</th>
	    <td colspan="2" class="right style9"><strong>&nbsp;&nbsp;Loan ID. <span class="style9"> <?php echo "$row[kd_kelompok]/$id_pinj/$row[id]";?></span></strong>
            <p class="bottom"></td>
	  </tr>
	  <tr>
	    <th class="style9">&nbsp;</th>
	    <th class="style9">&nbsp;</th>
	    <th class="style9 right">&nbsp;</th>
	  </tr>
	  <tr>
	    <th width="177" class="style9">&nbsp;</th>
	    <th class="style9">&nbsp;</th>
	    <td class="style9 right"><div align="center"><?php echo "$row[nama_desa], ".tgl_indo($tgl_cair) ?></div></td>
      </tr>
	  <tr>
	    <th rowspan="2" class="style9"><hr class="garis">
          Rp. <?php echo number_format($alokasi);?>,-
        <hr class="garis"></th>
	    <td class="style9"><div align="center">&nbsp;</div></td>
	    <td class="style9 right "><div align="center">Diterima oleh</div></td>
      </tr>
	  <tr>
	    <th width="310" class="style9"><br>
<br>
<br>
<br>
&nbsp;</th>
        <th width="295" class="style9 right "><br>
<br>
<br><br>
<?php echo strtoupper($row['namadepan']);?></th>
	  </tr>
	  <tr>
	    <td colspan="4" class="style9 right left">&nbsp;</td>
      </tr>
	  <tr><td colspan="4" class="style9 right bottom left">&nbsp;</td></tr>
</table>

<title>7. Kwitansi <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>

	  <?php } ?>        
</body>
