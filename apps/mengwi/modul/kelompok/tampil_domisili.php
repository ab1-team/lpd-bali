<?php session_start();
include "../../inc/inc.koneksi.php";
$dat=mysql_fetch_array(mysql_query("select * from kelompok_$_SESSION[kd_kab] k, desa d, kecamatan c where k.desa=d.id and k.lokasi=c.id and k.id=$_SESSION[ida]"));
?>
<div class="form-group">
    <label class="control-label col-sm-4">Domisili Lama</label><label class="control-label col-sm-8"><?php echo $dat['alamat_kelompok']?></label>
    <label class="control-label col-sm-4">&nbsp;</label><label class="control-label col-sm-8"><?php echo "Desa $dat[nama_desa]";?></label>
    <label class="control-label col-sm-4">&nbsp;</label><label class="control-label col-sm-8"><?php echo "Kecamatan $dat[nama_kec]";?></label>
</div>