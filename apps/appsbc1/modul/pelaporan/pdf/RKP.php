<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		

$id_pinj	=$_GET['idp'];


$r		=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia  AND pi.id='$id_pinj' "));
if($id_pinj<9){$lid="000$id_pinj";}else if($id_pinj<99){$lid="00$id_pinj";}else if($id_pinj<999){$lid="0$id_pinj";}else{$lid="$id_pinj";}
$nia		=$r['nia'];
$nik		=$r['nik'];
if($nia<9){$cif="000$nia";}else if($nia<99){$cif="00$nia";}else if($nia<999){$cif="0$nia";}else{$cif="$nia";}

$lpd=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));


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
		$this->Cell(85,0,strtoupper($lpd['sebutan_desa']).' '.strtoupper($lpd['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);
		$this->Cell(0,0,'SK Gubernur Bali No.'.$lpd['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(105);
		$this->Cell(95,0,$lpd['alamat_desa'].', Telp.' .$lpd['telpon_desa'],0,0,'R');
		$this->Ln(5);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','U',11);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'REKENING KORAN PINJAMAN',0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','',8);
		$this->SetX(20);
		$this->Cell(30,0,'Nama Debitur',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(52);
		$this->Cell(50,0,strtoupper($r['namadepan']),0,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetX(102);
		$this->Cell(30,0,'Loan ID',0,0,'L');
		$this->SetX(132);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(134);
		$this->Cell(50,0,$lid,0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(20);
		$this->Cell(30,0,'NIK / CIF',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(52);
		$this->Cell(50,0,substr($nik,0,4).' '.substr($nik,4,4).' '.substr($nik,8,4).' '.substr($nik,12,4).' / '.$cif,0,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetX(102);
		$this->Cell(30,0,'Tanggal Cair',0,0,'L');
		$this->SetX(132);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(134);
		$this->Cell(50,0,tgl_indo($r['tgl_cair']),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(20);
		$this->Cell(30,0,'Alamat',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(52);
		$this->Cell(50,0,$r['alamat'],0,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetX(102);
		$this->Cell(30,0,'Alokasi',0,0,'L');
		$this->SetX(132);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(134);
		$this->Cell(50,0,number_format($r['alokasi'],0,',','.'),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(20);
		$this->Cell(30,0,'Telpon',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(52);
		$this->Cell(50,0,$r['hp'],0,0,'L');
		$this->SetFont('Arial','',8);
		$this->SetX(102);
		$this->Cell(30,0,'Jangka',0,0,'L');
		$this->SetX(132);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(134);
		$this->Cell(50,0,$r['jangka'].' Bulan',0,0,'L');
		$this->Ln(4);
		
		

	//QR-Code
	$qrcode="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$nik.png";
		
	$this->Image($qrcode,175,23,20,0);
		
//Fields Name position
$Y_Fields_Name_position = 45;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(255,255,255);
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(7,7,'No',1,0,'C',1);
$this->SetX(27);
$this->Cell(16,7,'Tanggal',1,0,'C',1);
$this->SetX(43);
$this->Cell(12,7,'Ref',1,0,'C',1);
$this->SetX(55);
$this->Cell(60,7,'Keterangan',1,0,'C',1);
$this->SetX(115);
$this->Cell(22,7,'Pencairan',1,0,'C',1);
$this->SetX(137);
$this->Cell(22,7,'Pokok',1,0,'C',1);
$this->SetX(159);
$this->Cell(21,7,'Jasa',1,0,'C',1);
$this->SetX(180);
$this->Cell(20,7,'Lainnya',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{
		
$table_transaksi="transaksi_$_SESSION[lokasi]";

$id_pinj	=$_GET['idp'];
$text	= "SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi, $table_transaksi t WHERE 
a.id=pi.nia AND pi.id=substring(t.rekening_debit,9) AND rekening_debit='1-10005_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='1-10005_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60001_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60002_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60003_$id_pinj' OR
a.id=pi.nia AND pi.id=substring(t.rekening_kredit,9) AND rekening_kredit='4-60004_$id_pinj' 
ORDER BY t.tgl_transaksi  ";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

$alokasi		=alokasi($id_pinj);
$alokasi_jasa	=alokasi_jasa($id_pinj);


$this->SetX(20);
$this->Cell(7,4,'',1,0,'C');
$this->SetX(27);
$this->Cell(16,4,'',1,0,'C');
$this->SetX(43);
$this->Cell(12,4,'',1,0,'C');
$this->SetX(55);
$this->Cell(60,4,'TARGET PEMBAYARAN',1,0,'C');
$this->SetX(115);
$this->Cell(22,4,number_format($alokasi,2,',','.'),1,0,'R');
$this->SetX(137);
$this->Cell(22,4,number_format($alokasi,2,',','.'),1,0,'R');
$this->SetX(159);
$this->Cell(21,4,number_format($alokasi_jasa,2,',','.'),1,0,'R');
$this->SetX(180);
$this->Cell(20,4,'0,00',1,0,'R');
$this->Ln(4);


$no=0;
								while($row=mysql_fetch_array($sql)){
								$no=$no+1;	
									if($row['rekening_kredit']=="1-10005_$id_pinj") { 
										$pokok	=pokok($row['idtp']);
										$jasa	="0";
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_kredit']=="4-60001_$id_pinj") {
										$pokok	="0";
										$jasa	=jasa($row['idtp']);
										$lainnya="0";
										$pencairan="0";
										}elseif($row['rekening_kredit']=="4-60002_$id_pinj") {
										$pokok	="0";
										$jasa	="0";
										$lainnya	=denda($row['idtp']);
										$pencairan="0";
										}elseif($row['rekening_debit']=="1-10005_$id_pinj") {
										$pokok	="0";
										$jasa	="0";
										$denda	="0";
										$lainnya	="0";
										$pencairan=$row['jumlah'];
										}else{
										$pokok	="0";
										$jasa	="0";
										$pencairan	="0";
										$lainnya=$row['jumlah'];
										}
		
		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetX(20);
		$this->Cell(7,4,$no,1,0,'C');
		$this->SetX(27);
		$this->Cell(16,4,tgl_ind($row['tgl_transaksi']),1,0,'C');
		$this->SetX(43);
		$this->Cell(12,4,$row['idt'],1,0,'C');
		$this->SetX(55);
		$this->Cell(60,4,$row['keterangan_transaksi'],1,0,'L');
		$this->SetX(115);
		$this->Cell(22,4,number_format($pencairan,2,',','.'),1,0,'R',1);
		$this->SetX(137);
		$this->Cell(22,4,number_format($pokok,2,',','.'),1,0,'R',1);
		$this->SetX(159);
		$this->Cell(21,4,number_format($jasa,2,',','.'),1,0,'R',1);
		$this->SetX(180);
		$this->Cell(20,4,number_format($lainnya,2,',','.'),1,0,'R',1);
		$this->Ln(4);
		
		
					$sumcair=$sumcair+$pencairan;
						$sumpokok=$sumpokok+$pokok;
						$sumjasa=$sumjasa+$jasa;
						$sumlainnya=$sumlainnya+$lainnya;
						$saldo_pokok=$row['alokasi']-$sumpokok;
						$saldo_cair=$row['alokasi']-$sumcair;
						$saldo_jasa=$alokasi_jasa-$sumjasa;
		
		}

//JUMLAH BAWAH	
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(95,6,'T O T A L',1,0,'C');
$this->SetX(115);
$this->Cell(22,6,number_format($sumcair,2,',','.'),1,0,'R');
$this->SetX(137);
$this->Cell(22,6,number_format($sumpokok,2,',','.'),1,0,'R');
$this->SetX(159);
$this->Cell(21,6,number_format($sumjasa,2,',','.'),1,0,'R');
$this->SetX(180);
$this->Cell(20,6,number_format($sumlainnya,2,',','.'),1,0,'R');
$this->Ln(6);

$this->SetX(20);
$this->Cell(95,6,'S A L D O',1,0,'C');
$this->SetX(115);
$this->Cell(22,6,number_format($saldo_cair,2,',','.'),1,0,'R');
$this->SetX(137);
$this->Cell(22,6,number_format($saldo_pokok,2,',','.'),1,0,'R');
$this->SetX(159);
$this->Cell(21,6,number_format($saldo_jasa,2,',','.'),1,0,'R');
$this->SetX(180);
$this->Cell(20,6,number_format($sumlainnya,2,',','.'),1,0,'R');
$this->Ln(4);


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
	$this->Cell(60,6,'Dilaporkan oleh,',0,0,'C');

	$this->Ln(17);
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
		$idp				=$_GET['idp'];
		$pinj		=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia  AND pi.id='$idp' "));

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
		$this->Cell(0,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->Cell(0,4,'Paraf : ............ | RKP '.$pinj['namadepan'].', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class

$idp				=$_GET['idp'];
$pinj		=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE a.id=pi.nia  AND pi.id='$idp' "));
		
$pdf = new PDF();
$pdf->SetTitle('REKENING KORAN PINJAMAN | '.strtoupper($pinj['namadepan']));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
