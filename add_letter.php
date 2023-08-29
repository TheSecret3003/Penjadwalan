<?php
ob_start();
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';
require 'templates/dashboard/sidebar.php';

guardAuth();

// Fungsi untuk menambahkan surat
function add()
{
    $file = $_FILES['image'];
    $name = $_POST['name'];
    $place = $_POST['place'];
    $origin = $_POST['origin'];
    $datetime = $_POST['datetime'];

    if (isEmpty([$name, $place, $origin,$datetime])) {
        return setFlash('error_tambah', 'danger', 'Harap isi semua field');
    }
    $path = uploadImage($file);
    if (!$path) return setFlash('error_tambah', 'danger', 'Gagal menyimpan.');

    query("INSERT INTO `surat` VALUES (null, '$name', '$datetime', '$place', '$origin', '$path')");
    setFlash('alert', 'success', 'Data surat berhasil disimpan');
    header("location: view_letter.php");
}

if (isset($_POST['tambah'])) {
    add();
}
?>
<!-- Tampilan form untuk menambahkan surat -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Form Penambahan Surat</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Tambah Surat</h3>
            
            </div>
            <div class="card-body">
            <?php if ($error = getFlash('error_tambah')) : ?>
                <div class="alert alert-<?= $error['type']; ?> " role="alert">
                    <div><?= $error['message']; ?></div>
                </div>
            <?php endif; ?>
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nama Kegiatan</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value=""<?= $_POST['name'] ?? ''; ?>""  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="datetime" class="col-md-4 col-form-label text-md-right">Waktu Kegiatan</label>

                    <div class="col-md-6">
                        <input id="datetime" type="datetime-local" class="form-control" name="datetime" value=""<?= $_POST['datetime'] ?? ''; ?>""  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="place" class="col-md-4 col-form-label text-md-right">Tempat Kegiatan</label>

                    <div class="col-md-6">
                        <input id="place" type="text" class="form-control" name="place" value=""<?= $_POST['place'] ?? ''; ?>""  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="origin" class="col-md-4 col-form-label text-md-right">Asal Surat</label>

                    <div class="col-md-6">
                        <input id="origin" type="text" class="form-control" name="origin" value=""<?= $_POST['origin'] ?? ''; ?>""  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="image" class="col-md-4 col-form-label text-md-right">Gambar</label>

                  <div class="col-md-6">
                      <input id="image" type="file" class="form-control" name="image" autocomplete="image" autofocus>
        
                          <span class="invalid-feedback" role="alert">
                              <strong></strong>
                          </span>
                
                  </div>
                </div>
                <button name="tambah" class="btn btn-primary col-md-6 offset-md-5 w-25 fw-bold">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
require 'mysql-footer.php';
require 'templates/dashboard/footer.php';
?>