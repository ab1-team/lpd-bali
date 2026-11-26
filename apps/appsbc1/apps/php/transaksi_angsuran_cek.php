<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_pinjaman_individu.php";
	
	$id_user		=$_SESSION['id'];
	$nomor_rekening	=$_POST['nomor_rekening'];
	
	$data=mysql_query("select * from anggota_1 a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia and pa.no_rekening='$nomor_rekening' AND pa.status='A' AND pa.lokasi='$_SESSION[lokasi]' ");
	$desa=mysql_fetch_array(mysql_query("select * from desa WHERE id='$_SESSION[lokasi]' "));
		
	$ketemu	=mysql_num_rows($data);
	
if ($ketemu > 0){
	  	$tr=mysql_fetch_array($data);
		
			$tgl_kondisi	=date('Y-m')."-31";
			$nunggakpokok	=nunggakpokok("$tgl_kondisi-$tr[id]"); //tunggakan menjadi tagihan pada form angsuran
			$nunggakjasa	=nunggakjasa("$tgl_kondisi-$tr[id]");
			$totalbayar		=$nunggakpokok+$nunggakjasa;
			$smpokok		=sumpokok("$tgl_kondisi-$tr[id]");
			if($smpokok=="") { $sumpokok="0"; }else{$sumpokok=$smpokok; }
			
	echo '
					
					
		<div class="card-body">
				<div class="card card-style mt-n5 ml-0 mr-0 bg-white">
                    <div class="row ml-2 mt-2">
                        <div class="col-4">
							Nama Debitur<br>
							HP/Alamat<br>
							Alokasi<br>
							Tanggal Cair<br>
                        </div>
                        <div class="col-8">
							: <b>'.strtoupper($tr['namadepan']).'</b><br>
							: <b>'.$tr['hp'].', '.$tr['alamat'].'</b><br>
							: <b>Rp. '.number_format($tr['alokasi'],0,',','.').'</b><br>
							: <b>'.$tr['tgl_cair'].', '.$tr['jangka'].'</b> Bulan<br>
						</div>
                    </div>
                </div>
           </div>
		   
		   <div class="card-body">
				<div class="card card-style mt-n5 ml-0 mr-0 bg-white">
                    <div class="input-style input-style-1 input-required ml-4 mt-1 mr-4">
						<span>Tanggal Transaksi</span>
						<em><i class="fa fa-angle-down"></i></em>
						<input type="date" value="'.date('Y-m-d').'" id="tgl_transaksi">
					</div>
					
					<div class="input-style input-style-1 input-required ml-4 mt-n3 mr-4">
						<span>Pokok</span>
						<em>(Pokok)</em>
						<input type="tel" class="font-18" placeholder="Pokok" id="pokok" value="'.number_format($nunggakpokok,0,',','.').'" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);">
					</div>
					
					<div class="input-style input-style-1 input-required ml-4 mt-n3 mr-4">
						<span>Bunga</span>
						<em>(Bunga)</em>
						<input type="tel" class="font-18" placeholder="Bunga" id="jasa" value="'.number_format($nunggakjasa,0,',','.').'" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);">
					</div>
					
					<div class="input-style input-style-1 input-required ml-4 mt-n3 mr-4 mb-3">
						<span>Denda</span>
						<em>(Denda)</em>
						<input type="tel" class="font-18" placeholder="Denda" id="denda" value="0" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);">
					</div>
					
					<input type="hidden" name="id_pinj" id="id_pinj" value="'.$tr['id'].'"/>
					<input type="hidden" name="tgl_pakai" id="tgl_pakai" value="'.$desa['tgl_pakai'].'"/>
					<input type="hidden" name="tgl_cair" id="tgl_cair" value="'.$tr['tgl_cair'].'"/>
					<input type="hidden" name="alokasi" id="tgl_cair" value="'.$tr['alokasi'].'"/>
					<input type="hidden" name="jumpokok" id="tgl_cair" value="'.$sumpokok.'"/>
				
                </div>
           </div>
		
		 
	';

}else{
	echo "<p class='text-center color-gray-dark'>DATA TIDAK DITEMUKAN</p>";
	
}
?>


<script type="text/javascript">
		
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
				if (e.keyCode>=48){
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
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){ //Dellete/Backspace
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){ //Tab
					return true;
				} else if (e.keyCode==17){ //Ctrl
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}

</script>


	 