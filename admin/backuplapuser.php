<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proses Diagnosa</title>
<style type="text/css">
p{ padding-left:2px; text-indent:0px;}
</style>
</head>

<body>
<div class="konten">
<?php
include "koneksi.php";

// Kosongkan tabel tmp_penyakit
$kosong_tmp_penyakit = $conn->query("DELETE FROM tmp_penyakit");
if (!$kosong_tmp_penyakit) {
    die("Error: " . $conn->error);
}

echo "<h3>Hasil Diagnosa</h3><hr>";

$sqlpenyakit = "SELECT * FROM relasi GROUP BY kd_penyakit";
$querypenyakit = $conn->query($sqlpenyakit);
if (!$querypenyakit) {
    die("Error: " . $conn->error);
}

$Similarity = 0;
echo "<div style='display:none;'>";

while ($rowpenyakit = $querypenyakit->fetch_assoc()) {
    $kd_pen = $rowpenyakit['kd_penyakit'];
    
    $query_gejala = $conn->query("SELECT * FROM relasi WHERE kd_penyakit='$kd_pen'");
    $var1 = 0; $var2 = 0;
    $querySUM = $conn->query("SELECT SUM(bobot) AS jumlahbobot FROM relasi WHERE kd_penyakit='$kd_pen'");
    $resSUM = $querySUM->fetch_assoc();
    echo $resSUM['jumlahbobot'] . "<br>";
    $SUMbobot = $resSUM['jumlahbobot'];
    
    while ($row_gejala = $query_gejala->fetch_assoc()) {
        $kode_gejala_relasi = $row_gejala['kd_gejala'];
        $bobotRelasi = $row_gejala['bobot'];
        echo "bobot relasi=" . $bobotRelasi . "<br>";
        echo "<p>";
        
        $query_tmp_gejala = $conn->query("SELECT * FROM tmp_gejala WHERE kd_gejala='$kode_gejala_relasi'");
        $row_tmp_gejala = $query_tmp_gejala->fetch_assoc();
        $adadata = $query_tmp_gejala->num_rows;
        
        if ($adadata !== 0) {
            echo "Ada data<br>";
            $bobotNilai = $bobotRelasi * 1;
            echo "Nilai bobot hasil kali 1 = " . $bobotNilai;
            $var1 = $bobotNilai / $SUMbobot;
            echo "Nilai Jika 1=" . $var1;
        } else {
            echo "Tidak ada data<br>";
            $bobotNilai = $bobotRelasi * 0;
            $var2 = $bobotNilai + $bobotNilai;
            echo "Nilai Jika 0=" . $var2;
        }
        
        $Nilai_tmp_gejala = $var1 + $var2;
        $Nilai_bawah = $Nilai_bawah + $bobotRelasi;
        $Nilai_Pembilang = $Nilai_tmp_gejala;
        $Nilai_Penyebut = $Nilai_bawah;
        $Similarity = $Nilai_Pembilang / $Nilai_Penyebut;
        
        echo "</p>";
    }
    
    $query_tmp_penyakit = $conn->query("INSERT INTO tmp_penyakit(kd_penyakit, nilai) VALUES ('$kd_pen', '$var1')");
    if (!$query_tmp_penyakit) {
        die("Error: " . $conn->error);
    }
}

$nilaiMin = $conn->query("SELECT kd_penyakit, MAX(nilai) AS NilaiAkhir FROM tmp_penyakit GROUP BY nilai ORDER BY nilai DESC");
$rowMin = $nilaiMin->fetch_assoc();
$rendah = $rowMin['NilaiAkhir'];
echo $rendah;
echo $rowMin['kd_penyakit'] . "<br>";
$penyakitakhir = $rowMin['kd_penyakit'];
echo "<input type='hidden' value='$rowMin[kd_penyakit]'>";

$sql_pilih_penyakit = $conn->query("SELECT * FROM penyakit_solusi WHERE kd_penyakit='$penyakitakhir'");
$row_hasil = $sql_pilih_penyakit->fetch_assoc();

$kd_penyakit = $row_hasil['kd_penyakit'];
$penyakit = $row_hasil['nama_penyakit'];
$keterangan_penyakit = $row_hasil['definisi'];
$solusi = $row_hasil['solusi'];

