// <?php session_start();
// include "inc/inc.koneksi.php"; 

// $kd_kab =2;
// $tgl_now="2022-10-10";
// $lokasi=3;

// function saldoratarata($id) {	//Total Saldo Simpanan
// $lokasi=3;
// 			$table_transaksi	="transaksi_$lokasi";
// 			$tgl_kondisi   		= substr($id,0,10);
// 				$tgl_awal 		= date('Y-m-01', strtotime('-1 month', strtotime($tgl_kondisi)));
// 				$tgl_akhir 		= date('Y-m-t', strtotime('-1 month', strtotime($tgl_kondisi)));
// 				$tgll			= substr($tgl_akhir,8,2);
// 			$id_simp_i			= substr($id,11);	
// $real=mysql_fetch_array(mysql_query("SELECT * FROM `real_$lokasi` WHERE `loan_id` = '$id_simp_i' AND tgl_angsuran='$tgl_awal' AND kode='A' ORDER BY id DESC LIMIT 1"));
// 			if(!$real){
// 			   $real=mysql_fetch_array(mysql_query("SELECT * FROM `real_$lokasi` WHERE `loan_id` = '$id_simp_i' AND tgl_angsuran<'$tgl_awal' ORDER BY id DESC LIMIT 1"));
// 			}
// 			$saldo_lalu = $real['sumd']-$real['sumk'];
// 		$while=(mysql_query("SELECT * FROM `real_$lokasi` WHERE `loan_id` = '$id_simp_i' AND tgl_angsuran>='$tgl_awal' AND tgl_angsuran<='$tgl_akhir' ORDER BY id DESC"));
// 		while($r=mysql_fetch_array($while)){
// 			$tgl_angsuran=$r['tgl_angsuran'];
// 			$tgla		= substr($tgl_angsuran,8,2);
// 			$seltgl 	= $tgll-($tgla-1);
// 			$saldo 		= $r['debit']*$seltgl-($r['kredit']*$seltgl);
// 			$penambahan = $penambahan + $saldo;
// 				}
// 			$rata2=$saldo_lalu+($penambahan/$tgll);
// 			return $rata2;
// }























// $limit ="1"; //where table pinjaman_kelompok_,,, jika ga ada kondisi, ketik 1
// $kec=mysql_fetch_array(mysql_query("select * from kecamatan where id=$lokasi"));
								
// $sql    = mysql_query("select * from  tb_bantu_3 tb, anggota_$kd_kab a, simpanan_anggota_$kd_kab si WHERE si.id=tb.id_simp_i AND a.id=si.nia");
// while($row=mysql_fetch_array($sql)){
// echo $row['id'];
// echo "=";
// $idsimp = $row['id'];
// $saldosimpanan=$row['debit']-$row['kredit'];
// $bungasimpananumum=0;
// $pajaksimpananumum=0;
// 								$saldoratarata	=$row['rerata'];
// 								if($kec['min_bunga']<=$saldosimpanan){
// 								$bungasimpananumum	= $saldoratarata*$row['bunga']/100;
// 								}
// 								if($kec['min_pajak']<=$saldosimpanan){
// 								$pajaksimpananumum	= $bungasimpananumum*$row['pajak']/100;
// 								}
								
// 								mysql_query("select * from  tb_bantu_$lokasi tb, simpanan_anggota_$kd_kab si WHERE si.id=tb.id_simp_i");
// 								if($bungasimpananumum>0){
// 								mysql_query("INSERT INTO `transaksi_$lokasi` (`idt`, `tgl_transaksi`, `rekening_debit`, `rekening_kredit`, `idtp`, `id_pinj`, `id_pinj_i`, `id_simp_i`, `keterangan_transaksi`, `jumlah`, `urutan`, `id_user`) VALUES 
// 								(NULL, '2022-09-30', '515.01', '221.02', '0', '0', '0', '$idsimp', 'Bunga SU $row[nomor_rekening] $row[namadepan] September', '$bungasimpananumum', '0', '253')");
																
// echo " [b] ";
								    
// 								}
// 								if($pajaksimpananumum>0){
// 								mysql_query("INSERT INTO `transaksi_$lokasi` (`idt`, `tgl_transaksi`, `rekening_debit`, `rekening_kredit`, `idtp`, `id_pinj`, `id_pinj_i`, `id_simp_i`, `keterangan_transaksi`, `jumlah`, `urutan`, `id_user`) VALUES 
// 								(NULL, '2022-09-30', '221.05', '231.01', '0', '0', '0', '$idsimp', 'Pajak SU $row[nomor_rekening] $row[namadepan] September', '$pajaksimpananumum', '0', '253')");
														
// echo " [p] ";
								    
// 								}
								
								
								
// echo "<br>";
// }
?>