<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/spdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		//Kotak
		//$this->SetLineWidth(0.3);
		//$this->Rect(8, 7, 199, 148);
		
		$ids=$_GET['ids'];
		$lokasi=$_SESSION['lokasi'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
		$r=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa WHERE a.id=sa.nia AND sa.id='$ids'"));
		
		//Frame
		$this->Image('../../../images/frame2.jpg',4,3,203,160);
		//Logo
		$this->Image('../../../images/logo_lpd.png',17,18,12,0);
		
		$this->Ln(-4.5);
		$this->SetFillColor(255,255,255);		
		$this->SetFont('Arial','',12);
		$this->SetX(156.5);
		$this->Cell(40,8,$r['nomor_rekening'],0,0,'C',1);
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetY(20);
		$this->SetX(30);
		$this->Cell(85,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(30);
		$this->Cell(85,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(30);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(100);
		$this->Cell(95,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.3);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(31,26,194,26);
			

	}
	
	//Page Content
	function Content()
	{
		
		
		$ids=$_GET['ids'];
		$lokasi=$_SESSION['lokasi'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
		$r=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa WHERE a.id=sa.nia AND sa.id='$ids'"));
		$u=mysql_fetch_array(mysql_query("select * from users WHERE level='1' AND jabatan='1'"));
		
		$id_pinj    =$r['id'];
		$jangka     =$r['jangka'];
		$pros_jasa	=$r['pros_jasa'];
		$tgl_buka	=$r['tgl_buka'];
		$tanggal	= substr($tgl_buka,8,2);
		
		$tgl_lunas = date('Y-m-d', strtotime('+'.$jangka.' month', strtotime($tgl_buka)));
		
		

//Fields Name position
$Y_Fields_Name_position = 34;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(255,255,255);
$this->SetY($Y_Fields_Name_position);

//Membuat QR-Code
		$qr="../../../images/qrcode/$r[nik].png";
		$tempdir = "../../../images/qrcode/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
		if (!file_exists($qr)) { 
	
		$isi_teks = $r['nik'];
		$namafile = $r['nik'].".png";
		$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 3;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
		}
		
		$this->Image($qr,68,120,25,0);
		
	
//judul
		$this->SetFont('Arial','U',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'SERTIFIKAT DEPOSITO BERJANGKA',0,0,'C');
		$this->Ln(4);
		$this->SetFont('Arial','',9);
		$this->Cell(0,0,'Nomor : '.$ids.'/SB/LPD'.tgl_rom($tgl_buka),0,0,'C');
		$this->Ln(8);
		
//Garis Garis
		//$this->SetLineWidth(0.2);
		$this->Line(70,54,190,54);
		$this->Line(70,60,190,60);
		$this->Line(70,66,190,66);
		$this->Line(70,72,190,72);
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(120,0,'Telah diterima penyetoran Deposito Berjangka dari :',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(40,0,'Nama Kreditur',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper("$r[namadepan]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(40,0,'NIK / Nomor Anggota',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper("$r[nik] / $r[nomor_rekening]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(40,0,'Alamat',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,strtoupper("$r[alamat], $r[hp]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(40,0,'Uang Sejumlah',0,0,'L');
		$this->SetX(67);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(69);
		$this->Cell(60,0,'Rp. '.number_format($r['jumlah'],0,",",".").' ('.strtoupper(toTerbilang($r['jumlah'])).' RUPIAH)',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->MultiCell(161,4,'Untuk disimpan berjangka dalam waktu '.$r['jangka'].' bulan, mulai sejak tanggal '.tgl_indo($r['tgl_buka']).' sampai dengan tanggal '.tgl_indo($tgl_lunas).' dengan bunga '.$pros_jasa.'% per bulan dengan syarat-syarat yang telah ditetapkan oleh LPD '.$row['sebutan_desa'].' '.$row['nama_desa'].'.',0);
		$this->Ln(-2);


//Tanda Tangan
$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

	
	$this->SetFont('Arial','',9);
	$this->SetX(140);
	$this->Cell(45,6,$row['nama_desa'].', '.tgl_indo($r['tgl_buka']),0,0,'C');
	$this->Ln(4);
	
	$this->SetX(140);
	$this->Cell(45,6,'Kepala,',0,0,'C');
	$this->Ln(4);
			
	$this->SetFont('Arial','',9);
	$this->SetX(30);
	$this->Cell(37,10,'Jumlah',0,0,'L');
	$this->SetX(67);
	$this->Cell(2,10,':',0,0,'L');
	
	$this->SetFillColor(232,232,232);		
	$this->SetFont('Arial','',12);
	$this->SetX(70);
	$this->Cell(45,10,'Rp. '.number_format($r['jumlah'],0,',','.').',-',1,0,'C',1);
	$this->Ln(11);
	
	$this->SetFont('Arial','B',9);	
	$this->SetX(140);
	$this->Cell(45,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->Ln(2);
	
	$this->SetFont('Arial','',9);	
	$this->SetX(30);
	$this->Cell(37,6,'Kwitansi',0,0,'L');
	$this->SetX(67);
	$this->Cell(2,6,':',0,0,'L');
	$this->Ln();
	
	$this->SetX(30);
	$this->MultiCell(161,4,'Yang bertanda tangan dibawah ini telah menerima kembali uang simpanan berjangka nomor '.$ids.'/SB/LPD'.tgl_rom($tgl_buka).' seperti tersebut diatas dari LPD '.$row['sebutan_desa'].' '.$row['nama_desa'].'.',0);
	$this->Ln(0);
	
	$this->SetFont('Arial','',9);
	$this->SetX(140);
	$this->Cell(45,6,$row['nama_desa'].', '.tgl_indo($r['tgl_tutup']),0,0,'C');
	$this->Ln(3);
	
	$this->SetX(140);
	$this->Cell(45,6,'Penerima,',0,0,'C');
	$this->Ln(15);
	
	$this->SetFont('Arial','B',9);	
	$this->SetX(140);
	$this->Cell(45,6,strtoupper($r['namadepan']),0,0,'C');
	$this->Ln();
	
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
