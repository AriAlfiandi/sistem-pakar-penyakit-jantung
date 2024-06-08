<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proses Diagnosa</title>
<style type="text/css">
p{ padding-left:30px;}
</style>
</head>

<body>
<?php
include "koneksi.php";

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sqlpenyakit = "SELECT * FROM relasi GROUP BY kd_penyakit";
$querypenyakit = $conn->query($sqlpenyakit);

if ($querypenyakit->num_rows > 0) {
    while($rowpenyakit = $querypenyakit->fetch_assoc()) {
        // data penyakit di tabel relasi
        echo $rowpenyakit['kd_penyakit'] . "<br>";
        $kd_pen = $rowpenyakit['kd_penyakit'];

        // cari tabel tmp_gejala
        $sqlgejalaTEMP = "SELECT relasi.kd_penyakit, relasi.kd_gejala, relasi.bobot, tmp_gejala.bobot AS bobotTMP 
                          FROM relasi 
                          JOIN tmp_gejala ON relasi.kd_gejala = tmp_gejala.kd_gejala 
                          WHERE relasi.kd_penyakit = '$kd_pen'";
        $querygejalaTEMP = $conn->query($sqlgejalaTEMP);

        if ($querygejalaTEMP->num_rows > 0) {
            while($rowTEMP = $querygejalaTEMP->fetch_assoc()) {
                $bobotRelasi = $rowTEMP['bobot'];
                $bobotTMP = $rowTEMP['bobotTMP'];

                echo "<p>";
                echo $rowTEMP['kd_gejala'] . "<br>";
                echo "Bobot tabel relasi: " . $bobotRelasi . "<br>";
                echo "Bobot tabel TMP: " . $bobotTMP . "<br>";
                echo "</p>";

                $kd_gej = $rowTEMP['kd_gejala'];
                // Query tambahan sesuai kebutuhan
                // $queryRelasi = $conn->query("SELECT * FROM relasi WHERE ...");
            }
        } else {
            echo "Tidak ada data di tmp_gejala untuk kd_penyakit: $kd_pen<br>";
        }
    }
} else {
    echo "Tidak ada data ditemukan di tabel relasi.";
}

$conn->close();
?>

</body>
</html>