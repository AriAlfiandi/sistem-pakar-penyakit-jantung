<?php 
include "../koneksi.php";

// Mendapatkan nilai dari permintaan
$kdsakit = $_REQUEST['CmbPenyakit'];

// Menyiapkan dan menjalankan query
$sqlp = "SELECT * FROM penyakit_solusi WHERE kd_penyakit = ?";
$stmt = $conn->prepare($sqlp);
$stmt->bind_param("s", $kdsakit);
$stmt->execute();
$result = $stmt->get_result();

// Mengambil data hasil query
if ($result->num_rows > 0) {
    $datap = $result->fetch_assoc();
    $sakit = $datap['nama_penyakit'];
} else {
    echo "Data tidak ditemukan.";
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>

<html>
<head>
<title>Tampilan Data Gejala Penyakit</title>
<link href="../images/favicon.png" rel="shortcut icon" />
<link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
</head>
<body>
<div align="left" style="background-color:#CCCC99; width:650;"><b>Nama Penyakit : 
  </b>
</div>
<br>
<div class="CSSTableGenerator">
<table width="650" border="0" align="left" cellpadding="2" cellspacing="1" bgcolor="#99CC99">
  <tr bgcolor="#CCCC99"> 
    <td colspan="3"><b>Daftar Gejala Per Penyakit</b> <br>
      <br></td>
  </tr>
  <tr bgcolor="#CCCC99"> 
    <td width="39" align="center"><b>No</b></td>
    <td width="84"><b>Kode</b></td>
    <td width="361"><b>Nama Gejala</b></td>
  </tr>
  <?php 
include "../koneksi.php";

// Mendapatkan nilai dari permintaan
$kdsakit = $_REQUEST['CmbPenyakit'];

// Menyiapkan dan menjalankan query
$sqlg = "SELECT gejala.* FROM gejala, relasi 
         WHERE gejala.kd_gejala = relasi.kd_gejala 
         AND relasi.kd_penyakit = ? 
         ORDER BY gejala.kd_gejala";
$stmt = $conn->prepare($sqlg);
$stmt->bind_param("s", $kdsakit);
$stmt->execute();
$result = $stmt->get_result();

// Menginisialisasi nomor
$no = 0;

// Menampilkan hasil query
while ($datag = $result->fetch_assoc()) {
    $no++;
    // Lakukan sesuatu dengan data $datag
    echo "Gejala $no: " . $datag['gejala'] . "<br>";
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>

  <tr bgcolor="#FFFFFF"> 
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $datag['kd_gejala']; ?></td>
    <td><?php echo $datag['gejala']; ?></td>
  </tr>
  <?php

  ?>
   <tr>
  <td colspan="3" bgcolor="#CCCC99"><div align="right"><a href="haladmin.php?top=LapGejala.php">Kembali</a></div> </td>
</tr>
</table>
</body>
</html>
