<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tanggal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .form-container, .result-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 20px 0;
        }
        .result-container {
            width: 80%;
            max-width: 600px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        label {
            flex: 0 0 80px;
            margin-bottom: 0;
            margin-right: 10px;
            color: #666;
        }
        select, input[type="text"] {
            flex: 1;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 12px auto;
        }
        input[type="submit"], button {
            background-color: #5DC4BF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #47B3AE;
        }
        input[type="submit"]:disabled, button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .result-text {
            margin-bottom: 20px;
            color: #5DC4BF;
            font-weight: bold;
            font-size: 18px;
        }
        .result-text2 {
            margin-bottom: 20px;
            color: #333;
        }
        .result-text3 {
            margin-bottom: 20px;
            text-align: right;
            margin-top: -15px;
            color: #333;
            font-size:11px;
        }
        .process-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .process-form input[type="text"] {
            width: 70px;
            margin-right: 10px;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #5DC4BF;
            text-decoration: none;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .back-button, .next-button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }
        .back-button {
            background-color: #FF4136;
            color: white;
        }
        .back-button:hover {
            background-color: #DC352D;
        }
        .next-button {
            background-color: #5DC4BF;
            color: white;
        }
        .next-button:hover {
            background-color: #47B3AE;
        }
        .button-icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <?php
    include './inc/inc.koneksi.php';
    include './inc/fungsi_keuangan.php';
    $lokasi = 3;
    $kd_kab = 2;
    if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if($id == NULL or $id == ""){
        $where = 1;
    } else {
        // Memisahkan ID yang diinput menjadi array
        $id_array = explode(',', $id);
        // Membersihkan setiap ID dari spasi dan memastikan hanya angka
        $id_array = array_map('trim', $id_array);
        $id_array = array_filter($id_array, 'is_numeric');
        // Menggabungkan ID menjadi string untuk query
        $where = "id IN (" . implode(',', $id_array) . ")";
    }
    $q = mysql_query("SELECT * FROM simpanan_anggota_$kd_kab WHERE ($where) ORDER BY id ASC");
    $total = mysql_num_rows($q);
    
        echo "<div class='result-container'>";
        echo "<div class='result-text2'>Total Simpanan yang akan di proses adalah " . $total . " data.</div>";
        
        if (isset($_GET['limit']) && isset($_GET['start'])) {
            $start = $_GET['start'] + $_GET['limit'];
            $per_page = 25;
        } else {
            $start = 0;
            $per_page = 25;
        }
        
        ?>
        <form action="" method="get" class="process-form" id="runForm">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="start" id="start" value="<?php echo $start; ?>" readonly>
            <input type="hidden" name="limit" id="limit" value="<?php echo $per_page; ?>" readonly>
            <button type="submit" name="migrate" id="runButton" <?php echo $start > $total ? 'disabled' : ''; ?>>
                Loading<span id="loadingDots">.</span>
            </button>
        </form>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var button = document.getElementById('runButton');
            var loadingDots = document.getElementById('loadingDots');
            var dotCount = 0;
        
            function animateDots() {
                dotCount = (dotCount % 4) + 1;
                loadingDots.textContent = '.'.repeat(dotCount);
            }
        
            // Mulai animasi saat tombol tidak disabled
            if (!button.disabled) {
                var interval = setInterval(animateDots, 500); // Mengubah setiap 500ms (0.5 detik)
        
                // Opsional: Hentikan animasi jika tombol diklik
                button.addEventListener('click', function() {
                    clearInterval(interval);
                    button.disabled = true; // Menonaktifkan tombol setelah diklik
                });
            }
        });
        </script>
        <?php
    $q2 = mysql_query("SELECT * FROM simpanan_anggota_$kd_kab WHERE lokasi=$lokasi AND ($where) ORDER BY id ASC  LIMIT $start, $per_page");
        while ($simp = mysql_fetch_array($q2)) {
            $del_re = mysql_query("DELETE FROM real_simpanan_$lokasi WHERE cif=$simp[id]");
            $query  = mysql_query("SELECT * FROM transaksi_$lokasi WHERE id_simp_i=$simp[id] ORDER BY tgl_transaksi ASC, urutan ASC, idt ASC");
                    $sum = 0;
                    while ($trx = mysql_fetch_array($query)) {
                        $cif            = $simp['id'];
                        $tgl_transaksi  = $trx['tgl_transaksi'];
                        
                        if (substr($trx['rekening_kredit'], 0, 2) == '22') {
                            $real_d         = $trx['jumlah'];
                            $real_k         = 0;
                            $sum            = $sum + $real_d;
                        } elseif (substr($trx['rekening_debit'], 0, 2) == '22') {
                            $real_d         = 0;
                            $real_k         = $trx['jumlah'];
                            $sum            = $sum - $real_k;
                        } else {
                            // Jika tidak memenuhi kedua kondisi di atas, gunakan nilai default
                            $real_d         = $trx['jumlah'];
                            $real_k         = $trx['jumlah'];
                            // $sum tidak berubah dalam kasus ini
                        }
                        
                        $lu             = date('Y-m-d H:i:s');
                        $id_user        = $trx['id_user'];
                        
                        $insert_t = mysql_query("INSERT INTO `real_simpanan_$lokasi`(`cif`, `tgl_transaksi`, `real_d`, `real_k`, `sum`, `lu`, `id_user`) 
                                     VALUES ('$cif','$tgl_transaksi','$real_d','$real_k','$sum','$lu','$id_user')");
                        
                    }
        }
        
        if ($start > $total) {
            echo "<div class='result-text'>Proses generate bunga telah selesai</div>";
            echo "<div class='button-container'>
                <button onclick=\"window.location.href='?'\" class='back-button'>
                    <span class='button-icon'>&#8592;</span> Back
                </button>
                <button onclick=\"window.location.href='generate_bunga.php'\" class='next-button'>
                    Next <span class='button-icon'>&#8594;</span>
                </button>
            </div>";
        }
        echo "</div>";

        // Script untuk auto-run
        if ($start <= $total) {
            echo "
            <script>
            window.onload = function() {
                setTimeout(function() {
                    document.getElementById('runForm').submit();
                }, 1000); // Delay 1 detik sebelum submit
            }
            </script>
            ";
        }
    } else {
        ?>
        <div class="form-container">
            <h2>Proses Generate</h2>
            <form>
                <div class="form-group">
                    <label for="id">CIF</label>
                    <input type="text" id="id" name="id" placeholder="semua CIF">
                </div>
                <div class='result-text3'>jika hanya sebagian, ketiklah : <strong>CIF, CIF </strong>dst
                </div>
                <input type="submit" value="Kirim">
            </form>
        </div>
    <?php
    }
    ?>
</body>
</html>