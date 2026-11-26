<?php session_start();
ob_start();
include "../../../inc/fungsi_pinjaman.php";
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";


define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/fpdf.php');

class PDF extends FPDF
{ 
	//Page header
	function Header()
	{
		$lokasi				=$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
		$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
		$thn_kondisi		="$y-01-01";

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		if($idf==1){ $jpp="SPP"; }else{$jpp="UEP";}

		
		//Logo
		//$this->Image('logo-ubl.jpg',10,8);
		//Arial bold 15
		$this->SetFont('Arial','',6);
		//judul
		$this->Cell(0,0,$row['nama_lembaga_sort']. ' Kecamatan ' .$row['nama_kec'],0,0,'L');
		//pindah baris
		$this->Ln(3);
		$this->Cell(0,0,$row['alamat_kec']. ' Telpon ' .$row['telpon_kec'],0,0,'L');
		$this->Ln(10);
		//buat garis horisontal
		$this->Line(10,15,285,15);
		$this->SetFont('Arial','B',10);
		//judul
		$this->Cell(0,0,'LAPORAN PERKEMBANGAN PINJAMAN '.$jpp.' REKAP KELOMPOK',0,0,'C');
		$this->Ln(4);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		
//Fields Name position
$Y_Fields_Name_position = 31;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetFillColor(255,255,255);
//Bold Font for Field Name
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(10);
$this->Cell(5,10,'NO',1,0,'C',1);
$this->SetX(15);
$this->Cell(45,10,'NAMA DESA',1,0,'C',1);
$this->SetX(60);
$this->Cell(20,10,'ALOKASI',1,0,'C',1);
$this->SetX(80);
$this->Cell(35,5,'TARGET',1,0,'C',1);
$this->SetX(115);
$this->Cell(35,5,'REAL s.d. '.strtoupper($judulL),1,0,'C',1);
$this->SetX(150);
$this->Cell(35,5,'REAL '.strtoupper($judulC),1,0,'C',1);
$this->SetX(185);
$this->Cell(35,5,'REAL s.d. '.strtoupper($judulC),1,0,'C',1);
$this->SetX(220);
$this->Cell(20,10,'SALDO',1,0,'C',1);
$this->SetX(240);
$this->Cell(10,10,'%',1,0,'C',1);
$this->SetX(250);
$this->Cell(35,5,'TUNGGAKAN',1,0,'C',1);
$this->Ln();


$this->SetX(80);
$this->Cell(18,5,'POKOK',1,0,'C',1);
$this->SetX(98);
$this->Cell(17,5,'JASA',1,0,'C',1);
$this->SetX(115);
$this->Cell(18,5,'POKOK',1,0,'C',1);
$this->SetX(133);
$this->Cell(17,5,'JASA',1,0,'C',1);
$this->SetX(150);
$this->Cell(18,5,'POKOK',1,0,'C',1);
$this->SetX(168);
$this->Cell(17,5,'JASA',1,0,'C',1);
$this->SetX(185);
$this->Cell(18,5,'POKOK',1,0,'C',1);
$this->SetX(203);
$this->Cell(17,5,'JASA',1,0,'C',1);
$this->SetX(250);
$this->Cell(18,5,'POKOK',1,0,'C',1);
$this->SetX(268);
$this->Cell(17,5,'JASA',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{
		
		$lokasi				=$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
		$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
		$thn_kondisi		="$y-01-01";

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		if($idf==1){ $jpp="SPP"; }else{$jpp="UEP";}
	
	
	$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		$sumKelD=mysql_num_rows(mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
WHERE k.id=pk.id_kel AND pk.status='A' AND k.desa='$idd'	"));

		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		$pros=@(sumrealpokokD("$tgl_kondisi-$idf-$idd")/targetpokokD("$tgl_kondisi-$idf-$idd")*100); if($pros>=100) { $prosD="100";}else{ $prosD=$pros;}
		
		$this->SetFont('Arial','',6);
		$this->SetX(10);
		$this->Cell(5,5,$no,1,0,'C');
		$this->SetX(15);
		$this->Cell(45,5,strtoupper($r['nama_desa'])." [$sumKelD]",1,0,'L');
		$this->SetX(60);
		$this->Cell(20,5,number_format(alokasiD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(80);
		$this->Cell(18,5,number_format(targetpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(98);
		$this->Cell(17,5,number_format(targetjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(115);
		$this->Cell(18,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(133);
		$this->Cell(17,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(150);
		$this->Cell(18,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd")),1,0,'R');
		$this->SetX(168);
		$this->Cell(17,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd")),1,0,'R');
		$this->SetX(185);
		$this->Cell(18,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(203);
		$this->Cell(17,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(220);
		$this->Cell(20,5,number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(240);
		$this->Cell(10,5,number_format($prosD).'%',1,0,'C');
		$this->SetX(250);
		$this->Cell(18,5,number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(268);
		$this->Cell(17,5,number_format(nunggakjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->Ln();
		
		
		$sumalokasi			=$sumalokasi+alokasiD("$tgl_kondisi-$idf-$idd");
		$sumtargetpokok		=$sumtargetpokok+targetpokokD("$tgl_kondisi-$idf-$idd");
		$sumtargetjasa		=$sumtargetjasa+targetjasaD("$tgl_kondisi-$idf-$idd");
		$sumreallalu		=$sumreallalu+sumrealpokokD("$tgl_kondisilalu-$idf-$idd");
		$sumreallalujasa	=$sumreallalujasa+sumrealjasaD("$tgl_kondisilalu-$idf-$idd");
		$sumrealpokok		=$sumrealpokok+(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));
		$sumrealjasa		=$sumrealjasa+(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));
		$sumsumpokok		=$sumsumpokok+sumrealpokokD("$tgl_kondisi-$idf-$idd");
		$sumsumjasa			=$sumsumjasa+sumrealjasaD("$tgl_kondisi-$idf-$idd");
		$sumsaldopinjaman	=$sumsaldopinjaman+saldopinjamanD("$tgl_kondisi-$idf-$idd");
		$sumnunggakpokok	=$sumnunggakpokok+nunggakpokokD("$tgl_kondisi-$idf-$idd");
		$sumnunggakjasa		=$sumnunggakjasa+nunggakjasaD("$tgl_kondisi-$idf-$idd");
	
		} //end data desa
	
	
	//KELOMPOK
		$this->SetFont('Arial','B',6);
		$this->SetX(10);
		$this->Cell(50,5,'T O T A L',1,0,'C');
		$this->SetX(60);
		$this->Cell(20,5,number_format($sumalokasi),1,0,'R');
		$this->SetX(80);
		$this->Cell(18,5,number_format($sumtargetpokok),1,0,'R');
		$this->SetX(98);
		$this->Cell(17,5,number_format($sumtargetjasa),1,0,'R');
		$this->SetX(115);
		$this->Cell(18,5,number_format($sumreallalu),1,0,'R');
		$this->SetX(133);
		$this->Cell(17,5,number_format($sumreallalujasa),1,0,'R');
		$this->SetX(150);
		$this->Cell(18,5,number_format($sumrealpokok),1,0,'R');
		$this->SetX(168);
		$this->Cell(17,5,number_format($sumrealjasa),1,0,'R');
		$this->SetX(185);
		$this->Cell(18,5,number_format($sumsumpokok),1,0,'R');
		$this->SetX(203);
		$this->Cell(17,5,number_format($sumsumjasa),1,0,'R');
		$this->SetX(220);
		$this->Cell(20,5,number_format($sumsaldopinjaman),1,0,'R');
		$this->SetX(240);
		$this->Cell(10,5,'%',1,0,'C');
		$this->SetX(250);
		$this->Cell(18,5,number_format($sumnunggakpokok),1,0,'R');
		$this->SetX(268);
		$this->Cell(17,5,number_format($sumnunggakjasa),1,0,'R');
		$this->Ln();
	
	
	} //End Content

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

$idf				=substr($_POST['sub_report'],3);
$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' "));

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle($jb['nama_jb']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
