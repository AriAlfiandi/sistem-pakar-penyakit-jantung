<?php 
//include "inc.connect/connect.php";
include "../koneksi.php";
//$kdsakit = $_REQUEST['kdsakit'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Halaman Untuk Relasi Gejala Penyakit</title>
</head>
<body>
<h2>Laporan Data Gejala Berdasarkan Penyakit</h2><hr>
<form name="form1" method="post" action="lapgejala2.php">
<div class="CSSTableGenerator">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="2">
<tr bgcolor="#CCCC99" align="center">
  <td colspan="2" align="center" ><b>TAMPILKAN GEJALA PER PENYAKIT </b></td>
  </tr>
<tr>
  <td width="204" align="right" ><b>Penyakit :</b></td>
  <td width="305" >
   <select name="CmbPenyakit">
    <option value="NULL">[ Daftar Penyakit ]</option>
	<?php
include "../koneksi.php";

// Query untuk mendapatkan daftar penyakit
$sqlp = "SELECT * FROM penyakit_solusi ORDER BY kd_penyakit";
$result = $conn->query($sqlp);

if ($result === false) {
    die("SQL Error: " . $conn->error);
}

// Loop melalui hasil query dan buat opsi dropdown
while ($datap = $result->fetch_assoc()) {
    $cek = ($datap['kd_penyakit'] == $kdsakit) ? "selected" : "";
    echo "<option value='{$datap['kd_penyakit']}' $cek>
          {$datap['nama_penyakit']} ({$datap['kd_penyakit']})</option>";
}

// Menutup koneksi
$conn->close();
?>

  </select></td>
</tr>
<tr > 
  <td align="center" >&nbsp;</td>
  <td ><input type="submit" name="Submit" value="Tampil"></td>
</tr>
</table></div>
</form>
</body>
</html>
