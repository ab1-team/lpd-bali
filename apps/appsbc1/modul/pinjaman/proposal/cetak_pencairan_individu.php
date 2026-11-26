<?php session_start();
include "../../../inc/inc.koneksi.php";
$id_pinj	=$_SESSION['id_pinkel'];

$row=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id='$id_pinj' "));	
?>

<script type="text/javascript">
		
		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
</script>
	<span class="fs-mini text-muted">Cetak Dokumen Nomor: <?php echo $row['spk_no'];?></span><br>
<div class="col-md-6">
	0. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_CoverDokumenPencairan.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Cover</a>	<br>
	1. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_AnalisaKredit.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Formulir Analisa Kredit</a><br>
	2. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_MemorandumPengusulan.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Memorandum Pengusulan Kredit</a><br>
	3. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_SuratKeputusanKredit.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Surat Keputusan Kredit (SKK)</a><br>
	4. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_SuratPerjanjianKredit.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Surat Perjanjian Kredit (SPK)</a><br>
    5. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_PenerimaanBarangJaminan.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Bukti Penerimaan Barang Jaminan</a><br>
</div>
<div class="col-md-6">
	6. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_SuratKuasaMenjual.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Surat Kuasa Menjual</a><br>
	7. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_BuktiPengeluaranKredit.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Bukti Pengeluaran Kredit</a><br>
	8. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_RencanaAngsuran.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Tabel Rencana Angsuran</a><br>
	9. Kartu Angsuran <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_KartuAngsuranLuar.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Hal-1</a> | 
		<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_KartuAngsuranDalam.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Hal-2</a><br>
	10. <a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/p_KuasaHak.php?&idp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="fw-normal">Surat Kuasa Pemindahan Hak</a><br>
</div>	