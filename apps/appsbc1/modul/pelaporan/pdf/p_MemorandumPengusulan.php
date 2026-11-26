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
		
		if(preg_match("/Tanah/i", $jam[1])) { $cef ="75"; }else{ $cef ="50"; }
		
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
		$this->Cell(0,0,'MEMORANDUM PENGUSULAN KREDIT',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'Nomor: '.$nomor.', Tanggal: '.tgl_ind($dva[0]),0,0,'C');
		$this->Ln(7);
		
		
		//Garis Garis
		//$this->SetLineWidth(0.2);
		$this->Line(76,45,195,45);
		$this->Line(76,51,195,51);
		$this->Line(76,57,195,57);
		$this->Line(76,63,195,63);
		$this->Line(76,69,195,69);
		$this->Line(76,75,195,75);
		$this->Line(76,81,195,81);
		
		
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'A. DATA PEMOHON',0,0,'L');
		$this->Ln(6);
		
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
		$this->Cell(48,0,'5. Besarnya Permohonan Kredit',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Rp. '.number_format($dpr[1],0,",","."),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'6. Tujuan Permohonan',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($tp['nama_tujuan']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'7. Nilai Scrore ',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(10);
		
		
		//Garis garis
		$this->Line(76,107,195,107);
		$this->Line(76,113,195,113);
		$this->Line(76,119,195,119);
		$this->Line(76,125,195,125);
		$this->Line(76,131,195,131);
		$this->Line(76,137,195,137);
		$this->Line(76,143,195,143);
		$this->Line(76,149,195,149);
		$this->Line(76,155,195,155);
		$this->Line(76,161,195,161);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'B. REKOMENDASI ANALISA/BAGIAN KREDIT ',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(26);
		$this->MultiCell(170,4,'Berdasarkan data tersebut diatas dan hasil analisa permohonan kredit terlampir, maka kami mengusulkan untuk diberikan kredit dengan ketentuan sebagai berikut:',0);
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  1. Maksimum Kredit',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Rp. '.number_format($dva[1],0,",","."),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  2. Suku Bunga',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$dva[3].' %',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  3. Jenis Bunga',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($jj['nama_jj']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  4. Jangka Waktu',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$dva[2].' BULAN',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  5. Sistem Pembayaran Pokok',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($sp['nama_sistem']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  6. Sistem Pembayaran Bunga',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($sj['nama_sistem']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  7. Biaya Administrasi',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,$dpr[8].'% x Rp. '.number_format($dvb[1],0,",",".").' = Rp. '.number_format($dvb[1]*$dpr[8]/100,0,",","."),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  8. Tujuan Penggunaan Kredit',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($tp['nama_tujuan']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'  9. Nilai Jaminan',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Rp. '.number_format($dva[9],0,",","."),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'10. Syarat Lainnya',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'',0,0,'L');
		$this->Ln(8);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'C. ASPEK JAMINAN',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->MultiCell(169,4,'Jenis Jaminan: '.$jam[1].'. Pengikatan : Dibawah Tangan. Nilai Pasar : '.number_format($jam[0],0,",",".").' CEF : '.$cef.'%. CEV : '.number_format($jam[0]*$cef/100,0,",","."),0);
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'D. CATATAN ANALIS',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',9);
		$this->SetX(26);
		$this->MultiCell(170,4,$dva[10].'.',0);
		$this->Ln(6);
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='4' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
		
		$this->SetX(110);
		$this->Cell(85,0,$row['nama_desa'].', '.tgl_indo($dva[0]),0,0,'C');
		$this->Ln(4);
		
		$this->SetX(110);
		$this->Cell(85,0,'Analis Kredit,',0,0,'C');
		$this->Ln(18);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(110);
		$this->Cell(85,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->Ln(8);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'E. VERIFIKASI/KEPUTUSAN KEPALA LPD',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',9);
		$this->SetX(26);
		$this->MultiCell(170,4," ",0);
		$this->Ln(20);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'F. VERIFIKASI/KEPUTUSAN BADAN PENGAWAS',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',9);
		$this->SetX(26);
		$this->MultiCell(170,4," ",0);
		$this->Ln(4);

		
		//$this->MultiCell(170,4,tgl_ind($dvk[0]).': Menyetujui pembiayaan tersebut diatas sebesar Rp.'.number_format($dvk[1],0,',','.').' dengan jangka waktu '.$dvk[2].' Bulan, dan jasa '.$dvk[3].'% per Bulan, dengan catatan : '.$dvk[10].'.',0);
		//$this->MultiCell(170,4,tgl_ind($dvb[0]).': Menyetujui pembiayaan tersebut diatas sebesar Rp.'.number_format($dvb[1],0,',','.').' dengan jangka waktu '.$dvb[2].' Bulan, dan jasa '.$dvb[3].'% per Bulan, dengan catatan : '.$dvb[10].'.',0);
			
	
		
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
		$this->Cell(0,5,'Paraf : ............ | Memorandum Kredit, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('MEMORANDUM PENGUSULAN KREDIT');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
