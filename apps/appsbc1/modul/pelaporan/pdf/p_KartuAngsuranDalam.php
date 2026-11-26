<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../inc/fungsi_pinjaman_individu.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/kpdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
	
	}
	
	//Page Content
	function Content()
	{
		
		
		

$this->SetTextColor(0,0,0);		
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);

$this->SetFont('Arial','B',7);
$this->Ln(-5);
$this->SetX(5);
$this->Cell(90,5,'TABEL REALISASI ANGSURAN (HAL-1)',0,0,'L',0);
$this->Ln();
$this->SetX(5);
$this->Cell(6,8,'Ke',1,0,'C',1);
$this->SetX(11);
$this->Cell(14,8,'Tanggal',1,0,'C',1);
$this->SetX(25);
$this->Cell(30,4,'Pokok',1,0,'C',1);
$this->SetX(55);
$this->Cell(30,4,'Jasa',1,0,'C',1);
$this->SetX(85);
$this->Cell(15,8,'Saldo',1,0,'C',1);

$this->Ln(-5);
$this->SetX(110);
$this->Cell(95,5,'TABEL REALISASI ANGSURAN (HAL-2)',0,0,'L',0);
$this->Ln();
$this->SetX(110);
$this->Cell(6,8,'Ke',1,0,'C',1);
$this->SetX(116);
$this->Cell(14,8,'Tanggal',1,0,'C',1);
$this->SetX(130);
$this->Cell(30,4,'Pokok',1,0,'C',1);
$this->SetX(160);
$this->Cell(30,4,'Jasa',1,0,'C',1);
$this->SetX(190);
$this->Cell(15,8,'Saldo',1,0,'C',1);

$this->Ln(4);
$this->SetX(25);
$this->Cell(15,4,'Realisasi',1,0,'C',1);
$this->SetX(40);
$this->Cell(15,4,'Nunggak',1,0,'C',1);
$this->SetX(55);
$this->Cell(15,4,'Realisasi',1,0,'C',1);
$this->SetX(70);
$this->Cell(15,4,'Nunggak',1,0,'C',1);

$this->SetX(130);
$this->Cell(15,4,'Realisasi',1,0,'C',1);
$this->SetX(145);
$this->Cell(15,4,'Nunggak',1,0,'C',1);
$this->SetX(160);
$this->Cell(15,4,'Realisasi',1,0,'C',1);
$this->SetX(175);
$this->Cell(15,4,'Nunggak',1,0,'C',1);

$this->Ln();
$this->SetFont('Arial','',7);
$this->SetX(5);
$this->Cell(6,60,'',1,0,'C',0);
$this->SetX(11);
$this->Cell(14,60,'',1,0,'C',0);
$this->SetX(25);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(40);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(55);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(70);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(85);
$this->Cell(15,60,'',1,0,'C',0);

$this->SetFont('Arial','',7);
$this->SetX(110);
$this->Cell(6,60,'',1,0,'C',0);
$this->SetX(116);
$this->Cell(14,60,'',1,0,'C',0);
$this->SetX(130);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(145);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(160);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(175);
$this->Cell(15,60,'',1,0,'C',0);
$this->SetX(190);
$this->Cell(15,60,'',1,0,'C',0);


//$this->Rect(110,3.5,95,74.5);

	}

	//Page footer
	function Footer()
	{
		
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('KARTU ANGSURAN');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
