<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];

?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px;  }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.all  {border: 1px solid #000000; }
.top  {border-top: 1px solid #000000; }
.bottom {border-bottom: 1px solid #000000; }
.left {border-left: 1px solid #000000; }
.right  {border-right: 1px solid #000000; }
.mt-n-lg {margin-top: -30px;}
-->
</style>
<body>
    <br>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="all">
       <?php 
     $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
      $nama_lembaga_long  =$row ['nama_lembaga_long'];
      $nama_kec =$row ['nama_kec'];
      $alamat_kec =$row ['alamat_kec'];
      $telpon_kec =$row ['telpon_kec'];
      $email_kec  =$row ['email_kec'];
      $web_kec  =$row ['web_kec'];
      $visi   =$row ['visi_misi'];
      $nama_kab =$row ['nama_kab'];

    ?>

      <tr align="center">
          <td colspan="5" class="style6 all">
    <?php
      $logo=$row['logo'];
      if (empty($logo)) {
      echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:100; margin:10px 0 10px 20px;'>";
      }else{
      echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:100; margin:10px 0 10px 20px;'>";
      }
      ?>    
    <br>
    <b><?php echo strtoupper($nama_lembaga_long);?></b><br>
    <span class="style3">KECAMATAN <?php echo strtoupper($nama_kec);?></span><br>
    <b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
    <span class="style9"><?php echo "$alamat_kec $nama_kec $nama_kab <br>Telp. $telpon_kec";?></span>
    </td>
      </tr>
    <?php
    $rcp=$_GET['rcp'];
    $view= mysql_fetch_array(mysql_query("SELECT * FROM
              kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk, sistem_angsuran sa, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa
              WHERE b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=a.desa AND k.id=pk.id_kel AND a.id=pa.nia AND sa.id=pa.sistem_angsuran AND pk.id=pa.id_pinkel
               AND pa.id='$rcp'"));
    
        
      ?>
    <tr align="center" height="20">
          <td colspan="5" class="style6 left right">&nbsp;</td>
          </tr>
        <tr align="center" height='200'> 
          <td colspan="5" class="style3 left right"><strong>DOKUMEN PENCAIRAN</strong>
        <br><?php  echo strtoupper($view['deskripsi_jpp']); ?>
        <br/> Kelompok <?php  echo ucwords($view['nama_kelompok']); ?>
        <br/> Desa <?php  echo ucwords($view['nama_desa']); ?>
        </td>
          </tr>
            <tr height="330">
              <td colspan='5'>
                <center><img src="i.png" width="7%" height="300px;"></center>
              </td>
            </tr>
        <tr>
          <td width="6%" colspan="5" align="center" height="70px;"></td>

        </tr>
        <tr height='12'>
          <td width="10%"></td>
          <td width="7%"></td>
          <td class="style99" width="10%" align="center"><b>Tanggal Cair</b>
          <br/><?php echo tgl_indO($view['tgl_cair']);?>
          </td>
          <td width="7%"></td>
          <td width="10%"></td>
        </tr>

        <tr height='15'>
          <td width="10%"></td>
          <td width="7%"></td>
          <td class="style99" width="10%" align="center"><b>Alokasi</b>
          <br/>Rp.<?php echo number_format($view['alokasi']);?>
          </td>
          <td width="7%"></td>
          <td width="10%"></td>
        </tr>
        <tr height="10">
          <td></td>
        </tr>

    

    <tr align="center">
        <td colspan="5" class="style6 all"><br>
    <span class="style9">Diterbitkan Oleh : </span><br>
    <b><?php echo $nama_lembaga_long; ?> <br>Kecamatan <?php echo $nama_kec;?> Kabupaten <?php echo $nama_kab;?></b><br>
    <span class="style9">
    <?php echo "$alamat_kec $nama_kec $nama_kab<br>Telp.$telpon_kec E-mail. $email_kec<br>
    Website : $web_kec";?><br>copyright&copy;<?php echo date('Y');?></span><br><br>        </td>
      </tr>
</table>
</body>
<title>Cover Proposal <?php echo "Kelompok $r[nama_kelompok] $r[sebutan_desa]  $r[nama_desa]";?></title>
      
</body>
