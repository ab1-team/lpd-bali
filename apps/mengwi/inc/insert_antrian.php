<?php
session_start();
include "inc.koneksi.php";
// include_once "terbilang.php";
// include_once "fungsi_indotgl.php";
// include_once "fungsi_pinjaman.php";
// include_once "Tunggakan.php";


function Tagihan($tgl2, $hari_indo, $tgl_tagihan, $tgl_jth_tempo, $jenis_pesan){
    $table_kelompok	= "kelompok_$_SESSION[kd_kab]"; //membaca session kelompok
    $table_pk		= "pinjaman_kelompok_$_SESSION[kd_kab]"; //membaca session pinjaman_kelompok

    $lokasi = "$_SESSION[lokasi]"; //membaca session lokasi

//query untuk ambil data kecamatan
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$telpon_kec	=$kec['telpon_kec'];
$lembaga	=substr($kec['nama_lembaga_sort'],0,8);
$nama_kec	=strtoupper("$lembaga $kec[nama_kec]");

//query untuk ambil data pinjaman kelompok
$query=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
					WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND 
                    substring(tgl_cair,9,2)='$tgl2' ORDER BY pk.tgl_cair ASC  ");
                    
                    while($row=mysql_fetch_array($query)){
                        $idpinj			=$row['id'];
                        $tgl_kondisi	=date('Y-m-d');
                        $nama_desa = $row['nama_desa'];
                        $saldopinjaman	    = saldopinjaman("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $nunggakpokok		= nunggakpokok("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $nunggakjasa		= nunggakjasa("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $total_tag = number_format($nunggakpokok+$nunggakjasa); //total tagihan
                        //ambil data nomor telepon
                        $no = $row['telpon']; // 081234567891
                        $numerik	=is_numeric($no); //Memeriksa apakah nomor telpon berupa Angka
                        $jumhp		=strlen($no); //Memeriksa jumlah digit pada nomor telpon, normalnya minimal ada 10 digit
                        $no1 = substr("$no",1); // 81234567891
                        $telp = !empty($no) ? "62".$no1 : ""; // 6281234567891
                        $id_k = $row['id_kel'];

                        $namakel = $row['nama_kelompok'];//kelompok pinjaman
                        
                        if($jumhp>=10 AND $numerik==1){
                        
                            if ($nunggakpokok > 0 or $nunggakjasa > 0) {//cek saldo pinjaman 
                                
                                $tgl=date('Y-m-d H:i:s');
                                
                                //template pesan untuk dikirim
                                $pesan = "[$nama_kec] ANGSURAN Kelompok $namakel ($nama_desa) Rp.$total_tag AKAN MEMASUKI JATUH TEMPO, MOHON SEGERA DIBAYARKAN SEBELUM $hari_indo, $tgl_jth_tempo, TERIMAKASIH. INFO: $telpon_kec.";
                                $pesan_bersih = addslashes($pesan);
                                // echo $pesan;
                                // echo"</br>";
                                // SELECT SUBSTRING("2020-11-25 21:52:12", 1, 10) AS ExtractString;
                                // 2020-11-25
                                //cek di table whatsapp_terkirim apakah sudah ada data pesan?
                                $cek_row = "SELECT * FROM whatsapp_terkirim WHERE id_pinkel='$idpinj'  AND tgl_jatuh_tempo='$tgl_tagihan' ORDER BY id";
                                $result = mysql_query($cek_row);
                                $rowcount=mysql_num_rows($result);
                                //cek di table whatsapp_antrian apakah sudah ada data pesan?
                                $cek_row1 = "SELECT * FROM whatsapp_antrian WHERE id_pinkel='$idpinj' AND tgl_jatuh_tempo='$tgl_tagihan' ORDER BY id";
                                $result1= mysql_query($cek_row1);
                                $rowcount1=mysql_num_rows($result1);
                                // echo "....".$rowcount;
                                // echo"</br>";
                                if($rowcount == 0 && $rowcount1 == 0){
                                    //kondisi jika terpenuhi akan insert ke whatsapp_antrian
                                    $sql = "INSERT INTO whatsapp_antrian VALUES('','$idpinj','0','$tgl_tagihan','$tgl','$telp','$pesan_bersih','$lokasi','$jenis_pesan') "; 
                                    // $sql = "INSERT INTO whatsapp_antrian (id, id_pinkel,id_transaksi,tgl_diantrikan,no_wa,pesan,pengirim,jenis_pesan) VALUES('','$idpinj','0','$tgl','$telp','$pesan','$lokasi','Tagihan') "; 
                                    // $sql = "INSERT INTO whatsapp_antrian ('id','id_pinkel','id_transaksi','tgl_diantrikan','no_wa','pesan','pengirim','jenis_pesan') VALUES('','$idpinj','0','$tgl','$telp','$pesan','$lokasi','Tagihan') "; 
                                    mysql_query($sql);
                                    // echo "cek table";
                                    // echo "ID : ";
                                    // echo $idpinj;
                                    // echo "</br>";
                                    // echo "TGL :";
                                    // echo $tgl;
                                    // echo "</br>";
                                    // echo "TELP :";
                                    // echo $telp;
                                    // echo "</br>";
                                    // echo "PESAN :";
                                    // echo $pesan;
                                    // echo "</br>";
                                    // echo "LOKASI :";
                                    // echo $lokasi;
                                    // echo "</br>";
                                    // echo "---------";
                                    // echo "</br>";
        
                                }
        
                                }
                        }
                    }
}
function TunggK($tgl2, $hari_indo, $tgl_tunggakan, $tgl_jth_tempo){
    $table_kelompok	= "kelompok_$_SESSION[kd_kab]"; //membaca session kelompok
    $table_pk		= "pinjaman_kelompok_$_SESSION[kd_kab]"; //membaca session pinjaman_kelompok

    $lokasi = "$_SESSION[lokasi]"; //membaca session lokasi

//query untuk ambil data kecamatan
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$telpon_kec	=$kec['telpon_kec'];
$lembaga	=substr($kec['nama_lembaga_sort'],0,8);
$nama_kec	=strtoupper("$lembaga $kec[nama_kec]");

//query untuk ambil data pinjaman kelompok
$query=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk 
					WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND 
                    substring(tgl_cair,9,2)='$tgl2' ORDER BY pk.tgl_cair ASC  ");
                    
                    while($row=mysql_fetch_array($query)){
                        $idpinj			=$row['id'];
                        $tgl_kondisi	=date('Y-m-d');
                        $nama_desa = $row['nama_desa'];
                        $saldopinjaman	    = saldopinjaman("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $nunggakpokok		= nunggakpokok("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $nunggakjasa		= nunggakjasa("$tgl_kondisi-$idpinj"); //memanggil dari fungsi_pinjaman
                        $total_tag = number_format($nunggakpokok+$nunggakjasa); //total tunggakan
                        //ambil data nomor telepon
                        $no = $row['telpon']; // 081234567891
                        $numerik	=is_numeric($no); //Memeriksa apakah nomor telpon berupa Angka
                        $jumhp		=strlen($no); //Memeriksa jumlah digit pada nomor telpon, normalnya minimal ada 10 digit
                        $no1 = substr("$no",1); // 81234567891
                        $telp = !empty($no) ? "62".$no1 : ""; // 6281234567891
                        $id_k = $row['id_kel'];

                        $namakel = $row['nama_kelompok'];//kelompok pinjaman
                        
                        if($jumhp>=10 AND $numerik==1){
                        
                            if ($nunggakpokok > 0 or $nunggakjasa > 0) {//cek saldo pinjaman 
                                
                                $tgl=date('Y-m-d H:i:s');
                                
                                //template pesan untuk dikirim
                                $pesan = "[$nama_kec] ANGSURAN Kelompok $namakel ($nama_desa) Rp.$total_tag SUDAH MELEWATI JATUH TEMPO $hari_indo $tgl_jth_tempo, MOHON UNTUK SEGERA DIBAYARKAN, TERIMAKASIH. INFO: $telpon_kec.";
                                $pesan_bersih = addslashes($pesan);
                                // echo $pesan;
                                // echo"</br>";
                                // SELECT SUBSTRING("2020-11-25 21:52:12", 1, 10) AS ExtractString;
                                // 2020-11-25
                                //cek di table whatsapp_terkirim apakah sudah ada data pesan?
                                $cek_row = "SELECT * FROM whatsapp_terkirim WHERE id_pinkel='$idpinj'  AND tgl_jatuh_tempo='$tgl_tunggakan'  ORDER BY id";
                                $result = mysql_query($cek_row);
                                $rowcount=mysql_num_rows($result);
                                //cek di table whatsapp_antrian apakah sudah ada data pesan?
                                $cek_row1 = "SELECT * FROM whatsapp_antrian WHERE id_pinkel='$idpinj' AND tgl_jatuh_tempo='$tgl_tunggakan'  ORDER BY id";
                                $result1= mysql_query($cek_row1);
                                $rowcount1=mysql_num_rows($result1);
                                // echo "....".$rowcount;
                                // echo"</br>";
                                if($rowcount == 0 && $rowcount1 == 0){
                                    //kondisi jika terpenuhi akan insert ke whatsapp_antrian
                                    $sql = "INSERT INTO whatsapp_antrian VALUES('','$idpinj','0','$tgl_tunggakan','$tgl','$telp','$pesan_bersih','$lokasi','Tunggakan_Minggu') "; 
                                    // $sql = "INSERT INTO whatsapp_antrian (id, id_pinkel,id_transaksi,tgl_diantrikan,no_wa,pesan,pengirim,jenis_pesan) VALUES('','$idpinj','0','$tgl','$telp','$pesan','$lokasi','tunggakan') "; 
                                    // $sql = "INSERT INTO whatsapp_antrian ('id','id_pinkel','id_transaksi','tgl_diantrikan','no_wa','pesan','pengirim','jenis_pesan') VALUES('','$idpinj','0','$tgl','$telp','$pesan','$lokasi','tunggakan') "; 
                                    mysql_query($sql);
                                    // echo "cek table";
                                    // echo "ID : ";
                                    // echo $idpinj;
                                    // echo "</br>";
                                    // echo "TGL :";
                                    // echo $tgl;
                                    // echo "</br>";
                                    // echo "TELP :";
                                    // echo $telp;
                                    // echo "</br>";
                                    // echo "PESAN :";
                                    // echo $pesan;
                                    // echo "</br>";
                                    // echo "LOKASI :";
                                    // echo $lokasi;
                                    // echo "</br>";
                                    // echo "---------";
                                    // echo "</br>";
        
                                }
        
                                }
                        }
                    }
}
$lokasi = "$_SESSION[lokasi]"; //membaca session lokasi

//query untuk ambil data kecamatan
$kec=mysql_fetch_array(mysql_query("SELECT set_hari FROM kecamatan WHERE id='$lokasi' "));
if($kec['set_hari']!=0){
    $tag_hari = $kec['set_hari']; // jumlah hari untuk di tambah
    // echo "<br>";
    $tgl=date('d');
    $tgl_kondisi=date('Y-m-d');
    //untuk menambah hari sesuai tagihan, 3 atau 7 hari
    $tgl2 = date('d', strtotime("$tag_hari days", strtotime($tgl_kondisi))); 
    //untuk create tanggal dengan format 2020-12-01(YYYY-mm-dd)
    $x  = mktime(0, 0, 0, date("m"), $tgl2, date("Y"));
    $tgl_tagihan = date("Y-m-d", $x);
    //untuk create tanggal dengan format 01-12-2020(dd-mm-YYYY)
    $tgl_jth_tempo = date("d-m-Y", $x);
    $jenis_pesan = "Tagihan";
    //create nama hari
    $namahari = date("D", $x);
    $hari_indo = strtoupper(hariIndo($namahari)); //memanggil dari fungsi_indotgl.php
    // echo "hari ditambah $tag_hari hari =".$tgl_tagihan;
    // echo "<br>";
    // echo "nama hari ". strtoupper(hariIndo($namahari));
    // echo "<br>";
    Tagihan($tgl2, $hari_indo, $tgl_tagihan, $tgl_jth_tempo, $jenis_pesan);
    if($namahari == 'Sun'){
    
        $tgl_kondisi_minggu = $tgl_tagihan;
        $tgl_khusus_minggu = date('d', strtotime("$tag_hari days", strtotime($tgl_kondisi_minggu)));
        $y  = mktime(0, 0, 0, date("m"), $tgl_khusus_minggu, date("Y"));
        $namahari_2 = date("D", $y);
        $hari_indo_2 = strtoupper(hariIndo($namahari_2)); //memanggil dari fungsi_indotgl.php
        $tgl_tagihan_2 = date("Y-m-d", $y);
        $tgl_jth_tempo_2 = date("d-m-Y", $y);
        $jenis_pesan_2 = "Tagihan_Minggu";
        Tagihan($tgl_khusus_minggu, $hari_indo_2, $tgl_tagihan_2, $tgl_jth_tempo_2, $jenis_pesan_2);
        
        //untuk tunggakan hari minggu
        $tgl_tunggk = $tag_hari*(-1);
        $tgl_khusus_2 = date('d', strtotime("$tgl_tunggk days", strtotime($tgl_kondisi_minggu)));
        $z  = mktime(0, 0, 0, date("m"), $tgl_khusus_2, date("Y"));
        $namahari_3 = date("D", $z);
        $hari_indo_3 = strtoupper(hariIndo($namahari_3)); //memanggil dari fungsi_indotgl.php
        $tgl_tagihan_3 = date("Y-m-d", $z);
        $tgl_jth_tempo_3 = date("d-m-Y", $z);
        
        
        TunggK($tgl_khusus_2, $hari_indo_3, $tgl_tagihan_3, $tgl_jth_tempo_3);
        // echo $namahari_3;
        // echo "<br>";
        // echo $tgl_tunggk;
        // echo "<br>";
        // echo $tgl_khusus_2;
        // echo "<br>";
        // echo $tgl_tagihan_3;
        // echo "<br>";
        // echo $tgl_jth_tempo_3;
        
        // echo"minggu ";
        // echo $tgl_jth_tempo;
        // echo "<br>";
        // echo $tgl2;
        // echo "<br>";
        // echo $tgl_tagihan;
        
        // echo "<br>";
        // echo $tgl_khusus_minggu;
        // echo "<br>";
        // echo $hari_indo_2;
        
        // echo "<br>";
        // echo $tgl_tagihan_2;
        // echo "<br>";
        // echo $tgl_jth_tempo_2;
    }
}
                   ?>

