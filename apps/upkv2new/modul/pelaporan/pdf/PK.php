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
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $kc="M"; $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$kd_kec=$row['kd_kec'];
		
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
$this->Cell(45,10,'KELOMPOK - LOAN ID',1,0,'C',1);
$this->SetX(60);
$this->Cell(15,10,'CAIR',1,0,'C',1);
$this->SetX(75);
$this->Cell(10,10,'TEMPO',1,0,'C',1);
$this->SetX(85);
$this->Cell(20,10,'ALOKASI',1,0,'C',1);
$this->SetX(105);
$this->Cell(30,5,'TARGET',1,0,'C',1);
$this->SetX(135);
$this->Cell(30,5,'REAL s.d. '.strtoupper($judulL),1,0,'C',1);
$this->SetX(165);
$this->Cell(30,5,'REAL '.strtoupper($judulC),1,0,'C',1);
$this->SetX(195);
$this->Cell(30,5,'REAL s.d. '.strtoupper($judulC),1,0,'C',1);
$this->SetX(225);
$this->Cell(20,10,'SALDO',1,0,'C',1);
$this->SetX(245);
$this->Cell(10,10,'%',1,0,'C',1);
$this->SetX(255);
$this->Cell(30,5,'TUNGGAKAN',1,0,'C',1);
$this->Ln();


$this->SetX(105);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(122);
$this->Cell(13,5,'JASA',1,0,'C',1);
$this->SetX(135);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(152);
$this->Cell(13,5,'JASA',1,0,'C',1);
$this->SetX(165);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(182);
$this->Cell(13,5,'JASA',1,0,'C',1);
$this->SetX(195);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(212);
$this->Cell(13,5,'JASA',1,0,'C',1);
$this->SetX(255);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(272);
$this->Cell(13,5,'JASA',1,0,'C',1);
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
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $kc="M"; $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		if($idf==1){ $jpp="SPP"; }else{$jpp="UEP";}
	
	
	$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$_SESSION[lokasi]' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		$pros=@(sumrealpokokD("$tgl_kondisi-$idf-$idd")/targetpokokD("$tgl_kondisi-$idf-$idd")*100); if($pros>=100) { $prosD="100";}else{ $prosD=$pros;}
		
		$this->SetFont('Arial','B',6);
		$this->SetX(10);
		$this->Cell(5,5,$no,1,0,'C');
		$this->SetX(15);
		$this->Cell(70,5,strtoupper($r['nama_desa']),1,0,'L');
		$this->SetX(85);
		$this->Cell(20,5,number_format(alokasiD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(105);
		$this->Cell(17,5,number_format(targetpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(122);
		$this->Cell(13,5,number_format(targetjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(135);
		$this->Cell(17,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(152);
		$this->Cell(13,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(165);
		$this->Cell(17,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd")),1,0,'R');
		$this->SetX(182);
		$this->Cell(13,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd")),1,0,'R');
		$this->SetX(195);
		$this->Cell(17,5,number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(212);
		$this->Cell(13,5,number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(225);
		$this->Cell(20,5,number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(245);
		$this->Cell(10,5,number_format($prosD).'%',1,0,'C');
		$this->SetX(255);
		$this->Cell(17,5,number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->SetX(272);
		$this->Cell(13,5,number_format(nunggakjasaD("$tgl_kondisi-$idf-$idd")),1,0,'R');
		$this->Ln();
		
		
		$view=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.status='A' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R'
		ORDER BY k.kd_kelompok ASC"); 
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
				$this->SetX(10);
				$this->Cell(5,5,$noo,1,0,'C');
				$this->SetX(15);
				$this->Cell(45,5,$row['kd_kelompok'].' '.$row['nama_kelompok'].' ('.$row['ketua'].') - '.$idp,1,0,'L');
				$this->SetX(60);
				$this->Cell(15,5,tgl_ind($row['tgl_cair']),1,0,'C');
				$this->SetX(75);
				$this->Cell(10,5,$row['jangka'].'/'.$row['sistem'].'*'.$angsuranke,1,0,'C');
				$this->SetX(85);
				$this->Cell(20,5,number_format($alokasi),1,0,'R');
				$this->SetX(105);
				$this->Cell(17,5,number_format($targetpokok),1,0,'R');
				$this->SetX(122);
				$this->Cell(13,5,number_format($targetjasa),1,0,'R');
				$this->SetX(135);
				$this->Cell(17,5,number_format($reallalu),1,0,'R');
				$this->SetX(152);
				$this->Cell(13,5,number_format($reallalujasa),1,0,'R');
				$this->SetX(165);
				$this->Cell(17,5,number_format($realpokok),1,0,'R');
				$this->SetX(182);
				$this->Cell(13,5,number_format($realjasa),1,0,'R');
				$this->SetX(195);
				$this->Cell(17,5,number_format($sumpokok),1,0,'R');
				$this->SetX(212);
				$this->Cell(13,5,number_format($sumjasa),1,0,'R');
				$this->SetX(225);
				$this->Cell(20,5,number_format($saldopinjaman),1,0,'R');
				$this->SetX(245);
				$this->Cell(10,5,number_format($prosK).'%',1,0,'C');
				$this->SetX(255);
				$this->Cell(17,5,number_format($nunggakpokok),1,0,'R');
				$this->SetX(272);
				$this->Cell(13,5,number_format($nunggakjasa),1,0,'R');
				$this->Ln();
				
				
		
			} //end data kelompok
		} //end data desa
	
		//SUM DATA
		
				$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$kd_kec=$row['kd_kec'];
		
		$pros=@(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")/targetpokokC("$tgl_kondisi-$idf-$kd_kec")*100); 
				if($pros>=100) {$pross="100";}else{$pross=number_format($pros);}
		
				$this->SetFont('Arial','B',6);
				$this->SetX(10);
				$this->Cell(75,8,'T O T A L',1,0,'C');
				$this->SetX(85);
				$this->Cell(20,8,number_format(alokasiC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(105);
				$this->Cell(17,8,number_format(targetpokokC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(122);
				$this->Cell(13,8,number_format(targetjasaC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(135);
				$this->Cell(17,8,number_format(sumrealpokokC("$tgl_kondisilalu-$idf-$kd_kec")),1,0,'R');
				$this->SetX(152);
				$this->Cell(13,8,number_format(sumrealjasaC("$tgl_kondisilalu-$idf-$kd_kec")),1,0,'R');
				$this->SetX(165);
				$this->Cell(17,8,number_format(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")-sumrealpokokC("$tgl_kondisilalu-$idf-$kd_kec")),1,0,'R');
				$this->SetX(182);
				$this->Cell(13,8,number_format(sumrealjasaC("$tgl_kondisi-$idf-$kd_kec")-sumrealjasaC("$tgl_kondisilalu-$idf-$kd_kec")),1,0,'R');
				$this->SetX(195);
				$this->Cell(17,8,number_format(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(212);
				$this->Cell(13,8,number_format(sumrealjasaC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(225);
				$this->Cell(20,8,number_format(saldopinjamanC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(245);
				$this->Cell(10,8,number_format("$pross").'%',1,0,'C');
				$this->SetX(255);
				$this->Cell(17,8,number_format(nunggakpokokC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
				$this->SetX(272);
				$this->Cell(13,8,number_format(nunggakjasaC("$tgl_kondisi-$idf-$kd_kec")),1,0,'R');
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
