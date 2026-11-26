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
.style9 {font-family: 'system-ui'; font-size: 12px; }
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

$ids			=$_GET['ids'];
$_SESSION['ids']=$ids;
$row=mysql_fetch_array(mysql_query("Select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_simpanan js, usaha us, users u, anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND js.id=si.jenis_simpanan AND us.id=a.usaha AND
																a.id=si.nia AND u.id=a.petugas AND si.id='$ids'"));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
if($row['lembaga']==NULL or $row['lembaga']==''){
								$nama			=$row['namadepan'];
								}else{
								$nama			="$row[namadepan] qq. $row[lembaga]";	
								}
?> 
<table width="100%" border="0"  align="center" cellpadding="3" cellspacing="0" style="margin-top:10px; "> 	
<tr>
        <td class="style9">&nbsp;<br>&nbsp;<br></td>
    </tr>
      <tr>
       
        <td colspan="2" class="style9">&nbsp;</td>
        <td width="10%" class="style9 align-right">&nbsp;</td>
        <td width="30%" class="style9">&nbsp;</td>

      </tr>
      <tr>
        <td class="style9">Rekening </td>
         <td class="style9">: <?php echo $row['nomor_rekening'];?></td>
        <td width="10%" class="style9 align-right"><strong> CIF - <?php echo $ids; ?> </strong></td>
      </tr>
      <tr>
        <td width="20%" class="style9">Nama Nasabah </td>
        <td colspan="2" class="style9">: <?php echo $nama;?> </td> 
       
      </tr>
      <tr>
        <td class="style9">Alamat </td>
        <td colspan="2" class="style9">: <?php echo "$row[alamat] $row[nama_desa]";?></td>
      </tr>
      <tr>
        <td class="style9">Telpon</td>
        <td colspan="2" height="5" class="style9">: <?php echo $row['hp'];?></td>
      </tr>
      
      
      <tr>
        <td class="style9">Jenis Simpanan </td>
         <td colspan="2" class="style9">: <?php echo $row['nama_js'];?></td>
      </tr>
      
</table>

</body>
<title>Cetak Buku</title>