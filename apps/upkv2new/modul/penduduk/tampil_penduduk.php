<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	
	function editanggota(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/penduduk/cari.php",
			data	: "id="+id,
			dataType : "json",				  
			success	: function(data){
				$('#id').val(ID);
				$('#nik').val(data.nik);
				$('#namadepan').val(data.namadepan);
				$('#jk').val(data.jk);
				$('#tempat_lahir').val(data.tempat_lahir);
				$('#tgl_lahir').val(data.tgl_lahir);
				$('#alamat').val(data.alamat);
				$('#desa').val(data.desa);
				$('#lokasi').val(data.lokasi);
				$('#hp').val(data.hp);
				$('#kk').val(data.kk);
				$('#penjamin').val(data.penjamin);
				$('#hubungan').val(data.hubungan);
				$('#usaha').val(data.usaha);
				//$('#foto').val(data.foto);
				$('#terdaftar').val(data.terdaftar);
				$('#status').val(data.status);
				$('#petugas').val(data.petugas);
				$('#online').val(data.online);
				$('#lo').val(data.lo);
				$('#uname').val(data.nik);
				$('#pass').val(data.pass);
				
			}
		});
		
	}
	
	
	function deleteRow(ID) {
		var id	= ID;
	   var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/penduduk/hapus.php",
				data	: "id="+id,
				success	: function(data){
					alert('Berhasil!');
				}
			});
		}
	}
	
	function DetailAnggota(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/penduduk/detail/account.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tab2').html(data);
				
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
		<h3><i class="fa fa-users"></i> Data Base Penduduk</h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tab1">
                <div class="table-responsive">
                    <table id="ajax-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>No.</th>
                            <th>N i k</th>
                            <th class="hidden-xs">Nama Lengkap</th>
                            <th class="hidden-xs">Alamat Domisili</th>
                            <th class="hidden-xs"><i class="fa fa-phone"></i> Telpon</th>
							<th class="no-sort">Status Pinjaman</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
			</div>
		<div class="tab-pane" id="tab2">
			<div id="DetailDataAnggota"></div>
        </div>
    </div>
</div>
</section>
<script>
    $(document).ready(function () {
	    var column = [
            { data: 'no', name: 'a.id' },
            { data: 'nik', name: 'a.nik' },
            { data: 'nama', name: 'a.namadepan' },
            { data: 'alamat', name: 'a.alamat' },
            { data: 'hp', name: 'a.hp' },
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
            }],
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['name'];
                });
            },
            "ajax": {
                url:'modul/penduduk/list_penduduk.php',
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
            var tab = '#tab2'
            
            var tabs = $('.tab-pane').removeClass('active')
            DetailAnggota(data.nik)
            
            $(tab).toggleClass('active')
        });
    });
</script>