<?php session_start();
include "../../../inc/inc.koneksi.php";
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
.pull-right {
  float: right;
  margin-left:120px;
}
-->
</style>
<?php
$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));
$ttd_saksi	        = $kec['ttd_saksi'];
$ttd_mengetahui		= $kec['ttd_mengetahui'];
$ttd_pdua			= $kec['ttd_pdua'];
$ttd_psatu			= $kec['ttd_psatu'];
$tgl_kondisi        = $tgl_cair;

     if($ttd_psatu=="1") { $psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE(u.sejak<='$tgl_kondisi' AND (u.hingga>='$tgl_kondisi' OR u.hingga='0000-00-00')) AND (u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' ) ORDER BY u.jabatan ASC "); }
else if ($ttd_psatu=="2"){ $psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]'AND u.jabatan='7' "); }

$ketuaupk=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='1' AND jabatan='1'  "));

$ketuabkad=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='2' AND jabatan='1'  "));
$sekbkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan='2' ");
$benbkad=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='2' AND u.jabatan='3' ");

$ketuabp=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='3' AND jabatan='1'  "));
$sekbp=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='3' AND jabatan='2'  "));
$benbp=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='3' AND jabatan='3'  "));

$rcp=$_GET['rcp'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'"));
	                         if($ttd_saksi=="6"){$mengetahui="Mengetahui sekaligus menjadi Saksi,"; }else if($ttd_saksi!="6"){$mengetahui="Mengetahui,";};               
							 ?>
						
<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
<!-----------Pihak Pertama dan Kedua -------->
<tr>
    <td class="style9 align-center" valign="top" width="31%">
    <br>Pihak PERTAMA,<br><br>
   	<?php
			$no=0;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>";
				
				while($upk=mysql_fetch_array($psatu)){
				$upk_namadepan  =$upk['namadepan'];
				$upk_namabelakang =$upk['namabelakang'];
				$jabatan	=$upk['jabatan'];
			    if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			    else if ($jabatan=="7") {$nama_jabatan=$kec['sebutan_level_7'];}
			
				$no=$no+1;
				}
					echo" <td class='style9' width='auto'><center><u><b>$upk_namadepan $upk_namabelakang</b></u><br>$nama_jabatan</center></td>";
					
				echo"</tr>
			</table>"; ?>
         
    </td>
    <td class="style9 align-center" valign="top" width="31%">
    <br>Pihak KEDUA,<br><br>
   	<?php
			$no=0;
			echo "
			<table width='100%'>
				<tr><td colspan='3'>&nbsp;</td></tr>
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
<!-----------Saksi -------->
<td class="style9 align-center" valign="top" width="31%" colspan="4">
    <?php if($ttd_saksi!="6") { ?>
    <br>Selaku Saksi,
    <br>
   	<?php
			$no=0;
			echo "
			<table width='100%'>
				<tr>";
				
			    if($ttd_saksi=="1") {
			        $p2 = [
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ]
			        ];
			    }
			    else if($ttd_saksi=="2") {
			        $p2 = [
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ]
			            
			        ];
			    }
			    else if($ttd_saksi=="3") {
			         $p2 = [
			            
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ],
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ]
			        
			            
			        ];
			    }
			    else if($ttd_saksi=="4") {
			         $p2 = [
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ],
			        
			            [
			                "nama" => "$row[ked]",
			                "jabatan" => "Ketua LPMD/Pendamping Kelompok <br>$row[nama_desa]"
			            ]
			            
			        ];
			    }else if($ttd_saksi=="5") {
			         $p2 = [
			            [
			                "nama" => "__________________________",
			                "jabatan" => "Saksi 1"
			                
			            ],
			        
			            [
			                "nama" => "__________________________",
			                "jabatan" => "Saksi 2"
			            ]
			            
			        ];
			    }else if($ttd_saksi=="7") {
			         $p2 = [
			            [
			                "nama" => "$ketuabp[namadepan] $ketuabp[namabelakang]",
			                "jabatan" => $row['nama_bp_long']
			            ],
			        
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ]
			            
			        ];
			    }
			    else if($ttd_saksi=="8") {
			         $p2 = [
			            [
			                "nama" => $row['sekdes'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => "an. $row[sebutan_kades]",
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ],
			        
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ]
			            
			        ];
			    }
			    else if($ttd_saksi=="10") {
			         $p2 = [
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ],
			        
			            [
			                "nama" => "$row[ked]",
			                "jabatan" => "Kader Ekonomi Desa<br>$row[nama_desa]"
			            ]
			            
			        ];
			    }
				foreach ($p2 as $p) {
				    echo" <td class='style9' width='50%'><center>$p[jabatan] $p[desa]</center></td>";
				}
					
				echo"</tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				";
				foreach ($p2 as $p) {
				    echo" <td class='style9' width='50'><center><u><b>$p[nama]</b></u><br>$p[pangkat]<br>$p[nip]</center></td>";
				}
				echo"
			</table>"; ?>
         
  <?php } ?> 
