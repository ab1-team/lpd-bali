<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/fpdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{							
		//Kotak
		$this->SetLineWidth(0.8);
		$this->Rect(25, 15, 170, 260);
		$this->Rect(25, 243, 170, 32);

	}
	
	//Page Content
	function Content()
	{
		
	
	//$this->SetLineWidth(0.8);
	$this->Line(55,145,165,145);
	$this->Line(55,174,165,174);
	$this->Line(55,197,165,197);
			
	$idp=$_GET['idp'];
	$row=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id='$idp'"));
	
	$id=$row['id'];
	if($id<9){$lid="000$id";}else if($id<99){$lid="00$id";}else if($id<999){$lid="0$id";}else{$lid="$id";}
	$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
		
		//Logo 
		//$this->Image('../../../images/logo/'.$logo,90,50,40,0);
		
		//QR-Code
		//$qrcode="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$row[nik].png";

		//$this->Image($qrcode,95,202,30,0);

		
		$this->Ln(35);
		$this->SetFont('Arial','B',20);
		$this->SetX(20);
		$this->Cell(0,100,'DOKUMEN PENCAIRAN',0,0,'C');
		$this->Ln(7);
		
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,'SPK No. '.$row['spk_no'],0,0,'C');
		$this->Ln(6);
		$this->SetX(20);
		$this->Cell(0,100,'Tanggal: '.tgl_ind($row['tgl_cair']),0,0,'C');
		$this->Ln(25);
		
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,'Nama Debitur : ',0,0,'C');
		$this->Ln(9);
		
		$this->SetFont('Arial','B',16);
		$this->SetX(20);
		$this->Cell(0,100,strtoupper($row['namadepan']),0,0,'C');
		$this->Ln(6);
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,substr($row['nik'],0,4).' '.substr($row['nik'],4,4).' '.substr($row['nik'],8,4).' '.substr($row['nik'],12,4),0,0,'C');
		$this->Ln(14);
		
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,'Alamat : ',0,0,'C');
		$this->Ln(9);
		
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,strtoupper($row['alamat']).', '.$row['hp'],0,0,'C');
		$this->Ln(14);
		
		$this->SetFont('Arial','',14);
		$this->SetX(20);
		$this->Cell(0,100,'Alokasi : ',0,0,'C');
		$this->Ln(9);
		
		$this->SetFont('Arial','',16);
		$this->SetX(20);
		$this->Cell(0,100,'Rp. '.number_format($row['alokasi'],0,',','.'),0,0,'C');
		$this->Ln(60);
		
		$this->SetFont('Arial','',10);
		$this->SetX(20);
		$this->Cell(0,60,'Loan ID. '.$lid,0,0,'C');
		$this->Ln(0);
		
		


	
		
	}

	//Page footer
	function Footer()
	{
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

		//Arial bold 15
		
			
		$this->SetY(-44);
		$this->SetFont('Arial','',12);
		$this->SetX(20);
		$this->Cell(0,0,strtoupper($_SESSION['lembaga_long']).' '.'('.($_SESSION['lembaga']).')',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->SetX(20);
		$this->Cell(0,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'C');
		
		$this->Ln(4);
		$this->SetFont('Arial','I',7);
		$this->SetTextColor(120,120,120);
		$this->SetX(20);
		$this->Cell(0,0,'Badan Hukum No.'.$row['nomor_bh'].', '.$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'C');
		$this->Ln(1);
		
		$this->SetX(20);
		$this->Cell(0,5,'Tahun '.date('Y'),0,0,'C');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Cover Laporan '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