echo "</div>";
echo "<h3>PROSES AKHIR DIAGNOSA</h3>";
?>
<table width="500" border="0" bgcolor="#0099FF" cellspacing="1" cellpadding="4" bordercolor="#0099FF">
    <tr bgcolor="#ffffff">
        <td height="32"><strong>Identitas Anda :</strong><br /><br />
        <?php
        $query_pasien = $conn->query("SELECT * FROM tmp_pasien");
        $data_pasien = $query_pasien->fetch_assoc();
        echo "Nama : " . $data_pasien['nama'] . "<br>";
        echo "Jenis Kelamin : " . $data_pasien['kelamin'] . "<br>";
        echo "Umur : " . $data_pasien['umur'] . "<br>";
        echo "Alamat : " . $data_pasien['alamat'] . "<br>";
        echo "<label>Gejala yang diinputkan : </label><br>";
        
        $query_gejala_input = $conn->query("SELECT gejala.gejala AS namagejala, tmp_gejala.kd_gejala FROM gejala, tmp_gejala WHERE tmp_gejala.kd_gejala=gejala.kd_gejala");
        $nogejala = 0;
        while ($row_gejala_input = $query_gejala_input->fetch_assoc()) {
            $nogejala++;
            echo $nogejala . "." . $row_gejala_input['namagejala'] . "<br>";
        }
        ?>
        <p></p>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td><strong>Hasil Diagnosa :</strong><br />
        <?php
        // Mencari persen
        $query_nilai = $conn->query("SELECT SUM(nilai) AS nilaiSum FROM tmp_penyakit");
        $rowSUM = $query_nilai->fetch_assoc();
        $nilaiTotal = $rowSUM['nilaiSum'];
        
        $query_sum_tmp = $conn->query("SELECT * FROM tmp_penyakit WHERE NOT nilai='0' ORDER BY nilai DESC LIMIT 0,2");
        while ($row_sumtmp = $query_sum_tmp->fetch_assoc()) {
            $nilai = $row_sumtmp['nilai'];
            $nilai_persen = $nilai / $nilaiTotal * 100;
            $data_persen = $nilai_persen;
            $persen = substr($data_persen, 0, 5);
            $kd_pen2 = $row_sumtmp['kd_penyakit'];
            $query_penyasol = $conn->query("SELECT * FROM penyakit_solusi WHERE kd_penyakit='$kd_pen2'");
            while ($row_penyasol = $query_penyasol->fetch_assoc()) {
                echo "<strong>Anda Menderita Penyakit " . $row_penyasol['nama_penyakit'] . " Sebesar " . $persen . "%</strong><br>";
                echo "<p>" . $row_penyasol['definisi'] . "</p>";
                echo "<p><strong>Solusi Pengobatan :</strong> " . $row_penyasol['solusi'] . "</p><hr>";
            }
        }
        
        // Proses simpan hasil diagnosa
        $query_temp = $conn->query("SELECT * FROM tmp_pasien");
        $row_pasien = $query_temp->fetch_assoc();
        $nama = $row_pasien['nama'];
        $kelamin = $row_pasien['kelamin'];
        $umur = $row_pasien['umur'];
        $alamat = $row_pasien['alamat'];
        $tanggal = $row_pasien['tanggal'];
        
        $query_hasil = "INSERT INTO analisa_hasil (nama, kelamin, umur, alamat, kd_penyakit, tanggal) VALUES ('$nama', '$kelamin', '$umur', '$alamat', '$kd_penyakit', '$tanggal')";
        $res_hasil = $conn->query($query_hasil);
        if (!$res_hasil) {
            echo "<font color='#FF0000'>Data tidak dapat disimpan..!</font><br>";
        }
        ?>
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td><strong>&nbsp;</strong><br />
        <?php
        // echo "<p>". $solusi ."</p>";
        ?>
        </td>
    </tr>
</table>

<?php
$conn->close();
?>

<br />
<br />
<a href="index.php?top=konsultasiFm.php">Diagnosa Kembali</a><br />
<a href="index.php?top=PasienAddFm.php">Kembali</a>
</div>
</body>
</html>

