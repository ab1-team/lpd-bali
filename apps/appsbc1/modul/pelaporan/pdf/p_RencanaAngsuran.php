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
		
//Fields Name position
$Y_Fields_Name_position = 30;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);


//judul
		$this->SetFont('Arial','U',14);
		$this->SetTextColor(0,0,0);
		$this->Cell(0,0,'TABEL RENCANA ANGSURAN',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(0,0,'SPK Nomor: '.$row['spk_no'],0,0,'C');
		$this->Ln(4);
		$this->Cell(0,0,'Tanggal: '.tgl_ind($row['tgl_cair']),0,0,'C');
		$this->Ln(10);
		
		
		//Garis Garis
		//$this->SetLineWidth(0.2);
		//$this->Line(30,75,195,75);
		
		
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'1. Nama Debitur',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetFont('Arial','B',9);
		$this->SetX(80);
		$this->Cell(115,0,strtoupper($row['namadepan']),0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'2. Alamat',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,$row['alamat'].', '.$row['hp'],0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'3. '.$ket,0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,tgl_indo($tglstatus),0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'4. Alokasi Pinjaman',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,'Rp. '.number_format($row['alokasi'],0,",","."),0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'5. Jangka Waktu',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,$jangka.' Bulan',0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'6. Sistem Bagi Hasil',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,$pros_jasa.' %/Bulan, '.$jj['nama_jj'],0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'7. Sistem Pembayaran Pokok',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,strtoupper($sistem_angsuran),0,0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','',9);
		$this->SetX(25);
		$this->Cell(53,0,'8. Sistem Pembayaran Bunga',0,0,'L');
		$this->SetX(78);
		$this->Cell(2,0,': ',0,0,'L');
		$this->SetX(80);
		$this->Cell(115,0,strtoupper($sj['nama_sistem']),0,0,'L');
		$this->Ln(5);
		
		

//First create each Field Name
//Gray color filling each Field Name box
$this->SetLineWidth(0.2);
$this->SetDrawColor(0,0,0);
//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetFont('Arial','B',7);
$this->SetX(25);
$this->Cell(10,7,'Ke',1,0,'C',1);
$this->SetX(35);
$this->Cell(20,7,'Tanggal',1,0,'C',1);
$this->SetX(55);
$this->Cell(20,7,'Pokok',1,0,'C',1);
$this->SetX(75);
$this->Cell(20,7,'Jasa',1,0,'C',1);
$this->SetX(95);
$this->Cell(25,7,'Jumlah',1,0,'C',1);
$this->SetX(120);
$this->Cell(25,7,'Total Target',1,0,'C',1);
$this->SetX(145);
$this->Cell(25,7,'Saldo Pokok',1,0,'C',1);
$this->SetX(170);
$this->Cell(25,7,'Saldo Jasa',1,0,'C',1);
$this->Ln();

$this->SetFont('Arial','',7);

//KE
for($no=1;$no<=$tempo;$no++) {		

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

$this->SetX(25);
$this->Cell(10,5,$no,1,0,'C',0);
$this->SetX(35);
$this->Cell(20,5,$tanggal.'/'.$bln.'/'.$th,1,0,'C',0);
$this->SetX(55);
$this->Cell(20,5,number_format($pokok, 0, ',', '.'),1,0,'R',0);
$this->SetX(75);
$this->Cell(20,5,number_format($bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->SetX(95);
$this->Cell(25,5,number_format($pokok+$bulat_jasa, 0, ',', '.'),1,0,'R',0);
$this->SetX(120);
$this->Cell(25,5,number_format($tot_target, 0, ',', '.'),1,0,'R',0);
$this->SetX(145);
$this->Cell(25,5,number_format($saldo_pokok, 0, ',', '.'),1,0,'R',0);
$this->SetX(170);
$this->Cell(25,5,number_format($saldo_jasa, 0, ',', '.'),1,0,'R',0);
$this->Ln(5);

}
		
		
		
		
		//Tanda Tangan
	$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='1' AND level='1' AND lokasi='$_SESSION[lokasi]' "));
		
		$this->Ln(6);
		$this->SetFont('Arial','',9);
		$this->SetX(110);
		$this->Cell(85,0,$row['nama_desa'].', '.tgl_indo($row['tgl_cair']),0,0,'C');
		$this->Ln(6);
		
		$this->SetX(25);
		$this->Cell(85,0,'Kepala,',0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,'Debitur/Peminjam,',0,0,'C');
		$this->Ln(20);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(25);
		$this->Cell(85,0,strtoupper("$u1[namadepan] $u1[namabelakang]"),0,0,'C');
		$this->SetX(110);
		$this->Cell(85,0,strtoupper("$row[namadepan]"),0,0,'C');
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
		$this->Cell(0,5,'Paraf : ............ | Rencana Angsuran, Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('TABEL RENCANA ANGSURAN');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
