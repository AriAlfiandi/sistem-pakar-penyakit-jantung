<html>
<head>
<title>Hapus gejala</title>
<body>
<?php
include "../koneksi.php";

$kdhapus = $_GET['kdhapus'];

if ($kdhapus != "") {
    // Mempersiapkan pernyataan SQL untuk menghapus data
    $sql = "DELETE FROM gejala WHERE kd_gejala = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Mengikat parameter
        $stmt->bind_param("s", $kdhapus);

        // Menjalankan pernyataan
        if ($stmt->execute()) {
            echo "<center>Data telah dihapus..!</center>";
            echo "<center><a href='haladmin.php?top=gejala.php'><strong>OK</strong></a></center>";
        } else {
            echo "<table style='margin-top:150px;' align='center'><tr><td>";
            echo "<div style='width:500px; height:50px auto; border:1px dashed #CCC; padding:3px 3px 3px 3px;'>";
            echo "<center><font color='#ff0000'>Data tidak dapat dihapus..!</strong></font></center><br>";
            echo "<center><a href='../admin/haladmin.php?top=gejala.php'>Kembali</a></center>";
            echo "</div>";
            echo "</td></tr></table>";
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

</body>
</head>
</html>