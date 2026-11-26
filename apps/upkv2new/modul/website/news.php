<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
	
</script>
<?php
function cuplikArtikel($konten)
{
$maxhuruf=substr($konten,0,100);
$cuplikan="$maxhuruf....";
return $cuplikan;
}
?>
<section class="widget">
 <div class="widget-body">
	<legend>
		<h3><i class="fa fa-globe"></i> Manajemen Berita UPK
		<span class="pull-right"><a href="#tabnews3" class="btn btn-primary width-200" data-toggle="tab"><i class="fa fa-plus-circle"></i> Tambah Berita</a></span></h3>
	</legend>
	<div id="tabs1c" class="tab-content mb-lg">
		<div class="tab-pane active" id="tabnews1">
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
							<th class="hidden-xs">NO</th>
							<th class="hidden-xs">Tanggal</th>
							<th class="hidden-xs">Foto</th>
							<th class="hidden-xs">Judul</th>
							<th class="hidden-xs">Head Line News</th>
							<th class="hidden-xs">Kontributor</th>
							<th class="hidden-xs">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../inc/inc.koneksi.php";
						$view=mysql_query("select * from users u, news n WHERE u.id=n.penulis AND n.lokasi='$_SESSION[lokasi]' order by tanggal DESC");
						$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$stat=$row['status'];
								if ($stat=='P') { $status="Publish"; $warna="success"; }
								else if ($stat=='D') { $status="Draft"; $warna="danger"; }
								else if ($stat=='N') { $status="Un Publish"; $warna="warning"; }
								
						echo "
						<tr>
							<td class='subject hidden-xs' width='2%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'>$no</td>
							<td class='subject hidden-xs' width='15%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'>$row[tanggal]</td>
							<td class='subject hidden-xs' width='5%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'><img src='images/news/$row[foto]' width='50px'/></td>
							<td class='subject hidden-xs' width='20%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'>$row[judul]</td>
							<td class='subject hidden-xs' width='30%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'>".cuplikArtikel($row['berita'])."</td>
							<td class='subject hidden-xs' width='20%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'>$row[namadepan] $row[namabelakang]</td>
							<td class='subject hidden-xs' width='8%' href='#tabnews2' onclick='javascript:EditBerita(\"{$row[id]}\")' data-toggle='tab'><span class='badge bg-$warna'>$status</span></td>
                        </tr> ";
						 } ?>
                        </tbody>
                    </table>
            </div>
        </div>
		<div class="tab-pane" id="tabnews2">
			<div id="EditBerita"></div>
        </div>
		<div class="tab-pane" id="tabnews3">
			<?php include "news_add.php";?>
        </div>
    </div>
	</div>
</section>