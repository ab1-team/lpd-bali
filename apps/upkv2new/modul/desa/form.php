<?php session_start(); ?> 
 
        <script type="text/javascript">
			$(document).ready(function() {
	
				$("#TampilData").load('modul/desa/tampil.php');
                $("#FormSubmit").click(function() {
                    var id_desa = $('#id_desa').val();
                    var kd_desa = $('#kd_desa').val();
                    var nama_desa = $('#nama_desa').val();
                    var alamat_desa = $('#alamat_desa').val();
                    var telp_desa = $('#telp_desa').val();
                    var sebutan = $('#sebutan').val();
                    var kades = $('#kades').val();
                    var pangkat = $('#pangkat').val();
                    var nip = $('#nip').val();
                    var no_kades = $('#no_kades').val();
                    var sekdes = $('#sekdes').val();
                    var no_sekdes = $('#no_sekdes').val();
                    var ked = $('#ked').val();
                    var no_ked = $('#no_ked').val();
                    var deskripsi_desa = $('#deskripsi_desa').val();
					var jadwal_angsuran_desa = $('#jadwal_angsuran_desa').val();
                    var uname = $('#uname').val();
                    var pass = $('#pass').val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/desa/simpan.php",
                        data: "id_desa="+id_desa+
								"&kd_desa="+kd_desa+
								"&nama_desa="+nama_desa+
								"&alamat_desa="+alamat_desa+
								"&telp_desa="+telp_desa+
								"&sebutan="+sebutan+
								"&kades="+kades+
								"&pangkat="+pangkat+
								"&nip="+nip+
								"&no_kades="+no_kades+
								"&sekdes="+sekdes+
								"&no_sekdes="+no_sekdes+
								"&ked="+ked+
								"&no_ked="+no_ked+
								"&deskripsi_desa="+deskripsi_desa+
								"&jadwal_angsuran_desa="+jadwal_angsuran_desa+
								"&uname="+uname+
								"&pass="+pass,
                        success: function(data) {
                            $("#TampilData").load('modul/desa/tampil.php');
							$("#Sukses").load('modul/desa/sukses.php');

                        }
                    });

                });
				
            });
        </script>       
		
		<div class="row">
			<div class="col-md-7">
				<section class="widget">
							<header>
								<legend><i class="fa fa-th-list"></i> Daftar Desa</legend>
								<div class="widget-controls">
									<a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
									<a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
									<a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
								</div>
							</header>
					<div id="TampilData"></div>
				</section>
			</div>
            <div class="col-md-5 col-md-offset">
                <section class="widget">
                    <header>
                        <legend><i class="fa fa-cog"></i> Detail Desa</legend>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">ID Desa</label>
                                        <div class="col-sm-8"><input type="text" name="id_desa" id="id_desa" maxlength="2" class="form-control" disabled="disabled"
										required="required" autocomplete="off" placeholder="Kode Desa"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Kode Desa</label>
                                        <div class="col-sm-8"><input type="text" name="kd_desa" id="kd_desa" maxlength="2" class="form-control" disabled="disabled"
										required="required" autocomplete="off" placeholder="Kode Desa"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Nama Desa</label>
                                        <div class="col-sm-8"><input type="text" name="nama_desa" id="nama_desa" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Desa"> </div>
                                    </div>
									
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Alamat Desa</label>
                                        <div class="col-sm-8"><input type="text" name="alamat_desa" id="alamat_desa" class="form-control" 
										required="required" autocomplete="off" placeholder="Alamat Desa"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Telepon Desa</label>
                                        <div class="col-sm-8"><input type="text" name="telp_desa" id="telp_desa" class="form-control" 
										required="required" autocomplete="off" placeholder="Telepon Desa"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Sebutan</label>
										<div class="col-sm-8">
                                        <?php
										echo "
										<select id='sebutan'  name='sebutan'
												class='select form-control'
												tabindex='-1'> ";
														$data=mysql_query('select * from sebutan_desa'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[sebutan_desa] ($row[sebutan_kades])</option>";
															}
												echo "
											</select>
										";
										?>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Kades</label>
                                      <div class="col-sm-8"><input type="text" name="kades" id="kades" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Kades">
										<input type="text" name="pangkat" id="pangkat" class="form-control" 
										required="required" autocomplete="off" placeholder="Pangkat/Golongan Kades" />
                                         <input type="text" name="nip" id="nip" class="form-control" 
										required="required" autocomplete="off" placeholder="NIP Kades" />
										<input type="text" name="no_kades" id="no_kades" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor HP/WA Kades">
                                      </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Sekdes</label>
                                        <div class="col-sm-8"><input type="text" name="sekdes" id="sekdes" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Sekdes">
										<input type="text" name="no_sekdes" id="no_sekdes" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor HP/WA Sekdes">
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama KED/LPMD</label>
                                        <div class="col-sm-8"><input type="text" name="ked" id="ked" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Kader Ekonomi Desa">
										<input type="text" name="no_ked" id="no_ked" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor HP/WA KED">
										</div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="deskripsi_desa">Deskripsi Desa</label>
										<div class="col-sm-8">
											<textarea rows="4" class="autogrow form-control transition-height" name="deskripsi_desa" id="deskripsi_desa"></textarea>
										</div>
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Jadwal Angsuran Desa</label>
                                        <div class="col-sm-8">
										<?php
										echo "
										<select id='jadwal_angsuran_desa'  name='jadwal_angsuran_desa'
												class='select form-control'
												tabindex='-1'>
												<option value=''>Sesuai Tanggal Cair</option>";
                        							for($tg=1;$tg<=31;$tg++) 
                        							{
                        								$tanggal0 = sprintf("%02d",$tg);
                        							echo "<option value=$tanggal0>Setiap Tanggal $tanggal0</option>";
                        							}
                        							echo "</select>";
                        										?>
										 </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="control-label col-sm-4">Username</label>
                                        <div class="col-sm-8"><input type="text" name="uname" id="uname" class="form-control"
										required="required" autocomplete="off" placeholder="Username Desa"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password</label>
                                        <div class="col-sm-8"><input type="text" name="pass" id="pass" class="form-control"
										required="required" autocomplete="off" placeholder="Password Desa"> </div>
                                    </div>

									<div id="Sukses"></div>
                            </fieldset>
                           
                            <div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="FormSubmit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                <button type="button" class="btn btn-default btn-rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
	
</div>