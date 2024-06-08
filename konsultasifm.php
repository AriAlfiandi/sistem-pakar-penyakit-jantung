<?php 
include "koneksi.php";
$NOIP = $_SERVER['REMOTE_ADDR'];
# Periksa apabila sudah ditemukan
$sql_cekh = "SELECT * FROM tmp_penyakit 
             WHERE noip='$NOIP' 
             GROUP BY kd_penyakit";
$qry_cekh = mysqli_query($koneksi, $sql_cekh);
$hsl_cekh = mysqli_num_rows($qry_cekh);
if ($hsl_cekh == 1) {
    $hsl_data = mysqli_fetch_array($qry_cekh);
    $sql_pasien = "SELECT * FROM tmp_pasien WHERE noip='$NOIP' ORDER BY id";
    $qry_pasien = mysqli_query($koneksi, $sql_pasien);
    $hsl_pasien = mysqli_fetch_array($qry_pasien);
        $sql_in = "INSERT INTO analisa_hasil SET
                  nama='{$hsl_pasien['nama']}',
                  kelamin='{$hsl_pasien['kelamin']}',
                  umur='{$hsl_pasien['umur']}',
                  alamat='{$hsl_pasien['alamat']}',
                  kd_penyakit='{$hsl_data['kd_penyakit']}',
                  noip='{$hsl_pasien['noip']}',
                  tanggal='{$hsl_pasien['tanggal']}'";
        mysqli_query($koneksi, $sql_in);              
    echo "<meta http-equiv='refresh' content='0; url=?top=AnalisaHasil.php'>";
    exit;
}
$sqlcek = "SELECT * FROM tmp_analisa WHERE noip='$NOIP'";
$qrycek = mysqli_query($koneksi, $sqlcek);
$datacek= mysqli_num_rows($qrycek);
if ($datacek >= 1) {
    // Seandainya tmp kosong
    $sqlg = "SELECT gejala.* FROM gejala,tmp_analisa 
             WHERE gejala.kd_gejala=tmp_analisa.kd_gejala 
             AND tmp_analisa.noip='$NOIP' 
             AND NOT tmp_analisa.kd_gejala 
                 IN(SELECT kd_gejala 
                 FROM tmp_gejala WHERE noip='$NOIP')
             ORDER BY gejala.kd_gejala LIMIT 1";
    $qryg = mysqli_query($koneksi, $sqlg) or die ("Gagal $qryg : ".mysqli_error($koneksi));
    $datag = mysqli_fetch_array($qryg) or die ("Gagal datag : ".mysqli_error($koneksi));
    $kdgejala = $datag['kd_gejala'];
    $gejala   = $datag['gejala'];
    echo " ADA BOS ($sqlg)";   
}
else {
    // Seandainya tmp kosong
    $sqlg = "SELECT * FROM gejala ORDER BY kd_gejala LIMIT 1";
    $qryg = mysqli_query($koneksi, $sqlg);
    $datag = mysqli_fetch_array($qryg);
    $kdgejala = $datag['kd_gejala'];
    $gejala   = $datag['gejala'];
}
?>
<html>
<head>
<title>Form Utama Penelusuran</title>
<script type="text/javascript" src="jquery-1.2.6.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("form").submit(function() {
        if (!isCheckedById("gejala")) {
            alert ("Anda Belum Memilih Gejala Apapun\nSilahkan Pilih Gejala..!");
            return false;
        } else {
            return true; //submit the form
        }
    });

    function isCheckedById(id) {
        var checked = $("input[id="+id+"]:checked").length;
        if (checked == 0) {
            return false;
        } else {
            return true;
        }
    }
});
</script>
<style type="text/css">
ul {list-style:none;}
li {line-height:-6px; font-weight:normal; color:#09F;}
</style>
</head>
<body>
<div class="konten">
    <form  method="post" name="form" target="_self" action="?top=konsulperiksa.php">
        <table width="700" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#FFFFFF">
            <tr>
                <td colspan="2">
                    <div align="center"><strong>Pilih Gejala Yang Dialami</strong></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Form Konsultasi :</strong></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="504">
                    <?php
                    include "koneksi.php";
                    $query=mysqli_query($koneksi, "SELECT * FROM gejala") or die("Query Error..!" );
                    while ($row=mysqli_fetch_array($query)){
                    ?>
                        <li><input type="checkbox" name="gejala[]" id="gejala" value="<?php echo $row['kd_gejala'];?>"><?php echo $row['gejala'];?></li>
                    <?php } ?>
                </td>
            </tr>
            <?php
            for ($i = 1; $i <= 21; $i++) {
                if (isset($_POST['gejala'.$i])) echo $_POST['gejala'.$i]."<br />";
            }
            ?>
            <tr>
                <td width="504" align="right" bgcolor="#FFFFFF">
                    <input type="submit" name="Submit" value="Proses Diagnosa">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>

