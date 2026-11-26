<?php session_start();
$sT=$_GET['sT'];
$vL=$_GET['vL_i'];

if($sT=="P"){
	$sebutan="PROPOSAL";
	$status="MENUNGGU VERIFIKASI";
	$nama="proposal";
	$kolom="<th class='hidden-xs'>Proposal</th>";
	$jumlahdok	=$jum_prop_i;
}elseif($sT=="V"){
	$sebutan="PROPOSAL";
	$status="VERIFIED";
	$nama="verifikasi";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Verifikasi</th>";
	$jumlahdok	=$jum_ver_i;
}elseif($sT=="W"){
	$sebutan="PROPOSAL";
	$status="WAITING LIST";
	$nama="tunggu";
	$kolom="<th class='hidden-xs'>Proposal</th><th class='hidden-xs'>Alokasi</th>";
	$jumlahdok	=$jum_wait_i;
}elseif($sT=="A"){
	$sebutan="PINJAMAN";
	$status="AKTIF";
	$nama="pencairan";
	$kolom="<th class='hidden-xs'>Alokasi</th><th class='hidden-xs'>Saldo</th>";
	$jumlahdok	=$jum_akt_i;
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
    	
    function DetailProposalIndividu(ID){
    	var id = ID;
    	$.ajax({
    		type	: "POST",
    		<?php if ($_SESSION['level']=='1'){ //UPK ?>
    		url		: "modul/pinjaman/proposal/detail_proposal_individu.php",
    		<?php }elseif ($_SESSION['level']=='4'){ //TV ?>
    		url		: "modul/pinjaman/verifikasi/detail_verifikasi_individu.php",
    		<?php } ?>
    		data	: "id="+id,			  
    		success	: function(data){
    			$('#tabp2').html(data);
    			
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
		<h3><i class="glyphicon glyphicon-user"></i> <?php echo "$jumlahdok $sebutan $status";?> 
			<span class="pull-right">
			<?php if ($_SESSION['level']=='1' and $sT=="P"){	//UPK ?>
				<a href="?p=p1" class="btn btn-primary width-200"><i class="fa fa-plus-circle"></i> Tambah Proposal</a>
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php }else{ ?>
				<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
			<?php } ?>
			</span>
		</h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk CRED Proposal dan Anggota |&nbsp;
			<?php
			$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'");
				while($pp=mysql_fetch_array($dpp)){
				echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
				}
			?>
			</span>
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
                            <th class="hidden-xs">NIK</th>
                            <th class="hidden-xs">Nama Pemanfaat</th>
                            <th class="hidden-xs">Desa</th>
							<?php echo $kolom;?>
                            <th class="hidden-xs">Jenis Pinjaman</th>
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
			<?php } elseif($sts=="suksesRC"){ ?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Rescedulling Pinjaman berhasil !</strong>dan SPK baru telah kami buat.
			</div>
			<?php } ?>
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposalIndividu"></div>
        </div>
    </div>
	</div>
</section>
<script>
	$(document).ready(function () {
    	var status = "<?php echo $sT; ?>";
    	
    	var orders = [{}];
    	if (status == 'P') {
    	    var column = [
                { data: 'no', name: 'pi.id' },
                { data: 'loan_id', name: 'pi.id' },
                { data: 'tgl', name: 'pi.tgl_proposal' },
                { data: 'nik', name: 'a.nik' },
                { data: 'nama', name: 'a.namadepan' },
                { data: 'desa', name: 'd.nama_desa' },
                { data: 'proposal' },
                { data: 'status', name: 'jpp.nama_jpp' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            }];
    	} else if (status == 'V') {
    	    var column = [
                { data: 'no', name: 'pi.id' },
                { data: 'loan_id', name: 'pi.id' },
                { data: 'tgl', name: 'pi.tgl_verifikasi' },
                { data: 'nik', name: 'a.nik' },
                { data: 'nama', name: 'a.namadepan' },
                { data: 'desa', name: 'd.nama_desa' },
                { data: 'proposal' },
                { data: 'alokasi' },
                { data: 'status', name: 'jpp.nama_jpp' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            }, {
                targets: 7,
                orderable: false,
                searchable: false
            }];
    	} else if (status == 'W') {
    	    var column = [
                { data: 'no', name: 'pi.id' },
                { data: 'loan_id', name: 'pi.id' },
                { data: 'tgl', name: 'pi.tgl_tunggu' },
                { data: 'nik', name: 'a.nik' },
                { data: 'nama', name: 'a.namadepan' },
                { data: 'desa', name: 'd.nama_desa' },
                { data: 'proposal', name: 'pi.proposal' },
                { data: 'alokasi', name: 'pi.alokasi' },
                { data: 'status', name: 'jpp.nama_jpp' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            }, {
                targets: 7,
                orderable: false,
                searchable: false
            }];
    	} else if (status == 'A') {
    	    var column = [
                { data: 'no', name: 'pi.id' },
                { data: 'loan_id', name: 'pi.id' },
                { data: 'tgl', name: 'pi.tgl_cair' },
                { data: 'nik', name: 'a.nik' },
                { data: 'nama', name: 'a.namadepan' },
                { data: 'desa', name: 'd.nama_desa' },
                { data: 'alokasi' },
                { data: 'saldo' },
                { data: 'status', name: 'jpp.nama_jpp' },
            ];
            
            var orders = [{
                targets: 6,
                orderable: false,
                searchable: false
            }, {
                targets: 7,
                orderable: false,
                searchable: false
            }];
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
                url:'modul/pinjaman/proposal/list_proposal_individu.php?status=' + status,
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
            DetailProposalIndividu(data.loan_id)
            
            $(tab).toggleClass('active')
        });
    });
</script>
