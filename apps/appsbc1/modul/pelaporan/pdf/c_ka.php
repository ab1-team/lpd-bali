<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/cpdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Kotak
		$this->SetLineWidth(0.3);
		$this->SetDrawColor(70,130,180); //warna D
		$this->SetFillColor(70,130,180); //Warna F
		$this->Rect(3,14,86,3,'F');
		$this->Rect(3,3,86,54,'D');
		$this->Rect(3,55,86,2,'F');
		
		//$this->Rect(89,3,86,54,'D');
		
		$this->SetFillColor(230,184,29); //Warna F
		$this->Rect(60,14,29,3,'F');
		
		
		
		


		
		$lokasi=$_SESSION['lokasi'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		//Logo
		$this->Image('../../../images/logo_bumdes.png',5,4.5,8.5,0);
		
		
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','B',14);
		$this->SetY(8.5);
		$this->SetX(14);
		$this->Cell(75,0,LEMBAGA_SORT.' CARD',0,0,'L');

			

	}
	
	//Page Content
	function Content()
	{
		
		
		$rcp=$_GET['rcp'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] WHERE nik=$rcp "));
		
		$id=$row['id'];
		if($id<9){$cif="000$id";}else if($id<99){$cif="00$id";}else if($id<999){$cif="0$id";}else{$cif="$id";}
		

//Fields Name position
$Y_Fields_Name_position = 40;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);

//FOTO
$this->SetDrawColor(128,128,128); //warna
$this->Rect(64,25,22,22,'D');

$foto="../../../foto_anggota/$row[id].png";
if(file_exists($foto)){
	$this->Image($foto,65,26,20,0);
}else{
	$this->Image('../../../img/avatar.png',65,26,20,0);
}

//QR-Code
	$qrcode="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$row[nik].png";
		
	$this->Image($qrcode,10,24,15,0);




$this->SetFont('Arial','',7);
$this->Ln(1);
$this->SetX(10);
$this->Cell(15,0,'CIF.'.$cif,0,0,'C');
$this->Ln(6);
//judul
		$this->SetFont('Arial','',12);
		$this->SetTextColor(0,0,0);
		$this->SetX(5);
		
		$this->Cell(55,0,substr($rcp,0,4).' '.substr($rcp,4,4).' '.substr($rcp,8,4).' '.substr($rcp,12,4),0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',8);
		$this->SetX(5);
		$this->Cell(55,0,strtoupper($row['namadepan']),0,0,'L');
		$this->Ln();
		
		$this->SetFillColor(0,0,0);
		//BARCODE
		$this->Code128(64,48,$rcp,22,4);
		
		


		

	}


	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('KARTU ANGGOTA');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
