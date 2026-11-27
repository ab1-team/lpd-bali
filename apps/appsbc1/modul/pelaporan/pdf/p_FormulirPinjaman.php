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
		
		$row=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, level l, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
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
		$jam 		= explode("#", $row['jaminan']);
		
		
	$tot_pend	=$pend[0]+$pend[1]+$pend[2];
	$tot_biaya	=$biaya[0]+$biaya[1]+$biaya[2]+$biaya[3]+$biaya[4]+$biaya[5]+$biaya[6]+$biaya[7];
	$surplus	=$tot_pend-$tot_biaya;
	
	
	  $tot_akt=$aktiva[0]+$aktiva[1]+$aktiva[2]+$aktiva[3]+$aktiva[4]+$aktiva[5];
	  $tot_kwj=$pasiva[0]+$pasiva[1]+$pasiva[2];
	  $sur_nrc=$tot_akt-$tot_kwj;
	  $tot_pas=$tot_kwj+$sur_nrc;
		
		$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dpr[7]'"));
		
		$tgl_analis	=$dva[0];
		$SaldoSimpananName	=SaldoSimpananName("$tgl_analis-$row[nia]");
		$SaldoPinjamanName	=SaldoPinjamanName("$tgl_analis-$row[nia]");
		
		
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
		$this->Cell(0,0,'FORMULIR PERMOHONAN PINJAMAN',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->Cell(0,0,'Nomor: ______  , Tanggal: ___________________',0,0,'C');
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
		$this->Line(76,87,195,87);
		$this->Line(76,93,195,93);
		$this->Line(76,107,195,107);
		$this->Line(76,113,195,113);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'I. ASPEK UMUM',0,0,'L');
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
		$this->Cell(60,0,'                                      ,  ',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'4. Alamat Pemohon',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'                                                                                   , Telp. ',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'5. Pekerjaan/Dinas/Instansi',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($row['nama_usaha']),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'6. Nama Penjamin',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'                                                                              ,Hub. Kekeluargaan : ',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'7. NIK/No.KK Penjamin',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'                                                           /   ',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'8. Permohonan Kredit',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,'Rp. ',0,0,'L');
		
		$this->SetFont('Arial','',9);
		$this->SetX(140);
		$this->Cell(20,0,'Jangka Waktu : ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(160);
		$this->Cell(30,0,$dpr[2].' Bulan',0,0,'C');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'9. Tujuan Permohonan',0,0,'L');
		$this->SetX(73);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(75);
		$this->Cell(60,0,strtoupper($tp['nama_tujuan']),0,0,'L');
		$this->Ln(8);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'II. HUBUNGAN DENGAN BANK/'.$_SESSION['lembaga'].'',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'1. Tabungan/Giro/Deposito',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp. ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(76);
		$this->Cell(34,0,'',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(85,0,'(Berdasarkan Rekap Data Tanggal '.tgl_indo($tgl_analis).')',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,'2. Kredit Pinjaman',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp. ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(76);
		$this->Cell(34,0,'',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(85,0,'(Berdasarkan Rekap Data Tanggal '.tgl_indo($tgl_analis).')',0,0,'L');
		$this->Ln(8);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'III.A. PERNYATAAN PENDAPATAN DAN PENGELUARAN',0,0,'L');
		$this->Ln(3);
		
		//Kotak Laba Rugi
		$this->Rect(25,127.3,85,40);
		$this->Rect(110,127.3,85,40);
		
		$this->Line(31,145,109,145);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(25);
		$this->Cell(85,5,'PENDAPATAN',1,0,'C');
		$this->SetX(110);
		$this->Cell(85,5,'PENGELUARAN',1,0,'C');
		$this->Ln(8);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,' 1. Penghasilan Pemohon ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 1. Biaya Pangan',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 2. Penghasilan Penjamin',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 2. Biaya Listrik dan Air',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 3. Penghasilan Lainnya',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 3. Biaya Telpon',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		
		$this->SetX(110);
		$this->Cell(48,0,' 4. Biaya Pendidikan',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(30);
		$this->Cell(43,0,'Total Pendapatan',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(48,0,' 5. Biaya Sandang',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(30);
		$this->Cell(43,0,'Total Biaya',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(48,0,' 6. Biaya Upacara Adat',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(30);
		$this->Cell(43,0,'Surplus',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(48,0,' 7. Angsuran Pinjaman',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(30);
		$this->Cell(43,0,'Angsuran (mak.50%)',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(48,0,' 8. Biaya Lainnya',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(8);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'III.B. NERACA',0,0,'L');
		$this->Ln(3);
		
		
		
		//Kotak Neraca
		$this->Rect(25,181.3,85,30.4);
		$this->Rect(110,181.3,85,30.4);
		$this->Line(115.5,196.5,194,196.5);
		
		
		$this->SetFont('Arial','B',9);
		$this->SetX(25);
		$this->Cell(85,5,'AKTIVA',1,0,'C');
		$this->SetX(110);
		$this->Cell(85,5,'PASIVA',1,0,'C');
		$this->Ln(8);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(48,0,' 1. Uang Tunai ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 1. Pinjaman Pribadi',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 2. Simpanan ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 2. Pinjaman '.LEMBAGA_SORT,0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 3. Kendaraan ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,' 3. Pinjaman Bank ',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 4. Tanah ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,'     Jumlah Kewajiban',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 5. Bangunan ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(5);
		
		$this->SetX(25);
		$this->Cell(48,0,' 6. Aktiva Lain-lain  ',0,0,'L');
		$this->SetX(73);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,0,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(48,0,'     Surplus',0,0,'L');
		$this->SetX(158);
		$this->Cell(3,0,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,0,'_______________',0,0,'R');
		$this->Ln(3);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(25);
		$this->Cell(85,5,'     Total Aktiva',1,0,'L');
		$this->SetX(73);
		$this->Cell(3,5,': Rp.',0,0,'L');
		$this->SetX(76);
		$this->Cell(34,5,'_______________',0,0,'R');
		
		$this->SetX(110);
		$this->Cell(85,5,'     Total Pasiva',1,0,'L');
		$this->SetX(158);
		$this->Cell(3,5,': Rp.',0,0,'L');
		$this->SetX(161);
		$this->Cell(34,5,'_______________',0,0,'R');
		$this->Ln(10);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(22);
		$this->Cell(100,0,'IV. ASPEK JAMINAN',0,0,'L');
		$this->Ln(3);
		
		$this->SetFont('Arial','',9);
		$this->SetX(27);
		$this->MultiCell(169,4,'Jenis Jaminan: ',0);
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(22);
		$this->Cell(169,0,'_________________________________________________________________________________________________',0);
		$this->Ln(2);
		
		$this->SetFont('Arial','',7);
		$this->SetX(22);
		$this->MultiCell(169,4,'Dengan ini saya menyatakan bahwa informasi ini adalah benar dan saya memberi persetujuan/kuasa kepada '.LEMBAGA_SORT.' untuk menghubungi sumber manapun yang dianggap perlu menegaskan kebenaranya, saya juga menyadari bahwa pemberian keterangan yang tidak benar dapat dituntut menurut hukum. Demikian permohonan pinjaman ini saya ajukan dan apabila disetujui saya bersedia menaati segala ketentuan yang berlaku.',0);
		$this->Ln(2);
		
	//Tanda Tangan
	$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
		
		$this->SetFont('Arial','',8);
		$this->SetX(110);
		$this->Cell(95,0,'Cengkok,_________________________',0,0,'C');
		$this->Ln(6);
		
		$this->SetX(15);
		$this->Cell(65,0,'Mengetahui',0,0,'C');
		$this->SetX(75);
		$this->Cell(65,0,'',0,0,'C');
		$this->SetX(135);
		$this->Cell(65,0,'',0,0,'C');
		$this->Ln(4);
		
		$this->SetX(15);
		$this->Cell(65,0,'Bendesa Adat Cengkok,',0,0,'C');
		$this->SetX(75);
		$this->Cell(65,0,'Menyetujui Penjamin',0,0,'C');
		$this->SetX(135);
		$this->Cell(65,0,'Pemohon ',0,0,'C');
		$this->Ln(15);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(15);
		$this->Cell(65,0,'(                                      )',0,0,'C'); 
		$this->SetX(75);
		$this->Cell(65,0,'(                                      )',0,0,'C');
		$this->SetX(135);
		$this->Cell(65,0,'(                                      )',0,0,'C');
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
		$this->Cell(0,5,'Paraf : ............ | Formulir Pinjaman, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('FORMULIR PINJAMAN');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
