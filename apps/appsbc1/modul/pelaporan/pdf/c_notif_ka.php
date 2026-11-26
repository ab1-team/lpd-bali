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

	//Page Content
	function Content()
	{

$idtp=$_GET['idtp'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] r, transaksi_$_SESSION[lokasi] t WHERE 
					r.kd_rekening=substring(t.rekening_kredit,1,7) AND t.idtp='$idtp'"));
					
$idp	=substr($row['rekening_kredit'],8);

$pokok	=pokok($idtp);
$jasa	=jasa($idtp);
$denda	=denda($idtp);

$bln_transaksi	=substr($row['tgl_transaksi'],0,7);
$tgl_kondisi	="$bln_transaksi-31";

$nunggakpokok	=nunggakpokok("$tgl_kondisi-$idp");
$nunggakjasa	=nunggakjasa("$tgl_kondisi-$idp");
$saldo			=saldopinjaman("$row[tgl_transaksi]-$idp");

//Jumlah Transaksi s.d. Record ini
$jtras=mysql_num_rows(mysql_query("SELECT * FROM transaksi_$_SESSION[lokasi] WHERE substring(rekening_kredit,9)='$idp' and tgl_transaksi<='$row[tgl_transaksi]' AND idtp<='$idtp' AND idtp!='0' GROUP BY idtp"));				
if($jtras>20) {$setx=105; $ke=$jtras-20;}else{$setx=0; $ke=$jtras;}

$this->SetTextColor(0,0,0);		
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
		
$this->SetFont('Arial','B',7);

$this->SetY(15);

$this->Ln(3*$ke);
$this->SetFont('Arial','',7);
$this->SetX(5+$setx);
$this->Cell(6,4,$jtras,0,0,'C',0);
$this->SetX(11+$setx);
$this->Cell(14,4,tgl_ind($row['tgl_transaksi']),0,0,'C',0);
$this->SetX(25+$setx);
$this->Cell(15,4,number_format($pokok,0,',','.'),0,0,'R',0);
$this->SetX(40+$setx);
$this->Cell(15,4,number_format($nunggakpokok,0,',','.'),0,0,'R',0);
$this->SetX(55+$setx);
$this->Cell(15,4,number_format($jasa,0,',','.'),0,0,'R',0);
$this->SetX(70+$setx);
$this->Cell(15,4,number_format($nunggakjasa,0,',','.'),0,0,'R',0);
$this->SetX(85+$setx);
$this->Cell(15,4,number_format($saldo,0,',','.'),0,0,'R',0);


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
