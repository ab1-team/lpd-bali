<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../js/bar128.php";

?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family:  Arial, Helvetica, sans-serif; font-size: 10px; }
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
$ids			=$_GET['idt'];
$row=mysql_fetch_array(mysql_query("Select *, t.jumlah as tjum from transaksi_$_SESSION[lokasi] t, simpanan_anggota_$_SESSION[kd_kab] sa
																WHERE sa.id=t.id_simp_i AND t.idt='$ids'"));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$us=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));
if($u['id']==$us['id']){$user=$u['ins'];}else{$user="$u[ins] / $us[ins]";}

if(substr($row['rekening_debit'],2)=="22"){
$kode = kode($row['rekening_debit']);
}else{
$kode = kode($row['rekening_kredit']);    
}
$jum_trans=mysql_num_rows(mysql_query("Select * from transaksi_$_SESSION[lokasi] WHERE id_simp_i=$row[id_simp_i] AND idt<='$ids' AND (rekening_debit LIKE '22%' OR rekening_kredit LIKE '22%')"));
?> 
      <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0"> 
			<tr>	  
			<th class="style10" colspan>
			    &nbsp;<br>
			    &nbsp;<br>
			    &nbsp;<br>
			    &nbsp;<br>
			    &nbsp;<br>
			    &nbsp;<br>
			</th>
              </tr>
			
    	<?php	    $noo=0;
                    $i=$jum_trans-1;
                    $a=$i%24;
                    if($a<=10){
                    $br=$a;
                    }else{
                    $br=$a+2;}
                    FOR($no=1;$no<=$br;$no++){ $noo=$noo+1; ?>
                      
               <tr>	  
			<th  class="style9">     
			    &nbsp;
              		</th>
              </tr>         
                        
              <?php  }		
            $js     = $row['jenis_simpanan'];
                        if($js==1){
                            $kd_jb  = 221;
                        }elseif($js==2){
                            $kd_jb  = 222;
                        }else{
                            $kd_jb  = 221;
                        }	
              $rek=mysql_num_rows(mysql_query("select * from rekening_$_SESSION[lokasi] where kd_jb=$kd_jb AND kd_rekening=$row[rekening_kredit] "));
						
              if($rek>0) {
											$debit	="0";
											$kredit	=$row['tjum'];
										}else{
											$debit	=$row['tjum'];
											$kredit	="0";
											}
											$saldo=saldosimpanant("$row[tgl_transaksi]#$row[id_simp_i]#$ids")
			    ?>
			    
			<tr>	  
          
              <td width="5%" class="style9 align-justify"><?php echo $noo?></td>
			<td width="12%" class="style9 align-center" ><?php echo $row['tgl_transaksi']?></td>
			<td width="5%" class="style9 align-center" ><?php echo $kode?></td>
              <td width="21%" class="style9 align-center"><?php echo number_format($debit)?></td>
              <td width="21%" class="style9 align-center"><?php echo number_format($kredit)?></td>
              <td width="21%" class="style9  align-center"><?php echo number_format($saldo)?></td>
			  <td width="10%" class="style9  align-center"><?php echo strtoupper($user)?>-<?php echo $row['idt']?></td>
			<td width="5%" class="style9 align-center" >&nbsp;</td>
        </tr>
        </table>
</body>
<title>Cetak Buku</title>