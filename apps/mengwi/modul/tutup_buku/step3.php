<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
include "../../inc/fungsi_pinjaman.php";

$tgl_kondisi        = "$_SESSION[tahunbuku]-12-31";
$surplus_kotor        = surplus($tgl_kondisi);
$cr_spp                = totCR("$tgl_kondisi-1");
$cr_uep                = totCR("$tgl_kondisi-2");
$cadangan_resiko    = $cr_spp + $cr_uep;
$pendaatan_op_non    = saldoawalK("$tgl_kondisi-412.04") + saldoBBK("$tgl_kondisi-412.04");

$surplusbersih        = $surplus_kotor - $cadangan_resiko - $pendaatan_op_non;
if ($surplusbersih < 0) {
    $surplus_bersih = 0;
    $cadanganresiko = $surplus_kotor;
} else {
    $surplus_bersih = $surplusbersih;
    $cadanganresiko = $cadangan_resiko;
}

$_SESSION['surplus_kotor'] = $surplus_kotor;
$_SESSION['surplus_bersih'] = $surplus_bersih;

$tbtahunlalu        = $_SESSION['tahunbuku'] - 1;
$sdit = mysql_fetch_array(mysql_query("SELECT tb$tbtahunlalu as tb FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='316.01' "));
$sditlalu    = $sdit['tb'];

$row = mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
$asu_kelembagaan    = $row['asu_kelembagaan'];
$asu_dansos            = $row['asu_dansos'];
$asu_bonus_upk        = $row['asu_bonus_upk'];
$asu_lainnya        = $row['asu_lainnya'];
$asu_modal            = $row['asu_ditahan'];

$kelembagaan        = floor($surplus_bersih * $asu_kelembagaan / 100);
$dansos                = floor($surplus_bersih * $asu_dansos / 100);
$bonus_upk            = floor($surplus_bersih * $asu_bonus_upk / 100);
$lainnya            = floor($surplus_bersih * $asu_lainnya / 100);

