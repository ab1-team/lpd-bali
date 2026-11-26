<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		
$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];

$tahun_anggaran		=$_GET['y'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));


		//Logo
		$this->Image('../../../images/logo_lpd.gif',21,8,12,0);
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetX(33);
		$this->Cell(85,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(105);
		$this->Cell(95,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'E-BUDGETING',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'TAHUN ANGGARAN '.$tahun_anggaran,0,0,'C');
		
		
//Fields Name position
$Y_Fields_Name_position = 37;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',9);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(120,8,'Nama Rekening',1,0,'C',1);
$this->SetX(140);
$this->Cell(55,8,'Rencana Anggaran',1,0,'C',1);
$this->Ln(8);


		

	}
	
	//Page Content
	function Content()
	{
		
$this->Rect(20,51,120,56);
$this->Rect(140,51,55,56);

$this->Rect(20,113,120,101);
$this->Rect(140,113,55,95);

//PENDAPATAN
$this->SetFont('Arial','B',9);
$this->SetX(20);
$this->Cell(175,6,'4-00000. RENCANA PENDAPATAN',1,0,'L');
$this->Ln(6);

$tahun_anggaran		=$_GET['y'];
$view=mysql_query("select * from jenis_akun WHERE posisi='4' ORDER by id ASC ");
	while($row=mysql_fetch_array($view)){
														
	$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");												

$this->SetFont('Arial','B',9);														
$this->SetX(20);
$this->Cell(120,5,'4-'.$row['id'].'0000. '.$row['nama_akun'],1,0,'L');
$this->SetX(140);
$this->Cell(55,5,'',1,0,'L');
$this->Ln(5);

	while($r=mysql_fetch_array($data)){
																	
	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
	$angkarencana=$s['ra'];

$this->SetFont('Arial','',9);	
$this->SetX(20);
$this->Cell(120,5,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L');
$this->SetX(140);
$this->Cell(55,5,number_format($angkarencana,2,',','.'),0,0,'R');
$this->Ln(5);

$sump=$sump+$angkarencana;

	}

	}

$this->SetFont('Arial','B',9);														
$this->SetX(20);
$this->Cell(120,6,'Total Rencana Pendapatan',1,0,'C');
$this->SetX(140);
$this->Cell(55,6,number_format($sump,2,',','.'),1,0,'R');
$this->Ln(6);


//BIAYA
$this->SetFont('Arial','B',9);
$this->SetX(20);
$this->Cell(175,6,'5-00000. RENCANA BIAYA',1,0,'L');
$this->Ln(6);

$tahun_anggaran		=$_GET['y'];
$view=mysql_query("select * from jenis_akun WHERE posisi='5' ORDER by id ASC ");
	while($row=mysql_fetch_array($view)){
														
	$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");												

$this->SetFont('Arial','B',9);														
$this->SetX(20);
$this->Cell(120,5,'5-'.$row['id'].'0000. '.$row['nama_akun'],1,0,'L');
$this->SetX(140);
$this->Cell(55,5,'',1,0,'L');
$this->Ln(5);

	while($r=mysql_fetch_array($data)){
																	
	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
	$angkarencana=$s['ra'];

$this->SetFont('Arial','',9);	
$this->SetX(20);
$this->Cell(120,5,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L');
$this->SetX(140);
$this->Cell(55,5,number_format($angkarencana,2,',','.'),0,0,'R');
$this->Ln(5);

$sumb=$sumb+$angkarencana;	

	}

	}

$this->SetFont('Arial','B',9);														
$this->SetX(20);
$this->Cell(120,6,'Total Rencana Biaya',1,0,'C');
$this->SetX(140);
$this->Cell(55,6,number_format($sumb,2,',','.'),1,0,'R');
$this->Ln(6);


$this->SetFont('Arial','B',9);														
$this->SetX(20);
$this->Cell(120,7,'RENCANA SURPLUS',1,0,'C');
$this->SetX(140);
$this->Cell(55,7,number_format($sump-$sumb,2,',','.'),1,0,'R');
$this->Ln(7);



//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',8);
	
	$this->Ln(5);
	$this->SetX(20);
	$this->Cell(60,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Dibuat oleh,',0,0,'C');

	$this->Ln(18);
	$this->SetFont('Arial','B',8);	
	$this->SetX(20);
	$this->Cell(60,6,strtoupper($u3['namadepan'].' '.$u3['namabelakang']),0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	
	$this->Ln(2.5);
	$this->SetFont('Arial','I',8);	
	$this->SetX(20);
	$this->Cell(60,6,'Badan Pengawas',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Kepala LPD',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
			
	
		
	}

	//Page footer
	function Footer()
	{
		$tahun_anggaran		=$_GET['y'];
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->Image('../../../images/logo_simlpd.png',114,276,12,0);
		$this->Cell(0,5,'Paraf : ............ | E-Budgeting '.$tahun_anggaran.', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$tahun_anggaran		=$_GET['y'];
//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('E-BUDGETING '.$tahun_anggaran);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
