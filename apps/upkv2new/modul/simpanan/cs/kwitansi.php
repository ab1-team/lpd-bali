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
.style9 {font-family:  Arial, Helvetica, sans-serif; font-size: 11px; }
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
$row=mysql_fetch_array(mysql_query("Select *, t.jumlah AS tjumlah from transaksi_$_SESSION[lokasi] t, simpanan_anggota_$_SESSION[kd_kab] sa
																WHERE sa.id=t.id_simp_i AND t.idt='$ids'"));
																
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$us=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));
if($u['id']==$us['id']){$user=$u['ins'];}else{$user="$u[ins] / $us[ins]";}

if(substr($row['rekening_debit'],2)=="22"){
$kode = kode("221.01");
}else{
$kode = kode($row['rekening_kredit']);    
}

?> 
<br><br><br>
      <table width="97%" border="0" align="center" cellpadding="5" cellspacing="0"> 
			<tr>	  
          
			<th width="5%" class="style9" >&nbsp;</th>
              <td width="80%" class="style9">
                            <?php echo $row['idt']?>.<?php echo $row['nomor_rekening']?> <?php echo $row['tgl_transaksi']?>-<?php echo strtoupper($user)?><br>
                            CIF-<?php echo $row['id_simp_i']?>-<?php echo $kode; ?><br>
                            Rp. <?php echo number_format($row['tjumlah'])?><br><br>
                            </td>
              
        </tr>
</body>
<title>Cetak Buku</title>