$modal                = $surplus_bersih - $kelembagaan - $dansos - $bonus_upk - $lainnya;
$surdit                = $pendaatan_op_non + $sditlalu; //surdit belum termasuk penambahan modal
$_SESSION['surdit']    = $surdit;
?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
        $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
        $("#SurDit").load('modul/tutup_buku/surdit.php');
        $("#TotalControl").load('modul/tutup_buku/total_control.php');

        $("#SimpanSurplus").click(function() {
            var ditahan = $('#ditahan').val();
            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_ditahan.php",
                data: "ditahan=" + ditahan,

                success: function(data) {
                    $("#SuksesUPS").load('modul/sop/sukses.php');
                }
            });
        });


        $("#kelembagaan").keyup(function() {
            var kelembagaan = $('#kelembagaan').val();
            var dansos = $('#dansos').val();
            var bonus = $('#bonus').val();
            var lain = $('#lain').val();
            var ditahan = $('#ditahan').val();
            var cadanganresiko = $('#cadanganresiko').val();

            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_surplus.php",
                data: "kelembagaan=" + kelembagaan +
                    "&dansos=" + dansos +
                    "&bonus=" + bonus +
                    "&lain=" + lain +
                    "&cadanganresiko=" + cadanganresiko +
                    "&ditahan=" + ditahan,
                success: function(data) {
                    $("#SuksesEdit1").load('modul/tutup_buku/sukses_edit.php');
                    $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
                    $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
                    $("#SurDit").load('modul/tutup_buku/surdit.php');
                    $("#TotalControl").load('modul/tutup_buku/total_control.php');

                }
            });
        });

        $("#dansos").keyup(function() {
            var kelembagaan = $('#kelembagaan').val();
            var dansos = $('#dansos').val();
            var bonus = $('#bonus').val();
            var lain = $('#lain').val();
            var ditahan = $('#ditahan').val();
            var cadanganresiko = $('#cadanganresiko').val();

            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_surplus.php",
                data: "kelembagaan=" + kelembagaan +
                    "&dansos=" + dansos +
                    "&bonus=" + bonus +
                    "&lain=" + lain +
                    "&cadanganresiko=" + cadanganresiko +
                    "&ditahan=" + ditahan,
                success: function(data) {
                    $("#SuksesEdit2").load('modul/tutup_buku/sukses_edit.php');
                    $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
                    $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
                    $("#SurDit").load('modul/tutup_buku/surdit.php');
                    $("#TotalControl").load('modul/tutup_buku/total_control.php');

                }
            });
        });

        $("#bonus").keyup(function() {
            var kelembagaan = $('#kelembagaan').val();
            var dansos = $('#dansos').val();
            var bonus = $('#bonus').val();
            var lain = $('#lain').val();
            var ditahan = $('#ditahan').val();
            var cadanganresiko = $('#cadanganresiko').val();

            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_surplus.php",
                data: "kelembagaan=" + kelembagaan +
                    "&dansos=" + dansos +
                    "&bonus=" + bonus +
                    "&lain=" + lain +
                    "&cadanganresiko=" + cadanganresiko +
                    "&ditahan=" + ditahan,
                success: function(data) {
                    $("#SuksesEdit3").load('modul/tutup_buku/sukses_edit.php');
                    $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
                    $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
                    $("#SurDit").load('modul/tutup_buku/surdit.php');
                    $("#TotalControl").load('modul/tutup_buku/total_control.php');

                }
            });
        });

        $("#lain").keyup(function() {
            var kelembagaan = $('#kelembagaan').val();
            var dansos = $('#dansos').val();
            var bonus = $('#bonus').val();
            var lain = $('#lain').val();
            var ditahan = $('#ditahan').val();
            var cadanganresiko = $('#cadanganresiko').val();

            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_surplus.php",
                data: "kelembagaan=" + kelembagaan +
                    "&dansos=" + dansos +
                    "&bonus=" + bonus +
                    "&lain=" + lain +
                    "&cadanganresiko=" + cadanganresiko +
                    "&ditahan=" + ditahan,
                success: function(data) {
                    $("#SuksesEdit4").load('modul/tutup_buku/sukses_edit.php');
                    $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
                    $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
                    $("#SurDit").load('modul/tutup_buku/surdit.php');
                    $("#TotalControl").load('modul/tutup_buku/total_control.php');

                }
            });
        });


        $("#cadanganresiko").keyup(function() {
            var kelembagaan = $('#kelembagaan').val();
            var dansos = $('#dansos').val();
            var bonus = $('#bonus').val();
            var lain = $('#lain').val();
            var ditahan = $('#ditahan').val();
            var cadanganresiko = $('#cadanganresiko').val();

            $.ajax({
                type: "POST",
                url: "modul/tutup_buku/update_surplus.php",
                data: "kelembagaan=" + kelembagaan +
                    "&dansos=" + dansos +
                    "&bonus=" + bonus +
                    "&lain=" + lain +
                    "&cadanganresiko=" + cadanganresiko +
                    "&ditahan=" + ditahan,
                success: function(data) {
                    $("#SuksesEdit5").load('modul/tutup_buku/sukses_edit.php');
                    $("#TambahModal").load('modul/tutup_buku/tambah_modal.php');
                    $("#TambahModalSurdit").load('modul/tutup_buku/tambah_modal_surdit.php');
                    $("#SurDit").load('modul/tutup_buku/surdit.php');
                    $("#TotalControl").load('modul/tutup_buku/total_control.php');

                }
            });
        });


    });
</script>

