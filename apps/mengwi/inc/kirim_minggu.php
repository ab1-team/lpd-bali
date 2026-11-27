<?php
include "inc.koneksi.php";


$cek_row = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tunggakan_Minggu' or jenis_pesan='Tagihan_Minggu' ORDER BY id";
$result = mysql_query($cek_row);
$rowcount=mysql_num_rows($result);

// echo $rowcount;
if(!empty($rowcount)){

    if($rowcount > 2){
        $query = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tunggakan_Minggu' or jenis_pesan='Tagihan_Minggu' ORDER BY id limit 3";
        
    } else{
        $query = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tunggakan_Minggu' or jenis_pesan='Tagihan_Minggu' ORDER BY id limit 1";
        
    }

    $hasil = mysql_query($query);
    while ($row = mysql_fetch_assoc($hasil)){
    $id= $row['id'];
    $id_pinj = $row['id_pinkel'];
    $lokasi = $row['pengirim'];
    $jenis = $row['jenis_pesan'];
    $no_wa = $row['no_wa'];
    $tgl_jth_tempo = $row['tgl_jatuh_tempo'];
    

    $kec = mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
    $_SESSION['kd_kab']= $kec['kd_kab'];
    $_SESSION['lokasi']= $lokasi;
    $telpon_kec	=$kec['telpon_kec'];
    $lembaga	=substr($kec['nama_lembaga_sort'],0,8);
    $nama_kec	=strtoupper("$lembaga $kec[nama_kec]");

    
    // echo $kd_kab;
    echo "<br>";
    include_once "terbilang.php";
    include_once "fungsi_indotgl.php";
    include_once "fungsi_pinjaman.php";

    $table_kelompok	    = "kelompok_$_SESSION[kd_kab]"; //membaca session kelompok
    $table_pk		    = "pinjaman_kelompok_$_SESSION[kd_kab]"; //membaca session pinjaman_kelompok


    // $idpinj			=$row['id'];
    $tgl_kondisi	    = date('Y-m-d');
    $saldopinjaman	    = saldopinjaman("$tgl_kondisi-$id_pinj"); //memanggil dari fungsi_pinjaman
    $nunggakpokok		= nunggakpokok("$tgl_kondisi-$id_pinj"); //memanggil dari fungsi_pinjaman
    $nunggakjasa		= nunggakjasa("$tgl_kondisi-$id_pinj"); //memanggil dari fungsi_pinjaman
    $total_tunggk = number_format($nunggakpokok+$nunggakjasa); //total tagihan
        if ($nunggakpokok > 0 or $nunggakjasa > 0) {

            $qry_lo = mysql_fetch_array(mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
            WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND pk.id='$id_pinj' ORDER BY pk.id ASC"));
            $thn = substr($tgl_jth_tempo,0,4);
            $bln = substr($tgl_jth_tempo,5,2);
            $tgl = substr($tgl_jth_tempo,8,2);
            $x  = mktime(0, 0, 0, $bln, $tgl, $thn);
            $namahari = date("D", $x);
            $hari_indo = strtoupper(hariIndo($namahari));

            $nama_desa = $qry_lo['nama_desa'];
            $nama_kel = $qry_lo['nama_kelompok'];
            $pesan = "[$nama_kec] ANGSURAN Kelompok $nama_kel ($nama_desa) Rp.$total_tunggk SUDAH MELEWATI JATUH TEMPO, $hari_indo $tgl_jth_tempo, MOHON SEGERA DIBAYARKAN, TERIMAKASIH. INFO: $telpon_kec.";
            $pesan_bersih = addslashes($pesan);
           
            $data = [
                'phone' => $no_wa,
                'body' => $pesan_bersih,
            ];
            $json = json_encode($data);
           
            $url = 'https://api.chat-api.com/instance207678/sendMessage?token=mtd2tzbcfyy95g8c';
            // Make a POST request
                $options = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json
                    ]
                ]);
            // Send a request
                $result = file_get_contents($url, false, $options);
                // echo "</br>";
                // echo $result;
                // echo json_encode($data);
                $dt_json = json_decode($result);
                $dt_json1 = json_decode($json);
            
            
            $sent = $dt_json->sent;
            $tgl = date('Y-m-d H:i:s');
            if($sent == 1){
                $status = "Terkirim";
            }else{
                $status = "Pending";
            }
                
            $insert = "INSERT INTO whatsapp_terkirim VALUES('','$id','$id_pinj','$tgl_jth_tempo','','$tgl','$no_wa','$pesan_bersih','$lokasi','$jenis','$status')";
            mysql_query($insert);
            // echo "Pesan error: ".mysql_error();
            $delete = "DELETE FROM whatsapp_antrian where id = '$id'";
            mysql_query($delete);
           
            echo $id_pinj;
            // echo "___";
            // echo $total_tunggk;
            // echo "<br>";
            // echo $nama_kel;
            echo "<br>";
            echo $pesan;
            echo "<br>";
        }else{
            $delete = "DELETE FROM whatsapp_antrian where id = '$id'";
            mysql_query($delete);
        }
    }
}