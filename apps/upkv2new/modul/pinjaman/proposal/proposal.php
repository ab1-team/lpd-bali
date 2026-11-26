<?php session_start();
$sT=$_GET['sT'];
$vL=$_GET['vL'];

if($sT=="P"){
	$sebutan="PROPOSAL";
	$status="MENUNGGU VERIFIKASI";
	$nama="proposal";
	$kolom="<th class='hidden-xs'>Proposal</th>";
	$jumlahdok	=$jum_prop;
}elseif($sT=="V"){
	$sebutan="PROPOSAL";
	$status="VERIFIED";
	$nama="verifikasi";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Verifikasi</th>";
	$jumlahdok	=$jum_ver;
}elseif($sT=="W"){
	$sebutan="PROPOSAL";
	$status="WAITING LIST";
	$nama="tunggu";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Alokasi</th>";
	$jumlahdok	=$jum_wait;
}elseif($sT=="A"){
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="pencairan";
	$kolom="<th class='hidden-xs'>Alokasi</th><th class='hidden-xs'>Saldo</th>";
	$jumlahdok	=$jum_akt;
}
?>
<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
	function DetailProposal(ID){
		var id = ID;
		<?php if ($_SESSION['level']=='1'){ //UPK ?>
		    var tujuan = "modul/pinjaman/proposal/detail_proposal.php"
		<?php }elseif ($_SESSION['level']=='4' || $_SESSION['level']=='5'){ //TV ?>
		    var tujuan = "modul/pinjaman/verifikasi/detail_verifikasi.php"
		<?php } ?>
		
		$.ajax({
			type	: "POST",
			url		: tujuan,
			data	: {
			    id: id
			},
			success	: function(data){
				$('#DetailProposal').html(data);
				
			}
		});
		
	}
</script>

<style>
    table tbody tr {
        cursor: pointer;
    }
</style>

<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="fa fa-users"></i> <?php echo "$jumlahdok $sebutan $status";?> 
			<span class="pull-right">
			<?php if ($_SESSION['level']=='1' and $sT=="P"){	//UPK ?>
				<a href="?p=p1" class="btn btn-primary width-200"><i class="fa fa-plus-circle"></i> Tambah Proposal</a>
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php }else{ ?>
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php } ?>
			</span>
		
		<span class="fs-mini"><br><b>Keterangan :</b> Klik untuk melihat detail pinjaman | &nbsp;
					<?php
					$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'");
						while($pp=mysql_fetch_array($dpp)){
						echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
						}
					?>
				</span></h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="ajax-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>LOAN ID</th>
                            <th>TGL <?php echo $nama; ?></th>
                            <th class="hidden-xs">KD.KELOMPOK</th>
                            <th class="hidden-xs">Nama Kelompok</th>
							<?php echo $kolom;?>
                            <th class="no-sort"><i class="fa fa-user"></i></th>
                            <th class="no-sort">Jenis Pinjaman</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            
                        </tbody>
                    </table>

            </div>
			<?php
			$sts=$_GET['s'];
			if($sts=="ok"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Verifikasi Berhasil, </strong>dan telah dikirim kembali ke UPK untuk diproses lebih lanjut.
			</div>
			<?php } elseif($sts=="suksesWL"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Proposal Berhasil masuk ke Waiting List, </strong>anda dapat mencetak Dokumen Pencairan melalui menu Waiting List
			</div>
			<?php } elseif($sts=="suksesVU"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Proposal Berhasil diubah menjadi P, </strong>dan telah dikirim kembali ke Tim Verifikasi untuk di Verifikasi Ulang
			</div>
			<?php } elseif($sts=="suksesC"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Pinjaman berhasil dicairkan, </strong>dan jurnal transaksi pencairan telah dibuat otomatis
			</div>
			<?php } elseif($sts=="suksesRS"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Rescedulling Pinjaman berhasil !</strong>dan SPK baru telah kami buat.
			</div>
			<?php } elseif($sts=="suksesPH"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-times"></i><strong> Penghapusan Pinjaman berhasil !</strong>pinjaman berubah menjadi H dan Transaksi Penghapusan telah dibuat.
			</div>
			<?php } ?>
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposal"></div>
        </div>
    </div>
	</div>
</section>

<!--<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-print-2.2.3/cr-1.5.6/kt-2.7.0/r-2.3.0/sb-1.3.4/datatables.min.js"></script>-->
<script>
	$(document).ready(function () {
    	var status = "<?php echo $sT; ?>";
    	if (status == 'P') {
    	    var column = [
                { data: 'no', name: 'pk.id' },
                { data: 'loan_id', name: 'pk.id' },
                { data: 'tgl', name: 'pk.tgl_proposal' },
                { data: 'kd_kel', name: 'k.kd_kelompok' },
                { data: 'nama_kel', name: 'k.nama_kelompok' },
                { data: 'proposal', name: 'pk.proposal' },
                { data: 'anggota' },
                { data: 'status', name: 'pk.status' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            }]
    	} else if (status == 'V') {
    	    var column = [
                { data: 'no', name: 'pk.id' },
                { data: 'loan_id', name: 'pk.id' },
                { data: 'tgl', name: 'pk.tgl_verifikasi' },
                { data: 'kd_kel', name: 'k.kd_kelompok' },
                { data: 'nama_kel', name: 'k.nama_kelompok' },
                { data: 'proposal', name: 'pk.proposal' },
                { data: 'alokasi', name: 'pk.alokasi' },
                { data: 'anggota' },
                { data: 'status', name: 'pk.status' },
            ];
            
            var orders = [{
                targets: 7,
                orderable: false,
                searchable: false
            }]
    	} else if (status == 'W') {
    	    var column = [
                { data: 'no', name: 'pk.id' },
                { data: 'loan_id', name: 'pk.id' },
                { data: 'tgl', name: 'pk.tgl_tunggu' },
                { data: 'kd_kel', name: 'k.kd_kelompok' },
                { data: 'nama_kel', name: 'k.nama_kelompok' },
                { data: 'proposal', name: 'pk.proposal' },
                { data: 'alokasi', name: 'pk.alokasi' },
                { data: 'anggota' },
                { data: 'status', name: 'pk.status' },
            ];
            
            var orders = [{
                targets: 7,
                orderable: false,
                searchable: false
            }]
    	} else if (status == 'A') {
    	    var column = [
                { data: 'no', name: 'pk.id' },
                { data: 'loan_id', name: 'pk.id' },
                { data: 'tgl', name: 'pk.tgl_cair' },
                { data: 'kd_kel', name: 'k.kd_kelompok' },
                { data: 'nama_kel', name: 'k.nama_kelompok' },
                { data: 'alokasi', name: 'pk.alokasi' },
                { data: 'saldo' },
                { data: 'anggota' },
                { data: 'status', name: 'pk.status' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            },{
                targets: 7,
                orderable: false,
                searchable: false
            }]
    	}
	
        var table = $('#ajax-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            columnDefs: orders,
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['name'];
                });
            },
            "ajax": {
                url:'modul/pinjaman/proposal/list_proposal.php?status=' + status,
                dataSrc: 'data',
                dataFilter: function(data){
                    var json = JSON.parse(data);
                    // console.log(!json)
                    if (json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
                        json.data = json.data;
              
                        return JSON.stringify( json ); // return JSON string
                    } else {
                        return JSON.stringify({'':''})
                    }
                    
                }
            },
            "columns": column
        });
     
        $('#ajax-table tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            var tab = '#tabp2'
            
            var tabs = $('.tab-pane').removeClass('active')
            DetailProposal(data.loan_id)
            
            $(tab).toggleClass('active')
        });
    });
</script>
