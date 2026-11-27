<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan_admin.php";

define('FPDF_FONTPATH','fpdf17/font/');
require('fpdf17/ppdf.php');

class PDF extends FPDF
{
	//Page header
	function Header()
	{
		
		
		//Logo 
		
		$this->Image('../../../images/abt_logo.png',21,17,24,0);
											
											
		
		
		//buat garis horisontal
		$this->SetDrawColor(21,85,92);
		$this->Line(20,15,195,15);
		$this->Line(20,16,195,16);
		
		$this->Line(20,42,195,42);
		$this->Line(20,43,195,43);
		
		
		$this->SetTextColor(21,85,92);
		
		$this->SetFont('courier','B',14);
		$this->SetX(47);
		$this->Cell(0,25,'PT. ASTA BRATA TEKNOLOGI',0,0,'L',0);
		$this->Ln(6);
		
		$this->SetFont('courier','I',9);
		$this->SetX(47);
		$this->Cell(0,20,'IT Colsulting, System, Training and Digital Audits',0,0,'L',0);
		$this->Ln(7);
		
		$this->SetFont('arial','I',8);
		$this->SetX(47);
		$this->Cell(0,15,'SK. Kementerian Hukum dan HAM RI Nomor. AHU-01329.40.10.2014 - NPWP. 66.867.912.9-524.000',0,0,'L',0);
		$this->Ln(6);
		
		$this->SetX(47);
		$this->Cell(0,10,'Office : Jalan Perintis Kemerdekaan Km 1.5, Banyuurip Tegalrejo Magelang Jawa Tengah Indonesia',0,0,'L',0);
		$this->Ln(6);
		
		$this->SetX(47);
	$this->Cell(0,5,'Telp.: (0293) 319 555 8 | E-mail: info@astabratagroup.com | Website: astabratagroup.com',0,0,'L',0);
		$this->Ln(6);
		



	}
	
