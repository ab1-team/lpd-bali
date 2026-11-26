<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="simpanan_anggota_$_SESSION[kd_kab]";
$table2		="transaksi_$_SESSION[lokasi]";


$tgl_transaksi	= $_POST['tgl_transaksi'];
$nia			= $_POST['nia'];
$id_simp_i		= $_POST['id_simp_i'];
$jenis_mutasi	= $_POST['jenis_mutasi'];
$jumlah			= str_replace(".", "", $_POST['jumlah']);
$user_id		= $_SESSION['id'];

$nm=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] sa where a.id=sa.nia AND sa.id='$id_simp_i' "));
$rek=mysql_fetch_array(mysql_query("select * from rekening_$_SESSION[lokasi] where jenis_akun='simp_umum' "));


if($jenis_mutasi=="setor") {
$rekening_debit		="1-10001";	//Kas Umum
$rekening_kredit	="$rek[kd_rekening]_$id_simp_i"; //Rek Simpanan Umum
$keterangan_transaksi="Setor SU $nm[nomor_rekening] $nm[namadepan]";	
}else if($jenis_mutasi=="tarik") {
$rekening_debit		="$rek[kd_rekening]_$id_simp_i"; //Rek Simpanan Umum
$rekening_kredit	="1-10001"; //Kas Umum
$keterangan_transaksi="Tarik SU $nm[nomor_rekening] $nm[namadepan]";
}


$query=mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user)
				VALUES('$tgl_transaksi','$rekening_debit', '$rekening_kredit', '0','$keterangan_transaksi','$jumlah','','$user_id')");


if($query) {

$u=mysql_fetch_array(mysql_query("SELECT namadepan, namabelakang FROM users WHERE id='$user_id' "));
$n=mysql_fetch_array(mysql_query("SELECT nomor_rekening FROM $table WHERE id='$id_simp_i' "));
$k=mysql_fetch_array(mysql_query("SELECT namadepan FROM anggota_$_SESSION[kd_kab] WHERE id='$nia' "));

echo '
	<h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle color-green1-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700"> Transaksi Berhasil</div></h1>
        <p class="boxed-text-l">
             <div class="row ml-2 mt-2">
                        <div class="col-4">
							Tanggal<br>
							No.Rekening<br>
							Nama Kreditur<br>
							Mutasi<br>
							Jumlah<br>
							Petugas<br>
                        </div>
                        <div class="col-8">
							: <b>'.$tgl_transaksi.'</b><br>
							: <b>'.$n['nomor_rekening'].'</b><br>
							: <b>'.strtoupper($k['namadepan']).'</b><br>
							: <b>'.strtoupper($jenis_mutasi).' TUNAI</b><br>
							: <b>Rp. '.number_format($jumlah,0,',','.').'</b><br>
							: <b>'.$u['namadepan'].' '.$u['namabelakang'].'</b><br>
						</div>
                    </div>
        </p>
        <a href="transaksi_simpanan.php" class="btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green1-light">Ok</a>
	';
	
	}
				
	

?>