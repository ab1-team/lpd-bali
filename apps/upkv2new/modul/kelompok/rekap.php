<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }

-->
</style>
<?php
@session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));
?>



<body onLoad="window.print()">
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$kec['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$kec['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>KECAMATAN $kec[nama_kec] KABUPATEN $kec[nama_kab]</b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">
			</div></td>
	  </tr> 
</table>
<p align="center" class="style6">REKAP DATA KELOMPOK<br>  </p>

                    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right" >

                        <tr>
                            <th height="34" class="style9 bottom top left">No</th>
                            <th class="style9 left bottom top">Kode Kelompok</th>
                            <th class="style9 left bottom top">Nama Kelompok</th>
                            <th class="style9 left bottom top">Jenis Kegiatan</th>
                            <th class="style9 left bottom top">Alamat Domisili</th>
                            <th class="style9 left bottom top"> Telpon</th>
							<th class="style9 left bottom top right">Status</th>
                        </tr>
                        <?php
						$vdesa=mysql_query("select d.id AS id, d.nama_desa AS nama from desa d, kecamatan k WHERE d.kd_kec=k.kd_kec AND k.id='$_SESSION[lokasi]' order by nama ASC");
								$no=0;
								while($rowv=mysql_fetch_array($vdesa)){ 
								$no1=$no1+1;
								echo "<tr>
										<td  height='33' class='style9 left right bottom top' align='left'colspan=7><b>$no1. $rowv[nama]</b></td></tr>";	
						$view=mysql_query("select * from desa d, kelompok_$_SESSION[kd_kab] k , jenis_kegiatan j WHERE d.id=$rowv[id] AND d.id=k.desa and k.lokasi='$_SESSION[lokasi]' and k.jenis_kegiatan=j.id order by j.id ASC, k.id ASC");
								while($row=mysql_fetch_array($view)){
									$no=$no+1;	
								
								$dpa=mysql_query("select * from status_pinjaman s, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE s.kd_status=pk.status AND pk.id_kel='$row[id]'");
									$pa	=mysql_num_rows($dpa);
									if ($pa > 0){
										$r = mysql_fetch_array($dpa);
										$status =$r['kd_status']; $bg=$r['warna_status'];
										}else{ $status ="N"; $bg="default"; }
								
								$jpp=$row['jenis_produk_pinjaman']; if ($jpp=="1") { $gb="female";}else{ $gb="male";}
						echo "
						<tr>
                            <td height='33' class='style9 left top' align='center'>$no</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[kd_kelompok]</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[nama_kelompok] ($row[ketua])<span class='pull-right'><i class='fa fa-$gb fa-lg'></i> </span></td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[nama_jk]</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[alamat_kelompok] $row[nama_desa]</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[telpon]</td>
                            <td class='style9 left top right' align='center' >$status</td>
                        </tr> ";
						 }} ?>
                    </table>
					

         
</body>
<title>REKAP DATA KELOMPOK</title>