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
		$this->SetMargins(13,0);
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
		$this->Cell(0,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(3);

		//buat garis horisontal
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,17,283,17);
		
		$this->SetFont('Arial','B',10);
		$this->SetDrawColor(0,0,0); //warna
		//judul
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'LAPORAN KOLEKTIBILITAS PINJAMAN ANGGOTA',0,0,'C');
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
$this->SetX(18);
$this->Cell(7,10,'NO',1,0,'C',1);
$this->SetX(25);
$this->Cell(50,10,'ANGGOTA PEMANFAAT',1,0,'C',1);
$this->SetX(75);
$this->Cell(38,10,'ALAMAT',1,0,'C',1);
$this->SetX(113);
$this->Cell(10,10,'LID',1,0,'C',1);
$this->SetX(123);
$this->Cell(20,10,'SALDO',1,0,'C',1);
$this->SetX(143);
$this->Cell(30,5,'TUNGGAKAN',1,0,'C',1);
$this->SetX(173);
$this->Cell(10,10,'#',1,0,'C',1);
$this->SetX(183);
$this->Cell(25,5,'LANCAR',1,0,'C',1);
$this->SetX(208);
$this->Cell(25,5,'KURANG LANCAR',1,0,'C',1);
$this->SetX(233);
$this->Cell(25,5,'DIRAGUKAN',1,0,'C',1);
$this->SetX(258);
$this->Cell(25,5,'MACET',1,0,'C',1);
$this->Ln();


