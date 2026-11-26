<?php session_start();
$id_pinj	=$_SESSION['id_pinkel'];
$sts		=$_SESSION['sts'];
?>

<script type="text/javascript">
		
		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
</script>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_SPK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK</a>
	<?php if($_SESSION['lokasi']=='1' ){ //lokasi pejagoan >>>> 97
?>		
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK_mm.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK Manunggal Motor</a>
<?php } ?>
	<?php if($_SESSION['lokasi']=='68' or  $_SESSION['lokasi']=='128' ){ //lokasi Sariwangi-Tsm dan Kademangan - Blitar
?>		
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK_bp.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK Kredit Barang</a>
<?php } ?>


<?php if($_SESSION['lokasi']=='3' or $_SESSION['lokasi']=='1'){ //Lokasi Kandangan
?>		
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_SPK_KB.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK Kredit Barang</a>
<?php } ?>

	<?php if($_SESSION['lokasi']=='97'){ //lokasi pejagoan >>>> 97
?>		

	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK_mk.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK Manunggal Karya</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK_p.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK Cash Tempo</a>
<?php } ?>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_RA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Rencana Angsuran</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_BA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Berita Acara</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_KW2.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kwitansi</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_KA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kartu Angsuran</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_AKK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Analisa Keputusan Kredit</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPember.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Pemberitahuan</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_PDSP.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Pengikat Diri Sebagai Penjamin</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_SPS.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Pernyataan Suami</a>	
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/COPER_i.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Cover</a>	
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/COPER2_i.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Cover 2</a>	
	<?php 
if($sts=="A") {
?>	
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_STag.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Tagihan</a>	
<?php 
}
?>		