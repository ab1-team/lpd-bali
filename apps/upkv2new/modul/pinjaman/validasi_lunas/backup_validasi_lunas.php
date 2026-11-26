<script type="text/javascript">	

	function DetailProposal(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/pinjaman/proposal/detail_proposal.php",
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
		<h3><i class="fa fa-users"></i> <?php echo "$jum_lns PINJAMAN DENGAN SALDO NOL (0)";?> </h3>
		<span class="fs-mini text-muted pull-right">* Klik untuk Validasi Lunas |&nbsp;
			<?php
			$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'");
				while($pp=mysql_fetch_array($dpp)){
				echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
				}
			?>
			</span>
			<?php
			if($_GET['s']=="suksesVL"){
			?>
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i><strong> Validasi Lunas Berhasil, </strong>status kelompok tersebut menjadi L dan dapat dicairkan kembali.
			</div>
			<?php } ?>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="ajax-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>LOAN ID</th>
                            <th>TGL CAIR</th>
                            <th class="hidden-xs">KELOMPOK</th>
                            <th class="hidden-xs">Alokasi</th>
                            <th class="hidden-xs">PENGEMBALIAN</th>
                            <th class="hidden-xs">saldo</th>
                            <th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
            </div>
			
        </div>
		<div class="tab-pane" id="tabp2">
			<div id="DetailProposal"></div>
        </div>
    </div>
	</div>
</section>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function () {
	    var column = [
            { data: 'no', name: 'pk.id' },
            { data: 'id', name: 'pk.id' },
            { data: 'tgl_cair', name: 'pk.tgl_cair' },
            { data: 'nama_kelompok', name: 'k.kd_kelompok' },
            { data: 'alokasi' },
            { data: 'sumpokok' },
            { data: 'saldo' },
            { data: 'status', render: function(data, type, row) {
                var bg = row.warna;
                return "<span class='label label-" + bg + " pull-right'>" + data + "</span>"; }
            }
        ];
        
        var orders = [{
            targets: 0,
            orderable: false,
            searchable: false
        },{
            targets: 1,
            orderable: false
        },{
            targets: 2,
            orderable: false
        },{
            targets: 3,
            orderable: false
        },{
            targets: 4,
            orderable: false,
            searchable: false
        },{
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
        }]
	
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
                url:'modul/pinjaman/validasi_lunas/list_lunas.php',
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
            DetailProposal(data.id)
            
            $(tab).toggleClass('active')
        });
    });
</script>