<?php session_start();
$sT="A";
$vL=$_GET['vL'];
$sebutan="PINJAMAN";
$status="AKTIF";
$nama="pencairan";
$kolom="";
$jumlahdok = $jum_akt;
$wR="pk.status='A'";
$js="1";
?>
<script type="text/javascript">	
    $(function() {
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
    	var ids = ID;
    	$.ajax({
    		type	: "POST",
    		url		: "modul/simpanan/detail_simpanan_individu.php",
    		data	: "ids="+ids,			  
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
		<h3><i class="fa fa-users"></i> <?php echo "SIMPANAN UMUM";?> 
			<span class="pull-right">
			
						<a href="2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=HBb" target="_blank" id="TampilHitungBunga" class="btn btn-info"><i class="glyphicon glyphicon-refresh"></i> Perhitungan Bulanan 1</a>
						<a href="2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=HBb2" target="_blank" id="TampilHitungBunga" class="btn btn-info"><i class="glyphicon glyphicon-refresh"></i> Perhitungan Bulanan 2</a>
		                <a href="javascript:;" onclick="MM_openBrWindow('/modul/simpanan/cs/s_CetakUmum.php?&js=<?php echo $js;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-info "><i class="glyphicon glyphicon-print"></i> Cetak</a>
			</span>
<span class="fs-mini"><br><b>Keterangan :</b> Klik untuk melihat detail simpanan | &nbsp;
				</span></h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="ajax-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>TGL BUKA</th>
                            <th class="hidden-xs">NOREK</th>
                            <th class="hidden-xs">NAMA NASABAH</th>
                            <th class='hidden-xs'>Debit</th>
                            <th class='hidden-xs'>Kredit</th>
                            <th class='hidden-xs'>Saldo</th>
                            <th class="no-sort">Status</th>
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
<script>
	$(document).ready(function () {
	    var column = [
            { data: 'no', name: 'no' },
            { data: 'cif', name: 'si.id' },
            { data: 'tgl_buka', name: 'si.tgl_buka' },
            { data: 'norek', name: 'si.nomor_rekening' },
            { data: 'nama', name: 'a.namadepan' },
            { data: 'debit' },
            { data: 'kredit' },
            { data: 'saldo' },
            { data: 'status' }
        ];
	
        var table = $('#ajax-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            columnDefs: [{
                targets: 5,
                orderable: false,
                searchable: false
            },{
                targets: 6,
                orderable: false,
                searchable: false
            },{
                targets: 7,
                orderable: false,
                searchable: false
            },{
                targets: 8,
                orderable: false,
                searchable: false
            }],
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['name'];
                });
            },
            "ajax": {
                url:'modul/simpanan/list_simpanan_individu.php?status=' + status,
                dataSrc: 'data',
                dataFilter: function(data){
                    var json = JSON.parse(data);
                    // console.log(JSON.stringify(json))
                    if (json) {
                        json.recordsTotal = json.recordsTotal;
                        json.recordsFiltered = json.recordsFiltered;
                        json.data = json.data
              
                        return JSON.stringify(json); // return JSON string
                    } else {
                        return JSON.stringify({
                            '':''
                        })
                    }
                    
                }
            },
            "columns": column
        });
     
        $('#ajax-table tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            var tab = '#tabp2'
            
            var tabs = $('.tab-pane').removeClass('active')
            DetailProposal(data.cif)
            
            $(tab).toggleClass('active')
        });
    });
</script>