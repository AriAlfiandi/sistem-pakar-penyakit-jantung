<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Edit Data Gejala</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<link href="../Image/icon.png" rel='shortcut icon'>
<script type="text/javascript">
function validasi(form){
	if(form.gejala.value==""){
		alert("Masukkan Gejala..!");
		form.gejala.focus(); return false;
		}
	form.submit();
	}
</script>
</head>
<body>
<?php
// Menghubungkan dengan database
include "../koneksi.php";

// Baca variabel URL
$kdubah = $_REQUEST['kdubah'];

// Memeriksa apakah ada parameter 'kdubah'
if ($kdubah != "") {
    // Menampilkan data berdasarkan 'kdubah'
    $sql = "SELECT * FROM gejala WHERE kd_gejala = ?";
    
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
            $kd_gejala = $data['kd_gejala'];
            $gejala = $data['gejala'];
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

<form id="form1" name="form1" onSubmit="return validasi(this);" method="post" action="edsimgejala.php" target="_self">
<table style="border:1px solid #CCC; margin-top:150px;" width="509" border="0" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td height="22" colspan="3" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="39" colspan="3" valign="top"><div align="center"><span class="style38"><strong>Edit Gejala </strong></span></div></td>
    </tr>
  <tr>
    <td width="160" valign="top"><span class="style35">Kode Gejala</span></td>
    <td width="9">:</td>
    <td width="326" valign="top">
      <label>
      <input name="kd_gejala" type="text" id="kd_gejala" size="1" value="<?php echo $kd_gejala; ?>" disabled="disabled">
        <input name="kd_gejala2" type="hidden" id="kd_gejala2" value="<?php echo "$kd_gejala"; ?>">
        </label>    </td>
  </tr>
  <tr valign="top">
    <td valign="top">Gejala</td>
    <td>:</td>
    <td valign="top">
      <label>
        <textarea name="gejala" id="gejala" cols="45" rows="5"><?php echo "$gejala"; ?></textarea>
        </label>    </td>
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
      <a href="haladmin.php?top=gejala.php"><input type="button" name="batal" id="batal" value="Batal" /></a></td>
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
