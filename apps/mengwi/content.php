<?php
include "inc/inc.koneksi.php";
$mod = $_GET['p'];

if ($mod=='1'){ //HOME

	if ($_SESSION['level']=='1'){   //UPK
		include "modul/home/dashboard_upk.php";
	}elseif ($_SESSION['level']=='4'){  //TV
		include "modul/home/dashboard_tv.php";
	}elseif ($_SESSION['level']=='5'){	//dana
		include "modul/home/dashboard_dana.php";
	}elseif ($_SESSION['level']=='2'){	//BKAD
		include "modul/home/dashboard_upk.php";
	}elseif ($_SESSION['level']=='camat'){	//Camat
		include "modul/home/dashboard_upk.php";
	}elseif ($_SESSION['level']=='3'){	//BP
		include "modul/home/dashboard_upk.php";
	}elseif ($_SESSION['level']=='kab'){	//KAB
		include "modul/home/dashboard_kab.php";
	}elseif ($_SESSION['level']=='prop'){	//PROP
		include "modul/home/dashboard_prop.php";
	}elseif ($_SESSION['level']=='pusat'){	//PUSAT
		include "modul/home/dashboard_pusat.php";
	}elseif ($_SESSION['level']=='desa'){	//DESA
		include "modul/home/dashboard_desa.php";
		
	}elseif ($_SESSION['level']=='group'){	//DESA
		include "modul/kelompok/kelompok_home.php";
	}

}
elseif ($mod=='account'){ //account
	include "modul/account/account.php";
}

elseif ($mod=='kab_account'){ //account
	include "modul/account/kab_account.php";
}

elseif ($mod=='sS'){
include "modul/simpanan/simpanan_individu.php";
$_SESSION['jenis_simpanan'] = "ini sS";
}

elseif ($mod=='sA'){
include "modul/simpanan/simpanan_anggota.php";
$_SESSION['jenis_simpanan'] = "2";
}

elseif ($mod=='SP'){
include "modul/simpanan/simpanan_individu3.php";
$_SESSION['jenis_simpanan'] = "3";
}

elseif ($mod=='SD'){
include "modul/simpanan_deposito/simpanan_deposito.php";
}

elseif ($mod=='s1'){
include "modul/simpanan/register/register_penduduk.php";
}


elseif ($mod=='HBb'){
include "modul/simpanan/tampil_hitung_bunga_simpanan_umum.php";
}


elseif ($mod=='HBp'){
include "modul/simpanan/tampil_hitung_bunga_simpanan_program.php";
}



elseif ($mod=='HBd'){
include "modul/simpanan_deposito/tampil_hitung_bunga_simpanan_deposito.php";
}



elseif ($mod=='uG'){
	include "modul/user_guides/user_guides.php";
}

elseif ($mod=='uF'){
	include "modul/update_fitur/update_fitur.php";
}

elseif ($mod=='eb'){
include "modul/e_bud/e_bud.php";    
}

elseif ($mod=='sop'){
include "modul/sop/sop.php";    
}

elseif ($mod=='la'){
if ($_SESSION['lokasi']=='1'){
include "modul/laporan_awal/laporan_awal.php";	
		echo"
		<div class='alert alert-danger mt animated fadeInDown'>
			<strong>Anda menggunakan versi Demo</strong><br>
			Halaman ini dapat anda akses pada versi Pro, silahkan hubungi kami, 085 743 07 1234
		</div>
		";
	}else{
		include "modul/laporan_awal/laporan_awal.php";
	}
}

elseif ($mod=='u'){
include "modul/users/users.php";    
}

elseif ($mod=='d'){
include "modul/desa/form.php";    
}

elseif ($mod=='k'){
include "modul/kelompok/kelompok.php";    
}

elseif ($mod=='rp'){
include "modul/penduduk/register_penduduk.php";    
}

elseif ($mod=='dp'){
include "modul/penduduk/tampil_penduduk.php";    
}

elseif ($mod=='a'){
include "modul/penduduk/tampil_anggota.php";    
}