	//Page Content
	function Content()
	{
		
		$nomor=$_GET['idv'];
		
		$row=mysql_fetch_array(mysql_query("select *,c.id as id_kec from kabupaten b, kecamatan c, admin_jenis_pembayaran j, admin_invoice i WHERE b.id=c.kd_kab AND j.id=i.jenis_pembayaran AND c.id=i.lokasi AND i.idv='$nomor'"));
				$tgl_invoice=$row['tgl_invoice'];
				$tgl_lunas=$row['tgl_lunas'];
				$tgl_registrasi=$row['tgl_registrasi'];
				$sts=$row['status'];
				$jenis_pembayaran=$row['jenis_pembayaran'];
				$tanggal2=date('Y-m-d', strtotime('+1 month', strtotime($tgl_invoice)));
				
				
				
				
				if($sts=="UNPAID") {
					$tanggal=$tanggal2;
					$kettgl="Jatuh Tempo";
					$status="U N P A I D";
				}else if($sts=="PAID") {
					$tanggal=$tgl_lunas;
					$kettgl="Tanggal Lunas";
					$status="P A I D";
				}
				
				//Masa Pakai
				$thn_invoice	=substr($tgl_invoice,0,4);
				$tgl_bulan_reg	=substr($tgl_registrasi,5,5); //0000-00-00
				
				$tgl_aktif1="$thn_invoice-$tgl_bulan_reg";
				
				$tgl_aktif2=date('Y-m-d', strtotime('+1 years', strtotime($tgl_aktif1)));
				
				if($jenis_pembayaran==1) {
					$keterangan	="Masa Pakai Sejak Tanggal ".tgl_indo($row['tgl_pakai']);
				}else if($jenis_pembayaran==2) {
					$keterangan	="Masa Aktif Tanggal ".tgl_indo($tgl_aktif1)." - ".tgl_indo($tgl_aktif2);
				}
				
									if($nomor<10) {
										$nomor_invoice="00000$nomor";
									}else if($nomor>=10 AND $nomor<100) {
										$nomor_invoice="0000$nomor";
									}else if($nomor>=100 AND $nomor<1000) {
										$nomor_invoice="000$nomor";
									}else if($nomor>=1000 AND $nomor<10000) {
										$nomor_invoice="00$nomor";
									}else if($nomor>=10000 AND $nomor<100000) {
										$nomor_invoice="0$nomor";
									}else if($nomor>100000) {
										$nomor_invoice="$nomor";
									}
		
		$this->SetFont('Arial','B',12);
		$this->SetX(20);
		$this->Cell(0,20,'INVOICE #'.$nomor_invoice,0,0,'L');
		
		$this->SetFont('Arial','B',12);
		$this->SetTextColor(255,0,0);
		$this->SetX(160);
		$this->Cell(0,20,$status,0,0,'L');
		$this->Ln(7);
		$this->SetTextColor(0,0,0,0);
		
if($sts=="PAID") {
		$this->Image('../../../images/lunas_abt.png',145,55,50,0);
	}
		
		$this->SetFont('Arial','',8);
		$this->SetX(20);
		$this->Cell(0,15,'Tanggal Invoice : '.tgl_ind($tgl_invoice),0,0,'L');
		$this->Ln(6);
		
		$this->SetX(20);
		$this->Cell(0,10,$kettgl.' : '.tgl_ind($tanggal),0,0,'L');
		$this->Ln(10);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,20,'Dikirim Kepada :',0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,20,strtoupper("$row[nama_lembaga_long] ($row[nama_lembaga_sort])"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,16,strtoupper("KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,12,"$row[alamat_kec] Kecamatan $row[nama_kec]",0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,7,"Telp. $row[telpon_kec]",0,0,'L');
		$this->Ln(6);
		
		
		//Fields Name position
$Y_Fields_Name_position = 98;

//First create each Field Name
//Gray color filling each Field Name box

$this->SetY($Y_Fields_Name_position);

$this->SetFillColor(29,97,122);
$this->SetTextColor(255,255,255);
$this->SetFont('Arial','B',8);
$this->SetX(21);
$this->Cell(120,8,'DESCRIPTION',0,0,'C',1);

$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,8,'TOTAL',0,0,'C',1);
$this->SetX(195);
$this->Ln(8);

$this->SetFont('Arial','',8);
$this->SetFillColor(232,232,232);
$this->SetTextColor(0,0,0);
$this->SetX(21);
$this->Cell(120,25,$keterangan,0,0,'C',1);
$this->SetX(141);
$this->Cell(54,25,'',0,0,'R',1);
$this->SetX(195);
$this->Ln(5);


$this->SetX(21);
$this->Cell(120,8,"$row[nama_jp] SI UPK Online Kecamatan $row[nama_kec]",0,0,'C');
$this->SetX(141);
$this->Cell(54,8,number_format($row['jumlah']),0,0,'R');
$this->SetX(195);
$this->Ln(20);


$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,8,'Sub Total',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,number_format($row['jumlah']),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);
if($row['id_kec']!='321'){
$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,6,'PPN 10%',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,number_format($row['jumlah']*10/100),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);


$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,6,'Discount 10%',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,number_format($row['jumlah']*10/100),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);
}
$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,6,'TOTAL',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,number_format($row['jumlah']),0,0,'R',1);
$this->SetX(195);
$this->Ln(15);

//Realisasi
$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(21);
$this->Cell(120,6,'Transaksi',0,0,'L');
$this->Ln(6);
		
$this->SetFillColor(232,232,232);
$this->SetX(21);
$this->Cell(19,8,'ID Transaksi',0,0,'C',1);
$this->SetX(40);
$this->Cell(20,8,'Tanggal',0,0,'C',1);
$this->SetX(60);
$this->Cell(100,8,'Keterangan/Metode Pembayaran',0,0,'C',1);
$this->SetX(160);
$this->Cell(35,8,'Jumlah',0,0,'C',1);
$this->SetX(195);
$this->Ln(8);

