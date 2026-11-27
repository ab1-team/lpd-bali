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
		$this->Cell(0,15,'SK. Kementerian Hukum dan HAM RI Nomor. AHU-0066523.AH.01.02.Th.2020 - NPWP. 66.867.912.9-524.000',0,0,'L',0);
		$this->Ln(6);
		
		$this->SetX(47);
		$this->Cell(0,10,'Office : Jalan Perintis Kemerdekaan Km 1.5, Banyuurip Tegalrejo Magelang Jawa Tengah Indonesia',0,0,'L',0);
		$this->Ln(6);
		
		$this->SetX(47);
	$this->Cell(0,5,'Telp.: (0293) 319 555 8 | E-mail: info@abt.co.id | Website: https://abt.co.id',0,0,'L',0);
		$this->Ln(6);
		



	}
	
	//Page Content
	function Content()
	{
		
	        	$nomor              = "410";   //diisi dengan nomor invoice                                   
        		$tgl_invoice        = "2021-06-20";  //tanggal invoice
				$tgl_lunas          = "2021-07-13";  //tanggal lunas
				$sts                = "PAID";        //status "PAID" atau "UNPAID" (pastikan huruf besar semua)
				
				$jenis_pembayaran   = "2";           // 1 untuk Masa Pakai Sejak Tanggal ......, 2 untuk Masa Aktif Tanggal ........
				//1
				$tgl_pakai          = "2019-04-29";
				//2
				$tgl_registrasi     = "2020-09-01";  //tanggal awal pakai (?)
		
		        $dikirimkepada      = "Bendahara SD IT AL MA'RUF TEGALREJO";
		        $dikirimkepada2     = "Kabupaten Magelang"; //baris ke 2 dikirim kepada
		        $alamat             = "Jl. PLN Tegalrejo Magelang";
		        $nomortelp          =   "(0293) 3148955 ";
		
		        $deskripsi          = "Biaya Lisensi Perpanjangan SAbIT SD IT AL MA'RUF TEGALREJO";
                $row['jumlah']      = "9000000"; //jumlah yang harus dibayar		
		        
		        $tr                 = "ada"; // tulis "ada" jika ada transaksi yang telah dilakukan, tulis "tidak" jika tidak ada transaksi   
	            //transaksi1
                $nomortrans         = "410"; //jika tidak ada transaksi, isikan nomor dengan "-" dan yang lain NULL tanpa petik
            	$tgltrans           = "2021-07-13";
            	$kettrans           = "Biaya Lisensi Perpanjangan SAbIT SD IT AL MA'RUF TEGALREJO";//Biaya Perpanjangan SAbIT Semester Genap TA. 2020/2021 
            	$kettrans1          ="Masa Operasional : Semester Ganjil TA. 2021/2022 ";
            	$jumtrans		    = "9000000";
		        //transaksi2
                $nomortrans2         = "-"; //jika tidak ada transaksi, isikan nomor dengan "-" dan yang lain NULL tanpa petik
            	$tgltrans2           = NULL;
            	$kettrans2           = NULL;
            	$jumtrans2		    = NULL;
		        //transaksi3
                $nomortrans3         = "-"; //jika tidak ada transaksi, isikan nomor dengan "-" dan yang lain NULL tanpa petik
            	$tgltrans3           = NULL;
            	$kettrans3           = NULL;
            	$jumtrans3		    = NULL;
		        //transaksi4
                $nomortrans4         = "-"; //jika tidak ada transaksi, isikan nomor dengan "-" dan yang lain NULL tanpa petik
            	$tgltrans4           = NULL;
            	$kettrans4           = NULL;
            	$jumtrans4		    = NULL;
		        //transaksi5
                $nomortrans5         = "-"; //jika tidak ada transaksi, isikan nomor dengan "-" dan yang lain NULL tanpa petik
            	$tgltrans5           = NULL;
            	$kettrans5           = NULL;
            	$jumtrans5		    = NULL;
		
		
		
		
		
		
		
		
		
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
					$keterangan	="Masa Pakai Sejak Tanggal ".tgl_indo($tgl_pakai);
				}else if($jenis_pembayaran==2) {
					$keterangan	="Masa Operasional : Semester Ganjil TA. 2021/2022 ";
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
		$this->Cell(0,15,'Tanggal Lunas : '.tgl_ind($tgl_invoice),0,0,'L');
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
		$this->Cell(0,20,strtoupper("$dikirimkepada"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,16,strtoupper("$dikirimkepada2"),0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,12,"$alamat",0,0,'L');
		$this->Ln(6);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,7,"Telp. $nomortelp",0,0,'L');
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
$this->Cell(120,8,"$deskripsi",0,0,'C');
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

$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,6,'PPN 10%',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,"-",0,0,'R',1);
$this->SetX(195);
$this->Ln(6);

$this->SetTextColor(0,0,0);
$this->SetFont('Arial','B',8);
$this->SetX(91);
$this->Cell(50,6,'Discount 10%',0,0,'R');

