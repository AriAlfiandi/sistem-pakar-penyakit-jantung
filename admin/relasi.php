<html>
<head>
<style type="text/css">
p {text-indent:0pt;}
</style>
<script type="text/javascript">
function konfirmasi(id_relasi){
	var kd_hapus=id_relasi;
	var url_str;
	url_str="hapus_relasi.php?id_relasi="+kd_hapus;
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
<h2>Data Relasi </h2><hr>
<div class="konten">
<?php
include "../koneksi.php";
?>
<form id="form1" name="form1" method="post" action="relasisim.php" enctype="multipart/form-data">
  <div>
    <table class="tab" width="528" border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#F0F0F0" bgcolor="#CCCC99">
      <tr bgcolor="#FFFFFF">
        <td>Kode</td>
        <td>
          <label>
            <select name="TxtKdPenyakit" id="TxtKdPenyakit">
              <option value="NULL">[ Daftar Penyakit ]</option>
              <?php 
              $sqlp = "SELECT * FROM penyakit_solusi ORDER BY kd_penyakit";
              $result = $conn->query($sqlp);
              if ($result === false) {
                die("SQL Error: " . $conn->error);
              }
              while ($datap = $result->fetch_assoc()) {
                $cek = ($datap['kd_penyakit'] == $kdsakit) ? "selected" : "";
                echo "<option value='{$datap['kd_penyakit']}' $cek>{$datap['kd_penyakit']}&nbsp;|&nbsp;{$datap['nama_penyakit']}</option>";
              }
              ?>
            </select>
          </label>
        </td>
      </tr>
      <!-- Add other form fields here -->
    </table>
  </div>
</form>

        </select>
        </label></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td width="124">Gejala</td>
        <td width="224">
          <select name="TxtKdGejala" id="TxtKdGejala">
            <option value="NULL">[ Daftar Gejala]</option>
			<?php 
include "../koneksi.php"; // Menghubungkan ke database

$sqlp = "SELECT * FROM gejala ORDER BY kd_gejala";
$result = $conn->query($sqlp);

if ($result === false) {
    die("SQL Error: " . $conn->error);
}

while ($datag = $result->fetch_assoc()) {
    $selected = ($datag['kd_gejala'] == $kdgejala) ? "selected" : "";
    echo "<option value='".htmlspecialchars($datag['kd_gejala'])."' $selected>".htmlspecialchars($datag['kd_gejala'])."&nbsp;|&nbsp;".htmlspecialchars($datag['gejala'])."</option>";
}

$conn->close(); // Menutup koneksi setelah selesai
?>

          </select>
         </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Bobot</td>
        <td><select name="txtbobot" id="txtbobot">
        <option value="0">[ Bobot Penyakit ]</option>
        <option value="5">5 | Gejala Dominan</option>
        <option value="3">3 | Gejala Sedang</option>
        <option value="1">1 | Gejala Biasa</option>
        </select></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Simpan" /></td>
      </tr>
    </table>
  </div>
</form>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bordercolor="#F0F0F0" >
  <tr>
    <td width="32"><strong>No</strong></td>
    <td width="105"><strong>Gejala</strong></td>
    <td width="535"><strong>Nama Penyakit</strong><span style="float:right; margin-right:25px;"><strong></strong></span></td>
    </tr>
	<?php
include "../koneksi.php"; // Menghubungkan ke database

$query = "SELECT relasi.kd_gejala, relasi.kd_penyakit, penyakit_solusi.kd_penyakit, penyakit_solusi.nama_penyakit AS penyakit 
          FROM relasi 
          JOIN penyakit_solusi ON penyakit_solusi.kd_penyakit = relasi.kd_penyakit 
          GROUP BY relasi.kd_penyakit";
$result = $conn->query($query);

if ($result === false) {
    die("SQL Error: " . $conn->error);
}

$no = 0;
while ($row = $result->fetch_assoc()) {
    $idpenyakit = $row['kd_penyakit'];
    $no++;
    // Anda bisa menambahkan HTML atau logika lain di sini
    // Contoh:
    echo "<p>$no. " . htmlspecialchars($row['penyakit']) . " (Kode Penyakit: " . htmlspecialchars($idpenyakit) . ")</p>";
}

$conn->close(); // Menutup koneksi setelah selesai
?>

  <tr bgcolor="#FFFFFF" bordercolor="#333333">
    <td valign="top"><?php echo $no;?></td>
    <td valign="top">
	<?php
include "../koneksi.php"; // Menghubungkan ke database

$idpenyakit = $_GET['idpenyakit']; // Pastikan variabel $idpenyakit terdefinisi

$query2 = "SELECT relasi.id_relasi, relasi.kd_gejala, relasi.bobot, relasi.kd_penyakit, gejala.gejala AS namagejala 
           FROM relasi 
           JOIN gejala ON gejala.kd_gejala = relasi.kd_gejala 
           WHERE relasi.kd_penyakit = ?";
$stmt = $conn->prepare($query2);
$stmt->bind_param("s", $idpenyakit);
$stmt->execute();
$result2 = $stmt->get_result();

while ($row2 = $result2->fetch_assoc()) {
    echo "<table width='600' border='0' cellpadding='4' cellspacing='1' bordercolor='#F0F0F0' bgcolor='#DBEAF5'>";
    echo "<tr bgcolor='#FFFFFF' bordercolor='#333333'>";
    echo "<td width='50'>" . htmlspecialchars($row2['kd_gejala']) . "</td>";
    echo "<td width='300'>" . htmlspecialchars($row2['namagejala']) . "</td>";
    echo "<td width='50'>" . htmlspecialchars($row2['bobot']) . "</td>";
    echo "<td width='20'><a title='Edit Relasi' href='haladmin.php?top=edit_relasi.php&id_relasi=" . htmlspecialchars($row2['id_relasi']) . "'>Edit</a></td>";
    echo "<td width='20'><a title='Hapus Relasi' style='cursor:pointer;' onclick='return konfirmasi(" . htmlspecialchars($row2['id_relasi']) . ")'>Hapus</a></td>";
    echo "</tr>";
    echo "</table>";
}

$stmt->close();
$conn->close(); // Menutup koneksi setelah selesai
?>
      <br /></td>
    <td><?php echo $row['kd_penyakit'];?>
      &nbsp;|&nbsp;<strong>
      <?php echo $row['penyakit'];?>
      </strong></td>
    </tr><?php  ?>
</table>

</div>
</body>
</html>