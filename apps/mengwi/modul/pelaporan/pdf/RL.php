<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		$table_rekening		="rekening_".$_SESSION['lokasi'];
		$lokasi				=$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
		$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }


			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini";  }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}

		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

		
		//Logo
		//$this->Image('logo-ubl.jpg',10,8);
		//Arial bold 15
		$this->SetFont('Arial','',6);
		//judul
		$this->SetX(20);
		$this->Cell(0,0,$row['nama_lembaga_sort']. ' Kecamatan ' .$row['nama_kec'],0,0,'L');
		//pindah baris
		$this->Ln(3);
		$this->SetX(20);
		$this->Cell(0,0,$row['alamat_kec']. ' Telpon ' .$row['telpon_kec'],0,0,'L');
		$this->Ln(10);
		//buat garis horisontal
		$this->Line(20,15,195,15);
		$this->SetFont('Arial','B',10);
		//judul
		$this->Cell(0,0,'LAPORAN RUGI LABA '.strtoupper("$jenis ".tgl_indo($tgl)),0,0,'C');
		$this->Ln(10);
		
//Fields Name position
$Y_Fields_Name_position = 29;

//First create each Field Name
//Gray color filling each Field Name box
$this->SetFillColor(255,255,255);
//Bold Font for Field Name
$this->SetFont('Arial','B',8);
$this->SetY($Y_Fields_Name_position);
$this->SetX(20);
$this->Cell(85,8,'Rekening',1,0,'C',1);
$this->SetX(105);
$this->Cell(30,8,'s.d. '.$judulL,1,0,'C',1);
$this->SetX(135);
$this->Cell(30,8,$judulC,1,0,'C',1);
$this->SetX(165);
$this->Cell(30,8,'s.d. '.$judulC,1,0,'C',1);
$this->Ln(8);

	}
	
	//Page Content
	function Content()
	{

	$table_rekening		="rekening_".$_SESSION['lokasi'];
		$lokasi				=$_SESSION['lokasi'];
		$idf				=substr($_POST['sub_report'],3);
		$d					=$_POST['d'];
		$m					=$_POST['m'];
		$y					=$_POST['y'];
		$tgl				="$y-$m-$d";
		$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
		$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }


			 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini";  }
		else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
		else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
		else{$laporan="Global";}
		
	$this->SetX(20);
	$this->Cell(175,6,'4. PENDAPATAN',1,0,'L',0);
	$this->Ln(6);
	
	$view=mysql_query("select * from jenis_buku WHERE posisi='4' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														
														$saldop=saldo("$tgl_kondisi-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$saldoplalu=saldo("$tgl_kondisibulanlalu-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='kredit' ORDER BY kd_rekening ASC ");
	
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(85,6,$row['kd_jb'].'. '.$row['nama_jb'],1,0,'L',0);
									$this->SetX(105);
									$this->Cell(30,6,number_format($saldoplalu*-1),1,0,'R',0);
									$this->SetX(135);
									$this->Cell(30,6,number_format(($saldop*-1)-($saldoplalu*-1)),1,0,'R',0);
									$this->SetX(165);
									$this->Cell(30,6,number_format($saldop*-1),1,0,'R',0);
									$this->Ln(6);
									
												while($r=mysql_fetch_array($data)){
																$saldo_pbulanlalu=saldoawalK("$tgl_kondisibulanlalu-".$r['kd_rekening'])+saldoBBK("$tgl_kondisibulanlalu-".$r['kd_rekening']);
																$saldo_p=saldoawalK("$tgl_kondisi-".$r['kd_rekening'])+saldoBBK("$tgl_kondisi-".$r['kd_rekening']);
																
															$this->SetFont('Arial','',8);	
															$this->SetX(27);
															$this->Cell(78,6,$r['kd_rekening'].'. '.$r['nama_rekening'],1,0,'L',0);
															$this->SetX(105);
															$this->Cell(30,6,number_format($saldo_pbulanlalu),1,0,'R',0);
															$this->SetX(135);
															$this->Cell(30,6,number_format($saldo_p-$saldo_pbulanlalu),1,0,'R',0);
															$this->SetX(165);
															$this->Cell(30,6,number_format($saldo_p),1,0,'R',0);
															$this->Ln(6);

													$sumpl=$sumpl+$saldo_pbulanlalu;																
													$sump=$sump+$saldo_p;															
																
												}
								
														}
														
									$this->SetFont('Arial','B',8);
									$this->SetX(20);
									$this->Cell(85,6,'TOTAL PENDAPATAN',1,0,'C',0);
									$this->SetX(105);
									$this->Cell(30,6,number_format($sumpl),1,0,'R',0);
									$this->SetX(135);
									$this->Cell(30,6,number_format($sump-$sumpl),1,0,'R',0);
									$this->SetX(165);
									$this->Cell(30,6,number_format($sump),1,0,'R',0);
									$this->Ln(6);
									
	//BIAYA
	$this->SetX(20);
	$this->Cell(175,6,'',0,0,'L',0);
	$this->Ln(6);
	
	$this->SetX(20);
	$this->Cell(175,6,'5. BIAYA',1,0,'L',0);
	$this->Ln(6);
	
	$view=mysql_query("select * from jenis_buku WHERE posisi='5' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														
														$saldobbl=saldo("$tgl_kondisibulanlalu-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$saldob=saldo("$tgl_kondisi-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='debit' ORDER BY kd_rekening ASC ");
														
														$this->SetFont('Arial','B',8);
														$this->SetX(20);
														$this->Cell(85,6,$row['kd_jb'].'. '.$row['nama_jb'],1,0,'L',0);
														$this->SetX(105);
														$this->Cell(30,6,number_format($saldobbl),1,0,'R',0);
														$this->SetX(135);
														$this->Cell(30,6,number_format($saldob-$saldobbl),1,0,'R',0);
														$this->SetX(165);
														$this->Cell(30,6,number_format($saldob),1,0,'R',0);
														$this->Ln(6);
														
														while($r=mysql_fetch_array($data)){
																$saldo_bbl=saldoawalD("$tgl_kondisibulanlalu-".$r['kd_rekening'])+saldoBBD("$tgl_kondisibulanlalu-".$r['kd_rekening']);
																$saldo_b=saldoawalD("$tgl_kondisi-".$r['kd_rekening'])+saldoBBD("$tgl_kondisi-".$r['kd_rekening']);
																
																$this->SetFont('Arial','',8);	
																$this->SetX(27);
																$this->Cell(78,6,$r['kd_rekening'].'. '.$r['nama_rekening'],1,0,'L',0);
																$this->SetX(105);
																$this->Cell(30,6,number_format($saldo_bbl),1,0,'R',0);
																$this->SetX(135);
																$this->Cell(30,6,number_format($saldo_b-$saldo_bbl),1,0,'R',0);
																$this->SetX(165);
																$this->Cell(30,6,number_format($saldo_b),1,0,'R',0);
																$this->Ln(6);
																
																
																$sumbbl=$sumbbl+$saldo_bbl;
																$sumb=$sumb+$saldo_b;
																
														}
														
														}
														
														
												$this->SetFont('Arial','B',8);
												$this->SetX(20);
												$this->Cell(85,6,'TOTAL BIAYA',1,0,'C',0);
												$this->SetX(105);
												$this->Cell(30,6,number_format($sumbbl),1,0,'R',0);
												$this->SetX(135);
												$this->Cell(30,6,number_format($sumb-$sumbbl),1,0,'R',0);
												$this->SetX(165);
												$this->Cell(30,6,number_format($sumb),1,0,'R',0);
												$this->Ln(6);
												
					$this->SetX(20);
					$this->Cell(175,3,'',0,0,'L',0);
					$this->Ln(3);
												
												$this->SetX(20);
												$this->Cell(85,8,'SURPLUS/DEVISIT/SHU',1,0,'C',0);
												$this->SetX(105);
												$this->Cell(30,8,number_format($sumpl-$sumbbl),1,0,'R',0);
												$this->SetX(135);
												$this->Cell(30,8,number_format(($sump-$sumb)-($sumpl-$sumbbl)),1,0,'R',0);
												$this->SetX(165);
												$this->Cell(30,8,number_format($sump-$sumb),1,0,'R',0);
												$this->Ln(8);
	
	
	
	
	
//TANDA TANGAN
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


	
	$this->SetX(20);
	$this->Cell(195,6,'',0,0,'C');
	$this->Ln(6);
	
	
	$this->SetX(20);
	$this->Cell(100,6,'Diperiksa oleh,',0,0,'C');
	$this->SetX(120);
	$this->Cell(95,6,'Dilaporkan oleh,',0,0,'C');
	$this->Ln(4);
	$this->SetX(20);
	$this->Cell(100,6,'BP-UPK',0,0,'C');
	$this->SetX(120);
	$this->Cell(95,6,'Pengurus UPK',0,0,'C');
	$this->Ln(6);
			
			
			$noo=0;
			while($upk=mysql_fetch_array($data)){
				$jabatan	=$upk['jabatan'];
			if($jabatan=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
			else if($jabatan=="2") {$nama_jabatan=$kec['sebutan_level_2'];}
			else if($jabatan=="3") {$nama_jabatan=$kec['sebutan_level_3'];}
			else  {$nama_jabatan=$upk['nama_jabatan'];}
			$noo=$noo+1;
	$this->SetX(120);	
	$this->Cell(95,8,$noo.'. '.$upk['namadepan'].' '.$upk['namabelakang'].' ('.$nama_jabatan.')',0,0,'L');
	$this->Ln(8);	
			}
			
			
			$no=0;
			while($bp=mysql_fetch_array($databp)){
			$no=$no+1;
	$this->SetX(20);		
	$this->Cell(100,8,$no.'. '.$bp['namadepan'].' '.$bp['namabelakang'].' ('.$bp['nama_jabatan'].')',0,0,'L');
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
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',6);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'Dicetak oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A'),0,0,'L');
		$this->Cell(0,5,'Paraf ............... | Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('Laporan Rugi Laba');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
