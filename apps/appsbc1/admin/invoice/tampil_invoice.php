<?php session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "inc/inc.koneksi.php";
						include "inc/fungsi_keuangan_admin.php";
?>

<script type="text/javascript">	

function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});


	
	function DetailInvoice(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "admin/invoice/detail_invoice.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tab2').html(data);
				
			}
		});
		
	}
</script>
<?php
$level = $_SESSION['level'];
$lokasi = $_SESSION['lokasi'];
if($level=='pusat') {
	$kondisi="";
}else if($level==1) {
	$kondisi="lokasi='$lokasi' ";
}

		
if ($_GET['sts']=="UNPAID"){ 
	$kolom_tanggal="TGL INVOICE";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' $kondisi")); 
	$AllSaldo=AllSaldo();
}else if ($_GET['sts']=="PAID"){
	$kolom_tanggal="TGL LUNAS";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='PAID' $kondisi"));
	$jumtag=mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah from admin_invoice WHERE status='PAID' $kondisi"));
	$AllSaldo=$jumtag['sumjumlah'];
	}else if ($_GET['sts']==""){
	$kolom_tanggal="TGL INVOICE";
	$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE $kondisi"));
	$AllSaldo="";
	}
	
	if($jumpaid>0){ $ketjumpaid=$jumpaid; }else{$ketjumpaid="BELUM ADA";}
?>

<section class="widget">
 <div class="widget-body">
 <legend>
		<h3 class="fw-semi-bold"><i class="glyphicon glyphicon-th-large"></i> <?php echo "$ketjumpaid INVOICE $_GET[sts]";?><span class="pull-right"><?php echo number_format($AllSaldo); ?></span></h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tab1">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-danger text-white">
                        <tr>
                            <th>NOMOR</th>
                            <th class="hidden-xs">LOKASI/KECAMATAN</th>
                            <th class="hidden-xs">JENIS PEMBAYARAN</th>
                            <th class="hidden-xs"><?php echo $kolom_tanggal;?></th>
                            <th class="hidden-xs">TAGIHAN</th>
                            <th class="hidden-xs">SALDO</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						if($level=='pusat') {
							$view=mysql_query("SELECT * FROM kabupaten b, kecamatan c, admin_jenis_pembayaran j, admin_invoice i  WHERE b.id=c.kd_kab AND c.id=i.lokasi AND j.id=i.jenis_pembayaran AND i.status='$_GET[sts]' ");
						}else if($level==1) {
							$view=mysql_query("SELECT * FROM kabupaten b, kecamatan c, admin_jenis_pembayaran j, admin_invoice i  WHERE b.id=c.kd_kab AND c.id=i.lokasi AND j.id=i.jenis_pembayaran AND i.lokasi='$lokasi' ");
						}
								while($row=mysql_fetch_array($view)){ 
								
								
								
									if ($row['status']=="PAID"){
										$bg="success";
										$kolom_tanggal="TGL INVOICE";
										$tanggal=$row['tgl_lunas'];
										}else{
										$bg="danger"; 
										$kolom_tanggal="TGL LUNAS";
										$tanggal=$row['tgl_invoice'];}
										
									$nomor=$row['idv'];
										
									if($nomor<10) {
										$nomor_invoice="00000$nomor";
									}else if($nomor>=10 AND $nomor<100) {
										$nomor_invoice="0000$nomor";
									}else if($nomor>=100 AND $nomor<1000) {
										$nomor_invoice="000$nomor";
									}else if($nomor>=1000 AND $nomor<10000) {
										$nomor_invoice="00$nomor";
									}else if($nomor>=10000 AND $nomor<100000) {
										$nomor_invoice="0$nomor";
									}else if($nomor>100000) {
										$nomor_invoice="$nomor";
									}
									
									
									$sumSaldo=sumSaldo($nomor);
						echo "
						<tr>
                            <td class='subject hidden-xs' width='10%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>#$nomor_invoice</td>
							<td class='subject hidden-xs' width='30%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>$row[nama_kec] - $row[nama_kab] - $row[nama_prov]</td>
							<td class='subject hidden-xs' width='30%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>$row[nama_jp]</td>
							<td class='subject hidden-xs' width='15%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>$tanggal</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>".number_format($row['jumlah'])."</td>
							<td class='subject hidden-xs text-align-right' width='15%' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'>".number_format($sumSaldo)."</td>
                            <td class='subject hidden-xs' href='#tab2' onclick='javascript:DetailInvoice(\"{$row[idv]}\")' data-toggle='tab'><span class='toggle badge bg-$bg pull-right'>$row[status]</span></td>
                        </tr> ";
						 } 
						 //<a href='#tab2' onclick='javascript:editanggota(\"{$row[id]}\")' data-toggle='tab' title='Edit $row[namadepan]'><span class='toggle label bg-primary'><i class='fa fa-edit'></i></span></a>
						 ?>
                        </tbody>
                    </table>
                </div>
			</div>
		<div class="tab-pane" id="tab2">
			<div id="DetailInvoice"></div>
        </div>
    </div>
</div>
</section>