$data=mysql_query("select * from admin_transaksi WHERE idv='$nomor' order by tgl_transaksi asc");
	$jumtrx=mysql_num_rows($data);
	
	if($jumtrx>0) {
		
		while($trx=mysql_fetch_array($data)){
			
			
			$rekdeb=$trx['rekening_debit'];
			if($rekdeb=="111.1001") {
				$kettrx="Via Kas";
			}else if($rekdeb=="121.1001") {
				$kettrx="Via Transfer Bank";
			}
			
$this->SetFont('Arial','',8);
$this->SetX(21);
$this->Cell(19,6,"$trx[idt]/SI-UPK",0,0,'C');
$this->SetX(40);
$this->Cell(20,6,$trx['tgl_transaksi'],0,0,'C');
$this->SetX(60);
$this->Cell(100,6,"$trx[keterangan_transaksi] $kettrx",0,0,'L');
$this->SetX(160);
$this->Cell(35,6,number_format($trx['jumlah']),0,0,'R');
$this->SetX(195);
$this->Ln(6);

		}
		
	}else{
		
$this->SetFont('Arial','',8);
$this->SetX(21);
$this->Cell(174,6,'Belum Ada Transaksi Pembayaran',0,0,'C');
$this->SetX(195);
$this->Ln(4);

$this->SetX(21);
$this->Cell(174,6,'Silahkan melakukan pembayaran sebelum Tanggal '.tgl_ind($tanggal),0,0,'C');
$this->SetX(195);
$this->Ln(6);
		
	}
		
$this->SetFont('Arial','B',8);
$this->SetFillColor(232,232,232);
$this->SetX(21);
$this->Cell(139,6,'Total Pembayaran',0,0,'R',1);
$this->SetX(160);
$this->Cell(35,6,number_format(sumBayar($nomor)),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);

$this->SetX(21);
$this->Cell(139,6,'Sisa Tagihan',0,0,'R',1);
$this->SetX(160);
$this->Cell(35,6,number_format(sumSaldo($nomor)),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);

		
	}

	//Page footer
	function Footer()
	{
		
		$nomor=$_GET['idv'];
		
		$row=mysql_fetch_array(mysql_query("select * from admin_invoice WHERE idv='$nomor'"));
		
		$this->SetY(-50);
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,20,'Metode Pembayaran:',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,20,'Transfer Bank Mandiri',0,0,'L');
		$this->Ln(4);
		
		$this->SetX(20);
		$this->Cell(0,20,'Nomor Rekening : 1 8 5 - 0 0 - 4 8 7 - 8 8 8 8 - 6',0,0,'L');
		$this->Ln(4);
		
		$this->SetX(20);
		$this->Cell(0,20,'a.n. PT. Asta Brata Teknologi',0,0,'L');
		
		$this->SetY(-85);
		$this->SetFont('Arial','',9);
		$this->SetX(21);
		$this->Cell(84,5,'',0,0,'R');
		$this->SetX(105);
		$this->Cell(90,5,'Direktur Utama',0,0,'C');
		$this->SetX(195);
		$this->Ln(4);

		$this->SetX(21);
		$this->Cell(84,5,'',0,0,'R');
		$this->SetX(105);
		$this->Cell(90,5,'PT. Asta Brata Teknologi',0,0,'C');
		$this->SetX(195);
		$this->Ln(30);


if($row['id_user']=='2') {

		$this->Image('../../../images/ttd.png',120,213,60,0);
		
}
		
		$this->SetFont('Arial','B',9);
		$this->SetX(21);
		$this->Cell(84,5,'',0,0,'R');
		$this->SetX(105);
		
if($row['id_user']=='2') {
		$this->Cell(90,5,'S A N T O S O',0,0,'C');
}else{
		$this->Cell(90,5,'MA ARIF, S.Kom.,CEH.,CHFI.,ECSS',0,0,'C');
	}
		$this->SetX(195);
		$this->Ln(35);
			
		
		//buat garis horizontal
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','',7);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'www.siupkonline.com',0,0,'C');
		$this->Ln(3);
		
		$this->SetX(20);
		$this->Cell(0,5,'@'.date('Y'),0,0,'C');
	}
	
	
}


//contoh pemanggilan class
$pdf = new PDF();
$pdf->SetTitle('INVOICE');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>
