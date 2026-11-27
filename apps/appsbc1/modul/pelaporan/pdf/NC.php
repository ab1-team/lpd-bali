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
		$table_rekening		="rekening_".$_SESSION['lokasi'];
		$lokasi				=$_SESSION['lokasi'];
		$report				=$_POST['report'];
			if (empty($report)) {
				$idf				=$_GET['idf'];
				$jenis_buku			=$_GET['idf'];
				$d					=$_GET['d'];
				$m					=$_GET['m'];
				$y					=$_GET['y'];
			}else{
				$idf				=substr($_POST['sub_report'],3);
				$jenis_buku			=substr($_POST['sub_report'],3);
				$d					=$_POST['d'];
				$m					=$_POST['m'];
				$y					=$_POST['y'];
			}
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r where a.id=r.id_akun AND r.kd_rekening='$idf' "));

		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

		
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
		$this->Cell(95,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'N E R A C A',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		$this->Ln(10);

	}
	
	//Page Content
	function Content()
	{
		
		//Kotak
		$this->SetLineWidth(0.5);
		$this->Rect(19, 41.5, 179, 10);
		$this->Rect(19, 41.5, 86, 119);
		$this->Rect(105, 41.5, 93, 119);

	$this->SetFillColor(232,232,232);
	
	$this->SetX(20);
	$this->Cell(84,8,'AKTIVA',0,0,'C',1);
	
	$this->SetX(106);
	$this->Cell(91,8,'PASSIVA',0,0,'C',1);
	$this->Ln(10);

$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];
$report				=$_POST['report'];
			if (empty($report)) {
				$idf				=$_GET['idf'];
				$jenis_buku			=$_GET['idf'];
				$d					=$_GET['d'];
				$m					=$_GET['m'];
				$y					=$_GET['y'];
			}else{
				$idf				=substr($_POST['sub_report'],3);
				$jenis_buku			=substr($_POST['sub_report'],3);
				$d					=$_POST['d'];
				$m					=$_POST['m'];
				$y					=$_POST['y'];
			}
$tgl				="$y-$m-$d";
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

	$view=mysql_query("select * from jenis_akun WHERE posisi='1' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");
						
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(80,6,$row['nama_akun'],0,0,'L',0);
									$this->Ln(6);
									
									
							while($r=mysql_fetch_array($data)){
							$saldo_aktiva=saldoR("$tgl_kondisi-".$r['kd_rekening']);
							
									$this->SetFont('Arial','',8);
									$this->SetX(20);
									$this->Cell(80,6,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L',0);
									$this->SetX(20);
									$this->Cell(80,6,number_format($saldo_aktiva,2,',','.'),0,0,'R',0);
									$this->Ln(6);
									
									$aktiva=$aktiva+$saldo_aktiva;
							
							}

						}
						
	
									$this->Ln(15);
									$this->SetFillColor(232,232,232);
									$this->SetFont('Arial','B',10);
									$this->SetX(20);
									$this->Cell(84,8,number_format($aktiva,2,',','.'),0,0,'C',1);
									
									$this->SetFont('Arial','B',10);
									$this->SetX(106);
									$this->Cell(91,8,number_format(surplus($tgl_kondisi)+passiva($tgl_kondisi),2,',','.'),0,0,'C',1);
									$this->Ln(8);
									
									$this->Ln(-107);
									
	//PASSIVA									
	$view=mysql_query("select * from jenis_akun WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");
									
									$this->SetFont('Arial','B',8);
									$this->SetX(110);
									$this->Cell(90,6,$row['nama_akun'],0,0,'L',0);
									$this->Ln(6);
									
									
							while($r=mysql_fetch_array($data)){
							$saldo_passiva=saldoR("$tgl_kondisi-".$r['kd_rekening']);
							
									$this->SetFont('Arial','',8);
									$this->SetX(110);
									$this->Cell(90,6,$r['kd_rekening'].'. '.$r['nama_rekening'],0,0,'L',0);
									$this->SetX(105);
									$this->Cell(90,6,number_format($saldo_passiva,2,',','.'),0,0,'R',0);
									$this->Ln(6);
									
									$passiva=$passiva+$saldo_passiva;
							
							}

						}
						
									$this->SetFont('Arial','B',8);
									$this->SetX(110);
									$this->Cell(90,6,'Ikhtisar Laba Rugi',0,0,'L',0);
									$this->SetX(105);
									$this->Cell(90,6,number_format(surplus($tgl_kondisi),2,',','.'),0,0,'R',0);
									$this->Ln(20);
									
									
									
									
	
	
//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',8);
	
	$this->Ln(6);
	$this->SetX(20);
	$this->Cell(60,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Dilaporkan oleh,',0,0,'C');

	$this->Ln(20);
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
	$this->Cell(60,6,'Kepala '.LEMBAGA_SORT,0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
			
	
	
	
		
	}

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0); //warna
		$this->SetLineWidth(0.2);
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->Cell(0,5,'Paraf : ............ | Neraca, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Neraca '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('2. 1. Neraca '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
