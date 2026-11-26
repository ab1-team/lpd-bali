<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code

define('FPDF_FONTPATH','../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/kpdf.php'); //ppdf.php=Portrait, fpdf.php=lanscape

class PDF extends FPDF
{
	//Page header
	function Header()
	{
	
	}
	
	//Page Content
	function Content()
	{
		
		
		
    $idp=$_GET['idp'];
		
		$row=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
                          anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
                                WHERE
                                b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
                                sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
                                a.id=pi.nia AND pi.id='$idp'"));

		$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$tgl_cair			=$row['tgl_cair'];
											$alokasi			=$row['alokasi'];
											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											
											$sa_pokok			=$row['sistem'];
											
											//Sistem Angsuran
			$sj	=mysql_fetch_array(mysql_query("SELECT * FROM  sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sa_jasa AND pi.id='$id_pinj' "));
				$sa_jasa	=$sj['sistem'];
				if ($sa_pokok>=$sa_jasa) {$sistem=$sa_jasa;}elseif ($sa_jasa>$sa_pokok) {$sistem=$sa_pokok;}
											
											
											$tempo				=@($jangka/$sistem);
											$temp				=$tempo/2;
											if($temp<=1) {$tempe="1"; $bulangs=$bulan+$sistem;} elseif($temp<=3) {$tempe="3"; $bulangs=$bulan+$sistem;} else{$tempe=$temp; $bulangs=$bulan+1;}
											
			//Tempo Pokok
			$tempo_pokok		=$jangka/$sa_pokok;
			$temp_pokok			=$tempo_pokok/2;
			if($temp_pokok<=1) {$tempe_pokok="1"; $bulangs=$bulan+$sa_pokok;} elseif($temp_pokok<=3) {$tempe_pokok="3"; $bulangs=$bulan+$sa_pokok;} else{$tempe_pokok=$temp_pokok; $bulangs=$bulan+1;}
				
											$sistem_angsuran	=$row['nama_sistem'];
											
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											
											
											$lokasi				=$row['lokasi'];
											
											if($status=="P"){$tglstatus=$tgl_proposal; $ket="Tanggal Proposal"; $dok="Proposal";
											}else if($status=="V"){$tglstatus=$tgl_verifikasi; $ket="Tanggal Verifikasi"; $dok="Verifikasi";
											}else if($status=="W" or $status=="A"){$tglstatus=$tgl_cair; $ket="Tanggal Cair"; $dok="Pencairan";
											}
											$ketua			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tglstatus' "));
											
		$u=mysql_fetch_array(mysql_query("select * FROM users WHERE lokasi='$_SESSION[id]' AND level='1' AND jabatan='4'"));
		
		$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$jenis_jasa'"));			
		$sp=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sistem_angsuran'"));			
		$sj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$row[sa_jasa]'"));
		
		if($idp<9){$nomor="000$idp";}else if($idp<99){$nomor="00$idp";}else if($idp<999){$nomor="0$idp";}else{$nomor="$idp";}
		

$this->SetTextColor(0,0,0);		
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',7);
$this->Ln(-5);
$this->SetX(10);
$this->Cell(90,5,'TABEL RINGKASAN KEWAJIBAN ANGSURAN',0,0,'L',0);
$this->Ln();
$this->SetX(10);
$this->Cell(10,5,'Ke',1,0,'C',1);
$this->SetX(20);
$this->Cell(20,5,'Tanggal',1,0,'C',1);
$this->SetX(40);
$this->Cell(20,5,'Pokok',1,0,'C',1);
$this->SetX(60);
$this->Cell(20,5,'Jasa',1,0,'C',1);
$this->SetX(80);
$this->Cell(20,5,'Jumlah',1,0,'C',1);
$this->Ln();


//KE untuk 1-6
for($no=1;$no<=6;$no++) {		

//tanggal 
$tanggal			 = substr($tglstatus,8,2);
$bulan  			 = substr($tglstatus,5,2);
$tahun  			 = substr($tglstatus,0,4);
			  
$b=$bulan+$sistem*$no;
			  
if ($b>12 and $b<=24){
	$bl=$b-12;
	$th=$tahun+1;
}else if ($b>24){
	$bl=$b-24;
	$th=$tahun+2;
}else{
	$bl=$b;
	$th=$tahun;
}
			  
if ($bl<10){
	$bln="0$bl";
}else{
	$bln=$bl;
}
//end tanggal

//Pokok
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$adaangsurankah=adaangsurankah_anggota("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja_anggota("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($no<$tempo AND $adaangsurankah==0){
					$pokok=$wapok;
			  }elseif ($no>=$tempo AND $adaangsurankah==0){
					$pokok=$alokasi-$sumpok;
			  }else{
				  $pokok="0";
			  }
//End Pokok

//Jasa
$adaJasakah_anggota=adaJasakah_anggota("$th-$bln-$tanggal-$id_pinj");
$jasa=wajibjasaaja_anggota($id_pinj)*$sa_jasa;
			  if($no<=$tempo AND $adaJasakah_anggota==0){
			  $js=$jasa;
			  }else{
			  $js="0";
			  }
			  
			  $saldo=$alokasi-($wapok*($no-1));
			  if ($jenis_jasa==1){$bayar_jasa=$js;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$js;}
			  $bulat_jasa=bulatkan($bayar_jasa);
//End Jasa

$tot_pokok		=$tot_pokok+$pokok;
$tot_jasa		=$tot_jasa+$bulat_jasa;
$tot_target		=$tot_pokok+$tot_jasa;
$saldo_pokok	=$alokasi-$tot_pokok;
$saldo_jasa		=alokasi_jasa($id_pinj)-$tot_jasa;

$this->SetFont('Arial','',7);
$this->SetX(10);
$this->Cell(10,4,$no,1,0,'C',0);
$this->SetX(20);
$this->Cell(20,4,$tanggal.'/'.$bln.'/'.$th,1,0,'C',0);
$this->SetX(40);
$this->Cell(20,4,number_format($pokok, 0, ',', '.'),1,0,'R',0);
$this->SetX(60);
$this->Cell(20,4,number_format($bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->SetX(80);
$this->Cell(20,4,number_format($pokok+$bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->Ln(4);

}

//KE untuk 6 bulan terakhir
for($no=$tempo-5;$no<=$tempo;$no++) {		

//tanggal 
$tanggal			 = substr($tglstatus,8,2);
$bulan  			 = substr($tglstatus,5,2);
$tahun  			 = substr($tglstatus,0,4);
			  
$b=$bulan+$sistem*$no;
			  
if ($b>12 and $b<=24){
	$bl=$b-12;
	$th=$tahun+1;
}else if ($b>24){
	$bl=$b-24;
	$th=$tahun+2;
}else{
	$bl=$b;
	$th=$tahun;
}
			  
if ($bl<10){
	$bln="0$bl";
}else{
	$bln=$bl;
}
//end tanggal

//Pokok
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$adaangsurankah=adaangsurankah_anggota("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja_anggota("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($no<$tempo AND $adaangsurankah==0){
					$pokok=$wapok;
			  }elseif ($no>=$tempo AND $adaangsurankah==0){
					$pokok=$alokasi-$sumpok;
			  }else{
				  $pokok="0";
			  }
//End Pokok

//Jasa
$adaJasakah_anggota=adaJasakah_anggota("$th-$bln-$tanggal-$id_pinj");
$jasa=wajibjasaaja_anggota($id_pinj)*$sa_jasa;
			  if($no<=$tempo AND $adaJasakah_anggota==0){
			  $js=$jasa;
			  }else{
			  $js="0";
			  }
			  
			  $saldo=$alokasi-($wapok*($no-1));
			  if ($jenis_jasa==1){$bayar_jasa=$js;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$js;}
			  $bulat_jasa=bulatkan($bayar_jasa);
//End Jasa

$tot_pokok		=$tot_pokok+$pokok;
$tot_jasa		=$tot_jasa+$bulat_jasa;
$tot_target		=$tot_pokok+$tot_jasa;
$saldo_pokok	=$alokasi-$tot_pokok;
$saldo_jasa		=alokasi_jasa($id_pinj)-$tot_jasa;

$this->SetFont('Arial','',7);
$this->SetX(10);
$this->Cell(10,4,$no,1,0,'C',0);
$this->SetX(20);
$this->Cell(20,4,$tanggal.'/'.$bln.'/'.$th,1,0,'C',0);
$this->SetX(40);
$this->Cell(20,4,number_format($pokok, 0, ',', '.'),1,0,'R',0);
$this->SetX(60);
$this->Cell(20,4,number_format($bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->SetX(80);
$this->Cell(20,4,number_format($pokok+$bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->Ln(4);

}

//Logo
		$this->Image('../../../images/logo_lpd.gif',12,66,13,0);
		
		$this->Ln(4.5);
		
		//Arial bold 15
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(80,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'C');
		$this->Ln(3.5);
		$this->SetFont('Arial','B',10);
		$this->SetX(20);
		$this->Cell(80,0,strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),0,0,'C');
		$this->Ln(3);
		
		$this->SetFont('Arial','I',6);
		$this->SetX(20);
		$this->Cell(80,0,'SK Gubernur Bali No.'.$row['nomor_bh'],0,0,'C');
		$this->Ln(2.5);
		
		$this->SetFont('Arial','I',6);
		$this->SetX(20);
		$this->Cell(80,0,$row['alamat_desa'].', Telp.' .$row['telpon_desa'],0,0,'C');
		
		
		
		$idp=$_GET['idp'];
		
		$row=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
                          anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
                                WHERE
                                b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
                                sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
                                a.id=pi.nia AND pi.id='$idp'"));

		$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$tgl_cair			=$row['tgl_cair'];
											$alokasi			=$row['alokasi'];
											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											
											$sa_pokok			=$row['sistem'];
											
											//Sistem Angsuran
			$sj	=mysql_fetch_array(mysql_query("SELECT * FROM  sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sa_jasa AND pi.id='$id_pinj' "));
				$sa_jasa	=$sj['sistem'];
				if ($sa_pokok>=$sa_jasa) {$sistem=$sa_jasa;}elseif ($sa_jasa>$sa_pokok) {$sistem=$sa_pokok;}
											
											
											$tempo				=@($jangka/$sistem);
											$temp				=$tempo/2;
											if($temp<=1) {$tempe="1"; $bulangs=$bulan+$sistem;} elseif($temp<=3) {$tempe="3"; $bulangs=$bulan+$sistem;} else{$tempe=$temp; $bulangs=$bulan+1;}
											
			//Tempo Pokok
			$tempo_pokok		=$jangka/$sa_pokok;
			$temp_pokok			=$tempo_pokok/2;
			if($temp_pokok<=1) {$tempe_pokok="1"; $bulangs=$bulan+$sa_pokok;} elseif($temp_pokok<=3) {$tempe_pokok="3"; $bulangs=$bulan+$sa_pokok;} else{$tempe_pokok=$temp_pokok; $bulangs=$bulan+1;}
				
											$sistem_angsuran	=$row['nama_sistem'];
											
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											
											
											$lokasi				=$row['lokasi'];
											$nik				=$row['nik'];
											$nia				=$row['nia'];
											
											if($status=="P"){$tglstatus=$tgl_proposal; $ket="Tanggal Proposal"; $dok="Proposal";
											}else if($status=="V"){$tglstatus=$tgl_verifikasi; $ket="Tanggal Verifikasi"; $dok="Verifikasi";
											}else if($status=="W" or $status=="A"){$tglstatus=$tgl_cair; $ket="Tanggal Cair"; $dok="Pencairan";
											}
											$ketua			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tglstatus' "));
											
		$u=mysql_fetch_array(mysql_query("select * FROM users WHERE lokasi='$_SESSION[id]' AND level='1' AND jabatan='4'"));
		
		$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$jenis_jasa'"));			
		$sp=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sistem_angsuran'"));			
		$sj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$row[sa_jasa]'"));
		
		if($idp<9){$nomor="000$idp";}else if($idp<99){$nomor="00$idp";}else if($idp<999){$nomor="0$idp";}else{$nomor="$idp";}
		if($nia<9){$nia_id="000$nia";}else if($nia<99){$nia_id="00$nia";}else if($nia<999){$nia_id="0$nia";}else{$nia_id="$nia";}
		
//Fields Name position
$Y_Fields_Name_position = 10;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);

$this->Rect(110,3.5,95,74.5);

//QR-Code
	$qrcode="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=$row[nik].png";
		
	$this->Image($qrcode,120,57.5,15,0);

//judul
		$this->SetFont('Arial','U',14);
		$this->SetTextColor(0,0,0);
		$this->SetX(110);
		$this->Cell(100,0,'KARTU ANGSURAN',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(100,0,'No. Rek.: '.$row['no_rekening'],0,0,'C');
		$this->Ln(8);
		
		
		//Garis Garis
		//$this->SetLineWidth(0.2);
		//$this->Line(30,75,195,75);
		
		
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Nama Debitur',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->SetX(147);
		$this->Cell(68,0,strtoupper($row['namadepan']),0,0,'L');
		$this->Ln(4);
		
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'NIK / CIF',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,substr($nik,0,4).' '.substr($nik,4,4).' '.substr($nik,8,4).' '.substr($nik,12,4).' / '.$nia_id,0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Alamat',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,$row['alamat'].', '.$row['hp'],0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Tanggal Cair',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,tgl_indo($tglstatus),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Alokasi Pinjaman',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,'Rp. '.number_format($row['alokasi'],0,",","."),0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Jangka Waktu',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,$jangka.' Bulan',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Sistem Bagi Hasil',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,$pros_jasa.' %/Bulan, '.$jj['nama_jj'],0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Sistem Pokok',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,$sistem_angsuran,0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',8);
		$this->SetX(115);
		$this->Cell(30,0,'Sistem Bunga',0,0,'L');
		$this->SetX(145);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(147);
		$this->Cell(68,0,$sj['nama_sistem'],0,0,'L');
		$this->Ln(0);	
		
		
		

		//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

$this->Ln(1.5);
	$this->SetX(150);
	$this->Cell(60,6,'Kepala,',0,0,'C');

	$this->Ln(15);
	$this->SetFont('Arial','B',8);	
	$this->SetX(120);
	$this->Cell(15,6,'LID. '.$nomor,0,0,'C');
	$this->SetX(150);
	$this->Cell(60,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
		
	
		
	}

	//Page footer
	function Footer()
	{
		
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('KARTU ANGSURAN');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
