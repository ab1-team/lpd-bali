<?php session_start();
include "../../../inc/inc.koneksi.php"; 

$id_pinj=$_POST['cari'];
$r=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman jpp, pinjaman_anggota_$_SESSION[kd_kab] pi
					WHERE jpp.id=pi.jenis_pp AND pi.id='$id_pinj' "));
$kecamatan=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id=$_SESSION[lokasi]"));

$kunci_alokasi =$r['alokasi'];
?>

<script type="text/javascript">
$("#alokasi").focus();
function tandaPemisahTitik(b) {
                var _minus = false;
                if (b < 0) _minus = true;
                b = b.toString();
                b = b.replace(".", "");

                c = "";
                panjang = b.length;
                j = 0;
                for (i = panjang; i > 0; i--) {
                    j = j + 1;
                    if (((j % 3) == 1) && (j != 1)) {
                        c = b.substr(i - 1, 1) + "." + c;
                    } else {
                        c = b.substr(i - 1, 1) + c;
                    }
                }
                if (_minus) c = "-" + c;
                return c;
            }

            function numbersonly(ini, e) {
                if (e.keyCode >= 49) {
                    if (e.keyCode <= 57) {
                        a = ini.value.toString().replace(".", "");
                        b = a.replace(/[^\d]/g, "");
                        b = (b == "0") ? String.fromCharCode(e.keyCode) : b + String.fromCharCode(e.keyCode);
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else if (e.keyCode <= 105) {
                        if (e.keyCode >= 96) {
                            //e.keycode = e.keycode - 47;
                            a = ini.value.toString().replace(".", "");
                            b = a.replace(/[^\d]/g, "");
                            b = (b == "0") ? String.fromCharCode(e.keyCode - 48) : b + String.fromCharCode(e.keyCode -
                                48);
                            ini.value = tandaPemisahTitik(b);
                            //alert(e.keycode);
                            return false;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 48) {
                    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode);
                    b = a.replace(/[^\d]/g, "");
                    if (parseFloat(b) != 0) {
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 95) {
                    a = ini.value.replace(".", "") + String.fromCharCode(e.keyCode - 48);
                    b = a.replace(/[^\d]/g, "");
                    if (parseFloat(b) != 0) {
                        ini.value = tandaPemisahTitik(b);
                        return false;
                    } else {
                        return false;
                    }
                } else if (e.keyCode == 8 || e.keycode == 46) {
                    a = ini.value.replace(".", "");
                    b = a.replace(/[^\d]/g, "");
                    b = b.substr(0, b.length - 1);
                    if (tandaPemisahTitik(b) != "") {
                        ini.value = tandaPemisahTitik(b);
                    } else {
                        ini.value = "";
                    }

                    return false;
                } else if (e.keyCode == 9) {
                    return true;
                } else if (e.keyCode == 17) {
                    return true;
                } else {
                    //alert (e.keyCode);
                    return false;
                }
            }
	$("#GoCairkanIndividu").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var jenis_pp			= $('#jenis_pp').val();
		var tgl_cair			= $('#tgl_cair').val();
		var alokasi				= $('#alokasi').val();
		var admin				= $('#admin').val();
		var provisi				= $('#provisi').val();
		var sumber				= $('#sumber').val();
		var metode				= $('#metode').val();
		var kunci_alokasi		= <?php echo $kunci_alokasi;?>
		
		if(alokasi.length==0){ alert('Alokasi tidak boleh kosong!'); $("#alokasi").focus(); return false; }
		if(admin.length==0){ alert('Admin tidak boleh kosong! input 0 jika tidak ada admin'); $("#admin").focus(); return false; }
		if(alokasi<=0){ alert('Alokasi tidak boleh NOL!'); $("#alokasi").focus(); return false; }
		if(alokasi>kunci_alokasi){ alert('Maaf Alokasi tidak boleh melebihi Hasil rekomendasi Analis Kredit!'); $("#alokasi").focus(); return false; }
		var i = 0
		var j = 0
		var k = 0
		while(i <= alokasi.length) {
		    alokasi = alokasi.toString().replace('.','')
		    i++
		}
		while(j <= admin.length) {
		    admin = admin.toString().replace('.','')
		    j++
		}
		while(k <= provisi.length) {
		    provisi = provisi.toString().replace('.','')
		    k++
		}
							
		var pilih = confirm('Tgl Cair '+tgl_cair+ ', dan Alokasi '+alokasi+ '?');
		if (pilih==true) {			
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/waiting/simpan_cair_individu.php",
				data: 	"id_pinj="+id_pinj+
						"&jenis_pp="+jenis_pp+
						"&tgl_cair="+tgl_cair+
						"&alokasi="+alokasi+
						"&admin="+admin+
						"&provisi="+provisi+
						"&sumber="+sumber+
						"&metode="+metode,
				success: function(data) {
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=W&s=suksesC';
				}
			});
		}
	});														
</script>

<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			Tanggal Pencairan
			<input type="text" class="form-control" name="tgl_cair" id="tgl_cair" value="<?php echo ($r['tgl_cair'] != '0000-00-00') ? $r['tgl_cair']:date('Y-m-d'); ?>"
			required="required" autocomplete="off" placeholder="Tanggal Pencairan"/>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
			Alokasi (Rp.)
			<input type="text" class="form-control" name="alokasi" id="alokasi" value="<?php echo number_format($r['alokasi'],0,',','.'); ?>"
			required="required" autocomplete="off" placeholder="Alokasi Kelompok" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
			Biaya Administrasi
			<input type="text" class="form-control" name="admin" id="admin" value="<?php echo number_format($kecamatan['admin'],0,',','.'); ?>"
			required="required" autocomplete="off" placeholder="admin Kelompok" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
			Provisi
			<input type="text" class="form-control" name="provisi" id="provisi" value="<?php echo number_format(($r['alokasi']*$kecamatan['provisi']/100),0,',','.'); ?>"
			required="required" autocomplete="off" placeholder="Provisi Kelompok" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
		</div>
	</div>
		<input type="hidden" name="id_pinj" id="id_pinj" value="<?php echo $r['id'];?>"/>
		<input type="hidden" name="jenis_pp" id="jenis_pp" value="<?php echo $r['jenis_pp'];?>"/>
		<input type="hidden" name="sumber" id="sumber" value="1"/>
		<input type="hidden" name="metode" id="metode" value="K"/>
	<div class="col-xs-12">
		<div class="text-center">
			<p class="fs-mini text-muted mt-sm">Cek Data Pencairan sebelum klik tombol Cairkan, data akan otomatis masuk ke jurnal transaksi</p>
			<button type="button" class="btn btn-danger width-200" id="GoCairkanIndividu"><i class="fa fa-money"></i> Cairkan</button>
		</div>
	</div>
</div>
<hr>