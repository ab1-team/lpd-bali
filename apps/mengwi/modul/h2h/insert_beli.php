    <?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	//INSERT.PHP
    //konfigurasi di Hosting
	$dbname            =    'siupkonl_new';
	$dbuser            =    'siupkonl_new';
	$dbpass            =    'upkbaru';
	$dbhost            =    'localhost';

	if(mysql_connect($dbhost,$dbuser,$dbpass)){
	mysql_select_db($dbname);
	}else{
	echo 'DB ne ra konek!!';
	}
	
	 

    // membaca ketiga data dari parameter CURL
	
    $beli_kode 		=$_POST['beli_kode'];
    $beli_tanggal 	=$_POST['beli_tanggal'];
    $jumlah		 	=$_POST['beli_total'];
	$keterangan_transaksi	="Pembelian $beli_kode";

    // query insert data ke mysql
    $input = "INSERT INTO transaksi_1 (idt,tgl_transaksi,rekening_debit,rekening_kredit,idtp,id_pinj,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('','$beli_tanggal','0','0','0','0','$keterangan_transaksi','$jumlah','0','1')";
	mysql_query($input);

    ?>