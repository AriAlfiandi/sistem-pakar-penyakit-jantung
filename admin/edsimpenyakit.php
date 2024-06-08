<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Eksamtema | admin </title>
<link href="/image/aq.JPG" rel='shortcut icon'>
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
include "../koneksi.php"; // Pastikan koneksi menggunakan mysqli

$kd_penyakit = $_POST['kd_penyakit'];
$penyakit = $_POST['in_penyakit'];
$definisi = $_POST['in_definisi'];
$solusi = $_POST['in_solusi'];

$sql = "UPDATE penyakit_solusi SET nama_penyakit = ?, definisi = ?, solusi = ? WHERE kd_penyakit = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $penyakit, $definisi, $solusi, $kd_penyakit);

    if ($stmt->execute()) {
        echo "<center>Data Telah Berhasil Diubah</center>";
        echo "<center><a href='haladmin.php?top=penyakit_solusi.php'>OK</a></center>";
    } else {
        echo "<center><font color='#ff0000'>Error update</font></center>";
        echo "<center><a href='haladmin.php?top=penyakit_solusi.php'>Kembali</a></center>";
    }

    $stmt->close();
} else {
    die("SQL Error: " . $conn->error);
}

$conn->close();
?>
