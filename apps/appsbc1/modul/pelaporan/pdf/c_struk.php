<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

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
		
		
		$idtp=$_GET['idtp'];
		$lokasi=$_SESSION['lokasi'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] r, transaksi_$_SESSION[lokasi] t WHERE 
					r.kd_rekening=substring(t.rekening_kredit,1,7) AND t.idtp='$idtp'"));
							
			$ja		=$row['jenis_akun'];
			$idp	=rek_id($row['rekening_kredit']);
			
		
		$r=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id='$idp' "));
				$namadepan	=$r['namadepan'];
				$nik		=$r['nik'];
				$id			=$r['id'];
				if($id<9){$lid="000$id";}else if($id<99){$lid="00$id";}else if($id<999){$lid="0$id";}else{$lid="$id";}
				$nia		=$r['nia'];
				if($nia<9){$cif="000$nia";}else if($nia<99){$cif="00$nia";}else if($nia<999){$cif="0$nia";}else{$cif="$nia";}
		
		$alokasi	=$r['alokasi'];
		
		$pokok	=pokok($idtp);
		$jasa	=jasa($idtp);
		$denda	=denda($idtp);
		$total_bayar	=$pokok+$jasa+$denda;
		
		$tgl_transaksi	=$row['tgl_transaksi'];
		$bln_transaksi	=substr($tgl_transaksi,0,7);
		$tgl_kondisi	="$bln_transaksi-31";
		
		$angsuranke		=angsuranke("$tgl_kondisi-$id");
		$targetpokok	=targetpokok("$tgl_kondisi-$id");
		$targetjasa		=targetjasa("$tgl_kondisi-$id");
		$sumpokok		=sumpokok("$tgl_transaksi-$id");
		$sumjasa		=sumjasa("$tgl_transaksi-$id");
		$saldopinjaman	=saldopinjaman("$tgl_transaksi-$id");
		$nunggakpokok	=nunggakpokok("$tgl_kondisi-$id");
		$nunggakjasa	=nunggakjasa("$tgl_kondisi-$id");
		
		$wajibpokok	=wajibpokok("$tgl_kondisi-$id");
		$wajibpokokaja	=wajibpokokaja($id);
		$wajibjasa	=wajibjasa("$tgl_kondisi-$id");
		
		$untuk		=@(floor($sumpokok/$wajibpokokaja));
	
		
	//Menghitung pengembalian bulan selanjutnya		
		if 		($sumpokok<$alokasi and $saldopinjaman>$wajibpokok)		{ $ansjut_p=$wajibpokok; 			$ansjut_j=$wajibjasa;	}	//Normal
		elseif 	($saldopinjaman<$wajibpokok and $saldopinjaman>0) 		{ $ansjut_p=$saldopinjaman; 		$ansjut_j=$wajibjasa;	}	//Angsuran Terakhir
		elseif 	($sumpokok>=$alokasi) 									{ $ansjut_p=$alokasi-$sumpokok;		$ansjut_j='0';			}	//Lunas
		
	//Menghitung total angsuran bulan depan
		$totansjut_p=$ansjut_p+$nunggakpokok;
		$totansjut_j=$ansjut_j+$nunggakjasa;
		
		
		//Ucapan Terimakasih dan tanggal cetak
		$tgl=date('d/m/Y H:i:s A');
		$tgl1=substr($r['tgl_cair'],8,2);
		$tgl2=substr($tgl_transaksi,8,2);
		$tgl_sel=$tgl2-$tgl1;
		if ($tgl_sel < 0){
		$ucapan="Terimakasih telah membayar sebelum jatuh tempo.";
		}else if ($tgl_sel == 0){
		$ucapan="Terimakasih telah membayar tepat waktu.";
		}else if ($tgl_sel > 0){
		$ucapan="Pembayaran sebelum tgl.$tgl1 TERLAMBAT $tgl_sel hari.";
		}
		
		//Kotak
		$this->SetLineWidth(0.3);
		$this->Rect(8,3.5,199,74.5);
		
		
		$lokasi=$_SESSION['lokasi'];

		$lpd=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
		
		
		//Jumlah Transaksi s.d. Record ini
