<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Proses Diagnosa</title>
<style type="text/css">
    p {
        padding-left: 2px;
        text-indent: 0px;
    }
</style>
</head>
<body>
<div class="konten">
<?php
include "koneksi.php";
// kosongkan tabel tmp_penyakit
$kosong_tmp_penyakit = mysqli_query($koneksi, "DELETE FROM tmp_penyakit");
echo "<h3>Hasil Diagnosa</h3><hr>";
$sqlpenyakit = "SELECT * FROM relasi GROUP BY kd_penyakit ";
$querypenyakit = mysqli_query($koneksi, $sqlpenyakit);
$Similarity = 0;
echo "<div style='display:none;'>";
while ($rowpenyakit = mysqli_fetch_array($querypenyakit)) {
    // data penyakit di tabel relasi
    //echo $rowpenyakit['kd_penyakit']. "<br>";
    $kd_pen = $rowpenyakit['kd_penyakit'];
    //mengambil gejala di tabel relasi
    $query_gejala = mysqli_query($koneksi, "SELECT * FROM relasi WHERE kd_penyakit='$kd_pen'");
    $var1 = 0;
    $var2 = 0;
    $querySUM = mysqli_query($koneksi, "SELECT SUM(bobot) AS jumlahbobot FROM relasi WHERE kd_penyakit='$kd_pen'");
    $resSUM = mysqli_fetch_array($querySUM);
    echo $resSUM['jumlahbobot'] . "<br>";
    $SUMbobot = $resSUM['jumlahbobot'];
    while ($row_gejala = mysqli_fetch_array($query_gejala)) {
        // kode gejala di tabel relasi
        $kode_gejala_relasi = $row_gejala['kd_gejala'];
        $bobotRelasi = $row_gejala['bobot'];
        echo "bobot relasi=" . $bobotRelasi . "<br>";
        echo "<p>";
        // mencari data di tabel tmp_gejala dan membandingkannya
        $query_tmp_gejala = mysqli_query($koneksi, "SELECT * FROM tmp_gejala WHERE kd_gejala='$kode_gejala_relasi'");
        $row_tmp_gejala = mysqli_fetch_array($query_tmp_gejala);
        //$bobot_TMP=$row_tmp_gejala['bobot'];
        // Mengecek apakah ada data di tabel tmp_gejala
        $adadata = mysqli_num_rows($query_tmp_gejala);
        if ($adadata !== 0) {
            echo "Ada data<br>";
            //$bobotNilai=$bobotRelasi*1; echo "Nilai bobot hasil kali 1 = ".$bobotNilai;
            $bobotNilai = $bobotRelasi * 1;
            echo "Nilai bobot hasil kali 1 = " . $bobotNilai;
            $HasilKaliSatu;
            $var1 = $bobotNilai / $SUMbobot;
            echo "Nilai Jika 1=" . $var1;
        } else {
            echo "Tidak ada data<br>";
            $bobotNilai = $bobotRelasi * 0;
            //echo "Nilai = ".$bobotNilai;
            $var2 = $bobotNilai + $bobotNilai;
            echo "Nilai Jika 0=" . $var2;
        }
        $Nilai_tmp_gejala = $var1 + $var2;
        //echo "Nilai akhir".$Nilai_tmp_gejala;
        $Nilai_bawah = $Nilai_bawah + $bobotRelasi;
        $Nilai_Pembilang = $Nilai_tmp_gejala;
        $Nilai_Penyebut = $Nilai_bawah;
        // menghasilkan nilai Similarity dengan membagikan $Nilai_Pembilang/$Nilai_Penyebut
        $Similarity = $Nilai_Pembilang / $Nilai_Penyebut;
        // input data ke tabel tmp_penyakit
        echo "</p>";
    }
    $query_tmp_penyakit = mysqli_query($koneksi, "INSERT INTO tmp_penyakit(kd_penyakit,nilai) VALUES ('$kd_pen','$var1')");
    $nilaiMin = mysqli_query($koneksi, "SELECT kd_penyakit,MAX(nilai)  AS NilaiAkhir FROM tmp_penyakit GROUP BY nilai  ORDER BY nilai DESC ");
    $rowMin = mysqli_fetch_array($nilaiMin);
    $rendah = $rowMin['NilaiAkhir'];
    echo $rendah;
    //echo "Gejala yang paling dominan adalah : ". $rowMin['NilaiAkhir'];
    //echo "<h3>Hasil Diagnosa : </h3>";
    echo $rowMin['kd_penyakit'] . "<br>";
    $penyakitakhir = $rowMin['kd_penyakit'];
    echo "<input type='hidden' value='$rowMin[kd_penyakit]'>";
    $sql_pilih_penyakit = mysqli_query($koneksi, "SELECT * FROM penyakit_solusi WHERE kd_penyakit='$penyakitakhir'");
    $row_hasil = mysqli_fetch_array($sql_pilih_penyakit);
    $kd_penyakit = $row_hasil['kd_penyakit'];
    $penyakit = $row_hasil['nama_penyakit'];
    $keterangan_penyakit = $row_hasil['definisi'];
    $solusi = $row_hasil['solusi'];
}
echo "</div>";
?></div>
</body>
</html>

