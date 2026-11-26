<?php session_start();
$id_pinj	=$_SESSION['id_pinkel'];
$sts		=$_SESSION['sts'];
?>

<script type="text/javascript">
		
		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
</script>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> SPK</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/RA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Rencana Angsuran</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SK.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Kuasa</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/BA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Berita Acara Pencairan</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/TT.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Tanda Terima Pinjaman</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KW1.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kwitansi 1</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KW2.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kwitansi 2</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/DH.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Daftar Hadir</a>
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KA.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Kartu Angsuran</a>												
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPem.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Pemberitahuan ke Desa</a>												
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/ST.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Tanggung Renteng</a>	
<?php 
if($sts=="A") {
?>	
	<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/STag.php?&rcp=<?php echo $id_pinj;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded width-200 mb-xs"><i class="glyphicon glyphicon-print"></i> Surat Tagihan</a>	
<?php 
}
?>		