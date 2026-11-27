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

if($nm['jenis_simpanan']==1){
    if($jenis_mutasi=="setor") {	
        $rekening_debit		="119.01";	//Kas Umum
        $rekening_kredit	="221.01"; //Rek Simpanan Umum
        $keterangan_transaksi="Setor SU $nm[nomor_rekening] $nm[namadepan]";	
    }else if($jenis_mutasi=="tarik") {
        $rekening_debit		="221.03"; //Rek Simpanan Umum
        $rekening_kredit	="119.06"; //Kas Umum
        $keterangan_transaksi="Tarik SU $nm[nomor_rekening] $nm[namadepan]";
    }
}else if($nm['jenis_simpanan']==2){
    if($jenis_mutasi=="setor") {	
        $rekening_debit		="119.02";	//Kas wajib
        $rekening_kredit	="222.01"; 
        $keterangan_transaksi="Setor SPr $nm[nomor_rekening] $nm[namadepan]";	
    }else if($jenis_mutasi=="tarik") {
        $rekening_debit		="222.03"; 
        $rekening_kredit	="119.07"; 
        $keterangan_transaksi="Tarik SPr $nm[nomor_rekening] $nm[namadepan]";
    }
}else if($nm['jenis_simpanan']==3){
    if($jenis_mutasi=="setor") {	
        $rekening_debit		="119.03";	//Kas pokok
        $rekening_kredit	="223.01";
        $keterangan_transaksi="Setor SPr $nm[nomor_rekening] $nm[namadepan]";	
    }else if($jenis_mutasi=="tarik") {
        $rekening_debit		="223.03";
        $rekening_kredit	="119.08"; 
        $keterangan_transaksi="Tarik SPr $nm[nomor_rekening] $nm[namadepan]";
    }
}else if($nm['jenis_simpanan']==4){
    if($jenis_mutasi=="setor") {	
        $rekening_debit		="119.04";	//Kas Program
        $rekening_kredit	="224.01"; 
        $keterangan_transaksi="Setor SPr $nm[nomor_rekening] $nm[namadepan]";	
    }else if($jenis_mutasi=="tarik") {
        $rekening_debit		="224.03"; 
        $rekening_kredit	="119.09"; 
        $keterangan_transaksi="Tarik SPr $nm[nomor_rekening] $nm[namadepan]";
    }
}else if($nm['jenis_simpanan']==5){
    if($jenis_mutasi=="setor") {	
        $rekening_debit		="119.05";	//Kas Deposito
        $rekening_kredit	="225.01"; 
        $keterangan_transaksi="Setor SPr $nm[nomor_rekening] $nm[namadepan]";	
    }else if($jenis_mutasi=="tarik") {
        $rekening_debit		="225.03"; 
        $rekening_kredit	="119.10"; 
        $keterangan_transaksi="Tarik SPr $nm[nomor_rekening] $nm[namadepan]";
    }
}

mysql_query("INSERT INTO $table2 (tgl_transaksi,rekening_debit,rekening_kredit,idtp,keterangan_transaksi,jumlah,urutan,id_user,id_simp_i)
				VALUES('$tgl_transaksi','$rekening_debit', '$rekening_kredit', '0','$keterangan_transaksi','$jumlah','','$user_id','$id_simp_i')");
 

				
	

?>