<?php
include "../koneksi.php"; // Pastikan koneksi menggunakan mysqli

$kdubah = $_GET['kdubah'];

if ($kdubah != "") {
    // Menampilkan data berdasarkan 'kdubah'
    $sql = "SELECT * FROM penyakit_solusi WHERE kd_penyakit = ?";
    
    // Mempersiapkan statement
    if ($stmt = $conn->prepare($sql)) {
        // Mengikat parameter
        $stmt->bind_param("s", $kdubah);
        
        // Menjalankan statement
        $stmt->execute();
        
        // Mengambil hasil
        $result = $stmt->get_result();
        
        // Memeriksa apakah ada data yang ditemukan
        if ($result->num_rows > 0) {
            // Mengambil data sebagai array asosiatif
            $data = $result->fetch_assoc();
            
            // Samakan dengan variabel form
            $in_id_penyakit = $data['kd_penyakit'];
            $in_penyakit = $data['nama_penyakit'];
            $in_definisi = $data['definisi'];
            $in_solusi = $data['solusi'];
        } else {
            echo "Tidak ada data yang ditemukan.";
        }
        
        // Menutup statement
        $stmt->close();
    } else {
        die("SQL ERROR: " . $conn->error);
    }
}

// Menutup koneksi
$conn->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Edit Penyakit</title>
<link href="file:/image/aq.jpg" rel='shortcut icon'>
<style>
<!--
body
{
background-image:url(file:/image/background.jpg);
background-repeat:no-repeat;
background-attachment:fixed;
}
</style> 
</head>
<body>          
<form id="form1" name="form1" method="post" action="edsimpenyakit.php">
<table width="509" border="0" align="center">
  <tr>
    <td height="22" colspan="3" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="39" colspan="3" valign="top"><div align="center">
      <div align="center"><span class="style38"><strong> Edit penyakit </strong></span></div></td>
    </tr>
  <tr>
    <td width="160" valign="top"><span class="style35">Kd Penyakit</span></td>
    <td width="9">&nbsp;</td>
    <td width="326" valign="top">
      <label>
      <input type="text" size="1" value="<?php echo $in_id_penyakit;?>" disabled="disabled">
        <input name="kd_penyakit" type="hidden" id="kd_penyakit" value="<?php echo $in_id_penyakit;?>">
        </label>    </td>
  </tr>
  <tr>
    <td valign="top">Penyakit</td>
    <td>&nbsp;</td>
    <td valign="top">
      <label>
        <textarea name="in_penyakit" id="in_penyakit" cols="45" rows="5"><?php echo $in_penyakit;?></textarea>
        </label>  </td>
  </tr>
  <tr>
    <td valign="top">Definisi</td>
    <td>&nbsp;</td>
    <td valign="top">
      <label>
        <textarea name="in_definisi" id="in_definisi" cols="45" rows="5"><?php echo $in_definisi;?></textarea>
        </label>  </td>
  </tr>
  <tr>
    <td valign="top">Solusi</td>
    <td>&nbsp;</td>
    <td valign="top">
      <label>
        <textarea name="in_solusi" id="in_solusi" cols="45" rows="5"><?php echo $in_solusi;?></textarea>
        </label>  </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top"><input type="submit" name="simpan" id="simpan" value="Update" />
     <a href="haladmin.php?top=penyakit_solusi.php"><input type="button" name="batal" id="batal" value="Batal" /></a></td>
      </a></td>
  </tr>
  <tr>
    <td valign="top"><span class="style36"></span></td>
    <td>&nbsp;</td>
    <td valign="top">
      <label></label>
      <label></label></td>
  </tr>
</table>
</form>
</body>
</html>