<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/fpdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		
$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));


		//Logo
		$this->Image('../../../images/logo_bumdes.png',21,8,12,0);
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper(LEMBAGA_LONG),0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);

		$this->SetFont('Arial','I',6);
		$this->SetX(105);
		$this->Cell(175,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(8);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,283,16);
		
		//judul
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'REALISASI ANGGARAN DAN BIAYA (E-BUDGETING)',0,0,'C');
		$this->Ln(5);
		$this->Cell(0,0,'TAHUN ANGGARAN '.$tahun_anggaran,0,0,'C');
		
		
//Fields Name position
$Y_Fields_Name_position = 35;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',8);
$this->SetY($Y_Fields_Name_position);
$this->SetX(12);
$this->Cell(61,12,'Nama Rekening',1,0,'C',1);
$this->SetX(73);
$this->Cell(15,12,'Rencana',1,0,'C',1);
$this->SetX(88);
$this->Cell(180,6,'Realisasi',1,0,'C',1);
$this->SetX(268);
$this->Cell(15,12,'TOTAL',1,0,'C',1);
$this->Ln(6);


$this->SetX(88);
$this->Cell(15,6,'Jan',1,0,'C',1);
$this->SetX(103);
$this->Cell(15,6,'Feb',1,0,'C',1);
$this->SetX(118);
$this->Cell(15,6,'Mar',1,0,'C',1);
$this->SetX(133);
$this->Cell(15,6,'Apr',1,0,'C',1);
$this->SetX(148);
$this->Cell(15,6,'Mei',1,0,'C',1);
$this->SetX(163);
$this->Cell(15,6,'Jun',1,0,'C',1);
$this->SetX(178);
$this->Cell(15,6,'Jul',1,0,'C',1);
$this->SetX(193);
$this->Cell(15,6,'Agt',1,0,'C',1);
$this->SetX(208);
$this->Cell(15,6,'Sep',1,0,'C',1);
$this->SetX(223);
$this->Cell(15,6,'Okt',1,0,'C',1);
$this->SetX(238);
$this->Cell(15,6,'Nop',1,0,'C',1);
$this->SetX(253);
$this->Cell(15,6,'Des',1,0,'C',1);
$this->Ln(6);


		

	}
	
	//Page Content
	function Content()
	{
		
$this->Rect(12,35,271,154);


//PENDAPATAN
$this->SetFont('Arial','B',8);
$this->SetX(12);
$this->Cell(271,5,'4-00000. PENDAPATAN',1,0,'L');
$this->Ln(5);

$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}

