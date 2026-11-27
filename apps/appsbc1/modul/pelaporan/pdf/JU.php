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
	$jenis_buku				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$jenis_buku			=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}
		$tgl				="$y-$m-$d";

		$tgl_awal="$y-$m-01"; 

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-31' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));

		$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_akun a, rekening_$_SESSION[lokasi] r where a.id=r.id_akun AND r.kd_rekening='$idf' "));

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
		$this->SetX(100);
		$this->Cell(96,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'R');
		$this->Ln(5);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(128,128,128); //warna
		$this->Line(34,16,196,16);
		
		//judul
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'J U R N A L   U M U M',0,0,'C');
		$this->Ln(4);
		$this->Cell(0,0,strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		$this->Ln(2);
		
//Fields Name position
$Y_Fields_Name_position = 30;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',7);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(7,6,'No',1,0,'C',1);
$this->SetX(27);
$this->Cell(20,6,'Tanggal',1,0,'C',1);
$this->SetX(47);
$this->Cell(13,6,'ID.Trx',1,0,'C',1);
$this->SetX(60);
$this->Cell(20,6,'Kd.Rek',1,0,'C',1);
$this->SetX(80);
$this->Cell(60,6,'Keterangan',1,0,'C',1);
$this->SetX(140);
$this->Cell(25,6,'Debit',1,0,'C',1);
$this->SetX(165);
$this->Cell(25,6,'Kredit',1,0,'C',1);
$this->SetX(190);
$this->Cell(6,6,'P',1,0,'C',1);
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
		$jenis_buku			=$_GET['idf'];
		$d					=$_GET['d'];
		$m					=$_GET['m'];
		$y					=$_GET['y'];
	}else{
		$idf				=substr($_POST['sub_report'],3);
		$jenis_buku			=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
	}
		$yl					=$y-1;
		$tgl				="$y-$m-$d";

		$tgl_awal="$y-$m-01";

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo="$y-$m-31"; $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$y-$m-31' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}
		


		$data=mysql_query("select * from $table_transaksi WHERE $kondisi  order by tgl_transaksi, urutan, idt asc");
		while($row=mysql_fetch_array($data)){
		$no=$no+1;
		
			$debit			=$row['jumlah'];
			$kredit			=$row['jumlah'];
			$kd_debit		=rek($row['rekening_debit']);
			$kd_kredit		=rek($row['rekening_kredit']);
										
		$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));
		$bd=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening where kd_rekening='$kd_debit' "));
		$bk=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening where kd_rekening='$kd_kredit' "));
		
		

		$sumdebit=$sumdebit+$debit;
		$sumkredit=$sumkredit+$kredit;
  
		
		$this->SetLineWidth(0);
		$this->SetDrawColor(0,0,0);		
		$this->SetFont('Arial','',7);
		$this->SetX(20);
		$this->Cell(7,6,$no,1,0,'C');
		$this->SetX(27);
		$this->Cell(20,6,tgl_ind($row['tgl_transaksi']),1,0,'C');
		$this->SetX(47);
		$this->Cell(13,6,$row['idt'],1,0,'C');
		
		//KOSONG
		$this->SetX(60);
		$this->Cell(20,6,'',1,0,'C');
		$this->SetX(80);
		$this->Cell(60,6,'',1,0,'L');
		$this->SetX(140);
		$this->Cell(25,6,'',1,0,'R');
		$this->SetX(165);
		$this->Cell(25,6,'',1,0,'R');
		$this->SetX(190);
		$this->Cell(6,6,'',1,0,'C');
		$this->Ln(0);
		
		
		//DEBIT
		$this->SetX(60);
		$this->Cell(20,3.5,$kd_debit,0,0,'L');
		$this->SetX(80);
		$this->Cell(60,3.5,$bd['nama_rekening'],0,0,'L');
		$this->SetX(140);
		$this->Cell(25,3.5,number_format($debit,2,',','.'),0,0,'R');
		$this->SetX(165);
		$this->Cell(25,3.5,'',0,0,'R');
		$this->SetX(190);
		$this->Cell(6,6,$r['ins'],0,0,'C');
		$this->Ln(3);
		
		//KREDIT
		$this->SetX(60);
		$this->Cell(20,3,$kd_kredit,0,0,'R');
		$this->SetX(80);
		$this->Cell(60,3,'',0,0,'L');
		$this->SetX(83);
		$this->Cell(57,3,$row['keterangan_transaksi'],0,0,'L');
		$this->SetX(140);
		$this->Cell(25,3,'',0,0,'R');
		$this->SetX(165);
		$this->Cell(25,3,number_format($kredit,2,',','.'),0,0,'R');
		$this->Ln(3);
		
		
		}
		
$saldo=saldo("$tgl_kondisisaldo-$idf");
								if($saldo>0) {
								$saldo=$saldo;
								$ketsaldo="Saldo Debit";
								}elseif($saldo<0){
								$saldo=$saldo*-1;
								$ketsaldo="Saldo Kredit";
								}
		
//JUMLAH BAWAH
$this->SetFillColor(232,232,232);
$this->SetLineWidth(0);
$this->SetFont('Arial','B',7);
$this->SetX(20);
$this->Cell(120,7,'Total Transaksi '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'C',1);
$this->SetX(140);
$this->Cell(25,7,number_format(saldoABKD("$tgl_kondisi-$idf")+$sumdebit,2,',','.'),1,0,'R',1);
$this->SetX(165);
$this->Cell(25,7,number_format(saldoABKK("$tgl_kondisi-$idf")+$sumkredit,2,',','.'),1,0,'R',1);
$this->SetX(190);
$this->Cell(6,7,'',1,0,'C',1);
$this->Ln(6);


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
	$this->Cell(60,6,'Kepala '.LEMBAGA_SORT,0,0,'C');
	$this->SetX(140);
	$this->Cell(60,6,'Accounting',0,0,'C');
			
	
		
	}

	//Page footer
	function Footer()
	{
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-20);
		//buat garis horizontal
		$this->SetDrawColor(0,0,0);
		$this->Line(20,$this->GetY(),196,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(90,4,'Disajikan oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		$this->SetX(110);
		$this->Cell(88,4,'Paraf : ............ | Jurnal Umum, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

$d=$_POST['d'];
	$m=$_POST['m'];
	$y=$_POST['y'];
	$tgl="$y-$m-$d";
if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Jurnal Umum '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output('3. Jurnal Umum '.$jenis.' '.tgl_indo($tgl).' ('.$pdf->PageNo().' halaman).pdf','I');
?>
