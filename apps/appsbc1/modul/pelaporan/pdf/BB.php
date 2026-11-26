<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		
$lokasi				=$_SESSION['lokasi'];
$table_transaksi	="transaksi_".$_SESSION['lokasi'];
$table_rekening		="rekening_".$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$kd_rekening		=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$kd_rekening		=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}
		$tgl			="$y-$m-$d";

		$tgl_awal		="$y-$m-01"; 

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-31' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r where a.id=r.id_akun AND r.kd_rekening='$idf' "));

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
		$this->Ln(5);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,200,16);
		
		//judul
		$this->SetFont('Arial','B',11);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'BUKU BANTU '.strtoupper($jb['nama_rekening']),0,0,'C');
		$this->Ln(4.5);
		$this->SetFont('Arial','B',9);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		
		$this->SetFont('Arial','',9);
		$this->Cell(0,0,'Kode Akun : #'.$jb['kd_rekening'],0,0,'R');
		
		
//Fields Name position
$Y_Fields_Name_position = 29;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(7,7,'No',1,0,'C',1);
$this->SetX(27);
$this->Cell(16,7,'Tanggal',1,0,'C',1);
$this->SetX(43);
$this->Cell(25,7,'Ref',1,0,'C',1);
$this->SetX(68);
$this->Cell(57,7,'Keterangan',1,0,'C',1);
$this->SetX(125);
$this->Cell(22,7,'Debit',1,0,'C',1);
$this->SetX(147);
$this->Cell(22,7,'Kredit',1,0,'C',1);
$this->SetX(169);
$this->Cell(25,7,'Saldo',1,0,'C',1);
$this->SetX(194);
$this->Cell(6,7,'P',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{


		
	$lokasi				=$_SESSION['lokasi'];
	$table_transaksi	="transaksi_".$_SESSION['lokasi'];
	$table_rekening		="rekening_".$_SESSION['lokasi'];

	$report				=$_POST['report'];
	if (empty($report)) {
		$idf				=$_GET['idf'];
		$kd_rekening		=$_GET['idf'];
		$d					=$_GET['d'];
		$m					=$_GET['m'];
		$y					=$_GET['y'];
	}else{
		$idf				=substr($_POST['sub_report'],3);
		$kd_rekening		=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
	}
		$yl					=$y-1;
		$tgl				="$y-$m-$d";

		$tgl_awal="$y-$m-01";

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi=$tgl_awal; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-31' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $tgl_lalu=date('Y-m-d', strtotime('-1 days', strtotime($tgl_kondisi))); $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}
		

		$totsaldoawaltahun	=saldoATR("$tgl_kondisi-$idf");
		$saldoDR			=saldoDR("$tgl_kondisi-$idf");
		$saldoKR			=saldoKR("$tgl_kondisi-$idf");
		
		$ja=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND r.kd_rekening='$idf' "));
$jenis_saldo	=$ja['jenis_saldo'];

if($jenis_saldo=="debit") { $totsaldoawalbulan	=$totsaldoawaltahun+$saldoDR-$saldoKR; } else if($jenis_saldo=="kredit") { $totsaldoawalbulan	=$totsaldoawaltahun+$saldoKR-$saldoDR; }


$this->SetLineWidth(0);
$this->SetDrawColor(0,0,0);		
$this->SetFont('Arial','',7);
$this->SetX(20);
$this->Cell(7,5,'',1,0,'C');
$this->SetX(27);
$this->Cell(16,5,'01/01/'.$y,1,0,'C');
$this->SetX(43);
$this->Cell(25,5,'',1,0,'C');
$this->SetX(68);
$this->Cell(57,5,'Saldo Awal Tahun '.$y.' (Tutup Buku '.$yl.')',1,0,'L');
$this->SetX(125);
$this->Cell(22,5,'',1,0,'R');
$this->SetX(147);
$this->Cell(22,5,'',1,0,'R');
$this->SetX(169);
$this->Cell(25,5,number_format($totsaldoawaltahun,2,',','.'),1,0,'R');
$this->SetX(194);
$this->Cell(6,5,'',1,0,'C');
$this->Ln();


$this->SetFont('Arial','',7);
$this->SetX(20);
$this->Cell(7,5,'',1,0,'C');
$this->SetX(27);
$this->Cell(16,5,tgl_ind($tgl_kondisi),1,0,'C');
$this->SetX(43);
$this->Cell(25,5,'',1,0,'C');
$this->SetX(68);
$this->Cell(57,5,'Saldo Awal '.$jenis.' '.tgl_indo($tgl_kondisi),1,0,'L');
$this->SetX(125);
$this->Cell(22,5,number_format($saldoDR,2,',','.'),1,0,'R');
$this->SetX(147);
$this->Cell(22,5,number_format($saldoKR,2,',','.'),1,0,'R');
$this->SetX(169);
$this->Cell(25,5,number_format($totsaldoawalbulan,2,',','.'),1,0,'R');
$this->SetX(194);
$this->Cell(6,5,'',1,0,'C');
$this->Ln();

		$data=mysql_query("select * from $table_transaksi WHERE substring(rekening_debit,1,7)='$kd_rekening' AND $kondisi OR substring(rekening_kredit,1,7)='$kd_rekening' AND $kondisi  order by tgl_transaksi, urutan, idt asc");
		while($bb=mysql_fetch_array($data)){
		$no=$no+1;
									if(substr($bb['rekening_debit'],0,7)==$kd_rekening) {
										$rek	=$bb['rekening_kredit'];
										$debit	=$bb['jumlah'];
										$kredit	="0";
									}else if(substr($bb['rekening_kredit'],0,7)==$kd_rekening) {
										$debit	="0";
										$kredit	=$bb['jumlah'];
										$rek	=$bb['rekening_debit'];
									}
		$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$bb[id_user]' "));
		
		$keterangan_transaksi	=$bb['keterangan_transaksi'];

	
$ja=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r WHERE a.id=r.id_akun AND r.kd_rekening='$idf' "));
$jenis_saldo	=$ja['jenis_saldo'];

		if($jenis_saldo=="debit") { $prasaldo=$debit-$kredit; } else if($jenis_saldo=="kredit") { $prasaldo=$kredit-$debit; }
		
		if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; }
		
		$sumdebit=$sumdebit+$debit;
		$sumkredit=$sumkredit+$kredit;
  
		
		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetX(20);
		$this->Cell(7,4,$no,1,0,'C');
		$this->SetX(27);
		$this->Cell(16,4,tgl_ind($bb['tgl_transaksi']),1,0,'C');
		$this->SetX(43);
		$this->Cell(25,4,$rek.'/'.$bb['idt'],1,0,'L');
		$this->SetX(68);
		$this->Cell(57,4,$keterangan_transaksi,1,0,'L');
		$this->SetX(125);
		$this->Cell(22,4,number_format($debit,2,',','.'),1,0,'R',1);
		$this->SetX(147);
		$this->Cell(22,4,number_format($kredit,2,',','.'),1,0,'R',1);
		$this->SetX(169);
		$this->Cell(25,4,number_format($saldosamping,2,',','.'),1,0,'R',1);
		$this->SetX(194);
		$this->Cell(6,4,$r['ins'],1,0,'C',1);
		$this->Ln(4);
		
		}
		
$saldo=saldoR("$tgl_kondisisaldo-$idf");

		
//JUMLAH BAWAH	
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(105,5,'Total Transaksi '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(125);
$this->Cell(22,5,number_format($sumdebit,2,',','.'),1,0,'R');
$this->SetX(147);
$this->Cell(22,5,number_format($sumkredit,2,',','.'),1,0,'R');
$this->SetX(169);
$this->SetFillColor(232,232,232);
$this->Cell(31,5,'Saldo '.ucwords($jb['jenis_saldo']).' :',1,0,'C',1);

$this->Ln(5);

$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(105,5,'Total Transaksi sampai dengan '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(125);
$this->Cell(22,5,number_format($saldoDR+$sumdebit,2,',','.'),1,0,'R');
$this->SetX(147);
$this->Cell(22,5,number_format($saldoKR+$sumkredit,2,',','.'),1,0,'R');
$this->SetX(169);
$this->SetFont('Arial','B',9);
$this->Cell(31,10,number_format($saldo,2,',','.'),1,0,'C');
$this->Ln(5);

$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(105,5,'Total Transaksi Komulatif sampai dengan '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(125);
$this->Cell(22,5,number_format($saldoDR+$sumdebit,2,',','.'),1,0,'R');
$this->SetX(147);
$this->Cell(22,5,number_format($saldoKR+$sumkredit,2,',','.'),1,0,'R');
$this->Ln(5);


//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
$u3=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='3' AND lokasi='$_SESSION[lokasi]' "));
	
$this->SetFont('Arial','',8);
	
	$this->Ln(5);
	$this->SetX(20);
	$this->Cell(60,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Disetujui oleh,',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Dilaporkan oleh,',0,0,'C');

	$this->Ln(17);
	$this->SetFont('Arial','B',8);	
	$this->SetX(20);
	$this->Cell(60,6,strtoupper($u3['namadepan'].' '.$u3['namabelakang']),0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	
	$this->Ln(2.5);
	$this->SetFont('Arial','I',8);	
	$this->SetX(20);
	$this->Cell(60,6,'Badan Pengawas',0,0,'C');
	$this->SetX(80);
	$this->Cell(60,6,'Kepala LPD',0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
			
	
		
	}

	//Page footer
	function Footer()
	{	
		$report				=$_POST['report'];
			if (empty($report)) {
				$kd_rekening		=$_GET['idf'];
			}else{
				$kd_rekening		=substr($_POST['sub_report'],3);
			}
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(20,$this->GetY(),200,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(19);
		$this->Cell(100,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(119);
		$this->Cell(83,4,'Paraf : ............ | Buku '.namarek($kd_rekening).', Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$report				=$_POST['report'];

if (empty($report)) {
	$kd_rekening		=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$kd_rekening		=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl			="$y-$m-$d";

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle($kd_rekening.' '.namarek($kd_rekening).' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('4. '.$kd_rekening.' '.namarek($kd_rekening).' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
