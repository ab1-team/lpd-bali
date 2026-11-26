<?php
include "../inc/inc.koneksi.php";

$id = 1;
switch ($_GET["type"]) {
	case 'tahun':
		$arr = array('-');
		$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id=".$id));
		$tgl_pakai		=$tp['tgl_pakai'];
		$th_pakai   	= substr($tgl_pakai,0,4);
		$th=date('Y');
		for($t=$th_pakai;$t<=$th;$t++) 
		{
			$arr[] = $t;
		}

		break;
	case 'bulan':
		$arr = array('-','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER');
		break;
	case 'hari':
		$arr = array('-');
		for($tg=1;$tg<=31;$tg++) 
		{
		if($tg<=9){$tg="0$tg";}else{$tg=$tg;}
			$arr[] = $tg;
		}
		break;
	case 'laporan':
		$arr = array('-');
		$lapData=mysql_query("select * from jenis_laporan ORDER BY urut"); //Jenis Laporan
		while($row=mysql_fetch_array($lapData))
		{
		$arr[]=$row['nama_laporan'];
		}
		break;
	case "sub":

		$arr = array();

		$lapData=mysql_query("select * from jenis_laporan where nama_laporan='".str_replace("-"," ",$_GET['laporan'])."'");
		$row=mysql_fetch_array($lapData);
		if (isset($row['file'])) {
			$jenis_laporan = $row['file'];
			
			if($jenis_laporan==3) {

			$view=mysql_query("select * from jenis_buku WHERE lokasi='0' OR lokasi=".$id." ORDER by kd_jb ASC ");
				$arr[] = "-- Pilih Sub Laporan SAK --";
				while($row=mysql_fetch_array($view)){
					$arr[] = "BB-".$row['kd_jb']." - ".$row['nama_jb'];
				}

			}else if($jenis_laporan==4) {
				
				$view=mysql_query("select * from jenis_buku WHERE lokasi='0' OR lokasi=".$id." ORDER by kd_jb ASC ");
					$arr[] = "-- Pilih Sub Laporan PTO --";
					while($row=mysql_fetch_array($view)){
						$arr[] = "BS-".$row['kd_jb']." - ".$row['nama_jb'];
					}
				
			}else if($jenis_laporan==5) {
				
				$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ");
					$arr[] = "-- Pilih Sub Laporan Pinjaman SPP --";
					while($row=mysql_fetch_array($view)){
						$arr[] = $row['file']."-1 - ".$row['nama_laporan']." (SPP)";
					}
				
			}else if($jenis_laporan==6) {
				
				$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ");
					$arr[] = "-- Pilih Sub Laporan Pinjaman UEP --";
					while($row=mysql_fetch_array($view)){
						$arr[] = $row['file']."-2 - ".$row['nama_laporan']." (UEP)";
					}
				
			}else if($jenis_laporan==7) {
				
				$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ");
					$arr[] = "-- Pilih Sub Laporan Pinjaman Lainnya --";
					while($row=mysql_fetch_array($view)){
						$arr[] = $row['file']."-3 - ".$row['nama_laporan']." (PL)";
					}
								
			}else if($jenis_laporan==9) {
				
				$view=mysql_query("select * from jenis_laporan_pinjaman WHERE file!='0' ");
					$arr[] = "-- Pilih Sub Laporan Pinjaman DKU--";
					while($row=mysql_fetch_array($view)){
						$arr[] = $row['file']."-4 - ".$row['nama_laporan']." (DKU)";
					}
				
			}else if($jenis_laporan==8) {
				
				$view=mysql_query("select * from jenis_buku WHERE id='10' or id='11' or id='12' ");
					$arr[] = "-- Pilih Sub Laporan Inventory --";
					while($row=mysql_fetch_array($view)){
						$arr[] = "IN-".$row['id']." - ".$row['nama_jb'];
					}
			} else {
				$arr[] = "-- Silahkan klik Tombol Format Pelaporan --";
			}

		} else {
			
			$arr[] = "-- Tidak ada Sub Laporan --";
		}

	break;
	default:

	break;
}

die(json_encode($arr));

?>