$jtras=mysql_num_rows(mysql_query("SELECT * FROM transaksi_$_SESSION[lokasi] WHERE substring(rekening_kredit,9)='$id' and tgl_transaksi<='$tgl_transaksi' AND idtp<='$idtp' AND idtp!='0' GROUP BY idtp"));				
if($jtras<9){$jtra="0$jtras";}else{$jtra="$jtras";}

		//Logo
		$this->Image('../../../images/logo_lpd.gif',15,5,12,0);
		
		//arial bold 15
		$this->SetTextColor(0,0,0);
		$this->SetFont('arial','',9);
		$this->SetY(7);
		$this->SetX(28);
		$this->Cell(85,0,'LEMBAGA PERKREDITAN DESA (LPD)',0,0,'L');
		$this->Ln(4);
		$this->SetFont('arial','I',10);
		$this->SetX(28);
		$this->Cell(85,0,strtoupper($lpd['sebutan_desa']).' '.strtoupper($lpd['nama_desa']),0,0,'L');
		$this->SetFont('arial','I',10);
		$this->SetX(105);
		$this->Cell(100,0,'BUKTI PEMBAYARAN ANGSURAN',0,0,'C');
		
		$this->Ln(3.5);
		$this->SetFont('arial','I',6);
		$this->SetX(28);
		$this->Cell(85,0,$lpd['alamat_desa'].', Telp.' .$lpd['telpon_desa'],0,0,'L');
		$this->SetFont('arial','',8);
		$this->SetX(105);
		$this->Cell(100,0,'Nomor : '.$jtra.'/LID.'.$lid.'/KM'.tgl_rom($row['tgl_transaksi']).' Tanggal : '.tgl_indo($row['tgl_transaksi']),0,0,'C');

		$this->Ln(10);

		//buat garis horisontal
		$this->SetLineWidth(0.2);
		$this->SetDrawColor(0,0,0); //warna
		$this->Line(15,17,100,17);
		$this->Line(105,17,200,17);
		
		

//Fields Name position
$Y_Fields_Name_position = 20;

//First create each Field Name
//Gray color filling each Field Name box

