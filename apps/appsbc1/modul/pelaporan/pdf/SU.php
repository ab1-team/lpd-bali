<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/fpdf.php');

class PDF extends FPDF
{ 
	//Page header
	function Header()
	{
$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));


		$this->SetY(11);
		//Logo
		$this->Image('../../../images/logo_bumdes.png',20,9,12,0);
		
		//Arial bold 15
		$this->SetMargins(13,0);
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
		$this->Cell(0,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(3);

		//buat garis horisontal
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,17,283,17);
		
		$this->SetFont('Arial','B',10);
		$this->SetDrawColor(0,0,0); //warna
		//judul
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'LAPORAN PERKEMBANGAN SIMPANAN UMUM',0,0,'C');
		$this->Ln(4);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		
//Fields Name position
$Y_Fields_Name_position = 29;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetFillColor(255,255,255);
//Bold Font for Field Name
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(18);
$this->Cell(7,10,'NO',1,0,'C',1);
$this->SetX(25);
$this->Cell(30,10,'NOMOR REKENING',1,0,'C',1);
$this->SetX(55);
$this->Cell(25,10,'TANGGAL BUKA',1,0,'C',1);
$this->SetX(80);
$this->Cell(15,10,'CIF',1,0,'C',1);
$this->SetX(95);
$this->Cell(55,10,'CUSTOMER/KREDITUR',1,0,'C',1);
$this->SetX(150);
$this->Cell(40,10,'TELPON, ALAMAT',1,0,'C',1);
$this->SetX(190);
$this->Cell(50,5,'MUTASI',1,0,'C',1);
$this->SetX(240);
$this->Cell(30,10,'SALDO',1,0,'C',1);
$this->SetX(270);
$this->Cell(13,10,'STATUS',1,0,'C',1);
$this->Ln(5);

$this->SetX(190);
$this->Cell(25,5,'DEBIT',1,0,'C',1);
$this->SetX(215);
$this->Cell(25,5,'KREDIT',1,0,'C',1);
$this->Ln();

	}
	
	//Page Content
	function Content()
	{
		
$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				="$y-$m-$d";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}
		
$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.tgl_buka<='$tgl_kondisi' AND si.jenis_simpanan='1' order by si.nomor_rekening asc");
								$no=0;
								while($r=mysql_fetch_array($view)){
		$no=$no+1;
								$idsimp			=$r['id'];
								$tgl_now		=date('Y-m-d');
								$sumnabung		=sumnabung("$tgl_kondisi-$idsimp");
								$sumambil		=sumambil("$tgl_kondisi-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_kondisi-$idsimp");
								$sts			=$r['status'];
		 
				$this->SetFont('Arial','',6);
				$this->SetFillColor(255,255,255);
				$this->SetX(18);
				$this->Cell(7,5,$no,1,0,'C',1);
				$this->SetX(25);
				$this->Cell(30,5,$r['nomor_rekening'],1,0,'C',1);
				$this->SetX(55);
				$this->Cell(25,5,tgl_ind($r['tgl_buka']),1,0,'C',1);
				$this->SetX(80);
				$this->Cell(15,5,$r['id'],1,0,'C',1);
				$this->SetX(95);
				$this->Cell(55,5,$r['nik'].' - '.strtoupper($r['namadepan']),1,0,'L',1);
				$this->SetX(150);
				$this->Cell(40,5,$r['hp'].', '.$r['alamat'],1,0,'L',1);
				$this->SetX(190);
				$this->Cell(25,5,number_format($sumambil,0,',','.'),1,0,'R',1);
				$this->SetX(215);
				$this->Cell(25,5,number_format($sumnabung,0,',','.'),1,0,'R',1);
				$this->SetX(240);
				$this->Cell(30,5,number_format($saldosimpanan,0,',','.'),1,0,'R',1);
				$this->SetX(270);
				$this->Cell(13,5,$r['nama_status'],1,0,'C',1);
				$this->Ln();
				
			
  $totambil+=$sumambil;
  $totnabung+=$sumnabung;
  $totsaldo=$totnabung-$totambil;
  
  }
		
				$this->SetFont('Arial','B',6);
				$this->SetX(18);
				$this->Cell(172,8,'T O T A L',1,0,'C',1);
				$this->SetX(190);
				$this->Cell(25,8,number_format($totambil,0,',','.'),1,0,'C',1);
				$this->SetX(215);
				$this->Cell(25,8,number_format($totnabung,0,',','.'),1,0,'C',1);
				$this->SetX(240);
				$this->Cell(30,8,number_format($totsaldo,0,',','.'),1,0,'C',1);
				$this->SetX(270);
				$this->Cell(13,8,'',1,0,'C',1);
				$this->Ln();

	
	
	//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='2' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u4=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',8);
	
	$this->Ln(5);
	$this->SetX(20);
	$this->Cell(60,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(120,6,'Dilaporkan oleh,',0,0,'C');

	$this->Ln(17);
	$this->SetFont('Arial','B',8);	
	$this->SetX(20);
	$this->Cell(60,6,strtoupper($u4['namadepan'].' '.$u4['namabelakang']),0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	$this->SetX(200);
	$this->Cell(60,6,strtoupper($u3['namadepan'].' '.$u3['namabelakang']),0,0,'C');
	
	$this->Ln(2.5);
	$this->SetFont('Arial','I',8);	
	$this->SetX(20);
	$this->Cell(60,6,'Badan Pengawas (Panureksa)',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Kepala '.LEMBAGA_SORT,0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
	$this->SetX(200);
	$this->Cell(60,6,'Sekretaris/Data Center',0,0,'C');
	
	} //End Content

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(18,$this->GetY(),283,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(18);
		$this->Cell(0,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(18);
		$this->Cell(0,4,'Paraf : ............ | Simpanan Umum, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Simpanan Sukarela/Umum '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('5.1. Perkembangan Simpanan Sukarela/Umum '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
