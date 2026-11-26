<?php
session_start();

include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

define('FPDF_FONTPATH', '../../../modul/pelaporan/pdf/fpdf17/font/');
require('../../../modul/pelaporan/pdf/fpdf17/ppdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetLineWidth(0.8);
        $this->Rect(25, 15, 170, 260);
        $this->Rect(25, 243, 170, 32);
    }

    function Content()
    {
        $this->Line(55, 145, 165, 145);
        $this->Line(55, 174, 165, 174);
        $this->Line(55, 197, 165, 197);

        $idp = $_GET['idp'];

        $sql = "SELECT * 
                FROM anggota_".$_SESSION['kd_kab']." a,
                     pinjaman_anggota_".$_SESSION['kd_kab']." pa
                WHERE a.id = pa.nia
                AND pa.id = '$idp'";

        $row = mysql_fetch_array(mysql_query($sql));

        $id = $row['id'];

        if ($id < 10) {
            $lid = "000".$id;
        } elseif ($id < 100) {
            $lid = "00".$id;
        } elseif ($id < 1000) {
            $lid = "0".$id;
        } else {
            $lid = $id;
        }

        $this->Image('../../../images/logo_lpd.gif', 90, 50, 40, 0);

        $nik = trim($row['nik']);

        if ($nik != '') {
            $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=".urlencode($nik);

            $img = @file_get_contents($qr_url);

            if ($img) {
                $tmp_qr = dirname(__FILE__).'/qr_temp.png';
                file_put_contents($tmp_qr, $img);

                if (file_exists($tmp_qr) && filesize($tmp_qr) > 100) {
                    $this->Image($tmp_qr, 95, 202, 30, 30, 'PNG');
                } else {
                    $this->Image('../../../images/logo_lpd.gif', 95, 202, 30, 30);
                }
            } else {
                $this->Image('../../../images/logo_lpd.gif', 95, 202, 30, 30);
            }
        } else {
            $this->Image('../../../images/logo_lpd.gif', 95, 202, 30, 30);
        }

        $this->Ln(35);

        $this->SetFont('Arial', 'B', 20);
        $this->SetX(20);
        $this->Cell(0, 100, 'DOKUMEN PENCAIRAN', 0, 0, 'C');

        $this->Ln(7);

        $this->SetFont('Arial', '', 14);
        $this->SetX(20);
        $this->Cell(0, 100, 'SPK No. '.$row['spk_no'], 0, 0, 'C');

        $this->Ln(6);

        $this->SetX(20);
        $this->Cell(0, 100, 'Tanggal: '.tgl_ind($row['tgl_cair']), 0, 0, 'C');

        $this->Ln(25);

        $this->SetX(20);
        $this->Cell(0, 100, 'Nama Debitur : ', 0, 0, 'C');

        $this->Ln(9);

        $this->SetFont('Arial', 'B', 16);
        $this->SetX(20);
        $this->Cell(0, 100, strtoupper($row['namadepan']), 0, 0, 'C');

        $this->Ln(6);

        $this->SetFont('Arial', '', 14);
        $this->SetX(20);
        $this->Cell(
            0,
            100,
            substr($row['nik'], 0, 4).' '.
            substr($row['nik'], 4, 4).' '.
            substr($row['nik'], 8, 4).' '.
            substr($row['nik'], 12, 4),
            0,
            0,
            'C'
        );

        $this->Ln(14);

        $this->SetX(20);
        $this->Cell(0, 100, 'Alamat : ', 0, 0, 'C');

        $this->Ln(9);

        $this->SetFont('Arial', '', 12);
        $this->SetX(20);
        $this->Cell(0, 100, strtoupper($row['alamat']).', '.$row['hp'], 0, 0, 'C');

        $this->Ln(14);

        $this->SetFont('Arial', '', 14);
        $this->SetX(20);
        $this->Cell(0, 100, 'Alokasi : ', 0, 0, 'C');

        $this->Ln(9);

        $this->SetFont('Arial', '', 16);
        $this->SetX(20);
        $this->Cell(0, 100, 'Rp. '.number_format($row['alokasi'], 0, ',', '.'), 0, 0, 'C');

        $this->Ln(60);

        $this->SetFont('Arial', '', 10);
        $this->SetX(20);
        $this->Cell(0, 60, 'Loan ID. '.$lid, 0, 0, 'C');
    }

    function Footer()
    {
        $sql = "SELECT * 
                FROM kabupaten b,
                     kecamatan c,
                     sebutan_desa sd,
                     desa d
                WHERE b.id = c.kd_kab
                AND c.id = d.kd_kec
                AND sd.id = d.sebutan
                AND d.id = '".$_SESSION['lokasi']."'";

        $row = mysql_fetch_array(mysql_query($sql));

        $this->SetY(-44);

        $this->SetFont('Arial', '', 12);
        $this->SetX(20);
        $this->Cell(0, 0, 'LEMBAGA PERKREDITAN DESA (LPD)', 0, 0, 'C');

        $this->Ln(5);

        $this->SetFont('Arial', 'B', 12);
        $this->SetX(20);
        $this->Cell(
            0,
            0,
            strtoupper($row['sebutan_desa']).' '.strtoupper($row['nama_desa']),
            0,
            0,
            'C'
        );

        $this->Ln(4);

        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(120, 120, 120);
        $this->SetX(20);
        $this->Cell(
            0,
            0,
            'SK Gubernur Bali No.'.$row['nomor_bh'].', '.$row['alamat_desa'].', Telp.'.$row['telpon_desa'],
            0,
            0,
            'C'
        );

        $this->Ln(1);

        $this->SetX(20);
        $this->Cell(0, 5, 'Tahun '.date('Y'), 0, 0, 'C');
    }
}

$d = $_POST['d'];
$m = $_POST['m'];
$y = $_POST['y'];

$tgl = $y . '-' . $m . '-' . $d;

$jenis = 'Tanggal';

$pdf = new PDF();
$pdf->SetTitle('Cover Laporan '.$jenis.' '.tgl_indo($tgl));
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();
?>