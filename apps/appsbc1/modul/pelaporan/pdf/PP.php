<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

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

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

		$this->SetY(11);
		//Logo
		$this->Image('../../../images/logo_bumdes.png',20,9,12,0);
		
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
		$this->Cell(178,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(3);

		//buat garis horisontal
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,17,283,17);
		
		$this->SetFont('Arial','B',10);
		$this->SetDrawColor(0,0,0); //warna
		//judul
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'LAPORAN PERKEMBANGAN PINJAMAN ANGGOTA',0,0,'C');
		$this->Ln(4);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		
//Fields Name position
$Y_Fields_Name_position = 29;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetFillColor(255,255,255);
//Bold Font for Field Name
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(15);
$this->Cell(5,10,'NO',1,0,'C',1);
$this->SetX(20);
$this->Cell(52,10,'PEMANFAAT - LOAN ID',1,0,'C',1);
$this->SetX(72);
$this->Cell(13,10,'CAIR',1,0,'C',1);
$this->SetX(85);
$this->Cell(10,10,'TEMPO',1,0,'C',1);
$this->SetX(95);
$this->Cell(15,10,'ALOKASI',1,0,'C',1);
$this->SetX(110);
$this->Cell(30,5,'TARGET',1,0,'C',1);
$this->SetX(140);
$this->Cell(30,5,'REAL s.d. '.strtoupper($judulL),1,0,'C',1);
$this->SetX(170);
$this->Cell(30,5,'REAL '.strtoupper($judulC),1,0,'C',1);
$this->SetX(200);
$this->Cell(30,5,'REAL s.d. '.strtoupper($judulC),1,0,'C',1);
$this->SetX(230);
$this->Cell(15,10,'SALDO',1,0,'C',1);
$this->SetX(245);
$this->Cell(9,10,'%',1,0,'C',1);
$this->SetX(254);
$this->Cell(29,5,'TUNGGAKAN',1,0,'C',1);
$this->Ln();


