<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		

$ids				=$_GET['ids'];
$lokasi				=$_SESSION['lokasi'];

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		$simp=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si WHERE a.id=si.nia AND si.id='$ids' "));

		$nia		=$simp['nia'];
		$nik		=$simp['nik'];
		if($nia<9){$cif="000$nia";}else if($nia<99){$cif="00$nia";}else if($nia<999){$cif="0$nia";}else{$cif="$nia";}

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
		$this->Ln(5);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','U',11);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'REKENING KORAN SIMPANAN UMUM',0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(30,0,'Nomor Rekening',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->SetX(52);
		$this->Cell(60,0,$simp['nomor_rekening'],0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(30,0,'Nama Kreditur',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->SetX(52);
		$this->Cell(60,0,strtoupper($simp['namadepan']),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(30,0,'NIK / CIF',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->SetX(52);
		$this->Cell(60,0,substr($nik,0,4).' '.substr($nik,4,4).' '.substr($nik,8,4).' '.substr($nik,12,4).' / '.$cif,0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(30,0,'Alamat',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->SetX(52);
		$this->Cell(60,0,$simp['alamat'],0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(30,0,'Telpon/HP',0,0,'L');
		$this->SetX(50);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->SetX(52);
		$this->Cell(60,0,$simp['hp'],0,0,'L');
		
		
//QR-Code
$qrcode="../../../images/qrcode/$simp[nia].png";
if(file_exists($qrcode)){
	$this->Image($qrcode,175,25,20,0);
}else{
	//Membuat QR-Code
$tempdir = "../../../images/qrcode/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
	mkdir($tempdir);
	
		$isi_teks = $simp['nik'];
		$namafile = $simp['nia'].".png";
		$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 3;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
		
	$this->Image($qrcode,175,25,20,0);
}
		
//Fields Name position
$Y_Fields_Name_position = 48;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(7,7,'No',1,0,'C',1);
$this->SetX(27);
$this->Cell(16,7,'Tanggal',1,0,'C',1);
$this->SetX(43);
$this->Cell(22,7,'Ref',1,0,'C',1);
$this->SetX(65);
$this->Cell(60,7,'Keterangan',1,0,'C',1);
$this->SetX(125);
$this->Cell(22,7,'Debit',1,0,'C',1);
$this->SetX(147);
$this->Cell(22,7,'Kredit',1,0,'C',1);
$this->SetX(169);
$this->Cell(25,7,'Saldo',1,0,'C',1);
$this->SetX(194);
$this->Cell(6,7,'P',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{
		
$ids				=$_GET['ids'];
$table_transaksi	="transaksi_$_SESSION[lokasi]";
$table_rekening		="rekening_$_SESSION[lokasi]";

$rekSU=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));

$text	= "SELECT * FROM $table_transaksi WHERE rekening_debit='$rekSU[kd_rekening]_$ids' OR rekening_kredit='$rekSU[kd_rekening]_$ids' ORDER BY tgl_transaksi  ";
$sql 	= mysql_query($text);
$rows	= mysql_num_rows($sql);

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		$simp=mysql_fetch_array(mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[lokasi] where id='$ids' "));

		$no=0;
									while($row=mysql_fetch_array($sql)){
									$no=$no+1;

										if(rek($row['rekening_kredit'])==$rekSU['kd_rekening']) {
											$debit	="0";
											$kredit	=$row['jumlah'];
										}elseif(rek($row['rekening_debit'])==$rekSU['kd_rekening']) {
											$debit	=$row['jumlah'];
											$kredit	="0";
											}
											
									$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));	
			$prasaldo=$kredit-$debit; $saldosamping=$saldosamping+$prasaldo;
		
		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetX(20);
		$this->Cell(7,4,$no,1,0,'C');
		$this->SetX(27);
		$this->Cell(16,4,tgl_ind($row['tgl_transaksi']),1,0,'C');
		$this->SetX(43);
		$this->Cell(22,4,$row['idt'],1,0,'C');
		$this->SetX(65);
		$this->Cell(60,4,$row['keterangan_transaksi'],1,0,'L');
		$this->SetX(125);
		$this->Cell(22,4,number_format($debit,2,',','.'),1,0,'R',1);
		$this->SetX(147);
		$this->Cell(22,4,number_format($kredit,2,',','.'),1,0,'R',1);
		$this->SetX(169);
		$this->Cell(25,4,number_format($saldosamping,2,',','.'),1,0,'R',1);
		$this->SetX(194);
		$this->Cell(6,4,$r['ins'],1,0,'C',1);
		$this->Ln(4);
		
		$tgl_kondisi	=date('Y-m-d');
		$sumdebit	=$sumdebit+$debit;
		$sumkredit	=$sumkredit+$kredit;
		$saldoo=saldosimpanan("$tgl_kondisi-$ids");
		}

		
//JUMLAH BAWAH	
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(105,6,'T O T A L',1,0,'C');
$this->SetX(125);
$this->Cell(22,6,number_format($sumdebit,2,',','.'),1,0,'R');
$this->SetX(147);
$this->Cell(22,6,number_format($sumkredit,2,',','.'),1,0,'R');
$this->SetX(169);
$this->SetFillColor(232,232,232);
$this->Cell(31,6,number_format($saldoo,2,',','.'),1,0,'C',1);

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
		$ids				=$_GET['ids'];
		$simp=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si WHERE a.id=si.nia AND si.id='$ids' "));

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
		$this->Cell(0,4,'Paraf : ............ | RKU '.$simp['nomor_rekening'].' '.$simp['namadepan'].', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class

$ids				=$_GET['ids'];
$simp=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si WHERE a.id=si.nia AND si.id='$ids' "));
		
$pdf = new PDF();
$pdf->SetTitle('RKU '.$simp['nomor_rekening'].' '.$simp['namadepan']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
