<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "beasiswa";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
// Inisialisasi Variabel
$nama = "";
$jenis = "";
$nik = "";
$tempatlahir = "";
$tanggallahir = "";
$alamat = "";
$namawali = "";
$pekerjaan = "";
$gaji = "";
$universitas = "";
$sukses = "";
$error = "";


// Edit ambil op
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// DELETE DATA
if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql        = "DELETE FROM beasiswa WHERE id = '$id'";
    $query      = mysqli_query($koneksi, $sql);
    if ($query) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}

// EDIT DATA
if ($op == 'edit') {
    $id             = $_GET['id'];
    $sql            = "SELECT * FROM beasiswa WHERE id = '$id'";
    $query          = mysqli_query($koneksi, $sql);
    $row            = mysqli_fetch_array($query);
    $nama           = $row['nama'];
    $jenis          = $row['jenis'];
    $nik            = $row['nik'];
    $tempatlahir    = $row['tempatlahir'];
    $tanggallahir   = $row['tanggallahir'];
    $alamat         = $row['alamat'];
    $namawali       = $row['namawali'];
    $pekerjaan      = $row['pekerjaan'];
    $gaji           = $row['gaji'];
    $universitas    = $row['universitas'];

    if ($nik == '') {
        $error = "Data tidak ditemukan";
    }
}

// INSERT DATA
if (isset($_POST['simpan'])) { //untuk create
    $nama           = $_POST['nama'];
    $jenis          = $_POST['jenis'];
    $nik            = $_POST['nik'];
    $tempatlahir    = $_POST['tempatlahir'];
    $tanggallahir   = $_POST['tanggallahir'];
    $alamat         = $_POST['alamat'];
    $namawali       = $_POST['namawali'];
    $pekerjaan      = $_POST['pekerjaan'];
    $gaji           = $_POST['gaji'];
    $universitas    = $_POST['universitas'];

    if ($nama && $jenis && $nik && $tempatlahir && $tanggallahir && $alamat && $namawali && $pekerjaan && $gaji && $universitas) {
        // UPDATE DATA
        if ($op == 'edit') {
            $sql        = "UPDATE beasiswa SET nama = '$nama', jenis='$jenis', nik = '$nik', tempatlahir='$tempatlahir', tanggallahir = '$tanggallahir', alamat='$alamat', namawali='$namawali', pekerjaan='$pekerjaan', gaji= '$gaji', universitas= '$universitas' WHERE id = '$id'";
            $query         = mysqli_query($koneksi, $sql);
            if ($query) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
            // INSERT DATA
        } else {
            // Pengecekan NIK
            $cek_nik   = "SELECT * FROM beasiswa WHERE nik = '$nik'";
            $result    = mysqli_query($koneksi, $cek_nik);
            $row_count = mysqli_num_rows($result);
            if ($row_count > 0) {
                // Jika NIK sudah ada, error
                $error = "NIK sudah terdaftar. Silakan gunakan NIK yang berbeda.";
            } else {
                // Jika NIK belum terdaftar, insert data
                $sql       = "INSERT INTO beasiswa (nama, jenis, nik, tempatlahir, tanggallahir, alamat, namawali, pekerjaan, gaji, universitas) VALUES ('$nama','$jenis','$nik','$tempatlahir','$tanggallahir','$alamat','$namawali','$pekerjaan','$gaji','$universitas')";
                $query     = mysqli_query($koneksi, $sql);
                if ($query) {
                    $sukses = "Berhasil memasukkan data baru";
                } else {
                    $error  = "Gagal memasukkan data";
                }
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        body {
            background-image: url('education.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="container px-2 py-1">
        <!-- Header-->
        <header class="bg-dark py-3 rounded">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h2 class="display-5 fw-bold">Hi! Selamat datang di Fia Beasiswa
                        !</h2>
                    <p class="lead fw-normal text-white-50 mb-0">Semoga kamu menjadi salah satu bagian dari kami</p>
                </div>
            </div>
        </header>

        <div class="card">
            <div class="card-header text-white bg-info">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php if ($error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php header("refresh:5;url=index.php");
                } //5 : detik
                ?>

                <?php if ($sukses) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php header("refresh:5;url=index.php");
                } //5 : detik
                ?>

                <form action="" method="POST">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pendaftar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis" id="jenis">
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="Perempuan" <?php if ($jenis == "Perempuan") echo "selected" ?>>Perempuan</option>
                                <option value="Laki-Laki" <?php if ($jenis == "Laki-Laki") echo "selected" ?>>Laki-Laki</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="<?php echo $tempatlahir ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" value="<?php echo $tanggallahir ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Orang Tua</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="namawali" name="namawali" value="<?php echo $namawali ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Pekerjaan Orang Tua</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?php echo $pekerjaan ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis" class="col-sm-2 col-form-label">Gaji</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="gaji" id="gaji">
                                <option value="">- Pilih Gaji Orang Tua -</option>
                                <option value="< Rp 5.000.000" <?php if ($jenis == "< Rp 5.000.000") echo "selected" ?>>
                                    < Rp 5.000.000</option>
                                <option value="> Rp 5.000.000" <?php if ($jenis == "> Rp 5.000.000") echo "selected" ?>>> Rp 5.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Universitas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="universitas" name="universitas" value="<?php echo $universitas ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" name="simpan" value="Simpan Data">Simpan Data</button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header text-white bg-secondary">
                Data Pendaftar Beasiswa
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-responsive">
                    <thead class="table-dark text-center align-middle">
                        <tr>
                            <th class="col">#</th>
                            <th class="col">Nama Pendaftar</th>
                            <th class="col">Jenis Kelamin</th>
                            <th class="col">NIK</th>
                            <th class="col">Tempat Lahir</th>
                            <th class="col">Tanggal Lahir</th>
                            <th class="col">Alamat Lengkap</th>
                            <th class="col">Nama Orang Tua</th>
                            <th class="col">Pekerjaan Orang Tua</th>
                            <th class="col">Gaji</th>
                            <th class="col">Universitas</th>
                            <th class="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "SELECT * FROM beasiswa ORDER BY id DESC";
                        $query2 = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($row2 = mysqli_fetch_array($query2)) {
                            $id             = $row2['id'];
                            $nama           = $row2['nama'];
                            $jenis          = $row2['jenis'];
                            $nik            = $row2['nik'];
                            $tempatlahir    = $row2['tempatlahir'];
                            $tanggallahir   = $row2['tanggallahir'];
                            $alamat         = $row2['alamat'];
                            $namawali       = $row2['namawali'];
                            $pekerjaan      = $row2['pekerjaan'];
                            $gaji           = $row2['gaji'];
                            $universitas    = $row2['universitas'];
                        ?>
                            <tr>
                                <th class="col"><?php echo $urut++ ?></th>
                                <td class="col"><?php echo $nama ?></td>
                                <td class="col"><?php echo $jenis ?></td>
                                <td class="col"><?php echo $nik ?></td>
                                <td class="col"><?php echo $tempatlahir ?></td>
                                <td class="col"><?php echo $tanggallahir ?></td>
                                <td class="col"><?php echo $alamat ?></td>
                                <td class="col"><?php echo $namawali ?></td>
                                <td class="col"><?php echo $pekerjaan ?></td>
                                <td class="col"><?php echo $gaji ?></td>
                                <td class="col"><?php echo $universitas ?></td>
                                <td class="col-3 text-center">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</body>

</html>