$this->SetX(110);
$this->Cell(15,5,'POKOK',1,0,'C',1);
$this->SetX(125);
$this->Cell(15,5,'JASA',1,0,'C',1);
$this->SetX(140);
$this->Cell(15,5,'POKOK',1,0,'C',1);
$this->SetX(155);
$this->Cell(15,5,'JASA',1,0,'C',1);
$this->SetX(170);
$this->Cell(15,5,'POKOK',1,0,'C',1);
$this->SetX(185);
$this->Cell(15,5,'JASA',1,0,'C',1);
$this->SetX(200);
$this->Cell(15,5,'POKOK',1,0,'C',1);
$this->SetX(215);
$this->Cell(15,5,'JASA',1,0,'C',1);
$this->SetX(254);
$this->Cell(15,5,'POKOK',1,0,'C',1);
$this->SetX(269);
$this->Cell(14,5,'JASA',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{
		
$lokasi				=$_SESSION['lokasi'];

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


		$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.status='A' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='L' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND pi.lokasi='$lokasi'  AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R'
		ORDER BY pi.tgl_cair ASC"); 
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$tgl_lunas		=$row['tgl_lunas'];
		$status			=$row['status'];
		$targetpokok	=targetpokok($tgl_kondisi."-".$idp);
		$targetjasa		=targetjasa($tgl_kondisi."-".$idp);
		$reallalu		=sumpokok("$tgl_kondisilalu-$idp");
		$reallalujasa	=sumjasa("$tgl_kondisilalu-$idp");
		$realpokok		=realisasiinipokok("$tgl_kondisi-$kc-$idp");
		$realjasa		=realisasiinijasa("$tgl_kondisi-$kc-$idp");
		$sumpokok		=sumpokok("$tgl_kondisi-$idp");
		$sumjasa		=sumjasa($tgl_kondisi."-".$idp);
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		
		$angsuranke		=angsuranke($tgl_kondisi."-".$idp);
		
		$pros=@($sumpokok/$targetpokok*100); if($pros>=100) {$prosK ="100";}else{$prosK=$pros;}
		 
				$this->SetFont('Arial','',6);
				$this->SetFillColor(255,255,255);
				$this->SetX(15);
				$this->Cell(5,5,$noo,1,0,'C');
				$this->SetX(20);
				$this->Cell(52,5,$row['id_kel'].'     '.strtoupper($row['namadepan']),1,0,'L');
				$this->SetX(66);
				$this->Cell(6,5,$idp,0,0,'C');
				$this->SetX(72);
				$this->Cell(13,5,tgl_ind($row['tgl_cair']),1,0,'C',1);
				$this->SetX(85);
				$this->Cell(10,5,$row['jangka'].'/'.$row['sistem'].'*'.$angsuranke,1,0,'C');
				$this->SetX(95);
				$this->Cell(15,5,number_format($alokasi),1,0,'R');
				$this->SetX(110);
				$this->Cell(15,5,number_format($targetpokok),1,0,'R');
				$this->SetX(125);
				$this->Cell(15,5,number_format($targetjasa),1,0,'R');
				$this->SetX(140);
				$this->Cell(15,5,number_format($reallalu),1,0,'R');
				$this->SetX(155);
				$this->Cell(15,5,number_format($reallalujasa),1,0,'R');
				$this->SetX(170);
				$this->Cell(15,5,number_format($realpokok),1,0,'R');
				$this->SetX(185);
				$this->Cell(15,5,number_format($realjasa),1,0,'R');
				$this->SetX(200);
				$this->Cell(15,5,number_format($sumpokok),1,0,'R');
				$this->SetX(215);
				$this->Cell(15,5,number_format($sumjasa),1,0,'R');
				$this->SetX(230);
				$this->Cell(15,5,number_format($saldopinjaman),1,0,'R');
				$this->SetX(245);
				$this->Cell(9,5,number_format($prosK).'%',1,0,'C');
				$this->SetX(254);
				$this->Cell(15,5,number_format($nunggakpokok),1,0,'R');
				$this->SetX(269);
				$this->Cell(14,5,number_format($nunggakjasa),1,0,'R');
				$this->Ln();
				
			
		$sumalokasi			=$sumalokasi+$alokasi;
		$sumtargetpokok		=$sumtargetpokok+$targetpokok;
		$sumtargetjasa		=$sumtargetjasa+$targetjasa;
		$sumreallalu		=$sumreallalu+$reallalu;
		$sumreallalujasa	=$sumreallalujasa+$reallalujasa;
		$sumrealpokok		=$sumrealpokok+$realpokok;
		$sumrealjasa		=$sumrealjasa+$realjasa;
		$sumsumpokok		=$sumsumpokok+$sumpokok;
		$sumsumjasa			=$sumsumjasa+$sumjasa;
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumnunggakjasa		=$sumnunggakjasa+$nunggakjasa;			
		
			} //end data kelompok
	
		//SUM DATA
		
		$pros=@(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")/targetpokokC("$tgl_kondisi-$idf-$kd_kec")*100); 
				if($pros>=100) {$pross="100";}else{$pross=number_format($pros);}
		
				$this->SetFont('Arial','B',6);
				$this->SetX(15);
				$this->Cell(80,8,'T O T A L',1,0,'C');
				$this->SetX(95);
				$this->Cell(15,8,number_format($sumalokasi),1,0,'R');
				$this->SetX(110);
				$this->Cell(15,8,number_format($sumtargetpokok),1,0,'R');
				$this->SetX(125);
				$this->Cell(15,8,number_format($sumtargetjasa),1,0,'R');
				$this->SetX(140);
				$this->Cell(15,8,number_format($sumreallalu),1,0,'R');
				$this->SetX(155);
				$this->Cell(15,8,number_format($sumreallalujasa),1,0,'R');
				$this->SetX(170);
				$this->Cell(15,8,number_format($sumrealpokok),1,0,'R');
				$this->SetX(185);
				$this->Cell(15,8,number_format($sumrealjasa),1,0,'R');
				$this->SetX(200);
				$this->Cell(15,8,number_format($sumsumpokok),1,0,'R');
				$this->SetX(215);
				$this->Cell(15,8,number_format($sumsumjasa),1,0,'R');
				$this->SetX(230);
				$this->Cell(15,8,number_format($sumsaldopinjaman),1,0,'R');
				$this->SetX(245);
				$this->Cell(9,8,number_format("$pross").'%',1,0,'C');
				$this->SetX(254);
				$this->Cell(15,8,number_format($sumnunggakpokok),1,0,'R');
				$this->SetX(269);
				$this->Cell(14,8,number_format($sumnunggakjasa),1,0,'R');
				$this->Ln();
	
	
	//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='2' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u4=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',8);
	
	$this->Ln(5);
	$this->SetX(20);
	$this->Cell(60,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Dilaporkan oleh,',0,0,'C');
	$this->SetX(200);
	$this->Cell(60,6,'Dilaporkan oleh,',0,0,'C');

	$this->Ln(17);
	$this->SetFont('Arial','B',8);	
	$this->SetX(20);
	$this->Cell(60,6,strtoupper($u4['namadepan'].' '.$u4['namabelakang']),0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	$this->SetX(200);
	$this->Cell(60,6,strtoupper($u3['namadepan'].' '.$u3['namabelakang']),0,0,'C');
	
	$this->Ln(2.5);
	$this->SetFont('Arial','I',8);	
	$this->SetX(20);
	$this->Cell(60,6,'Badan Pengawas',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Kepala '.LEMBAGA_SORT,0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
	$this->SetX(200);
	$this->Cell(60,6,'Sekretaris/Data Center',0,0,'C');
	
	} //End Content

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(15,$this->GetY(),283,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(15);
		$this->Cell(140,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(155);
		$this->Cell(130,4,'Paraf : ............ | LPP Anggota, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('LPP '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('6.1. Perkembangan Pinjaman '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
