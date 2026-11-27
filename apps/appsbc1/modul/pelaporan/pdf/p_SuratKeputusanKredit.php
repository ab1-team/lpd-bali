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
		$pend 		= explode("#", $row['pendapatan']);            
		$biaya 		= explode("#", $row['biaya']);            
		$aktiva 	= explode("#", $row['aktiva']);            
		$pasiva 	= explode("#", $row['pasiva']);            
		$dpr 		= explode("#", $row['data_proposal']);
		$dva 		= explode("#", $row['data_verifikasi_analis']);
		$dvk 		= explode("#", $row['data_verifikasi_kepala']);
		$dvb 		= explode("#", $row['data_verifikasi_bawas']);
		$jam 		= explode("#", $row['jaminan']);
		
		
		$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dpr[7]'"));
		$u=mysql_fetch_array(mysql_query("select * FROM users WHERE lokasi='$_SESSION[id]' AND level='1' AND jabatan='4'"));
		
		$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$dva[4]'"));			
		$sp=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dva[5]'"));			
		$sj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dva[6]'"));			
		$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dva[7]'"));
		
		
		if($idp<9){$nomor="000$idp";}else if($idp<99){$nomor="00$idp";}else if($idp<999){$nomor="0$idp";}else{$nomor="$idp";}
		
//Fields Name position
$Y_Fields_Name_position = 25;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);


//judul
		$this->SetFont('Arial','U',14);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'SURAT KEPUTUSAN KREDIT',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'Nomor: '.$nomor.', Tanggal: '.tgl_ind($dvk[0]),0,0,'C');
		$this->Ln(15);
		
		
		//Garis Garis
		//$this->SetLineWidth(0.2);
		$this->Line(76,81,195,81);
		$this->Line(76,87,195,87);
		$this->Line(76,93,195,93);
		$this->Line(76,99,195,99);
		$this->Line(76,105,195,105);
		$this->Line(76,111,195,111);
		$this->Line(76,117,195,117);
		$this->Line(76,123,195,123);
		$this->Line(76,129,195,129);
		$this->Line(76,135,195,135);
		$this->Line(76,141,195,141);
		
		//Garis Syarat28
		$this->Line(30,169,195,169);
		$this->Line(30,174,195,174);
		
		$this->Line(30,195,195,195);
		$this->Line(30,200,195,200);
		$this->Line(30,225,195,225);
		
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(130);
		$this->Cell(65,0,'KEPADA YTH.',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(130);
		$this->Cell(65,0,strtoupper("$row[namadepan]"),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(130);
		$this->Cell(65,0,strtoupper($row['alamat']),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(130);
		$this->Cell(65,0,strtoupper($row['hp']),0,0,'L');
		$this->Ln(10);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Merujuk Memorandum Pengusulan Kredit saudara, nomor : '.$nomor.' tanggal '.tgl_ind($dva[0]).' bersama ini kami beritahukan bahwa permohonan kredit saudara telah kami setujui dengan ketentuan dan syarat sebagai berikut:',0);
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'1. Nama Pemohon',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper("$row[namadepan]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'2. NIK',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$row['nik'],0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'3. Tempat, Tanggal Lahir',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['tempat_lahir']).', '.strtoupper(tgl_indo($row['tgl_lahir'])),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'4. Alamat Pemohon',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['alamat']).', '.$row['hp'],0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'5. Pekerjaan/Usaha',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['nama_usaha']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'6. Maksimum Kredit',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Rp. '.number_format($dvk[1],0,",","."),0,0,'L');
		$this->Ln(6);
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'7. Jangka Waktu',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$dvk[2].' BULAN',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'8. Tujuan Permohonan',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($tp['nama_tujuan']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'9. Suku Bunga',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$row['pros_jasa'].'%',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'10. Biaya Administrasi',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$dpr[8].'% x Rp. '.number_format($dva[1],0,",",".").' = Rp. '.number_format($dva[1]*$dpr[8]/100,0,",","."),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'11. Pengikatan',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Dibawah tangan',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Syarat-syarat penandatanganan perjanjian kredit :',0);
		$this->Ln(2);
		
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Telah menyetujui dengan menandatangani SKK, dan menyerahkan kembali kepada '.LEMBAGA_SORT.' '.$row['sebutan_desa'].' '.$row['nama_desa'].'.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Asli surat-surat barang jaminan  diserahkan kepada '.LEMBAGA_SORT.'.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Perjanjian Kredit dibuat dibawah  tangan.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'5.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Syarat penarikan kredit :',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Perjanjian Kredit telah ditanda tangani oleh Debtur dan kepala '.LEMBAGA_SORT.'.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengikatan jaminan telah dilengkapi.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Syarat-syarat lainnya :',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Tidak diperbolehkan menggunakan kredit menyimpang dari tujuan yang telah ditetapkan semula sepeti yang dicantumkan dalam yang dicantumkan dalam butir 8 diatas.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Tunduk kepada peraturan-peraturan yang telah dan akan ditetapkan oleh '.LEMBAGA_SORT.' '.$row['sebutan_desa'].' '.$row['nama_desa'].'.',0);
		$this->Ln(1);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(174,4,'',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Demikian agar saudara maklum dan sebagai persetujuan atas ketentuan tersebut diatas diharapkan kepada saudara untuk menandatangani tebusan / lembar keduanya dan mengirimkan / menyampaikan kepada '.LEMBAGA_SORT.' '.$row['sebutan_desa'].' '.$row['nama_desa'].' selambatnya 3 (tiga) hari kerja setelah tanggal pengiriman.',0);
		$this->Ln(5);
		
		
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
		
		
		$this->SetX(110);
		$this->Cell(85,0,$row['nama_desa'].', '.tgl_indo($dva[0]),0,0,'C');
		$this->Ln(4);
		
		$this->SetX(25);
		$this->Cell(85,0,LEMBAGA_SORT.' '.$row['sebutan_desa'].' '.$row['nama_desa'],0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,'Menyetujui syarat-syarat diatas',0,0,'C');
		$this->Ln(4);
		
		$this->SetX(25);
		$this->Cell(85,0,'Kepala,',0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,'Debitur/Peminjam,',0,0,'C');
		$this->Ln(18);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(25);
		$this->Cell(85,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,strtoupper("$row[namadepan]"),0,0,'C');
		$this->Ln(8);

		
			
	
		
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
		$this->Image('../../../images/logo_bumdes.png',114,276,12,0);
		$this->Cell(0,5,'Paraf : ............ | Keputusan Kredit, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('SURAT KEPUTUSAN KREDIT');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
