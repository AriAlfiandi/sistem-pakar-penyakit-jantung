<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Simpan Data Penyakit</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<link href="../Image/icon.png" rel="shortcut icon">
</head>
<body>
</body>
</html>
<?php
include "../koneksi.php";

$kd_penyakit = $_POST['kd_penyakit'];
$nama_penyakit = $_POST['nama_penyakit'];
$definisi = $_POST['definisi'];
$solusi = $_POST['solusi'];

// Cek keberadaan data
$sqlrs = $conn->prepare("SELECT kd_penyakit FROM penyakit_solusi WHERE kd_penyakit = ?");
$sqlrs->bind_param("s", $kd_penyakit);
$sqlrs->execute();
$sqlrs->store_result();
$rs = $sqlrs->num_rows;

if ($rs == 0) {
    // Jika data tidak ada, simpan data
    $perintah = $conn->prepare("INSERT INTO penyakit_solusi (kd_penyakit, nama_penyakit, definisi, solusi) VALUES (?, ?, ?, ?)");
    $perintah->bind_param("ssss", $kd_penyakit, $nama_penyakit, $definisi, $solusi);
    $berhasil = $perintah->execute();
    
    if ($berhasil) {
        echo "<center>Penyimpanan Berhasil</center><br>";
        echo "<center><a href='../admin/haladmin.php?top=penyakit_solusi.php'>OK</a></center>";
    } else {
        echo "<center><font color='#ff0000'><strong>Penyimpanan Gagal</strong></font></center><br>";
        echo "<center><a href='../admin/haladmin.php?top=penyakit_solusi.php'>Kembali</a></center>";
    }
} else {
    // Jika data sudah ada
    echo "<table style='margin-top:150px;' align='center'><tr><td>";
    echo "<div style='width:500px; height:50px auto; border:1px dashed #CCC; color:#F90; padding:3px 3px 3px 3px;'>";
    echo "<center><font>Kode Penyakit $kd_penyakit <strong>Telah ada di database, Masukkan Kode Unik..!</strong></font></center><br>";
    echo "<center><a href='../admin/haladmin.php?top=penyakit_solusi.php'>Kembali</a></center>";
    echo "</div>";
    echo "</td></tr></table>";
}

$conn->close();
?>
