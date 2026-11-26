<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
?>

        <!-- Report and Sub Report Selection -->
        <div class="col-md-8" style="margin-bottom: 10px;">
            <label for="report">Report:<?php 
				echo "select * from jenis_laporan Where lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER BY urut";?></label>
            <select name="report" id="report" class="form-control" onchange="updateSubReportOptions()">
                <option value="">Pilih Laporan</option>
                <?php 
                $view=mysql_query("select * from jenis_laporan Where lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER BY urut"); //Jenis Laporan
                while($row=mysql_fetch_array($view)){
                    echo "<option value='$row[file]'>$row[file] | $row[nama_laporan]</option>";
                } ?>
            </select>
        </div>