<?php
include "inc/inc.koneksi.php";
$mod = $_GET['p'];

if ($mod=='1'){ //HOME

	include "modul/home/dashboard.php";

}
elseif ($mod=='account'){ //account
	include "modul/account/account.php";
}

elseif ($mod=='uG'){
	include "modul/user_guides/user_guides.php";
}

elseif ($mod=='eb'){
include "modul/e_bud/e_bud.php";    
}

elseif ($mod=='sop'){
include "modul/sop/sop.php";    
}

elseif ($mod=='la'){
include "modul/laporan_awal/laporan_awal.php";
}

elseif ($mod=='u'){
include "modul/users/users.php";    
}

elseif ($mod=='rp'){
include "modul/penduduk/register_penduduk.php";    
}

elseif ($mod=='a'){
include "modul/penduduk/tampil_anggota.php";    
}

elseif ($mod=='sS'){
include "modul/simpanan/simpanan_individu.php";
}

elseif ($mod=='HBU'){
include "modul/simpanan/tampil_hitung_bunga_simpanan_umum.php";
}

elseif ($mod=='SD'){
include "modul/simpanan_deposito/simpanan_deposito.php";
}

elseif ($mod=='pJ_i'){
include "modul/pinjaman/proposal/proposal_individu.php";
}

elseif ($mod=='vL_i'){
include "modul/pinjaman/validasi_lunas/validasi_lunas_individu.php";
}

elseif ($mod=='ju'){
    include "modul/jurnal/jurnal.php";
}

elseif ($mod=='ja_i'){
    include "modul/jurnal_angsuran/jurnal_angsuran_individu.php";
}

elseif ($mod=='cash'){
    include "modul/cash/cash.php";
}

elseif ($mod=='bb'){
    include "modul/buku_besar/buku_besar.php";
}

elseif ($mod=='np'){
    include "modul/neraca_percobaan/neraca_percobaan.php";
}

elseif ($mod=='lk'){
    include "modul/laporan_keuangan/laporan_keuangan.php";
}

elseif ($mod=='l'){
    include "modul/pelaporan/pelaporan.php";
}

elseif ($mod=='tb'){
include "modul/tutup_buku/tutup_buku.php";  
}

elseif ($mod=='x'){
    echo"
		<div class='alert alert-danger mt animated fadeInDown h4'>
			Maaf, masih dalam pengembangan!
		</div>
		";
}

else{
echo "<h2>Maaf, halaman belum tersedia!</h2>";
}
?>