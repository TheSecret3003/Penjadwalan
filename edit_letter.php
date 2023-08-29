<?php
ob_start();
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';
require 'templates/dashboard/sidebar.php';

guardAuth();

// Fungsi untuk mengedit surat
function update($id, $letter)
{
    $file = $_FILES['image'];
    $name = $_POST['name'];
    $place = $_POST['place'];
    $origin = $_POST['origin'];
    $datetime = $_POST['datetime'];

    if (isEmpty([$name, $place, $origin,$datetime])) {
        return setFlash('error_edit', 'danger', 'Harap isi semua field');
    }

    $path = $letter['cover'];
    if ($file && $file['error'] == UPLOAD_ERR_OK) {
        $path = uploadImage($file);
        if (!$path) {
            return setFlash('error_edit', 'danger', 'Gagal menyimpan.');
        }
    }

    query("UPDATE `surat` SET nama_kegiatan='$name', tempat_kegiatan='$place', asal_surat='$origin', waktu_kegiatan='$datetime', gambar='$path' WHERE id='$id'");
    setFlash('alert', 'success', 'Data surat berhasil disimpan');
    header("location: view_letter.php");
}

$id = $_GET['id'];

$lt = query("SELECT id, nama_kegiatan, waktu_kegiatan, tempat_kegiatan, asal_surat, gambar FROM surat WHERE id='$id' LIMIT 1");
$letter = $lt->fetch_assoc();

if (isset($_POST['edit'])) {
    update($id, $letter);
}
?>

<!-- Tampilan form edit surat -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Form Edit Surat</h1>
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
            <?php if ($error = getFlash('error_edit')) : ?>
                <div class="alert alert-<?= $error['type']; ?> " role="alert">
                    <div><?= $error['message']; ?></div>
                </div>
            <?php endif; ?>
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nama Kegiatan</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="<?= $_POST['name'] ?? $letter['nama_kegiatan']; ?>"  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="datetime" class="col-md-4 col-form-label text-md-right">Waktu Kegiatan</label>

                    <div class="col-md-6">
                        <input id="datetime" type="datetime-local" class="form-control" name="datetime" value="<?= $_POST['datetime'] ?? $letter['waktu_kegiatan']; ?>"  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="place" class="col-md-4 col-form-label text-md-right">Tempat Kegiatan</label>

                    <div class="col-md-6">
                        <input id="place" type="text" class="form-control" name="place" value="<?= $_POST['place'] ?? $letter['tempat_kegiatan']; ?>"  autofocus>

                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="origin" class="col-md-4 col-form-label text-md-right">Asal Surat</label>

                    <div class="col-md-6">
                        <input id="origin" type="text" class="form-control" name="origin" value="<?= $_POST['origin'] ?? $letter['asal_surat']; ?>"  autofocus>

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

                    <div class="col-md-6 offset-md-4" style="margin-top:20px;">
                        <img src="<?= $letter['gambar'] ?>" alt="gambar" class="img-thumbnail d-block w-100" />
                    </div>
                </div>
                <button name="edit" class="btn btn-primary col-md-6 offset-md-5 w-25 fw-bold">Simpan</button>
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