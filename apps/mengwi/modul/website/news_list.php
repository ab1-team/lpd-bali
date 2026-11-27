<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
	function DetailBerita(ID){
		var id = ID;
		$.ajax({
			type	: "POST",
			url		: "modul/website/news_detail.php",
			data	: "id="+id,			  
			success	: function(data){
				$('#tabnews2').html(data);
				
			}
		});
		
	}
	
</script>
<?php
function cuplikArtikel($konten)
{
$maxhuruf=substr($konten,0,250);
$cuplikan="$maxhuruf....";
return $cuplikan;
}
?>
<section class="widget">
 <div class="widget-body">
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabnews1">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
							<th class="hidden-xs">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from users u, news n WHERE u.id=n.penulis AND n.lokasi='$_SESSION[lokasi]' AND n.status='P' order by n.tanggal DESC");
								while($row=mysql_fetch_array($view)){ 
								
						echo "
						<tr>
							<td class='subject hidden-xs' width='75%' href='#tabnews2' onclick='javascript:DetailBerita(\"{$row[id]}\")' data-toggle='tab'>
							<img src='images/news/$row[foto]' class='col-xs-4'/>
							<span class='fw-semi-bold h3'>$row[judul]</span><br>
							<span class='text-muted fs-mini'><i class='fa fa-calendar'></i> $row[tanggal] <i class='ml-lg fa fa-user'></i> $row[namadepan] $row[namabelakang]</span><br>
							<span class='text-justify'>".cuplikArtikel($row['berita'])."</span><br>
							</td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
            </div>
        </div>
		<div class="tab-pane" id="tabnews2">
			<div id="DetailBerita"></div>
        </div>
    </div>
	</div>
</section>