<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="pola_angsuran_$_SESSION[kd_kab]";

$id		= $_POST['id_pola'];
$a1		= $_POST['a1'];
$a2		= $_POST['a2'];
$a3		= $_POST['a3'];
$a4		= $_POST['a4'];
$a5		= $_POST['a5'];
$a6		= $_POST['a6'];
$a7		= $_POST['a7'];
$a8		= $_POST['a8'];
$a9		= $_POST['a9'];
$a10	= $_POST['a10'];
$a11	= $_POST['a11'];
$a12	= $_POST['a12'];
$a13	= $_POST['a13'];
$a14	= $_POST['a14'];
$a15	= $_POST['a15'];
$a16	= $_POST['a16'];
$a17	= $_POST['a17'];
$a18	= $_POST['a18'];
$a19	= $_POST['a19'];
$a20	= $_POST['a20'];
$a21	= $_POST['a21'];
$a22	= $_POST['a22'];
$a23	= $_POST['a23'];
$a24	= $_POST['a24'];

	$input	= "UPDATE $table SET 	a1	='$a1',
									a2	='$a2',
									a3	='$a3',
									a4	='$a4',
									a5	='$a5',
									a6	='$a6',
									a7	='$a7',
									a8	='$a8',
									a9	='$a9',
									a10	='$a10',
									a11	='$a11',
									a12	='$a12',
									a13	='$a13',
									a14	='$a14',
									a15	='$a15',
									a16	='$a16',
									a17	='$a17',
									a18	='$a18',
									a19	='$a19',
									a20	='$a20',
									a21	='$a21',
									a22	='$a22',
									a23	='$a23',
									a24	='$a24'

						WHERE id= '$id'";
	mysql_query($input);					

?>