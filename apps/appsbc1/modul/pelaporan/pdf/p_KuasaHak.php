<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../inc/fungsi_pinjaman_individu.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		
    $idp=$_GET['idp'];
    $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

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
		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.4);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
	
	}
	
	//Page Content
	function Content()
	{
		
		$idp=$_GET['idp'];
		
		$row=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
                          anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
                                WHERE
                                b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
                                sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
                                a.id=pi.nia AND pi.id='$idp'"));

		$id_pinj      =$row['id'];

		$jam 		= explode("#", $row['jaminan']);
		
		$u=mysql_fetch_array(mysql_query("select * FROM users WHERE lokasi='$_SESSION[id]' AND level='1' AND jabatan='1'"));

		
		
		if($idp<9){$nomor="000$idp";}else if($idp<99){$nomor="00$idp";}else if($idp<999){$nomor="0$idp";}else{$nomor="$idp";}
		if(preg_match("/Tanah/i", $jam[1])) { $dokumen ="DOKUMEN SERTIFIKAT HAK MILIK (SHM): "; }
		else if(preg_match("/Kendaraan/i", $jam[1]) OR preg_match("/Motor/i", $jam[1])) { $dokumen ="DOKUMEN BUKU PEMILIK KENDARAAN BERMOTOR (BPKB): "; }
		
//Fields Name position
$Y_Fields_Name_position = 30;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);


//judul
		$this->SetFont('Arial','U',14);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'SURAT KUASA PEMINDAHAN HAK',0,0,'C');
		$this->Ln(20);
		
		
		//Garis Garis
		//$this->SetLineWidth(0.2);
		$this->Line(76,60,195,60);
		$this->Line(76,66,195,66);
		$this->Line(76,72,195,72);
		$this->Line(76,78,195,78);
		$this->Line(76,84,195,84);
		
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Yang bertanda tangan di bawah ini saya:',0);
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->Cell(48,0,'1.',0,0,'L');
		$this->SetX(30);
		$this->Cell(48,0,'Nama Lengkap',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'NIK',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Tempat, Tanggal Lahir',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Alamat Pemohon',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Pekerjaan/Usaha',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->MultiCell(174,4,'Yang selanjutnya di sebut PIHAK PERTAMA.',0);
		$this->Ln(5);
	//Pihak Kedua
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->Cell(48,0,'2.',0,0,'L');
		$this->SetX(30);
		$this->Cell(48,0,'Nama Lengkap',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper("$row[namadepan]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'NIK',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$row['nik'],0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Tempat, Tanggal Lahir',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['tempat_lahir']).', '.strtoupper(tgl_indo($row['tgl_lahir'])),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Alamat Pemohon',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['alamat']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->Cell(48,0,'Pekerjaan/Usaha',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['nama_usaha']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(30);
		$this->MultiCell(174,4,'Yang selanjutnya di sebut PIHAK KEDUA.',0);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,5,'Dimana kami Pihak Pertama memberikan Kuasa Penuh kepada Pihak Kedua atas harta kami yang sah dan tidak bersangkutan suatu perkara /hutang piutang kepada Pihak Ketiga, untuk jaminan atas kredit dari Pihak Kedua pada Lembaga Perkreditan Desa Adat Cengkok dan tidak di cabut kembali sebelum pinjaman kredit Pihak Kedua dilunasi.',0);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Adapun harta benda kami yang dikuasakan seperti tersebut di bawah ini:',0);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
	    $this->SetX(22);
		$this->MultiCell(174,4,$dokumen .strtoupper($jam[1]),0);
		$this->Ln(4);
		
	
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Demikian surat kuasa menjual ini saya buat untuk dapat digunakan sebagaimana mestinya.',0);
		$this->Ln(7);
		
		
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
		
		
		$this->SetX(110);
		$this->Cell(85,0,$row['nama_desa'].', '.tgl_indo(date('Y-m-d')),0,0,'C');
		$this->Ln(6);
		
		$this->SetX(25);
		$this->Cell(85,0,'Penerima Kuasa / Pihak Kedua',0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,'Pemberi Kuasa / Pihak Pertama',0,0,'C');
		$this->Ln(25);
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(85,0,strtoupper("$row[namadepan]"),0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,'__________________________',0,0,'C');
		$this->Ln(7);

		
		$this->SetFont('Arial','',9);
		$this->SetX(65);
		$this->Cell(85,0,'Mengetahui/Mengesahkan',0,0,'C');
		$this->Ln(4);
		$this->SetX(65);
		$this->Cell(85,0,'Kepala LPD Desa Adat Cengkok',0,0,'C');
		$this->Ln(20);
		$this->SetX(65);
		$this->Cell(85,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->Ln(2);
	
		
	}

	//Page footer
	function Footer()
	{
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
		$this->Cell(0,5,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->Image('../../../images/logo_simlpd.png',114,276,12,0);
		$this->Cell(0,5,'Paraf : ............ | Kuasa Menjual, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('SURAT KUASA MENJUAL');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