elseif ($mod=='p1'){
include "modul/pinjaman/register/register.php";    
}

elseif ($mod=='pJ'){
include "modul/pinjaman/proposal/proposal.php";
}

elseif ($mod=='pJ_i'){
include "modul/pinjaman/proposal/proposal_individu.php";
}

elseif ($mod=='vL'){
include "modul/pinjaman/validasi_lunas/validasi_lunas.php";
}

elseif ($mod=='vL_i'){
include "modul/pinjaman/validasi_lunas/validasi_lunas_individu.php";
}

elseif ($mod=='ju'){
    include "modul/jurnal/jurnal.php";
}

elseif ($mod=='ja'){
    include "modul/jurnal_angsuran/jurnal_angsuran.php";
}

elseif ($mod=='ja_i'){
    include "modul/jurnal_angsuran/jurnal_angsuran_individu.php";
}

elseif ($mod=='GT'){
if ($_SESSION['level']=='1' AND $_SESSION['jabatan']=='1'){				
		include "modul/gudang_transaksi/gudang_transaksi.php";
	}else{
		echo"
		<div class='alert alert-danger mt animated fadeInDown'>
			<strong>Maaf, Halaman ini hanya dapat diakses oleh Ketua/Manajer
		</div>
		";
	}
    
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

elseif ($mod=='ld' and $_SESSION['level']=="desa"){
    include "modul/pelaporan/pelaporan_desa.php";
}

elseif ($mod=='lc'){
    include "modul/pelaporan/pelaporan_kec.php";
}

elseif ($mod=='lb'){
    include "modul/pelaporan/pelaporan_kab.php";
}

elseif ($mod=='cpBP'){
    include "modul/catatan_bp/catatan_bp.php";
}

elseif ($mod=='tb'){
if ($_SESSION['lokasi']=='1'){	
include "modul/tutup_buku/tutup_buku.php";			
		echo"
		<div class='alert alert-danger mt animated fadeInDown'>
			<strong>Anda menggunakan versi Demo</strong><br>
			Halaman ini dapat anda akses pada versi Pro, silahkan hubungi kami, 085 743 07 1234
		</div>
		";
	}else{
		include "modul/tutup_buku/tutup_buku.php";
	}
    
}

elseif ($mod=='home'){
    include "modul/website/home.php";
}

elseif ($mod=='profil'){
    include "modul/website/profil.php";
}

elseif ($mod=='lembaga'){
    include "modul/website/lembaga.php";
}

elseif ($mod=='desaku'){
    include "modul/website/desaku.php";
}

elseif ($mod=='unews'){
    include "modul/website/news_list.php";
}

elseif ($mod=='galery'){
    include "modul/website/galery.php";
}

elseif ($mod=='trx' and $_SESSION['level'] =='pusat'){
    include "admin/transaksi/jurnal.php";
}

elseif ($mod=='users_upk' and $_SESSION['level'] =='pusat'){
    include "admin/users_upk/users_upk.php";
}

elseif ($mod=='form_invoice' and $_SESSION['level'] =='pusat'){
    include "admin/invoice/form_invoice.php";
}

elseif ($mod=='invoice' and $_SESSION['level'] =='pusat'){
    include "admin/invoice/tampil_invoice.php";
}

elseif ($mod=='invoice' and $_SESSION['level'] ==1){
    include "admin/invoice/tampil_invoice.php";
}

elseif ($mod=='laporan' and $_SESSION['level'] =='pusat'){
    include "modul/pelaporan/pelaporan_admin.php";
}

elseif ($mod=='tutup_buku' and $_SESSION['level'] =='pusat'){
    include "admin/tutup_buku/tutup_buku.php";
}

elseif ($mod=='trx_bkad' and $_SESSION['level'] =='2'){
    include "bkad/transaksi/jurnal.php";
}

elseif ($mod=='lap_bkad' and $_SESSION['level'] =='2'){
    include "bkad/pelaporan/pelaporan_bkad.php";
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