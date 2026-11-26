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
		
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' ")); 
			$nama_kec	=$row ['nama_kec'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi		=$row ['visi_misi'];
			$nama_kab	=$row ['nama_kab'];
		
		//Logo 
											 $logo=$row['logo'];
											if (empty($logo)) {
												$this->Image('../../../images/upk.png',20,20,25,0);
											}else{
												$this->Image('../../../images/logo/'.$logo,30,20,25,0);
											}
											
											
											
		//buat garis horisontal
		$this->Line(20,15,195,15);
		$this->Line(20,16,195,16);
		
		$this->SetFont('Arial','B',12);
		$this->SetX(45);
		$this->Cell(0,30,strtoupper($row['nama_lembaga_long']),0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','',16);
		$this->SetX(45);
		$this->Cell(0,30,'KECAMATAN '.strtoupper($nama_kec),0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','B',12);
		$this->SetX(45);
		$this->Cell(0,30,'KABUPATEN '.strtoupper($nama_kab),0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','',8);
		$this->SetX(45);
		$this->Cell(0,30,'Alamat :'.$alamat_kec.' '.$nama_kec.' '.$nama_kab,0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(45);
		$this->Cell(0,30,'Telp. '.$telpon_kec,0,0,'C');
		$this->Ln(6);
		



	}
	
	//Page Content
	function Content()
	{

	$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' ")); 
			$visi		=$row ['visi_misi'];
			
	$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";

	if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

		
		$this->SetFont('Arial','B',16);
		$this->SetX(20);
		$this->Cell(0,100,'LAPORAN '.strtoupper($laporan),0,0,'C');
		$this->Ln(7);
		
		$this->SetFont('Arial','B',16);
		$this->SetX(20);
		$this->Cell(0,100,strtoupper($jenis.' '.tgl_indo($tgl)),0,0,'C');
		$this->Ln(50);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,100,$visi,0,0,'C');
		$this->Ln(6);


	
		
	}

	//Page footer
	function Footer()
	{
		
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' ")); 
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			
		$this->SetY(-30);
		//buat garis horizontal
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','',7);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,15,'www.'.$web_kec,0,0,'C');
		$this->Ln(3);
		
		$this->SetX(20);
		$this->Cell(0,15,'@'.date('Y'),0,0,'C');
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
