<?php
    session_start();
    include "../../inc/inc.koneksi.php";
    
    $limit = $_GET['length'];
    $start = $_GET['start'];
    $search = $_GET['search']['value'];
    
    $order = $_GET['order'][0]['column'];
    $type = $_GET['order'][0]['dir'];
    
    $ordering = $order . ' ' . $type;
    
    $view = mysql_query("select * from desa d, jenis_kegiatan j, kelompok_$_SESSION[kd_kab] k WHERE 
                        d.id=k.desa and k.lokasi='$_SESSION[lokasi]' and k.jenis_kegiatan=j.id and
                        (k.id LIKE '%$search%' OR k.kd_kelompok LIKE '%$search%' OR k.nama_kelompok LIKE '%$search%' OR
                        j.nama_jk LIKE '%$search%' OR k.alamat_kelompok LIKE '%$search%' OR d.nama_desa LIKE '%$search%'
                        OR k.telpon LIKE '%$search%') order by $ordering LIMIT $start, $limit");
    
    $rows = mysql_num_rows($view);
    $total_rows = mysql_num_rows(mysql_query("select * from desa d, jenis_kegiatan j, kelompok_$_SESSION[kd_kab] k WHERE 
                        d.id=k.desa and k.lokasi='$_SESSION[lokasi]' and k.jenis_kegiatan=j.id and
                        (k.id LIKE '%$search%' OR k.kd_kelompok LIKE '%$search%' OR k.nama_kelompok LIKE '%$search%' OR
                        j.nama_jk LIKE '%$search%' OR k.alamat_kelompok LIKE '%$search%' OR d.nama_desa LIKE '%$search%'
                        OR k.telpon LIKE '%$search%') order by $ordering"));
    
    $no = $start;
    $data = [];
    while($row=mysql_fetch_array($view)) { 
        $no = $no+1;
        
        $dpa = mysql_query("select * from status_pinjaman s, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE s.kd_status=pk.status AND pk.id_kel='$row[id]'");
    	$pa	= mysql_num_rows($dpa);
    	if ($pa > 0) {
    		$r = mysql_fetch_array($dpa);
    		$status =$r['kd_status']; $bg=$r['warna_status'];
    	} else {
    	    $status ="N"; $bg="default";
    	}
        
        $jpp = $row['jenis_produk_pinjaman'];
        if ($jpp=="1") {
            $gb="female";
        } else {
            $gb="male";
        }
        
        $data[] = [
            "no"            => $no,
            "id"            => "$row[id]",
            "kd_kelompok"   => "$row[kd_kelompok]",
            "nama_kelompok" => "$row[nama_kelompok]",
            "jk"            => "$row[nama_jk]",
            "alamat"        => substr("$row[alamat_kelompok] $row[nama_desa]",0,40),
            "hp"            => "$row[telpon]",
            "status"        => "$status",
            "bg"            => $bg
        ];
        
    }
    
    if ($total_rows < 1) {
        $output = [
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  0,
            "recordsFiltered"   =>  0,
            "data"              =>  ['' => '']
        ];
    } else {
        $output = [
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $rows,
            "recordsFiltered"   =>  $total_rows,
            "data"              =>  $data
        ];
    }
    
    echo json_encode($output);
?>