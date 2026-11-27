<?php session_start();
include "../inc/koneksi_payment.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
?>

<section class="widget">
	<header>
        <legend><i class="fa fa-book"></i> List Order</legend>
    </header>
			<div class="widget-body">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
							<th>Tanggal</th>
							<th>Nominal</th>
							<th>Nomor</th>
							<th>Status</th>
                            <th>P</th>
							<th class="hidden-print">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
								$view=mysql_query("select * from orderan ",$koneksi_1);
								$no=0;
								while($r=mysql_fetch_array($view)){
								$no=$no+1;


						echo "
						<tr>
							<td>$no</td>
							<td>$r[tgl_order]</td>
							<td>$r[nominal]</td>
							<td>$r[nomor]</td>
							<td>$r[status]</td>
							<td>$r[lokasi]</td>
                            <td class='hidden-print'>";
							?>
								<a href="javascript:;" data-toggle='tooltip' data-placement='top' title='Cetak' onclick="MM_openBrWindow('modul/jurnal/c_kw_dot_1.php?idt=<?php echo $row['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print">Cetak</i></a>
							<?php echo "
							</td>
                        </tr> ";												
						 } 
						 ?>
                        </tbody>
                    </table>
                </div>
            </div>
</section>