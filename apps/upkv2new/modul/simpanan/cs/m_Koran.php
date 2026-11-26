<?php 
$ids			=$_GET['ids'];
$_SESSION['ids']=$ids;
$row=mysql_fetch_array(mysql_query("Select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_simpanan js, usaha us, users u, anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND js.id=si.jenis_simpanan AND us.id=a.usaha AND
																a.id=si.nia AND u.id=a.petugas AND si.id='$ids'"));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$sa=mysql_fetch_array(mysql_query("select * from simpanan_anggota_$_SESSION[kd_kab] where id='$ids' "));
$js     = $sa['jenis_simpanan'];
$table_transaksi	="transaksi_$_SESSION[lokasi]";

$wrek1  = jenisrek("1-$js");
$text	= "SELECT * FROM $table_transaksi WHERE $wrek1 AND id_simp_i='$ids' ORDER BY tgl_transaksi ASC, idt ASC";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

                        if($js==1){
                            $kd_jb  = 221;
                        }elseif($js==2){
                            $kd_jb  = 222;
                        }else{
                            $kd_jb  = 223;
                        }
                        
                        if($row['lembaga']==NULL or $row['lembaga']==''){
								$nama			=$row['namadepan'];
								}else{
								$nama			="$row[namadepan] qq. $row[lembaga]";	
								}
?> 
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?><br>
				<?php echo $row['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $row['telpon_kec'];?>
				</div>
			</td>
			<td height="20" colspan="2" class=""><div align="right" class="style9">Dokumen Simpanan<br>
			CIF - <?php echo $ids;?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="50" colspan="4" class=""><p align="center" class="style6">
		REKENING KORAN <?php echo strtoupper($row['nama_js']);?>
	 
      </tr>
      <tr>
        <td width="19%" height="20" class="style9">Nomor Rekening</td>
        <td width="32%" height="20"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['nomor_rekening']);?></span></td>
        
      </tr>
      <tr>
        <td height="20" class="style9">CIF / NIK </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo $ids;?> /  <?php echo "$row[nik]";?> </span></td>
        
      </tr>
      <tr>
        <td width="19%" height="20" class="style9">Nama Kreditur</td>
        <td width="42%" height="20"><span class="style9">:</span><span class="style27"> <?php echo $nama;?></span></td>
        
      </tr>
      <tr>
        <td height="20" class="style9">Tanggal Buka </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($row['tgl_buka']); ?></span></td>
	  </tr>
	  <?php if($row['jenis_simpanan']==3) {?>	
      <tr>
        <td height="20" class="style9">Jenis Program </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo "$row[catatan_simpanan]";?></span></td>
       <?php } ?> 
      </tr>  
      
      <tr>
        <td height="20" class="style9">Alamat </td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo "$row[alamat]";?></span></td>
        
      </tr>
      <tr>
        <td height="20" class="style9">Telpon</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo "$row[hp]";?></span></td>
        
      </tr>  
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
	    <th width="4%" height="30" class="style9  ">NO</th>
	    <th width="8%" class="style9  ">TANGGAL</th>
	    <th width="6%" class="style9  ">REF</th>
	    <th width="40%" class="style9  ">KETERANGAN</th>
	    <th width="10%" class="style9  ">DEBIT</th>
	    <th width="10%" class="style9  ">KREDIT</th>
	    <th width="10%" class="style9 ">SALDO</th>
	    <th width="2%" class="style9 ">P</th>
    </tr>
   <?php  
   $no=0;
									while($row2=mysql_fetch_array($sql)){
									$no=$no+1;
									
									$rek=mysql_num_rows(mysql_query("select * from rekening_$_SESSION[lokasi] where kd_jb=$kd_jb AND kd_rekening=$row2[rekening_kredit] "));
									
									if(jenisrek("2-$js")) {$file="c_bkm";} else {$file="c_bkk";}
									
										if($rek>0) {
											$debit	="0";
											$kredit	=$row2['jumlah'];
										}else{
											$debit	=$row2['jumlah'];
											$kredit	="0";
											}
											
									$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row2[id_user]' "));		

							?>
							<tr>
								<td width="4%" height="30" class="style9 "><?php echo $no;?></td>
								<td width="10%" class="style9 align-center"><?php echo ($row2['tgl_transaksi']); ?></td>
								<td width="6%" class="style9 align-center"><?php echo $row2['idt'];?></td>
								<td width="40%" class="style9 "><?php echo $row2['keterangan_transaksi'];?></td>
								<td width="10%" class="style9 align-right"><?php echo number_format($debit);?></td>
								<td width="10%" class="style9 align-right"><?php echo number_format($kredit); ?></td>
								<td width="10%" class="style9 align-right"><?php $prasaldo=$kredit-$debit; $saldosamping=$saldosamping+$prasaldo; echo number_format($saldosamping); ?> </td>
								<td width="2%" class="style9 align-center"><?php echo $r['ins'];?></td>
								
							</tr>
						<?php	 }
							 
   ?>
</table>