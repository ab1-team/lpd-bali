<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_simpanan_individu.php";
	
	$id_user		=$_SESSION['id'];
	$nomor_rekening	=$_POST['nomor_rekening'];
	
	$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia and pa.nomor_rekening='$nomor_rekening' AND pa.status='A' AND pa.lokasi='$_SESSION[lokasi]' ");
	$desa=mysql_fetch_array(mysql_query("select * from desa WHERE id='$_SESSION[lokasi]' "));
		
	$ketemu	=mysql_num_rows($data);
	
if ($ketemu > 0){
	  	$tr=mysql_fetch_array($data);
		
		$tgl_kondisi	=date('Y-m')."-31";
		$saldosimpanan	=saldosimpanan("$tgl_kondisi-$tr[id]");
		
			
	echo '
					
					
		<div class="card-body">
				<div class="card card-style mt-n5 ml-0 mr-0 bg-white">
                    <div class="row ml-2 mt-2">
                        <div class="col-4">
							Nama Kreditur<br>
							Alamat<br>
							HP<br>
							Saldo<br>
                        </div>
                        <div class="col-8">
							: <b>'.strtoupper($tr['namadepan']).'</b><br>
							: <b>'.$tr['alamat'].'</b><br>
							: <b>'.$tr['hp'].'</b><br>
							: <b>Rp. '.number_format($saldosimpanan,0,',','.').'</b><br>
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
					
					<div class="row ml-4">
						<div class="col-4">
							<div class="fac fac-radio fac-green"><span></span>
								<input id="setor" type="radio" name="rad" value="1">
								<label for="setor">Setor</label>
							</div>
						</div>
						<div class="col-8">
							<div class="fac fac-radio fac-red"><span></span>
								<input id="tarik" type="radio" name="rad" value="2">
								<label for="tarik">Tarik</label>
							</div>
						</div>
					</div>
                    
					
					<div class="input-style input-style-1 input-required ml-4 mt-n3 mr-4 mb-3">
						<span>Jumlah</span>
						<em>(Jumlah)</em>
						<input disabled type="tel" class="font-18" placeholder="Jumlah" id="jumlah"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);">
					</div>
					
					
					<input type="hidden" name="nia" id="nia" value="'.$tr['nia'].'"/>
					<input type="hidden" name="id_simp_i" id="id_simp_i" value="'.$tr['id'].'"/>
					<input type="hidden" name="saldo" id="saldo" value="'.$saldosimpanan.'"/>
					<input type="hidden" name="jenis_mutasi" id="jenis_mutasi" value="" >
					
					
				
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
			
			
			$('#setor').click(function () {
					//check if checkbox is checked
				if ($(this).is(':checked')) {
					$('#jumlah').removeAttr('disabled'); //enable input
					$('#jumlah').focus();
					$('#SimpanSimpananUmum').removeAttr('disabled'); //enable input
					$('#jenis_mutasi').val('setor');
					$('#JenisMutasi').html("SETOR TUNAI");
				}
			});
			
			$('#tarik').click(function () {
				if ($(this).is(':checked')) {
					$('#jumlah').removeAttr('disabled'); //enable input
					$('#jumlah').focus();
					$('#SimpanSimpananUmum').removeAttr('disabled'); //enable input
					$('#jenis_mutasi').val('tarik');
					$('#JenisMutasi').html("TARIK TUNAI");
				}
			});

</script>


	 