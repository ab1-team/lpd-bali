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

		
	}
	
	//Page Content
	function Content()
	{
		
	
			
	$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";

	if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $nomor="0$d";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $nomor="0$m";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $nomor="0$y";}else{$laporan="Global"; $nomor="0001";}
	$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

		
		//Logo 
		$this->Image('../../../images/logo_lpd.gif',40,10,20,0);
			
		$this->SetY(12);
		$this->SetFont('Arial','',14);
		$this->SetX(30);
		$this->Cell(0,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'C');
		$this->Ln(6);
		$this->SetFont('Arial','B',16);
		$this->SetX(30);
		$this->Cell(0,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'C');
		$this->Ln(5);
		
		$this->SetFont('Arial','I',8);
		$this->SetTextColor(0,0,0);
		$this->SetX(30);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'C');
		$this->Ln(1);
		
		$this->SetX(30);
		$this->Cell(0,5,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'C');
		$this->Ln(7);
		
		$this->Line(35,30,190,30);
		$this->Line(35,30.5,190,30.5);
		
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',10);
		$this->SetX(35);
		$this->Cell(20,5,'Nomor',0,0,'L');
		$this->Cell(2,5,': ',0,0,'L');
		$this->Cell(88,5,$nomor.'/LPD.'.$row['inisial'].''.tgl_rom($tgl),0,0,'L');
		$this->Cell(45,5,ucwords($row['nama_desa']).',     '.tgl_indo($tgl),0,0,'R');
		$this->Ln(5);
		
		$this->SetX(35);
		$this->Cell(20,5,'Lampiran',0,0,'L');
		$this->Cell(2,5,': ',0,0,'L');
		$this->Cell(88,5,'1 Bendel',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(35);
		$this->Cell(20,5,'Perihal',0,0,'L');
		$this->Cell(2,5,': ',0,0,'L');
		$this->Cell(88,5,'Laporan Perkembangan LPD',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(35);
		$this->Cell(22,5,'',0,0,'L');
		$this->SetFont('Arial','U',10);
		$this->Cell(88,5,'Sampai Dengan '.$jenis.' '.tgl_indo($tgl).'.',0,0,'L');
		$this->Ln(13);
		
		$this->SetFont('Arial','B',10);
		$this->SetX(57);
		$this->Cell(88,5,'Kepada Yth.',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(57);
		$this->Cell(88,5,'Kepala LP LPD Kabupaten '.$row['nama_kab'],0,0,'L');
		$this->Ln(5);
		
		$this->SetX(57);
		$this->Cell(88,5,'Di '.$row['alamat_kab'].'.',0,0,'L');
		$this->Ln(13);
		
		$this->SetFont('Arial','',10);
		$this->SetX(57);
		$this->Cell(88,5,'Dengan hormat,',0,0,'L');
		$this->Ln(6);
		
		$this->SetX(57);
		$this->MultiCell(133,5,'Bersama ini kami sampaikan Laporan Perkembangan LPD '.$row['sebutan_desa'].' '.$row['nama_desa'].' sampai dengan '.$jenis.' '.tgl_indo($tgl).' sebagai berikut:',0);
		$this->Ln(1);
		
		$this->SetX(60);
		$this->Cell(88,5,'1. Surat Pengantar',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'2. Neraca Bulanan',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'3. Daftar Perincian Rugi/Laba',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'4. Laporan Kegiatan',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'5. Laporan Sektrorial',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'6. Neraca Percobaan',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'7. Berita Acara Uang Kas',0,0,'L');
		$this->Ln(5);
		
		$this->SetX(60);
		$this->Cell(88,5,'8. Penempatan ABA',0,0,'L');
		$this->Ln(6);
		
		$this->SetX(57);
		$this->MultiCell(133,5,'Demikian laporan kami sampaikan, atas perhatiannya kami ucapkan terima kasih.',0);
		$this->Ln(10);
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
	$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
		
		$this->SetX(35);
		$this->Cell(75,0,'Mengetahui',0,0,'C');
		$this->SetX(110);
		$this->Cell(75,0,'Lembaga Perkreditan Desa (LPD)',0,0,'C');
		$this->Ln(4);
		
		$this->SetX(35);
		$this->Cell(75,0,'Badan Pengawasan LPD',0,0,'C');
		$this->SetX(110);
		$this->Cell(75,0,$row['sebutan_desa'].' '.$row['nama_desa'],0,0,'C');
		$this->Ln(4);
		
		$this->SetX(35);
		$this->Cell(75,0,'Ketua,',0,0,'C');
		$this->SetX(110);
		$this->Cell(75,0,'Kepala,',0,0,'C');
		$this->Ln(25);
		
		$this->SetFont('Arial','B',10);
		$this->SetX(35);
		$this->Cell(75,0,strtoupper("$u2[namadepan] $u2[namabelakang]"),0,0,'C');
		$this->SetX(110);
		$this->Cell(75,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->Ln(8);
		
		$this->SetFont('Arial','',10);
		$this->SetX(35);
		$this->Cell(20,5,'Tembusan :',0,0,'L');
		$this->Ln(4);
		
		$this->SetX(35);
		$this->Cell(20,5,'   1. Arsip',0,0,'L');
		$this->Ln(4);



	
		
	}

	//Page footer
	function Footer()
	{
		
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Surat Pengantar '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('2. Surat Pengantar '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
