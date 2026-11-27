<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style>
	* {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 14px;
	}

	.w-full {
		width: 100%;
	}

	.text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	}

	.text-left {
		text-align: left;
	}

	.text-justify {
		text-align: justify;
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

	.justify-start {
		justify-content: flex-start;
	}

	.justify-end {
		justify-content: flex-end;
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
		font-size: 18px;
	}

	.font-sm {
		font-size: 16px;
	}

	.font-xs {
		font-size: 14px;
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
		font-weight: bold;
	}
</style>

<body onload="window.print()">
	<?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];

											
											$tgl_cair			=$row['tgl_cair'];
											
										
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$alokasi			=$row['alokasi'];
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];

											$sistem				=$row['sistem'];
											$jangka				=$row['jangka'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
											$nama_lembaga_long	=$row ['nama_lembaga_long'];
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											
											
											$spk_no				=$row['spk_no'];
											$nik				=$row['nik'];
											$namadepan			=$row['namadepan'];
											$alamat				=$row['alamat'];
											$telpon				=$row['telpon'];
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
											$nik_penjamin		=$row['nik_penjamin'];
											$wajibjasaaja		=wajibjasaaja_anggota($id_pinj);
											$wajibjasa			=($wajibjasaaja*$sistem);
				
				                            $row['nama_kec'] = $_SESSION['unit'];
			                                $nama_kec = $row['nama_kec'];
			?>
	<table width="97%" border="0" align="center" class="border-b">
		<tr>
			<td>
				<div class="flex">
					<?php
                    $logo=$row['logo'];
                    if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' width='70'>";
                    }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' width='70'>";
                    }
					$nomor_bh =$row ['nomor_bh'];
					if (empty($nomor_bh)) {
						$bh="";
					}else{
						$bh="Badan Hukum No.$nomor_bh<br>";
					}
                ?>
					<div style="margin-left: .5em;">
						<div class="font-bold">
							<?php echo strtoupper($row['nama_lembaga_long']); ?> <br>
							<?php echo strtoupper($sebutan_kec.$row['nama_kec']); ?> KABUPATEN
							<?php echo strtoupper($row['nama_kab']); ?>
						</div>
						<div><?php echo $bh. " " . $row['alamat_kec']; ?> Telp. <?php echo $row['telpon_kec']; ?></div>
					</div>
				</div>
			</td>
			<td>
				<div class="flex justify-end">
					<span>
						Dokumen Pencairan <br>
						Loan ID. <?php echo "$id_pinj";?>
					</span>
				</div>
			</td>
		</tr>
	</table>
	<table width="97%" border="0" align="center">
		<tr>
			<td>
				<p>&nbsp;</p>
				<div class="flex justify-center font-bold font-lg">
					SURAT PERNYATAAN PENJAMIN
				</div>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
	<table width="97%" border="0" align="center">
	    <tr>
	        <td>&nbsp;</td>
	    </tr>
		<tr>
			<td>
				<div>
					Saya yang bertanda tangan di bawah ini :
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo strtoupper($row['penjamin']); ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo strtoupper($row['alamat']); ?></td>
					</tr>
					<tr>
						<td>No. KTP</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo strtoupper($row['nik_penjamin']); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div>
					adalah <span class="font-bold"><?php echo $row['kekeluargaan']; ?></span> dari :
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo strtoupper($row['namadepan']); ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo $row['alamat'];?></td>
					</tr>
					<tr>
						<td>Pekerjaan</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo $row['nama_usaha'];?></td>
					</tr>
					<tr>
						<td>No. KTP</td>
						<td>:</td>
						<td class="font-bold font-sm"><?php echo $row['nik'];?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<div>
					Menerangkan dengan sebenarnya, bahwa saya mengetahui dan menyetujui pinjaman sebesar <span
						class="font-bold">Rp. <?php echo number_format($row['alokasi']);?> ,-
						(<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah)</span> yang akan di ajukan ke
					<span class="font-bold">
						<?php echo $row['nama_lembaga_sort']; ?> <?php echo $row['nama_kec']; ?></span> Sebagai
					salah satu syarat pengajuan pinjaman. Apabila pinjaman tersebut bisa dicairkan maka dana itu akan
					kami pergunakan untuk _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _
					_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _
					_
					. Sebagai bentuk tanggung jawab saya sebagai <span
						class="font-bold"><?php echo $row['kekeluargaan'] ?></span>, maka saya
					akan turut bertanggung jawab dalam melaksanakan kewajiban pengembalian dana tersebut.
				</div>
				<br>
				<div>
					Demikan surat pernyataan ini saya buat dengan sebenarnya tanpa ada unsur paksaan dari siapapun.
				</div>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<table width="97%" border="0" align="center">
		<tr>
			<td width="65%">&nbsp;</td>
			<td width="35%">
				<div class="flex items-center flex-col text-center font-sm">
					<span>
						<?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_proposal);?>
					</span>
					<span class="text-center">
						Yang membuat pernyataan
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div class="flex flex-col items-center text-center font-sm">
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<span class="text-center">
						<?php echo strtoupper($row['penjamin']); ?> <br>
					</span>
					<span>
						Penjamin
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
	<title>1. Surat Pernyataan SDR. KANDUNG</title>
	<?php } ?>
</body>
