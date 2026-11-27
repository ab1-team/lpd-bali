<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../js/bar128.php";

$lokasi				=$_SESSION['lokasi'];

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
<?php 

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi'"));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
$js     = $sa['jenis_simpanan'];
$js			=$_GET['js'];
$table_transaksi	="transaksi_$_SESSION[lokasi]";

$wrek1  = jenisrek("1-$js");
$text	= "SELECT * FROM $table_transaksi WHERE $wrek1 AND id_simp_i='$ids' ORDER BY tgl_transaksi ASC, idt ASC";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

                        if($js==1){
                            $kd_jb  = 221;
                            $msg = 'UMUM';
                        }elseif($js==2){
                            $kd_jb  = 222;
                            $msg = 'ANGGOTA';
                        }elseif($js==3){
                            $kd_jb  = 223;
                            $msg = 'UMUM';
                        }
                        
                        if($row['lembaga']==NULL or $row['lembaga']==''){
								$nama			=$row['namadepan'];
								}else{
								$nama			="$row[namadepan] qq. $row[lembaga]";	
								}
?> 
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="0" class="bottom">
				<div class="style9 text-align-left"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?><br>
				<?php echo $row['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $row['telpon_kec'];?>
				</div>
			</td>
			
		  </tr> 	  
      

      
       
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td height="50" colspan="10" class=""><p align="center" class="style6 "><b>REKAP LAPORAN SIMPANAN <?= $msg; ?> </b>
      </tr>
	<tr>
	    <th width="4%" height="30" class="style9 bottom top left ">NO</th>
	    <th width="5%" class="style9 left bottom top ">NIK</th>
	    <th width="14%" class="style9 left bottom top">TANGGAL BUKA</th>
	    <th width="32%" class="style9 left bottom top ">NAMA NASABAH - CIF</th>
	    <th width="15%" class="style9 left bottom top ">DEBIT</th>
	    <th width="15%" class="style9 left bottom top ">KREDIT</th>
	    <th width="15%" class="style9 left bottom top ">SALDO</th>
	    <th width="5%" class="style9 left bottom top right">KET</th>
    </tr>
   
   
   <?php  
						include "inc/inc.koneksi.php";
						include "inc/fungsi_simpanan_individu.php";
						$js = $_GET['js'];
				// 		$view=mysql_query("SELECT * FROM kecamatan kc, jenis_simpanan js, anggota_$_SESSION[kd_kab] a,simpanan_anggota_$_SESSION[kd_kab] si
				// 							WHERE
				// 							a.id=si.nia AND js.id=si.jenis_simpanan AND kc.id=a.lokasi AND si.jenis_simpanan='$js'  order by si.id asc");
											
						$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, jenis_simpanan js, simpanan_anggota_$_SESSION[kd_kab] si 
						                    WHERE
				                            a.id=si.nia AND ss.kd_status=si.status AND si.jenis_simpanan='$js' order by si.id asc");
								
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idsimp			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$sumambil		=sumambil("$tgl_now-$idsimp");
								$sumnabung		=sumnabung("$tgl_now-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_now-$idsimp");
								$sts			=$row['status'];
								if($row['lembaga']==NULL or $row['lembaga']==''){
								$nama			=$row['namadepan'];
								}else{
								$nama			= "$row[namadepan] QQ $row[lembaga]" ;	
								}
								$jum_nas=mysql_num_rows(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab]
																WHERE
																id='$row[id]'"));
							?>
							<tr>
								<td width="4%" height="30" class="style9 left bottom align-left"><?php echo $no;?></td> 
								<td width="5%" height="30" class="style9 left bottom align-center"><?php echo $row['nik'];?></td>
								<td width="14%" class="style9 left bottom align-center"><?php echo ($row['tgl_buka']); ?></td>
								<td width="32%" class="style9 left bottom align-left"><?php echo $nama.' - '.$idsimp ;?></td>
								<td width="15%" class="style9 left bottom  align-right"><?php echo number_format($sumambil);?></td>
								<td width="15%" class="style9 left bottom  align-right"><?php echo number_format($sumnabung); ?></td>
								<td width="15%" class="style9 left bottom  align-right"><?php echo number_format($saldosimpanan); ?> </td>
								<td width="5%" class="style9 left bottom  right align-center"><?php echo ($row['status']); ?></td>
								
							</tr>
						
		<?php 
$tot_nas	=$tot_nas+$jum_nas;
$tot_ambil	=$tot_ambil+$sumambil;
$tot_nabung	=$tot_nabung+$sumnabung;
$tot_saldo	=$tot_saldo+$saldosimpanan;
  		} ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="4"><div align="center" >JUMLAH</div></th>
              
			  <th class='style9 left bottom top text-right'><?php echo number_format($tot_ambil);?></th>
              <th class="style9 left bottom top"><?php echo number_format($tot_nabung);?></th>
              <th class="style9 left bottom top"><?php echo number_format($tot_saldo);?></th>
              <th class="style9 left bottom top right"></th>
            </tr>		
</table>
</body>
<title>Cetak Buku</title>