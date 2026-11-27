<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";


$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));

$text	= "SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k, bimbingan b, users u WHERE d.id=k.desa AND k.id=b.id_receiver AND u.id=b.id_sender AND k.id='$_GET[id]' AND b.kd_kab='$_SESSION[kd_kab]'  ";
$sql 	= mysql_query($text);
$data 	= mysql_query($text);
$r		= mysql_fetch_array($sql);

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
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php echo "$kec[nama_lembaga_sort] Kecamatan $kec[nama_kec]";?><br>
				<?php echo $kec['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_kec'];?>
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Catatn Bimbingan<br>
			Loan ID. <?php echo $r['kd_kelompok'];?>-<?php echo $r['id_pinj'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		CATATAN BIMBINGAN<br>
		KELOMPOK <?php echo strtoupper("$r[nama_kelompok] $r[nama_desa]");?><br>
		Alamat : <?php echo "$r[alamat_kelompok] $r[nama_desa]";?></p></td>
      </tr>

</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
	    <th width="4%" height="30" class="style9 all">NO</th>
	    <th width="8%" class="style9 top bottom">TANGGAL</th>
	    <th class="style9 all">CATATAN BIMBINGAN</th>
	    <th width="20%" class="style9 top bottom right">VISITOR</th>
    </tr>

	  <?php
		while($row=mysql_fetch_array($data)){
		$no=$no+1;
										
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo tgl_ind($row['tanggal']);?></td>
	    <td class="style9 left right bottom"><?php echo "$row[isi]";?></td>
	    <td class="style9 bottom right"><?php echo "$row[namadepan] $row[namabelakang]";?></td>
	</tr>
  <?php 
						
						} ?>

	<tr>
		<td class="style10 top align-right" colspan="9">Dicetak Oleh: <?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]"; ?>; pada: <?php echo date('d/m/Y H:i:s A')?> | Paraf : [ &nbsp; &nbsp; &nbsp; &nbsp; ]</td>
	</tr>
</table>
	          
</body>
<title>Catatan Bimbingan Kelompok</title>