<?php 
session_start();

if (session_is_registered('id_upk') or session_is_registered('id') or session_is_registered('id_fk')  
or session_is_registered('id_pl') or session_is_registered('id_bp') or session_is_registered('id_bkad')
or session_is_registered('id_tv'))

{
include "../conn/conn.php";
include "../conn/fungsi_indotgl.php";
include "../conn/level_filter.php";
$username=ucfirst($_SESSION['username']);
//MEMBUAT BERBAGAI MACAM MODE LAPORAN
$user=$_GET['user'];
$desa=$_GET['kd_desa'];
$tg=$_GET['tg'];
$bl=$_GET['bl'];
$th=$_GET['th'];
		$hari_ini="$th-$bl-$tg";
		$awal_bln="$th-$bl-01";
		$akhir_bln="$th-$bl-31";
		$awal_thn="$th-01-01";
		$akhir_thn="$th-12-01";
		$thlalu=$th-1;
		
		//Tanggal terakhir dari bulan kemaren
		$bul = $bl-1;
		$lastday= "$th-$bul-31";
		
			if($tg=$tg){
				$tampil="Tanggal ".tgl_indo($hari_ini);
				$periode="$th-$bl-$tg";
				$jenislap="Harian (D)";
			}else if($bl=$bl and $th=$th){
				$tampil="Bulan ".tgl_indo("$th-$bl");
				$periode="$th-$bl-31";
				$jenislap="Bulanan (M)";
			}else if($th=$th){
				$tampil="Tahun $th";
				$periode="$th-12-31";
				$jenislap="Tahunan (Y)";
			}else{
				$tampil="Semua Transaksi";
				$periode="$th-$bl-$tg";
				$jenislap="All (A)";
			}
			
			if($desa=$desa and $desa!=$user) {
			$view = mysql_fetch_array(mysql_query("SELECT * FROM setup_desa where kd_desa=$desa"));
			$nama_keca=$view['nama_kec'];
			$fildesa="and kelompok.kd_desa='$desa'";
			$filuser="and kelompok.user='$user'";
			$filpinj="and pinjaman.user='$user'";
			$filkec="where nama_kec='$user'";
			$nama_desa="Desa ".$view['nama_desa']." Kecamatan $nama_keca";
			}else if($user=$user and $desa=$user){
			$fildesa="";
			$filuser="and kelompok.user='$user'";
			$filpinj="and pinjaman.user='$user'";
			$filkec="where nama_kec='$user'";
			$nama_desa="Kecamatan $user Kabupaten $nama_kab";
			}else{
			$fildesa="";
			$filuser="";
			$filpinj="";
			$filkec="";
			$nama_desa="Kabupaten $nama_kab Provinsi $provinsi";
			}

		
$mode=mysql_query("select * from data_pinjaman pinjaman where pinjaman.status=1 and pinjaman.tgl_cair<='$periode' $filpinj"); // query hitung jumlah transaksi
				$jml_trans=mysql_num_rows($mode);
				
			if ($jml_trans==0){
			$print_jml="Tidak ada Kelompok Aktif di $tampil";
			}else{
			$print_jml="$jml_trans Kelompok Aktif.";
			}

//File Mode : SPP - UEP
$kdp=$_GET['kdp'];
		if($kdp=='1'){
			$file="SPP";
			$tbl='kas_spp'; 
			$warna="#0050EF"; 
		}else if ($kdp=='2'){
			$file="UEP";
			$tbl='kas_uep';
			$warna="#6A00FF";
		}
?>

<?php
function pembulatan($uang)
{
 $ratusan = substr($uang, -3);
 if($ratusan<500)
 $akhir = $uang + (500-$ratusan);
 else
 $akhir = $uang + (1000-$ratusan);
 echo number_format($akhir, 2, ',', '.');
}
?>

<head>
<title>Cetak Kolek <?php echo $file; ?> Kelompok <?php echo $user; ?></title>
</head>



<body onLoad="window.print()">

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 20px;  }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.all	{border: 2px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px;}
-->
</style>

<!--  start page-heading -->
<div id="page-heading">
    <table width="100%">
    <tr>
      <td align="center" colspan="11"><span class="style3"><b>Kolektibilitas <?php echo $file; ?> Rekap Kelompok</b><br>
