<?php
include "../koneksi.php"; // Pastikan koneksi menggunakan mysqli

$kd_gejala = $_REQUEST['kd_gejala2'];
$gejala = $_REQUEST['gejala'];

$sql = "UPDATE gejala SET gejala = ? WHERE kd_gejala = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $gejala, $kd_gejala);
    
    if ($stmt->execute()) {
        echo "<center>Data Telah Berhasil Diubah</center>";
        echo "<center><a href='haladmin.php?top=gejala.php'>OK</a></center>";
    } else {
        echo "<table style='margin-top:150px;' align='center'><tr><td>";
        echo "<div style='width:500px; height:50px auto; border:1px dashed #CCC; padding:3px;'>";
        echo "<center><font color='#ff0000'>Data tidak dapat di Update..!</font></center><br>";
        echo "<center><a href='../admin/haladmin.php?top=gejala.php'>Kembali</a></center>";
        echo "</div>";
        echo "</td></tr></table>";
    }
    
    $stmt->close();
} else {
    die("SQL Error: " . $conn->error);
}

$conn->close();
?>