//Bold Font for Field Name
$this->SetFillColor(232,232,232);
$this->SetY($Y_Fields_Name_position);

		
//Garis Garis
		//$this->SetLineWidth(0.2);
		//$this->Line(70,40,200,40);

		
		
		
		$this->Line(105,22,200,22);
		
		$this->SetFont('arial','',8);
		$this->SetX(15);
		$this->Cell(25,0,'Nama Debitur',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetFont('arial','I',8);
		$this->SetX(42);
		$this->Cell(58,0,strtoupper("$namadepan"),0,0,'L');
		
		$this->SetX(105);
		$this->Cell(35,0,'STATUS PINJAMAN',0,0,'C');
		$this->SetX(140);
		$this->Cell(31,0,'POKOK',0,0,'C');
		$this->SetX(171);
		$this->Cell(30,0,'BUNGA/JASA',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('arial','',8);
		$this->SetX(15);
		$this->Cell(25,0,'NIK / CIF',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,substr($nik,0,4).' '.substr($nik,4,4).' '.substr($nik,8,4).' '.substr($nik,12,4).' / '.$cif,0,0,'L');
		
		$this->SetX(105);
		$this->Cell(35,0,'Alokasi Pinjaman',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($r['alokasi'],0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,$r['pros_jasa'].'%',0,0,'C');
		$this->Ln(4);
		
		$this->SetX(15);
		$this->Cell(25,0,'Alamat',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,$r['alamat'],0,0,'L');
		
		$this->SetX(105);
		$this->Cell(35,0,'Target Pengembalian ('.$angsuranke.'x)',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($targetpokok,0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,number_format($targetjasa,0,',','.').',-',0,0,'R');
		$this->Ln(4);
		
		$this->SetX(15);
		$this->Cell(25,0,'Telpon',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,$r['hp'],0,0,'L');
		
		$this->SetX(105);
		$this->Cell(35,0,'Realisasi Pengembalian ('.$untuk.'x)',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($sumpokok,0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,number_format($sumjasa,0,',','.').',-',0,0,'R');
		$this->Ln(4);
		
		$this->SetFont('arial','',8);
		$this->SetX(15);
		$this->Cell(25,0,'Tanggal Cair',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,tgl_indo($r['tgl_cair']).', Jangka : '.$r['jangka'].' Bulan',0,0,'L');
		
		$this->Line(105,34,200,34);
		
		$this->SetFont('arial','I',8);
		$this->SetX(105);
		$this->Cell(35,0,'Saldo Pinjaman',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($saldopinjaman,0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,'',0,0,'R');
		$this->Ln(4);
		
		$this->SetFont('arial','',8);
		$this->SetX(15);
		$this->Cell(25,0,'Loan ID',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,$lid,0,0,'L');
		$this->Ln(4);
		
		$this->SetX(15);
		$this->Cell(25,0,'  - Pokok',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,': Rp.',0,0,'L');
		$this->SetX(42);
		$this->Cell(35,0,number_format($pokok,0,',','.').',-',0,0,'R');
		
		$this->Line(105,42,200,42);
		$this->Line(105,46,200,46);
		
		$this->SetFont('arial','I',8);
		$this->SetX(105);
		$this->Cell(35,0,'TAGIHAN BERIKUTNYA',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,'POKOK',0,0,'C');
		$this->SetX(171);
		$this->Cell(30,0,'BUNGA/JASA',0,0,'C');
		$this->Ln(4);
		
		$this->SetFont('arial','',8);
		$this->SetX(15);
		$this->Cell(25,0,'  - Bunga/Jasa',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,': Rp.',0,0,'L');
		$this->SetX(42);
		$this->Cell(35,0,number_format($jasa,0,',','.').',-',0,0,'R');
		
		$this->SetX(105);
		$this->Cell(35,0,'Tunggakan s.d. Bulan Ini',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($nunggakpokok,0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,number_format($nunggakjasa,0,',','.').',-',0,0,'R');
		$this->Ln(4);
		
		$this->SetX(15);
		$this->Cell(25,0,'  - Denda',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,': Rp.',0,0,'L');
		$this->SetX(42);
		$this->Cell(35,0,number_format($denda,0,',','.').',-',0,0,'R');
		
		$this->SetX(105);
		$this->Cell(35,0,'Angsuran Bulan Depan',0,0,'L');
		$this->SetX(140);
		$this->Cell(31,0,number_format($ansjut_p,0,',','.').',-',0,0,'R');
		$this->SetX(171);
		$this->Cell(30,0,number_format($ansjut_j,0,',','.').',-',0,0,'R');
		$this->Ln(5);
		
		$this->Line(15,54,100,54);
		$this->Line(15,60,100,60);
		$this->Line(105,54,200,54);
		
		$this->SetX(15);
		$this->Cell(25,0,'Jumlah Pembayaran',0,0,'C');
		$this->SetX(40);
		$this->Cell(2,0,': Rp.',0,0,'L');
		$this->SetFont('arial','',14);
		$this->SetX(42);
		$this->Cell(58,0,number_format($total_bayar,0,',','.').',-',0,0,'C');
		
		$this->SetFont('arial','I',8);
		$this->SetX(105);
		$this->Cell(35,0,'Total Tagihan Berikutnya',0,0,'L');
		$this->SetX(140);
		$this->Cell(61,0,number_format($totansjut_p+$totansjut_j,0,',','.').',-',0,0,'R');
		$this->Ln(6);
		
		$this->SetFont('arial','I',8);
		$this->SetX(15);
		$this->Cell(25,0,'Terbilang',0,0,'L');
		$this->SetX(40);
		$this->Cell(2,0,':',0,0,'L');
		$this->SetX(42);
		$this->Cell(58,0,'',0,0,'R');
		
		$this->SetFont('arial','',8);
		$this->SetX(105);
		$this->Cell(32,0,'Dibayarkan Oleh,',0,0,'C');
		$this->SetX(137);
		$this->Cell(32,0,'Diterima oleh,',0,0,'C');
		$this->SetX(169);
		$this->Cell(32,0,'Dibukukan oleh,',0,0,'C');
		$this->Ln(2);
		
		$this->SetFont('arial','I',8);
		$this->SetX(15);
		$this->MultiCell(85,4,strtoupper(toterbilang($total_bayar)).' RUPIAH',0,'C');
		//$this->Ln(0);
		
		



//Tanda Tangan

$u1=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$row[id_user]' "));
$u2=mysql_fetch_array(mysql_query("SELECT * FROM users where jabatan='3' AND level='1' AND lokasi='$_SESSION[lokasi]' "));

	$this->SetFont('arial','I',8);	
	$this->SetX(105);
	$this->Cell(32,6,strtoupper($namadepan),0,0,'C');
	$this->SetX(137);
	$this->Cell(32,6,strtoupper($u1['namadepan'].' '.$u1['namabelakang']),0,0,'C');
	$this->SetX(169);
	$this->Cell(32,6,strtoupper($u2['namadepan'].' '.$u2['namabelakang']),0,0,'C');
	

	$this->Ln(4);
		
		$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
		
		$this->SetFont('arial','I',6);
		//Footer
		$this->SetX(8);
		$this->Cell(0,5,$ucapan.' Dicetak oleh: '.$u['namadepan'].' '.$u['namabelakang'].'; pada: '.date('d/m/Y H:i:s A').'; Generated By. sim.lpd-bali.id',0,0,'L');
		
	}


	
	
}

//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('BUKTI PENERIMAAN ANGSURAN');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