$view=mysql_query("select * from jenis_akun WHERE posisi='4' ORDER by id ASC ");
	while($row=mysql_fetch_array($view)){
														
	$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");												

$this->SetFont('Arial','B',8);														
$this->SetX(12);
$this->Cell(271,4,'4-'.$row['id'].'0000. '.$row['nama_akun'],1,0,'L');
$this->Ln(4);

	while($r=mysql_fetch_array($data)){
																	
	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
	$angkarencana=$s['ra'];
	
	$pjan	=saldoRB("$tahun_anggaran-01-$r[kd_rekening]");
	$pfeb	=saldoRB("$tahun_anggaran-02-$r[kd_rekening]");
	$pmar	=saldoRB("$tahun_anggaran-03-$r[kd_rekening]");
	$papr	=saldoRB("$tahun_anggaran-04-$r[kd_rekening]");
	$pmei	=saldoRB("$tahun_anggaran-05-$r[kd_rekening]");
	$pjun	=saldoRB("$tahun_anggaran-06-$r[kd_rekening]");
	$pjul	=saldoRB("$tahun_anggaran-07-$r[kd_rekening]");
	$pagt	=saldoRB("$tahun_anggaran-08-$r[kd_rekening]");
	$psep	=saldoRB("$tahun_anggaran-09-$r[kd_rekening]");
	$pokt	=saldoRB("$tahun_anggaran-10-$r[kd_rekening]");
	$pnop	=saldoRB("$tahun_anggaran-11-$r[kd_rekening]");
	$pdes	=saldoRB("$tahun_anggaran-12-$r[kd_rekening]");
	$ptotal	=saldoRT("$tahun_anggaran-$r[kd_rekening]");

$this->SetFont('Arial','',8);	

$this->SetX(12);
$this->Cell(61,4,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L');
$this->SetX(73);

$this->SetFont('Arial','',7);

$this->Cell(15,4,number_format($angkarencana,0,',','.'),0,0,'R',0);
$this->SetX(88);
$this->Cell(15,4,number_format($pjan,0,',','.'),0,0,'R',0);
$this->SetX(103);
$this->Cell(15,4,number_format($pfeb,0,',','.'),0,0,'R',0);
$this->SetX(118);
$this->Cell(15,4,number_format($pmar,0,',','.'),0,0,'R',0);
$this->SetX(133);
$this->Cell(15,4,number_format($papr,0,',','.'),0,0,'R',0);
$this->SetX(148);
$this->Cell(15,4,number_format($pmei,0,',','.'),0,0,'R',0);
$this->SetX(163);
$this->Cell(15,4,number_format($pjun,0,',','.'),0,0,'R',0);
$this->SetX(178);
$this->Cell(15,4,number_format($pjul,0,',','.'),0,0,'R',0);
$this->SetX(193);
$this->Cell(15,4,number_format($pagt,0,',','.'),0,0,'R',0);
$this->SetX(208);
$this->Cell(15,4,number_format($psep,0,',','.'),0,0,'R',0);
$this->SetX(223);
$this->Cell(15,4,number_format($pokt,0,',','.'),0,0,'R',0);
$this->SetX(238);
$this->Cell(15,4,number_format($pnop,0,',','.'),0,0,'R',0);
$this->SetX(253);
$this->Cell(15,4,number_format($pdes,0,',','.'),0,0,'R',0);
$this->SetX(268);
$this->Cell(15,4,number_format($ptotal,0,',','.'),0,0,'R',0);
$this->Ln(4);

$sump=$sump+$angkarencana;
$tpjan=$tpjan+$pjan;
$tpfeb=$tpfeb+$pfeb;
$tpmar=$tpmar+$pmar;
$tpapr=$tpapr+$papr;
$tpmei=$tpmei+$pmei;
$tpjun=$tpjun+$pjun;
$tpjul=$tpjul+$pjul;
$tpagt=$tpagt+$pagt;
$tpsep=$tpsep+$psep;
$tpokt=$tpokt+$pokt;
$tpnop=$tpnop+$pnop;
$tpdes=$tpdes+$pdes;
$tptotal=$tptotal+$ptotal;

	}

	}

$this->SetFont('Arial','B',8);														

$this->SetX(12);
$this->Cell(271,5,'       Total Pendapatan',1,0,'L',0);

$this->SetFont('Arial','B',7);
$this->SetX(73);
$this->Cell(15,5,number_format($sump,0,',','.'),0,0,'R');
$this->SetX(88);
$this->Cell(15,5,number_format($tpjan,0,',','.'),0,0,'R',0);
$this->SetX(103);
$this->Cell(15,5,number_format($tpfeb,0,',','.'),0,0,'R',0);
$this->SetX(118);
$this->Cell(15,5,number_format($tpmar,0,',','.'),0,0,'R',0);
$this->SetX(133);
$this->Cell(15,5,number_format($tpapr,0,',','.'),0,0,'R',0);
$this->SetX(148);
$this->Cell(15,5,number_format($tpmei,0,',','.'),0,0,'R',0);
$this->SetX(163);
$this->Cell(15,5,number_format($tpjun,0,',','.'),0,0,'R',0);
$this->SetX(178);
$this->Cell(15,5,number_format($tpjul,0,',','.'),0,0,'R',0);
$this->SetX(193);
$this->Cell(15,5,number_format($tpagt,0,',','.'),0,0,'R',0);
$this->SetX(208);
$this->Cell(15,5,number_format($tpsep,0,',','.'),0,0,'R',0);
$this->SetX(223);
$this->Cell(15,5,number_format($tpokt,0,',','.'),0,0,'R',0);
$this->SetX(238);
$this->Cell(15,5,number_format($tpnop,0,',','.'),0,0,'R',0);
$this->SetX(253);
$this->Cell(15,5,number_format($tpdes,0,',','.'),0,0,'R',0);
$this->SetX(268);
$this->Cell(15,5,number_format($tptotal,0,',','.'),0,0,'R',0);
$this->Ln(5);


//BIAYA
$this->SetFont('Arial','B',8);
$this->SetX(12);
$this->Cell(271,5,'5-00000. RENCANA BIAYA',1,0,'L');
$this->Ln(5);

$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}

