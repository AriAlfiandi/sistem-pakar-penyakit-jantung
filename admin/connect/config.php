<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Data Relasi</title>
<style type="text/css">
body { margin:50px; background-image:url(../Image/Bottom_texture.jpg); }
div { border:1px dashed #666; background-color:#CCC; padding:10px; }
</style>
</head>
<body>
<div>
<?php
include "../koneksi.php";

$id_relasi = htmlspecialchars($_POST['textrelasi']);
$kd_penyakit = htmlspecialchars($_POST['TxtKdPenyakit']);
$kd_gejala = htmlspecialchars($_POST['TxtKdGejala']);
$bobot = htmlspecialchars($_POST['txtbobot']);

// Menggunakan prepared statement untuk mencegah SQL injection
$query = $conn->prepare("UPDATE relasi SET kd_penyakit = ?, kd_gejala = ?, bobot = ? WHERE id_relasi = ?");
$query->bind_param("sssi", $kd_penyakit, $kd_gejala, $bobot, $id_relasi);

if ($query->execute()) {
    echo "<center><font color='#0000ff'>DATA BERHASIL DIUPDATE..!</font></center>";
    echo "<center><a href='../admin/haladmin.php?top=Relasi.php'>OK</a></center>";
} else {
    echo "<center><font color='#ff0000'>DATA TIDAK DAPAT DI UPDATE..!</font></center>";
    echo "<center><font color='#ff0000'>Error: " . $conn->error . "</font></center>";
    echo "<center><a href='../admin/haladmin.php?top=Relasi.php'>Kembali</a></center>";
}

$query->close();
$conn->close();
?>

</div>
</body>
</html>
