<?php session_start(); 
include "modul/kelompok/form_registrasi.php";
?>
<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	//$("#DetailKelompok").load('modul/kelompok/detail.php');
	
	function deleteRow(ID) {
		var id	= ID;
	   var pilih = confirm('Anda akan hapus data '+id+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/kelompok/hapus.php",
				data	: "id="+id,
				success	: function(data){
					alert('Berhasil!');
				}
			});
		}
	}
	
	function DetailKelompok(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/kelompok/detail.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tabk22').html(data);
				
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
		<h3><i class="fa fa-users"></i> Data Base Kelompok 
		<span class="pull-right"><a href="modul/kelompok/rekap.php" target="_blank"  class="btn btn-success "><i class="glyphicon glyphicon-print"></i> Cetak </a> <button data-toggle="modal" data-target="#FormInputKelompok" class="btn btn-primary width-100"><i class="fa fa-plus-circle"></i> Tambah</button></span></h3>
		<!--MODAL REGISTRASI KELOMPOK ADA DI modul/kelompok/form_registrasi.php-->
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabk12">
			<div class="table-responsive">
                    <table id="ajax-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>KD.KELOMPOK</th>
                            <th class="hidden-xs">Nama Kelompok</th>
                            <th class="hidden-xs">Kegiatan</th>
                            <th class="hidden-xs">Alamat Domisili</th>
                            <th class="hidden-xs"><i class="fa fa-phone"></i> Telpon</th>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
					Keterangan:
					<table>
						<tr><th> Icon &nbsp; &nbsp;</th><th> &nbsp; &nbsp;  &nbsp; &nbsp;Nama </th><th>Keterangan</th></tr>
						<?php
						$view=mysql_query("select * from status_pinjaman");
								while($row=mysql_fetch_array($view)){
							echo "
							<tr>
								<td><span class='toggle badge bg-$row[warna_status] pull-right'>$row[kd_status]</span></td><td>  &nbsp; &nbsp; $row[nama_status]  &nbsp; &nbsp;</td><td> $row[deskripsi]</td>
							<tr>
							";
								}
						?>
						
					</table>
            </div>
        </div>
		<div class="tab-pane" id="tabk22">
			<div id="DetailKelompok"></div>
        </div>
    </div>
	</div>
</section>

<script>
    $(document).ready(function () {
	    var column = [
            { data: 'no', name: 'k.id' },
            { data: 'id', name: 'k.id' },
            { data: 'kd_kelompok', name: 'k.kd_kelompok' },
            { data: 'nama_kelompok', name: 'k.nama_kelompok' },
            { data: 'jk', name: 'j.nama_jk' },
            { data: 'alamat', name: 'k.alamat_kelompok' },
            { data: 'hp', name: 'k.telpon' },
            { data: 'status', render: function(data, type, row) {
                var bg = row.bg;
                return "<span class='toggle badge bg-" + bg + " pull-right'>" + data + "</span>";
            } }
        ];
	
        var table = $('#ajax-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            columnDefs: [{
                targets: 7,
                orderable: false,
                searchable: false
            }],
            fnServerParams: function(data) {
                data['order'].forEach(function(items, index) {
                    data['order'][index]['column'] = data['columns'][items.column]['name'];
                });
            },
            "ajax": {
                url:'modul/kelompok/list_kelompok.php',
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
            var tab = '#tabk22'
            
            var tabs = $('.tab-pane').removeClass('active')
            DetailKelompok(data.id)
            
            $(tab).toggleClass('active')
        });
    });
</script>