$view=mysql_query("select * from jenis_akun WHERE posisi='5' ORDER by id ASC ");
	while($row=mysql_fetch_array($view)){
														
	$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");												

$this->SetFont('Arial','B',8);														
$this->SetX(12);
$this->Cell(271,4,'5-'.$row['id'].'0000. '.$row['nama_akun'],1,0,'L');
$this->Ln(4);

	while($r=mysql_fetch_array($data)){
																	
	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
	$angkarencana=$s['ra'];
	
	$bjan	=saldoRBB("$tahun_anggaran-01-$r[kd_rekening]");
	$bfeb	=saldoRBB("$tahun_anggaran-02-$r[kd_rekening]");
	$bmar	=saldoRBB("$tahun_anggaran-03-$r[kd_rekening]");
	$bapr	=saldoRBB("$tahun_anggaran-04-$r[kd_rekening]");
	$bmei	=saldoRBB("$tahun_anggaran-05-$r[kd_rekening]");
	$bjun	=saldoRBB("$tahun_anggaran-06-$r[kd_rekening]");
	$bjul	=saldoRBB("$tahun_anggaran-07-$r[kd_rekening]");
	$bagt	=saldoRBB("$tahun_anggaran-08-$r[kd_rekening]");
	$bsep	=saldoRBB("$tahun_anggaran-09-$r[kd_rekening]");
	$bokt	=saldoRBB("$tahun_anggaran-10-$r[kd_rekening]");
	$bnop	=saldoRBB("$tahun_anggaran-11-$r[kd_rekening]");
	$bdes	=saldoRBB("$tahun_anggaran-12-$r[kd_rekening]");
	$btotal	=saldoRBT("$tahun_anggaran-$r[kd_rekening]");

$this->SetFont('Arial','',8);

$this->SetX(12);
$this->Cell(61,4,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L');

$this->SetFont('Arial','',7);
$this->SetX(73);
$this->Cell(15,4,number_format($angkarencana,0,',','.'),0,0,'R',0);
$this->SetX(88);
$this->Cell(15,4,number_format($bjan,0,',','.'),0,0,'R',0);
$this->SetX(103);
$this->Cell(15,4,number_format($bfeb,0,',','.'),0,0,'R',0);
$this->SetX(118);
$this->Cell(15,4,number_format($bmar,0,',','.'),0,0,'R',0);
$this->SetX(133);
$this->Cell(15,4,number_format($bapr,0,',','.'),0,0,'R',0);
$this->SetX(148);
$this->Cell(15,4,number_format($bmei,0,',','.'),0,0,'R',0);
$this->SetX(163);
$this->Cell(15,4,number_format($bjun,0,',','.'),0,0,'R',0);
$this->SetX(178);
$this->Cell(15,4,number_format($bjul,0,',','.'),0,0,'R',0);
$this->SetX(193);
$this->Cell(15,4,number_format($bagt,0,',','.'),0,0,'R',0);
$this->SetX(208);
$this->Cell(15,4,number_format($bsep,0,',','.'),0,0,'R',0);
$this->SetX(223);
$this->Cell(15,4,number_format($bokt,0,',','.'),0,0,'R',0);
$this->SetX(238);
$this->Cell(15,4,number_format($bnop,0,',','.'),0,0,'R',0);
$this->SetX(253);
$this->Cell(15,4,number_format($bdes,0,',','.'),0,0,'R',0);
$this->SetX(268);
$this->Cell(15,4,number_format($btotal,0,',','.'),0,0,'R',0);
$this->Ln(4);

$sumb=$sumb+$angkarencana;	
$tbjan=$tbjan+$bjan;
$tbfeb=$tbfeb+$bfeb;
$tbmar=$tbmar+$bmar;
$tbapr=$tbapr+$bapr;
$tbmei=$tbmei+$bmei;
$tbjun=$tbjun+$bjun;
$tbjul=$tbjul+$bjul;
$tbagt=$tbagt+$bagt;
$tbsep=$tbsep+$bsep;
$tbokt=$tbokt+$bokt;
$tbnop=$tbnop+$bnop;
$tbdes=$tbdes+$bdes;
$tbtotal=$tbtotal+$btotal;

	}

	}

$this->SetFont('Arial','B',8);
	
$this->SetX(12);
$this->Cell(271,5,'       Total Biaya',1,0,'L',0);

$this->SetFont('Arial','B',7);
$this->SetX(73);
$this->Cell(15,5,number_format($sumb,0,',','.'),0,0,'R');
$this->SetX(88);
$this->Cell(15,5,number_format($tbjan,0,',','.'),0,0,'R',0);
$this->SetX(103);
$this->Cell(15,5,number_format($tbfeb,0,',','.'),0,0,'R',0);
$this->SetX(118);
$this->Cell(15,5,number_format($tbmar,0,',','.'),0,0,'R',0);
$this->SetX(133);
$this->Cell(15,5,number_format($tbapr,0,',','.'),0,0,'R',0);
$this->SetX(148);
$this->Cell(15,5,number_format($tbmei,0,',','.'),0,0,'R',0);
$this->SetX(163);
$this->Cell(15,5,number_format($tbjun,0,',','.'),0,0,'R',0);
$this->SetX(178);
$this->Cell(15,5,number_format($tbjul,0,',','.'),0,0,'R',0);
$this->SetX(193);
$this->Cell(15,5,number_format($tbagt,0,',','.'),0,0,'R',0);
$this->SetX(208);
$this->Cell(15,5,number_format($tbsep,0,',','.'),0,0,'R',0);
$this->SetX(223);
$this->Cell(15,5,number_format($tbokt,0,',','.'),0,0,'R',0);
$this->SetX(238);
$this->Cell(15,5,number_format($tbnop,0,',','.'),0,0,'R',0);
$this->SetX(253);
$this->Cell(15,5,number_format($tbdes,0,',','.'),0,0,'R',0);
$this->SetX(268);
$this->Cell(15,5,number_format($tbtotal,0,',','.'),0,0,'R',0);
$this->Ln(5);


$this->SetFont('Arial','B',8);														

$this->SetX(12);
$this->Cell(271,6,'       SURPLUS',1,0,'L',0);

$this->SetFont('Arial','B',7);
$this->SetX(73);
$this->Cell(15,6,number_format($sump-$sumb,0,',','.'),0,0,'R');
$this->SetX(88);
$this->Cell(15,6,number_format($tpjan-$tbjan,0,',','.'),0,0,'R',0);
$this->SetX(103);
$this->Cell(15,6,number_format($tpfeb-$tbfeb,0,',','.'),0,0,'R',0);
$this->SetX(118);
$this->Cell(15,6,number_format($tpmar-$tbmar,0,',','.'),0,0,'R',0);
$this->SetX(133);
$this->Cell(15,6,number_format($tpapr-$tbapr,0,',','.'),0,0,'R',0);
$this->SetX(148);
$this->Cell(15,6,number_format($tpmei-$tbmei,0,',','.'),0,0,'R',0);
$this->SetX(163);
$this->Cell(15,6,number_format($tpjun-$tbjun,0,',','.'),0,0,'R',0);
$this->SetX(178);
$this->Cell(15,6,number_format($tpjul-$tbjul,0,',','.'),0,0,'R',0);
$this->SetX(193);
$this->Cell(15,6,number_format($tpagt-$tbagt,0,',','.'),0,0,'R',0);
$this->SetX(208);
$this->Cell(15,6,number_format($tpsep-$tbsep,0,',','.'),0,0,'R',0);
$this->SetX(223);
$this->Cell(15,6,number_format($tpokt-$tbokt,0,',','.'),0,0,'R',0);
$this->SetX(238);
$this->Cell(15,6,number_format($tpnop-$tbnop,0,',','.'),0,0,'R',0);
$this->SetX(253);
$this->Cell(15,6,number_format($tpdes-$tbdes,0,',','.'),0,0,'R',0);
$this->SetX(268);
$this->Cell(15,6,number_format($tptotal-$tbtotal,0,',','.'),0,0,'R',0);
$this->Ln(6);


	}

	//Page footer
	function Footer()
	{
		$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(12,$this->GetY(),283,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(12);
		$this->Cell(100,5,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(112);
		$this->Cell(172,5,'Paraf : ............ | Realisasi Anggaran '.$tahun_anggaran.', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$report				=$_POST['report'];
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}
//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('E-BUDGETING '.$tahun_anggaran);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('2. 4. E-Budgeting '.$tahun_anggaran.' ('.$pdf->PageNo().' halaman).pdf','I');
?>
