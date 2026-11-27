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
		//Kotak
		$this->SetLineWidth(0.8);
		$this->Rect(20, 15, 175, 260);
		$this->Rect(104, 140, 2, 70);
		$this->Rect(109, 130, 2, 90);
		$this->Rect(114, 140, 2, 70);

	}
	
	//Page Content
	function Content()
	{
		
	
			
	$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";

	if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

		//Logo 
		$this->Image('../../../images/logo_bumdes.png',90,60,40,0);
		
		$this->Ln(45);
		$this->SetFont('Arial','B',16);
		$this->SetX(20);
		$this->Cell(0,100,'LAPORAN '.strtoupper($laporan),0,0,'C');
		$this->Ln(7);
		
		$this->SetFont('Arial','B',20);
		$this->SetX(20);
		$this->Cell(0,100,strtoupper($jenis.' '.tgl_indo($tgl)),0,0,'C');
		$this->Ln(50);


	
		
	}

	//Page footer
	function Footer()
	{
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

		//Arial bold 15
		
			
		$this->SetY(-45);
		$this->SetFont('Arial','',12);
		$this->SetX(20);
		$this->Cell(0,0,strtoupper(LEMBAGA_LONG),0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->SetX(20);
		$this->Cell(0,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'C');
		
		$this->Ln(4);
		$this->SetFont('Arial','I',7);
		$this->SetTextColor(0,0,0);
		$this->SetX(20);
		$this->Cell(0,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'C');
		$this->Ln(1);
		
		$this->SetX(20);
		$this->Cell(0,5,'Tahun '.date('Y'),0,0,'C');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Cover Laporan '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('1. Cover '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
