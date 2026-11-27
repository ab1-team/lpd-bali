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
		$this->Cell(85,0,strtoupper($_SESSION['lembaga_long']).' '.'('.($_SESSION['lembaga']).')',0,0,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->SetX(33);
		$this->Cell(85,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'L');
		
		$this->Ln(3.5);
		$this->SetFont('Arial','I',6);
		$this->SetX(33);
		$this->Cell(0,0,'Badan Hukum No.'.$row['nomor_bh'],0,0,'L');

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
		
		$row=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, usaha us, keluarga k,
                          anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
                                WHERE
                                b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
                                sa.id=pi.sistem_angsuran AND us.id=a.usaha AND
                                a.id=pi.nia AND pi.id='$idp'"));

		$id_pinj      =$row['id'];
		$jangka      =$row['jangka'];
		$sistem      	=$row['sistem'];
		$tempo		=$jangka/$sistem;
		$pros_jasa	=$row['pros_jasa'];
		$tgl_cair	=$row['tgl_cair'];
		$tanggal	= substr($tgl_cair,8,2);
		$nomor_bh 	=$row ['nomor_bh'];
            
		$dpr 		= explode("#", $row['data_proposal']);
		$dva 		= explode("#", $row['data_verifikasi_analis']);
		$dvb 		= explode("#", $row['data_verifikasi_bawas']);
		$dwt 		= explode("#", $row['data_waiting']);
		$jam 		= explode("#", $row['jaminan']);
		
		$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dpr[7]'"));
		$u=mysql_fetch_array(mysql_query("select * FROM users WHERE lokasi='$_SESSION[id]' AND level='1' AND jabatan='1'"));
				
		$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dvb[7]'"));
		
		$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$row[sa_jasa]'"));
		
		$tgl_lunas = date('Y-m-d', strtotime('+'.$jangka.' month', strtotime($tgl_cair)));
		
		
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
		$this->Cell(0,0,'SURAT PERJANJIAN KREDIT (SPK)',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'Nomor: '.$row['spk_no'].', Tanggal: '.tgl_ind($tgl_cair),0,0,'C');
		$this->Ln(5);
		
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Yang bertanda tangan di bawah ini :',0);
		$this->Ln(1);
		
		$this->SetX(22);
		$this->MultiCell(174,4,strtoupper("$u[namadepan] $u[namabelakang]").', '.($_SESSION['lembaga_long']).' '.'('.($_SESSION['lembaga']).')'.$row['sebutan_desa'].' '.$row['nama_desa'].' untuk dan  atas nama '.($_SESSION['lembaga_long']).' '.'('.($_SESSION['lembaga']).')'.$row['sebutan_desa'].' '.$row['nama_desa'].' yang dikukuhkan Gubernur Bali Nomor '.$nomor_bh.' selanjutnya  disebut pemberi kredit, memberikan kredit kepada '.strtoupper("$row[namadepan]").' Bertempat tinggal di '.strtoupper("$row[alamat]").' dalam hal ini bertindak untuk dan atas  nama dirinya sendiri, selanjutnya disebut pengambil kredit, dengan pasal-pasal perjanjian kredit sebagai berikut:',0);
		$this->Ln(0);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 1',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,$_SESSION['lembaga'].' memberikan Kredit kepada pengambil kredit sebesar Rp. '.number_format($row['alokasi'],0,",",".").' ('.ucwords(toTerbilang($row['alokasi'])).' Rupiah) yang digunakan untuk '.$tp['nama_tujuan'].'.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Kredit Diberikan dalam jangka waktu '.$row['jangka'].' bulan terhitung sejak tanggal '.tgl_indo($row['tgl_cair']).' dan harus lunas pada tanggal '.tgl_indo($tgl_lunas).' kredit diberikan untuk '.$tempo.' kali angsuran dengan  angsuran pokok '.$row['nama_sistem'].' ('.$row['deskripsi_sistem'].') sebesar Rp. '.number_format(wajibpokokaja($id_pinj),0,",",".").' ('.ucwords(toTerbilang(wajibpokokaja($id_pinj))).' Rupiah) ditambah bunga.',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 2',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Atas kredit tersebut kepada Pengambil Kredit dikenakan Bunga sebesar Rp. '.number_format(wajibjasaaja($id_pinj),0,",",".").' ('.ucwords(toTerbilang(wajibjasaaja($id_pinj))).' Rupiah) atau setara '.$pros_jasa.' % per bulan '.$jj['nama_jj'].' ('.$jj['deskripsi_jj'].'), yang harus dibayar setiap tanggal '.$tanggal.' ('.ucwords(toTerbilang($tanggal)).').',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil Kredit juga dikenakan biaya administrasi kredit atau tata usaha 3% dari plapon kredit yang dibayar pada saat realisasi kredit.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil kredit tabungan wajib sebesar 0% dari plapon kredit yang dibayar pada saat Realisasi Kredit.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil Kredit dikenakan Denda sebesar 5 % per bulan atas keterlambatan pembayaran angsuran pokon dan / atau bunga yang dihitung  dari besarnya tunggakan.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'5.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil kredit dikenakan materai secukupnya.',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 3',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Untuk menjamin pembayaran kredit kembali termasuk bunga dan denda serta biaya lainnya yang akan dibebankan oleh '.$_SESSION['lembaga'].', maka pengambil kredit  dengan ini menyerahkan barang jaminan berupa '.$jam[1].', dan apabila dirasa kurang, maka hak milik pengambil kredit yang ada maupun yang akan ada wajib mejadi jaminan yang akan dikaitkan dengan saksi dan/atau sanksi awig-awig '.$row['sebutan_desa'].' '.$row['nama_desa'].'yang berlaku.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengikat barang jaminan dilakukan sesuai dengan ketentuan yang berlaku dan memerlukan lampiran yang tidak dapat dipisahkan dari perjanjian ini.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Selama kredit belum dilunasi maka barang jaminan yang diserahkan dilarang dijual atau dialihkan atau dipindahkan kepihak baru.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil kredit memberi kuasa memotong gaji kepada bendahara kantor dimana pengambilan kredit bekerja guna melunasi kewajibannya. Kuasa mana akan ditandatangani sendiri dan merupakan bagian terpenting yang tak terpisahkan dari perjanjian ini.',0);
		$this->Ln(0);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 4',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Selama kredit berjalan barang-barang jaminan bila dianggap perlu diasuransikan oleh penerima kredit pada maskapai angsuran yang ditunjukan dan disetujui oleh '.$_SESSION['lembaga'].' dengan syarat-syarat bankers/'.$_SESSION['lembaga'].' Clausula.',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 5',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,$_SESSION['lembaga'].'berhak menagih hutang (kredit) ini atau sisanya berikut bunga maupun biaya administrasi / tata usaha dengan seketika dan sekaligus atas kekuatan perjanjian kredit itu apabila :',0);
		$this->Ln(4);
		
		$this->SetX(25);
		$this->Cell(4,4,'1.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil kredit melakukan kewajiban-kewajiban membayar angsuran-angsuran pokok bunga dan biaya administrasi kredit/ tata usaha.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'2.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Pengambil kredit meninggal dunia kecuali para ahli waris dari yang  meninggal itu dapat memenuhi kewajibannya.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'3.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Jika kekayaan pengambil kredit seluruhnya atau sebagian disita orang lain.',0);
		$this->Ln(0);
		
		$this->SetX(25);
		$this->Cell(4,4,'4.',0,0,'L');
		$this->SetX(29);
		$this->MultiCell(167,4,'Jika pengambil kredit menurut pertimbangan '.$_SESSION['lembaga'].' tidak atau tidak cukup memenuhi peraturan yang ditetapkan dalam perjanjian itu.',0);
		$this->Ln(0);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(174,4,'PASAL 6',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->MultiCell(174,4,'Dan segala akibat yang mungkin timbul dikemudian hari atas perjanjian ini kedua belah pihak sepakat menyelesaikan melalui Paruman '.$row['sebutan_desa'].' '.$row['nama_desa'].' dan/memilih tempat (domisili) penyelesaian yang tidak dapat diubah pada kantor Pengadilan Negeri di Denpasar pemilihan mana yang berlaku pula untuk ahli waris Pengambil kredit.',0);
		$this->Ln(2);
		
		$this->SetX(22);
		$this->MultiCell(174,4,'Demikian perjanjian kredit ini dibuat dan ditanda tangani di '.$row['sebutan_desa'].' '.$row['nama_desa'].' pada tanggal '.tgl_indo($row['tgl_cair']).'.',0);
		$this->Ln(5);
		
		
		
		
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
		
		$this->SetX(22);
		$this->Cell(57,0,'Kepala,',0,0,'C');
		$this->SetX(79);
		$this->Cell(57,0,'Penanggung/'.$row['kekeluargaan'].',',0,0,'C');
		$this->SetX(136);
		$this->Cell(57,0,'Debitur/Peminjam,',0,0,'C');
		$this->Ln(18);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(57,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->SetX(79);
		$this->Cell(57,0,strtoupper($row['penjamin']),0,0,'C');
		$this->SetX(136);
		$this->Cell(57,0,strtoupper("$row[namadepan]"),0,0,'C');
		$this->Ln(10);

		
			
	
		
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
		$this->Cell(0,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By abt.co.id',0,0,'L');
		$this->Cell(0,4,'Paraf : ............ | Perjanjian Kredit, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('SURAT PERJANJIAN KREDIT (SPK)');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
