<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
$row=mysql_fetch_array(mysql_query("select * from kabupaten where id='$_SESSION[id]'"));
?>
<fieldset>
    <div>
        <div class="col-sm-4">Nama Provinsi</div><label class="col-sm-8">: <?php echo $row['nama_prov'];?></label>
    </div>
    <div>
        <div class="col-sm-4">Nama Kabupaten</div><label class="col-sm-8">: <?php echo $row['nama_kab'];?></label>
    </div>
    <div>
        <div class="col-sm-4">Nama Lembaga</div><label class="col-sm-8">: <?php echo $row['nama_lembaga'];?></label>
    </div>
    <div>
        <div class="col-sm-4">Alamat Lembaga</div><label class="col-sm-8">: <?php echo $row['alamat_kab'];?></label>
    </div>
    <div>
        <div class="col-sm-4">No. Telp.</div><label class="col-sm-8">: <?php echo $row['telpon_kab'];?></label>
    </div>
    <div>
        <div class="col-sm-4">Nomor</div><label class="col-sm-8">: <?php echo $row['no_bh'];?></label>
    </div>
    <div>
        <div class="col-sm-4">Email Kabupaten</div><label class="col-sm-8">: <?php echo $row['email_kab'];?></label>
    </div>
</fieldset>
<div class="form-actions">
    <button href="#tab52" data-toggle="tab" class="btn btn-inverse btn-rounded pull-right"><i class="fa fa-edit"></i>
        Ubah Data</button>
    <label></label>
</div>