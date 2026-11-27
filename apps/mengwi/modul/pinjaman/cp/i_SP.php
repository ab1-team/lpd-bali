<?php session_start();
    include "../../../inc/inc.koneksi.php";
    include "../../../inc/terbilang.php";
    include "../../../inc/fungsi_indotgl.php";

    ini_set('display_errors', '1');
?>

<style>
    * {
        font-family: Verdana, Arial, Helvetica, sans-serif;
    }

    .w-full {
        width: 100%;
    }

    .flex {
        display: flex;
    }

    .items-center {
        align-items: center;
    }

    .justify-center {
        justify-content: center;
    }

    .flex-col {
        flex-direction: column;
    }

    .font-lg {
        font-size: 20px;
    }

    .font-xl {
        font-size: 24px;
    }

    .font-md {
        font-size: 16px;
    }

    .font-sm {
        font-size: 14px;
    }

    .font-xs {
        font-size: 12px;
    }

    .border-t {
        border-top: 1px solid #000;
    }

    .border-b {
        border-bottom: 1px solid #000;
    }

    .border-r {
        border-right: 1px solid #000;
    }

    .border-l {
        border-left: 1px solid #000;
    }

    .border {
        border: 1px solid #000;
    }

    .font-bold {
        font-weight: 600;
    }
</style>

<body onload="window.print()">
    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi ,keluarga kl
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'AND kl.id=a.hubungan");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$nama_barang        =$row['nama_barang'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											$nik				=$row['nik'];
											$namadepan			=$row['namadepan'];
											$alamat				=$row['alamat'];
											$telpon				=$row['hp'];
											$tempat_lahir		=$row['tempat_lahir'];
											$tgl_lahir			=$row['tgl_lahir'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_usaha'];
											$jenis_kelamin		=$row['jk'];
											$nomor_kk			=$row['kk'];
											$penjamin			=$row['penjamin'];
											$hubungan			=$row['hubungan'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$tgl_now			=date('Y-m-d');

                                            $row['nama_kec'] = $_SESSION['unit'];
                                            $nama_kec = $row['nama_kec'];
?>

    <table border="0" width="97%" align="center">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div class="flex items-center justify-center flex-col">
                    <div class="font-sm"><?php echo strtoupper($row['deskripsi_jpp']);?></div>
                    <div class="font-md font-bold">"<?php echo strtoupper($namadepan);?>"</div>
                    <div class="font-xs">
                        <?php echo ucwords("Alamat : $alamat Desa $nama_desa $sebutan_kec $nama_kec Telp.$telpon");?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table border="0" width="97%" align="center" class="font-xs font-bold">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="10%">Nomor</td>
            <td>:</td>
            <td><?php echo "______/$nik-$id_pinj/$nama_jpp".tgl_rom($tgl_proposal)."";?></td>
        </tr>
        <tr>
            <td width="10%">Tanggal</td>
            <td>:</td>
            <td><?php echo tgl_indo($tgl_proposal);?></td>
        </tr>
        <tr>
            <td width="10%">Perihal</td>
            <td>:</td>
            <td>Permohonan Kredit <?php echo $nama_jpp;?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table border="0" width="97%" align="center">
        <tr class="font-xs">
            <td>Kepada Yth.</td>
        </tr>
        <tr class="font-xs">
            <td><?php echo "$row[sebutan_level_1] $row[nama_lembaga_long]";?> <br>
                <?php echo "$sebutan_kec $nama_kec";?>
            </td>
        </tr>
    </table>
    <table border="0" width="97%" align="center">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <div class="flex justify-center font-md font-bold">
                    SURAT PERMOHONAN KREDIT 
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr class="font-xs">
            <td>Yang bertanda tangan dibawah ini:</td>
        </tr>
        <tr class="font-xs">
            <td>
                <table border="0" class="font-xs">
                    <tr>
                        <td>Nama lengkap</td>
                        <td>:</td>
                        <td><?php echo $namadepan;?></td>
                    </tr>
                    <tr>
                        <td>Jenis kelamin</td>
                        <td>:</td>
                        <td><?= ($jenis_kelamin == 'L') ? 'Laki-laki':'Perempuan';?></td>
                    </tr>
                    <tr>
                        <td>N I K</td>
                        <td>:</td>
                        <td><?php echo $nik;?></td>
                    </tr>
                    <tr>
                        <td>Kelahiran</td>
                        <td>:</td>
                        <td><?php echo "$tempat_lahir, " . tgl_indo($tgl_lahir) ;?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo "$alamat $sebutan_desa $nama_desa";?></td>
                    </tr>
                    <tr>
                        <td>Telpon</td>
                        <td>:</td>
                        <td><?php echo $telpon;?></td>
                    </tr>
                    <tr>
                        <td>Jenis usaha</td>
                        <td>:</td>
                        <td><?php echo $jenis_usaha;?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="font-xs">
            <td>
                Dalam hal ini bertindak untuk dan atas nama diri sendiri, dengan ini bermaksud mengajukan permohonan
                kredit sebesar Rp. <?php echo number_format($proposal);?> (<?php echo ucwords(toTerbilang($proposal));?>
                Rupiah) dipergunakan untuk _ _ _ _ _ _
                _ _ _ _ _ _ _ _ _ _ _
                _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _
                _ _ Kredit atau pinjaman tersebut di atas, akan kami kembalikan dalam jangka waktu <?php echo $jangka;?>
                bulan, dengan sistem angsuran <?php echo "$sistem_angsuran ($row[deskripsi_sistem])";?>.<br>
                Sebagai bahan pertimbangan, bersama ini kami lampirkan: <br>
                <ol class="font-xs">
                    <li>Fotokopi KTP dan KK</li>
                    <?php for ($i=0;$i<5;$i++) : ?>
                    <li>_______________________________</li>
                    <?php endfor; ?>
                </ol>
                Demikian permohonan kami, atas perhatiannya kami ucapkan terima kasih.
            </td>
        </tr>
    </table>
    <table border="0" width="97%" align="center" class="font-xs">
        <tr>
            <td width="30%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="30%">
                <div class="flex justify-center"><?php echo $_SESSION['unit']; ?>, <?php echo tgl_indo($tgl_proposal);?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="flex justify-center items-center flex-col">
                    <span>Mengetahui,</span>
                    <span><?php echo $row['kekeluargaan']; ?></span>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>
                <div class="flex justify-center">Yang menyatakan</div>
            </td>
        </tr>
        <tr>
            <td>
                <p>&nbsp;</p>
                <div class="flex justify-center flex-col items-center">
                    <?php echo strtoupper("<span>$row[penjamin]</span> "); ?>
                </div>
            </td>
            <td>&nbsp;</td>
            <td>
                <p>&nbsp;</p>
                <div class="flex justify-center flex-col items-center">
                    <?php echo strtoupper("<span>$row[namadepan]</span> <span>NIK. $row[nik]</span>"); ?>
                </div>
            </td>
        </tr>
    </table>
    <?php } ?>
</body>
<title><?php echo "Surat Permohonan Kredit $namadepan $nama_desa"; ?></title>