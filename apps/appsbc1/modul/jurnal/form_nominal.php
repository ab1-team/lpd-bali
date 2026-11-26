<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$kd_rekening_1	= $_POST['rekening_1'];
$kd_rekening_2	= $_POST['rekening_2'];
$jenis_transaksi	= $_POST['jenis_transaksi'];
$_SESSION['kd_rekening'] = $_POST['rekening_2'];
$_SESSION['rekening_1'] = $_POST['rekening_1']; //Dikirim ke modul/jurnal/tampil_saldo.php

$rek1=mysql_fetch_array(mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$kd_rekening_1' "));
$rek2=mysql_fetch_array(mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$kd_rekening_2' "));

if($jenis_transaksi==1){		//Brangkas Masuk
	if(empty($kd_rekening_2)) {
	$keterangan_transaksi="$rek1[nama_rekening]";
	}else{
	$keterangan_transaksi="Dari $rek1[nama_rekening] ke $rek2[nama_rekening]";
	}
}else if($jenis_transaksi==2){	//Brangkas Keluar
	if(empty($kd_rekening_2)) {
	$keterangan_transaksi="$rek2[nama_rekening]";
	}else{
	$keterangan_transaksi="Bayar $rek2[nama_rekening] via $rek1[nama_rekening]";
	}
}else if($jenis_transaksi==3){	//Pemindahan Saldo/Aset
	if(empty($kd_rekening_2)) {
	$keterangan_transaksi="$rek1[nama_rekening]";
	}else{
	$keterangan_transaksi="Pemindahan $rek1[nama_rekening] ke $rek2[nama_rekening]";
	}
}
	
?>
<script type="text/javascript">
$("#nominal").focus();

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


        </script> 
							
							<?php
							if ($rek1['jenis_akun']=="piutang" AND $_SESSION['lokasi']<='2'){
								?>
								
							<div class="form-group">
							  <label class="col-sm-4 control-label">Pilih Invoice Piutang</label>
								<div class="col-sm-6">
									<select id="invoice_jual"  name="invoice_jual"
									class="form-control">
										<option value="">-- Pilih Invoice / Tagihan --</option>
										<?php 
											$view=mysql_query("select * from invoice WHERE lokasi='$_SESSION[lokasi]' AND status='UNPAID' ");
											while($row=mysql_fetch_array($view)){
												$noInvoice=noInvoice($row['id']);
												$sumSaldo=sumSaldo($row['id']);
												
												$cus=mysql_fetch_array(mysql_query("select * from customer WHERE id='$row[id_customer]' "));
												$pak=mysql_fetch_array(mysql_query("select * from paket WHERE id='$row[id_paket]' "));
												if($row['id_paket']==0){$nama_proyek="Penjualan Ritail";}else{$nama_proyek=$pak['nama_proyek'];}
												
												echo "<option value='$row[id]'>$noInvoice => $cus[nama_customer] => $nama_proyek => ".number_format($sumSaldo,0,',','.')."</option>";
										} ?>
									</select>
								</div>
							</div>
							
							<?php							
							}
							?>
							
							<?php
							if ($rek1['jenis_akun']=="piutang" AND $_SESSION['lokasi']=='3'){
								?>
								
							<div class="form-group">
							  <label class="col-sm-4 control-label">Pilih Invoice Piutang</label>
								<div class="col-sm-6">
									<select id="invoice_jual"  name="invoice_jual"
									class="form-control">
										<option value="">-- Pilih Invoice / Tagihan --</option>
										<?php 
											$view=mysql_query("select * from customer c, invoice_muatan i WHERE c.id=i.id_customer AND i.lokasi='$_SESSION[lokasi]' AND i.status='UNPAID' ");
											while($row=mysql_fetch_array($view)){
												$noInvoice=noInvoice($row['id']);
												$sumSaldo=sumSaldoMuatan($row['id']);
												echo "<option value='$row[id]'>$noInvoice => $row[nama_customer] => ".number_format($sumSaldo,0,',','.')."</option>";
										} ?>
									</select>
								</div>
							</div>
							
							<?php							
							}
							?>
							
							<?php
							if ($rek2['jenis_akun']=="hutang"){
								?>
								
							<div class="form-group">
							  <label class="col-sm-4 control-label">Pilih Invoice Hutang</label>
								<div class="col-sm-6">
									<select id="invoice_beli"  name="invoice_beli"
									class="form-control">
										<option value="">-- Pilih Invoice Hutang --</option>
										<?php 
											$view=mysql_query("select * from supplier s, invoice_beli i WHERE s.id=i.id_supplier AND i.lokasi='$_SESSION[lokasi]' AND i.status='UNPAID' ");
											while($row=mysql_fetch_array($view)){
												$noInvoice=$row['nomor_invoice'];
												$sumSaldoBeli=sumSaldoBeli($row['id']);
												echo "<option value='$row[id]'>#$noInvoice => $row[nama_supplier] => ".number_format($sumSaldoBeli,0,',','.')."</option>";
										} ?>
									</select>
								</div>
							</div>
							
							<?php							
							}
							?>
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Keterangan</label>
                                <div class="col-sm-8">
									<input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="form-control" value="<?php echo $keterangan_transaksi;?>"
									required="required" autocomplete="off" placeholder="-- Keterangan Transaksi --"> 
								</div>
                            </div>
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Nominal Rp.</label>
                                <div class="col-sm-8"><input type="text" name="nominal" id="nominal" class="form-control" 
									required="required" autocomplete="off" placeholder="-- Nominal Transaksi --" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"> </div>
                            </div>
							
							