<table width="500" border="0" bgcolor="#0099FF" cellspacing="1" cellpadding="4" bordercolor="#0099FF">
  <tr bgcolor="#ffffff">
    <td height="32" style="color:#C60;"><strong>Identitas Anda :</strong><br /><br />
    <?php
    include "koneksi.php";
    $query_pasien = mysqli_query($koneksi, "SELECT * FROM tmp_pasien ORDER BY id DESC");
    $data_pasien = mysqli_fetch_array($query_pasien);
    echo "Nama : " . $data_pasien['nama'] . "<br>";
    echo "Jenis Kelamin : " . $data_pasien['kelamin'] . "<br>";
    echo "Umur : " . $data_pasien['umur'] . "<br>";
    echo "Alamat : " . $data_pasien['alamat'] . "<br>";
    echo "<label>Gejala yang diinputkan : </label><br>";
    $query_gejala_input = mysqli_query($koneksi, "SELECT gejala.gejala AS namagejala,tmp_gejala.kd_gejala FROM gejala,tmp_gejala WHERE tmp_gejala.kd_gejala=gejala.kd_gejala");
    $nogejala = 0;
    while ($row_gejala_input = mysqli_fetch_array($query_gejala_input)) {
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
//mencari persen
$query_nilai = mysqli_query($koneksi, "SELECT SUM(nilai) as nilaiSum FROM tmp_penyakit");
$rowSUM = mysqli_fetch_array($query_nilai);
$nilaiTotal = $rowSUM['nilaiSum'];
//echo "Nilai Total ". $rowSUM['nilaiSum']. "<br>";
$query_sum_tmp = mysqli_query($koneksi, "SELECT * FROM tmp_penyakit WHERE NOT nilai='0' ORDER BY nilai DESC LIMIT 0,2");
while ($row_sumtmp = mysqli_fetch_array($query_sum_tmp)) {
    $nilai = $row_sumtmp['nilai'];
    $nilai_persen = $nilai / $nilaiTotal * 100;
    $data_persen = $nilai_persen;
    $persen = substr($data_persen, 0, 5);
    //echo "Nilai persen : ".$persen. "%<br>";
    $kd_pen2 = $row_sumtmp['kd_penyakit'];
    //echo $kd_pen2 ."<br>";
    //echo $kd_pen2. "<br>";
    $query_penyasol = mysqli_query($koneksi, "SELECT * FROM penyakit_solusi WHERE kd_penyakit='$kd_pen2'");
    while ($row_penyasol = mysqli_fetch_array($query_penyasol)) {
        // jika hasil diagnosa 100%
        if ($persen == 100 || $persen >= 70) {
            echo "<strong>Anda Menderita Penyakit " . $row_penyasol['nama_penyakit'] . "</strong><br>";
            echo "<p>" . $row_penyasol['definisi'] . "</p>";
            echo "<p>" . "<strong>Solusi Pengobatan :</strong> " . $row_penyasol['solusi'] . "</p><hr>";
            // simpan hasil
            $query_temp = mysqli_query($koneksi, "SELECT * FROM tmp_pasien ORDER BY id DESC") or die(mysqli_error($koneksi));
            $row_pasien = mysqli_fetch_array($query_temp) or die(mysqli_error($koneksi));
            $nama = $row_pasien['nama'];
            $kelamin = $row_pasien['kelamin'];
            $umur = $row_pasien['umur'];
            $alamat = $row_pasien['alamat'];
            $tanggal = $row_pasien['tanggal'];
            //echo $nama ."<br>";
            //$query_tmp_hasil=mysql_query("");
            $kode_penyakit = $row_sumtmp['kd_penyakit'];
            echo $kode_penyakit . "100%";
            $query_hasil = "INSERT INTO analisa_hasil(nama,kelamin,umur,alamat,kd_penyakit,tanggal) VALUES ('$nama','$kelamin','$umur','$alamat','$kode_penyakit','$tanggal')";
            $res_hasil = mysqli_query($koneksi, $query_hasil) or die(mysqli_error($koneksi));
            if ($res_hasil) {
                echo "";
            } else {
                echo "<font color='#FF0000'>Data tidak dapat disimpan..!</font><br>";
            }
            //#end simpan
        } else {
            echo "<strong>Anda Menderita Penyakit " . $row_penyasol['nama_penyakit'] . " Sebesar " . $persen . "%" . "</strong><br>";
            echo "<p>" . $row_penyasol['definisi'] . "</p>";
            echo "<p>" . "<strong>Solusi Pengobatan :</strong> " . $row_penyasol['solusi'] . "</p><hr>";
            // simpan data
            $query_temp = mysqli_query($koneksi, "SELECT * FROM tmp_pasien ORDER BY id DESC") or die(mysqli_error($koneksi));
            $row_pasien = mysqli_fetch_array($query_temp) or die(mysqli_error($koneksi));
            $nama = $row_pasien['nama'];
            $kelamin = $row_pasien['kelamin'];
            $umur = $row_pasien['umur'];
            $alamat = $row_pasien['alamat'];
            $tanggal = $row_pasien['tanggal'];
            $query_hasil2 = "INSERT INTO analisa_hasil(nama,kelamin,umur,alamat,kd_penyakit,tanggal) VALUES ('$nama','$kelamin','$umur','$alamat','$kd_pen2','$tanggal')";
            $res_hasil2 = mysqli_query($koneksi, $query_hasil2) or die(mysqli_error($koneksi));
            if ($res_hasil2) {
                echo "";
            } else {
                echo "<font color='#FF0000'>Data tidak dapat disimpan..!</font><br>";
            }
        }
    }
}
?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>&nbsp;</strong><br />
    </td>
  </tr>
</table>
<br />
<br />
<a href="index.php?top=konsultasiFm.php">Diagnosa Kembali</a><br />
<a href="index.php?top=PasienAddFm.php">Kembali</a>
</div>
</body>
</html>


