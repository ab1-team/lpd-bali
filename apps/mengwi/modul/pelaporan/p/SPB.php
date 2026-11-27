<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}



$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

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
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="17" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}

			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
			</tr> 
            <tr>
				<td height="25" colspan="6" class="style6 align-center"><br><b>SURAT PERINTAH PEMBAYARAN</b> <br></br></td></td>
			</tr>
			<tr>	  
          <th width="3%" height="34" class="style9 bottom top left">NO</th>
			<th width="23%" class="style9 left bottom top" >KETERANGAN</th>
              <th width="13%" class="style9 left bottom top">TANGGAL PELAKSANAAN</th>
              <th width="15%" class="style9 left bottom top">CASHFLOW</th>
			  <th width="15%" class="style9 left bottom top right ">PENGAMBILAN</th>
              
        </tr>
				<?php
				$view=mysql_query("select * from jenis_buku WHERE posisi='5' AND lokasi='0' OR posisi='5' AND lokasi='$_SESSION[lokasi]' ORDER by id ASC ");
					while($row2=mysql_fetch_array($view)){
				$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE kd_jb='$row2[kd_jb]' ORDER by kd_rekening ASC ");
					echo "
					<tr>
						<td colspan=5 class='style9 left bottom right'><strong>$row2[nama_jb]</strong> </td></tr>";
						$no=0;
							while($r=mysql_fetch_array($data)){
                                $no=$no+1;
								$urut="$r[kd_jb]$no";
								$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
									$angkarencana=$s['ra'];
									$kolom1 = "baris$urut";
									$kolom2 = "baris2$urut";
									$kd_rekening=$r['kd_rekening'];
								$cashflow=$_POST[$kolom1]; 
								$pengemb=$_POST[$kolom2]; 
								if (empty($cashflow)){}else{
        

        ?>
        
        <!-- Menampilkan isi tabel -->
        <tr>
              <td height="33" class="style9 left  bottom"><div align="center" ><?php echo $no;?></div></td>
              <td class="style9 left bottom"> <?php echo $r['nama_rekening']; ?> </td>
              <td class="style9 left bottom"><div align="center">  <?php echo tgl_indo($_POST['tanggal']); ?> </div></td>
              <td class="style9 left bottom"><div align="right"> <?php echo number_format($cashflow); ?></div></td>
              <td class="style9 left bottom right"> <div align="right"><?php echo  number_format($pengemb); ?></div></td>
              
            </tr>
            
            <?php
					    $jcashflow  = $jcashflow + $cashflow;
					    $jpengemb   = $jpengemb + $pengemb;
							}}
					
					}
            ?>
            
            
            
            
            
            
            
            <tr>
              <td height="30" class="style27  bottom left " colspan="3"><div align="center" >JUMLAH</div></td>
              <td class="style9  bottom left " ><div align="right" > <?php echo number_format($jcashflow);?> </div></td>
              <td class="style9  bottom left right" ><div align="right" ><?php echo  number_format($jpengemb);?></div></td>
            </tr>
            <tr>
              <td height="30" class="style27  left " colspan="3"><div align="center" >CASH ON HAND</div></td>
              <td class="style9  left " ><div align="right" ></div></td>
              <td class="style9  left right" ><div align="right" ></div></td>
            </tr>
            <tr>
              <td height="30" class="style27  top bottom left " colspan="3"><div align="center" >JUMLAH AKHIR RENCANA</div></td>
              <td class="style9 top bottom left " ><div align="right" ></div></td>
              <td class="style9 top bottom left right" ><div align="right" ></div></td>
            </tr>
	</table>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      
      <tr>
       &nbsp;
        <td colspan=2 class="style9"><div align="right" ><?php echo ucwords(strtolower($row['nama_kec'])); ?>, <?php echo tgl_indo(date('Y-m-d')); ?><br></br></div></td>
      </tr>
      
     <!-- Menampilkan tanda tangan -->
      
       <?php 
       $ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' "));
       $bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' "));
       ?>
	<tr>
        <td height="24" class="style9"><p align="center">Menyetujui,</p>
        <p align="center"><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort] "?></p>
        <p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align="center"><b><?php echo " $ketuaupk[namadepan] $ketuaupk[namabelakang] "?></b></p>
		</td>
	    
	    <td height="24" class="style9"><p align="center">Dibuat Oleh,</p>
        <p align="center"><?php echo "$row[sebutan_level_3] $row[nama_lembaga_sort] "?></p>
        <p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align="center"><b><?php echo "$bendaharaupk[namadepan] $bendaharaupk[namabelakang]"?></b></p>
		</td>
        
  </tr>
	</table>
</body>
<title>E-Budgeting<?php echo " $tahun_anggaran";?></title>