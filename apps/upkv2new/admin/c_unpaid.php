<?php session_start();
include "../inc/inc.koneksi.php";
include "../inc/terbilang.php";
include "../inc/fungsi_indotgl.php";
include "../inc/fungsi_keuangan_admin.php";
include "../js/bar128.php";

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
$level = $_SESSION['level'];
$lokasi = $_SESSION['lokasi'];
if($level=='pusat') {
	$kondisi="";
}else if($level==1) {
	$kondisi="lokasi='$lokasi' ";
}
$sts=$_GET['sts'];
		
if ($_GET['sts']=="UNPAID"){ 
	$kolom_tanggal="TGL INVOICE";
	$kop="REKAP INVOICE UNPAID";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' $kondisi")); 
	$AllSaldo=AllSaldo();
}else if ($_GET['sts']=="PAID"){
	$kolom_tanggal="TGL LUNAS";
	$kop="REKAP INVOICE PAID";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='PAID' $kondisi"));
	$jumtag=mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah from admin_invoice WHERE status='PAID' $kondisi"));
	$AllSaldo=$jumtag['sumjumlah'];
	}else if ($_GET['sts']==""){
	$kolom_tanggal="TGL INVOICE";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE $kondisi"));
	$AllSaldo="";
	}
	
	if($jumpaid>0){ $ketjumpaid=$jumpaid; }else{$ketjumpaid="BELUM ADA";}
	
	
$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, admin_jenis_pembayaran j, admin_invoice i  WHERE b.id=c.kd_kab AND c.id=i.lokasi AND j.id=i.jenis_pembayaran AND i.status='$_GET[sts]' "));

?> 
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="0" class="bottom">
				<div class="style9 text-align-left">PUSAT ADMINISTRASI SI UPK ONLINE<br>
				
				</div>
			</td>
			
		  </tr> 	  
      
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td height="50" colspan="10" class=""><p align="center" class="style6 "><b><?php echo $kop;?></b>
      </tr>
	<tr>
	    <th width="4%" height="30" class="style9 bottom top left ">NO</th>
	    <th width="5%" class="style9 left bottom top ">ID KEC</th>
	    <th width="20%" class="style9 left bottom top">NAMA KECAMATAN</th>
	    <th width="10%" class="style9 left bottom top ">TANGGAL PAKAI</th>
	    <th width="10%" class="style9 left bottom top ">TANGGAL INVOICE</th>
	    <th width="15%" class="style9 left bottom top ">BIAYA TAHUNAN</th>
	    <th width="15%" class="style9 left bottom top ">TAGIHAN</th>
	    <th width="25%" class="style9 left bottom top right">KET</th>
    </tr>
    <?php
    $level = $_SESSION['level'];
    $lokasi = $_SESSION['lokasi'];
    if($level=='pusat') {
	$kondisi="";
    }else if($level==1) {
	$kondisi="lokasi='$lokasi' ";
    }

		
    if ($_GET['sts']=="UNPAID"){ 
	$kolom_tanggal="TGL INVOICE";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' $kondisi")); 
	$AllSaldo=AllSaldo();
    }else if ($_GET['sts']=="PAID"){
	$kolom_tanggal="TGL LUNAS";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='PAID' $kondisi"));
	$jumtag=mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah from admin_invoice WHERE status='PAID' $kondisi"));
	$AllSaldo=$jumtag['sumjumlah'];
	}else if ($_GET['sts']==""){
	$kolom_tanggal="TGL INVOICE";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE $kondisi"));
	$AllSaldo="";
	}
	
	if($jumpaid>0){ $ketjumpaid=$jumpaid; }else{$ketjumpaid="BELUM ADA";}
	
	
    $view=(mysql_query("SELECT * FROM kabupaten b, kecamatan c, admin_jenis_pembayaran j, admin_invoice i  WHERE b.id=c.kd_kab AND c.id=i.lokasi AND j.id=i.jenis_pembayaran AND i.status='$_GET[sts]' ORDER by lokasi"));
    
    $no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$biaya_tahunan = $row['biaya_tahunan'];
								$jumlah =$row['jumlah'];
								
?>
							<tr>
								<td class="style9 left bottom align-right"><?php echo $no;?></td> 
								<td class="style9 left bottom align-center"><?php echo $row['lokasi'];?></td>
								<td class="style9 left bottom align-left"><?php echo $row['nama_kec'].' - '.$row['nama_kab']; ?></td>
								<td class="style9 left bottom align-center"><?php echo $row['tgl_pakai'];?></td>
								<td class="style9 left bottom  align-center"><?php echo $row['tgl_invoice'];?></td>
								<td class="style9 left bottom  align-right"><?php echo number_format($biaya_tahunan);?></td>
								<td class="style9 left bottom  align-right"><?php echo number_format($jumlah);?></td>
								<td class="style9 left bottom  right align-center"><?php echo ($row['nama_jp']); ?></td>
								
							</tr>
						
		<?php 
$tot_biaya	=$tot_biaya+$biaya_tahunan;
$tot_jumlah	=$tot_jumlah+$jumlah;

								}
  		 ?>
			<tr>
              <th height="33" class="style9 top bottom left" colspan="4"><div align="center" >JUMLAH</div></th>
              
			  <th class='style9 left bottom top text-right'></th>
              <th class="style9 left bottom top align-right"><?php echo number_format($tot_biaya);?></th>
              <th class="style9 left bottom top align-right"><?php echo number_format($tot_jumlah);?></th>
              <th class="style9 left bottom top right"></th>
            </tr>		
</table>
</body>
<title>Cetak Buku</title>