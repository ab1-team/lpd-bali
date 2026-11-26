<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/fpdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		$lokasi				=$_SESSION['lokasi'];
		$table_transaksi	="transaksi_".$_SESSION['lokasi'];
		$jenis_buku			=substr($_POST['sub_report'],3);
		$table_rekening		="rekening_".$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";

		$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
		$tgl_open		=$kec['tgl_open'];
		$tgl_close		=$kec['tgl_close'];
		$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
		if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }
if($tgl_close>28){$tgl_akhir= date('Y-m-t', strtotime("$y-$m-01"));}else{ $tgl_akhir="$y-$m-$tgl_close"; }

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		
		$jb=mysql_fetch_array(mysql_query("SELECT * FROM jenis_buku where kd_jb='$idf' "));

		
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
		$this->Cell(0,0,'BUKU '.strtoupper("$jb[nama_jb] $jenis ".tgl_indo($tgl)),0,0,'C');
		$this->Ln(10);
		
//Fields Name position
$Y_Fields_Name_position = 29;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetFillColor(255,255,255);
//Bold Font for Field Name
$this->SetFont('Arial','B',8);
$this->SetY($Y_Fields_Name_position);
$this->SetX(10);
$this->Cell(10,8,'NO',1,0,'C',1);
$this->SetX(20);
$this->Cell(25,8,'TANGGAL',1,0,'C',1);
$this->SetX(45);
$this->Cell(15,8,'ID.TRX',1,0,'C',1);
$this->SetX(60);
$this->Cell(15,8,'KD.REK',1,0,'C',1);
$this->SetX(75);
$this->Cell(105,8,'KETERANGAN',1,0,'C',1);
$this->SetX(180);
$this->Cell(30,8,'DEBET',1,0,'C',1);
$this->SetX(210);
$this->Cell(30,8,'KREDIT',1,0,'C',1);
$this->SetX(240);
$this->Cell(35,8,'SALDO',1,0,'C',1);
$this->SetX(275);
$this->Cell(10,8,'P',1,0,'C',1);
$this->Ln();


		

	}
	
	//Page Content
	function Content()
	{


		$lokasi				=$_SESSION['lokasi'];
		$table_transaksi	="transaksi_".$_SESSION['lokasi'];
		$jenis_buku			=substr($_POST['sub_report'],3);
		$table_rekening		="rekening_".$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$yl					=$y-1;
		$tgl				="$y-$m-$d";

		$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
		$tgl_open		=$kec['tgl_open'];
		$tgl_close		=$kec['tgl_close'];
		$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
		if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }
if($tgl_close>28){$tgl_akhir= date('Y-m-t', strtotime("$y-$m-01"));}else{ $tgl_akhir="$y-$m-$tgl_close"; }

			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisisaldo="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kondisi="tgl_transaksi='$tgl'"; }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisisaldo=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisi=$tgl_awal; $kondisi="tgl_transaksi between '$tgl_awal' AND '$tgl_akhir' ";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisisaldo="$y-12-31"; $tgl_kondisi="$y-00-00"; $kondisi="tgl_transaksi between '$y-01-01' AND '$y-12-31' ";}
		else{$laporan="Global";}
		
		if(saldoATD("$tgl_kondisi-$idf")>=saldoATK("$tgl_kondisi-$idf") ) {
		$totsaldoawaltahun	=saldoATD("$tgl_kondisi-$idf")-saldoATK("$tgl_kondisi-$idf");
		$saldoawalbulan		=saldoABKD("$tgl_kondisi-$idf")-saldoABKK("$tgl_kondisi-$idf");
		}else{
		$totsaldoawaltahun	=saldoATK("$tgl_kondisi-$idf")-saldoATD("$tgl_kondisi-$idf");
		$saldoawalbulan		=saldoABKK("$tgl_kondisi-$idf")-saldoABKD("$tgl_kondisi-$idf");
		}
		$totsaldoawalbulan	=$totsaldoawaltahun+$saldoawalbulan;
		