<legend class="h4"><strong> Step 3 :</strong> Pembagian SHU <?php echo $_SESSION['tahunbuku']; ?></legend>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label class="col-sm-12 control-label"><strong>Perhitungan Surplus</strong></label>

            <label class="col-sm-5 control-label">Surplus Kotor</label>
            <label class="col-sm-3 control-label text-align-right"><?php echo number_format($surplus_kotor); ?></label>
            <label class="col-sm-5 control-label">Total Laba</label>
            <label class="col-sm-3 control-label text-align-right"><?php echo number_format($surplus_kotor); ?></label>

            <label class="col-sm-12 control-label">&nbsp;</label>
        </div>

        <div class="form-group">
            <label class="col-sm-12 control-label"><strong>Pembagian SHU</strong></label>
            <label class="col-sm-4 control-label">SHU Anggota</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_kelembagaan %"; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="kelembagaan" name="kelembagaan" value="<?php echo $kelembagaan; ?>" required="required" autocomplete="off" placeholder="Alokasi Kelembagaan">
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit1"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">SHU Penyedia Modal</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_dansos %"; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="dansos" name="dansos" value="<?php echo $dansos; ?>" required="required" autocomplete="off" placeholder="Alokasi Dana Sosial">
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit2"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Utang Beban Tahun Lalu</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_bonus_upk %"; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="bonus" name="bonus" value="<?php echo $bonus_upk; ?>" required="required" autocomplete="off" placeholder="Alokasi Bonus Koperasi">
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit3"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Bantuan Sosial</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_lainnya %"; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="lain" name="lain" value="<?php echo $lainnya; ?>" required="required" autocomplete="off" placeholder="Alokasi Lain-lain">
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit4"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Alokasi lain - lain</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_lainnya %"; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control text-align-right" id="lain" name="lain" value="<?php echo $lainnya; ?>" required="required" autocomplete="off" placeholder="Alokasi Lain-lain">
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit4"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Alokasi Penambahan Modal</label>
            <label class="col-sm-4 control-label"><?php echo number_format($surplus_bersih) . " x $asu_modal %"; ?></label>
            <div class="col-sm-3">
                <div id="TambahModal"></div>
            </div>
            <div class="col-sm-1">
                <div id="SuksesEdit5"></div>
            </div>

            <label class="col-sm-5 control-label text-align-center"><strong>Total Control</strong></label>
            <label class="col-sm-6 control-label text-align-right"><strong><?php echo $surplus_kotor; ?></strong></label>
            <label class="col-sm-12 control-label">&nbsp;</label>
        </div>


        <!--<div class="form-group">-->
        <!--    <label class="col-sm-5 control-label">Pendapatan Operasional 2% NonSPP/UEP</label>-->
        <!--    <label class="col-sm-3 control-label text-align-right"><?php echo number_format($pendaatan_op_non); ?></label>-->
        <!--</div>-->

        <div class="form-group">
            <label class="col-sm-5 control-label">Alokasi Penambahan Modal</label>
            <label class="col-sm-3 control-label text-align-right">
                <div id="TambahModalSurdit"></div>
            </label>
        </div>

        <div class="form-group">
            <label class="col-sm-5 control-label">Laba Ditahan s.d. Tahun Lalu</label>
            <label class="col-sm-3 control-label text-align-right"><?php echo number_format($sditlalu); ?></label>
        </div>

        <div class="form-group">
            <label class="col-sm-8 control-label text-align-center"><strong>Total Surplus Ditahan</strong></label>
            <div class="col-sm-3">
                <div id="SurDit"></div>
            </div>
            <label class="col-sm-12 control-label">&nbsp;</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="alert alert-info animated fadeInDown">
            <legend><strong>Perhatian</strong></legend>
            <ol>
                <li>Isikan pembagian surplus sesuai dengan Alokasinya</li>
                <li>Angka tersebut disamping hanyalah angka rekomendasi SI Koperasi Online, anda dapat merubahnya</li>
                <li>Klik tombol simpan jika Anda telah yakin dengan alokasi surplus</li>
                <li>Angka-angka tersebut akan automatis masuk ke Neraca bagian Passiva</li>
                <li>Anda dapat merubah dilain waktu jika ada kekeliruan, dengan mengulangi mulai step 1</li>
            </ol>
            <button type="button" class="btn btn-info input-lg" id="SimpanSurplus"><i class="glyphicon glyphicon-book text-white"></i> Simpan Alokasi Surplus</button>

        </div>

        <div id="SuksesUPS"></div>
    </div>
</div>