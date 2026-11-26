<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		$table_rekening		="rekening_".$_SESSION['lokasi'];
		$lokasi				=$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

		
		//Logo
		//$this->Image('logo-ubl.jpg',10,8);
		//Arial bold 15
		$this->SetFont('Arial','',6);
		//judul
		$this->SetX(20);
		$this->Cell(0,0,$row['nama_lembaga_sort']. ' Kecamatan ' .$row['nama_kec'],0,0,'L');
		//pindah baris
		$this->Ln(3);
		$this->SetX(20);
		$this->Cell(0,0,$row['alamat_kec']. ' Telpon ' .$row['telpon_kec'],0,0,'L');
		$this->Ln(10);
		//buat garis horisontal
		$this->Line(20,15,195,15);
		$this->SetFont('Arial','B',10);
		//judul
		$this->Cell(0,0,'LAPORAN NERACA '.strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		$this->Ln(10);

	}
	
	//Page Content
	function Content()
	{

		
	$this->SetX(20);
	$this->Cell(175,8,'AKTIVA',1,0,'L',0);
	$this->Ln(8);

$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];
$idf				=substr($_POST['sub_report'],3);
$d					=$_POST['d'];
$m					=$_POST['m'];
$y					=$_POST['y'];
$tgl				="$y-$m-$d";
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

	$view=mysql_query("select * from rekening_riil WHERE posisi='1' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' AND lokasi='0' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
						
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(175,6,$row['nama_rr'],1,0,'L',0);
									$this->Ln(6);
									
									
							while($r=mysql_fetch_array($data)){
							$saldo_aktiva=saldo("$tgl_kondisi-".$r['kd_jb']);
							
									$this->SetFont('Arial','',8);
									$this->SetX(20);
									$this->Cell(120,6,$r['kd_jb'].'. '.$r['nama_jb'],1,0,'L',0);
									$this->SetX(140);
									$this->Cell(55,6,number_format($saldo_aktiva),1,0,'R',0);
									$this->Ln(6);
									
									$aktiva=$aktiva+$saldo_aktiva;
							
							}

						}
						
						
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(120,8,'TOTAL AKTIVA',1,0,'C',0);
									$this->SetX(140);
									$this->Cell(55,8,number_format($aktiva),1,0,'R',0);
									$this->Ln(8);
									
	//PASSIVA								
	$this->SetX(20);
	$this->Cell(175,6,'',0,0,'L',0);
	$this->Ln(6);

	$this->SetX(20);
	$this->Cell(175,8,'PASSIVA',1,0,'L',0);
	$this->Ln(8);	
	$view=mysql_query("select * from rekening_riil WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' AND lokasi='0' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' ORDER by kd_jb ASC ");
						
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(175,6,$row['nama_rr'],1,0,'L',0);
									$this->Ln(6);
									
									
							while($r=mysql_fetch_array($data)){
							$saldo_passiva=saldo("$tgl_kondisi-".$r['kd_jb'])*-1;
							
									$this->SetFont('Arial','',8);
									$this->SetX(20);
									$this->Cell(120,6,$r['kd_jb'].'. '.$r['nama_jb'],1,0,'L',0);
									$this->SetX(140);
									$this->Cell(55,6,number_format($saldo_passiva),1,0,'R',0);
									$this->Ln(6);
									
									$passiva=$passiva+$saldo_passiva;
							
							}

						}
						
									$this->SetFont('Arial','',8);
									$this->SetX(20);
									$this->Cell(120,6,'Surplus/Devisit/SHU Berjalan',1,0,'L',0);
									$this->SetX(140);
									$this->Cell(55,6,number_format(surplus($tgl_kondisi)),1,0,'R',0);
									$this->Ln(6);
									
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(120,8,'TOTAL PASSIVA',1,0,'C',0);
									$this->SetX(140);
									$this->Cell(55,8,number_format(surplus($tgl_kondisi)+$passiva),1,0,'R',0);
									$this->Ln(8);
	
	
//TANDA TANGAN
$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));
$ttd_pelapor	= $kec['ttd_pelapor'];
$ttd_bp			= $kec['ttd_bp'];

	 if($ttd_pelapor=="1") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' "); }
else if($ttd_pelapor=="2") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' "); }
else if($ttd_pelapor=="3") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='2' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' "); }
else if($ttd_pelapor=="4") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' "); }

	 if($ttd_bp=="1") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan='1' "); }
else if($ttd_bp=="2") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' "); }


$this->SetFont('Arial','B',8);


	
	$this->SetX(20);
	$this->Cell(195,6,'',0,0,'C');
	$this->Ln(6);
	
	
	$this->SetX(20);
	$this->Cell(100,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(120);
	$this->Cell(95,6,'Dilaporkan oleh,',0,0,'C');
	$this->Ln(4);
	$this->SetX(20);
	$this->Cell(100,6,'BP-UPK',0,0,'C');
	$this->SetX(120);
	$this->Cell(95,6,'Pengurus UPK',0,0,'C');
	$this->Ln(6);
			
			
			$noo=0;
			while($upk=mysql_fetch_array($data)){
				$jabatan	=$upk['jabatan'];
			if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			else if($jabatan=="2") {$nama_jabatan=$kec['sebutan_level_2'];}
			else if($jabatan=="3") {$nama_jabatan=$kec['sebutan_level_3'];}
			else  {$nama_jabatan=$upk['nama_jabatan'];}
			$noo=$noo+1;
	$this->SetX(120);	
	$this->Cell(95,8,$noo.'. '.$upk['namadepan'].' '.$upk['namabelakang'].' ('.$nama_jabatan.')',0,0,'L');
	$this->Ln(8);	
			}
			
			
			$no=0;
			while($bp=mysql_fetch_array($databp)){
			$no=$no+1;
	$this->SetX(20);		
	$this->Cell(100,8,$no.'. '.$bp['namadepan'].' '.$bp['namabelakang'].' ('.$bp['nama_jabatan'].')',0,0,'L');
	$this->Ln(8);
			}
	
		
	}

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'Dicetak oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A'),0,0,'L');
		$this->Cell(0,5,'Paraf ............... | Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Laporan Neraca');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