$this->SetFont('Arial','',8);
$this->SetX(10);
$this->Cell(10,5,'',1,0,'C');
$this->SetX(20);
$this->Cell(25,5,$y.'-01-01',1,0,'C');
$this->SetX(45);
$this->Cell(15,5,'',1,0,'C');
$this->SetX(60);
$this->Cell(15,5,'',1,0,'C');
$this->SetX(75);
$this->Cell(105,5,'Saldo Awal Tahun '.$y.' (Tutup Buku '.$yl.')',1,0,'L');
$this->SetX(180);
$this->Cell(30,5,number_format(saldoATD("$tgl_kondisi-$idf")),1,0,'R');
$this->SetX(210);
$this->Cell(30,5,number_format(saldoATK("$tgl_kondisi-$idf")),1,0,'R');
$this->SetX(240);
$this->Cell(35,5,number_format($totsaldoawalbulan),1,0,'R');
$this->SetX(275);
$this->Cell(10,5,'',1,0,'C');
$this->Ln();

$this->SetFont('Arial','',8);
$this->SetX(10);
$this->Cell(10,5,'',1,0,'C');
$this->SetX(20);
$this->Cell(25,5,$tgl_kondisi,1,0,'C');
$this->SetX(45);
$this->Cell(15,5,'',1,0,'C');
$this->SetX(60);
$this->Cell(15,5,'',1,0,'C');
$this->SetX(75);
$this->Cell(105,5,'Saldo Awal '.$jenis.' '.tgl_indo($tgl_kondisi),1,0,'L');
$this->SetX(180);
$this->Cell(30,5,number_format(saldoABKD("$tgl_kondisi-$idf")),1,0,'R');
$this->SetX(210);
$this->Cell(30,5,number_format(saldoABKK("$tgl_kondisi-$idf")),1,0,'R');
$this->SetX(240);
$this->Cell(35,5,number_format($totsaldoawaltahun),1,0,'R');
$this->SetX(275);
$this->Cell(10,5,'',1,0,'C');
$this->Ln();


		$data=mysql_query("select * from $table_rekening r, $table_transaksi t WHERE r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_debit AND $kondisi OR  r.kd_jb='$jenis_buku'  AND r.kd_rekening=t.rekening_kredit AND $kondisi  order by tgl_transaksi, urutan, idt asc");
		while($bb=mysql_fetch_array($data)){
		$no=$no+1;
		if($bb['rekening_debit']==$bb['kd_rekening']) {
										$debit	=$bb['jumlah'];
										$kredit	="0";
										$kdrek	=$bb['rekening_debit'];
										}elseif($bb['rekening_kredit']==$bb['kd_rekening']) {
										$debit	="0";
										$kredit	=$bb['jumlah'];
										$kdrek	=$bb['rekening_kredit'];
										}
		$r=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$bb[id_user]' "));
		
		$rekening_debit			=$bb['rekening_debit'];
		$rekening_kredit		=$bb['rekening_kredit'];
		$nama_rekening			=$bb['nama_rekening'];
		//Untuk memunculkan keterangan TRX yg berbeda pada TRX BANK
		if ($rekening_debit=='122.01' OR $rekening_kredit=='121.04' OR $rekening_debit=='121.07' OR $rekening_debit=='121.08'
		OR $rekening_debit=='111.03' OR $rekening_debit=='111.04' OR $rekening_debit=='111.05'
		OR $rekening_debit=='122.01' OR $rekening_kredit=='122.04'  OR $rekening_debit=='123.01' OR $rekening_kredit=='123.04') 
		{ $keterangantransaksi=$nama_rekening; }else{$keterangantransaksi=$bb['keterangan_transaksi'];}
		//
		$ds=mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] pk, kelompok_$_SESSION[kd_kab] k, desa d WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.id='$bb[id_pinj]'"));
		if($bb['id_pinj'] >0) { $keterangan_transaksi="$keterangantransaksi $ds[nama_desa]"; }else{ $keterangan_transaksi="$keterangantransaksi"; }
		
		$prasaldo=$debit-$kredit; if($no==1) {$saldosamping=$totsaldoawalbulan+$prasaldo; } elseif($no>=2) {$saldosamping=$saldosamping+$prasaldo; }
		
		$sumdebit=$sumdebit+$debit;
		$sumkredit=$sumkredit+$kredit;
  
		
		$this->SetFont('Arial','',8);
		$this->SetX(10);
		$this->Cell(10,5,$no,1,0,'C');
		$this->SetX(20);
		$this->Cell(25,5,$bb['tgl_transaksi'],1,0,'C');
		$this->SetX(45);
		$this->Cell(15,5,$bb['idt'],1,0,'C');
		$this->SetX(60);
		$this->Cell(15,5,$kdrek,1,0,'C');
		$this->SetX(75);
		$this->Cell(105,5,$keterangan_transaksi,1,0,'L');
		$this->SetX(180);
		$this->Cell(30,5,number_format($debit),1,0,'R');
		$this->SetX(210);
		$this->Cell(30,5,number_format($kredit),1,0,'R');
		$this->SetX(240);
		$this->Cell(35,5,number_format($saldosamping),1,0,'R');
		$this->SetX(275);
		$this->Cell(10,5,$r['ins'],1,0,'C');
		$this->Ln(5);
		
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
$this->SetFont('Arial','B',8);
$this->SetX(10);
$this->Cell(170,6,'Total Transaksi '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(180);
$this->Cell(30,6,number_format($sumdebit),1,0,'R');
$this->SetX(210);
$this->Cell(30,6,number_format($sumkredit),1,0,'R');
$this->SetX(240);
$this->Cell(45,6,$ketsaldo,1,0,'C');
$this->SetX(275);
$this->Ln(6);

$this->SetFont('Arial','B',8);
$this->SetX(10);
$this->Cell(170,6,'Total Transaksi sampai dengan '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(180);
$this->Cell(30,6,number_format(saldoABKD("$tgl_kondisi-$idf")+$sumdebit),1,0,'R');
$this->SetX(210);
$this->Cell(30,6,number_format(saldoABKK("$tgl_kondisi-$idf")+$sumkredit),1,0,'R');
$this->SetX(240);
$this->SetFont('Arial','B',12);
$this->Cell(45,12,number_format($saldo),1,0,'C');
$this->Ln(6);

$this->SetFont('Arial','B',8);
$this->SetX(10);
$this->Cell(170,6,'Total Transaksi sampai dengan '.$jenis.' '.tgl_indo("$y-$m-$d"),1,0,'L');
$this->SetX(180);
$this->Cell(30,6,number_format(saldoABKD("$tgl_kondisi-$idf")+$sumdebit),1,0,'R');
$this->SetX(210);
$this->Cell(30,6,number_format(saldoABKK("$tgl_kondisi-$idf")+$sumkredit),1,0,'R');
$this->Ln(6);
	

$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$_SESSION[lokasi]' "));
$ttd_pelapor	= $kec['ttd_pelapor'];
$ttd_bp			= $kec['ttd_bp'];

	 if($ttd_pelapor=="1") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' "); }
else if($ttd_pelapor=="2") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' "); }
else if($ttd_pelapor=="3") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='2' OR u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='3' "); }
else if($ttd_pelapor=="4") { $data=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' "); }

	 if($ttd_bp=="1") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' AND u.jabatan='1' "); }
else if($ttd_bp=="2") { $databp=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='3' "); }


$this->SetFont('Arial','B',8);


	
	$this->SetX(10);
	$this->Cell(275,6,'',0,0,'C');
	$this->Ln(6);
	
	
	$this->SetX(10);
	$this->Cell(140,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(150);
	$this->Cell(135,6,'Dilaporkan oleh,',0,0,'C');
	$this->Ln(6);
			
			
			$noo=0;
			while($upk=mysql_fetch_array($data)){
				$jabatan	=$upk['jabatan'];
			if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			else if($jabatan=="2") {$nama_jabatan=$kec['sebutan_level_2'];}
			else if($jabatan=="3") {$nama_jabatan=$kec['sebutan_level_3'];}
			else  {$nama_jabatan=$upk['nama_jabatan'];}
			$noo=$noo+1;
	$this->SetX(150);	
	$this->Cell(135,8,$noo.'. '.$upk['namadepan'].' '.$upk['namabelakang'].' ('.$nama_jabatan.')',0,0,'L');
	$this->Ln(8);	
			}
			
			
			$no=0;
			while($bp=mysql_fetch_array($databp)){
			$no=$no+1;
			
	$this->Cell(140,8,$no.'. '.$bp['namadepan'].' '.$bp['namabelakang'].' ('.$bp['nama_jabatan'].')',0,0,'L');
	$this->Ln(8);
			}
	
		
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
