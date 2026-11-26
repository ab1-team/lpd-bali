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
		$this->Image('../../../images/frame1copy.jpg',4,3,203,160);
		
		
		$this->Ln(-4);
		$this->SetFillColor(255,255,255);		
		$this->SetFont('Arial','',12);
		$this->SetX(156.5);
		$this->Cell(40,8,$r['nomor_rekening'],0,0,'C',1);
		
	
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
$Y_Fields_Name_position = 35;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(255,255,255);
$this->SetY($Y_Fields_Name_position);


		$this->Ln(-20);
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(120,0,'SYARAT-SYARAT UMUM ',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Simpanan Berjangka ini baru dapat diambil kembali setelah jangka waktunya berakhir.',0);
		$this->Ln(1);
		
		$this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Segala perubahan-perubahan nama, alamat, tanda tangan, dan lain-lain yang menyimpang dan penjelasan-penjelasan yang pernah diberikan LPD Desa Adat Cengkok harus diberitahukan dengan tertulis.',0);
		$this->Ln(1);

        $this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Bila pemegang simpanan berjangka meninggal dunia, uang simpanannya akan dibayarkan kembali kepada ahli warisnya yang sah, kecuali jika ditetapkan lain.',0);
		$this->Ln(1);

		$this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Terhadap simpanan berjangka ini diberikan bunga sebesar 0,6% per bulan.',0);
		$this->Ln(1);

        $this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'5.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Pemegang Simpanan Berjangka harus tunduk kepada syarat-syarat umum dan ketentuan-ketentuan lain yang telah dan ditetapkan kemudian oleh LPD Desa Adat Cengkok.',0);
		$this->Ln(1);

        $this->SetFont('Arial','',8);
	    $this->SetX(22);
		$this->Cell(4,4,'6.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(160,4,'Perpanjangan otomatis dilakukan untuk jangka waktu yang sama bila tidak dicairkan pada saat jatuh tempo.',0);
		$this->Ln(1);

        $this->SetFont('Arial','B',8);
        $this->SetX(80);
	    $this->Cell(45,3,'PERHITUNGAN BUNGA',0,0,'C');
	    $this->Ln(1);

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->Ln(3);
$this->SetFillColor(252,252,252);
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(8,6,'No',1,0,'C',0);
$this->SetX(28);
$this->Cell(25,6,'Bunga',1,0,'C',0);
$this->SetX(53);
$this->Cell(18,6,'Tgl',1,0,'C',0);
$this->SetX(71);
$this->Cell(18,6,'No Bukti',1,0,'C',0);
$this->SetX(89);
$this->Cell(15,6,'Paraf',1,0,'C',0);
$this->SetX(104);
$this->Cell(8,6,'No',1,0,'C',0);
$this->SetX(112);
$this->Cell(25,6,'Bunga',1,0,'C',0);
$this->SetX(137);
$this->Cell(18,6,'Tgl',1,0,'C',0);
$this->SetX(155);
$this->Cell(18,6,'No Bukti',1,0,'C',0);
$this->SetX(173);
$this->Cell(15,6,'Paraf',1,0,'C',0);
$this->Ln();

// Isi Tabel

for($no=1;$no<=6;$no++){
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(8,5,$no,1,0,'C',0);
$this->SetX(28);
$this->Cell(25,5,'',1,0,'C',0);
$this->SetX(53);
$this->Cell(18,5,'',1,0,'C',0);
$this->SetX(71);
$this->Cell(18,5,'',1,0,'C',0);
$this->SetX(89);
$this->Cell(15,5,'',1,0,'C',0);
$this->SetX(104);
$this->Cell(8,5,$no+6,1,0,'C',0);
$this->SetX(112);
$this->Cell(25,5,'',1,0,'C',0);
$this->SetX(137);
$this->Cell(18,5,'',1,0,'C',0);
$this->SetX(155);
$this->Cell(18,5,'',1,0,'C',0);
$this->SetX(173);
$this->Cell(15,5,'',1,0,'C',0);
$this->Ln();	    
}
$this->Ln(3);	    
// Tulisan lagi
        $this->SetFont('Arial','B',8);
        $this->SetX(80);
	    $this->Cell(45,0,'SURAT PERNYATAAN',0,0,'C');
	    $this->Ln(4);
	    
	    $this->SetFont('Arial','',8);
        $this->SetX(22);
	    $this->Cell(45,0,'Yang bertanda tangan di bawah ini :',0);
	    $this->Ln(3);
	    
	    $this->SetFont('Arial','',8);
		$this->SetX(25);
		$this->Cell(53,0,'Nama',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,strtoupper($r['namadepan']),0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',8);
		$this->SetX(25);
		$this->Cell(53,0,'Alamat',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,($r['alamat']),0,0,'L');
		$this->Ln(2);
		
		$this->SetFont('Arial','',8);
		$this->SetX(22);
		$this->MultiCell(174,4,'Dalam hal ini bertindak untuk dan atas nama Pemegang Surat Simpanan Berjangka No '.$ids.'/SB/LPD'.tgl_rom($tgl_buka).' menyatakan telah menyetujui/ menerima baik syarat-syarat umum yang telah ditetapkan kemudian oleh LPD DESA ADAT CENGKOK.',0);
		$this->Ln(0);
	    

		
//Tanda Tangan
$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

	
	$this->SetFont('Arial','',8);
	$this->SetX(140);
	$this->Cell(45,4,$row['nama_desa'].', '.tgl_indo($r['tgl_buka']),0,0,'C');
	$this->Ln(3);
	
    $this->SetX(45);
    $this->Cell(15,4,'Ahli Waris',0,0,'C',0);
    $this->SetX(140);
	$this->Cell(45,4,'Penerima',0,0,'C');
	$this->Ln(13);
	
	$this->SetFont('Arial','B',8);
	if (empty($r['penjamin'])) {
	
	$this->SetX(45);
	$this->Cell(15,4,'( ________________ )',0,0,'C',0);
	$this->SetX(140);
	$this->Cell(45,4,strtoupper($r['namadepan']),0,0,'C');
	$this->Ln();
	
  } else {
	  
	$this->SetX(45);
	$this->Cell(15,4,strtoupper($r['penjamin']),0,0,'C',0);
	$this->SetX(140);
	$this->Cell(35,4,strtoupper($r['namadepan']),0,0,'C');
	$this->Ln();
	
  }
 }
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('SERTIFIKAT HAL 2');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