</td>
<!-----------Mengetahui------------>
<tr>
    <td class="style9 align-center" valign="top" width="31%" colspan="4">
    <?php if($ttd_mengetahui!="4") { ?>
    <br><?php echo $mengetahui ;?><br>
    <br>
   	<?php
			$no=0;
			echo "
			<table width='100%' >
				<tr>";
				
			    if($ttd_mengetahui=="1") {
			        $p2 = [
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ]
			        ];
			    }
			    else if($ttd_mengetahui=="2") {
			        $p2 = [
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ]
			            
			        ];
			    }
			    else if($ttd_mengetahui=="3") {
			         $p2 = [
			            [
			                "nama" => "$ketuabkad[namadepan] $ketuabkad[namabelakang]",
			                "jabatan" => $row['nama_bkad_long']
			            ],
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ]
			        
			        ];
			    }
			    else if($ttd_mengetahui=="5") {
			         $p2 = [
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => $row['sebutan_kades'],
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ],
			        
			            [
			                "nama" => "$row[ked]",
			                "jabatan" => "Ketua LPMD/Pendamping Kelompok <br>$row[nama_desa]"
			            ]
			            
			        ];
			    
			    }
			    else if($ttd_mengetahui=="7") {
			         $p2 = [
			            [
			                "nama" => "$ketuaupk[namadepan] $ketuaupk[namabelakang]",
			                "jabatan" => "$row[sebutan_level_1] <br>"
			            ]
			            
			        ];
			    }
			    else if($ttd_mengetahui=="8") {
			         $p2 = [
			            [
			                "nama" => "$ketuaupk[namadepan] $ketuaupk[namabelakang]",
			                "jabatan" => "$row[sebutan_level_1] <br>"
			            ],
			        
			            [
			                "nama" => $row['kades'],
			                "desa" => $row['nama_desa'],
			                "jabatan" => "$row[sebutan_kades]",
			                "nip" => ($row['nip']) ? "NIP. $row[nip]":'',
			                "pangkat" =>$row['pangkat']
			            ]
			            
			        ];
			    }
			    
				foreach ($p2 as $p) {
				    echo" <td class='style9' width='auto'><center>$p[jabatan] $p[desa]</center></td>";
				}
					
				echo"</tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				";
				foreach ($p2 as $p) {
				    echo" <td class='style9' width='auto'><center><u><b>$p[nama]</b></u><br>$p[pangkat]<br>$p[nip]</center></td>";
				}
				echo"
			</table>"; ?>
         
  <?php } ?> 
</td>
<tr>
<td><p>&nbsp;&nbsp;&nbsp;</p></td>

</tr>
<tr>
<td height="20" colspan="1" class="style9"><div align="left"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></div></td>
<td colspan="2" class="style9"><div align="right">Loan ID. <?php echo $row['kd_kelompok'];?>-<?php echo $row['id'];?></div></td>
</tr>
</tr>
</table>