$this->SetTextColor(255,255,255);
$this->SetFillColor(130,164,176);
$this->SetX(141);
$this->Cell(54,6,"-",0,0,'R',1);
$this->SetX(195);
$this->Ln(6);

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

if($tr=="ada"){			
$this->SetFont('Arial','',8);
$this->SetX(21);
$this->Cell(19,6,"$nomortrans",0,0,'C');
$this->SetX(40);
$this->Cell(20,6,$tgltrans,0,0,'C');
$this->SetX(60);
$this->Cell(100,6,"$kettrans",0,0,'C');
$this->Ln(4);
$this->SetX(60);
$this->Cell(100,6,"$kettrans1",0,0,'C');
$this->SetX(160);
$this->Cell(35,6,number_format($jumtrans),0,0,'R');
$this->SetX(195);
$this->Ln(6);
        if($nomortrans2!="-"){			
        $this->SetFont('Arial','',8);
        $this->SetX(21);
        $this->Cell(19,6,"$nomortrans2",0,0,'C');
        $this->SetX(40);
        $this->Cell(20,6,$tgltrans2,0,0,'C');
        $this->SetX(60);
        $this->Cell(100,6,"$kettrans2",0,0,'L');
        $this->SetX(160);
        $this->Cell(35,6,number_format($jumtrans2),0,0,'R');
        $this->SetX(195);
        $this->Ln(6);
        }
        if($nomortrans3!="-"){			
        $this->SetFont('Arial','',8);
        $this->SetX(21);
        $this->Cell(19,6,"$nomortrans3",0,0,'C');
        $this->SetX(40);
        $this->Cell(20,6,$tgltrans3,0,0,'C');
        $this->SetX(60);
        $this->Cell(100,6,"$kettrans3",0,0,'L');
        $this->SetX(160);
        $this->Cell(35,6,number_format($jumtrans3),0,0,'R');
        $this->SetX(195);
        $this->Ln(6);
        }
        if($nomortrans4!="-"){			
        $this->SetFont('Arial','',8);
        $this->SetX(21);
        $this->Cell(19,6,"$nomortrans4",0,0,'C');
        $this->SetX(40);
        $this->Cell(20,6,$tgltrans4,0,0,'C');
        $this->SetX(60);
        $this->Cell(100,6,"$kettrans4",0,0,'L');
        $this->SetX(160);
        $this->Cell(35,6,number_format($jumtrans4),0,0,'R');
        $this->SetX(195);
        $this->Ln(6);
        }
        if($nomortrans5!="-"){			
        $this->SetFont('Arial','',8);
        $this->SetX(21);
        $this->Cell(19,6,"$nomortrans5",0,0,'C');
        $this->SetX(40);
        $this->Cell(20,6,$tgltrans5,0,0,'C');
        $this->SetX(60);
        $this->Cell(100,6,"$kettrans5",0,0,'L');
        $this->SetX(160);
        $this->Cell(35,6,number_format($jumtrans5),0,0,'R');
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
	$totalbayar = $jumtrans +$jumtrans2+$jumtrans3+$jumtrans4+$jumtrans5;
	$sisatagihan= $row['jumlah']-$totalbayar;
$this->SetFont('Arial','B',8);
$this->SetFillColor(232,232,232);
$this->SetX(21);
$this->Cell(139,6,'Total Pembayaran',0,0,'R',1);
$this->SetX(160);
$this->Cell(35,6,number_format($totalbayar),0,0,'R',1);
$this->SetX(195);
$this->Ln(6);

$this->SetX(21);
$this->Cell(139,6,'Sisa Tagihan',0,0,'R',1);
$this->SetX(160);
$this->Cell(35,6,number_format($sisatagihan),0,0,'R',1);
$this->SetX(195);
$this->Ln(4);

		
	}

	//Page footer
	function Footer()
	{
		
		$nomor=122;
		
		$row=mysql_fetch_array(mysql_query("select * from admin_invoice WHERE idv='$nomor'"));
		
		$this->SetY(-50);
		$this->SetFont('Arial','B',9);
		$this->SetX(20);
		$this->Cell(0,20,'Pembayaran Transfer Via :',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,20,' - Bank Mandiri Nomor Rekening : 185-00-487-8888-6',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,20,'   an. PT. Asta Brata Teknologi',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,20,' - Bank BRI Nomor Rekening : 0048-01-057317-50-5',0,0,'L');
		$this->Ln(4);
		
		$this->SetFont('Arial','',9);
		$this->SetX(20);
		$this->Cell(0,20,'   an. Santoso',0,0,'L');
		$this->Ln(4);
		
		$this->SetY(-95);
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

		$this->Image('../../../images/ttd.png',120,204,60,0);
		
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
		$this->Ln(40);
			
		
		//buat garis horizontal
		$this->Line(20,$this->GetY(),197,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','',7);
		//nomor halaman
		$this->SetX(20);
		$this->Cell(0,5,'https://abt.co.id',0,0,'C');
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
