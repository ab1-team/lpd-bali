<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/kpdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Kotak
		$this->SetLineWidth(0.3);
		$this->Rect(8,3.5,199,74.5);
		
		
		$lokasi=$_SESSION['lokasi'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		//Logo
		$this->Image('../../../images/logo_lpd.gif',15,5,12,0);
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetY(7);
		$this->SetX(27);
		$this->Cell(85,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(27);
		$this->Cell(85,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(27);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(105);
		$this->Cell(95,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(28,13,200,13);
			

	}
	
	//Page Content
	function Content()
	{
		
		
		$idt=$_GET['idt'];
		$lokasi=$_SESSION['lokasi'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, rekening_$_SESSION[lokasi] r, transaksi_$_SESSION[lokasi] t
							WHERE
							d.id='$_SESSION[lokasi]' AND r.kd_rekening=substring(t.rekening_debit,1,7) AND idt='$idt' OR
							d.id='$_SESSION[lokasi]' AND r.kd_rekening=substring(t.rekening_kredit,1,7) AND idt='$idt'"));
							

			$rekening_debit		=rek($row['rekening_debit']);
			$rekening_kredit	=rek($row['rekening_kredit']);
			$dari				="$rekening_debit ".namarek($rekening_debit)."";
			$ke					="$rekening_kredit ".namarek($rekening_kredit)."";
		
		
		

//Fields Name position
$Y_Fields_Name_position = 19;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);


//judul
		$this->SetFont('Arial','U',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'BUKTI TRANSFER/PEMINDAHAN ASET',0,0,'C');
		$this->Ln(4);
		$this->SetFont('Arial','',9);
		$this->Cell(0,0,'Nomor : '.$idt.'/BPA, Tanggal : '.tgl_ind($row['tgl_transaksi']),0,0,'C');
		$this->Ln(9);
		
//Garis Garis
		//$this->SetLineWidth(0.2);
		$this->Line(70,34,200,34);
		$this->Line(70,40,200,40);
		$this->Line(70,46,200,46);
		$this->Line(70,52,200,52);
		
		
$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(40,0,'Telah Ditrasfer Dari',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper($dari),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(40,0,'Uang Sebanyak',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper(toTerbilang($row['jumlah'])).' RUPIAH',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(40,0,'Ke Rekening',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper($ke),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(40,0,'Keterangan',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper($row['keterangan_transaksi']),0,0,'L');
		$this->Ln(3);

		



//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

	
$this->SetFont('Arial','',9);
	
	$this->SetX(70);
	$this->Cell(45,6,'Dibayarkan Oleh,',0,0,'C');
	$this->SetX(115);
	$this->Cell(45,6,'Diterima oleh,',0,0,'C');
	$this->SetX(160);
	$this->Cell(45,6,'Dibukukan oleh,',0,0,'C');
	$this->Ln(7);
	
	$this->SetFont('Arial','',12);		
	$this->SetX(28);
	$this->Cell(40,10,'Rp. '.number_format($row['jumlah'],0,',','.').',-',1,0,'C',1);
	$this->Ln(9);
	
	$this->SetFont('Arial','B',9);	
	$this->SetX(70);
	$this->Cell(45,6,strtoupper($dari),0,0,'C');
	$this->SetX(115);
	$this->Cell(45,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(160);
	$this->Cell(45,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	
	$this->Ln(3);
	$this->SetFont('Arial','I',9);	
	$this->SetX(70);
	$this->Cell(45,6,'',0,0,'C');
	$this->SetX(115);
	$this->Cell(45,6,'',0,0,'C');
	$this->SetX(160);
	$this->Cell(45,6,'Accounting',0,0,'C');
	$this->Ln(5);
		
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		
		$this->SetFont('Arial','I',6);
		//Footer
		$this->SetX(7);
		$this->Cell(0,5,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		
	}


	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('BUKTI KAS KELUAR');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
