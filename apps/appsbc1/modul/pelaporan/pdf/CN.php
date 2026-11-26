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
		
$lokasi				=$_SESSION['lokasi'];
$id_user			=$_SESSION['id_user'];

$report				=$_POST['report'];
if (empty($report)) {
	$tanggal	=date('Y-m-d');
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
	$akhir_bulan		=date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime($m . '/01/' . $y. ' 00:00:00'))));
	if($d=="") { $tanggal =$akhir_bulan; }else{ $tanggal	="$y-$m-$d"; }
}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));


		//Logo
		$this->Image('../../../images/logo_lpd.gif',21,8,12,0);
		
		//Arial bold 16
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetX(33);
		$this->Cell(86,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(33);
		$this->Cell(86,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.6);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(106);
		$this->Cell(96,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'BERITA ACARA PERHITUNGAN UANG KAS',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','I',12);
		$this->Cell(0,0,'( C A S H  O P N A M E )',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'TANGGAL '.strtoupper(tgl_indo($tanggal)),0,0,'C');
		
		



		

	}
	
	//Page Content
	function Content()
	{
		
$lokasi				=$_SESSION['lokasi'];
$id_user			=$_SESSION['id_user'];

$report				=$_POST['report'];
if (empty($report)) {
	$tanggal	=date('Y-m-d');
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
	$akhir_bulan		=date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime($m . '/01/' . $y. ' 00:00:00'))));
	if($d=="") { $tanggal =$akhir_bulan; }else{ $tanggal	="$y-$m-$d"; }
}

$r=mysql_fetch_array(mysql_query("SELECT * FROM cashopname WHERE tanggal='$tanggal' AND lokasi='$lokasi' ORDER BY id DESC "));

$k1	= $r['k100K'];
$k2	= $r['k50K'];
$k3	= $r['k20K'];
$k4	= $r['k10K'];
$k5	= $r['k5K'];
$k6	= $r['k2K'];
$k7	= $r['k1K'];
$k8	= $r['k500'];
$k9	= $r['k100'];
$l1	= $r['L1K'];
$l2	= $r['L500'];
$l3	= $r['L200'];
$l4	= $r['L100'];
$l5	= $r['L50'];
$l6	= $r['L25'];
$l7	= $r['L5'];
$l8	= $r['L1'];

$sumk	=$k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8+$k9;
$suml	=$l1+$l2+$l3+$l4+$l5+$l6+$l7+$l8;

$sk1	= $r['k100K'] * 100000;
$sk2	= $r['k50K'] * 50000;
$sk3	= $r['k20K'] * 20000;
$sk4	= $r['k10K'] * 10000;
$sk5	= $r['k5K'] * 5000;
$sk6	= $r['k2K'] * 2000;
$sk7	= $r['k1K'] * 1000;
$sk8	= $r['k500'] * 500;
$sk9	= $r['k100'] * 100;
$sl1	= $r['L1K'] * 1000;
$sl2	= $r['L500'] * 500;
$sl3	= $r['L200'] * 200;
$sl4	= $r['L100'] * 100;
$sl5	= $r['L50'] * 50;
$sl6	= $r['L25'] * 25;
$sl7	= $r['L5'] * 5;
$sl8	= $r['L1'] * 1;

$sumsk	=$sk1+$sk2+$sk3+$sk4+$sk5+$sk6+$sk7+$sk8+$sk9;
$sumsl	=$sl1+$sl2+$sl3+$sl4+$sl5+$sl6+$sl7+$sl8;
$sumCON	=$sumsk+$sumsl;
$saldo	=saldoR("$tanggal-1-10001");
		
