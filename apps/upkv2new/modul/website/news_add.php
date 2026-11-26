 <script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {

				$("#SubmitBerita").click(function() {
                    var foto = $('#foto').val();
						
                    $.ajax({
                        type: "POST",
                        data:"foto="+foto,
                        
						success: function(data) {
                           
                        }
                    });
                });
				
            });
			

        </script>

<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_thumb.php";
	

//UPLOAD FOTO

$table		="news";
$tanggal	=$_POST['tanggal'];
$judul		=$_POST['judul'];
$berita		=$_POST['berita'];
$status_b	=$_POST['status'];
$lokasi		=$_SESSION['lokasi'];
$penulis	=$_SESSION['id'];

$nama_file = $_FILES['foto']['name'];
$file_ext = substr($nama_file, strripos($nama_file, '.')); // strip name
$newfilename = $judul . $file_ext;
$status = FALSE;

	if(!empty($_FILES['foto']['tmp_name']) && ($file_ext == ".jpg" || $file_ext == ".png"))
	{
		$upload = move_uploaded_file($_FILES['foto']['tmp_name'], 'images/news/'.$newfilename);
		if($upload)
		{
			UploadImage_users($newfilename);
			$input = "INSERT INTO $table (id,tanggal,judul,foto,berita,lokasi,penulis,status)
				VALUES('','$tanggal','$judul','$newfilename','$berita','$lokasi','$penulis','$status_b')";
			mysql_query($input);
			header('location:m.php?p=news');

		}else{
		?>
		<script>
			alert('Tidak berhasil melakukan upload');
		</script>
		<?php
		}
	}
	
?>
		<div class="row">
			<div class="col-md-12">
						<header>
							<legend><i class="fa fa-camera"></i> Add News</legend>
						</header>
						<form method="post" enctype="multipart/form-data">
							<div class="col-sm-3">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height:200px;">
										<?php
										$foto=$row['foto'];
										if (empty($foto)) {
											echo "<img src='images/avatar.png' alt='...'>";
											}else{
											echo "<img alt='...' src='images/news/$foto'>";
											}
										?>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200;"></div>
										<div>
											<span class="btn btn-default btn-file"><span class="fileinput-new">Pilih Foto</span><span class="fileinput-exists">Change</span><input type="file" id="foto" name="foto"></span>
											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a><br>
										</div>
								</div>
							</div>
						
							
							<div class="col-sm-9">
							<div id="validation-form" class="form-horizontal form-label-left" method="post"
								  data-parsley-priority-enabled="false"
								  novalidate="novalidate">
								<fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Tanggal Berita</label>
                                        <div class="col-sm-10"><input type="text" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>"
										required="required" autocomplete="off" placeholder="Tanggal Berita"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-2">Judul</label>
                                        <div class="col-sm-10"><input type="text" name="judul" id="judul" class="form-control"
										required="required" autocomplete="off" placeholder="Judul Berita"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-2">Status</label>
										<div class="col-sm-10">
											<select id="status"  name="status"
												class='select form-control'
												tabindex='-1'>
												<option value="P">Publikasikan</option>
												<option value="D">Draft</option>
												<option value="N">Jangan Publikasikan</option>
											</select>
										</div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="wysiwyg">
											Isi Berita
											<span class="help-block">
												With bottom toolbar appended
											</span>
										</label>
										<div class="col-sm-10">
											<textarea rows="4" class="form-control" id="wysiwyg" name="berita"></textarea>
										</div>
									</div>
								</fieldset>
                           
								<div class="form-actions">
									<button class="btn btn-inverse btn-rounded pull-right" id="SubmitBerita"><i class="fa fa-floppy-o"></i> Simpan</button>
									<button href="#tabnews1" data-toggle="tab" type="button" class="btn btn-default btn-rounded">Kembali</button>
								</div>
							</div>
							</div>
						</form>
						
            </div>
        </div>