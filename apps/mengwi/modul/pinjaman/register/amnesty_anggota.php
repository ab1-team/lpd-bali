<?php session_start();
include "../../../inc/inc.koneksi.php";
 
$id		=$_POST['cari'];

$row=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where pa.nia=a.id AND pa.id='$id' "));
?>

<script type="text/javascript">

$("#totalpokok").focus();

function tandaPemisahTitik(b){
				var _minus = false;
				if (b<0) _minus = true;
				b = b.toString();
				b=b.replace(".","");
				
				c = "";
				panjang = b.length;
				j = 0;
				for (i = panjang; i > 0; i--){
					 j = j + 1;
					 if (((j % 3) == 1) && (j != 1)){
					   c = b.substr(i-1,1) + "." + c;
					 } else {
					   c = b.substr(i-1,1) + c;
					 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}

			function numbersonly(ini, e){
				if (e.keyCode>=49){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
				}else if (e.keyCode==48){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){
					return true;
				} else if (e.keyCode==17){
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}

$(document).ready(function() {

$("#SimpanPenghapusanAnggota").click(function() {
				var loanid				= $('#loanid').val();
				var tglhapus			= $('#tglhapus').val();
				var totalpokok		= $('#totalpokok').val();
				var totaljasa		= $('#totaljasa').val();
				var catatanhapus		= $('#catatanhapus').val();
				var sumber_biaya		= $('#sumber_biaya').val();
					var pilih = confirm('Apakah yakin akan melakukan Penghapusan Pinjaman Anggota ini?');
					if (pilih==true) {
						$.ajax({
						
						type: "POST",
						url: "modul/pinjaman/proposal/simpan_penghapusan_anggota.php",
						data: 	"loanid="+loanid+
						"&tglhapus="+tglhapus+
						"&totalpokok="+totalpokok+
						"&totaljasa="+totaljasa+
						"&catatanhapus="+catatanhapus+
						"&sumber_biaya="+sumber_biaya,
							success: function(data) {
									$("#PenghapusanBerhasil").load('modul/pinjaman/proposal/sukses_hapus.php');
								}
						});
					}
			});
			
	});
			
		
        </script>

<div class="form-actions">
								<p class="text-justify fs-sm">
								Fitur ini dapat Anda gunakan jika Anda akan melakukan Penghapusan Pinjaman untuk <?php echo $row['namadepan'];?><br>
								Dengan klik tombol PROSES maka pinjaman ini akan berstatus H, dan akan membuat transaksi penghapusan sesuai dengan yang anda tuliskan pada form dibawah ini<br>
								</p>
									<input type="hidden"  value="<?php echo $id;?>" id="loanid" />
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Tanggal Transaksi Penghapusan</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" name="tglhapus" id="tglhapus" 
                                                autocomplete="off" placeholder="Tanggal">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Total Penghapusan Pokok</label>
                                            <input type="text" class="form-control"  name="totalpokok" id="totalpokok" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
                                                autocomplete="off" placeholder="Total Penghapusan Pokok">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Total Penghapusan Jasa</label>
                                            <input type="text" class="form-control"  name="totaljasa" id="totaljasa" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
                                                autocomplete="off" placeholder="Total Penghapusan Jasa">
                                    </div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sumber Biaya</label>
														<select id="sumber_biaya"  name="sumber_biaya"
															class="select2 form-control"
															tabindex="-1">
																<option value='1'>Alokasi Cadangan Resiko</option>
																<option value='2'>Biaya Penghapusan Pinjaman (Surplus Berjalan)</option>
														</select>
													</div>
									<div class="form-group mb-sm">
										<label class="fs-sm mb-0">Catatan</label>
                                            <textarea rows="4" class="form-control" name="catatanhapus" id="catatanhapus"
											autocomplete="off" placeholder="Tuliskan catatan/Alasan mengapa pinjaman ini dihapus, contoh : Meninggal Dunia, dan sebagainya."></textarea>
                                    </div>
									
									<div id="PenghapusanBerhasil"></div>
									<div class="form-group mb-lg">
										<a href="" class='btn btn-inverse btn-rounded pull-right' id="SimpanPenghapusanAnggota"><i class='fa fa-paper-plane'></i>  PROSES PENGHAPUSAN PINJAMAN INI</a>
										<a href="" class='btn btn-inverse'></a>
									</div>
							</div>