//Fields Name position
$Y_Fields_Name_position = 42;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',9);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(40,8,'Uang Kertas (Rp.)',1,0,'C',1);
$this->SetX(60);
$this->Cell(40,8,'Jumlah (Lembar)',1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,'Total (Rp.)',1,0,'C',0);
$this->SetX(140);
$this->Cell(60,8,'Catatan',1,0,'C',0);
$this->Ln(8);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'100.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k1,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk1,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'50.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k2,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk2,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'20.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k3,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk3,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'10.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k4,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk4,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'5.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k5,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk5,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'2.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k6,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk6,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'1.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k7,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk7,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'500',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k8,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk8,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetX(20);
$this->Cell(40,6,'100',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$k9,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sk9,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

//SUM Kertas
$this->SetFont('Arial','B',9);
$this->SetX(20);
$this->Cell(40,8,'Jumlah',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,8,$sumk,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,number_format($sumsk,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,8,'',1,0,'L',0);
$this->Ln(10);


$this->SetX(20);
$this->Cell(40,8,'Uang Logam (Rp.)',1,0,'C',1);
$this->SetX(60);
$this->Cell(40,8,'Jumlah (Keping)',1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,'Total (Rp.)',1,0,'C',0);
$this->SetX(140);
$this->Cell(60,8,'Catatan',1,0,'C',0);
$this->Ln(8);

$this->SetFont('Arial','',9);
$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'1.000',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l1,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl1,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'500',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l2,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl2,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'200',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l3,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl3,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'100',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l4,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl4,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'50',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l5,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl5,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'25',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l6,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl6,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'5',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l7,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl7,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

$this->SetFont('Arial','',9);
$this->SetX(20);
$this->Cell(40,6,'1',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,6,$l8,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,6,number_format($sl8,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,6,'',1,0,'L',0);
$this->Ln(6);

//SUM Logam
$this->SetFont('Arial','B',9);
$this->SetX(20);
$this->Cell(40,8,'Jumlah',1,0,'C',0);
$this->SetX(60);
$this->Cell(40,8,$suml,1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,number_format($sumsl,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,8,'',1,0,'L',0);
$this->Ln(10);

//SUM ALL
$this->SetFont('Arial','B',9);
$this->SetX(20);
$this->Cell(80,8,'Jumlah Kas Fisik',1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,number_format($sumCON,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,8,'',1,0,'L',0);
$this->Ln(8);

$this->SetX(20);
$this->Cell(80,8,'Jumlah Menurut Neraca Percobaan',1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,number_format($saldo,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,8,'',1,0,'L',0);
$this->Ln(8);

$this->SetX(20);
$this->Cell(80,8,'Selisih',1,0,'C',0);
$this->SetX(100);
$this->Cell(40,8,number_format($sumCON-$saldo,2,',','.'),1,0,'R',0);
$this->SetX(140);
$this->Cell(60,8,'',1,0,'L',0);
$this->Ln(8);




//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',9);
	
	$this->Ln(5);
	$this->SetX(20);
	$this->Cell(60,5,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,5,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,5,'Dibuat oleh,',0,0,'C');

	$this->Ln(20);
	$this->SetFont('Arial','B',8);	
	$this->SetX(20);
	$this->Cell(60,5,strtoupper($u3['namadepan'].' '.$u3['namabelakang']),0,0,'C');
	$this->SetX(80);
	$this->Cell(60,5,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(140);
	$this->Cell(60,5,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	
	$this->Ln(3);
	$this->SetFont('Arial','I',8);	
	$this->SetX(20);
	$this->Cell(60,5,'Badan Pengawas',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,5,'Kepala LPD',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,5,'Accounting',0,0,'C');
			
	
		
	}

	//Page footer
	function Footer()
	{
$report				=$_POST['report'];
if (empty($report)) {
	$tanggal	=date('Y-m-d');
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
	$akhir_bulan		=date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime($m . '/01/' . $y. ' 00:00:00'))));
	if($d=="") { $tanggal =$akhir_bulan; }else{ $tanggal	="$y-$m-$d"; }
}
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.6 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->Cell(0,4,'Paraf : ............ | Cash Opname '.tgl_indo($tanggal).', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$report				=$_POST['report'];
if (empty($report)) {
	$tanggal	=date('Y-m-d');
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
	$akhir_bulan		=date("Y-m-d", strtotime('-1 second', strtotime('+1 month',strtotime($m . '/01/' . $y. ' 00:00:00'))));
	if($d=="") { $tanggal =$akhir_bulan; }else{ $tanggal	="$y-$m-$d"; }
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('CASH OPNAME '.tgl_indo($tanggal));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
