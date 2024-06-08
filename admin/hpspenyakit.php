<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sistem Pakar Penyakit Pencernaan</title>
<link href="/image/mimi.JPG" rel='shortcut icon'>
<style>
<!--
body
{
background-image:url(/image/background.jpg);
background-repeat:no-repeat;
background-attachment:fixed;
}
</style>
</head>
<body>
</body>
</html>
<?php
include "../koneksi.php";

$kdhapus = $_GET['kdhapus'];

if ($kdhapus != "") {
    // Mempersiapkan pernyataan SQL untuk menghapus data
    $sql = "DELETE FROM penyakit_solusi WHERE kd_penyakit = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Mengikat parameter
        $stmt->bind_param("s", $kdhapus);

        // Menjalankan pernyataan
        if ($stmt->execute()) {
            echo "<center><b>Data berhasil dihapus</b></center>";
            echo "<center><a href='haladmin.php?top=penyakit_solusi.php'><b>OK</b></a></center>";
        } else {
            echo "<center>Data belum berhasil dihapus</center>";
            echo "<center><a href='haladmin.php?top=penyakit_solusi.php'><b>Kembali</b></a></center>";
        }

        // Menutup pernyataan
        $stmt->close();
    } else {
        die("SQL Error: " . $conn->error);
    }
}

// Menutup koneksi
$conn->close();
?>
