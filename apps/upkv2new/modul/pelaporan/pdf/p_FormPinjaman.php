<?php session_start();
ini_set('display_errors',1);
ob_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
//include "../../../inc/fungsi_simpanan_individu.php";
include "../../../inc/fungsi_pinjaman_individu.php";


define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=landscape

class PDF extends FPDF
{ 
	//Page header
	function Header()
	{
		$idp=$_GET['idp'];
        $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c where b.id=c.kd_kab and c.id='$_SESSION[lokasi]' "));
        
		//Logo
		$logo=$row['logo'];
        if (empty($logo)) {
        $this->Image('../../../images/upk.png',21,8,12,0);
        }else{
        $this->Image('../../../images/logo/'.$logo,21,8,12,0);
        }
		
		//Arial bold 15
		$this->SetTextColor(128,128,128);
		$this->SetFont('Arial','',9);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper($row['nama_lembaga_long']),0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper($row['nama_lembaga_sort']).' '.strtoupper($row['nama_kec']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);
		$this->Cell(0,0,'SK Kemenkumham RI No.'.$row['nomor_bh'],0,0,'L');

		$this->SetFont('Arial','I',6);
		$this->SetX(105);
		$this->Cell(95,0,$row['alamat_kec'].', Telp.' .$row['telpon_kec'],0,0,'R');
		$this->Ln(5);

		//buat garis horisontal
		$this->SetLineWidth(0.4);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		$this->Ln(5);
	
		
	}
	

	
	//Page Content
	function Content()
	{
	    
        //judul
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'FORMULIR PERMOHONAN KREDIT',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->Cell(0,0,'Nomor : ...... , Tanggal : ............',0,0,'C');
		$this->Ln(7);
		
		//buat garis horisontal
// 		$this->SetLineWidth(0.4);
// 		$this->SetDrawColor(128,128,128); //warna
// 		$this->Line(22,40,200,40);
// 		$this->Ln(3);
	
		// DATA PRIBADI PEMOHON
		$this->Ln(5);
	    $this->SetFont('Arial','B',10);
	    $this->SetX(22);
		$this->Cell(0,0,'I. DATA PRIBADI PEMOHON',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Nomor Identitas',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Nama Lengkap',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Maulida',0,0,'L');
		$this->SetX(112);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Jenis Kelamin *)',0,0,'L');
		$this->SetX(144);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(146);
		$this->Cell(33,0,'Laki-laki / Perempuan',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Tempat, Tgl Lahir',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Usia',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'_____ Tahun',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Status Pernikahan',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Menikah',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Jumlah Tanggungan',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Nama Ibu Kandung',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Alamat Domisili Sekarang',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,' ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Desa/Kelurahan',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'- Kode Pos',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Kecamatan',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'- Lama Tinggal',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Kota/Kabupaten',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
        
        $this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Status Domisili *)',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Pribadi / Keluarga / Sewa / Dinas',0,0,'L');
		$this->Ln(5);

		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'No. Telp Pemohon',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Pendidikan Terakhir',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Pekerjaan/Jabatan',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Nomor NPWP',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Untuk keperluan mendadak hubungi (keluarga dekat yang tidak serumah)',0,0,'L');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Nama',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'- Hubungan',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Alamat',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'- No. Telp',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
	//PERMOHONAN KREDIT
		$this->SetLineWidth(0.4);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(22,140,200,140);
		$this->Ln(3);
		
		$this->Ln(5);
	    $this->SetFont('Arial','B',9);
		$this->Cell(0,0,'PERMOHONAN KREDIT',0,0,'C');
		$this->Ln(9);
	    
	    $this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Permohonan Kredit',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Rp. ',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Jangka Waktu',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'____ bulan',0,0,'L');
		$this->Ln(5);
	
	    
	    $this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Sifat Pengajuan *)',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Pemula / Berkembang / Mandiri',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Keperluan Kredit *)',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Modal Usaha / Pengadaan Barang / Investasi / Lainnya',0,0,'L');
		$this->SetX(109);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'- Keterangan',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->Ln(5);
		
		//DATA USAHA
		
		$this->SetLineWidth(0.4);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(22,178,200,178);
		$this->Ln(3);
		
		$this->Ln(5);
	    $this->SetFont('Arial','B',9);
		$this->Cell(0,0,'DATA USAHA',0,0,'C');
		$this->Ln(9);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Jenis Kegiatan *)',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'Aneka Jasa / Perdagangan / Aneka Industri / Pertanian / Peternakan / Pertanian',0,0,'L');
		$this->SetX(109);
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->Cell(33,0,'Nama Usaha',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Mulai Usaha',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Bidang Usaha',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Pendapatan',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'Alamat Usaha',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->SetFont('Arial','',9);
		$this->Cell(33,0,'Beban Kredit',0,0,'L');
		$this->SetX(142);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(144);
		$this->Cell(33,0,'',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(33,0,'No. Telp Usaha',0,0,'L');
		$this->SetX(58);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(60);
		$this->Cell(33,0,'',0,0,'L');
		$this->SetX(109);
		$this->Ln(5);
		
	}

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),285,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->Cell(0,5,'Dicetak oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A'),0,0,'L');
		$this->Cell(0,5,'Paraf ............... | Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
ob_end_clean();
//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Formulir Pinjaman');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
