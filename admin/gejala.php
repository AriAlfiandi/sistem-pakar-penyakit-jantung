<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
function validasi(form){
	if(form.kd_gejala.value==""){
		alert("Masukkan kode gejala..!");
		form.kd_gejala.focus(); return false;
		}else if(form.gejala.value==""){
		alert("Masukkan gejala..!");
		form.gejala.focus(); return false;	
		}
		form.submit();
	}
function konfirmasi(kd_gejala){
	var kd_hapus=kd_gejala;
	var url_str;
	url_str="hpsgejala.php?kdhapus="+kd_hapus;
	var r=confirm("Yakin ingin menghapus data..?"+kd_hapus);
	if (r==true){   
		window.location=url_str;
		}else{
			//alert("no");
			}
	}
</script>
</head>
<body>
<h2>Data Gejala-gejala</h2>
<form name="form3" onSubmit="return validasi(this);" method="post" action="simpangejala.php">
<table class="tab" width="477" border="0" align="center">
  <tr>
    <td colspan="3"><div align="center"></div></td>
  </tr>
  <tr>
    <td width="95">Kode gejala </td>
    <td width="8">:</td>
    <td width="224">
      <input name="kd_gejala" type="text" id="kd_gejala" size="4" maxlength="4">
    </td>
  </tr>
  <tr>
    <td> Gejala </td>
    <td>:</td>
    <td>
      <textarea name="gejala" rows="2" cols="40" id="gejala"></textarea>
    </td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
      <input name="simpan" type="submit" id="simpan" value="Simpan">
      <input type="reset" name="reset" value="Reset">
    </td>
  </tr>
</table>
</form>
<div class="CSSTableGenerator">          
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr bgcolor="#CCCC99" align="center">
    <td width="85"><strong>Kode Gejala</strong></td>
    <td width="505"><strong>Gejala</strong></td>
    <td width="50"><strong>Edit</strong></td>
    <td width="50"><strong>Hapus</strong></td>
  </tr>
  <tr>
  <?php
include "../koneksi.php"; // Pastikan koneksi menggunakan mysqli

$kd_penyakit = $_POST['kd_penyakit'];
$penyakit = $_POST['in_penyakit'];
$definisi = $_POST['in_definisi'];
$solusi = $_POST['in_solusi'];

$sql = "UPDATE penyakit_solusi SET nama_penyakit = ?, definisi = ?, solusi = ? WHERE kd_penyakit = ?";
$stmt = $conn->prepare($sql);

// Mengikat parameter ke dalam statement SQL
$stmt->bind_param("sssi", $penyakit, $definisi, $solusi, $kd_penyakit);

// Mengeksekusi pernyataan yang telah dipersiapkan
$stmt->execute();

// Menutup pernyataan yang telah dipersiapkan
$stmt->close();


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


  <tr>
    <td><?php echo $data['kd_gejala']; ?></td>
    <td><?php echo $data['gejala']; ?></td>
    <td><a title="Edit Penyakit" href="edgejala.php?kdubah=<?php echo $data['kd_gejala'];?>"><img src="image/edit.jpeg" width="16" height="16" border="0"></a></td>
    <td><a title="Hapus Gejala" style="cursor:pointer;" onclick="return konfirmasi('<?php echo $data['kd_gejala'];?>');"><img src="image/hapus.jpeg" width="16" height="16" ></a></td>
  </tr>
</table></div>
<p>&nbsp; </p>
</body>
</html>