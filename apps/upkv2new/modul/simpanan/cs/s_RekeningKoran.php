<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
include "../../../inc/fungsi_simpanan_individu.php";
include "../../../js/bar128.php";

?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
@media print{
   .noprint{
       display:none;
   }
}
-->
</style>
<body onLoad="window.print()">
    
    <div class="noprint">
    
    <form>
        <input 
    </form>
    
    </div>
    <?php 
    include "m_Koran.php";
    ?>
    
    

<script type="text/javascript">

	<![CDATA[
var htmlobjek;
$(document).ready(function(){
      //apabila terjadi event onchange terhadap object <select id=report>
      $("#ids").change(function(){
        var ids = $("#ids").val();
        $.ajax({
            url: "modul/simpanan/cs/m_Koran.php",
            data: "ids="+ids,
            cache: false,
            success: function(msg){
                //jika data sukses diambil dari server kita tampilkan
                //di <select id=jenis_buku>
                $("#ids").html(msg);
            }
        });
      });
  });



 ]]>
</script>
		
    
    
</body>
<title>Cetak Buku</title>