<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Simpan Relasi</title>
<style type="text/css">
body { margin:50px;background-image:url(../Image/Bottom_texture.jpg);}
div { border:1px dashed #666; background-color:#CCC; padding:10px;}
</style>
</head>
<body>
<div>
<?php 
include "../koneksi.php";

// Baca variabel Form
$TxtKdPenyakit = $_POST['TxtKdPenyakit'];
$TxtKdGejala = $_POST['TxtKdGejala'];
$bobot = $_POST['txtbobot'];

// Validasi Form
if (trim($TxtKdPenyakit) == "") {
    echo "Kode Penyakit masih kosong, ulangi kembali";
    include "relasi.php";
    exit;
} elseif (trim($TxtKdGejala) == "") {
    echo "Kode Gejala masih kosong, ulangi kembali";
    include "relasi.php";
    exit;
}

// Cek apakah relasi sudah ada
$sql_cek = "SELECT * FROM relasi WHERE kd_penyakit = ? AND kd_gejala = ?";
$stmt_cek = $conn->prepare($sql_cek);
$stmt_cek->bind_param("ss", $TxtKdPenyakit, $TxtKdGejala);
$stmt_cek->execute();
$result_cek = $stmt_cek->get_result();
$ada_cek = $result_cek->num_rows;

if ($ada_cek >= 1) {
    echo "RELASI TELAH ADA";
    include "relasi.php";
    exit;
} else {
    // Insert relasi baru
    $sql = "INSERT INTO relasi (kd_penyakit, kd_gejala, bobot) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $TxtKdPenyakit, $TxtKdGejala, $bobot);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<center><strong>DATA TELAH BERHASIL DIRELASIKAN..!</strong></center>";
        echo "<center><a href='../admin/haladmin.php?top=relasi.php'>OK</a></center>";
    } else {
        echo "<center><strong>GAGAL MENYIMPAN DATA!</strong></center>";
        echo "<center><a href='../admin/haladmin.php?top=relasi.php'>Kembali</a></center>";
    }

    $stmt->close();
}

$conn->close();
?>

</div>
</body>
</html>
