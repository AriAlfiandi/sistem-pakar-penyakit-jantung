<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
</body>
</html>
<?php
include "../koneksi.php";

$kd_gejala = $_POST['kd_gejala'];
$gejala = $_POST['gejala'];

// Cek apakah kode gejala sudah ada di database
$sqlrs = $conn->prepare("SELECT kd_gejala FROM gejala WHERE kd_gejala = ?");
$sqlrs->bind_param("s", $kd_gejala);
$sqlrs->execute();
$sqlrs->store_result();
$rs = $sqlrs->num_rows;

if ($rs == 0) {
    // Jika data nol maka simpan data
    $perintah = $conn->prepare("INSERT INTO gejala (kd_gejala, gejala) VALUES (?, ?)");
    $perintah->bind_param("ss", $kd_gejala, $gejala);
    $berhasil = $perintah->execute();

    if ($berhasil) {
        echo "<center><b>Data Berhasil Disimpan </b></center>";
        header("Location: haladmin.php?top=gejala.php");
    } else {
        echo "<center><font color='#ff0000'><strong>Penyimpanan Gagal: " . $conn->error . "</strong></font></center><br>";
        echo "<center><a href='../admin/haladmin.php?top=gejala.php'>Kembali</a></center>";
    }
} else {
    // Jika data sudah ada
    echo "<table style='margin-top:150px;' align='center'><tr><td>";
    echo "<div style='width:500px; height:50px auto; border:1px dashed #CCC; color:#F90; padding:3px 3px 3px 3px;'>";
    echo "<center><font>Kode Gejala $kd_gejala <strong>Telah ada di database, Masukkan Kode Unik..!</strong></font></center><br>";
    echo "<center><a href='../admin/haladmin.php?top=gejala.php'>Kembali</a></center>";
    echo "</div>";
    echo "</td></tr></table>";
}

$conn->close();
?>
