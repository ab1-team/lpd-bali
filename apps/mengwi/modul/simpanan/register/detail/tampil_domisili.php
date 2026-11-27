<?php session_start();
include "../../../../inc/inc.koneksi.php"; 
$dat=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, desa d, kecamatan k where a.desa=d.id and a.lokasi=k.id and a.id=$_SESSION[ida]"));
?>
<div class="form-group">
    <label class="control-label col-sm-4">Domisili Lama</label><label class="control-label col-sm-8"><?php echo $dat['alamat']?></label>
    <label class="control-label col-sm-4">&nbsp;</label><label class="control-label col-sm-8"><?php echo "Desa $dat[nama_desa]";?></label>
    <label class="control-label col-sm-4">&nbsp;</label><label class="control-label col-sm-8"><?php echo "Kecamatan $dat[nama_kec]";?></label>
</div>