$this->SetX(143);
$this->Cell(17,5,'POKOK',1,0,'C',1);
$this->SetX(160);
$this->Cell(13,5,'JASA',1,0,'C',1);
$this->SetX(183);
$this->Cell(25,5,'(menunggak 1-4)',1,0,'C',1);
$this->SetX(208);
$this->Cell(25,5,'(menunggak >= 4)',1,0,'C',1);
$this->SetX(233);
$this->Cell(25,5,'(over 1-6)',1,0,'C',1);
$this->SetX(258);
$this->Cell(25,5,'(over >= 6)',1,0,'C',1);
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
		$saldopinjaman	=saldoPB($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp);
		$kolek1			=kolek1($tgl_kondisi."-".$idp);
		$kolek2			=kolek2($tgl_kondisi."-".$idp);
		$kolek3			=kolek3($tgl_kondisi."-".$idp);
		$kolek4			=kolek4($tgl_kondisi."-".$idp);
		
		$jangka			=jangka($idp);
		
		$over			=$jum_nunggak-$jangka;
		if($jum_nunggak>0 and $jum_nunggak<$jangka){$sig_nunggak=floor($jum_nunggak)."+";}elseif($jum_nunggak>$jangka){$sig_nunggak="$jangka+$over";}else{$sig_nunggak=$jum_nunggak;}
		
		 
				$this->SetFont('Arial','',6);
				$this->SetFillColor(255,255,255);
				$this->SetX(18);
				$this->Cell(7,5,$noo,1,0,'C');
				$this->SetX(25);
				$this->Cell(50,5,$row['nik'].' '.strtoupper($row['namadepan']),1,0,'L');
				$this->SetX(75);
				$this->Cell(38,5,$row['hp'].' '.$row['alamat'],1,0,'L');
				$this->SetX(113);
				$this->Cell(10,5,$idp,1,0,'C');
				$this->SetX(123);
				$this->Cell(20,5,number_format($saldopinjaman),1,0,'R');
				$this->SetX(143);
				$this->Cell(17,5,number_format($nunggakpokok),1,0,'R');
				$this->SetX(160);
				$this->Cell(13,5,number_format($nunggakjasa),1,0,'R');
				$this->SetX(173);
				$this->Cell(10,5,$sig_nunggak,1,0,'C');
				$this->SetX(183);
				$this->Cell(25,5,number_format($kolek1),1,0,'R');
				$this->SetX(208);
				$this->Cell(25,5,number_format($kolek2),1,0,'R');
				$this->SetX(233);
				$this->Cell(25,5,number_format($kolek3),1,0,'R');
				$this->SetX(258);
				$this->Cell(25,5,number_format($kolek4),1,0,'R');
				$this->Ln();
				
			
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumnunggakjasa		+=$nunggakjasa;
		$sumkolek1			=$sumkolek1+$kolek1;
		$sumkolek2			=$sumkolek2+$kolek2;
		$sumkolek3			=$sumkolek3+$kolek3;
		$sumkolek4			=$sumkolek4+$kolek4;

		$cr1		=$sumkolek1*0.5/100;
		$cr2		=$sumkolek2*10/100;
		$cr3		=$sumkolek3*50/100;
		$cr4		=$sumkolek4*100/100;
		$sumcr		=$cr1+$cr2+$cr3+$cr4;
		
			} //end data kelompok
	
		//SUM DATA
		
		$pros=@(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")/targetpokokC("$tgl_kondisi-$idf-$kd_kec")*100); 
				if($pros>=100) {$pross="100";}else{$pross=number_format($pros);}
		
				$this->SetFont('Arial','B',6);
				$this->SetX(18);
				$this->Cell(105,8,'TOTAL KOLEKTIBILITAS',1,0,'C');
				$this->SetX(123);
				$this->Cell(20,8,number_format($sumsaldopinjaman),1,0,'R');
				$this->SetX(143);
				$this->Cell(17,8,number_format($sumnunggakpokok),1,0,'R');
				$this->SetX(160);
				$this->Cell(13,8,number_format($sumnunggakjasa),1,0,'R');
				$this->SetX(173);
				$this->Cell(10,8,'#',1,0,'C');
				$this->SetX(183);
				$this->Cell(25,8,number_format($sumkolek1),1,0,'R');
				$this->SetX(208);
				$this->Cell(25,8,number_format($sumkolek2),1,0,'R');
				$this->SetX(233);
				$this->Cell(25,8,number_format($sumkolek3),1,0,'R');
				$this->SetX(258);
				$this->Cell(25,8,number_format($sumkolek4),1,0,'R');
				$this->Ln();

//CADANGAN RESIKO				
				
				$this->SetX(18);
				$this->Cell(105,8,'CADANGAN PINJAMAN RAGU-RAGU (CPRR)',1,0,'C');
				
				
				$this->SetFont('Arial','',6);
				$this->SetX(123);
				$this->Cell(60,4,'(K1 + K2 + K3 + K4)',1,0,'L',0);
				$this->SetX(183);
				$this->Cell(25,4,'K1 x 0.5 %',1,0,'L',0);
				$this->SetX(208);
				$this->Cell(25,4,'K2 x 10 %',1,0,'L',0);
				$this->SetX(233);
				$this->Cell(25,4,'K3 x 50 %',1,0,'L',0);
				$this->SetX(258);
				$this->Cell(25,4,'K4 x 100 %',1,0,'L',0);
				$this->Ln();
				
				$this->SetFont('Arial','B',6);
				$this->SetX(123);
				$this->Cell(60,4,number_format($sumcr),1,0,'R');
				$this->SetX(183);
				$this->Cell(25,4,number_format($cr1),1,0,'R',0);
				$this->SetX(208);
				$this->Cell(25,4,number_format($cr2),1,0,'R');
				$this->SetX(233);
				$this->Cell(25,4,number_format($cr3),1,0,'R');
				$this->SetX(258);
				$this->Cell(25,4,number_format($cr4),1,0,'R');
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
	$this->Cell(60,6,'Badan Pengawas (Panureksa)',0,0,'C');
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
		$this->Line(18,$this->GetY(),283,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(18);
		$this->Cell(140,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(155);
		$this->Cell(130,4,'Paraf : ............ | Kolektibilitas Anggota, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Kolektibilitas dan CPRR '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('6.1. Kolektibilitas dan CPRR '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
