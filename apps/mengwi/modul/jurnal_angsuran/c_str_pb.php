<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_simpanan_individu.php";
include "../../js/bar128.php";

$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];
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
$idtp			=$_GET['idtp'];
$r=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, desa d, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, $table_transaksi t, $table_rekening r, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi
								WHERE  c.id=a.lokasi AND d.id=a.desa AND a.id=pi.nia AND pi.id=t.id_pinj_i AND pi.jenis_pp=jpp.id AND t.idtp='$idtp' AND r.kd_rekening=t.rekening_debit AND sa.id=pi.sistem_angsuran"));

								
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
$us=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[id_user]' "));

if($u['id']==$us['id']){$user=$u['ins'];}else{$user="$u[ins]/pb-$us[ins]";}

$kode = ($r['rekening_kredit']);   

?> 
<br><br><br>
      <table width="97%" border="0" align="center" cellpadding="5" cellspacing="0"> 
			<tr>	  
          
              <td class="style9">
                            <?php echo $r['idt']?>.<?php echo $r['nik']?> <?php echo $r['tgl_transaksi']?>-<?php echo strtoupper($user)?><br>
                            LoanID-<?php echo $r['id_pinj_i']?>-<?php echo $kode; ?><br>
                            Rp. <?php echo number_format($r['jumlah'],2,',','.')?><br><br>
                            </td>
              
        </tr>
</body>
<title>Cetak Buku</title>