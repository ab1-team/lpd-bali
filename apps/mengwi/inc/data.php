<?php

include "inc.koneksi.php";


$ip         =  $_SERVER['REMOTE_ADDR'];
$host		=  $_SERVER['HTTP_HOST'];

// echo $rmt;
// echo $url;

// $tgl=date('Y-m-d H:i:s');

if(empty($ip) && empty($host)){
// code untuk pengaman, yang hanya bisa diinput oleh cron job
    
$cek_row = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tagihan' OR jenis_pesan='Tunggakan' OR jenis_pesan='Notifikasi' ORDER BY id";
$result = mysql_query($cek_row);
$rowcount=mysql_num_rows($result);
// echo $rowcount;

    if($rowcount > 2){
        $query = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tagihan' OR jenis_pesan='Tunggakan' OR jenis_pesan='Notifikasi' ORDER BY id limit 3";
        
    } else{
        // $query = "SELECT * FROM whatsapp_antrian ORDER BY id";
        $query = "SELECT * FROM whatsapp_antrian WHERE jenis_pesan='Tagihan' OR jenis_pesan='Tunggakan' OR jenis_pesan='Notifikasi' ORDER BY id limit 1";
        
    }

    $hasil = mysql_query($query);

    // $dt_wa = [];

    while ($row = mysql_fetch_assoc($hasil)){
    //  $dt[] = $row; 
 
            $data = [
                'phone' => $row['no_wa'],
                'body' => $row['pesan'],
            ];

            // $dt_wa['id'] = $row['id'];
            // $dt_wa['pesan'] = $row['pesan'];

            //  $dt_wa = $row['pesan']; 
        $json = json_encode($data);
        // echo json_encode($data);
        
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
        
        $id = $row['id'];
        $id_tr = $row['id_transaksi'];
        $tgl = date('Y-m-d H:i:s');
        $tgl_jt = $row['tgl_jatuh_tempo'];
        $no_wa = $dt_json1->phone;
        $pesan = $dt_json1->body;
        $pesan_bersih = addslashes($pesan);
        $idp = $row['id_pinkel'];
        $pengirim = $row['pengirim'];
        $jenis = $row['jenis_pesan'];
        $sent = $dt_json->sent;
        // echo $tgl_jt;
        echo "</br>";
        if($sent == 1){
            $status = "Terkirim";
        }else{
            $status = "Pending";
        }
        $insert = "INSERT INTO whatsapp_terkirim VALUES('','$id','$idp','$tgl_jt','$id_tr','$tgl','$no_wa','$pesan_bersih','$pengirim','$jenis','$status')";
        mysql_query($insert);
        // echo "Pesan error: ".mysql_error();
        $delete = "DELETE FROM whatsapp_antrian where id = '$id'";
        mysql_query($delete);
        
        // echo $id;
    }

//  print_r($dt_wa);
    
    
} else{
    echo "<h1>Access Denied</h1>";
}

