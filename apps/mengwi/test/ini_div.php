<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    $("#close").click(function() {
        $("#Form_div_target").html("");
    });
    
});
</script>

<?php
    $id_anggota = 1;

while($id_anggota <= 5) {
?>

<script type="text/javascript">
$(document).ready(function() {
    
    $("#id_button<?php echo "$id_anggota";?>").click(function() {  //function saat tombol di pencet maka . . . 
    
        var value = $("#id_button<?php echo "$id_anggota";?>").val(); //ini buat variable di javascript (kalo di php, ini bisa di bilang $value=... gitu)

        $.ajax({
            type: "POST", //ini untuk mengirim variable ke url lain
            url: "ini_isi_div.php", //ini link target yang bakal dikirimi variablenya
            data: 
                "value=" + value, //ini variable yang dikirim,,, 
						success: function(data) { //ini kalo sukses ngirim, maka lakukan ini
                $("#Form_div_target").html(data);
						}
        });
    });
});
</script>

<button href="" data-target="#Form_div_target" value="<?php echo "$id_anggota";?>" id="id_button<?php echo "$id_anggota";?>" name="id_button<?php echo "$id_anggota";?>" >
    tombol
</button>
<?php
  echo "Nomor id_anggota : $id_anggota <br> <br> <br>";
  $id_anggota++;
} ?>


<div id="div_target">
    <div>
        Form
    </div>
    <div>
        <div id="Form_div_target"></div>
    </div>
<button href="" data-target="#Form_div_target" value="" id="close" name="close" >
    close
</button>
</div>