<?php echo $nama_desa; ?><br>
<?php echo $tampil; ?></span></td>
    </tr>
    <tr>
		<td align="left" valign="bottom" class="style26" colspan="6">Form 59 A : <?php echo $print_jml; ?></td>
		<td align="right" valign="bottom" class="style26" colspan="5">Jenis Laporan : <?php echo $jenislap; ?></td>
	</tr>
	</table>
</div>
<!-- end page-heading -->

      	<!--  start product-table ..................................................................................... -->
        <form id="mainform" action="">
          <table width="100%" height="107" border="0"  cellpadding="3" cellspacing="0" class="style9 all">
            <tr align="center" height="40px">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="10%">DESA</th>
              <th class="left bottom" width="10%">KELOMPOK</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="4%">&Sigma;</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Tunggakan 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Tunggakan 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Tunggakan 5-6</th>
              <th class="left bottom" width="10%">KOLEK V <br>Tunggakan &gt; 6</th>
            </tr>
			<tr align="center" style="background:rgba(0,0,0, 0.3);" height="20px">
              <td class="left bottom">1</td>
              <td class="left bottom">2</td>
              <td class="left bottom">3</td>
              <td class="left bottom">4</td>
              <td class="left bottom">5</td>
              <td class="left bottom">6</td>
              <td class="left bottom">7</td>
              <td class="left bottom">8</td>
              <td class="left bottom">9</td>
              <td class="left bottom">10</td>
              <td class="left bottom">11</td>
            </tr>
            <?php
			//Query Utama untuk memunculkan ke tabel tampil
			$dataa=mysql_query("select * from setup_kec $filkec order by kd_kec asc");  	//Kecamatan
		$noo=0;
		while($keca=mysql_fetch_array($dataa)){
		$kd_kec=$keca['kd_kec'];
		$nama_kec=$keca['nama_kec'];
		?>
			<tr height="30"><td colspan="11" bgcolor="#6BA5E7" class="left bottom top"><span style="color:#fff;"><?php echo $noo=$noo+1;?>. <?php echo strtoupper($keca['nama_kec']);?></span></td></tr>
		<?php
		$view=mysql_query("select * from setup_kelompok kelompok, data_pinjaman pinjaman
		where kelompok.id=pinjaman.id_kel $filuser and kelompok.user='$nama_kec' and kelompok.jenis_pinjaman=$kdp 
		 $fildesa and pinjaman.tgl_cair<='$periode' order by kd_desa asc");  	
		$no=0;
		while($row=mysql_fetch_array($view)){
		
		$kd_desa=$row['kd_desa'];
		$alokasi=$row['alokasi'];
		$tempo=$row['tempo'];
		$pros_jasa=number_format($row['pros_jasa']/$row['jangka'],2);
		$anspok = floor($alokasi/$tempo);
		$kd_kelompok=$row['kd_kelompok'];
		$idk=$row['id_kel'];
		$idp=$row['id'];
		$jasa=$alokasi*($pros_jasa/100);
		
		//Pembulatan Ansuran POKOK
		$ratusan = substr($anspok, -3);
		if($ratusan<500 and $ratusan>0)
		$pokok = $anspok + (500-$ratusan);
		else if($ratusan>500)
		$pokok = $anspok + (1000-$ratusan);
		else if($ratusan==0)
		$pokok = $anspok;
		    
	
		//Query untuk menghitung jumlah pengembalian sampai bulan lalu	
		$lalu=mysql_fetch_array(mysql_query("SELECT SUM(pokok) as lalu_pokok, SUM(jasa) as lalu_jasa from $tbl 
		WHERE id_kelompok='$idk' and id_pinjaman='$idp' and tgl_transaksi <= '$lastday' and rekening=1"));
		$lalu_pokok=$lalu['lalu_pokok'];
		$lalu_jasa=$lalu['lalu_jasa'];
					
		//Query untuk menghitung realisasi pengembalian bulan ini
		$ini=mysql_fetch_array(mysql_query("SELECT SUM(pokok) as now_pokok, SUM(jasa) as now_jasa from $tbl 
		WHERE id_kelompok='$idk' and id_pinjaman='$idp' and tgl_transaksi BETWEEN '$awal_bln' and '$akhir_bln' and rekening=1"));
					$now_pokok=$ini['now_pokok'];
					$now_jasa=$ini['now_jasa'];					
					
					
		//Query untuk menghitung jumlah total pengembalian
		$kom=mysql_fetch_array(mysql_query("SELECT SUM(pokok) as sum_pokok, SUM(jasa) as sum_jasa, sum(masuk_lain) as sum_lain from 
		$tbl kas, data_pinjaman pinjaman WHERE pinjaman.id=kas.id_pinjaman and kas.id_kelompok='$idk' and kas.id_pinjaman='$idp' 
		and rekening=1 and tgl_transaksi <= '$akhir_bln' and kas.user='$nama_kec'"));
		$kom_pokok=$kom['sum_pokok'];
		$kom_jasa=$kom['sum_jasa'];
		$kom_lain=$kom['sum_lain'];

//=====================ANSURAN KE===================================================================================================		
		//Menghitung sekarang ansuran ke berapa (selisih bulan tgl pencairan dengan bulan ini)
			$tgl_cair = $row['tgl_cair'];
			$tgl_now = $periode;
			$bulan1=substr($tgl_cair,5,2);
			$bulan2=substr($tgl_now,5,2);
			$tahun1=substr($tgl_cair,0,4);
			$tahun2=substr($tgl_now,0,4);
			$selisih_bulan_ini=12-$bulan1; //mencari selisih bulan pada tahun ini
			$selisih_bulan=$bulan2-$bulan1;
			$selisih_tahun=$tahun2-$tahun1;
			
			if ($selisih_tahun == '1'){
				$ansuranke1=$selisih_bulan_ini+$bulan2;
				}else if ($selisih_tahun>='2'){
					$ansuranke1=$selisih_bulan_ini+$bulan2+($selisih_tahun*12);
				}else if ($selisih_tahun=='0'){
					$ansuranke1=$selisih_bulan;
				}
		//Jika dilunasi ditengah maka ansuran ke adalah.....		
		$max_tgl=mysql_fetch_array(mysql_query("select max(tgl_transaksi) as max_trans from $tbl WHERE id_kelompok='$idk' and id_pinjaman='$idp' and rekening=1 and pokok!=0"));
		$max_trans=$max_tgl['max_trans'];
			$tgl_now = $periode;
			$bln_cair=substr($tgl_cair,5,2);
			$bln_trans=substr($max_trans,5,2);
			$tahun_cair=substr($tgl_cair,0,4);
			$tahun_trans=substr($max_trans,0,4);
			$selisih_bln_ini=12-$bln_cair; //mencari selisih bulan pada tahun ini
			$selisih_bln=$bln_trans-$bln_cair;
			$selisih_thn=$tahun_trans-$tahun_cair;
			if ($selisih_thn == '1'){
				$ansuranke2=$selisih_bulan_ini+$bulan2;
				}else if ($selisih_thn=='2'){
					$ansuranke2=$selisih_bulan_ini+$bulan2+12;
				}else if ($selisih_thn=='3'){
					$ansuranke2=$selisih_bulan_ini+$bulan2+24;
				}else if ($selisih_thn=='4'){
					$ansuranke2=$selisih_bulan_ini+$bulan2+36;
				}else if ($selisih_thn=='5'){
					$ansuranke2=$selisih_bulan_ini+$bulan2+48;
				}else if ($selisih_thn=='6'){
					$ansuranke2=$selisih_bulan_ini+$bulan2+60;
				}else if ($selisih_thn=='0'){
					$ansuranke2=$selisih_bln;
				}
//=====================END ANSURAN KE=================================================================================================
		
		$saldo=$alokasi-$kom_pokok;
		//Jika saldo = 0 (lunas) maka ansuranke = tgl_max
		if ($saldo=='0'){ 
		$ansuranke=$ansuranke2;
		}else{
		$ansuranke=$ansuranke1;
		}
		
		//jika ansuranke lebih dari atau sama-dengan tempo, maka ansuran = tempo	
		if ($ansuranke<=$tempo){
		$ansuranke=$ansuranke;
		}else{
		$ansuranke=$tempo;
		}
		
		//Target pokok = pokok*Ansuran ke, selama ansuran ke <=	tempo-1
		if ($ansuranke<=$tempo-1){ 
		$target_pokok=$pokok*$ansuranke; //target pengembalian pinjaman s.d. bulan ini
		}else{
		$target_pokok=$alokasi;
		}

		$target_jasa=$jasa*$ansuranke;


		
		$tunggak_pokok=$target_pokok-$kom_pokok; //Tunggakan pinjaman s.d. bulan ini
		if ($tunggak_pokok<=0){ // Jika tunggakan bernilai minus, maka ditulis NOL
		$nunggak_pokok=0;
		} else if ($tunggak_pokok>0) {
		$nunggak_pokok=$tunggak_pokok;
		}
		
		$tunggak_jasa=$target_jasa-$kom_jasa;
		if ($tunggak_jasa<=0){ // Jika tunggakan bernilai minus, maka ditulis NOL
		$nunggak_jasa=0;
		} else if ($tunggak_jasa>0) {
		$nunggak_jasa=$tunggak_jasa;
		}
		
		$jum_nunggak=$nunggak_pokok/$pokok;
		
			$tot_nunggak_pokok=$tot_nunggak_pokok+$nunggak_pokok;
			$tot_nunggak_jasa=$tot_nunggak_jasa+$nunggak_jasa;
		
		?>
		<!-- Menampilkan data pada tabel -->
           <tr height="15px">
              <td class="left bottom"><div align="center"><?php echo $no=$no+1;?></div></td>
              <td class="left bottom"><?php $desa=mysql_query("select * from setup_desa where $kd_desa=kd_desa order by kd_desa asc"); //Query untuk konversi Kode Desa menjadi Nama Desa
						  while($row5=mysql_fetch_array($desa)){
					echo $row5['nama_desa'];
					}
				?></td>
			  <td class="left bottom"><?php echo $row['nama_kelompok']; ?></td>
			  <td class="left bottom" align="right"><?php echo number_format($saldo);?></td>
			  <td class="left bottom" align="right"><?php echo number_format($nunggak_pokok);?></td>
			  <td class="left bottom" align="center"><?php echo number_format($jum_nunggak);?></td>
              <td class="left bottom" align="right"><?php 
								if ($jum_nunggak <=0){
									$kolek1=$saldo;
									}else {
									$kolek1=0;
									}
								echo number_format($kolek1);?></td> <!-- K1 -->
			  <td class="left bottom" align="right"><?php
								if ($jum_nunggak >0 and $jum_nunggak <=2){
									$kolek2=$saldo;
									}else {
									$kolek2=0;
									}
								echo number_format($kolek2);?></td><!-- K2 -->
			  <td class="left bottom" align="right"><?php
								if ($jum_nunggak >2 and $jum_nunggak <=4){
									$kolek3=$saldo;
									}else {
									$kolek3=0;
									}
								echo number_format($kolek3);?></td> <!-- K3 -->
              <td class="left bottom" align="right"><?php
								if ($jum_nunggak >4 and $jum_nunggak <=6){
									$kolek4=$saldo;
									}else {
									$kolek4=0;
									}
								echo number_format($kolek4);?></td> <!-- K4 -->
              <td class="left bottom" align="right"><?php
								if ($jum_nunggak >6){
									$kolek5=$saldo;
									}else {
									$kolek5=0;
									}
								echo number_format($kolek5);?></td> <!-- K5 -->
            </tr>
			<?php
			$tot_saldo=$tot_saldo+$saldo;
			$tot_kolek1=$tot_kolek1+$kolek1;
			$tot_kolek2=$tot_kolek2+$kolek2;
			$tot_kolek3=$tot_kolek3+$kolek3;
			$tot_kolek4=$tot_kolek4+$kolek4;
			$tot_kolek5=$tot_kolek5+$kolek5;
			
			$tot_kolek=$tot_kolek1+$tot_kolek2+$tot_kolek3+$tot_kolek4+$tot_kolek5;
			
			$cad_kolek1=$tot_kolek1*1/100;
			$cad_kolek2=$tot_kolek2*10/100;
			$cad_kolek3=$tot_kolek3*25/100;
			$cad_kolek4=$tot_kolek4*50/100;
			$cad_kolek5=$tot_kolek5*100/100;
			
			$cad_kolek=$cad_kolek1+$cad_kolek2+$cad_kolek3+$cad_kolek4+$cad_kolek5;

		}
		}
		?>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom" align="center">JUMLAH</th>
              <th class="left bottom" align="right"><?php echo number_format($tot_saldo);?></th>
              <th class="left bottom" align="right"><?php echo number_format($tot_nunggak_pokok);?></th>
              <th class="left bottom" align="right">&nbsp;</th>
              <th class="left bottom" align="right"><?php echo number_format($tot_kolek1);?></th>
              <th class="left bottom" align="right"><?php echo number_format($tot_kolek2);?></th>
              <th class="left bottom" align="right"><?php echo number_format($tot_kolek3);?></th>
              <th class="left bottom" align="right"><?php echo number_format($tot_kolek4);?></th>
              <th class="left bottom" align="right"><?php echo number_format($tot_kolek5);?></th>
            </tr>			
          </table>
        </form>
		<br><br><br>
		<table width="60%" height="192" border="0"  cellpadding="3" cellspacing="0" class="style9 all">
            <tr align="center" height="40px">
              <th width="2" class="left bottom">NO</th>
              <th width="20" class="left bottom">TINGKAT KOLEKTIBILITAS</th>
              <th width="63" class="left bottom">CADANGAN RESIKO PENGHAPUSAN</th>
              <th width="91" class="left bottom">JUMLAH PINJAMAN</th>
              <th width="86" class="left bottom">JUMLAH CADANGAN RESIKO</th>
			</tr>
			<tr align="center" height="15px" style="background:rgba(0,0,0, 0.4);">
              <td class="left bottom">1</td>
              <td class="left bottom">2</td>
              <td class="left bottom">3</td>
              <td class="left bottom">4</td>
              <td class="left bottom">5 = 3 * 4</td>
            </tr>
			<tr>
              <td class="left bottom" height="20px" align="center">1</td>
              <td class="left bottom">KOLEKTIBILITAS I</td>
              <td class="left bottom" align="center">1 %</td>
              <td class="left bottom" align="right"><?php echo number_format($tot_kolek1,0,'.',',');?></td>
              <td class="left bottom" align="right"><?php echo number_format($cad_kolek1,0,'.',',');?></td>
            </tr>
			<tr>
			<td class="left bottom" height="20px" align="center">2</td>
              <td class="left bottom">KOLEKTIBILITAS II</td>
              <td class="left bottom" align="center">10 %</td>
              <td class="left bottom" align="right"><?php echo number_format($tot_kolek2,0,'.',',');?></td>
              <td class="left bottom" align="right"><?php echo number_format($cad_kolek2,0,'.',',');?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">3</td>
              <td class="left bottom">KOLEKTIBILITAS III</td>
              <td class="left bottom" align="center">25 %</td>
              <td class="left bottom" align="right"><?php echo number_format($tot_kolek3,0,'.',',');?></td>
              <td class="left bottom" align="right"><?php echo number_format($cad_kolek3,0,'.',',');?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">4</td>
              <td class="left bottom">KOLEKTIBILITAS IV</td>
              <td class="left bottom" align="center">50 %</td>
              <td class="left bottom"  align="right"><?php echo number_format($tot_kolek4,0,'.',',');?></td>
              <td class="left bottom"  align="right"><?php echo number_format($cad_kolek4,0,'.',',');?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">5</td>
			  <td class="left bottom">KOLEKTIBILITAS V</td>
			  <td class="left bottom" align="center">100 %</td>
			  <td class="left bottom" align="right"><?php echo number_format($tot_kolek5,0,'.',',');?></td>
			  <td class="left bottom" align="right"><?php echo number_format($cad_kolek5,0,'.',',');?></td>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format($tot_kolek);?></th>
			  <th class="left bottom" align="right"><?php echo number_format($cad_kolek);?></th>
		  </tr>
		</table>

<?php 
}else{
	echo "Access Gagal Total!";
}
?>