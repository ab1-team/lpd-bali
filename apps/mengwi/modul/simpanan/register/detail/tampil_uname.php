<?php session_start();
include "../../../../inc/inc.koneksi.php"; 
$dat=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] where id=$_SESSION[ida]"));
?>
<div class="form-group">
    <label class="control-label col-sm-4">Username Lama</label>
        <div class="col-sm-8"><input type="text" name="unameold" class="form-control" id="unameold"
			value="<?php echo $dat['uname']?>" disabled="disabled"> </div>
</div>